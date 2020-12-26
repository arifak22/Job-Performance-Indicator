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
                                    {!!Sideveloper::formHidden('id', $tipe == 2 ? Crypt::encryptString($data->id_penyedia) : '')!!}
                                    {!!Sideveloper::formHidden('tipe_form', $tipe)!!}
                                    {!!Sideveloper::formSelect('Jenis', $jenis, 'id_jenis', $tipe == 2 ? $data->id_jenis : '')!!}
                                    {!!Sideveloper::formInput('Nama', 'text', 'nama', $tipe == 2 ? $data->nama : '')!!}
                                    {!!Sideveloper::formInput('NPWP', 'text', 'npwp', $tipe == 2 ? $data->npwp : '')!!}
                                    {!!Sideveloper::formInput('Nomor SIUP / NIB (Nomor Induk Bersama)', 'text', 'nomor_siup', $tipe == 2 ? $data->nomor_siup : '')!!}
                                    {!!Sideveloper::formText('Sarana dan Prasarana', 'sarana', $tipe == 2 ? $data->sarana : '')!!}
                                    {!!Sideveloper::formFile('Dokumen NIB', 'nib', "accept = \"application/pdf\"",$tipe == 2 ? '*Pdf 500KB. Biarkan Kosong, jika tidak ingin merubah' : '*PDF, Max 500KB.' , $tipe == 2 ? $data->nib : '')!!}
                                    {!!Sideveloper::formFile('Akta Perseroan', 'akta', "accept = \"application/pdf\"",$tipe == 2 ? '*Pdf 1MB. Biarkan Kosong, jika tidak ingin merubah'  : '*PDF, Max 1MB.', $tipe == 2 ? $data->akta : '')!!}
                                </div>
                                <div class="col-md-6">
                                    {!!Sideveloper::formInput('Kemampuan Keuangan (Modal Awal Perusahaan)', 'number', 'modal', $tipe == 2 ? $data->modal : '')!!}
                                    {!!Sideveloper::formText('Jumlah Personil SDM / Tenaga Ahli', 'jumlah_personil', $tipe == 2 ? $data->jumlah_personil : '')!!}
                                    {!!Sideveloper::formInput('Nama Direktur', 'text', 'nama_direktur', $tipe == 2 ? $data->nama_direktur : '')!!}
                                    {!!Sideveloper::formInput('Nama Komisaris', 'text', 'nama_komisaris', $tipe == 2 ? $data->nama_komisaris : '')!!}
                                    {!!Sideveloper::formInput('Nomor Telepon', 'text', 'no_telp', $tipe == 2 ? $data->no_telp : '')!!}
                                    {!!Sideveloper::formInput('E-mail', 'text', 'email', $tipe == 2 ? $data->email : '')!!}
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
            id_jenis: {
                required: true,
            },
            nama: {
                required: true,
                maxlength: 200,
            },
            npwp: {
                required: true,
                maxlength: 200,
            },
            nomor_siup: {
                required: true,
                maxlength: 200,
            },
            no_telp: {
                required: true,
                maxlength: 20,
            },
            email: {
                required: true,
                maxlength: 200,
                regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },
            alamat: {
                required: true,
                maxlength: 500,
            },
            sarana: {
                required: true,
                maxlength: 500,
            },
            @if($tipe == 1)
            nib: {
                required: true,
            },
            akta: {
                required: true,
            },
            @endif
            modal: {
                required: true,
                min: 0,
            },
            jumlah_personil: {
                required: true,
                maxlength: 800,
            },
            nama_direktur: {
                required: true,
                maxlength: 100,
            },
            nama_komisaris: {
                required: true,
                maxlength: 100,
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
                    window.location = "{{Sideveloper::selfUrl('penyedia')}}";
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