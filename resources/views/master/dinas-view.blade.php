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
                        {{-- <button class="btn btn-primary btn-border btn-sm" onclick="searchStatus()"><i class="fas fa-search"></i> Advance Search</button> --}}
                        <div class="ml-auto">
                            <a style="color: #fff;" class="btn btn-primary btn-round btn-sm" href="{{Sideveloper::selfUrl('dinas-form')}}">
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
                                        <th>Nama Lengkap</th>
                                        <th>Nama</th>
                                        <th>No Telp</th>
                                        <th>Alamat</th>
                                        <th>Jumlah User</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Action</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nama</th>
                                        <th>No Telp</th>
                                        <th>Alamat</th>
                                        <th>Jumlah User</th>
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
        order        : [[3,'desc']],
        //  "order": [[ 0, 'asc' ], [ 1, 'asc' ]]
        ajax         : {
            url  : "{{Sideveloper::selfUrl('dinas-table')}}",
            type : "get",            
            data: function(d) {
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
            { "data" : "id_dinas" },
            { "data" : "nama_lengkap" },
            { "data" : "nama" },
            { "data" : "no_telp" },
            { "data" : "alamat" },
            { "data" : "jumlah_user" },
        ],
        columnDefs: [
            {
                targets : 0,
                orderable: false, 
                data: "id_dinas",
                render: function ( data, type, row, meta ) {
                    return `
                            <div class="form-button-action">
                                <a href="{{Sideveloper::selfUrl('dinas-user?id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-lg" data-original-title="Tambah User">
                                    <i class="fa fa-user"></i>
                                </a>
                                <a href="{{Sideveloper::selfUrl('dinas-form?id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-warning btn-lg" data-original-title="Ubah">
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
                    url: "{{Sideveloper::selfUrl('dinas-hapus')}}",
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