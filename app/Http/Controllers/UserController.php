<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 
class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Menyimpan data pengguna baru
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:admin,direktur,manajer,pengelola,driver',
            ]);

            // Menyimpan pengguna baru
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User added successfully',
                'user' => $user
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request']);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'role' => 'required|in:admin,direktur,manajer,pengelola,driver',
            ]);

            $user = User::findOrFail($id);
            $user->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'user' => $user
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request']);
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
