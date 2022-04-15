<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets;

class GoogleSheet {
    private $spreadSheetId;
    private $client;
    private $googleSheetService;


    public function __construct()
    {
        $this->spreadSheetId = config('datastudio.google_sheet_id');

        $this->client = new \Google_Client(); 
        $this->client->setAuthConfig(storage_path('credentials.json'));
        $this->client->addScope("https://www.googleapis.com/auth/spreadsheets");

        $this->googleSheetService = new \Google_Service_Sheets($this->client); 
    }

    public function readGoogleSheet() {
        $dimensions = $this->getDimensions($this->spreadSheetId);
        $colRange = 'users_register!1:2';
        $range = 'users_register!A1:' . $dimensions['colCount'];

        $column = $this->googleSheetService
            ->spreadsheets_values
            ->batchGet($this->spreadSheetId, ['ranges' => $colRange, 'majorDimension' => 'ROWS']);

        $data = $this->googleSheetService
            ->spreadsheets_values
            ->batchGet($this->spreadSheetId, ['ranges' => $range]);
        //dd($data->getValueRanges()[0]->values);
        //dd($data);
        return $data->getValueRanges()[0]->values;
    }   

    public function saveDataToSheet(array $data, $spreadSheetId, $nameSheet){
        $dimensions = $this->getDimensions($spreadSheetId, $nameSheet);

        $body = new \Google_Service_Sheets_ValueRange([
           'values' => $data
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $range = "A" . ($dimensions['rowCount'] + 1);

        return $this->googleSheetService
            ->spreadsheets_values
            ->update($spreadSheetId, $range, $body, $params);
    }

    private function getDimensions($spreadSheetId, $nameSheet = 'users_register') {
        $rowDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
            $spreadSheetId,
            ['ranges' => $nameSheet.'!A:A', 'majorDimension' => 'COLUMNS']
        );
       
        //if data is present at nth row, it will return array till nth row
        //if all column values are empty, it returns null
        $rowMeta = $rowDimensions->getValueRanges()[0]->values;
        if (!$rowMeta) {
            return [
                'error' => true,
                'message' => 'missing row data'
            ];
        }

        $colDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
            $spreadSheetId,
            ['ranges' => $nameSheet.'!1:1', 'majorDimension' => 'ROWS']
        );

        //if data is present at nth col, it will return array till nth col
        //if all column values are empty, it returns null
        $colMeta = $colDimensions->getValueRanges()[0]->values;
        if (!$colMeta) {
            return [
                'error' => true,
                'message' => 'missing row data'
            ];
        }

        return [
            'error' => false,
            'rowCount' => count($rowMeta[0]),
            'colCount' => $this->colLengthToColumnAddress(count($colMeta[0]))
        ];
    }

    private function colLengthToColumnAddress($number) {
        if ($number <= 0) return null;

        $letter = '';

        while ($number > 0) {
            $temp = ($number - 1) % 26;
            $letter = chr($temp + 65) . $letter;
            $number = ($number - $temp - 1) / 26;
        }
        return $letter;
    }

}