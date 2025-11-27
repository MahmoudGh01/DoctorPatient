<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', Rule::in(['patient', 'doctor', 'admin'])],
            'code' => ['nullable', 'string'], // will validate below
            'photo' => ['nullable', 'image', 'max:2048'],

        ]);


        // Validate code based on role
        if ($request->role === 'admin' && $request->code !== '007') {
            return back()->withErrors(['code' => 'Invalid admin code']);
        }

        if ($request->role === 'doctor' && $request->code !== '1234') { // example doctor code
            return back()->withErrors(['code' => 'Invalid doctor code']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->hasFile('photo')) {
            $user->addMediaFromRequest('photo')->toMediaCollection('profile');
        }
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }

}
