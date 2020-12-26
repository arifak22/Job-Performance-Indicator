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
                                    {!!Sideveloper::formHidden('id', $tipe == 2 ? Crypt::encryptString($data->id_pekerjaan) : '')!!}
                                    {!!Sideveloper::formHidden('tipe_form', $tipe)!!}
                                    {!!Sideveloper::formSelect('Dinas', $dinas, 'id_dinas', $tipe == 2 ? $data->id_dinas : '')!!}
                                    {!!Sideveloper::formInput('Nama Pekerjaan', 'text', 'nama', $tipe == 2 ? $data->nama : '')!!}
                                    {!!Sideveloper::formText('Uraian', 'uraian', $tipe == 2 ? $data->uraian : '')!!}
                                    {!!Sideveloper::formSelect('Tahun Anggaran', $year, 'tahun_anggaran', $tipe == 2 ? $data->tahun_anggaran : date('Y'))!!}
                                    {!!Sideveloper::formInput('Nilai Pagu', 'number', 'nilai_pagu', $tipe == 2 ? $data->nilai_pagu : '')!!}
                                </div>
                                <div class="col-md-6">
                                    {!!Sideveloper::formSelect('Sumber Dana', $sumber, 'id_sumber', $tipe == 2 ? $data->id_sumber : '')!!}
                                    {!!Sideveloper::formSelect('Jenis Pengadaan', $jenis, 'id_jenis_pengadaan', $tipe == 2 ? $data->id_jenis_pengadaan : '')!!}
                                    {!!Sideveloper::formInput('Pemanfaatan Barang / Jasa', 'text', 'pemanfaatan_barang', $tipe == 2 ? $data->pemanfaatan_barang : date('Y-m'), 'readonly')!!}
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
    
$('#pemanfaatan_barang').datepicker({
    autoclose  : true,
    format     : 'yyyy-mm',
    orientation: "bottom left",
    viewMode: "months", 
    minViewMode: "months"
});
$('#submit').click(function(e) {
    e.preventDefault();
    var btn = $(this);
    var form = $(this).closest('form');
    form.validate({
        rules: {
            id_dinas: {
                required: true,
            },
            nama: {
                required: true,
                maxlength: 200,
            },
            uraian: {
                required: true,
                maxlength: 500,
            },
            nomor_siup: {
                required: true,
                maxlength: 200,
            },
            tahun_anggaran: {
                required: true,
            },
            nilai_pagu: {
                required: true,
                min: 0,
            },
            id_sumber: {
                required: true,
            },
            id_jenis_pengadaan: {
                required: true,
            },
            pemanfaatan_barang: {
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
                    window.location = "{{Sideveloper::selfUrl('pekerjaan')}}";
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