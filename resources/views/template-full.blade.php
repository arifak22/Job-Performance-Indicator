<?php
	$dark = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>{{Sideveloper::config('appname')}}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="shortcut icon" href="{{Sideveloper::config('favicon')}}" />

	<!-- Fonts and icons -->
	<script src="{{url('assets')}}/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{url('assets')}}/css/fonts.min.css"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
    <link rel="stylesheet" href="{{url('assets')}}/select2/css/select2.min.css">

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{url('assets')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('assets')}}/css/atlantis-new.min.css">
    

	<link rel="stylesheet" href="{{url('assets/datepicker')}}/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{url('assets/_custom')}}/css/style.css">

	<!--   Core JS Files   -->
	<script src="{{url('assets')}}/js/core/jquery.3.2.1.min.js"></script>
	<script src="{{url('assets')}}/js/core/popper.min.js"></script>
	<script src="{{url('assets')}}/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="{{url('assets')}}/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="{{url('assets')}}/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{url('assets')}}/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
	<script src="{{url('assets')}}/js/plugin/chart-circle/circles.min.js"></script>
	<script src="{{url('assets')}}/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Datatables -->
	<script src="{{url('assets')}}/js/plugin/datatables/datatables.min.js"></script>
	<!-- Atlantis JS -->
    <script src="{{url('assets')}}/js/atlantis.min.js"></script>
    

	<script src="{{url('assets/datepicker')}}/js/bootstrap-datepicker.min.js"></script>
	<script src="{{url('assets')}}/js/plugin/chart.js/chart.min.js"></script>
	
	
	<script src="{{url('assets')}}/js/plugin/jquery.validate.min.js"></script> 
	<script src="{{url('assets')}}/js/plugin/jquery.form.min.js"></script> 
	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/locale/id.js"></script>
	<script src="{{url('assets')}}/_custom/js/script.js"></script> 

	<script src="{{url('assets')}}/select2/js/select2.full.min.js"></script> 
	<script>
		moment.locale("id");
	</script>
	<style>
		.form-control[readonly] {
			background: #fff!important;
			border-color: #e8e8e8!important;
		}
		.form-button-action .btn{
			padding: 10px 15.5px!important;
		}
		.table-full{
			width: 100%!important;
		}
		.scroll-feed{
			height:300px; 
			max-height:300px; 
			overflow-y:scroll;
		}
		.scroll-feed::-webkit-scrollbar-track {
			border: 1px solid #e8e8e8;
			background-color: #fff;
		}

		.scroll-feed::-webkit-scrollbar {
			width: 5px;
		}

		.scroll-feed::-webkit-scrollbar-thumb {
			border-radius: 10px;
			box-shadow: inset 0 0 6px rgba(0,0,0,.3);
			background-color: #8d9498;
			border: 1px solid #737272;
		}
		.catatan{
			color: #1572e8;
		}
		.date{
			text-transform:none!important;
		}

		.swal-text {
			text-align: center;
		}
		.page-pretitle {
		letter-spacing: .08em;
		text-transform: uppercase;
		color: #95aac9; }
		/*     Invoices	    */
.card-invoice .invoice-header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px; }
  .card-invoice .invoice-header .invoice-title {
    font-size: 27px;
    font-weight: 400; }
  .card-invoice .invoice-header .invoice-logo {
    width: 150px;
    display: flex;
    align-items: center; }
    .card-invoice .invoice-header .invoice-logo img {
      width: 100%; }
.card-invoice .sub {
  font-size: 14px;
  margin-bottom: 8px;
  font-weight: 600; }
.card-invoice .info-invoice {
  padding-top: 15px;
  padding-bottom: 15px; }
  .card-invoice .info-invoice p {
    font-size: 13px; }
.card-invoice .invoice-desc {
  text-align: right;
  font-size: 13px; }
.card-invoice .invoice-detail {
  width: 100%;
  display: block; }
  .card-invoice .invoice-detail .invoice-top .title {
    font-size: 20px; }
