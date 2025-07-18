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


class UpdateBookingSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rows;
    /**
     * Create a new job instance.
     */
    public function __construct($rows)
    {
        $this->rows = $rows;
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

        foreach($this->rows as $ym){ // by year month
            if($sheet->createSheet($ym[0]['ym'].'-01')){
                $sheet->setUpSheet($ym[0]['ym'].'-01');
            }

            $tgl = Dater::formatTanggalIndo($ym[0]['date']);
            $sheetName = strtoupper($tgl['nama_bulan']) . "-{$tgl['tahun']}";

            $sheet->setBookingDate($sheetName, $ym);

            sleep(3);
            // foreach($groupedByVillaId as $villaId => $villa){
            //     sleep(5);
                // $sheet->setMergeByDateRoom($sheetName, $villa, $villaId);
            // }

        }

    }

    public function failed(\Throwable $exception)
    {
        Log::error('CreateSheet job failed: ' . $exception->getMessage());
    }
}
