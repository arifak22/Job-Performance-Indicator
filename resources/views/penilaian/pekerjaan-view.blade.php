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
                            <a style="color: #fff;" class="btn btn-primary btn-round btn-sm" href="{{Sideveloper::selfUrl('pekerjaan-form')}}">
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
                                {!!Sideveloper::formSelect('Dinas',  $dinas, 'id_dinas')!!}
                                {!!Sideveloper::formSelect('Status',  array(
                                    array('name'=>'--- Semua Status ---', 'value'=>'0'),
                                    array('name'=>'Selesai', 'value'=>'1'),
                                    array('name'=>'Belum Selesai', 'value'=>'2'),
                                ), 'status')!!}
                            </div>
                            <div class="col-md-4">
                                {!!Sideveloper::formSelect('Jenis Pengadaan',  $jenis, 'id_jenis_pengadaan')!!}
                                {!!Sideveloper::formSelect('Sumber Dana',  $sumber, 'id_sumber')!!}
                            </div>
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table id="data-list" class="display table table-striped table-hover table-full" >
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Action</th>
                                        <th>Dinas</th>
                                        <th>Pekerjaan</th>
                                        <th>Tahun</th>
                                        <th>Nilai Pagu</th>
                                        <th>Sumber</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Action</th>
                                        <th>Dinas</th>
                                        <th>Pekerjaan</th>
                                        <th>Tahun</th>
                                        <th>Nilai Pagu</th>
                                        <th>Sumber</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
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
    $("#id_dinas, #id_jenis_pengadaan, #id_sumber, #status").change(function(){
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
            url  : "{{Sideveloper::selfUrl('pekerjaan-table')}}",
            type : "get",            
            data: function(d) {
                d.id_jenis_pengadaan = $("#id_jenis_pengadaan").val();
                d.id_sumber          = $("#id_sumber").val();
                d.id_dinas           = $("#id_dinas").val();
                d.status           = $("#status").val();
            },
            error: function(){ 
                $(".employee-grid-error").html("");
                $("#data-list").append('<tbody class="employee-grid-error"><tr><th colspan="8"><center>Internal Server Error</center></th></tr></tbody>');
                $("#data-list_processing").css("display","none");
            }
        },
        drawCallback: function (settings) {
            var response = settings.json;
            $('.badge-waiting').html(response.recordsTotal);
        },
        columns : [
            { "data" : "id_pekerjaan" },
            { "data" : "nama_dinas" },
            { "data" : "nama" },
            { "data" : "tahun_anggaran" },
            { "data" : "nilai_pagu" },
            { "data" : "sumber" },
            { "data" : "jenis_pengadaan" },
            { "data" : "status" },
        ],
        columnDefs: [
            {
                targets : 0,
                orderable: false, 
                data: "id_pekerjaan",
                render: function ( data, type, row, meta ) {
                    return `
                            <div class="form-button-action">
                                <a href="{{Sideveloper::selfUrl('pekerjaan-form?id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-warning btn-lg" data-original-title="Ubah">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="button" onclick="hapus(${data})" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>`;
                }
            },
            {
                targets : 4,
                orderable: false, 
                data: "nilai_pagu",
                render: function ( data, type, row, meta ) {
                    return formatRupiah(data);
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
                    url: "{{Sideveloper::selfUrl('pekerjaan-hapus')}}",
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