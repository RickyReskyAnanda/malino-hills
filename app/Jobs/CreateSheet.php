<?php

namespace App\Jobs;

use App\Functions\SheetHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $date;
    /**
     * Create a new job instance.
     */
    public function __construct($date)
    {
        $this->date = $date;
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
        if($sheet->createSheet($this->date)){
            $sheet->setUpSheet($this->date);
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error('CreateSheet job failed: ' . $exception->getMessage());
    }
}
