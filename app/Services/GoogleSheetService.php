<?php
// app/Services/GoogleSheetService.php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request;
use Google\Service\Sheets\GridRange;
use Illuminate\Support\Facades\Log;


class GoogleSheetService
{
    protected $spreadsheetId;
    protected $service;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->addScope(Sheets::SPREADSHEETS);

        $this->service = new Sheets($client);

        // Ganti ini dengan Spreadsheet ID kamu
        $this->spreadsheetId = '1g7fxUT7bx43aiPlphu28r6jUjDPRZH4h9lu1XLRl9NA';
    }

    public function sheetExists(string $sheetName): bool
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                return true;
            }
        }

        return false;
    }



    public function addSheet(string $newSheetName)
    {
        $requests = [
            new \Google\Service\Sheets\Request([
                'addSheet' => [
                    'properties' => [
                        'title' => $newSheetName,
                    ]
                ]
            ])
        ];

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        return $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
    }

    public function appendRow(array $values, string $range = 'Sheet1')
    {
        $body = new Sheets\ValueRange([
            'values' => [$values]
        ]);

        $params = ['valueInputOption' => 'USER_ENTERED'];

        return $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }

    public function readSheet(string $range = 'Sheet1!A1:Z1000')
    {
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues();
    }

    public function writeToSheet(string $sheetName, string $cells, array $values)
    {
        $range = $sheetName . '!' . $cells; // Menulis ke sheet 'DataBaru', range A1 sampai C1


        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $values
        ]);

        $params = ['valueInputOption' => 'USER_ENTERED'];

        return $this->service->spreadsheets_values->update(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }


    public function writeSingleCell(string $sheetName, string $cell, string $value)
    {
        $range = "'$sheetName'!" . $cell; // Perhatikan tanda kutip
        $values = [
            [$value]
        ];

        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $values
        ]);

        $params = ['valueInputOption' => 'USER_ENTERED'];

        return $this->service->spreadsheets_values->update(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }

    public function listSheets()
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        foreach ($sheets as $sheet) {
            echo $sheet->getProperties()->getTitle() . "\n";
        }
    }


    public function freezeRowsAndColumns(string $sheetName, int $rows = 1, int $columns = 1)
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        $sheetId = null;
        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                $sheetId = $sheet->getProperties()->getSheetId();
                break;
            }
        }

        if (is_null($sheetId)) {
            throw new \Exception("Sheet '$sheetName' not found.");
        }

        $requests = [
            new \Google\Service\Sheets\Request([
                'updateSheetProperties' => [
                    'properties' => [
                        'sheetId' => $sheetId,
                        'gridProperties' => [
                            'frozenRowCount' => $rows,
                            'frozenColumnCount' => $columns,
                        ],
                    ],
                    'fields' => 'gridProperties.frozenRowCount,gridProperties.frozenColumnCount',
                ],
            ])
        ];

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        return $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
    }


    public function mergeCells(string $sheetName, string $startCell, string $endCell)
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        $sheetId = null;
        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                $sheetId = $sheet->getProperties()->getSheetId();
                break;
            }
        }

        if (is_null($sheetId)) {
            throw new \Exception("Sheet '$sheetName' not found.");
        }

        // Konversi cell ke index numerik
        [$startColumn, $startRow] = $this->cellToIndexes($startCell);
        [$endColumn, $endRow] = $this->cellToIndexes($endCell);

        $requests = [
            new \Google\Service\Sheets\Request([
                'mergeCells' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => $startRow - 1,
                        'endRowIndex' => $endRow,
                        'startColumnIndex' => $startColumn - 1,
                        'endColumnIndex' => $endColumn,
                    ],
                    'mergeType' => 'MERGE_ALL', // Bisa MERGE_COLUMNS, MERGE_ROWS, MERGE_ALL
                ]
            ])
        ];

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        return $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
    }

    private function cellToIndexes($cell)
    {
        preg_match('/([A-Z]+)([0-9]+)/', strtoupper($cell), $matches);

        if (!$matches) {
            throw new \Exception("Invalid cell format: $cell");
        }

        $columnLetter = $matches[1];
        $rowIndex = (int) $matches[2];

        $columnIndex = 0;
        $length = strlen($columnLetter);
        for ($i = 0; $i < $length; $i++) {
            $columnIndex *= 26;
            $columnIndex += ord($columnLetter[$i]) - ord('A') + 1;
        }

        return [$columnIndex, $rowIndex];
    }


    public function styleCell(string $sheetName, string $range, array $styleOptions = [])
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        $sheetId = null;
        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                $sheetId = $sheet->getProperties()->getSheetId();
                break;
            }
        }

        if (is_null($sheetId)) {
            throw new \Exception("Sheet '$sheetName' not found.");
        }

        // Mendukung single cell (A1) atau range (A1:C3)
        $parts = explode(':', $range);
        $startCell = $parts[0];
        $endCell = $parts[1] ?? $parts[0];

        [$startCol, $startRow] = $this->cellToIndexes($startCell);
        [$endCol, $endRow] = $this->cellToIndexes($endCell);

        $requests = [
            new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => $startRow - 1,
                        'endRowIndex' => $endRow,
                        'startColumnIndex' => $startCol - 1,
                        'endColumnIndex' => $endCol,
                    ],
                    'cell' => [
                        'userEnteredFormat' => $styleOptions
                    ],
                    'fields' => 'userEnteredFormat'
                ]
            ])
        ];

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        return $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
    }



    public function setBorderStyle(string $sheetName, string $range)
    {
        // Ambil index sheet berdasarkan nama
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheetId = null;
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                $sheetId = $sheet->getProperties()->getSheetId();
                break;
            }
        }

        if ($sheetId === null) {
            throw new \Exception("Sheet not found: $sheetName");
        }

        // Konversi range ke row/column index
        [$startCell, $endCell] = explode(':', $range);
        [$startCol, $startRow] = $this->cellToIndexes($startCell);
        [$endCol, $endRow] = $this->cellToIndexes($endCell);

        // Buat request border
        $requests[] = new \Google\Service\Sheets\Request([
            'updateBorders' => [
                'range' => [
                    'sheetId' => $sheetId,
                    'startRowIndex' => $startRow - 1,
                    'endRowIndex' => $endRow,
                    'startColumnIndex' => $startCol - 1,
                    'endColumnIndex' => $endCol,
                ],
                'top' => [
                    'style' => 'SOLID',
                    'width' => 1,
                    'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                ],
                'bottom' => [
                    'style' => 'SOLID',
                    'width' => 1,
                    'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                ],
                'left' => [
                    'style' => 'SOLID',
                    'width' => 1,
                    'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                ],
                'right' => [
                    'style' => 'SOLID',
                    'width' => 1,
                    'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                ],
                'innerHorizontal' => [
                    'style' => 'SOLID',
                    'width' => 1,
                    'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                ],
                'innerVertical' => [
                    'style' => 'SOLID',
                    'width' => 1,
                    'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                ],
            ]
        ]);

        // Kirim batch update
        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        return $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
    }
    public function autoResizeColumns(string $sheetName, int $startColumnIndex, int $endColumnIndex)
    {
        $sheetId = $this->getSheetIdByName($sheetName);

        if ($sheetId === null) {
            throw new \Exception("Sheet $sheetName tidak ditemukan.");
        }
        $requests = [
            new \Google\Service\Sheets\Request([
                'autoResizeDimensions' => [
                    'dimensions' => [
                        'sheetId' => $sheetId,
                        'dimension' => 'COLUMNS',
                        'startIndex' => 0,
                        'endIndex' => 33 // Kolom A sampai AG (index ke-32 + 1)
                    ]
                ]
            ])
        ];

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        return $this->service->spreadsheets->batchUpdate(
            $this->spreadsheetId,
            $batchUpdateRequest
        );
    }
    public function getSheetIdByName(string $sheetName): ?int
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                return $sheet->getProperties()->getSheetId();
            }
        }
        return null; // Sheet tidak ditemukan
    }

    public function getCellValue(string $sheetName, string $cell)
    {
        $range = $sheetName . '!' . $cell;

        $response = $this->service->spreadsheets_values->get(
            $this->spreadsheetId,
            $range
        );

        $values = $response->getValues();

        // Jika cell ada isinya, ambil nilai pertamanya
        return $values[0][0] ?? null;
    }


    public function getFilteredRowNumbersByColumn(string $sheetName, string $column = 'A', string $search)
    {
        $range = $sheetName . '!' . $column . ':' . $column;

        $response = $this->service->spreadsheets_values->get(
            $this->spreadsheetId,
            $range
        );

        $values = $response->getValues();
        $result = [];

        foreach ($values as $index => $row) {
            $rowNumber = $index + 1;
            $cellValue = $row[0] ?? null;

            if (trim($cellValue) === trim($search)) {
                $result[] = $rowNumber;
            }
        }

        return $result;
    }
    public function generateMergeRequests(string $sheetName, string $startCell, array $data)
    {
        // Mendapatkan Sheet ID berdasarkan nama sheet
        $sheetId = $this->getSheetIdByName($sheetName);
        if ($sheetId === null) {
            throw new \Exception("Sheet '$sheetName' not found.");
        }

        // Mengambil kolom dan baris dari $startCell (misalnya C4 menjadi C dan 4)
        [$startColLetter, $startRow] = sscanf($startCell, '%[A-Z]%d');
        $startColIndex = $this->letterToColumnIndex($startColLetter);

        // Mengelompokkan data berdasarkan room_number dan date
        $dates = array_unique(array_column($data, 'date'));
        sort($dates);
        $dateToCol = array_flip($dates);

        $grouped = [];
        foreach ($data as $entry) {
            $row = $entry['room_number'];
            $col = $dateToCol[$entry['date']];
            $grouped[$row][$col] = true;
        }

        $requests = [];
        // Debug: Periksa data yang dikelompokkan
        error_log(print_r($grouped, true));

        // Mengiterasi grouped untuk menentukan area yang akan di-merge
        foreach ($grouped as $room => $cols) {
            $rowIndex = $startRow - 1 + ($room - 1); // Konversi row ke indeks

            // Menentukan range kolom yang bersebelahan untuk setiap room
            $colIndexes = array_keys($cols);
            sort($colIndexes);

            $start = null;
            $prev = null;

            foreach ($colIndexes as $colIndex) {
                if ($start === null) {
                    $start = $colIndex;
                    $prev = $colIndex;
                    continue;
                }

                if ($colIndex === $prev + 1) {
                    $prev = $colIndex;
                    continue;
                }

                if ($prev > $start) {
                    // Membangun permintaan merge jika ada kolom yang bersebelahan secara horizontal
                    $requests[] = $this->buildMergeRequest($sheetId, $rowIndex, $startColIndex + $start, $startColIndex + $prev + 1);
                }

                $start = $colIndex;
                $prev = $colIndex;
            }

            if ($start !== null && $prev > $start) {
                // Menangani kondisi terakhir untuk merge secara horizontal
                $requests[] = $this->buildMergeRequest($sheetId, $rowIndex, $startColIndex + $start, $startColIndex + $prev + 1);
            }
        }

        // Debug: Periksa permintaan merge yang akan dikirim
        error_log(print_r($requests, true));

        // Kirim permintaan merge ke Google Sheets menggunakan batchUpdate
        if (!empty($requests)) {
            $this->service->spreadsheets->batchUpdate($this->spreadsheetId, new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]));
        } else {
            error_log("Tidak ada permintaan merge.");
        }
    }

    private function buildMergeRequest(int $sheetId, int $rowIndex, int $startCol, int $endCol): array
    {
        return [
            'mergeCells' => [
                'range' => [
                    'sheetId' => $sheetId,
                    'startRowIndex' => $rowIndex,
                    'endRowIndex' => $rowIndex + 1,
                    'startColumnIndex' => $startCol,
                    'endColumnIndex' => $endCol,
                ],
                'mergeType' => 'MERGE_ALL'
            ]
        ];
    }

    private function letterToColumnIndex(string $letter): int
    {
        $letter = strtoupper($letter);
        $col = 0;

        for ($i = 0; $i < strlen($letter); $i++) {
            $col *= 26;
            $col += ord($letter[$i]) - ord('A') + 1;
        }

        return $col - 1;
    }

    public function clearCells(string $sheetName, string $cells)
    {
        // Tentukan range (misalnya, "Sheet1!A1:B2")
        $range = $sheetName . '!' . $cells;

        try {
            // Buat objek ClearValuesRequest
            $clearRequest = new \Google\Service\Sheets\ClearValuesRequest();

            // Panggil metode clear
            $response = $this->service->spreadsheets_values->clear(
                $this->spreadsheetId,
                $range,
                $clearRequest
            );

            return $response;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
