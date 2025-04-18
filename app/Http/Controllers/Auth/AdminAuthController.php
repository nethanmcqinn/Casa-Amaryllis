<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showAdminRegistrationForm()
    {
        // Only allow admin registration if no admin exists
        if ($this->adminExists()) {
            return redirect('/')
                ->with('error', 'Admin registration is not available.');
        }

        return view('auth.admin-register');
    }

    public function registerAdmin(Request $request)
    {
        // Prevent admin registration if an admin already exists
        if ($this->adminExists()) {
            return redirect('/')
                ->with('error', 'Admin registration is not available.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Auth::login($user);

        return redirect('/admin/dashboard')
            ->with('success', 'Admin account created successfully.');
    }

    protected function adminExists()
    {
        return User::where('role', 'admin')->exists();
    }
}