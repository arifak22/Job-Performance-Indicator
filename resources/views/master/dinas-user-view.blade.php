<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{$title}}</h4>
        {!!Sideveloper::breadcrumb($breadcrumbs)!!}
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="formId">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    {!!Sideveloper::formInput('Nama Lengkap', 'text', 'nama')!!}
                                    {!!Sideveloper::formInput('NIP', 'text', 'nip')!!}
                                    {!!Sideveloper::formInput('Pangkat / Golongan', 'text', 'golongan')!!}
                                    {!!Sideveloper::formInput('No HP', 'text', 'no_hp')!!}
                                    {!!Sideveloper::formInput('E-mail', 'text', 'email')!!}
                                </div>
                                <div class="col-md-6">
                                    {!!Sideveloper::formHidden('id')!!}
                                    {!!Sideveloper::formHidden('tipe_form', $tipe)!!}
                                    {!!Sideveloper::formInput('Username', 'text', 'username')!!}
                                    {!!Sideveloper::formInput('Password', 'text', 'password', '123456')!!}
                                    {!!Sideveloper::formSelect('Dinas', $dinas, 'id_dinas', $data->id_dinas)!!}
                                    {!!Sideveloper::formSelect('Privilege', $privilege, 'id_privilege')!!}
                                </div>
                            </div>
                            {!!Sideveloper::formSubmit('Simpan', 'submit')!!}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        {{-- <button class="btn btn-primary btn-border btn-sm" onclick="searchStatus()"><i class="fas fa-search"></i> Advance Search</button> --}}
                        <div class="ml-auto">
                            {{-- <a style="color: #fff;" class="btn btn-primary btn-round btn-sm" href="{{Sideveloper::selfUrl('user-form')}}">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="form-search">
                        <div class="row">
                            <div class="col-md-4">
                                {!!Sideveloper::formSelect('Dinas',  $dinas, 'id_dinas')!!}
                            </div>
                            <div class="col-md-4">
                                {!!Sideveloper::formSelect('Privilege',  $privilege, 'id_privilege')!!}
                            </div>
                        </div>
                    </div> --}}
                        <div class="table-responsive">
                            <table id="data-list" class="display table table-striped table-hover table-full" >
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Action</th>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Dinas</th>
                                        <th>Privilege</th>
                                        <th>NIP</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Action</th>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Dinas</th>
                                        <th>Privilege</th>
                                        <th>NIP</th>
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
    $("#id_dinas, #id_privilege").change(function(){
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
            url  : "{{Sideveloper::selfUrl('user-table')}}",
            type : "get",            
            data: function(d) {
                d.id_privilege = [1,3];
                d.id_dinas     = "{{$data->id_dinas}}";
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
            { "data" : "id" },
            { "data" : "username" },
            { "data" : "nama" },
            { "data" : "nama_dinas" },
            { "data" : "nama_privilege" },
            { "data" : "nip" },
        ],
        columnDefs: [
            {
                targets : 0,
                orderable: false, 
                data: "id",
                render: function ( data, type, row, meta ) {
                    return `
                            <div class="form-button-action">
                                <a href="{{Sideveloper::selfUrl('user-detail?from=list&id=')}}${data}" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-lg" data-original-title="Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <button onclick="ubah(${data})" data-toggle="tooltip" title="" class="btn btn-link btn-warning btn-lg" data-original-title="Ubah">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" onclick="hapus(${data})" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
                                    <i class="fa fa-times"></i>
                                </button>
                                <button type="button" onclick="resetPass(${data})" data-toggle="tooltip" title="" class="btn btn-link btn-info" data-original-title="Reset Password">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </div>`;
                }
            },
            {
                targets : 3,
                visible: false, 
                data: "nama_dinas",
            }
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
                    url: "{{Sideveloper::selfUrl('user-hapus')}}",
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

    function resetPass(id){
        swal({
            title: "Apakah anda yakin?",
            text: "Reset Password 123456!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                apiLoading(true);
                $.ajax({
                    method: "POST",
                    url: "{{Sideveloper::selfUrl('user-reset')}}",
                    data: { id: id, _token: "{{ csrf_token() }}" }
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

    function ubah(id){
        // $("#nama").val('dsd');

        apiLoading(true);
        $.ajax({
            method: "GET",
            url: "{{Sideveloper::selfUrl('user-id')}}",
            data: { id: id, _token: "{{ csrf_token() }}" }
        })
        .done(function(res) {
            apiRespone(res,
                (res)=>{
                    $("#id").val(res.id);
                    $("#nama").val(res.data.nama);
                    $("#nip").val(res.data.nip);
                    $("#golongan").val(res.data.golongan);
                    $("#no_hp").val(res.data.no_hp);
                    $("#email").val(res.data.email);
                    $("#tipe_form").val('2');
                    $("#username").val(res.data.username);
                    $("#username").prop('disabled', true);
                    $("#all-password").hide();
                    $("#id_privilege").val(res.data.id_privilege);
                    $("#label-submit").html('Ubah');
                    window.scrollTo(0,0);
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
    
$('#submit').click(function(e) {
    e.preventDefault();
    var btn = $(this);
    var form = $(this).closest('form');
    if($("#id_privilege").val() == 2 ||$("#id_privilege").val() == 4){
        
    }else{
        if(!$("#id_dinas").val()){
            swal('Selain Kepala UKBPJ / Admin, wajib memilih dinas');
            return false;
        }
    }
    form.validate({
        rules: {
            nama: {
                maxlength: 200,
                required: true,
            },
            nip: {
                maxlength: 50,
                required: true,
            },
            golongan: {
                maxlength: 100,
                required: true,
            },
            no_hp: {
                maxlength: 12,
                required: true,
            },
            email: {
                maxlength: 200,
                required: true,
                regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },
            id_dinas: {
                required: false,
            },
            id_privilege: {
                required: true,
            },
            username: {
                required: true,
                maxlength: 50,
                regex: /^[a-z0-9]+(?:[ _-][a-z0-9]+)*$/
            },
            password: {
                maxlength: 150,
                required: true,
            },
        }
    });
    if (!form.valid()) {
        return;
    }
    apiLoading(true, btn);            
    form.ajaxSubmit({
        url : "{{url('master/user-form')}}",
        data: { _token: "{{ csrf_token() }}" },
        type: 'POST',
        success: function(response) {
            apiLoading(false, btn);
            apiRespone(response,
                false
                ,
                (res) => {
                    if(res.api_status == '1'){
                        $("#formId").get(0).reset();
                        $("#username").prop('disabled', false);
                        $("#all-password").show();
                        $("#label-submit").html('Simpan');
                        refreshTable();
                    }
                }
            );
        },
        error: function(error){
            apiLoading(false, btn);
            swal(error.statusText);
        }
    });
});
</script>