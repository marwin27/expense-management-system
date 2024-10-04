<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showUsers()
    {
        $users = User::all();   
        return view('users', compact('users'));
    }


    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:User,Admin',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'role.required' => 'The role field is required.',
            'role.in' => 'The selected role is invalid.',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
        ]);
    
        return redirect()->route('users')->with('success', 'User Successfully Added');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'Admin') {
            return redirect()->route('users')->withErrors(['delete_error' => 'Cannot delete a administrator.']);
        }

        try {
            $user->delete();
            return redirect()->route('users')->with('success', 'User Successfully Deleted');
        } catch (\Exception $e) {
            return redirect()->route('users')->withErrors(['delete_error' => 'Failed to delete user.']);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:User,Admin', 
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'role.required' => 'The role field is required.',
            'role.in' => 'The selected role is invalid.',
        ]);
        if ($user->role === 'Admin' && $request->role === 'User') {
            return redirect()->route('users')->withErrors(['update_error' => 'Cannot change an administrator to user.']);
        }
    
        if ($user->role === 'User' && $request->role === 'Admin') {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'Admin', 
            ]);
    
            return redirect()->route('users')->with('success', 'User successfully changed to Admin.');
        }
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    
        return redirect()->route('users')->with('success', 'User successfully updated.');
    }
    public function changePassword(Request $request, $id)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::findOrFail($id);
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
    
        $user->password = bcrypt($validatedData['new_password']);
        $user->save();
    
        return redirect()->back()->with('success', 'Password changed successfully!');
    }
    
    
}
