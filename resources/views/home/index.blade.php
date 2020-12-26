<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">{{$title}}</h2>
			</div>
		</div>
		
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<form class="ml-md-auto py-2 py-md-0">
				<div class="form-row align-items-center">
					<div class="col-auto">
                        {!!Sideveloper::defaultSelect('Dinas', $dinas, 'id_dinas', Request::input('id_dinas'))!!}
					</div>
					<div class="col-auto">
                        {{-- {!!Sideveloper::defaultSelect('kota', $kota, 'id_kota', Request::input('id_kota'))!!} --}}
					</div>
					<div class="col-auto">
						<input type="text" class="form-control" name="start" id="periode_start" placeholder="Periode" value="{{$start}}" readonly>
					</div>
					<div class="col-auto">
						<span style="color:#fff">s/d</span>
					</div>
					<div class="col-auto">
						<input type="text" class="form-control" name="end" id="periode_finish" placeholder="Periode" value="{{$end}}" readonly>
					</div>
					<div class="col-auto">
						<button type="submit" class="btn btn-icon btn-success">
							<i class="flaticon-search-2"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="page-inner mt--5">
    <div class="row mt--2">
		<div class="col-md-12">
			<div class="card full-height" style="padding:20px">
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="card card-stats card-secondary card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="flaticon-users"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Penyedia yang dinilai</p>
                                            <h4 class="card-title">{{number_format($jumlah_penyedia)}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="card card-stats card-success card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="flaticon-box"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Paket Pekerjaan</p>
                                            <h4 class="card-title">{{number_format($jumlah_pekerjaan)}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4 col-md-4">
                        <div class="card card-stats card-info card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="flaticon-desk"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Paket Penilian Kinerja</p>
                                            <h4 class="card-title">{{number_format($jumlah_paket)}} {{--/ {{number_format($jumlah_pekerjaan)}}--}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Pertumbuhan Pekerjaan</div>
				</div>
				<div class="card-body">
                    <div class="chart-container">
                        <canvas id="lineChart"></canvas>
                    </div>
				</div>
			</div>
		</div>

        <div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Ranking Penyedia</div>
				</div>
				<div class="card-body">

                    <div class="table-responsive">
                        <table id="data-list" class="display table table-striped table-hover table-full" >
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama</th>
                                    <th>Nilai rata-rata</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nilai rata-rata</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
        </div>

        <div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Ranking Dinas</div>
				</div>
				<div class="card-body">

                    <div class="table-responsive">
                        <table id="data-penyedia" class="display table table-striped table-hover table-full" >
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama</th>
                                    <th>Total Paket</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Kontrak HPS</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Total Paket</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Kontrak HPS</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
    </div>
</div>

<script>
    
	
    var today = new Date();
    $('#periode_start').datepicker({
        autoclose  : true,
        format     : 'yyyy-mm',
        orientation: "bottom left",
        endDate :  today,
		viewMode: "months", 
		minViewMode: "months"
    });
    $('#periode_finish').datepicker({
        autoclose  : true,
        format     : 'yyyy-mm',
        orientation: "bottom left",
        endDate :  today,
		viewMode: "months", 
		minViewMode: "months"
    });
    var lineChart = document.getElementById('lineChart').getContext('2d');
    var myLineChart = new Chart(lineChart, {
			type: 'line',
			data: {
				labels: <?=$periode?>,
				datasets: [{
					label: "Total Paket Pekerjaan",
					borderColor: "#1d7af3",
					pointBorderColor: "#FFF",
					pointBackgroundColor: "#1d7af3",
					pointBorderWidth: 2,
					pointHoverRadius: 4,
					pointHoverBorderWidth: 1,
					pointRadius: 4,
					backgroundColor: 'transparent',
					fill: true,
					borderWidth: 2,
					data: <?=$pertumbuhan?>
				}]
			},
			options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					position: 'bottom',
					labels : {
						padding: 10,
						fontColor: '#1d7af3',
					}
				},
				tooltips: {
					bodySpacing: 4,
					mode:"nearest",
					intersect: 0,
					position:"nearest",
					xPadding:10,
					yPadding:10,
					caretPadding:10
				},
				layout:{
					padding:{left:15,right:15,top:15,bottom:15}
				}
			}
        });
        
    var tableList = $('#data-list').DataTable({
        processing   : true,
        serverSide   : true,
        bLengthChange: false,
        bFilter      : false,
        pageLength   : 10,
        ordering     : false,
        ajax         : {
            url  : "{{Sideveloper::selfUrl('ranking-table')}}",
            type : "get",            
            data: function(d) {
                d.id_dinas       = $("#id_dinas").val();
                d.periode_start  = $("#periode_start").val();
                d.periode_finish = $("#periode_finish").val();
            },
            error: function(){ 
                $(".employee-grid-error").html("");
                $("#data-list").append('<tbody class="employee-grid-error"><tr><th colspan="3"><center>Internal Server Error</center></th></tr></tbody>');
                $("#data-list_processing").css("display","none");
            }
        },
        drawCallback: function (settings) {
            var response = settings.json;
            $('.badge-waiting').html(response.recordsTotal);
        },
        columns : [
            { "data" : "num" },
            { "data" : "nama_penyedia" },
            { "data" : "nilai" },
        ],
        columnDefs: [
            {
                targets : 0,
                orderable: false, 
                data: "num",
            },
            {
                targets : 1,
                orderable: false, 
                data: "nama_penyedia",
            },
        ],
    });

    var tablePenyedia = $('#data-penyedia').DataTable({
        processing   : true,
        serverSide   : true,
        bLengthChange: false,
        bFilter      : false,
        pageLength   : 10,
        ordering     : false,
        ajax         : {
            url  : "{{Sideveloper::selfUrl('penyedia-table')}}",
            type : "get",            
            data: function(d) {
                d.id_dinas       = $("#id_dinas").val();
                d.periode_start  = $("#periode_start").val();
                d.periode_finish = $("#periode_finish").val();
            },
            error: function(){ 
                $(".employee-grid-error").html("");
                $("#data-list").append('<tbody class="employee-grid-error"><tr><th colspan="5"><center>Internal Server Error</center></th></tr></tbody>');
                $("#data-list_processing").css("display","none");
            }
        },
        drawCallback: function (settings) {
            var response = settings.json;
            $('.badge-waiting').html(response.recordsTotal);
        },
        columns : [
            { "data" : "num" },
            { "data" : "nama_dinas" },
            { "data" : "total_paket" },
            { "data" : "nilai_kontrak" },
            { "data" : "nilai_kontrak_hps" },
        ],
        columnDefs: [
            {
                targets : 0,
                orderable: false, 
                data: "num",
            },
            {
                targets : 1,
                orderable: false, 
                data: "nama_dinas",
            },
            {
                targets : 3,
                orderable: false, 
                data: "nilai_kontrak",
                render: function ( data, type, row, meta ) {
                    return formatRupiah(data)
                }
            },
            {
                targets : 4,
                orderable: false, 
                data: "nilai_kontrak_hps",
                render: function ( data, type, row, meta ) {
                    return formatRupiah(data)
                }
            },
        ],
    });
</script>