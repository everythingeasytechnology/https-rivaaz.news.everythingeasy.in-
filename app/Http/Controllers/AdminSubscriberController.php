<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;

class AdminSubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::latest('subscribed_at')->paginate(25);

        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber removed successfully.');
    }
}
