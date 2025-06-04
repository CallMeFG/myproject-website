<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room; // Jangan lupa tambahkan ini
// Jika Anda ingin menyimpan pesan ke database, buat modelnya dulu, misal: App\Models\ContactMessage
// use App\Models\ContactMessage; 
// use Illuminate\Support\Facades\Mail; // Jika ingin kirim email
// use App\Mail\ContactFormMail; // Jika ingin kirim email

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (beranda).
     */
    public function index()
    {
        // Ambil 4 kamar terbaru berdasarkan ID atau created_at
        $featuredRooms = Room::orderBy('id', 'desc')->take(4)->get();
        // Atau: $featuredRooms = Room::orderBy('created_at', 'desc')->take(4)->get();

        return view('home', ['featuredRooms' => $featuredRooms]);
    }
    /**
     * Menampilkan halaman Tentang Kami (About Us).
     */
    public function about()
    {
        return view('about'); // View 'about.blade.php' akan kita buat
    }

    /**
     * Menampilkan halaman Kontak.
     */
    public function contact()
    {
        return view('contact'); // View 'contact.blade.php' akan kita buat
    }
    public function handleContactForm(Request $request)
    {
        // 1. Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal harus 10 karakter.',
        ]);

        // 2. Lakukan sesuatu dengan data (untuk sekarang, kita lewati dulu)
        // Contoh jika ingin menyimpan ke database (perlu buat model & migrasi ContactMessage dulu):
        /*
        try {
            ContactMessage::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'subject' => $validatedData['subject'],
                'message' => $validatedData['message'],
            ]);
        } catch (\Exception $e) {
            // Log error
            \Log::error('Gagal menyimpan pesan kontak: ' . $e->getMessage());
            return redirect()->route('contact')
                             ->with('contact_error', 'Terjadi kesalahan saat mengirim pesan Anda. Silakan coba lagi nanti.')
                             ->withInput();
        }
        */

        // Contoh jika ingin mengirim email (perlu setup mailer dan Mailable class):
        /*
        try {
            Mail::to('admin@callmehotel.test')->send(new ContactFormMail($validatedData));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email kontak: ' . $e->getMessage());
            // Mungkin tidak perlu menampilkan error ke user jika email gagal, cukup log
        }
        */

        // 3. Redirect kembali ke halaman kontak dengan pesan sukses
        return redirect()->route('contact')
            ->with('contact_success', 'Pesan Anda telah berhasil terkirim! Terima kasih telah menghubungi kami.');
    }
}
