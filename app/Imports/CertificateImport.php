<?php

namespace App\Imports;

use App\Models\Certificate;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Hash;

class CertificateImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $unix = ($row[4] - 25569) * 86400;
        $uuid = Str::uuid();

        $cert = new Certificate;
        
        $cert->id = $uuid;
        $cert->name = $row[0];
        $cert->email = $row[1];
        $cert->course = $row[2];
        $cert->module = $row[3];
        $cert->completion_date = date('Y-m-d', $unix);
        // $cert->qr_code = QrCode::generate("192.168.43.36:8000/certificates/"+$uuid);
        $cert->save();

        // return new Certificate([
        //     'id' => $uuid,
        //     'name' => $row[0],
        //     'email' => $row[1],
        //     'course' => $row[2],
        //     'module' => $row[3],
        //     'completion_date' => date('Y-m-d', $unix),
        //     'qr_code' => $svg,

        // ]);
    }
}
