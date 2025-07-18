<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GoogleSheetService;
use App\Enums\StatusType;
use App\Utils\Dater;
use App\Models\Villa;
use App\Utils\ResponseFormat;
use Validator;


class SheetController extends Controller
{

    public function createSheet(GoogleSheetService $sheet){
        $tgl = Dater::formatTanggalIndo(date('Y-m-d'));
        
        // $tahun = 2025;
        // $bulan = 11;
        // $bulan = strtoupper("NOVEMBER");
        
        $sheetName = strtoupper($tgl['nama_bulan']) . "-{$tgl['tahun']}";

        if($sheet->sheetExists($sheetName)){
            return response()->json(ResponseFormat::format(
                200,
                "Sheet {$sheetName} sudah ada",
                [
                    'is_exist' => true
                ],
            ), 200);
        }
        # CREATE SHEET
        $sheet->addSheet($sheetName);
        sleep(1);

        // #FREEZE ROW COLOMN
        $sheet->freezeRowsAndColumns($sheetName,6,2);
        sleep(1);

        #set label
        $sheet->writeSingleCell($sheetName,"B1","Room Book");
        $sheet->writeToSheet($sheetName,"A6:AG6",[
            [
                'Villa',
                'No',
                $tgl['bulan'].'/1',
                $tgl['bulan'].'/2',
                $tgl['bulan'].'/3',
                $tgl['bulan'].'/4',
                $tgl['bulan'].'/5',
                $tgl['bulan'].'/6',
                $tgl['bulan'].'/7',
                $tgl['bulan'].'/8',
                $tgl['bulan'].'/9',
                $tgl['bulan'].'/10',
                $tgl['bulan'].'/11',
                $tgl['bulan'].'/12',
                $tgl['bulan'].'/13',
                $tgl['bulan'].'/14',
                $tgl['bulan'].'/15',
                $tgl['bulan'].'/16',
                $tgl['bulan'].'/17',
                $tgl['bulan'].'/18',
                $tgl['bulan'].'/19',
                $tgl['bulan'].'/20',
                $tgl['bulan'].'/21',
                $tgl['bulan'].'/22',
                $tgl['bulan'].'/23',
                $tgl['bulan'].'/24',
                $tgl['bulan'].'/25',
                $tgl['bulan'].'/26',
                $tgl['bulan'].'/27',
                $tgl['bulan'].'/28',
                $tgl['bulan'].'/29',
                $tgl['bulan'].'/30',
                $tgl['bulan'].'/31',
            ]
        ]);
        #setting header
        $sheet->mergeCells($sheetName,"C5","AG5");
        $sheet->writeSingleCell($sheetName,"C5","'{$tgl['nama_bulan']} {$tgl['tahun']}");
        $sheet->styleCell($sheetName, 'C5', [
            'horizontalAlignment' => 'CENTER',
            'verticalAlignment' => 'MIDDLE',
            'textFormat' => [
                'bold' => true,
                'fontSize' => 12,
                'foregroundColor' => ['red' => 0.2, 'green' => 0.2, 'blue' => 0.2]
            ],
        ]);
    }