.card-invoice .transfer-to .sub {
  font-size: 14px;
  margin-bottom: 8px;
  font-weight: 600; }
.card-invoice .transfer-to .account-transfer > div span:first-child {
  font-weight: 600;
  font-size: 13px; }
.card-invoice .transfer-to .account-transfer > div span:last-child {
  font-size: 13px;
  float: right; }
.card-invoice .transfer-total {
  text-align: right;
  display: flex;
  flex-direction: column;
  justify-content: center; }
  .card-invoice .transfer-total .sub {
    font-size: 14px;
    margin-bottom: 8px;
    font-weight: 600; }
  .card-invoice .transfer-total .price {
    font-size: 28px;
    color: #1572E8;
    padding: 7px 0;
    font-weight: 600; }
  .card-invoice .transfer-total span {
    font-weight: 600;
    font-size: 13px; }
.card-invoice .card-body {
  padding: 0;
  border: 0px !important;
  width: 75%;
  margin: auto; }
.card-invoice .card-header {
  padding: 50px 0px 20px;
  border: 0px !important;
  width: 75%;
  margin: auto; }
.card-invoice .card-footer {
  padding: 5px 0 50px;
  border: 0px !important;
  width: 75%;
  margin: auto; }
  @media print {
		body * {
			visibility: hidden;
		}
		#section-to-print, #section-to-print * {
			visibility: visible;
		}
		#section-to-print {
			position: fixed;
			left: 0;
			top: 0;
		}
	}
	.detail-oat:hover{
		cursor: pointer;
		color: #1572E8;
	}	
	.account-transfer{
		margin-left: 6px;
		margin-right: 6px;
	}

	
    .select2-container .select2-selection--single .select2-selection__rendered{
        display: block;
        width: 100%;
        height: calc(2.25rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 0px solid #aaa;
        border-radius: 4px;
    }
	.logintext:hover{
		text-decoration: #1572E8;
	}
	.main-header2 {
		background: #fff;
		min-height: 60px;
		width: 100%;
		position: fixed;
		z-index: 1001;
		box-shadow: 0 0 5px rgba(18,23,39,.5);
	}
	.main-panel2 {
		position: relative;
		width: 100%;
		height: 100vh;
		min-height: 100%;
		float: right;
		transition: all .3s;
	}
	.more:hover{
		text-decoration: none;
	}
</style>
</head>
<body {{$dark ? "data-background-color=\"dark\"" : ''}}>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="{{$dark ? 'dark2' : 'light-blue2'}}">
				
				<a href="{{url('')}}" class="logo">
					<img height="80%" src="{{Sideveloper::config('sidelogo')}}" alt="navbar brand" class="navbar-brand">
				</a>
				<a href="{{url('login')}}" class="more"><i class="la flaticon-arrow"></i></a>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="{{$dark ? 'dark2' : 'light-blue2'}}">
				
				
				<div class="container-fluid">
					{{-- <div class="row" style="color:white;text-align: center;height:62px;display: flex;
					justify-content: center;
					align-items: center;">
						<img style="margin-left:20px" height="90%" src="{{url('assets/_custom/img/logokab.gif')}}">
						<h3 style="margin-left:15px">Sistem Informasi Penilaian Kinerja Penyedia Kabupaten Karimun</h3>
					</div> --}}
					<div class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<b><a href="{{url('login')}}" class="pull-right logintext" style="color: white"><i class="la flaticon-arrow"></i> Login</a></b>
					</div>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>


		<div class="main-panel2" style="width: 100%">
			<div class="content">
                    {!!$contents!!}
			</div>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul class="nav">
							<li class="nav-item">
								{{-- <a class="nav-link" href="https://www.themekita.com">
                                Theme By ThemeKita
								</a> --}}
							</li>
						</ul>
					</nav>
					<div class="copyright ml-auto">
						Copyright © 2020 <a href="https://www.ukpbjkarimun.info">IT UKPBJ Karimun Team</a> - {{Sideveloper::config('appname')}}
					</div>				
				</div>
			</footer>
		</div>
	</div>
</body>
</html>