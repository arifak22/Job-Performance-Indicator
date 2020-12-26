<?php  

namespace App\Http\Controllers;

use App;
use Cache;
use Config;
use Crypt;
use DB;
use File;
use Excel;
use Hash;
use Log;
use PDF;
use Request;
use Route;
use Session;
use Storage;
use Schema;
use Validator;
use Auth;
use URL;
use Mail;
use Carbon;
use Sideveloper;

class PenilaianController extends MiddleController
{
    var $view  = 'penilaian.';
    var $title = 'Penilaian';
    var $table = 'transaksi';
    var $pk    = 'id_transaksi';

    #VIEW
    public function getIndex(){
        $data['title'] = $this->title;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl(''), 'title'=> $this->title]
        ];
        $year = [];
        $k = 0;
        for ($i='2018'; $i < date('Y') + 2; $i++) { 
            $year[$k]['value'] = $i;
            $year[$k]['name'] = $i;
            $k++;
        }
        $data['year'] = $year;

        $penyedia   = Sideveloper::getPenyedia()->get();
        $data['penyedia'] = Sideveloper::makeOption($penyedia, 'id_penyedia', 'nama', true);

        $dinas   = Sideveloper::getDinas()->get();
        $data['dinas'] = Sideveloper::makeOption($dinas, 'id_dinas', 'nama', true);

        return Sideveloper::load('template', $this->view.'view', $data);
    }

    #READ DATA
    public function getTable(){
        $id_penyedia = $this->input('id_penyedia');
        $tahun_paket = $this->input('tahun_paket');
        $id_dinas    = $this->input('id_dinas');
        $nilai_min   = $this->input('nilai_min');
        $nilai_max   = $this->input('nilai_max');
        $tgl_start   = $this->input('tgl_start');
        $tgl_end     = $this->input('tgl_end');

        $query = DB::table('transaksi')
            ->select('id_transaksi', 'm_penyedia.nama as nama_penyedia', 'nomor_surat', 'tanggal_surat', 'tahun_paket', 
                DB::raw('biaya_nilai + realisasi_nilai + kualitas_nilai + ketepatan_waktu_nilai + tingkat_layanan_nilai as nilai'))
            ->join('m_penyedia', 'm_penyedia.id_penyedia', '=', 'transaksi.id_penyedia')
            // ->whereNull('deleted_at')
            ->where('tahun_paket', $tahun_paket);

        if($id_penyedia)
            $query->where('transaksi.id_penyedia', $id_penyedia);

        if(Auth::user()->id_dinas){
            $query->where('transaksi.id_dinas', Auth::user()->id_dinas);
        }else{
            if($id_dinas)
                $query->where('transaksi.id_dinas', $id_dinas);
        }

        if(isset($nilai_min) && isset($nilai_max) && ($nilai_min <= $nilai_max)){
            $query->whereBetween(DB::raw('biaya_nilai + realisasi_nilai + kualitas_nilai + ketepatan_waktu_nilai + tingkat_layanan_nilai'), [$nilai_min, $nilai_max]);
        }

        if(isset($tgl_start)&&isset($tgl_end) && ($tgl_start <= $tgl_end)){
            $query->whereBetween('tanggal_surat', [$tgl_start, $tgl_end]);
        }
        // $query->dd();
        return datatables()->of($query)->toJson();
    }

    #READ DETAIL DATA
    public function getDetail(){
        $id   = $this->input('id',"required|numeric|exists:transaksi,id_transaksi");
        $from = $this->input('from', 'required');
        $tipe = $this->input('tipe');

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }
        $query = DB::table($this->table)
            ->select(
                'm_penyedia.alamat','users.nama as nama_ppk', 'users.nip',
                'm_penyedia.nama as nama_penyedia', 'npwp', 'nomor_siup',
                'm_dinas.nama as nama_dinas','m_dinas.alamat as alamat_dinas', 'm_dinas.no_telp', 'nomor_surat', 'tanggal_surat', 'hal_surat',
                'pekerjaan.nama as nama_pekerjaan', 'nilai_kontrak', 'nilai_kontrak_hps', 'tahun_paket', 'persentase_realisasi', 'nomor_kontrak',
                'biaya', 'realisasi', 'kt.name as kualitas', 'kw.name as ketepatan_waktu', 'tl.name as tingkat_layanan',
                'biaya_nilai', 'realisasi_nilai', 'kualitas_nilai', 'ketepatan_waktu_nilai', 'tingkat_layanan_nilai',
                DB::raw('biaya_nilai + realisasi_nilai + kualitas_nilai + ketepatan_waktu_nilai + tingkat_layanan_nilai as nilai'),
                'id_transaksi')
            ->join('m_penyedia', 'm_penyedia.id_penyedia', '=', 'transaksi.id_penyedia')
            ->join('pekerjaan', 'pekerjaan.id_pekerjaan', '=', 'transaksi.id_pekerjaan')
            ->join('m_dinas', 'm_dinas.id_dinas', '=', 'transaksi.id_dinas')
            ->join('users', 'users.id', '=', 'transaksi.created_by')
            ->join('m_syscode as kt', function($query){
                $query->on('kt.value', '=', 'transaksi.kualitas')
                    ->on('kt.code', '=', DB::raw("'KT'"));
            })
            ->join('m_syscode as kw', function($query){
                $query->on('kw.value', '=', 'transaksi.ketepatan_waktu')
                    ->on('kw.code', '=', DB::raw("'KW'"));
            })
            ->join('m_syscode as tl', function($query){
                $query->on('tl.value', '=', 'transaksi.tingkat_layanan')
                    ->on('tl.code', '=', DB::raw("'TL'"));
            });

        if(Auth::user()->id_dinas)
            $query->where('transaksi.id_dinas', Auth::user()->id_dinas);

        $data['data'] = $query->where($this->pk, $id)->first();
        $data['title'] = $this->title;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl(''), 'title'=> $this->title],
            ['link' => '#', 'title'=> 'Detail'],
        ];

        if($data['data']){
            if($tipe == "print"){
                $mpdfConfig = array(
                    'mode' => 'utf-8', 
                    'format' => 'A4',
                    'margin_top' => 40,     // 30mm not pixel
                    'margin_left' => 25,
                    'margin_right' => 25,
                    'orientation' => 'P'    
                );
                $mpdf = new \Mpdf\Mpdf($mpdfConfig);

                //HEADER
                $htmlHeader = view('pdf/header', $data)->render();
                $mpdf->SetHTMLHeader($htmlHeader);

                //ISIAN
                $html = view('pdf/cetak', $data)->render();
                $mpdf->WriteHTML($html);

                // Output a PDF file directly to the browser
                $mpdf->Output();
                
            }else{
                return Sideveloper::load('template', $this->view.'detail', $data);
            }
        }
        
        return abort(404);
    }

    #FORM INPUT (INSERT/UPDATE)
    public function getForm(){
        $cekppk = Sideveloper::cekPpk();
        if(!$cekppk)
            abort(404);
            
        $id   = $this->input('id',"numeric|exists:transaksi,id_transaksi");

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }

        $year = [];
        $k = 0;
        for ($i='2018'; $i < date('Y') + 2; $i++) { 
            $year[$k]['value'] = $i;
            $year[$k]['name'] = $i;
            $k++;
        }
        $data['year'] = $year;

        $data['title'] = 'Tambah '.$this->title;
        $data['tipe']  = 1;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl(''), 'title'=> $this->title],
            ['link' => '#', 'title'=> 'Tambah'],
        ];
        if($id){
            $data['title'] = 'Ubah '.$this->title;
            $data['tipe']  = 2;
            $data['breadcrumbs'] = [
                ['link' => Sideveloper::selfUrl(''), 'title'=> $this->title],
                ['link' => '#', 'title'=> 'Ubah'],
            ];
            $data['data']  = DB::table($this->table)->where($this->pk, $id)->first();
            $pekerjaan = Sideveloper::getPekerjaan($data['data']->id_pekerjaan)->get();
        }else{
            $pekerjaan = Sideveloper::getPekerjaan()->get();
        }

        $penyedia = Sideveloper::getPenyedia()->get();
        $data['penyedia']     = Sideveloper::makeOption($penyedia, 'id_penyedia', 'nama', false);
        
        $data['pekerjaan']     = Sideveloper::makeOption($pekerjaan, 'id_pekerjaan', 'nama', false);

        $kualitas = DB::table('m_syscode')->where('code', 'KT')->get();
        $data['kualitas']     = Sideveloper::makeOption($kualitas, 'value', 'name', false);
        
        $waktu = DB::table('m_syscode')->where('code', 'KW')->get();
        $data['waktu']     = Sideveloper::makeOption($waktu, 'value', 'name', false);
        
        $layanan = DB::table('m_syscode')->where('code', 'TL')->get();
        $data['layanan']     = Sideveloper::makeOption($layanan, 'value', 'name', false);
        
        return Sideveloper::load('template', $this->view.'form', $data);
    }

    #EKSEKUSI INPUT (INSERT/UPDATE)
    public function postForm(){
        $cekppk = Sideveloper::cekPpk();
        if(!$cekppk){
            $res['api_message'] = 'Access Forbidden';
            $res['api_status']  = 0;
            return $this->api_output($res);
        }
        $id                    = $this->input('id') ? Crypt::decryptString($this->input('id')) : null;
        $tipe_form             = $this->input('tipe_form');
        $nomor_surat           = $this->input('nomor_surat','required|max:100');
        $tanggal_surat         = $this->input('tanggal_surat','required|date_format:Y-m-d');
        $hal_surat             = $this->input('hal_surat','required|max:100');
        $id_penyedia           = $this->input('id_penyedia','required');
        $id_pekerjaan          = $this->input('id_pekerjaan','required');
        $nilai_kontrak         = $this->input('nilai_kontrak','required|numeric|min:0');
        $nilai_kontrak_hps     = $this->input('nilai_kontrak_hps','required|numeric|min:0');
        $tahun_paket           = $this->input('tahun_paket','required|date_format:Y');
        $persentase_realisasi  = $this->input('persentase_realisasi','required|numeric|min:0|max:100');
        $nomor_kontrak         = $this->input('nomor_kontrak','required|max:100');
        $biaya                 = $this->input('biaya','required|numeric|min:0|max:100');
        $realisasi             = $this->input('realisasi','required|max:100');
        $kualitas              = $this->input('kualitas','required');
        $ketepatan_waktu       = $this->input('ketepatan_waktu','required');
        $tingkat_layanan       = $this->input('tingkat_layanan','required');
        $biaya_nilai           = $this->input('biaya_nilai','required');
        $realisasi_nilai       = $this->input('realisasi_nilai','required');
        $kualitas_nilai        = $this->input('kualitas_nilai','required');
        $ketepatan_waktu_nilai = $this->input('ketepatan_waktu_nilai','required');
        $tingkat_layanan_nilai = $this->input('tingkat_layanan_nilai','required');

        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }

        $save['nomor_surat']           = $nomor_surat;
        $save['tanggal_surat']         = $tanggal_surat;
        $save['hal_surat']             = $hal_surat;
        $save['id_penyedia']           = $id_penyedia;
        $save['id_pekerjaan']          = $id_pekerjaan;
        $save['nilai_kontrak']         = $nilai_kontrak;
        $save['nilai_kontrak_hps']     = $nilai_kontrak_hps;
        $save['tahun_paket']           = $tahun_paket;
        $save['persentase_realisasi']  = $persentase_realisasi;
        $save['nomor_kontrak']         = $nomor_kontrak;
        $save['biaya']                 = $biaya;
        $save['realisasi']             = $realisasi;
        $save['kualitas']              = $kualitas;
        $save['ketepatan_waktu']       = $ketepatan_waktu;
        $save['tingkat_layanan']       = $tingkat_layanan;
        $save['biaya_nilai']           = $biaya_nilai;
        $save['realisasi_nilai']       = $realisasi_nilai;
        $save['kualitas_nilai']        = $kualitas_nilai;
        $save['ketepatan_waktu_nilai'] = $ketepatan_waktu_nilai;
        $save['tingkat_layanan_nilai'] = $tingkat_layanan_nilai;
        $save['id_dinas']              = Auth::user()->id_dinas;

        if($tipe_form == 1){
            $save['created_at'] = new \DateTime();
            $save['created_by'] = Auth::user()->id;
            DB::table($this->table)->insert($save);
            $res['api_message'] = 'Berhasil Ditambahkan';
        }else if($tipe_form == 2){
            $save['updated_at'] = new \DateTime();
            $save['updated_by'] = Auth::user()->id;
            DB::table($this->table)
                ->where($this->pk, $id)
                ->update($save);
            $res['api_message'] = 'Berhasil Diubah';
        }
        $res['api_status']  = 1;
        return $this->api_output($res);
    }

    #DELETE
    // public function postHapus(){
    //     $cekppk = Sideveloper::cekPpk();
    //     if(!$cekppk){
    //         $res['api_message'] = 'Access Forbidden';
    //         $res['api_status']  = 0;
    //         return $this->api_output($res);
    //     }
    //     $id           = $this->input('id');
    //     $save['deleted_at'] = new \DateTime();
    //     $save['deleted_by'] = Auth::user()->id;
    //     DB::table($this->table)
    //         ->where($this->pk, $id)
    //         ->update($save);

    //     $res['api_message'] = 'Berhasil Dihapus';
    //     $res['api_status']  = 1;
    //     return $this->api_output($res);
    // }
    
    
    public function postHapus(){
        $cekppk = Sideveloper::cekPpk();
        if(!$cekppk){
            $res['api_message'] = 'Access Forbidden';
            $res['api_status']  = 0;
            return $this->api_output($res);
        }
        $id = $this->input('id','required');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }
        try {
            DB::table($this->table)->where($this->pk, $id)->delete();
            $res['api_status']  = 1;
            $res['api_message'] = 'Data Berhasil dihapus';
            return $this->api_output($res);
        }catch (\Illuminate\Database\QueryException $e) {
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Terjadi masalah!';
            return $this->api_output($res);
        } catch (PDOException $e) {
            $res['api_status']  = 0;
            $res['api_message'] = 'Error';
            return $this->api_output($res);
        }
    }

    /**
     * LAPORAN
     */

    public function getLaporan(){
        $data['title'] = 'Laporan '.$this->title;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl(''), 'title'=> $this->title]
        ];
        $year = [];
        $k = 0;
        for ($i='2018'; $i < date('Y') + 2; $i++) { 
            $year[$k]['value'] = $i;
            $year[$k]['name'] = $i;
            $k++;
        }
        $data['year'] = $year;

        $penyedia   = Sideveloper::getPenyedia()->get();
        $data['penyedia'] = Sideveloper::makeOption($penyedia, 'id_penyedia', 'nama', true);

        $dinas   = Sideveloper::getDinas()->get();
        $data['dinas'] = Sideveloper::makeOption($dinas, 'id_dinas', 'nama', true);

        return Sideveloper::load('template', $this->view.'laporan', $data);
    }

    #EXPORT EXCEL
    public function getExportReport(){
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $id_penyedia = $this->input('id_penyedia');
        $tahun_paket = $this->input('tahun_paket');
        $id_dinas    = $this->input('id_dinas');
        $nilai_min   = $this->input('nilai_min');
        $nilai_max   = $this->input('nilai_max');
        $tgl_start   = $this->input('tgl_start');
        $tgl_end     = $this->input('tgl_end');

        $title = 'Laporan Penilaian';

        $query = DB::table($this->table)
            ->select(
                'm_penyedia.alamat','users.nama as nama_ppk', 'users.nip',
                'm_penyedia.nama as nama_penyedia', 'npwp', 'nomor_siup',
                'm_dinas.nama as nama_dinas','m_dinas.alamat as alamat_dinas', 'm_dinas.no_telp', 'nomor_surat', 'tanggal_surat', 'hal_surat',
                'pekerjaan.nama as nama_pekerjaan', 'nilai_kontrak', 'nilai_kontrak_hps', 'tahun_paket', 'persentase_realisasi', 'nomor_kontrak',
                'biaya', 'realisasi', 'kt.name as kualitas', 'kw.name as ketepatan_waktu', 'tl.name as tingkat_layanan',
                'biaya_nilai', 'realisasi_nilai', 'kualitas_nilai', 'ketepatan_waktu_nilai', 'tingkat_layanan_nilai',
                DB::raw('biaya_nilai + realisasi_nilai + kualitas_nilai + ketepatan_waktu_nilai + tingkat_layanan_nilai as nilai'),
                'id_transaksi')
            ->join('m_penyedia', 'm_penyedia.id_penyedia', '=', 'transaksi.id_penyedia')
            ->join('m_dinas', 'm_dinas.id_dinas', '=', 'transaksi.id_dinas')
            ->join('pekerjaan', 'pekerjaan.id_pekerjaan', '=', 'transaksi.id_pekerjaan')
            ->join('users', 'users.id', '=', 'transaksi.created_by')
            ->join('m_syscode as kt', function($query){
                $query->on('kt.value', '=', 'transaksi.kualitas')
                    ->on('kt.code', '=', DB::raw("'KT'"));
            })
            ->join('m_syscode as kw', function($query){
                $query->on('kw.value', '=', 'transaksi.ketepatan_waktu')
                    ->on('kw.code', '=', DB::raw("'KW'"));
            })
            ->join('m_syscode as tl', function($query){
                $query->on('tl.value', '=', 'transaksi.tingkat_layanan')
                    ->on('tl.code', '=', DB::raw("'TL'"));
            });

        if($id_penyedia)
            $query->where('transaksi.id_penyedia', $id_penyedia);

        if(Auth::user()->id_dinas){
            $query->where('transaksi.id_dinas', Auth::user()->id_dinas);
        }else{
            if($id_dinas)
                $query->where('transaksi.id_dinas', $id_dinas);
        }

        if(isset($nilai_min) && isset($nilai_max) && ($nilai_min <= $nilai_max)){
            $query->whereBetween(DB::raw('biaya_nilai + realisasi_nilai + kualitas_nilai + ketepatan_waktu_nilai + tingkat_layanan_nilai'), [$nilai_min, $nilai_max]);
        }

        if(isset($tgl_start)&&isset($tgl_end) && ($tgl_start <= $tgl_end)){
            $query->whereBetween('tanggal_surat', [$tgl_start, $tgl_end]);
        }

        $data = $query->get();

        #SET TITLE
        $spreadsheet->getProperties()->setCreator(Sideveloper::config('appname'))
            ->setTitle($title);
        $spreadsheet->getActiveSheet()->setTitle($title);

        #VALUE EXCEL
        $sheet = $spreadsheet->setActiveSheetIndex(0);

        #SET PROPERTIES
        $nama_dinas    = $id_dinas ? DB::table('m_dinas')->where('id_dinas', $id_dinas)->value('nama') : ' Semua Dinas ';
        $nama_penyedia = $id_penyedia ? DB::table('m_penyedia')->where('id_penyedia', $id_penyedia)->value('nama') : ' Semua Penyedia ';
        $sheet->setCellValue('B2', 'Dinas')->setCellValue('C2',':')->setCellValue('D2', $nama_dinas);
        $sheet->setCellValue('B3', 'Penyedia')->setCellValue('C3',':')->setCellValue('D3', $nama_penyedia);
        $sheet->setCellValue('B4', 'Tahun Paket')->setCellValue('C4',':')->setCellValue('D4', $tahun_paket);
        $sheet->setCellValue('B5', 'Range Nilai')->setCellValue('C5',':')->setCellValue('D5', $nilai_min . ' s/d ' . $nilai_max);
        $sheet->setCellValue('B6', 'Range Tanggal Surat')->setCellValue('C6',':')->setCellValue('D6', Sideveloper::date($tgl_start) . ' s/d ' . Sideveloper::date($tgl_end));


        #SET HEADER
        $sheet->setCellValue('B10', 'NAMA DINAS')
              ->setCellValue('C10', 'NAMA PENYEDIA')
              ->setCellValue('D10', 'NOMOR SURAT')
              ->setCellValue('E10', 'TANGGAL SURAT')
              ->setCellValue('F10', 'HAL SURAT')

              ->setCellValue('G10', 'DATA PAKET PEKERJAAN')
              ->setCellValue('G11', 'PAKET PEKERJAAN')
              ->setCellValue('H11', 'TAHUN PAKET')
              ->setCellValue('I11', 'NILAI KONTRAK')
              ->setCellValue('J11', 'NILAI KONTRAK HPS')
              ->setCellValue('K11', 'PERSENTASE REALISASI PEKERJAAN')
              ->setCellValue('L11', 'NOMOR KONTRAK')

              ->setCellValue('M10', 'INFORMASI KINERJA')
              ->setCellValue('M11', 'BIAYA')
              ->setCellValue('N11', 'REALISASI PEKERJAAN')
              ->setCellValue('O11', 'KUALITAS PEKERJAAN')
              ->setCellValue('P11', 'KETEPATAN WAKTU')
              ->setCellValue('Q11', 'TINGKAT LAYANAN')
              
              ->setCellValue('R10', 'NILAI KINERJA')
              ->setCellValue('R11', 'BIAYA')
              ->setCellValue('S11', 'REALISASI PEKERJAAN')
              ->setCellValue('T11', 'KUALITAS PEKERJAAN')
              ->setCellValue('U11', 'KETEPATAN WAKTU')
              ->setCellValue('V11', 'TINGKAT LAYANAN')
              ->setCellValue('W10', 'TOTAL NILAI');
        $sheet->mergeCells("B10:B11")
              ->mergeCells("C10:C11")
              ->mergeCells("D10:D11")
              ->mergeCells("E10:E11")
              ->mergeCells("F10:F11")
              ->mergeCells("G10:L10")
              ->mergeCells("M10:Q10")
              ->mergeCells("R10:V10")
              ->mergeCells("W10:W11");

        #SET VALUE
        $i = 12;
        foreach($data as $d){
            $sheet->setCellValue('B'.$i, $d->nama_dinas)
                  ->setCellValue('C'.$i, $d->nama_penyedia)
                  ->setCellValue('D'.$i, $d->nomor_surat)
                  ->setCellValue('E'.$i, $d->tanggal_surat)
                  ->setCellValue('F'.$i, $d->hal_surat)
                  ->setCellValue('G'.$i, $d->nama_pekerjaan)
                  ->setCellValue('H'.$i, $d->tahun_paket)
                  ->setCellValue('I'.$i, $d->nilai_kontrak)
                  ->setCellValue('J'.$i, $d->nilai_kontrak_hps)
                  ->setCellValue('K'.$i, $d->persentase_realisasi)
                  ->setCellValue('L'.$i, $d->nomor_kontrak)
                  ->setCellValue('M'.$i, $d->biaya)
                  ->setCellValue('N'.$i, $d->realisasi)
                  ->setCellValue('O'.$i, $d->kualitas)
                  ->setCellValue('P'.$i, $d->ketepatan_waktu)
                  ->setCellValue('Q'.$i, $d->tingkat_layanan)
                  ->setCellValue('R'.$i, $d->biaya_nilai)
                  ->setCellValue('S'.$i, $d->realisasi_nilai)
                  ->setCellValue('T'.$i, $d->kualitas_nilai)
                  ->setCellValue('U'.$i, $d->ketepatan_waktu_nilai)
                  ->setCellValue('V'.$i, $d->tingkat_layanan_nilai)
                  ->setCellValue('W'.$i, "=SUM(R$i:V$i)");
            $i++;
        }

        $sheet->getStyle('B10:W11')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B10:W11')->getAlignment()->setVertical('center');
        $sheet->getStyle('B10:W11')->getFont()->setBold(true);
        for ($z='A'; $z <= 'W' ; $z++) { 
            $sheet->getColumnDimension($z)->setAutoSize(TRUE);
        }

        #OUTPUT EXCEL
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$title.'.xlsx"');
        $writer->save("php://output");
    }

    public function getPekerjaan(){
        $data['title'] = 'Pekerjaan';
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('pekerjaan'), 'title'=> 'Pekerjaan']
        ];

        $jenis   = DB::table('m_syscode')->where('code','JEP')->get();
        $data['jenis'] = Sideveloper::makeOption($jenis, 'value', 'name', true);
        
        $sumber   = DB::table('m_syscode')->where('code','SB')->get();
        $data['sumber'] = Sideveloper::makeOption($sumber, 'value', 'name', true);
        
        $dinas   = Sideveloper::getDinas()->get();
        $data['dinas'] = Sideveloper::makeOption($dinas, 'id_dinas', 'nama', true);
        return Sideveloper::load('template', $this->view.'pekerjaan-view', $data);
    }

    
    public function getPekerjaanTable(){
        $id_jenis_pengadaan = $this->input('id_jenis_pengadaan');
        $id_sumber          = $this->input('id_sumber');
        $id_dinas           = $this->input('id_dinas');
        $status           = $this->input('status');

        $query = DB::table('pekerjaan')
            ->select('pekerjaan.id_pekerjaan', 'm_dinas.nama as nama_dinas', 'jep.name as jenis_pengadaan', 
                'sb.name as sumber', 'pekerjaan.nama', 'tahun_anggaran', 'nilai_pagu', DB::raw("CASE WHEN id_transaksi THEN 'Selesai' ELSE 'Belum Selesai' END AS status"))
            ->join('m_dinas', 'm_dinas.id_dinas', '=', 'pekerjaan.id_dinas')
            ->leftJoin('transaksi', 'transaksi.id_pekerjaan', '=', 'pekerjaan.id_pekerjaan')
            ->join('m_syscode as jep', function($q){
                $q->on('jep.code', '=', DB::raw("'JEP'"));
                $q->on('jep.value', '=', 'pekerjaan.id_jenis_pengadaan');
            })
            ->join('m_syscode as sb', function($q){
                $q->on('sb.code', '=', DB::raw("'SB'"));
                $q->on('sb.value', '=', 'pekerjaan.id_sumber');
            });
        
        if($id_jenis_pengadaan)
            $query->where('pekerjaan.id_jenis_pengadaan', $id_jenis_pengadaan);
        if($id_sumber)
            $query->where('pekerjaan.id_sumber', $id_sumber);
        if($id_dinas)
            $query->where('pekerjaan.id_dinas', $id_dinas);

        if($status){
            if($status == 1)
                $query->whereNotNull('id_transaksi');
                
            if($status == 2)
                $query->whereNull('id_transaksi');
        }
        // $query->dd();

        return datatables()->of($query)->toJson();
    }

    public function getPekerjaanForm(){
        $id   = $this->input('id',"numeric|exists:pekerjaan,id_pekerjaan");

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }


        $data['title'] = 'Tambah Pekerjaan';
        $data['tipe']  = 1;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('pekerjaan'), 'title'=>'Pekerjaan'],
            ['link' => '#', 'title'=> 'Tambah'],
        ];
        if($id){
            $data['title'] = 'Ubah Pekerjaan';
            $data['tipe']  = 2;
            $data['breadcrumbs'] = [
                ['link' => Sideveloper::selfUrl('pekerjaan'), 'title'=> 'Pekerjaan'],
                ['link' => '#', 'title'=> 'Ubah'],
            ];
            $data['data']  = DB::table('pekerjaan')->where('id_pekerjaan', $id)->first();
        }

        $jenis   = DB::table('m_syscode')->where('code','JEP')->get();
        $data['jenis'] = Sideveloper::makeOption($jenis, 'value', 'name', false);
        
        $sumber   = DB::table('m_syscode')->where('code','SB')->get();
        $data['sumber'] = Sideveloper::makeOption($sumber, 'value', 'name', false);
        
        $dinas   = Sideveloper::getDinas()->get();
        $data['dinas'] = Sideveloper::makeOption($dinas, 'id_dinas', 'nama', false);

        
        $year = [];
        $k = 0;
        for ($i='2018'; $i < date('Y') + 2; $i++) { 
            $year[$k]['value'] = $i;
            $year[$k]['name'] = $i;
            $k++;
        }
        $data['year'] = $year;

        return Sideveloper::load('template', $this->view.'pekerjaan-form', $data);
    }
    
    #EKSEKUSI INPUT (INSERT/UPDATE)
    public function postPekerjaanForm(){
        $id                 = $this->input('id') ? Crypt::decryptString($this->input('id')) : null;
        $tipe_form          = $this->input('tipe_form');
        $id_dinas           = $this->input('id_dinas','required');
        $nama               = $this->input('nama','required|max:200');
        $uraian             = $this->input('uraian','required|max:500');
        $tahun_anggaran     = $this->input('tahun_anggaran','required');
        $nilai_pagu         = $this->input('nilai_pagu','required|numeric|min:0');
        $id_sumber          = $this->input('id_sumber','required');
        $id_jenis_pengadaan = $this->input('id_jenis_pengadaan','required');
        $pemanfaatan_barang = $this->input('pemanfaatan_barang','required');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }

        $save['id_dinas']           = $id_dinas;
        $save['nama']               = $nama;
        $save['uraian']             = $uraian;
        $save['tahun_anggaran']     = $tahun_anggaran;
        $save['nilai_pagu']         = $nilai_pagu;
        $save['id_sumber']          = $id_sumber;
        $save['id_jenis_pengadaan'] = $id_jenis_pengadaan;
        $save['pemanfaatan_barang'] = $pemanfaatan_barang;

        if($tipe_form == 1){
            DB::table('pekerjaan')->insert($save);
            $res['api_message'] = 'Berhasil Ditambahkan';
        }else if($tipe_form == 2){
            DB::table('pekerjaan')
                ->where('id_pekerjaan', $id)
                ->update($save);
            $res['api_message'] = 'Berhasil Diubah';
        }
        $res['api_status']  = 1;
        return $this->api_output($res);
    }
    
    public function postPekerjaanHapus(){
        $id = $this->input('id','required');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }
        try {
            DB::table('pekerjaan')->where('id_pekerjaan', $id)->delete();
            $res['api_status']  = 1;
            $res['api_message'] = 'Data Berhasil dihapus';
            return $this->api_output($res);
        }catch (\Illuminate\Database\QueryException $e) {
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Terjadi masalah!';
            return $this->api_output($res);
        } catch (PDOException $e) {
            $res['api_status']  = 0;
            $res['api_message'] = 'Error';
            return $this->api_output($res);
        }
    }
}