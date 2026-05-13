<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|super-admin']);
    }

    public function index(Request $request): View
    {
        $query = Inquiry::with(['product', 'handler']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->notSpam();
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('sender_name', 'like', "%{$request->search}%")
                    ->orWhere('sender_email', 'like', "%{$request->search}%")
                    ->orWhere('company_name', 'like', "%{$request->search}%")
                    ->orWhere('message', 'like', "%{$request->search}%");
            });
        }

        $inquiries = $query->latest()->paginate(20)->withQueryString();
        $stats = [
            'total' => Inquiry::count(),
            'pending' => Inquiry::pending()->notSpam()->count(),
            'processed' => Inquiry::processed()->count(),
            'spam' => Inquiry::where('status', 'spam')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'stats'));
    }

    public function show(Inquiry $inquiry): View
    {
        $inquiry->load(['product', 'handler']);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $data = $request->validate([
            'admin_notes' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,processed,spam,archived'],
        ]);

        if ($data['status'] === 'processed' && $inquiry->status !== 'processed') {
            $data['handled_by'] = auth()->id();
            $data['handled_at'] = now();
        }

        $inquiry->update($data);

        return redirect()
            ->route('admin.inquiries.index')
            ->with('success', 'Inquiry berhasil diperbarui.');
    }

    public function markProcessed(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->markAsProcessed(auth()->id());

        return redirect()
            ->back()
            ->with('success', 'Inquiry ditandai sebagai diproses.');
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return redirect()
            ->route('admin.inquiries.index')
            ->with('success', 'Inquiry berhasil dihapus.');
    }
}
