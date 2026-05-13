<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInquiryRequest;
use App\Mail\InquiryNotification;
use App\Models\AdvertisingPoint;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function create(?AdvertisingPoint $product = null): View
    {
        return view('public.inquiry', compact('product'));
    }

    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['ip_address'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        if ($request->filled('website')) {
            $data['status'] = 'spam';
        }

        $inquiry = Inquiry::create($data);

        if (!$inquiry->isSpam()) {
            try {
                $adminEmail = setting('admin_email', config('mail.from.address'));
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new InquiryNotification($inquiry));
                }
            } catch (\Throwable $e) {
                logger()->error('Gagal kirim email notifikasi inquiry: ' . $e->getMessage());
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Terima kasih! Permintaan Anda telah kami terima.');
    }
}
