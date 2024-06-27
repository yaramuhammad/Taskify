<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function updateEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);

        $request->user()->email = $data['email'];
        $request->user()->email_verified_at = null;
        $request->user()->save();
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);

    }

    public function updateImage(Request $request)
    {
        $imagePath = $request->file('image')->store('images', 'public');
        $request->user()->imagePath = $imagePath;
        $request->user()->save();

        return $request->user();
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate(
            [
                'password' => ['required', 'confirmed'],
            ]
        );
        $request->user()->password = Hash::make($data['password']);

        return response()->noContent();
    }
}
