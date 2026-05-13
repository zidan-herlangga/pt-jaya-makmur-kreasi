<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $exists = NewsletterSubscriber::where('email', $data['email'])->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Email ini sudah terdaftar.',
            ], 422);
        }

        NewsletterSubscriber::create([
            'email' => $data['email'],
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Terima kasih! Anda telah berlangganan newsletter kami.',
        ]);
    }
}
