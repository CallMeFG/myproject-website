<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::orderBy('id', 'desc')->paginate(10); // Ambil semua kamar, urutkan, dan gunakan pagination
        return view('admin.rooms.index', compact('rooms')); // Kirim data ke view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create'); // Menampilkan view form tambah kamar
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data input
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|url|max:2048', // Validasi sebagai URL
            'quantity' => 'required|integer|min:0',
        ], [
            // Pesan error kustom (opsional, bisa disesuaikan)
            'type.required' => 'Tipe kamar wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'quantity.required' => 'Kuantitas wajib diisi.',
            'quantity.integer' => 'Kuantitas harus berupa angka bulat.',
            'image.url' => 'Format URL gambar tidak valid.',
        ]);

        // 2. Buat dan simpan kamar baru
        try {
            Room::create($validatedData); // Mass assignment karena kita sudah atur $fillable di model Room

            // 3. Redirect ke halaman daftar kamar dengan pesan sukses
            return redirect()->route('admin.rooms.index')
                ->with('success', 'Kamar baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangani jika ada error saat menyimpan ke database
            // \Log::error('Error saving room: ' . $e->getMessage()); // Opsional: log error
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan kamar. Silakan coba lagi.')
                ->withInput(); // Kembalikan dengan input lama
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room')); // Kirim data kamar ke view edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        // 1. Validasi data input
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|url|max:2048',
            'quantity' => 'required|integer|min:0',
        ], [
            // Pesan error kustom (opsional)
            'type.required' => 'Tipe kamar wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'quantity.required' => 'Kuantitas wajib diisi.',
            'quantity.integer' => 'Kuantitas harus berupa angka bulat.',
            'image.url' => 'Format URL gambar tidak valid.',
        ]);

        // 2. Update data kamar
        try {
            $room->update($validatedData); // Langsung update pada objek $room yang sudah ada

            // 3. Redirect ke halaman daftar kamar dengan pesan sukses
            return redirect()->route('admin.rooms.index')
                ->with('success', 'Data kamar berhasil diperbarui!');
        } catch (\Exception $e) {
            // \Log::error('Error updating room: ' . $e->getMessage()); // Opsional: log error
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui kamar. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete(); // Menghapus data kamar dari database

            // Redirect kembali ke halaman daftar kamar dengan pesan sukses
            return redirect()->route('admin.rooms.index')
                ->with('success', 'Kamar "' . $room->type . '" berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani jika ada error foreign key constraint (misalnya jika kamar masih terkait dengan reservasi)
            // \Log::error('Error deleting room: ' . $e->getMessage()); // Opsional: log error
            return redirect()->route('admin.rooms.index')
                ->with('error', 'Kamar "' . $room->type . '" tidak dapat dihapus karena mungkin masih terkait dengan data reservasi. Hapus dulu reservasi terkait atau hubungi administrator.');
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            // \Log::error('Error deleting room: ' . $e->getMessage()); // Opsional: log error
            return redirect()->route('admin.rooms.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kamar. Silakan coba lagi.');
        }
    }
}
