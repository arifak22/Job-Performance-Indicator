<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{$title}}</h4>       
        {!!Sideveloper::breadcrumb($breadcrumbs)!!}
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        Filter
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="col-md-12 step-1">
                            <div class="row">
                                <div class="col-md-12">
                                    {!!Sideveloper::formSelect('Dinas', $dinas, 'id_dinas')!!}
                                    {!!Sideveloper::formSelect('Penyedia', $penyedia, 'id_penyedia')!!}
                                    {!!Sideveloper::formSelect('Tahun Paket',  $year, 'tahun_paket', date('Y'))!!}
                                    <div class="form-group m-form__group">
                                        <label>
                                            Range Nilai
                                        </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input name="min" id="min" type="number" value="0" max="100" min="0" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <input name="max" id="max" type="number" value="100" max="100" min="0" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group">
                                        <label>
                                            Range Tanggal Surat
                                        </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input name="start" id="start" type="text" value="{{date('Y-m-d')}}" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <input name="end" id="end" type="text" value="{{date('Y-m-d')}}" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    {!!Sideveloper::formSubmit('Search', 'submit')!!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 view">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        Hasil
                        <div class="ml-auto">
                            <button onclick="exportexcel()" style="color: #fff;" class="btn btn-primary btn-round btn-sm">
                                <i class="fas fa-file-excel"></i>
                                Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data-list" class="display table table-striped table-hover table-full">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Penyedia</th>
                                    <th>Nomor Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Tahun Paket</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
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
    $(document).ready(function(){
        $(".view").hide();
    })
    var today = new Date();
    $('#start').datepicker({
        autoclose  : true,
        format     : 'yyyy-mm-dd',
        orientation: "bottom left",
    });
    $('#end').datepicker({
        autoclose  : true,
        format     : 'yyyy-mm-dd',
        orientation: "bottom left",
    });
    
    var tableList = $('#data-list').DataTable({
        processing   : true,
        serverSide   : true,
        bLengthChange: false,
        bFilter      : false,
        pageLength   : 10,
        order        : [[3,'desc']],
        //  "order": [[ 0, 'asc' ], [ 1, 'asc' ]]
        ajax         : {
            url  : "{{Sideveloper::selfUrl('table')}}",
            type : "get",            
            data: function(d) {
                d.id_penyedia = $("#id_penyedia").val();
                d.id_dinas    = $("#id_dinas").val();
                d.tahun_paket = $("#tahun_paket").val();
                d.nilai_min   = $("#min").val();
                d.nilai_max   = $("#max").val();
                d.tgl_start   = $("#start").val();
                d.tgl_end     = $("#end").val();
            },
            error: function(){ 
                $(".employee-grid-error").html("");
                $("#data-list").append('<tbody class="employee-grid-error"><tr><th colspan="6"><center>Internal Server Error</center></th></tr></tbody>');
                $("#data-list_processing").css("display","none");
            }
        },
        drawCallback: function (settings) {
            var response = settings.json;
            $('.badge-waiting').html(response.recordsTotal);
        },
        columns : [
            { "data" : "id_transaksi" },
            { "data" : "nama_penyedia" },
            { "data" : "nomor_surat" },
            { "data" : "tanggal_surat" },
            { "data" : "tahun_paket" },
            { "data" : "nilai" },
        ],
        columnDefs: [
            {
                targets : 0,
                orderable: false, 
                data: "id_transaksi",
                render: function ( data, type, row, meta ) {
                    return `
                            <div class="form-button-action">
                                <a href="{{Sideveloper::selfUrl('detail?from=report&id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-lg" data-original-title="Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a target="_blank" href="{{Sideveloper::selfUrl('detail?from=list&tipe=print&id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Detail">
                                    <i class="fa fa-print"></i>
                                </a>
                            </div>`;
                }
            },
            {
                targets : 3,
                orderable: true, 
                data: "tanggal_surat",
                render: function(data){
                    var day = moment(data).format('DD MMMM YYYY');
                    return day;
                },
            },
        ],
    });

    $('#submit').click(function(e) {
        e.preventDefault();
        var btn  = $(this);
        var form = $(this).closest('form');
        form.validate({
            rules: {
                start: {
                    required: true,
                },
                end: {
                    required: true,
                },
                min: {
                    required: true,
                },
                max: {
                    required: true,
                },
            }
        });
        if (!form.valid()) {
            return;
        }
        tableList.ajax.reload();
        $(".view").show();
    });

    function exportexcel(){
        var id_penyedia = $("#id_penyedia").val();
        var id_dinas    = $("#id_dinas").val();
        var tahun_paket = $("#tahun_paket").val();
        var nilai_min   = $("#min").val();
        var nilai_max   = $("#max").val();
        var tgl_start   = $("#start").val();
        var tgl_end     = $("#end").val();

        window.open("{{Sideveloper::selfUrl('export-report')}}?id_penyedia=" + id_penyedia + "&id_dinas=" + id_dinas + "&tahun_paket=" + tahun_paket + "&nilai_min=" + nilai_min + "&nilai_max=" + nilai_max + "&tgl_start=" + tgl_start+ "&tgl_end=" + tgl_end);
    }
</script>