<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kosan;
use App\Models\Kontrakan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function createForKosan(Kosan $kosan)
    {
        return view('user.booking.create', [
            'type' => 'kosan',
            'listing' => $kosan,
            'price' => $kosan->harga_bulan,
            'priceUnit' => ' / Bulan',
        ]);
    }

    public function createForKontrakan(Kontrakan $kontrakan)
    {
        return view('user.booking.create', [
            'type' => 'kontrakan',
            'listing' => $kontrakan,
            'price' => $kontrakan->harga_tahun,
            'priceUnit' => ' / Tahun',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'telepon' => ['required', 'string'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after:tanggal_mulai'],
            'kosan_id' => ['nullable', 'exists:kosans,id', 'required_without:kontrakan_id'],
            'kontrakan_id' => ['nullable', 'exists:kontrakans,id', 'required_without:kosan_id'],
        ]);

        if (!empty($validated['kosan_id']) && !empty($validated['kontrakan_id'])) {
            return back()
                ->withInput()
                ->withErrors(['kosan_id' => 'Pilih salah satu: kosan atau kontrakan.']);
        }

        $bookingCode = 'BK-' . Str::upper(Str::random(8));

        if (!empty($validated['kosan_id'])) {
            $kosan = Kosan::findOrFail($validated['kosan_id']);

            $start = Carbon::parse($validated['tanggal_mulai']);
            $end = Carbon::parse($validated['tanggal_selesai']);

            $totalHari = $start -> diffInDays($end);
            $durasi = ceil($totalHari/30);
            if ($durasi  < 1 ) $durasi = 1;
            $totalBiaya  = $kosan -> harga_bulan * $durasi;

            $booking = Booking::create([
                'id_booking' => $bookingCode,
                'user_id' => Auth::id(),
                'telepon' => $validated['telepon'],
                'id_kosan' => $kosan->id,
                'id_kontrakan' => null,
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'jumlah_biaya' => $totalBiaya,
                'status' => 'Pending',
            ]);
            $listingName = $kosan->nama_kosan;
            $listingContact = $kosan->kontak_kosan;
            $listingType = 'Kosan';
            $priceUnit =  "/ $durasi Bulan";

        } elseif (!empty($validated['kontrakan_id'])) {
            $kontrakan = Kontrakan::findOrFail($validated['kontrakan_id']);
            $start = Carbon::parse($validated['tanggal_mulai']);
            $end = Carbon::parse($validated['tanggal_selesai']);

            $durasi = $start->diffInYears($end);
            if ($durasi < 1) $durasi = 1;
            $totalBiaya = $kontrakan->harga_tahun * $durasi;

            $booking = Booking::create([
                'id_booking' => $bookingCode,
                'user_id' => Auth::id(),
                'telepon' => $validated['telepon'],
                'id_kosan' => null,
                'id_kontrakan' => $kontrakan->id,
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'jumlah_biaya' => $totalBiaya,
                'status' => 'Pending',
            ]);
            $listingName = $kontrakan->nama_kontrakan;
            $listingContact = $kontrakan->kontak_kontrakan;
            $listingType = 'Kontrakan';
            $priceUnit = " / $durasi Tahun";
        }

        $bookingProof = [
            'id_booking' => $booking->id_booking,
            'tanggal_pengajuan' => Carbon::parse($booking->created_at)->locale('id')->translatedFormat('d F Y'),
            'nama' => Auth::user()->nama,
            'email' => Auth::user()->email,
            'telepon' => $validated['telepon'],
            'tanggal_mulai' => Carbon::parse($booking->tanggal_mulai)->locale('id')->translatedFormat('d F Y'),
            'tanggal_selesai' => Carbon::parse($booking->tanggal_selesai)->locale('id')->translatedFormat('d F Y'),
            'durasi' => $durasi, 
            'unit' => $listingType === 'Kosan' ? 'Bulan' : 'Tahun',
            'jumlah_biaya' => number_format($booking->jumlah_biaya, 0, ',', '.'),
            'listing' => $listingName ?? '-',
            'listing_type' => $listingType ?? '',
            'price_unit' => $priceUnit ?? '',
            'kontak_pemilik' => $listingContact ?? $validated['telepon'],
        ];

        return redirect()
            ->back()
            ->with('success', 'Booking berhasil dibuat! Silakan selesaikan pembayaran. Klik Profil untuk mengecek pembayaran')
            ->with('booking_proof', $bookingProof);
    }

    public function index()
    {
        $bookings = Booking::with('user', 'kosan', 'kontrakan')->latest()->get();
        return view('admin.booking.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with('user', 'kosan', 'kontrakan')->findOrFail($id);

        return view('admin.booking.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Pending', 'Diterima', 'Ditolak'])],
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $validated['status']]);

        if ($validated['status'] === 'Diterima') {
            if ($booking->id_kosan) {
                Kosan::where('id', $booking->id_kosan)->update(['status' => 'tidak tersedia']);
            } elseif ($booking->id_kontrakan) {
                Kontrakan::where('id', $booking->id_kontrakan)->update(['status' => 'tidak tersedia']);
            }
        }

        return redirect()->route('admin.booking.index')->with('success', 'Status booking berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil dihapus.');
    }
}
