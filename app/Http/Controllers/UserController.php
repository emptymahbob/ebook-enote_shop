<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function books()
    {
        $books = auth()->user()->userBooks()
            ->with(['book', 'order'])
            ->whereHas('order', function ($query) {
                $query->where('approval_status', 'approved');
            })
            ->latest('purchased_at')
            ->paginate(12);

        return view('user.books', compact('books'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($validated);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully');
    }
}
