<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Approval;
use App\Models\Contract;
use App\Models\ContractVendor;
use App\Models\ReviewLegal;
use App\Models\User;
use Carbon\Carbon;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Milon\Barcode\DNS2D;
use PhpOffice\PhpWord\TemplateProcessor;
use bootstrap\helpers\Terbilang;

use function Ramsey\Uuid\v1;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Vendor');
    }

    public function contracts()
    {
        $vendor = Vendor::where('user_detail_id', Auth::id())->first();
        $contracts = $vendor->contracts()->get();

        return view('vendor.contracts', compact('contracts'));
    }

    public function contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $review_hukum = ReviewLegal::where('contract_vendor_id', $contracts->pivot->id)->get();

        return view('vendor.contract',  compact('contracts', 'contract', 'review_hukum'));
    }


    public function contract_edit(Contract $contract, Vendor $vendor)
    {
        $contracts = Contract::where('id', $contract->id)->first();
        $dateSPFormat = Carbon::createFromFormat('Y-m-d', $contracts->date_sp)->format('d-M-Y');

        $contract = $contracts->vendors()->where('vendor_id', $vendor->id)->first();
        return view('vendor.contract-edit', compact('contract', 'contracts', 'dateSPFormat'));
    }

    public function contract_update(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        $request->validate([
            'prosentase' => 'required',
            'nilai_kontrak' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $fileName = now()->format('Ymd') . "_" .  Str::random(20);
        //HURUF BESAR
        $vendor_upper = strtoupper($request->vendor);
        //HURUF KAPITAL
        $vendor_capital = ucfirst($request->vendor);

        // Tentukan format bahasa Indonesia untuk bulan
        $indonesianMonths = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        
        // Ubah tahun dalam angka menjadi kata-kata dalam bahasa Indonesia
        $indonesianYears = [
          '2022' => 'Dua Ribu Dua Puluh Dua',
          '2023' => 'Dua Ribu Dua Puluh Tiga',
          '2024' => 'Dua Ribu Dua Puluh Empat',
          '2025' => 'Dua Ribu Dua Puluh Lima',
          '2026' => 'Dua Ribu Dua Puluh Enam',
          '2027' => 'Dua Ribu Dua Puluh Tujuh'
      ];
        $inputStartDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        // Format tanggal dengan format bahasa Indonesia
        $date_sname = 'Tanggal '.terbilang($inputStartDate->day) . ' Bulan ' . $indonesianMonths[$inputStartDate->month] . ' Tahun ' . $indonesianYears[$inputStartDate->year];
    

        $inputEndDate = Carbon::createFromFormat('Y-m-d', $request->end_date);
        // Format tanggal dengan format bahasa Indonesia
        $date_ename = 'Tanggal '.terbilang($inputEndDate->day) . ' Bulan ' . $indonesianMonths[$inputEndDate->month] . ' Tahun ' . $indonesianYears[$inputEndDate->year];
        
        $inputDateName = Carbon::createFromFormat('Y-m-d', $request->date_dof);
        // Format tanggal dengan format bahasa Indonesia
        $date_name = 'Tanggal '.terbilang($inputDateName->day) . ' Bulan ' . $indonesianMonths[$inputDateName->month] . ' Tahun ' . $indonesianYears[$inputDateName->year];

        // $angkaTerbilang = require('@develoka/angka-terbilang-js');
        $rupiah = terbilang($request->performance_bond);

        $name_devdate = terbilang($request->delivery_date);
    
        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 2,
            'no_dof' => $request->no_dof,
            'date_dof' => $request->date_dof,
            'date_name' => $date_name,
            'management_executives' => $request->management_executives,
            'management_job' => $request->management_job,
            'vendor_upper' => $vendor_upper,
            'vendor_capital' => $vendor_capital,
            'director' => $request->director,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'place_vendor' => $request->place_vendor,
            'prosentase' => $request->prosentase,
            'contract_amount' => $request->contract_amount,
            'state_rate' => $request->state_rate,
            'minimum_transport' => $request->minimum_transport,
            'start_date' => $request->start_date,
            'date_sname' => $date_sname,
            'end_date' => $request->end_date,
            'date_ename' => $date_ename,
            'performance_bond' => $request->performance_bond,
            'rupiah' => $rupiah,
            'delivery_date' => $request->delivery_date,
            'name_devdate' => $name_devdate,
            'filename' => $fileName,
        ]);

        //mengubah date ('Y-m-d') ke ('d-m-Y)
        $date_dof = Carbon::createFromFormat('Y-m-d', $request->date_dof)->format('d-m-Y');
        $date_sp = Carbon::createFromFormat('Y-m-d', $request->date_sp)->format('d-m-Y');
        $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date)->format('d-m-Y');
        $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->format('d-m-Y');

        // .docx
        $templateProcessor = new TemplateProcessor('word-template/template-kontrak-jasa-angkutan-darat.docx');
        $templateProcessor->setValue('no_dof', $request->no_dof);
        $templateProcessor->setValue('date_dof', $date_dof);
        $templateProcessor->setValue('date_name', $date_name);
        $templateProcessor->setValue('prosentase', $request->prosentase);
        $templateProcessor->setValue('management_executives', $request->management_executives);
        $templateProcessor->setValue('management_job', $request->management_job);
        $templateProcessor->setValue('vendor_upper', $vendor_upper);
        $templateProcessor->setValue('vendor_capital', $vendor_capital);
        $templateProcessor->setValue('director', $request->director);
        $templateProcessor->setValue('phone', $request->phone);
        $templateProcessor->setValue('address', $request->address);
        $templateProcessor->setValue('email', $request->email);
        $templateProcessor->setValue('place_vendor', $request->place_vendor);
        $templateProcessor->setValue('prosentase', $request->prosentase);
        $templateProcessor->setValue('contract_amount', $request->contract_amount);
        $templateProcessor->setValue('state_rate', $request->state_rate);
        $templateProcessor->setValue('minimum_transport', $request->minimum_transport);
        $templateProcessor->setValue('start_date', $start_date);
        $templateProcessor->setValue('date_sname', $date_sname);
        $templateProcessor->setValue('end_date', $end_date);
        $templateProcessor->setValue('date_ename', $date_ename);
        $templateProcessor->setValue('performance_bond', $request->performance_bond);
        $templateProcessor->setValue('rupiah', $rupiah);
        $templateProcessor->setValue('delivery_date', $request->delivery_date);
        $templateProcessor->setValue('name_devdate', $name_devdate);
        $templateProcessor->setValue('no_sp', $request->no_sp);
        $templateProcessor->setValue('date_sp', $date_sp);
        $templateProcessor->saveAs($fileName . '.docx');

        // .pdf
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($fileName . '.docx'));
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save(public_path($fileName . '.pdf'));

        // .docx
        // $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($fileName . '.docx'));
        // $docxWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'Word2007');
        // $docxWriter->save(public_path($fileName . '.docx'));

        // get contract_detail id
        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        // create approval
        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 1,
            'description' => 'Data Kontrak Diisi Oleh Vendor',
        ]);

        $flasher->addSuccess('Berhasil menambah data kontrak!');

        return redirect()->route('vendor.contract', ['contract' => $contract->id, 'vendor' => $vendor->id]);
    }
    
    function terbilang($nilai) {
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        if($nilai==0){
            return "Kosong";
        }elseif ($nilai < 12&$nilai!=0) {
            return "" . $huruf[$nilai];
        } elseif ($nilai < 20) {
            return Terbilang($nilai - 10) . " Belas ";
        } elseif ($nilai < 100) {
            return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
        } elseif ($nilai < 200) {
            return " Seratus " . Terbilang($nilai - 100);
        } elseif ($nilai < 1000) {
            return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
        } elseif ($nilai < 2000) {
            return " Seribu " . Terbilang($nilai - 1000);
        } elseif ($nilai < 1000000) {
            return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
        }elseif ($nilai < 1000000000000) {
            return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
        }elseif ($nilai < 100000000000000) {
            return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
        }elseif ($nilai <= 100000000000000) {
            return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
        }
    }
    // public function penyebut($nilai) {
    //     $nilai = abs($nilai);
    //     $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    //     $temp = "";
    //     if ($nilai < 12) {
    //         $temp = " ". $huruf[$nilai];
    //     } else if ($nilai <20) {
    //         $temp = penyebut($nilai - 10). " belas";
    //     } else if ($nilai < 100) {
    //         $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    //     } else if ($nilai < 200) {
    //         $temp = " seratus" . penyebut($nilai - 100);
    //     } else if ($nilai < 1000) {
    //         $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    //     } else if ($nilai < 2000) {
    //         $temp = " seribu" . penyebut($nilai - 1000);
    //     } else if ($nilai < 1000000) {
    //         $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    //     } else if ($nilai < 1000000000) {
    //         $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    //     } else if ($nilai < 1000000000000) {
    //         $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    //     } else if ($nilai < 1000000000000000) {
    //         $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    //     }     
    //     return $temp;
    // }
 

    // function terbilang($nilai) {
    //     if($nilai<0) {
    //         $hasil = "minus ". trim(penyebut($nilai));
    //     } else {
    //         $hasil = trim(penyebut($nilai));
    //     }     		
    //     return $hasil;
    // }
    public function sign_contracts()
    {
        $vendor = Vendor::where('user_detail_id', Auth::id())->first();
        $contracts = $vendor->contracts()->where('status_id', [10])->get();
        // $sign = ContractVendor::whereIn('status_id', [10,11])->get();
        return view('vendor.sign-contracts', compact('contracts', 'vendor'));
    }

    public function sign_contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        $path = Storage::url('gQU8ArBwT84xOuO9Rc2vFgPMlOR6GI.pdf');
        // return '<img src=*' . asset('/file_upload/gQU8ArBwT84xOuO9Rc2vFgPMlOR6GI.pdf'). '" alt=**>';

        return view('vendor.sign-contract', compact('contracts', 'contract'));
    }

    public function sign_contract_upload(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        $request->validate([
            'kontrak' => 'nullable|mimes:pdf|max:10000',
        ]);

        if ($request->hasFile('kontrak')) {
            $kontrak = $request->file('kontrak');
            $nama_kontrak = Str::random(30) . '.' . $kontrak->getClientOriginalExtension();
            $kontrak->move('file_upload', $nama_kontrak);
        }

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'final_vendor' => $nama_kontrak,
            'status_id' => 11
        ]);



        $flasher->addSuccess('Kontrak berhasil diupload!');

        return redirect()->back();
    }

    public function show_final(Contract $contract, Vendor $vendor)
    {
    }

    public function check_unique(Request $request)
    {
        $number = $request->input('number');

        // Periksa apakah email sudah ada di database
        $dof = ContractVendor::where('number', $number)->first();

        if ($dof) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
