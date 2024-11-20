<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Profile',
            'list' => [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Profile', 'url' => url('/profile')]
            ]
        ];
        
        $activeMenu = 'profile';

        // Data user bisa berasal dari database
        $user = [
            'name' => 'Agung Nugroho, S.Tr Kom, M.T',
            'role' => 'Dosen',
            'nidn' => '123456',
            'email' => 'agung@example.com',
            'address' => 'Jl. Malang Raya',
            'phone' => '08123456789',
        ];

        return view('profile.index', compact('user'), ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request)
    {
        // Validasi dan update data profil
        $request->validate([
            'nidn' => 'required',
            'name' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // Simpan data ke database (mock)
        // User::find(auth()->id())->update($request->all());

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        // Validasi dan update password
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        // Update password (mock)
        // $user = User::find(auth()->id());
        // $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui.');
    }
}
