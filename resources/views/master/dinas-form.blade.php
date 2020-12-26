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
                                    {!!Sideveloper::formHidden('id', $tipe == 2 ? Crypt::encryptString($data->id_dinas) : '')!!}
                                    {!!Sideveloper::formHidden('tipe_form', $tipe)!!}
                                    {!!Sideveloper::formInput('Nama Lengkap Dinas', 'text', 'nama_lengkap', $tipe == 2 ? $data->nama_lengkap : '')!!}
                                    {!!Sideveloper::formInput('Nama KOP Dinas', 'text', 'nama', $tipe == 2 ? $data->nama : '')!!}
                                    {!!Sideveloper::formInput('Nomor Telepon', 'text', 'no_telp', $tipe == 2 ? $data->no_telp : '')!!}
                                </div>
                                <div class="col-md-6">
                                    {!!Sideveloper::formText('Alamat', 'alamat', $tipe == 2 ? $data->alamat : '')!!}
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
    form.validate({
        rules: {
            nama_lengkap: {
                maxlength: 200,
                required: true,
            },
            nama: {
                maxlength: 55,
                required: true,
            },
            alamat: {
                maxlength: 255,
                required: true,
            },
            no_telp: {
                maxlength: 20,
                required: true,
            },
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
                    window.location = "{{Sideveloper::selfUrl('dinas')}}";
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