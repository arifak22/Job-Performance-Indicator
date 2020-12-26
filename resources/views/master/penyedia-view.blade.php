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
                        <div class="ml-auto">
                            <a style="color: #fff;" class="btn btn-primary btn-round btn-sm" href="{{Sideveloper::selfUrl('penyedia-form')}}">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-search">
                        <div class="row">
                            <div class="col-md-4">
                                {!!Sideveloper::formSelect('Jenis Penyedia',  $jenis, 'id_jenis')!!}
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table id="data-list" class="display table table-striped table-hover table-full" >
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Action</th>
                                        <th>Jenis</th>
                                        <th>Nama</th>
                                        <th>NPWP</th>
                                        <th>Nomor SIUP</th>
                                        <th>No Telp</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Action</th>
                                        <th>Jenis</th>
                                        <th>Nama</th>
                                        <th>NPWP</th>
                                        <th>Nomor SIUP</th>
                                        <th>No Telp</th>
                                        <th>Email</th>
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
    $("#id_jenis").change(function(){
        refreshTable();
    })
    var tableList = $('#data-list').DataTable({
        processing   : true,
        serverSide   : true,
        bLengthChange: false,
        bFilter      : false,
        pageLength   : 10,
        order        : [[2,'desc']],
        //  "order": [[ 0, 'asc' ], [ 1, 'asc' ]]
        ajax         : {
            url  : "{{Sideveloper::selfUrl('penyedia-table')}}",
            type : "get",            
            data: function(d) {
                d.id_jenis = $("#id_jenis").val();
            },
            error: function(){ 
                $(".employee-grid-error").html("");
                $("#data-list").append('<tbody class="employee-grid-error"><tr><th colspan="7"><center>Internal Server Error</center></th></tr></tbody>');
                $("#data-list_processing").css("display","none");
            }
        },
        drawCallback: function (settings) {
            var response = settings.json;
            $('.badge-waiting').html(response.recordsTotal);
        },
        columns : [
            { "data" : "id_penyedia" },
            { "data" : "nama_jenis" },
            { "data" : "nama" },
            { "data" : "npwp" },
            { "data" : "nomor_siup" },
            { "data" : "no_telp" },
            { "data" : "email" },
        ],
        columnDefs: [
            {
                targets : 0,
                orderable: false, 
                data: "id_penyedia",
                render: function ( data, type, row, meta ) {
                    return `
                            <div class="form-button-action">
                                <a href="{{Sideveloper::selfUrl('penyedia-detail?from=list&id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-lg" data-original-title="Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{Sideveloper::selfUrl('penyedia-form?id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-warning btn-lg" data-original-title="Ubah">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="button" onclick="hapus(${data})" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>`;
                }
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
                    url: "{{Sideveloper::selfUrl('penyedia-hapus')}}",
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