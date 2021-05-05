<?php

namespace App\Http\Controllers;

use App\Imports\CertificateImport;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;
// use Mpdf\Mpdf;

class CertificatesController extends Controller
{
    
    //display database records 
    public function cert(){
        $cert = Certificate::all();
        return view('certificates')->with('cert', $cert);
    }

    //store single certificate record in database
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'course' => 'required',
            'module' => 'required',
            'c_date' => 'required|date',
        ]);
        $uuid = Str::uuid();

        $cert = new Certificate;
        
        $cert->id = $uuid;
        $cert->name = $request->name;
        $cert->email = $request->email;
        $cert->course = $request->course;
        $cert->module = $request->module;
        $cert->completion_date = $request->c_date;
        $cert->save();

        QrCode::generate("192.168.43.36/certificate_generator/public/certificates/$uuid", "../public/qrcodes/$uuid.svg");

        return "Created Successfully";
    }

    //store .xlsx file certificate records in database
    public function fileStore(Request $request){
        $validated = $request->validate([
            'file' => 'required',
        ]);
        $extensions = "xlsx";

        $result = $request->file('file')->getClientOriginalExtension();
    
        if($result == $extensions){
             // Do something when Succeeded 
             $file = $request->file('file');
             Excel::import(new CertificateImport, $file);
             return back()->withStatus('Excel File imported successfully');
        }else{
           return back();
        }
    }

    public function show($id){
        // set_time_limit(300);
        $cert = Certificate::where('id',$id)->get();
        //PDF 
        // $pdf = PDF::loadView('qrcode', compact('cert'));
        // return $pdf->stream();

    
        $html = file_get_contents("../resources/views/qrcode.blade.php"); 

    //DOMPDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('d.pdf', array('Attachment'=> 0));

    //MPDF
        // $mpdf = new Mpdf();
        // $mpdf->WriteHTML($html);
        // $mpdf->showImageErrors = true;
        // $mpdf->Output();

        // return view('displaycert')->with('cert', $cert);

    }
        
        
}
