<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
        ]);

        Subscriber::firstOrCreate(
            ['email' => strtolower($validated['email'])],
            [
                'ip_address' => $request->ip(),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 1000),
                'subscribed_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'सब्सक्राइब करने के लिए धन्यवाद!',
        ]);
    }
}
