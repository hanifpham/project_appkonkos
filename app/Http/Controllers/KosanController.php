<?php

namespace App\Http\Controllers;

use App\Models\Kosan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class KosanController extends Controller
{
    public function index()
    {
        $data = Kosan::all();
        return view('admin.kosan.index', compact('data'));
    }
    public function create()
    {
        return view('admin.kosan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kosan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak_kosan' => 'required|string|max:20',
            'harga_bulan' => 'required|numeric',
            'gambar_kosan' => 'image|mimes:jpg,png,jpeg|max:10240',
            'detail_kosan.*' => 'image|mimes:jpg,png,jpeg|max:10240',
            'fasilitas_kosan' => 'required|string',
            'fasilitas_umum' => 'required|string',
            'peraturan_kosan' => 'required|string',
            'kamar_yang_tersedia' => 'required|string',
            'status' => 'required|string',
            'maps' => 'required|string',
        ], [
            'nama_kosan.required' => 'Nama kosan harus diisi.',
            'alamat.required' => 'Alamat kosan harus diisi.',
            'kontak_kosan.required' => 'Kontak kosan harus diisi.',
            'harga_bulan.required' => 'Harga kosan harus diisi.',
            'harga_bulan.numeric' => 'Harga kosan harus berupa angka.',

            'gambar_kosan.image' => 'Gambar kosan harus berupa gambar.',
            'gambar_kosan.mimes' => 'Format gambar kosan harus jpg, png, atau jpeg.',
            'gambar_kosan.max' => 'Ukuran gambar kosan maksimal 10 MB.',

            'detail_kosan.*.image' => 'Detail gambar kosan harus berupa gambar.',
            'detail_kosan.*.mimes' => 'Format detail gambar harus jpg, png, atau jpeg.',
            'detail_kosan.*.max' => 'Detail gambar maksimal 10 MB.',

            'fasilitas_kosan.required' => 'Fasilitas kosan harus diisi.',
            'fasilitas_umum.required' => 'Fasilitas umum harus diisi.',
            'peraturan_kosan.required' => 'Peraturan kosan harus diisi.',
            'kamar_yang_tersedia.required' => 'Kamar yang tersedia harus diisi.',
            'status.required' => 'Status kosan harus diisi.',
            'maps.required' => 'Link maps harus diisi.',
        ]);

        // SIMPAN GAMBAR UTAMA
        if ($request->hasFile('gambar_kosan')) {
            $validated['gambar_kosan'] = $request->file('gambar_kosan')->store('gambar_kosan', 'public');
        }

        // SIMPAN MULTI GAMBAR DETAIL
        $detailImages = [];
        if ($request->hasFile('detail_kosan')) {
            foreach ($request->file('detail_kosan') as $file) {
                $detailImages[] = $file->store('detail_kosan', 'public');
            }
        }

        // SIMPAN SEBAGAI JSON
        $validated['detail_kosan'] = json_encode($detailImages);

        Kosan::create($validated);

        return redirect()->route('admin.kosan.index')->with('success', 'Data kosan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kosan = Kosan::findOrFail($id);
        return view('admin.kosan.edit', compact('kosan'));
    }

    public function update(Request $request, $id)
    {
        $kosan = Kosan::findOrFail($id);

        $validated = $request->validate(
            [
                'nama_kosan' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kontak_kosan' => 'required|string|max:20',
                'harga_bulan' => 'required|numeric',
                'gambar_kosan' => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'detail_kosan.*' => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'fasilitas_kosan' => 'required|string',
                'fasilitas_umum' => 'required|string',
                'peraturan_kosan' => 'required|string',
                'kamar_yang_tersedia' => 'required|string',
                'status' => 'required|string',
                'maps' => 'required|string',
            ],
            [
                'nama_kosan' => 'Nama kosan harus diisi.',
                'alamat' => 'Alamat kosan harus diisi.',
                'kontak_kosan' => 'Kontak kosan harus berupa angka.',
                'harga_bulan' => 'Harga kosan harus diisi.',
                'harga_bulan.numeric' => 'Harga kosan harus berupa angka.',
                'gambar_kosan.image' => 'Gambar kosan harus berupa gambar.',
                'gambar_kosan.mimes' => 'Format gambar kosan harus jpg, png, atau jpeg.',
                'gambar_kosan.max' => 'Ukuran gambar kosan maksimal 10 MB.',
                'detail_kosan.*.image' => 'Detail gambar kosan harus berupa gambar.',
                'detail_kosan.*.mimes' => 'Format gambar detail kosan harus jpg, png, atau jpeg.',
                'detail_kosan.*.max' => 'Ukuran gambar detail kosan maksimal 10 MB.',
                'fasilitas_kosan' => 'Fasilitas kosan harus diisi.',
                'fasilitas_umum' => 'Fasilitas umum kosan harus diisi.',
                'peraturan_kosan' => 'Peraturan kosan harus diisi.',
                'kamar_yang_tersedia' => 'Kamar yang tersedia kosan harus diisi.',
                'status' => 'Status kosan harus diisi.',
                'maps' => 'Link maps harus diisi.',
            ]
        );

        // UPDATE GAMBAR UTAMA
        if ($request->hasFile('gambar_kosan')) {
            if ($kosan->gambar_kosan && Storage::disk('public')->exists($kosan->gambar_kosan)) {
                Storage::disk('public')->delete($kosan->gambar_kosan);
            }
            $validated['gambar_kosan'] = $request->file('gambar_kosan')->store('gambar_kosan', 'public');
        }

        // UPDATE MULTI GAMBAR DETAIL
        $detailImages = json_decode($kosan->detail_kosan, true) ?? [];

        if ($request->hasFile('detail_kosan')) {

            // Hapus gambar lama
            foreach ($detailImages as $old) {
                if (Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }

            // Upload ulang
            $detailImages = [];
            foreach ($request->file('detail_kosan') as $file) {
                $detailImages[] = $file->store('detail_kosan', 'public');
            }
        }

        // Hanya update detail_kosan jika ada file baru, jika tidak maka biarkan detailImages tetap menyimpan yang lama
        $validated['detail_kosan'] = json_encode($detailImages);

        $kosan->update($validated);

        return redirect()->route('admin.kosan.index')->with('success', 'Data kosan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kosan = Kosan::findOrFail($id);

        // Hapus gambar utama
        if ($kosan->gambar_kosan && Storage::disk('public')->exists($kosan->gambar_kosan)) {
            Storage::disk('public')->delete($kosan->gambar_kosan);
        }

        // Hapus semua gambar detail
        $detailImages = json_decode($kosan->detail_kosan, true) ?? [];
        foreach ($detailImages as $img) {
            if (Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        $kosan->delete();

        return back()->with('success', 'Data kosan berhasil dihapus!');
    }

    public function show($id)
    {
        $data = Kosan::findOrFail($id);
        return view('admin.kosan.show', compact('data'));
    }

    public function pdf()
    {
        $data = Kosan::all();
        $pdf = Pdf::loadView('admin.kosan.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('data_kosan.pdf');
    }
}
