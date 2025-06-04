<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
// Di bagian atas RoomManagementController.php
use Illuminate\Support\Facades\Storage;

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
        // 1. Validasi data input (termasuk file gambar)
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            // Validasi untuk file gambar:
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Boleh kosong, harus file gambar, format tertentu, maks 2MB
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // 'file' lebih umum jika 'image' bermasalah, tapi 'image' lebih spesifik untuk validasi tipe gambar
            'quantity' => 'required|integer|min:0',
        ], [
            'type.required' => 'Tipe kamar wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'quantity.required' => 'Kuantitas wajib diisi.',
            'quantity.integer' => 'Kuantitas harus berupa angka bulat.',
            'image.image' => 'File yang diupload harus berupa gambar.', // Pesan jika menggunakan validasi 'image'
            'image.file' => 'File yang diupload tidak valid.', // Pesan jika menggunakan validasi 'file'
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        // 2. Handle File Upload jika ada gambar yang diupload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Simpan file gambar ke disk 'public' di dalam folder 'room_images'
            // Nama file akan di-generate secara unik oleh Laravel untuk menghindari konflik
            $imagePath = $request->file('image')->store('room_images', 'public');
            $validatedData['image'] = $imagePath; // Simpan path file ke data yang akan disimpan
        } else {
            // Jika tidak ada file yang diupload atau file tidak valid, pastikan 'image' tidak ada di $validatedData
            // atau set ke null jika field di DB boleh null dan Anda ingin eksplisit.
            // Karena kita set 'nullable' di validasi, jika tidak ada file, 'image' tidak akan ada di $validatedData.
            // Jika Anda ingin menyimpan null secara eksplisit jika tidak ada gambar:
            $validatedData['image'] = null;
        }

        // 3. Buat dan simpan kamar baru
        try {
            Room::create($validatedData);

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Kamar baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Jika ada error saat menyimpan dan kita sudah upload gambar, idealnya gambar yang baru diupload dihapus.
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            \Log::error('Error saving room: ' . $e->getMessage()); // Log error
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan kamar. Silakan coba lagi.')
                ->withInput();
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
        // 1. Validasi data input (gambar sekarang boleh kosong saat update)
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Boleh kosong saat update
            'quantity' => 'required|integer|min:0',
        ], [
            'type.required' => 'Tipe kamar wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'quantity.required' => 'Kuantitas wajib diisi.',
            'quantity.integer' => 'Kuantitas harus berupa angka bulat.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        // 2. Handle File Upload jika ada gambar baru yang diupload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Hapus gambar lama dari storage jika ada dan jika bukan placeholder/URL eksternal
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }

            // Simpan file gambar baru
            $imagePath = $request->file('image')->store('room_images', 'public');
            $validatedData['image'] = $imagePath; // Update path gambar di data yang akan disimpan
        } else {
            // Jika tidak ada file baru yang diupload, kita tidak mengubah field 'image'
            // Jadi, kita hapus 'image' dari $validatedData agar tidak menimpa dengan null jika kosong
            // kecuali jika memang fieldnya dikirim kosong dan kita ingin mengosongkannya.
            // Namun, karena 'image' nullable, jika tidak ada di $request, validasi akan lolos
            // dan $validatedData tidak akan memiliki key 'image'. $room->update() tidak akan mengubahnya.
            // Jika Anda ingin ada tombol "hapus gambar", logikanya akan berbeda.
            // Untuk sekarang, jika tidak ada file baru, gambar lama tetap.
            unset($validatedData['image']); // Hapus image dari array jika tidak ada file baru, agar tidak di-update menjadi null
            // Ini jika Anda ingin field image tidak berubah jika tidak ada file baru.
            // Jika Anda ingin bisa mengosongkan gambar dengan tidak memilih file,
            // maka Anda perlu logika tambahan atau biarkan $validatedData['image'] = null; jika request image kosong.
            // Dengan 'nullable' pada validasi dan tidak ada file, 'image' tidak akan ada di $validatedData,
            // sehingga $room->update($validatedData) tidak akan mengubah kolom image. Ini perilaku yang diinginkan.
        }
        // 3. Update data kamar
        try {
            // Jika 'image' tidak ada di $validatedData (karena tidak ada file baru diupload),
            // kolom 'image' di database tidak akan diubah oleh $room->update().
            $room->update($validatedData);

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Data kamar berhasil diperbarui!');
        } catch (\Exception $e) {
            // Jika ada error saat menyimpan dan kita sudah upload gambar baru (dan mungkin menghapus yg lama),
            // idealnya ada rollback untuk file, tapi ini lebih kompleks.
            // Untuk sekarang, cukup log error.
            \Log::error('Error updating room: ' . $e->getMessage());
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
