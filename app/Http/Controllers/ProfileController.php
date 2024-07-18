<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($request->user()->id),
            ],
            // 'phone' => 'nullable|string|max:15',
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user's profile
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->phone = $request->phone;
        // Check if the current password is provided and is correct
        if ($request->current_password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Current password is incorrect'])
                    ->withInput();
            }

            // If new password is provided, update it
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
        }

        // If email has changed, reset email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the updated user
        $user->save();

        // Redirect back with success message
        return redirect()->route('user_settings', [
            'user' => $request->user(),
        ])->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
