<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import Controller dasar
use App\Models\User;                 // Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   // Untuk mendapatkan user yang sedang login
use Illuminate\Validation\Rule; // Import Rule untuk validasi 'in'

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar pengguna dengan peran 'user'.
     */
    public function listUsers()
    {
        $users = User::where('role', 'user')
            ->orderBy('name', 'asc')
            ->paginate(15);
        return view('admin.users.index', ['users' => $users, 'roleTitle' => 'Pengguna Biasa']);
    }

    /**
     * Menampilkan daftar pengguna dengan peran 'staff'.
     */
    public function listStaff()
    {
        $users = User::where('role', 'staff') // Hanya ambil staff
            ->orderBy('name', 'asc')
            ->paginate(15);
        return view('admin.users.index', ['users' => $users, 'roleTitle' => 'Staff']);
        // Kita bisa menggunakan view yang sama (admin.users.index) untuk menampilkan keduanya,
        // hanya datanya saja yang berbeda.
    }

    /**
     * Menghapus pengguna (user atau staff) dari database.
     */
    public function destroy(User $user) // $user akan otomatis di-inject berdasarkan ID dari URL
    {
        // Pencegahan agar admin tidak bisa menghapus dirinya sendiri
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Pencegahan agar admin tidak bisa menghapus admin lain (jika ada lebih dari 1 admin)
        // Atau tambahkan logika lain jika perlu, misalnya hanya super admin yang bisa hapus admin lain
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun Admin lain melalui antarmuka ini.');
        }

        try {
            $userName = $user->name;
            $userRole = $user->role;
            $user->delete();

            // Redirect kembali ke halaman yang sesuai berdasarkan peran user yang dihapus
            $redirectRoute = ($userRole === 'staff') ? 'admin.staff.index' : 'admin.users.index';

            return redirect()->route($redirectRoute)
                ->with('success', 'Akun "' . $userName . '" (' . $userRole . ') berhasil dihapus.');
        } catch (\Exception $e) {
            // \Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus akun. Pengguna mungkin masih memiliki data terkait (misalnya reservasi).');
        }
    }
    /**
     * Menampilkan form untuk mengedit peran pengguna.
     */
    public function editRole(User $user)
    {
        // Admin tidak bisa mengubah peran dirinya sendiri atau admin lain melalui form ini
        if ($user->id === Auth::id() || $user->role === 'admin') {
            $redirectRoute = ($user->role === 'staff') ? 'admin.staff.index' : 'admin.users.index';
            if ($user->id === Auth::id()) {
                return redirect()->route($redirectRoute)->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri.');
            }
            return redirect()->route($redirectRoute)->with('error', 'Peran Admin tidak dapat diubah melalui antarmuka ini.');
        }

        $roles = ['user', 'staff']; // Peran yang bisa dipilih untuk diubah
        return view('admin.users.edit-role', compact('user', 'roles'));
    }

    /**
     * Memperbarui peran pengguna di database.
     */
    public function updateRole(Request $request, User $user)
    {
        // Admin tidak bisa mengubah peran dirinya sendiri atau admin lain
        if ($user->id === Auth::id() || $user->role === 'admin') {
            $redirectRoute = ($user->role === 'staff') ? 'admin.staff.index' : 'admin.users.index';
            if ($user->id === Auth::id()) {
                return redirect()->route($redirectRoute)->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri.');
            }
            return redirect()->route($redirectRoute)->with('error', 'Peran Admin tidak dapat diubah melalui antarmuka ini.');
        }

        $availableRoles = ['user', 'staff'];
        $validated = $request->validate([
            'role' => [
                'required',
                Rule::in($availableRoles), // Peran baru harus salah satu dari 'user' atau 'staff'
            ],
        ], [
            'role.required' => 'Peran baru wajib dipilih.',
            'role.in' => 'Pilihan peran tidak valid.',
        ]);

        try {
            $oldRole = $user->role;
            $user->role = $validated['role'];
            $user->save();

            // Tentukan ke halaman mana akan di-redirect setelah update
            // Jika peran lama adalah staff dan peran baru adalah user, redirect ke daftar user
            // Jika peran lama adalah user dan peran baru adalah staff, redirect ke daftar staff
            // Jika peran tidak berubah, redirect ke halaman asal (daftar user atau staff)
            $redirectToList = ($validated['role'] === 'staff') ? 'admin.staff.index' : 'admin.users.index';
            if ($oldRole === 'staff' && $validated['role'] === 'user') {
                $redirectToList = 'admin.users.index';
            } elseif ($oldRole === 'user' && $validated['role'] === 'staff') {
                $redirectToList = 'admin.staff.index';
            } else { // Jika peran sama, atau salah satu tidak terdefinisi, kembali ke daftar awal
                $redirectToList = ($oldRole === 'staff') ? 'admin.staff.index' : 'admin.users.index';
            }


            return redirect()->route($redirectToList)
                ->with('success', 'Peran untuk pengguna "' . $user->name . '" berhasil diperbarui menjadi "' . ucfirst($validated['role']) . '".');
        } catch (\Exception $e) {
            // \Log::error('Error updating user role: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui peran pengguna.')
                ->withInput();
        }
    }
}
