<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Simpan pesan dari halaman landing page.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'pesan' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->to(route('home') . '#contact')
            ->with('success', 'Pesan berhasil dikirim. Terima kasih atas masukannya!');
    }

    /**
     * Tampilkan daftar pesan di dashboard admin.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Detail pesan tunggal.
     */
    public function show(ContactMessage $message)
    {
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Hapus pesan.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
