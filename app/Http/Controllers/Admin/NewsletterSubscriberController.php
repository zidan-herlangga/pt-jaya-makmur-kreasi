<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class NewsletterSubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|super-admin']);
    }

    public function index(Request $request): View
    {
        $query = NewsletterSubscriber::query();

        if ($request->filled('search')) {
            $query->where('email', 'like', "%{$request->search}%");
        }

        $subscribers = $query->latest()->paginate(20)->withQueryString();
        $stats = [
            'total' => NewsletterSubscriber::count(),
            'today' => NewsletterSubscriber::whereDate('created_at', today())->count(),
            'this_month' => NewsletterSubscriber::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
        ];

        return view('admin.newsletter-subscribers.index', compact('subscribers', 'stats'));
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['integer']]);
        NewsletterSubscriber::whereIn('id', $request->ids)->delete();
        $count = count($request->ids);
        return redirect()->back()->with('success', "$count subscriber berhasil dihapus.");
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();
        return redirect()->route('admin.newsletter-subscribers.index')
            ->with('success', 'Subscriber berhasil dihapus.');
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::latest()->get();
        $filename = 'subscribers-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($subscribers) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['No', 'Email', 'Tanggal Subscribe']);

            foreach ($subscribers as $i => $s) {
                fputcsv($handle, [
                    $i + 1,
                    $s->email,
                    $s->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
