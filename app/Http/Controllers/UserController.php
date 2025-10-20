<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ✅ Toggle status aktif / nonaktif
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return redirect()->back()->with('success', 'Status user berhasil diperbarui');
    }
    public function editPassword($id)
    {
        $editUser = User::findOrFail($id);
        return view('dashboard.edit_password', compact('editUser'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('edit-user-password', $id)->with('password_success', 'Password berhasil diperbarui!');
    }
}
