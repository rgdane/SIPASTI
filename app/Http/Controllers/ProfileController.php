<?php

namespace App\Http\Controllers;

use App\Models\UserDetailModel;
use App\Models\UserModel;
use App\Models\UserTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

        // Mengambil ID user yang sedang login
        $id = auth()->id();

        // Data user bisa berasal dari database
        $profile = UserDetailModel::where('user_id', $id)->first();
        if (!$profile) {
            UserDetailModel::create([
                'user_id' => $id,
                'user_detail_nip' => '',
                'user_detail_nidn' => '',
                'user_detail_email' => '',
                'user_detail_phone' => '',
                'user_detail_address' => '',
                'user_detail_image' => 'image/default-profile.jpg',
            ]);

            $profile = UserDetailModel::where('user_id', $id)->first();
        }
        // Ambil user yang sedang login
        $user = auth()->user();
        $user_type = UserTypeModel::where('user_type_id', $user -> user_type_id)->first();;

        // Mengirim data ke view
        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'profile' => $profile, // Mengirim data profile user yang login
            'user' => $user, // Mengirim data user yang login
            'user_type' => $user_type, // Mengirim data user_type yang login
            'profile' => $profile
        ]);
    }

    public function update(Request $request)
    {
        $userId = auth()->id();

        // Periksa apakah request berasal dari AJAX atau membutuhkan JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'user_detail_nip' => 'required',
                'user_detail_nidn' => 'nullable', // Field opsional, gunakan 'nullable' agar validasi tidak gagal
                'user_detail_email' => 'required|email',
                'user_detail_phone' => 'required|numeric',
                'user_detail_address' => 'required',
                'username' => 'required|max:20|unique:m_user,username,' . $userId . ',user_id', // Validasi unik berdasarkan user_id
                'user_fullname' => 'required',
            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(), // Tampilkan error untuk field
                ]);
            }

            // Ambil model yang sesuai
            $userDetail = UserDetailModel::where('user_id', $userId)->first();
            $user = UserModel::find($userId);

            if (!$userDetail || !$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data pengguna tidak ditemukan.',
                ]);
            }

            // Update data user_detail
            $userDetail->update($request->only([
                'user_detail_nip',
                'user_detail_nidn',
                'user_detail_email',
                'user_detail_phone',
                'user_detail_address',
            ]));

            // Update data user
            $user->update($request->only([
                'username',
                'user_fullname',
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diperbarui.',
            ]);
        }

        // Handle request non-AJAX (redirect)
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }


    public function update_password(Request $request)
    {
        $user = UserModel::find(auth()->id());

        // Validasi dan update password
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // Respon JSON, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(), // Menunjukkan field mana yang error
                ]);
            }

            // Validasi apakah old_password cocok
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password lama tidak cocok.',
                ]);
            }

            // Jika validasi lolos, update password
            if ($user) {
                $user->update(['password' => Hash::make($request->new_password)]); // Hash password baru sebelum disimpan
                return response()->json([
                    'status' => true,
                    'message' => 'Password berhasil diperbarui.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.',
                ]);
            }
        }
        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui.');
    }

    public function update_image(Request $request)
    {
        // Validasi file gambar
        $request->validate([
            'user_detail_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Logika untuk menyimpan gambar dan mengembalikan URL
        if ($request->hasFile('user_detail_image')) {
            $file = $request->file('user_detail_image');

        // Buat nama file unik
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Tentukan lokasi penyimpanan
        $path = public_path('storage/image'); // Misalnya, Anda ingin menyimpan di folder public/uploads/images

        // Pindahkan file ke lokasi permanen
        $file->move($path, $filename);
        
        $userId = auth()->id();
        $userDetail = UserDetailModel::where('user_id', $userId)->first();
        $userDetail->user_detail_image = 'storage/image/' . $filename;
        $userDetail->save();
        // Simpan path file ke database atau lakukan hal lain yang diperlukan
        // Contoh: $user->update(['user_detail_image' => 'uploads/images/' . $filename]);

        return response()->json(['success' => true, 'image_url' => asset('storage/image/' . $filename)]);
            
            // Kembalikan URL gambar yang baru
        }

        return response()->json(['success' => false, 'message' => 'File tidak ditemukan.']);
    }
}
