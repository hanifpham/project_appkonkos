<?php

namespace App\Http\Controllers;

use App\Models\Kontrakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class KontrakanController extends Controller
{
    public function index()
    {
        $data = Kontrakan::all();
        return view('admin.kontrakan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kontrakan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nama_kontrakan' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kontak_kontrakan' => 'required|string|max:20',
                'harga_tahun' => 'required|numeric',
                'luas_kontrakan' => 'required|string',
                'jumlah_kamar' => 'required|numeric',
                'status' => 'required|string',
                'maps' => 'required|string',
                'gambar_kontrakan' => 'required|image|mimes:jpg,png,jpeg|max:10240',
                'detail_kontrakan.*' => 'image|mimes:jpg,png,jpeg|max:10240',
                'fasilitas_kontrakan' => 'required|string',
                'fasilitas_umum' => 'required|string',
                'peraturan_kontrakan' => 'required|string',
            ],
            [
                'nama_kontrakan.required' => 'Nama kontrakan harus diisi.',
                'alamat.required' => 'Alamat kontrakan harus diisi.',
                'kontak_kontrakan.required' => 'Kontak kontrakan harus diisi.',
                'harga_tahun.required' => 'Harga kontrakan harus diisi.',
                'harga_tahun.numeric' => 'Harga kontrakan harus berupa angka.',
                'luas_kontrakan.required' => 'Luas kontrakan harus diisi.',
                'jumlah_kamar.required' => 'Jumlah kamar harus diisi.',
                'jumlah_kamar.numeric' => 'Jumlah kamar harus berupa angka.',
                'maps.required' => 'Maps kontrakan harus diisi.',
                'gambar_kontrakan.required' => 'Gambar kontrakan harus diisi.',
                'gambar_kontrakan.image' => 'Gambar kontrakan harus berupa gambar.',
                'gambar_kontrakan.mimes' => 'Format gambar kontrakan harus jpg, png, atau jpeg.',
                'gambar_kontrakan.max' => 'Ukuran gambar kontrakan maksimal 10 MB.',
                'detail_kontrakan.*.required' => 'Detail gambar kontrakan harus diisi.',
                'detail_kontrakan.*.image' => 'Detail gambar kontrakan harus berupa gambar.',
                'peraturan_kontrakan.required' => 'Peraturan kontrakan harus diisi.',
            ]
        );

        // SIMPAN GAMBAR UTAMA
        if ($request->hasFile('gambar_kontrakan')) {
            $validated['gambar_kontrakan'] = $request->file('gambar_kontrakan')->store('gambar_kontrakan', 'public');
        }

        // SIMPAN GAMBAR DETAIL
        $detailImages = [];
        if ($request->hasFile('detail_kontrakan')) {
            foreach ($request->file('detail_kontrakan') as $file) {
                $detailImages[] = $file->store('detail_kontrakan', 'public');
            }
        }

        $validated['detail_kontrakan'] = json_encode($detailImages);

        Kontrakan::create($validated);

        return redirect()->route('admin.kontrakan.index')->with('success', 'Data kontrakan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kontrakan = Kontrakan::findOrFail($id);
        return view('admin.kontrakan.edit', compact('kontrakan'));
    }

    public function update(Request $request, $id)
    {
        $kontrakan = Kontrakan::findOrFail($id);

        $validated = $request->validate(
            [
                'nama_kontrakan' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kontak_kontrakan' => 'required|string|max:20',
                'harga_tahun' => 'required|numeric',
                'luas_kontrakan' => 'required|string',
                'jumlah_kamar' => 'required|numeric',
                'status' => 'required|string',
                'maps' => 'required|string',
                'gambar_kontrakan' => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'detail_kontrakan.*' => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'fasilitas_kontrakan' => 'required|string',
                'fasilitas_umum' => 'required|string',
                'peraturan_kontrakan' => 'required|string',
            ],
            [
                'nama_kontrakan.required' => 'Nama kontrakan harus diisi.',
                'alamat.required' => 'Alamat kontrakan harus diisi.',
                'kontak_kontrakan.required' => 'Kontak kontrakan harus diisi.',
                'harga_tahun.required' => 'Harga kontrakan harus diisi.',
                'harga_tahun.numeric' => 'Harga kontrakan harus berupa angka.',
                'luas_kontrakan.required' => 'Luas kontrakan harus diisi.',
                'jumlah_kamar.required' => 'Jumlah kamar harus diisi.',
                'jumlah_kamar.numeric' => 'Jumlah kamar harus berupa angka.',
                'maps.required' => 'Maps kontrakan harus diisi.',

                'gambar_kontrakan.image' => 'Gambar kontrakan harus berupa gambar.',
                'gambar_kontrakan.mimes' => 'Format gambar kontrakan harus jpg, png, atau jpeg.',
                'gambar_kontrakan.max' => 'Ukuran gambar kontrakan maksimal 10 MB.',

                'detail_kontrakan.*.image' => 'Detail gambar kontrakan harus berupa gambar.',
                'detail_kontrakan.*.mimes' => 'Format detail gambar harus jpg, png, atau jpeg.',
                'peraturan_kontrakan.required' => 'Peraturan kontrakan harus diisi.',
            ]
        );

        // UPDATE GAMBAR UTAMA
        if ($request->hasFile('gambar_kontrakan')) {
            Storage::disk('public')->delete($kontrakan->gambar_kontrakan);
            $validated['gambar_kontrakan'] = $request->file('gambar_kontrakan')->store('gambar_kontrakan', 'public');
        }

        // UPDATE GAMBAR DETAIL
        $detailImages = json_decode($kontrakan->detail_kontrakan, true) ?? [];

        if ($request->hasFile('detail_kontrakan')) {
            foreach ($detailImages as $old) {
                Storage::disk('public')->delete($old);
            }

            $newImages = [];
            foreach ($request->file('detail_kontrakan') as $file) {
                $newImages[] = $file->store('detail_kontrakan', 'public');
            }

            $validated['detail_kontrakan'] = json_encode($newImages);
        }

        $kontrakan->update($validated);

        return redirect()->route('admin.kontrakan.index')->with('success', 'Data kontrakan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kontrakan = Kontrakan::findOrFail($id);

        Storage::disk('public')->delete($kontrakan->gambar_kontrakan);

        $detailImages = json_decode($kontrakan->detail_kontrakan, true) ?? [];
        foreach ($detailImages as $img) {
            Storage::disk('public')->delete($img);
        }

        $kontrakan->delete();

        return back()->with('success', 'Data kontrakan berhasil dihapus!');
    }

    public function show($id)
    {
        $data = Kontrakan::findOrFail($id);
        return view('admin.kontrakan.show', compact('data'));
    }
    public function pdf()
    {
        $data = Kontrakan::all();
        $pdf = Pdf::loadView('admin.kontrakan.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('data_kontrakan.pdf');
    }
}
