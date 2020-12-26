<?php
	
	namespace App\Helpers;
	
	use App;
	use Cache;
	use Config;
	use DB;
	use Excel;
	use File;
	use Hash;
	use Log;
	use Mail;
	use PDF;
	use Request;
	use Route;
	use Session;
	use Storage;
	use Schema;
	use Validator;
	use Auth;
	use Carbon;
	
	class Sideveloper
	{

		#CONFIG APLIKASI
		public static function config($parameter, $app = 'fuel-supply'){

			$config = array(
				'appname'        => 'UKPBJ Karimun',
				'logo'           => url('assets/_custom/img/logo.png'),
				'sidelogo'       => url('assets/_custom/img/logo.png'),
				'favicon'        => url('assets/_custom/img/favicon.jpg'),
				'menus'          => 'menus_fuelsupply',
				'access'         => 'access_fuelsupply',
				'namespace'      => 'Modules\FuelSupply\Http\Controllers',
				'nama_privilege' => self::getPrivilege(),
				'staff'          => [2],
				'avp'            => [3],
				'vp'             => [4],
				'supplier'       => [5],
				'customer'       => [6],
				'staffkeu'       => [7],
				'pel'            => [2, 3, 4, 7, 8],
				'contact'        => '031-3284275',
				'email'          => 'info@pel.co.id',
			);
			return $config[$parameter];
		}

		public static function cekPpk(){
			if(Auth::user()->id_privilege != 1){
				return false;
			}
			return true;
		}

		public static function getPrivilege(){
			if(Auth::user())
			return DB::table('privileges')->where('id_privilege', Auth::user()->id_privilege)->value('nama_privilege');
		}

        #ROUTING
        public static function routeController($prefix, $controller, $namespace = null, $token = false)
		{
			
			$prefix = trim($prefix, '/') . '/';
			
			$namespace = ($namespace) ?: 'App\Http\Controllers';
			
			try {
				Route::get($prefix, ['uses' => $controller . '@getIndex', 'as' => $controller . 'GetIndex']);
				
				$controller_class = new \ReflectionClass($namespace . '\\' . $controller);
				$controller_methods = $controller_class->getMethods(\ReflectionMethod::IS_PUBLIC);
				$wildcards = '/{one?}/{two?}/{three?}/{four?}/{five?}';
				foreach ($controller_methods as $method) {
					if ($method->class != 'Illuminate\Routing\Controller' && $method->name != 'getIndex') {
						if (substr($method->name, 0, 3) == 'get') {
							$method_name = substr($method->name, 3);
							$slug = array_filter(preg_split('/(?=[A-Z])/', $method_name));
							$slug = strtolower(implode('-', $slug));
							$slug = ($slug == 'index') ? '' : $slug;
							if($token){
								Route::get($prefix . $slug . $wildcards, ['uses' => $controller . '@' . $method->name, 'as' => $controller . 'Get' . $method_name]);
							}else{
								Route::get($prefix . $slug . $wildcards, ['uses' => $controller . '@' . $method->name, 'as' => $controller . 'Get' . $method_name]);
							}
						} elseif (substr($method->name, 0, 4) == 'post') {
							$method_name = substr($method->name, 4);
							$slug = array_filter(preg_split('/(?=[A-Z])/', $method_name));
							if($token){
								Route::post($prefix . strtolower(implode('-', $slug)) . $wildcards, [
									'uses' => $controller . '@' . $method->name,
									'as' => $controller . 'Post' . $method_name,
								]);
							}else{
								Route::post($prefix . strtolower(implode('-', $slug)) . $wildcards, [
									'uses' => $controller . '@' . $method->name,
									'as' => $controller . 'Post' . $method_name,
								]);
							}
						}
					}
				}
			} catch (\Exception $e) {
			
			}
		}

		#GET MENU
		public static function getMenu($id_privilege){
			$menu_data = DB::table('menus')
				->distinct()->select('urutan','menus.id_menu','nama_menu as nama','link','ikon')
				->join('permissions','permissions.id_menu','=','menus.id_menu')
				->where('id_privilege',$id_privilege)
				->orderBy('urutan')->get();
			foreach($menu_data as $key => $mn){
				$from = DB::table('submenus')
					->select('menus.id_menu','submenus.id_sub_menu','submenus.nama_sub_menu as nama_sub','submenus.link as link_sub','submenus.urutan')
					->join('menus','menus.id_menu','=','submenus.id_menu')
					->whereRaw(DB::raw("menus.id_menu=$mn->id_menu"))
					->orderBy('submenus.urutan');
				$sub_menu_data = DB::table(DB::raw("({$from->toSql()}) sub"))
					->select('sub.*')
					// ->mergeBindings($from->getQuery())
					->join('permissions', function ($join) {
						$join->on('permissions.id_menu', '=', 'sub.id_menu')
							->on('permissions.id_sub_menu','=','sub.id_sub_menu');
					})
					->where('permissions.id_privilege',$id_privilege)->get();
				$menu_data[$key]->sub_menu = $sub_menu_data;
			}
			return $menu_data;
		}

		#GET ACCESS
		public static function getAccess($id_privilege){
			$menu = DB::table('permissions')
				->select('menus.link as link_menu','submenus.link as link_sub_menu')
				->leftJoin('submenus', 'submenus.id_sub_menu', '=', 'permissions.id_sub_menu')
				->join('menus', 'menus.id_menu', '=', 'permissions.id_menu')
				->orderBy('menus.id_menu','asc')
				->where('id_privilege', $id_privilege)->get();
			$access_menu     = array_filter(array_column($menu->toArray(),'link_menu'));
			$access_sub_menu = array_filter(array_column($menu->toArray(),'link_sub_menu'));
			$access = array_merge($access_menu,$access_sub_menu);
			$forbidden  = DB::table('menus')
				->select('submenus.link as link_sub_menu','menus.link as link_menu')
				->leftJoin('submenus', 'submenus.id_menu', '=', 'menus.id_menu')
				->whereNotIn('menus.link', $access)
				->orWhere(function ($query) use($access){
					$query->whereNotIn('submenus.link', $access);
				})->get();
			$sec_menu     = array_filter(array_column($forbidden->toArray(),'link_menu'));
			$sec_sub_menu = array_filter(array_column($forbidden->toArray(),'link_sub_menu'));
			$sec = array_merge($sec_menu,$sec_sub_menu);
			return array('access_list' => $access, 'forbidden_list' => $sec);
		}

		
		#VIEW TEMPLATE
		public static function load($template = '', $view = '' , $view_data = array(), $view_add = array())
		{   
			$set  = $view_data;
			$data = array_merge($set, $view_add);
			$data['contents'] = view($view, $view_data);
			$data['menus']    = Request::session()->get('menus');

			return view($template, $data);
		}

		/**
		 * SESSION
		 */

		public static function getSession($nama){
			return Request::session()->get($nama);
		}

		#PATH URL
		public static function storageUrl($path=''){
			return url('storage/app/'.$path);
		}

		#CUSTOM URL
		public static function customUrl($path=''){
			return url('/public/assets/custom/' . $path);
		}


		/**
		 * FORM TEMPLATE
		 */

		
		#VIEW
		public static function formView($label, $isi){
			return "<div class=\"form-group\">
						<label>
							$label
						</label><br>
						$isi
						<hr style=\"margin:0\">
					</div>";
		}

		#INPUT HIDDEN
		public static function formHidden($name, $value = ''){
			return "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"$value\" />";
		}

		#INPUT
		public static function formInput($label, $type, $name, $value = '', $add=''){
			return "<div id=\"all-$name\" class=\"form-group m-form__group\">
                <label>
                    $label
                </label>
                <input name=\"$name\" id=\"$name\" type=\"$type\" value=\"$value\" class=\"form-control m-input m-input--pill\" placeholder=\"$label\" $add>
            </div>";
		}

		#INPUT
		public static function formText($label, $name, $value = '', $add=''){
			return "<div class=\"form-group m-form__group\">
                <label>
                    $label
				</label>
				<textarea class=\"form-control\" name=\"$name\" id=\"$name\" $add>$value</textarea>
            </div>";
		}

		#INPUT
		public static function formFile($label, $name, $add='', $msg ='', $file = ''){
			if($file)
			$filetext =  "(<a target=\"_blank\" href=\"".self::storageUrl($file)."\">File</a>)";
			else
			$filetext = '';
			$msg = $msg ? "<small class=\"form-text text-muted\">$msg $filetext</small>" : '';
			return "<div class=\"form-group m-form__group\">
                <label>
                    $label
                </label>
				<input name=\"$name\" id=\"$name\" type=\"file\" class=\"form-control-file\" $add>
				$msg
            </div>";
		}

		public static function formInputButton($label, $type, $name, $value_button, $value = '', $add=''){
			return "<div class=\"form-group m-form__group\">
                <label>
                    $label
				</label>
				<div class=\"input-group\">
					<input name=\"$name\" id=\"$name\" type=\"$type\" value=\"$value\" class=\"form-control m-input m-input--pill\" placeholder=\"$label\" $add>
					<div class=\"input-group-prepend\">
						<button class=\"btn btn-default btn-border $name-button\" type=\"button\">$value_button</button>
					</div>
				</div>
            </div>";
		}

		public static function defaultInput($label, $type, $name, $value = '', $add=''){
			return "<input name=\"$name\" id=\"$name\" type=\"$type\" value=\"$value\" class=\"form-control m-input m-input--pill\" style=\"width:100%\" placeholder=\"$label\" $add>";
		}
		
		#MAKE OPTION DATA
		public static function makeOption($data, $value, $name, $all = false){
			$res = [];
			if($all && count($data) > 1){
				$res[0]['value'] = '';
				$res[0]['name'] = '--- Pilih Semua ---';
				$all = true;
			}else{
				$all = false;
			}
			foreach($data as $key => $d){
				if($all){
					$res[$key + 1]['value'] = $d->$value;
					$res[$key + 1]['name'] = $d->$name;
				}else{
					$res[$key]['value'] = $d->$value;
					$res[$key]['name'] = $d->$name;
				}
			}
			
			return $res;
		}
		#SELECT
		public static function formSelect($label, $data = null, $name, $value = '', $add=''){
			$option = '';
			$selected = '';
			if($data){
				foreach($data as $d){
					$selected = $d['value'] == $value ? 'selected' : '';
					$option .= "<option value=\"$d[value]\" $selected>$d[name]</option>";
				}
			}
			return "<div class=\"form-group m-form__group\">
                <label>
                    $label
                </label>
				<select class=\"form-control m-input m-input--pill\" name=\"$name\" id=\"$name\" $add>
					$option
				</select>
            </div>";
		}
		#SELECT 
		public static function formSelect2($label, $data = null, $name, $value = '', $multipe=false){
			$option = '';
			$varmultiple = $multipe ? " multiple=\"multiple\"" : '';
			$id = $multipe ? $name."[]" : $name;
			if($data){
				foreach($data as $d){
					$option .= "<option value=\"$d[value]\">$d[name]</option>";
				}
			}
			return "<div class=\"form-group m-form__group\">
                <label>
                    $label
                </label>
				<select class=\"form-control m-input m-input--pill\" id=\"$name\" name=\"$id\" $varmultiple>
					$option
				</select>
            </div>";
		}

		#SELECT
		public static function defaultSelect($label, $data = null, $name, $value = '', $add=''){
			$option = '';
			if($data){
				foreach($data as $d){
					$selected = $d['value'] == $value ? 'selected' : '';
					$option .= "<option value=\"$d[value]\" $selected>$d[name]</option>";
				}
			}
			return "
				<select class=\"form-control m-input m-input--pill\" name=\"$name\" id=\"$name\" $add>
					$option
				</select>";
		}

		#SUBMIT
		public static function formSubmit($label, $name, $icon=null){
			$icon = $icon ? "<i class=\"$icon\"></i>" : "";
			return "<div class=\"form-group m-form__group\">
						<button id=\"$name\" class=\"btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill btn-sm pull-right\">
							<span>
								$icon
								<span id=\"label-$name\">
									$label
								</span>
							</span>
						</button>
					</div>
					<br/><br/>";
		}

		public static function breadcrumb($data){
			$view ='';
			foreach($data as $bc):
			$view .= "<li class=\"separator\">
						<i class=\"flaticon-right-arrow\"></i>
					</li>
					<li class=\"nav-item\">
						<a href=\"$bc[link]\">$bc[title]</a>
					</li>";
			endforeach;
			
			return "<ul class=\"breadcrumbs\">
						<li class=\"nav-home\">
							<a href=\"".url('')."\">
								<i class=\"flaticon-home\"></i>
							</a>
						</li>
						$view
					</ul>";
		}
		/* =============== */

		public static function selfUrl($path=''){
			return url(Request::segment(1).'/'.$path);
		}

		/**
		 * MODEL
		 */

		public static function getPenyedia(){
			$data = DB::table('m_penyedia');
			return $data;
		}

		public static function getDinas(){
			$data = DB::table('m_dinas');
			if(Auth::user()->id_dinas)
				$data->where('id_dinas', Auth::user()->id_dinas);

			return $data;
		}
		
		public static function getPekerjaan($id = null){
			$id_pekerjaan = DB::table('transaksi')->pluck('id_pekerjaan');
			if($id){
				$data = DB::table('pekerjaan')
					->where(function($query) use($id, $id_pekerjaan){
						$query->whereNotIn('id_pekerjaan', $id_pekerjaan);
						$query->orWhere('id_pekerjaan', $id);
					});
			}else{
				$data = DB::table('pekerjaan')->whereNotIn('id_pekerjaan', $id_pekerjaan);
			}
			if(Auth::user()->id_dinas)
				$data->where('id_dinas', Auth::user()->id_dinas);

			return $data;
		}

		/**
		 * DATE 
		 * example: 2020-03-17 12:00:00
		 */

		
		#Selasa, 17 Maret 2019
		public static function getFullDate($date){
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = self::getTanggal($date);
            $bulan   = self::bulan(self::getBulan($date));
            $tahun   = self::getTahun($date);
            return self::hari($tanggal) .', '.$tanggal.' '.$bulan.' '.$tahun;  
		}

		public static function dateFull($date){
			return Carbon::createFromFormat('Y-m-d H:i:s', $date)->formatLocalized('%A, %d %B %Y - %H:%M');
		}

		public static function date($date){
			return Carbon::parse($date)->isoFormat('D MMMM Y');
		}

		public static function defaultDate($date){
			return Carbon::parse($date)->formatLocalized('%Y-%m-%d');
		}
		public static function defaultDateTime($date){
			return Carbon::parse($date)->formatLocalized('%Y-%m-%d %H:%M');
		}
		public static function imaisDate($date){
			return Carbon::parse($date)->formatLocalized('%d-%m-%Y');
		}

		public static function datePeriode($date){
			return Carbon::createFromFormat('Ym',$date)->formatLocalized("%B %Y");
		}

		public static function dateFormat($date, $format = 'Y-m-d H:i:s'){
			return date($format, strtotime($date));
		}


		public static function getTanggal($date){
			return substr($date,8,2);
		}
		public static function getBulan($date){
			return substr($date,5,2);
		}
		public static function getTahun($date){
			return substr($date,0,4);
		}

		public static function getHour($date){
			return substr($date, 11,5);
		}

		public static function hari($date){
			$hari = date('D', strtotime($date));
			switch ($hari) {
				case 'Sun':
					return 'Minggu';
					break;
				case 'Mon':
					return 'Senin';
					break;
				case 'Tue':
					return 'Selasa';
					break;
				case 'Wed':
					return 'Rabu';
					break;
				case 'Thu':
					return 'Kamis';
					break;
				case 'Fri':
					return 'Jumat';
					break;
				case 'Sat':
					return 'Sabtu';
					break;
			}
		}

		public static function isPeriode($date){
			$bln = substr($date,5,2);
			$bulan = '';
			switch ($bln){
				case 1: 
					$bulan = "JAN";
					break;
				case 2:
					$bulan = "FEB";
					break;
				case 3:
					$bulan = "MAR";
					break;
				case 4:
					$bulan = "APR";
					break;
				case 5:
					$bulan = "MEI";
					break;
				case 6:
					$bulan = "JUN";
					break;
				case 7:
					$bulan = "JUL";
					break;
				case 8:
					$bulan = "AGU";
					break;
				case 9:
					$bulan = "SEP";
					break;
				case 10:
					$bulan = "OKT";
					break;
				case 11:
					$bulan = "NOV";
					break;
				case 12:
					$bulan = "DES";
					break;
			}
			if(substr($date,8,2) > 14){
				return $bulan .'-2';
			}else{
				return $bulan .'-1';
			}

		}
		public static function getNomor($date){
			if(substr($date,8,2) > 14){
				return '2';
			}else{
				return '1';
			}
		}
		public static function bulan($bln){
			switch ($bln){
				case 1: 
					return "Januari";
					break;
				case 2:
					return "Februari";
					break;
				case 3:
					return "Maret";
					break;
				case 4:
					return "April";
					break;
				case 5:
					return "Mei";
					break;
				case 6:
					return "Juni";
					break;
				case 7:
					return "Juli";
					break;
				case 8:
					return "Agustus";
					break;
				case 9:
					return "September";
					break;
				case 10:
					return "Oktober";
					break;
				case 11:
					return "November";
					break;
				case 12:
					return "Desember";
					break;
			}
		} 

		public static function rupiah_format($nilai){
			return 'Rp. '.number_format($nilai,2);
		}
    }