    public function setUpSheet(GoogleSheetService $sheet){
        $tgl = Dater::formatTanggalIndo(date('Y-m-d'));
        $sheetName = strtoupper($tgl['nama_bulan']) . "-{$tgl['tahun']}";
        if(!$sheet->sheetExists($sheetName)){
            return response()->json(ResponseFormat::format(
                200,
                "Sheet {$sheetName} belum ada",
            ), 200);
        }
        $data = Villa::with(['villaNumber' => function($q){
         $q->orderBy('number','asc');
        }])
        ->select('id_villa','name','villa_count')
        ->where('status',StatusType::PUBLISHED)
        ->get();

        $rowNumber = 6;
        sleep(1);
        
        try {
            foreach($data as $key => $value){
                if($key > 0)
                    $sheet->writeToSheet($sheetName,"A".$rowNumber.":AG".$rowNumber,[
                        [
                            'Villa',
                            'No',
                            '1/1',
                            '1/2',
                            '1/3',
                            '1/4',
                            '1/5',
                            '1/6',
                            '1/7',
                            '1/8',
                            '1/9',
                            '1/10',
                            '1/11',
                            '1/12',
                            '1/13',
                            '1/14',
                            '1/15',
                            '1/16',
                            '1/17',
                            '1/18',
                            '1/19',
                            '1/20',
                            '1/21',
                            '1/22',
                            '1/23',
                            '1/24',
                            '1/25',
                            '1/26',
                            '1/27',
                            '1/28',
                            '1/29',
                            '1/30',
                            '1/31',
                        ]
                    ]);
    
                #GABUNG CELL
                $sheet->mergeCells($sheetName,"A".$rowNumber+1, "A".($value->villa_count + $rowNumber));
                $sheet->writeSingleCell($sheetName,"A".$rowNumber+1, str_replace("Villa ","", $value->name));
                $sheet->styleCell($sheetName, "A".$rowNumber+1, [
                    'horizontalAlignment' => 'CENTER',
                    'verticalAlignment' => 'MIDDLE',
                    'textFormat' => [
                        'bold' => true,
                        'fontSize' => 12,
                    ],
                    'textRotation' => [
                        'angle' => 90, // 90 derajat ke atas
                    ],
                ]);

                $sheet->setBorderStyle($sheetName,"A".$rowNumber.":AG".($rowNumber + $value->villa_count));


                $rowNumber++;
                $arr = [];
                foreach(range(1,$value->villa_count) as $number){
                    $arr[]= ["$number"];
                }

                $sheet->writeToSheet($sheetName,"B".$rowNumber.":B".($rowNumber+$value->villa_count),$arr);
                $rowNumber+= (2+$value->villa_count);
            }

            $sheet->autoResizeColumns($sheetName, 2,32);

            return response()->json(ResponseFormat::format(
                200,
                "Sheet {$sheetName} sudah diperbarui",
            ), 200);
        } catch (\Throwable $th) {
            return response()->json(ResponseFormat::format(
                500,
                $th->getMessage(),
            ), 200);
        }

    }


    public function setBookingDate(GoogleSheetService $sheet, Request $request){

        $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date_format:Y-m-d',
            'villa_id' => 'required|numeric',
            'room_number' => 'required|numeric',
            'nama' => 'required|string|max:100',
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }

        $bookingDate = request()->input('booking_date');
        $villaId = request()->input('villa_id');
        $roomNumber = request()->input('room_number');
        $nama = request()->input('nama');

        $tgl = Dater::formatTanggalIndo($bookingDate);

        $sheetName = strtoupper($tgl['nama_bulan']) . "-{$tgl['tahun']}";
        if(!$sheet->sheetExists($sheetName)){
            return response()->json(ResponseFormat::format(
                200,
                "Sheet {$sheetName} belum ada",
            ), 200);
        }

        $villa = Villa::where('id_villa',$villaId)->first();
        $villaName = str_replace("Villa ","",$villa->name);
        
        $arrayVillaNumber = $sheet->getFilteredRowNumbersByColumn($sheetName,"A", $villaName);

        $column = $this->shiftExcelColumn('B', $tgl['tanggal'], $nama);
        


        $row =  $arrayVillaNumber[0] + $roomNumber - 1;
        $cell = $column. $row;

        $sheet->writeSingleCell($sheetName,$cell, $nama);



        $sheet->autoResizeColumns($sheetName, 2,32);

        return response()->json(ResponseFormat::format(
            200,
            "{$villaName} sudah ditandai",
        ), 200);
    }


    private function shiftExcelColumn(string $column, int $shift): string {
        // Ubah huruf ke angka
        $column = strtoupper($column);
        $length = strlen($column);
        $number = 0;
        for ($i = 0; $i < $length; $i++) {
            $number *= 26;
            $number += ord($column[$i]) - ord('A') + 1;
        }
    
        // Tambahkan shift
        $number += $shift;
    
        // Ubah balik ke huruf
        $result = '';
        while ($number > 0) {
            $mod = ($number - 1) % 26;
            $result = chr($mod + ord('A')) . $result;
            $number = intval(($number - $mod - 1) / 26);
        }
    
        return $result;
    }
}