<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvertisingPoint;
use App\Models\Inquiry;
use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|super-admin|editor']);
    }

    public function index(): View
    {
        $stats = [
            'total_points' => AdvertisingPoint::count(),
            'available_points' => AdvertisingPoint::available()->count(),
            'booked_points' => AdvertisingPoint::where('status', 'booked')->count(),
            'maintenance_points' => AdvertisingPoint::where('status', 'maintenance')->count(),
            'pending_inquiries' => Inquiry::pending()->notSpam()->count(),
            'total_posts' => Post::published()->count(),
            'total_users' => User::active()->count(),
        ];

        $recentInquiries = Inquiry::with('product')
            ->notSpam()
            ->latest()
            ->limit(5)
            ->get();

        $popularPoints = AdvertisingPoint::published()
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        $monthlyInquiries = Inquiry::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->notSpam()
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('admin.dashboard.index', compact(
            'stats',
            'recentInquiries',
            'popularPoints',
            'monthlyInquiries'
        ));
    }
}
