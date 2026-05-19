<?php

namespace App\Jobs;

use App\Models\Antrian;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UpdateStatusTelat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $id_antrian;

    /**
     * Create a new job instance.
     */
    public function __construct($id_antrian)
    {
        $this->id_antrian = $id_antrian;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $antrian = Antrian::findOrFail($this->id_antrian);
        if ($antrian && $antrian->status == 'called') {
            $antrian->update([
                'status' => 'late'
            ]);

            // Update Cache Antrian
            $antrians = Antrian::with('Layanan.KategoriLayanan')
                    ->orderBy('waktu_daftar')
                    ->get();
            Cache::put('antrian', $antrians, now()->addHours(24));

            // Cache CalledAntrian
            $currAntrian = Cache::get('antrian-dipanggil', false);
            if ($antrian->id == $currAntrian['antrian_called']['id']) {
                Cache::put(
                    'antrian-dipanggil',
                    false,
                    now()->addHours(24)
                );
            }

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
        }
    }
}
