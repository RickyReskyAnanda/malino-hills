<?php

namespace App\Functions;

use App\Services\GoogleSheetService;
use App\Enums\StatusType;
use App\Utils\Dater;
use App\Models\Villa;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class SheetHelper
{
    protected $service;

    public function __construct()
    {
        $this->service = new GoogleSheetService();
    }

    public function createSheet($date)
    {

        $tgl = Dater::formatTanggalIndo($date);
        $sheetName = strtoupper($tgl['nama_bulan']) . "-{$tgl['tahun']}";

        if ($this->service->sheetExists($sheetName)) {
            return false;
        }

        $this->service->addSheet($sheetName);
        sleep(1);

        $this->service->freezeRowsAndColumns($sheetName, 6, 2);
        sleep(1);

        $this->service->writeSingleCell($sheetName, "B1", "Room Book");

        $this->service->writeToSheet($sheetName, "A6:AG6", [[
            'Villa',
            'No',
            ...array_map(fn($i) => $tgl['bulan'] . "/" . $i, range(1, $tgl['end_date']))
        ]]);

        $this->service->mergeCells($sheetName, "C5", "AG5");
        $this->service->writeSingleCell($sheetName, "C5", "'{$tgl['nama_bulan']} {$tgl['tahun']}");
        $this->service->styleCell($sheetName, 'C5', [
            'horizontalAlignment' => 'CENTER',
            'verticalAlignment' => 'MIDDLE',
            'textFormat' => [
                'bold' => true,
                'fontSize' => 12,
                'foregroundColor' => ['red' => 0.2, 'green' => 0.2, 'blue' => 0.2]
            ],
        ]);

        return true;
    }

    public function setUpSheet($date)
    {
        $tgl = Dater::formatTanggalIndo($date);
        $sheetName = strtoupper($tgl['nama_bulan']) . "-{$tgl['tahun']}";

        if (!$this->service->sheetExists($sheetName)) {
            return false;
        }

        $data = Villa::with(['villaNumber' => fn($q) => $q->orderBy('number', 'asc')])
            ->select('id_villa', 'name', 'villa_count')
            ->where('status', StatusType::PUBLISHED)
            ->get();

        $rowNumber = 6;
        sleep(1);

        try {
            foreach ($data as $key => $value) {
                sleep(3);
                if ($key > 0) {
                    $this->service->writeToSheet($sheetName, "A{$rowNumber}:AG{$rowNumber}", [[
                        'Villa',
                        'No',
                        ...array_map(fn($i) => $tgl['bulan'] . "/{$i}", range(1, $tgl['end_date']))
                    ]]);
                }

                $this->service->mergeCells($sheetName, "A" . ($rowNumber + 1), "A" . ($value->villa_count + $rowNumber));
                $this->service->writeSingleCell($sheetName, "A" . ($rowNumber + 1), str_replace("Villa ", "", $value->name));
                $this->service->styleCell($sheetName, "A" . ($rowNumber + 1), [
                    'horizontalAlignment' => 'CENTER',
                    'verticalAlignment' => 'MIDDLE',
                    'textFormat' => [
                        'bold' => true,
                        'fontSize' => 12,
                    ],
                    'textRotation' => ['angle' => 90],
                ]);

                $this->service->setBorderStyle($sheetName, "A{$rowNumber}:AG" . ($rowNumber + $value->villa_count));

                $rowNumber++;
                $arr = [];
                foreach (range(1, $value->villa_count) as $number) {
                    $arr[] = ["$number"];
                }

                $this->service->writeToSheet($sheetName, "B{$rowNumber}:B" . ($rowNumber + $value->villa_count), $arr);
                $rowNumber += (2 + $value->villa_count);
            }
            sleep(3);

            $this->service->autoResizeColumns($sheetName, 2, 32);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function setClearCell($sheetName, $data)
    {
            $bookingDate = $data['date'];
            $villaId = $data['villa_id'];
            $roomNumber = $data['room_number'];

            $tgl = Dater::formatTanggalIndo($bookingDate);
            $villa = Villa::find($villaId);
            $villaName = str_replace("Villa ", "", $villa->name);
            $arrayVillaNumber = $this->service->getFilteredRowNumbersByColumn($sheetName, "A", $villaName);

            $column = self::shiftExcelColumn('B', $tgl['tanggal']);
            $data = $arrayVillaNumber[0] + $roomNumber - 1;
            $cell = $column . $data;

            $this->service->clearCells($sheetName, $cell);

    }


    public function setBookingDate($sheetName, $rows)
    {
        foreach ($rows as $row) {

            $bookingDate = $row['date'];
            $villaId = $row['villa_id'];
            $roomNumber = $row['room_number'];
            $nama = $row['name'];

            $tgl = Dater::formatTanggalIndo($bookingDate);
            $villa = Villa::find($villaId);
            $villaName = str_replace("Villa ", "", $villa->name);
            $arrayVillaNumber = $this->service->getFilteredRowNumbersByColumn($sheetName, "A", $villaName);

            $column = self::shiftExcelColumn('B', $tgl['tanggal']);
            $row = $arrayVillaNumber[0] + $roomNumber - 1;
            $cell = $column . $row;

            $this->service->writeSingleCell($sheetName, $cell, $nama);
            sleep(2);
        }

        $this->service->autoResizeColumns($sheetName, 2, 32);

        sleep(3);

        return true;
    }

    public function setMergeByDateRoom($sheetName, $rows, $villaId)
    {

        $villa = Villa::find($villaId);
        $villaName = str_replace("Villa ", "", $villa->name);
        $arrayVillaNumber = $this->service->getFilteredRowNumbersByColumn($sheetName, "A", $villaName);

        $startRow = $arrayVillaNumber[0];
        $column = self::shiftExcelColumn('B', date('d', strtotime($rows[0]['date'])));

        $this->service->generateMergeRequests($sheetName, $column . $startRow, $rows);
        $this->service->autoResizeColumns($sheetName, 2, 32);
    }

    private static function shiftExcelColumn(string $column, int $shift): string
    {
        $column = strtoupper($column);
        $length = strlen($column);
        $number = 0;
        for ($i = 0; $i < $length; $i++) {
            $number *= 26;
            $number += ord($column[$i]) - ord('A') + 1;
        }

        $number += $shift;

        $result = '';
        while ($number > 0) {
            $mod = ($number - 1) % 26;
            $result = chr($mod + ord('A')) . $result;
            $number = intval(($number - $mod - 1) / 26);
        }

        return $result;
    }
}
