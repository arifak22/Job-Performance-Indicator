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
use Pel;
use URL;
use Mail;
use Carbon;
use Sideveloper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;

class IndexController extends MiddleController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    var $title = 'Home';

    public function getIndex(){        
        $id_dinas = $this->input('id_dinas');
        $start    = $this->input('start') ? $this->input('start') : date('Y-m', strtotime("-6 month"));
        $end      = $this->input('end') ? $this->input('end') : date('Y-m');

        $data['title']    = $this->title;
        
        $dinas   =  DB::table('m_dinas')->get();
        $data['dinas'] = Sideveloper::makeOption($dinas, 'id_dinas', 'nama', true);
        
        $data['start'] = $start;
        $data['end']   = $end;

        #JUMLAH PENYEDIA
        $query_penyedia = DB::table('transaksi')
            ->select(DB::raw("count(id_transaksi) as jml, id_penyedia"))
            ->groupBy('id_penyedia');
        if($id_dinas)
            $query_penyedia->where('id_dinas', $id_dinas);
        $query_penyedia->whereBetween(DB::raw("DATE_FORMAT(tanggal_surat, '%Y-%m')"), [$start, $end]);
        $data['jumlah_penyedia'] = count($query_penyedia->get());
        // print_r($data['jumlah_penyedia']);die();

        #PAKET PEKERJAAN
        $query_paket = DB::table('transaksi');
        if($id_dinas)
            $query_paket->where('id_dinas', $id_dinas);
        $query_paket->whereBetween(DB::raw("DATE_FORMAT(tanggal_surat, '%Y-%m')"), [$start, $end]);
        $data['jumlah_paket'] = $query_paket->count();

        $data['periode']  = json_encode($this->period($start, $end));
        $pertumbuhan = [];
        
        #PAKET PEKERJAAN TERAKHIR
        $query_pekerjaan = DB::table('pekerjaan');
        if($id_dinas)
            $query_pekerjaan->where('id_dinas', $id_dinas);
        $query_pekerjaan->whereBetween('tahun_anggaran', [substr($start,0, 4), substr($end,0, 4)]);
        $data['jumlah_pekerjaan'] = $query_pekerjaan->count();

        #PERTUMBUHAN
        foreach($this->period($start, $end, 'format') as $ym){
            $query_pertumbuhan = DB::table('transaksi');
            if($id_dinas)
                $query_pertumbuhan->where('id_dinas', $id_dinas);
            $query_pertumbuhan->where(DB::raw("DATE_FORMAT(tanggal_surat, '%Y%m')"), $ym);

            $pertumbuhan[] = $query_pertumbuhan->count();
        }
        $data['pertumbuhan'] = json_encode($pertumbuhan);
        return Sideveloper::load('template-full', 'home/index', $data);
    }

    public function getRankingTable(){
        $id_dinas = $this->input('id_dinas');
        $start    = $this->input('start') ? $this->input('start') : date('Y-m', strtotime("-6 month"));
        $end      = $this->input('end') ? $this->input('end') : date('Y-m');
        // DB::statement(DB::raw('set @row_number=-1'));
        $query = DB::table(DB::raw("(SELECT @rowid := 0) dummy, vranking"))
            ->select(DB::raw("vranking.*, @rowid := @rowid + 1 AS num"));
    
        if($id_dinas)
            $query->where('vranking.id_dinas', $id_dinas);

        $query->whereBetween('periode', [$start, $end]);
        return datatables()->of($query)->toJson();
    }
    
    public function getPenyediaTable(){
        $id_dinas = $this->input('id_dinas');
        $start    = $this->input('start') ? $this->input('start') : date('Y-m', strtotime("-6 month"));
        $end      = $this->input('end') ? $this->input('end') : date('Y-m');

        // DB::statement(DB::raw('set @rownum=-1'));
        $query = DB::table(DB::raw("(SELECT @rowid := 0) dummy, vpenyedia"))
            ->select(DB::raw("vpenyedia.*, @rowid := @rowid + 1 AS num"));
        if($id_dinas)
            $query->where('vpenyedia.id_dinas', $id_dinas);

        $query->whereBetween('periode', [$start, $end]);
        return datatables()->of($query)->toJson();
    }

    public function period($start, $end, $return = 'default')
    {
        $date1  = $start;
        $date2  = $end;
        $output = [];
        $format = [];
        $time   = strtotime($date1);
        $last   = date('Ym', strtotime($date2));

        do {
            $month = date('Ym', $time);

            $output[] = Sideveloper::datePeriode($month);
            $format[] =$month;
            $time = strtotime('+1 month', $time);
        } while ($month != $last);
        if($return == 'default')
            return $output;

        return $format;
    }

    
    public function postUbahPassword()
    {
        $passlama  = $this->input('passlama','required');
        $passbaru1 = $this->input('passbaru1','required');
        $passbaru2 = $this->input('passbaru2','required');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }
        
        if (!Hash::check($passlama, Auth::user()->password)) {
            $res['api_status']  = 0;
            $res['api_message'] = 'Password lama tidak sesuai';
            return $this->api_output($res);
        }
        if(!($passbaru1 == $passbaru2)){
            $res['api_status']  = 0;
            $res['api_message'] = 'Konfirmasi password baru tidak match';
            return $this->api_output($res);
        }

        $save['password']   = Hash::make($passbaru1);
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update($save);
        $res['api_status']  = 1;
        $res['api_message'] = 'Password berhasil diganti';
        return $this->api_output($res);
    }
}