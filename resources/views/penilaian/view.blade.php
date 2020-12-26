<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{$title}}</h4>
        {!!Sideveloper::breadcrumb($breadcrumbs)!!}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary btn-border btn-sm" onclick="searchStatus()"><i class="fas fa-search"></i> Advance Search</button>
                        @if(Auth::user()->id_privilege == 1)
                        <div class="ml-auto">
                            <a style="color: #fff;" class="btn btn-primary btn-round btn-sm" href="{{Sideveloper::selfUrl('form')}}">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-search">
                        <div class="row">
                            <div class="col-md-4">
                                {!!Sideveloper::formSelect('Penyedia',  $penyedia, 'id_penyedia')!!}
                                {!!Sideveloper::formSelect('Dinas',  $dinas, 'id_dinas')!!}
                            </div>
                            <div class="col-md-4">
                                {!!Sideveloper::formSelect('Tahun Paket',  $year, 'tahun_paket', date('Y'))!!}
                            </div>
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table id="data-list" class="display table table-striped table-hover table-full" >
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Action</th>
                                        <th>Penyedia</th>
                                        <th>Nomor Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>Tahun Paket</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Action</th>
                                        <th>Penyedia</th>
                                        <th>Nomor Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>Tahun Paket</th>
                                        <th>Nilai</th>
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
</div>
<script>
    var hideSearch = true;
    $(document).ready(function(){
        $(".form-search").hide();
    });

    function searchStatus(){
        hideSearch = !hideSearch;
        if(hideSearch){
            $(".form-search").hide();
        }else{
            $(".form-search").show();
        }
    }
    
    function refreshTable(){
        tableList.ajax.reload();
    }    
    $("#id_penyedia, #id_dinas, #tahun_paket").change(function(){
        refreshTable();
    })
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
                                <a href="{{Sideveloper::selfUrl('detail?from=list&id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-lg" data-original-title="Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a target="_blank" href="{{Sideveloper::selfUrl('detail?from=list&tipe=print&id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Detail">
                                    <i class="fa fa-print"></i>
                                </a>
                                @if(Auth::user()->id_privilege == 1)
                                <a href="{{Sideveloper::selfUrl('form?id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-warning btn-lg" data-original-title="Ubah">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="button" onclick="hapus(${data})" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
                                    <i class="fa fa-times"></i>
                                </button>
                                @endif
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

    function hapus(id){
        swal({
            title: "Apakah anda yakin?",
            text: "Menghapus data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                apiLoading(true);
                $.ajax({
                    method: "POST",
                    url: "{{Sideveloper::selfUrl('hapus')}}",
                    data: { id: id, value:9, catatan: 'Hapus', _token: "{{ csrf_token() }}" }
                })
                .done(function(res) {
                    apiRespone(res,
						null,
						() => {
                            refreshTable();
						}
					);
                })
                .fail(function(err) {
                    alert("error");
                })
                .always(function() {
                    apiLoading(false);
                });
            }
        });
    }
</script>