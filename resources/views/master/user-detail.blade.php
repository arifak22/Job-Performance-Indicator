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
                                <th>Username</th>
                                <td>:</td>
                                <td>{{$data->username}}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>{{$data->nama}}</td>
                            </tr>
                            <tr>
                                <th>Dinas</th>
                                <td>:</td>
                                <td>{{$data->nama_dinas}}</td>
                            </tr>
                            <tr>
                                <th>Privilege</th>
                                <td>:</td>
                                <td>{{$data->nama_privilege}}</td>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <td>:</td>
                                <td>{{$data->nip}}</td>
                            </tr>
                            <tr>
                                <th>Golongan</th>
                                <td>:</td>
                                <td>{{$data->golongan}}</td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td>:</td>
                                <td>{{$data->no_hp}}</td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <td>:</td>
                                <td>{{$data->email}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>