<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'password' => !empty($data['password']) ? Hash::make($data['password']) : $user->password,
        ]);

        return back()->with('success', 'Đã cập nhật hồ sơ.');
    }
}
