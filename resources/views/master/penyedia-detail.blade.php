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
                        <h4>Rincian</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Jenis Penyedia</th>
                                <td>:</td>
                                <td>{{$data->name}}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>{{$data->nama}}</td>
                            </tr>
                            <tr>
                                <th>NPWP</th>
                                <td>:</td>
                                <td>{{$data->npwp}}</td>
                            </tr>
                            <tr>
                                <th>Nomor SIUP / NIB</th>
                                <td>:</td>
                                <td>{{$data->nomor_siup}}</td>
                            </tr>
                            <tr>
                                <th>Kemampuan Keuangan (Modal Awal)</th>
                                <td>:</td>
                                <td>{{Sideveloper::rupiah_format($data->modal)}}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Personil</th>
                                <td>:</td>
                                <td>{{$data->jumlah_personil}}</td>
                            </tr>
                            <tr>
                                <th>Nama Direktur</th>
                                <td>:</td>
                                <td>{{$data->nama_direktur}}</td>
                            </tr>
                            <tr>
                                <th>Nama Komisaris</th>
                                <td>:</td>
                                <td>{{$data->nama_komisaris}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4>Berkas</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Dokumen NIB</th>
                                <td>:</td>
                                <td><a target="_blank" href="{{Sideveloper::storageUrl($data->nib)}}">File</a></td>
                            </tr>
                            <tr>
                                <th>Akta Perseroan</th>
                                <td>:</td>
                                <td><a target="_blank" href="{{Sideveloper::storageUrl($data->akta)}}">File</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>