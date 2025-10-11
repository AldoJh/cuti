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
}
