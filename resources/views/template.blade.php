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
</style>
<script>
	
$.validator.addMethod(
    /* The value you can use inside the email object in the validator. */
    "regex",

    /* The function that tests a given string against a given regEx. */
    function(value, element, regexp)  {
        /* Check if the value is truthy (avoid null.constructor) & if it's not a RegEx. (Edited: regex --> regexp)*/

        if (regexp && regexp.constructor != RegExp) {
           /* Create a new regular expression using the regex argument. */
           regexp = new RegExp(regexp);
        }

        /* Check whether the argument is global and, if so set its last index to 0. */
        else if (regexp.global) regexp.lastIndex = 0;

        /* Return whether the element is optional or the result of the validation. */
        return this.optional(element) || regexp.test(value);
    }, "Enter with valid pattern"
);
</script>
</head>
<body {{$dark ? "data-background-color=\"dark\"" : ''}}>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="{{$dark ? 'dark2' : 'light-blue'}}">
				
				<a href="{{url('')}}" class="logo">
					<img height="80%" src="{{Sideveloper::config('sidelogo')}}" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="{{$dark ? 'dark2' : 'light-blue2'}}">
				<div class="container-fluid">
					<div class="row" style="color:white;text-align: center;height:62px;display: flex;
					justify-content: center;
					align-items: center;">
						<img style="margin-left:20px" height="90%" src="{{url('assets/_custom/img/logokab.gif')}}">
						<h3 style="margin-left:15px">Sistem Informasi Penilaian Kinerja Penyedia Kabupaten Karimun</h3>
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{Sideveloper::storageUrl('public/img/user.svg')}}" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="{{Sideveloper::storageUrl('public/img/user.svg')}}" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4>{{Auth::user()->nama}}</h4>
												<p class="text-muted">{{Sideveloper::config('nama_privilege')}}</p>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" id="ubah-password" href="">Ubah Password</a>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="{{url('home/logout')}}">Logout</a>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2" {{$dark ? "data-background-color=\"dark2\"" : ''}}>			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{Sideveloper::storageUrl('public/img/user.svg')}}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a>
								<span>
									{{Auth::user()->nama}}
									<span class="user-level">{{Sideveloper::config('nama_privilege')}}</span>
								</span>
							</a>
							<div class="clearfix"></div>
						</div>
					</div>
					<ul class="nav nav-primary">
						@foreach ($menus as $key => $mn)
							@if (count($mn->sub_menu) > 0)
								<li class="nav-item {{--active--}}">
									<a data-toggle="collapse" href="#mn-{{$key}}" class="collapsed" aria-expanded="false">
										<i class="{{$mn->ikon}}"></i>
										<p>{{$mn->nama}}</p>
										<span class="caret"></span>
									</a>
									<div class="collapse" id="mn-{{$key}}">
										<ul class="nav nav-collapse">
											@foreach ($mn->sub_menu as $sm)
											<li>
												<a href="{{url($sm->link_sub)}}">
													<span class="sub-item">{{$sm->nama_sub}} </span>
												</a>
											</li>
											@endforeach
										</ul>
									</div>
								</li>
							@else
								<li class="nav-item">
									<a href="{{url($mn->link)}}" >
										<i class="{{$mn->ikon}}"></i>
										<p>{{$mn->nama}}</p>
									</a>
								</li>
							@endif
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->

		<div class="main-panel">
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
<!-- Modal -->
<div class="modal fade" id="modal-ubah-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="form-history">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
			</div>
            <div class="modal-body">
				{!!Sideveloper::formInput('Password Lama', 'password', 'passlama')!!}
				{!!Sideveloper::formInput('Password Baru', 'password', 'passbaru1')!!}
				{!!Sideveloper::formInput('Ulangi Password Baru', 'password', 'passbaru2')!!}
            </div>
            <div class="modal-footer">
                <button type="submit" id="exec-ubah" class="btn btn-primary"><i class="fa fa-send"></i>
                    Ubah</button>
            </div>
        </form>
    </div>
</div>
<script>
	$("#ubah-password").click(function(e){
		e.preventDefault();
		$("#modal-ubah-password").modal('show');
	});
	$('#exec-ubah').click(function(e) {
        e.preventDefault();
        var btn = $(this);
        var form = $(this).closest('form');
        form.validate({
            rules: {
                passlama: {
					required: true,
					minlength: 6,
                },
                passbaru1: {
                    required: true,
					minlength: 6,
                },
                passbaru2: {
                    required: true,
					minlength: 6,
                },
            }
        });
        if (!form.valid()) {
            return;
        }
        apiLoading(true, btn);
		form.ajaxSubmit({
            url : "{{url('home/ubah-password')}}",
            data: { _token: "{{ csrf_token() }}" },
            type: 'POST',
            success: function(response) {
                apiLoading(false, btn);
                apiRespone(response, (res)=> {
					if(res.api_status == 1){
						$("#passlama").val('');
						$("#passbaru1").val('');
						$("#passbaru2").val('');
						$("#modal-ubah-password").modal('hide');
					}
				});
            },
            error: function(error){
                apiLoading(false, btn);
                swal(error.statusText);
            }
        });
    });
</script>
</html>