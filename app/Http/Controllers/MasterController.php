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

class MasterController extends MiddleController
{
    
    var $view  = 'master.';
    var $title = 'Master';

    /**
     * USER
     */
    public function getUser(){
        $data['title'] = $this->title . ' User';
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('user'), 'title'=> $this->title . ' User']
        ];
        $dinas   = Sideveloper::getDinas()->get();
        $data['dinas'] = Sideveloper::makeOption($dinas, 'id_dinas', 'nama', true);
        
        $privilege   = DB::table('privileges')->get();
        $data['privilege'] = Sideveloper::makeOption($privilege, 'id_privilege', 'nama_privilege', true);

        return Sideveloper::load('template', $this->view.'user-view', $data);
    }

    public function getUserTable(){
        $id_dinas     = $this->input('id_dinas');
        $id_privilege = $this->input('id_privilege');

        $query = DB::table('users')
            ->select('id', 'username', 'users.nama', DB::raw("coalesce(m_dinas.nama, 'Seluruh Dinas') as nama_dinas"), 'nama_privilege', 'nip')
            ->leftJoin('m_dinas', 'm_dinas.id_dinas', '=', 'users.id_dinas')
            ->join('privileges', 'privileges.id_privilege', '=', 'users.id_privilege');
        
        if($id_dinas){
            $query->where(function($q) use($id_dinas){
                $q->where('users.id_dinas', $id_dinas);
                $q->orWhereNull('users.id_dinas');
            });
        }

            
        if($id_privilege && count($id_privilege)>0)
            $query->whereIn('users.id_privilege', $id_privilege);

        return datatables()->of($query)->toJson();
    }

    #FORM INPUT (INSERT/UPDATE)
    public function getUserForm(){
        $id   = $this->input('id',"numeric|exists:users,id");

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }


        $data['title'] = 'Tambah '.$this->title .' User';
        $data['tipe']  = 1;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('user'), 'title'=> $this->title .' User'],
            ['link' => '#', 'title'=> 'Tambah'],
        ];
        if($id){
            $data['title'] = 'Ubah '.$this->title.' User';
            $data['tipe']  = 2;
            $data['breadcrumbs'] = [
                ['link' => Sideveloper::selfUrl('user'), 'title'=> $this->title.' User'],
                ['link' => '#', 'title'=> 'Ubah'],
            ];
            $data['data']  = DB::table('users')->where('id', $id)->first();

        }
        $dinas   = Sideveloper::getDinas()->get();
        $data['dinas'] = Sideveloper::makeOption($dinas, 'id_dinas', 'nama', true);
        
        $privilege   = DB::table('privileges')->get();
        $data['privilege'] = Sideveloper::makeOption($privilege, 'id_privilege', 'nama_privilege', false);

        
        return Sideveloper::load('template', $this->view.'user-form', $data);
    }

    #EKSEKUSI INPUT (INSERT/UPDATE)
    public function postUserForm(){
        $id           = $this->input('id') ? Crypt::decryptString($this->input('id')) : null;
        $tipe_form    = $this->input('tipe_form');
        $nama         = $this->input('nama','required|max:200');
        $nip          = $this->input('nip','required|max:100');
        $golongan     = $this->input('golongan','required|max:100');
        $no_hp        = $this->input('no_hp','required|max:12');
        $email        = $this->input('email','required|max:200');
        $id_privilege = $this->input('id_privilege','required');
        if($id_privilege == 2 || $id_privilege == 4){
            $id_dinas     = $this->input('id_dinas');
        }else{
            $id_dinas     = $this->input('id_dinas', 'required');
        }
        if($tipe_form == 1){
            $username     = $this->input('username','required|max:50');
            $password     = $this->input('password','required');

            $cek_exist = DB::table('users')->where('username', $username)->count();
            if($cek_exist > 0){
                $res['api_message'] = 'Username sudah terdaftar';
                $res['api_status']  = 0;
                return $this->api_output($res);
            }
        }

        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }

        $save['nama']         = $nama;
        $save['nip']          = $nip;
        $save['golongan']     = $golongan;
        $save['no_hp']        = $no_hp;
        $save['email']        = $email;
        $save['id_dinas']     = $id_dinas;
        $save['id_privilege'] = $id_privilege;

        if($tipe_form == 1){
            $save['username']     = $username;
            $save['password']     = Hash::make($password);
            DB::table('users')->insert($save);
            $res['api_message'] = 'Berhasil Ditambahkan';
        }else if($tipe_form == 2){
            DB::table('users')
                ->where('id', $id)
                ->update($save);
            $res['api_message'] = 'Berhasil Diubah';
        }
        $res['api_status']  = 1;
        return $this->api_output($res);
    }

    public function postUserHapus(){
        $id = $this->input('id','required');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }
        try {
            DB::table('users')->where('id', $id)->delete();
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

    public function getUserDetail(){
        $id   = $this->input('id',"required|numeric|exists:users,id");
        $from = $this->input('from', 'required');

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }

        $data['data'] = DB::table('users')
            ->select('nama_privilege', DB::raw("coalesce(m_dinas.nama, 'Seluruh Dinas') as nama_dinas"), 
                'username', 'users.nama', 'nip', 'golongan', 'no_hp', 'email', 'user_ppk')
            ->leftJoin('m_dinas', 'm_dinas.id_dinas', '=', 'users.id_dinas')
            ->join('privileges', 'privileges.id_privilege', '=', 'users.id_privilege')
            ->where('id', $id)
            ->first();

        $data['title'] = 'Detail ' .$this->title .' User';
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('user'), 'title'=> $this->title .' User'],
            ['link' => '#', 'title'=> 'Detail'],
        ];

        return Sideveloper::load('template', $this->view.'user-detail', $data);
    }

    public function postUserReset(){
        $id   = $this->input('id',"required|numeric|exists:users,id");

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }
        $save['password'] = Hash::make('123456');
        DB::table('users')
            ->where('id', $id)
            ->update($save);
            
        $res['api_status']  = 1;
        $res['api_message'] = 'Berhasil Di reset ke 123456';
        return $this->api_output($res);
    }

    
    /**
     * DINAS
     */
    public function getDinas(){
        $data['title'] = $this->title . ' Dinas';
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('dinas'), 'title'=> $this->title . ' Dinas']
        ];

        return Sideveloper::load('template', $this->view.'dinas-view', $data);
    }

    public function getDinasTable(){
        $query = DB::table('m_dinas')
            ->select('m_dinas.id_dinas', 'nama_lengkap', 'm_dinas.nama', 'm_dinas.no_telp', 'm_dinas.alamat', DB::raw("count(id) as jumlah_user"))
            ->leftJoin('users', 'users.id_dinas', '=', 'm_dinas.id_dinas')
            ->groupBy(DB::raw("m_dinas.id_dinas, nama_lengkap, m_dinas.nama, m_dinas.no_telp, m_dinas.alamat"));

        return datatables()->of($query)->toJson();
    }

    #FORM INPUT (INSERT/UPDATE)
    public function getDinasForm(){
        $id   = $this->input('id',"numeric|exists:m_dinas,id_dinas");

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }


        $data['title'] = 'Tambah '.$this->title .' Dinas';
        $data['tipe']  = 1;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('dinas'), 'title'=> $this->title .' Dinas'],
            ['link' => '#', 'title'=> 'Tambah'],
        ];
        if($id){
            $data['title'] = 'Ubah '.$this->title.' Dinas';
            $data['tipe']  = 2;
            $data['breadcrumbs'] = [
                ['link' => Sideveloper::selfUrl('dinas'), 'title'=> $this->title.' Dinas'],
                ['link' => '#', 'title'=> 'Ubah'],
            ];
            $data['data']  = DB::table('m_dinas')->where('id_dinas', $id)->first();

        }
        return Sideveloper::load('template', $this->view.'dinas-form', $data);
    }

    #EKSEKUSI INPUT (INSERT/UPDATE)
    public function postDinasForm(){
        $id           = $this->input('id') ? Crypt::decryptString($this->input('id')) : null;
        $tipe_form    = $this->input('tipe_form');
        $nama_lengkap = $this->input('nama_lengkap','required|max:200');
        $nama         = $this->input('nama','required|max:55');
        $alamat       = $this->input('alamat','required|max:255');
        $no_telp      = $this->input('no_telp','required|max:20');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }

        $save['nama']         = $nama;
        $save['nama_lengkap'] = $nama_lengkap;
        $save['alamat']       = $alamat;
        $save['no_telp']      = $no_telp;

        if($tipe_form == 1){
            DB::table('m_dinas')->insert($save);
            $res['api_message'] = 'Berhasil Ditambahkan';
        }else if($tipe_form == 2){
            DB::table('m_dinas')
                ->where('id_dinas', $id)
                ->update($save);
            $res['api_message'] = 'Berhasil Diubah';
        }
        $res['api_status']  = 1;
        return $this->api_output($res);
    }

    public function postDinasHapus(){
        $id = $this->input('id','required');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }
        try {
            DB::table('m_dinas')->where('id_dinas', $id)->delete();
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

    public function getDinasUser(){
        $id   = $this->input('id',"required|numeric|exists:m_dinas,id_dinas");

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }

        $m_dinas = DB::table('m_dinas')->where('id_dinas', $id)->first();
        $data['title'] = 'User '. $m_dinas->nama;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('dinas'), 'title'=> 'Master Dinas'],
            ['link' => '#', 'title'=> 'User '. $m_dinas->nama],
        ];
        $data['data'] = $m_dinas;
        
        $dinas   = Sideveloper::getDinas()->get();
        $data['dinas'] = Sideveloper::makeOption($dinas, 'id_dinas', 'nama', true);
        
        $privilege   = DB::table('privileges')->whereNotIn('id_privilege', [2,4])->get();
        $data['privilege'] = Sideveloper::makeOption($privilege, 'id_privilege', 'nama_privilege', false);

        $data['tipe'] = 1;
        return Sideveloper::load('template', $this->view.'dinas-user-view', $data);
    }

    public function getUserId(){
        $id   = $this->input('id',"required|numeric|exists:users,id");
        
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }
        $data['data'] = DB::table('users')->where('id', $id)->first();
        $data['id']   = Crypt::encryptString($id);
        return $this->api_output($data);
    }

    /**
     * PENYEDIA
     */
    public function getPenyedia(){
        $data['title'] = $this->title . ' Penyedia';
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('penyedia'), 'title'=> $this->title . ' Penyedia']
        ];

        $jenis   = DB::table('m_syscode')->where('code','JP')->get();
        $data['jenis'] = Sideveloper::makeOption($jenis, 'value', 'name', true);


        return Sideveloper::load('template', $this->view.'penyedia-view', $data);
    }

    public function getPenyediaTable(){
        $id_jenis     = $this->input('id_jenis');

        $query = DB::table('m_penyedia')
            ->select('id_penyedia', 'm_syscode.name as nama_jenis', 'm_penyedia.nama', 'npwp', 'nomor_siup', 'no_telp', 'email')
            ->join('m_syscode', function($q){
                $q->on('m_syscode.code', '=', DB::raw("'JP'"));
                $q->on('m_syscode.value', '=', 'm_penyedia.id_jenis');
            });
        
        if($id_jenis)
            $query->where('m_penyedia.id_jenis', $id_jenis);

        return datatables()->of($query)->toJson();
    }    

    public function getPenyediaDetail(){
        $id   = $this->input('id',"required|numeric|exists:m_penyedia,id_penyedia");
        $from = $this->input('from', 'required');

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }

        $data['data'] = DB::table('m_penyedia')
            ->join('m_syscode', function($q){
                $q->on('m_syscode.code', '=', DB::raw("'JP'"));
                $q->on('m_syscode.value', '=', 'm_penyedia.id_jenis');
            })
            ->where('id_penyedia', $id)
            ->first();

        $data['title'] = 'Detail ' .$this->title .' Penyedia';
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('penyedia'), 'title'=> $this->title .' Penyedia'],
            ['link' => '#', 'title'=> 'Detail'],
        ];

        return Sideveloper::load('template', $this->view.'penyedia-detail', $data);
    }

    #FORM INPUT (INSERT/UPDATE)
    public function getPenyediaForm(){
        $id   = $this->input('id',"numeric|exists:m_penyedia,id_penyedia");

        #CEK VALID
        if($this->validatorView()){
            return  $this->validatorView(true);
        }


        $data['title'] = 'Tambah '.$this->title .' Penyedia';
        $data['tipe']  = 1;
        $data['breadcrumbs'] = [
            ['link' => Sideveloper::selfUrl('penyedia'), 'title'=> $this->title .' Penyedia'],
            ['link' => '#', 'title'=> 'Tambah'],
        ];
        if($id){
            $data['title'] = 'Ubah '.$this->title.' Penyedia';
            $data['tipe']  = 2;
            $data['breadcrumbs'] = [
                ['link' => Sideveloper::selfUrl('penyedia'), 'title'=> $this->title.' Penyedia'],
                ['link' => '#', 'title'=> 'Ubah'],
            ];
            $data['data']  = DB::table('m_penyedia')->where('id_penyedia', $id)->first();
        }
        
        $jenis   = DB::table('m_syscode')->where('code','JP')->get();
        $data['jenis'] = Sideveloper::makeOption($jenis, 'value', 'name', false);

        return Sideveloper::load('template', $this->view.'penyedia-form', $data);
    }

    #EKSEKUSI INPUT (INSERT/UPDATE)
    public function postPenyediaForm(){
        $id              = $this->input('id') ? Crypt::decryptString($this->input('id')) : null;
        $tipe_form       = $this->input('tipe_form');
        $nama            = $this->input('nama','required|max:200');
        $npwp            = $this->input('npwp','required|max:200');
        $nomor_siup      = $this->input('nomor_siup','required|max:200');
        $id_jenis        = $this->input('id_jenis','required');
        $email           = $this->input('email','required|max:200');
        $alamat          = $this->input('alamat','required|max:500');
        $no_telp         = $this->input('no_telp','required|max:20');
        $sarana          = $this->input('sarana','required|max:500');
        $modal           = $this->input('modal','required|min:0');
        $jumlah_personil = $this->input('jumlah_personil','required|max:800');
        $nama_direktur   = $this->input('nama_direktur','required|max:100');
        $nama_komisaris  = $this->input('nama_komisaris','required|max:100');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }
        // dd(Request::file());
        $config['allowed_type'] = 'pdf';
        $config['max_size']     = '512';
        $config['required']     = $tipe_form == 2 ? false : true;
        $akta = $this->uploadFile('akta', 'penyedia', 'akta-'.$nama.$npwp, $config);
        if(!$akta['is_uploaded']){
            return $this->api_output($akta['msg']);
        }

        $config['max_size']     = '1024';
        $nib = $this->uploadFile('nib', 'penyedia', 'nib-'.$nama.$npwp, $config);
        if(!$nib['is_uploaded']){
            return $this->api_output($nib['msg']);
        }

        $save['nama']            = $nama;
        $save['npwp']            = $npwp;
        $save['nomor_siup']      = $nomor_siup;
        $save['id_jenis']        = $id_jenis;
        $save['email']           = $email;
        $save['alamat']          = $alamat;
        $save['no_telp']         = $no_telp;
        $save['sarana']          = $sarana;
        $save['modal']           = $modal;
        $save['jumlah_personil'] = $jumlah_personil;
        $save['nama_direktur']   = $nama_direktur;
        $save['nama_komisaris']  = $nama_komisaris;
        if($akta['filename'])
        $save['akta']            = $akta['filename'];
        if($nib['filename'])
        $save['nib']             = $nib['filename'];

        if($tipe_form == 1){
            DB::table('m_penyedia')->insert($save);
            $res['api_message'] = 'Berhasil Ditambahkan';
        }else if($tipe_form == 2){
            DB::table('m_penyedia')
                ->where('id_penyedia', $id)
                ->update($save);
            $res['api_message'] = 'Berhasil Diubah';
        }
        $res['api_status']  = 1;
        return $this->api_output($res);
    }

    public function postPenyediaHapus(){
        $id = $this->input('id','required');
        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }
        try {
            DB::table('m_penyedia')->where('id_penyedia', $id)->delete();
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