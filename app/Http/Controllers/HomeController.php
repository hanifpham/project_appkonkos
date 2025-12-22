<?php

namespace App\Http\Controllers;

use App\Models\Kosan;
use App\Models\Kontrakan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the marketing home page with featured kosan & kontrakan data.
     */
    public function __invoke(Request $request)
    {
        $jenisHunian = $request->string('jenis')->lower()->value();
        $lokasi = trim((string) $request->input('lokasi'));

        $normalizePrice = fn ($value) => $value !== null && $value !== ''
            ? (int) preg_replace('/\D+/', '', $value)
            : null;

        $hargaMin = $normalizePrice($request->input('harga_min'));
        $hargaMax = $normalizePrice($request->input('harga_max'));

        if ($hargaMin === null && $hargaMax === null) {
            $hargaInput = $request->input('harga');
            if ($hargaInput !== null && $hargaInput !== '') {
                preg_match_all('/\d+/', $hargaInput, $matches);
                $numbers = array_map('intval', $matches[0] ?? []);
                if (count($numbers) === 1) {
                    $hargaMin = $numbers[0];
                } elseif (count($numbers) >= 2) {
                    $hargaMin = min($numbers[0], $numbers[1]);
                    $hargaMax = max($numbers[0], $numbers[1]);
                }
            }
        }

        $filterKosan = ! $jenisHunian || $jenisHunian === 'semua' || $jenisHunian === 'kosan';
        $filterKontrakan = ! $jenisHunian || $jenisHunian === 'semua' || $jenisHunian === 'kontrakan';

        $kosanQuery = Kosan::where('status', 'tersedia');
        $kontrakanQuery = Kontrakan::where('status', 'tersedia');

        if ($lokasi !== '') {
            $kosanQuery->where(function ($query) use ($lokasi) {
                $query->where('nama_kosan', 'like', '%' . $lokasi . '%')
                    ->orWhere('alamat', 'like', '%' . $lokasi . '%');
            });

            $kontrakanQuery->where(function ($query) use ($lokasi) {
                $query->where('nama_kontrakan', 'like', '%' . $lokasi . '%')
                    ->orWhere('alamat', 'like', '%' . $lokasi . '%');
            });
        }

        if ($hargaMin !== null) {
            $kosanQuery->where('harga_bulan', '>=', $hargaMin);
            $kontrakanQuery->where('harga_tahun', '>=', $hargaMin);
        }

        if ($hargaMax !== null) {
            $kosanQuery->where('harga_bulan', '<=', $hargaMax);
            $kontrakanQuery->where('harga_tahun', '<=', $hargaMax);
        }

        $kosans = $filterKosan ? $kosanQuery->latest()->get() : collect();
        $kontrakans = $filterKontrakan ? $kontrakanQuery->latest()->get() : collect();

        return view('user.home.index', [
            'kosans' => $kosans,
            'kontrakans' => $kontrakans,
            'filters' => [
                'lokasi' => $lokasi,
                'jenis' => $jenisHunian ?: 'semua',
                'harga' => $request->input('harga'),
            ],
        ]);
    }
}
