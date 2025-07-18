<?php

namespace App\Utils;

class Dater
{
    public static function formatTanggalIndo($tanggal)
    {
        $timestamp = strtotime($tanggal);

        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $tahun = date('Y', $timestamp);
        $bulan = (int) date('m', $timestamp);
        $tanggal = date('d', $timestamp);
        $endDate = date('t', $timestamp);
        $namaBulan = $bulanIndo[$bulan];

        return [
            'tahun' => (int) $tahun,
            'bulan' => $bulan,
            'tanggal' => (int) $tanggal,
            'nama_bulan' => $namaBulan,
            'end_date' => (int) $endDate,
        ];
    }
}
