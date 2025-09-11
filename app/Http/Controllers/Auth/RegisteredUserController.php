<?php

namespace App\Http\Controllers\Auth;

use App\Enum\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function associationRegister(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'licence' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'userType' => ['required', 'string'],
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('Files', $fileName, 'local');
        if ($request['uesrType'] == "association") {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'licence' => $validated['licence'],
                'phone' => $validated['phone'],
                'file' => $fileName,
            ])->assignRole(RolesEnum::Association);
            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('home');
        } else {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'licence' => "00000000",
                'phone' => $validated['phone'],
                'file' => $fileName,
            ])->assignRole(RolesEnum::Client);
            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('home');
        }
    }
    public function clientRegister(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string'],
            'userType' => ['required', 'string'],
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'image' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('Files', $fileName, 'local');
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('file')->storeAs('Files', $imageName, 'local');
        // if ($request['uesrType'] == "association") {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'licence' => $validated['licence'],
                'phone' => $validated['phone'],
                'file' => $fileName,
                'image' => $imageName,
            ])->assignRole(RolesEnum::Association);
            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('home');
        // } else {
        //     $user = User::create([
        //         'name' => $validated['name'],
        //         'email' => $validated['email'],
        //         'password' => Hash::make($validated['password']),
        //         'licence' => "00000000",
        //         'phone' => $validated['phone'],
        //         'file' => $fileName,
        //         'image' => $imageName,
        //     ])->assignRole(RolesEnum::Client);
        //     event(new Registered($user));
        //     Auth::login($user);
        //     return redirect()->route('home');
        // }
    }
}
