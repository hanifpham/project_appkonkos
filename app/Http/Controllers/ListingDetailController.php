<?php

namespace App\Http\Controllers;

use App\Models\Kosan;
use App\Models\Kontrakan;

class ListingDetailController extends Controller
{
    public function kosan(Kosan $kosan)
    {
        return view('user.listings.show', [
            'type' => 'kosan',
            'title' => $kosan->nama_kosan,
            'location' => $kosan->alamat,
            'contact' => $kosan->kontak_kosan,
            'price' => $kosan->harga_bulan,
            'priceUnit' => ' / Bulan',
            'status' => $kosan->status,
            'primaryImage' => $kosan->gambar_kosan,
            'detailImages' => $this->prepareImages($kosan->detail_kosan),
            'roomLabel' => 'Kamar',
            'roomValue' => $kosan->kamar_yang_tersedia,
            'roomFacilities' => $this->splitList($kosan->fasilitas_kosan),
            'generalFacilities' => $this->splitList($kosan->fasilitas_umum),
            'notesTitle' => 'Peraturan Kos',
            'notes' => $this->splitList($kosan->peraturan_kosan),
            'mapEmbed' => $kosan->maps,
            'infoList' => [
                ['label' => 'Kontak Pemilik', 'value' => $kosan->kontak_kosan],
                ['label' => 'Kamar Tersedia', 'value' => $kosan->kamar_yang_tersedia],
                ['label' => 'Status', 'value' => ucfirst($kosan->status)],
            ],
        ]);
    }

    public function kontrakan(Kontrakan $kontrakan)
    {
        return view('user.listings.show', [
            'type' => 'kontrakan',
            'title' => $kontrakan->nama_kontrakan,
            'location' => $kontrakan->alamat,
            'contact' => $kontrakan->kontak_kontrakan,
            'price' => $kontrakan->harga_tahun,
            'priceUnit' => ' / Tahun',
            'status' => $kontrakan->status,
            'primaryImage' => $kontrakan->gambar_kontrakan,
            'detailImages' => $this->prepareImages($kontrakan->detail_kontrakan),
            'roomLabel' => 'Jumlah Kamar',
            'roomValue' => $kontrakan->jumlah_kamar,
            'roomFacilities' => $this->splitList($kontrakan->fasilitas_kontrakan),
            'generalFacilities' => $this->splitList($kontrakan->fasilitas_umum),
            'notesTitle' => 'Peraturan Kontrakan',
            'notes' => $this->splitList($kontrakan->peraturan_kontrakan),
            'mapEmbed' => $kontrakan->maps,
            'infoList' => [
                ['label' => 'Kontak Pemilik', 'value' => $kontrakan->kontak_kontrakan],
                ['label' => 'Luas Kontrakan', 'value' => $kontrakan->luas_kontrakan],
                ['label' => 'Status', 'value' => ucfirst($kontrakan->status)],
            ],
        ]);
    }

    /**
     * Pecah string fasilitas/peraturan menjadi array yang rapi.
     */
    private function splitList(?string $value): array
    {
        if (!$value) {
            return [];
        }

        $items = preg_split("/[\r\n,;]+/", $value);

        return array_values(array_filter(array_map('trim', $items)));
    }

    /**
     * Decode kolom gambar detail menjadi array path.
     */
    private function prepareImages(?string $value): array
    {
        if (!$value) {
            return [];
        }

        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return array_values(array_filter(array_map('trim', explode('|', $value))));
    }
}
