<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateStatusTelat;
use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AntrianController extends Controller
{
    public function index()
    {
        return Antrian::with('layanan')->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'id_layanan' => 'required|exists:layanans,id',
        ]);
        $antrian = Antrian::create($validated)->refresh();

        // Update Cache Antrian
        $antrians = Antrian::with('Layanan.KategoriLayanan')
             ->orderBy('waktu_daftar')
             ->get();
        Cache::put('antrian', $antrians, now()->addHours(24));

        // Cache Statistik
        $stats = Antrian::selectRaw("
            count(case when status = 'waiting' then 1 end) as waiting,
            count(case when status = 'called' then 1 end) as called,
            count(case when status = 'late' then 1 end) as late,
            count(case when status = 'done' then 1 end) as done
        ")
        ->first();
        Cache::put('antrian-statistic', [
            'waiting' => $stats->waiting ?? 0,
            'called'  => $stats->called ?? 0,
            'late'    => $stats->late ?? 0,
            'done'    => $stats->done ?? 0,
        ], now()->addHours(24));
        
        $antrian_created = $antrian->load('Layanan.KategoriLayanan');
        // dd($antrian_created);
        return view('mpp.guest.success-create-ticket', compact('antrian_created'));
    }

    public function resetStat() {
        Antrian::query()->update([
            'status' => 'waiting'
        ]);

        // Update Cache Antrian
        $antrians = Antrian::with('Layanan.KategoriLayanan')
             ->orderBy('waktu_daftar')
             ->get();
        Cache::put('antrian', $antrians, now()->addHours(24));

        // Cache Statistik
        $stats = Antrian::selectRaw("
            count(case when status = 'waiting' then 1 end) as waiting,
            count(case when status = 'called' then 1 end) as called,
            count(case when status = 'late' then 1 end) as late,
            count(case when status = 'done' then 1 end) as done
        ")
        ->first();
        Cache::put('antrian-statistic', [
            'waiting' => $stats->waiting ?? 0,
            'called'  => $stats->called ?? 0,
            'late'    => $stats->late ?? 0,
            'done'    => $stats->done ?? 0,
        ], now()->addHours(24));

        // Cache antrian terpanggil
        Cache::put('antrian-dipanggil', 
            false, 
            now()->addHours(24)
        );

        return response()->json(['success' => true, 'message' => 'Semua status berhasil direset'], 200);
    }

    public function stream_antrian()
    {
        set_time_limit(0);

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        return response()->stream(function () {
            while (true) {
                if (connection_aborted()) {
                    break;
                }

                // Ambil data terbaru dari storage/DB/cache
                $data = Cache::get('antrian', []);

                // Kirim event dan data Antrian SSE
                echo "event:antrian-update\n";
                echo "data: " . json_encode($data) . "\n\n";

                // Event for Data Statistik 
                $stats = Cache::get('antrian-statistic', [
                    'waiting' => 0, 'called' => 0, 'late' => 0, 'done' => 0
                ]);
                echo "event: antrian-statistic\n";
                echo "data: " . json_encode($stats) . "\n\n";

                // Event for Antrian Dipanggil 
                $stats = Cache::get('antrian-dipanggil', false);
                echo "event: antrian-called\n";
                echo "data: " . json_encode($stats) . "\n\n";

                ob_flush();
                flush();

                sleep(1); // Update setiap 1 detik
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // Penting untuk Nginx!
        ]);

    }

    public function show($id)
    {
        return Antrian::with('layanan')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'id_layanan' => 'sometimes|required|exists:layanans,id',
            'status' => 'sometimes|in:waiting,called,late,done',
        ]);
        $antrian->update($validated);

        if ($validated['status'] == 'called') {
            UpdateStatusTelat::dispatch($id)
                ->delay(now()->addMinutes(2));

            $antrianCalled = $antrian->load('Layanan.KategoriLayanan');
            $data = [
                'antrian_called' => $antrianCalled,
                'time' => now()->timestamp,
            ];

            // Cache Panggilan
            Cache::put('antrian-dipanggil', 
                $data, 
                now()->addHours(24)
            );
        }

        // Update Cache Antrian
        $antrians = Antrian::with('Layanan.KategoriLayanan')
             ->orderBy('waktu_daftar')
             ->get();
        Cache::put('antrian', $antrians, now()->addHours(24));

        // Cache Statistik
        $stats = Antrian::selectRaw("
            count(case when status = 'waiting' then 1 end) as waiting,
            count(case when status = 'called' then 1 end) as called,
            count(case when status = 'late' then 1 end) as late,
            count(case when status = 'done' then 1 end) as done
        ")
        ->first();
        Cache::put('antrian-statistic', [
            'waiting' => $stats->waiting ?? 0,
            'called'  => $stats->called ?? 0,
            'late'    => $stats->late ?? 0,
            'done'    => $stats->done ?? 0,
        ], now()->addHours(24));

        return response()->json([
            'success' => true,
            'message' => 'antrian updated',
            'data' => [
                'antrian' => $antrian->load('layanan')
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->delete();

        return $antrian;
    }
}
