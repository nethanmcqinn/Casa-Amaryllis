<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        return view('admin.users.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
       DB::table('users')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting yourself
            if (auth()->id() == $user->id) {
                return back()->with('error', 'You cannot delete your own account!');
            }

            // Check if user has orders
            if ($user->orders()->count() > 0) {
                return back()->with('error', 'Cannot delete user with existing orders. Consider deactivating the account instead.');
            }

            $user->delete();
            return back()->with('success', 'User deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete user. ' . $e->getMessage());
        }
    }

    public function status_update(Request $request)
    {
      // dd($request->all());
        $user = User::find($request->id);
        $user->is_active = $request->status;
        $user->save();
        return redirect()->back()->with('success', 'User status updated successfully');
    }

    public function role_update (Request $request)
    {
        $user = User::find($request->id);
        $user->role = $request->role;
        $user->save();
        return redirect()->back()->with('success', 'User role updated successfully');
    }
}