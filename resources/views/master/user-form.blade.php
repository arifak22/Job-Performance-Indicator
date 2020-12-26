<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{$title}}</h4>       
        {!!Sideveloper::breadcrumb($breadcrumbs)!!}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    {!!Sideveloper::formInput('Nama Lengkap', 'text', 'nama', $tipe == 2 ? $data->nama : '')!!}
                                    {!!Sideveloper::formInput('NIP', 'text', 'nip', $tipe == 2 ? $data->nip : '')!!}
                                    {!!Sideveloper::formInput('Pangkat / Golongan', 'text', 'golongan', $tipe == 2 ? $data->golongan : '')!!}
                                    {!!Sideveloper::formInput('No HP', 'text', 'no_hp', $tipe == 2 ? $data->no_hp : '')!!}
                                    {!!Sideveloper::formInput('E-mail', 'text', 'email', $tipe == 2 ? $data->email : '')!!}
                                </div>
                                <div class="col-md-6">
                                    {!!Sideveloper::formHidden('id', $tipe == 2 ? Crypt::encryptString($data->id) : '')!!}
                                    {!!Sideveloper::formHidden('tipe_form', $tipe)!!}
                                    {!!Sideveloper::formInput('Username', 'text', 'username', $tipe == 2 ? $data->username : '', $tipe == 2 ? 'readonly' : '')!!}
                                    @if($tipe == 1)
                                    {!!Sideveloper::formInput('Password', 'text', 'password', $tipe == 2 ? $data->password : '123456')!!}
                                    @endif
                                    {!!Sideveloper::formSelect('Dinas', $dinas, 'id_dinas', $tipe == 2 ? $data->id_dinas : '')!!}
                                    {!!Sideveloper::formSelect('Privilege', $privilege, 'id_privilege', $tipe == 2 ? $data->id_privilege : '')!!}
                                </div>
                            </div>
                            {!!Sideveloper::formSubmit($tipe == 2 ? 'Ubah' : 'Simpan', 'submit')!!}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
            @if($tipe == 1)
            password: {
                maxlength: 150,
                required: true,
            },
            @endif
        }
    });
    if (!form.valid()) {
        return;
    }
    apiLoading(true, btn);            
    form.ajaxSubmit({
        url : "{{url()->current()}}",
        data: { _token: "{{ csrf_token() }}" },
        type: 'POST',
        success: function(response) {
            apiLoading(false, btn);
            apiRespone(response,
                false
                ,
                (res) => {
                    window.location = "{{Sideveloper::selfUrl('user')}}";
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