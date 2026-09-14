<?php

namespace App\Http\Controllers;

use App\Notifications\EmailChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', Password::defaults()],
        ]);

        $originalEmail = $user->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ?? $user->password,
        ]);

        // if the email was changed, send an EmailChanged notification.
        if ($originalEmail !== $request->email) {
            Notification::route('mail', $originalEmail)
                ->notify(new EmailChanged($user, $originalEmail));
        }

        return to_route('idea.index')->with('success', 'Your profile has been updated');
    }
}
