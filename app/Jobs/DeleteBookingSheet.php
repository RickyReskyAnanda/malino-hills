<?php

namespace App\Jobs;

use App\Functions\SheetHelper;
use App\Utils\Dater;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class DeleteBookingSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dt;
    /**
     * Create a new job instance.
     */
    public function __construct($dt)
    {
        $this->dt = $dt;
    }
    public $tries = 5;       // Jumlah maksimum percobaan
    public $timeout = 60;    // Timeout per job (detik)

    // ⬇️ Tambahkan fungsi backoff di sini
    public function backoff(): int
    {
        return 10; // tunggu 10 detik sebelum retry
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sheet = new SheetHelper();

            $tgl = Dater::formatTanggalIndo($this->dt['date']);
            $sheetName = strtoupper($tgl['nama_bulan']) . "-{$tgl['tahun']}";

            $sheet->setClearCell($sheetName, $this->dt);
    }

    public function failed(\Throwable $exception)
    {
        Log::error('delete cell job failed: ' . $exception->getMessage());
    }
}
