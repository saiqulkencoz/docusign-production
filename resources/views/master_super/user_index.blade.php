@extends('master_super.master')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title">
                        <h2>Dashboard</h2>
                    </div>
                    @if (session('Sukses'))
                        <div class="alert alert-success col-lg-12" role="alert">
                            {{ session('Sukses') }}
                        </div>
                    @endif
                </div>
            </div>
            <!-- main -->
            <div class="row column2 graph margin_bottom_30">
                <div class="col-md-l2 col-lg-12">
                    <div class="white_shd full">
                        <div class="full graph_head">
                            <div class="heading1 margin_0">
                                <h2>Daftar User</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content">
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <div class="button_block">
                                                <button type="button" class="btn cur-p btn-primary mb-3 float-right"
                                                    data-toggle="modal" data-target="#tambahdata">Tambah Data</button>
                                            </div>
                                            <table class="table table-striped table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama</th>
                                                        <th>NIK</th>
                                                        <th>Role</th>
                                                        <th>Instansi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user as $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->nama }}</td>
                                                            <td>{{ $data->nik }}</td>
                                                            <td>{{ $data->role }}</td>
                                                            <td>{{ $data->instansi->nama }}</td>
                                                            <td>
                                                                <div style="text-align:center">
                                                                    <a href="/super/user/edit/{{ $data->id }}"
                                                                        class="btn btn-warning btn-sm">EDIT</a>
                                                                    <a href="/super/user/delete/{{ $data->id }}"
                                                                        class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Anda Yakin ?')">DELETE</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end graph -->
        </div>
        <!-- footer -->
        <div class="container-fluid">
            <div class="footer">
                <div class="row">
                    <div class="col-lg-3">
                        <img width="210" src="{{ asset('master/images/logo/footer.jfif') }}" alt="#" />
                    </div>
                    <div class="col-lg-6">
                        <p>Copyright © 2022 Designed by Diskominfo Kota Batu</p>
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create-user') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" placeholder="Masukkan Nama" class="form-control" required
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" name="role">
                                <option value="admin" selected>Admin</option>
                                <option value="kepala dinas">Kepala Dinas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" name="nik" placeholder="Masukkan NIK" class="form-control" required
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <script>
                                $(document).ready(function() {
                                    $("#show_hide_password a").on('click', function(event) {
                                        event.preventDefault();
                                        if ($('#show_hide_password input').attr("type") == "text") {
                                            $('#show_hide_password input').attr('type', 'password');
                                            $('#show_hide_password i').addClass("fa-eye-slash");
                                            $('#show_hide_password i').removeClass("fa-eye");
                                        } else if ($('#show_hide_password input').attr("type") == "password") {
                                            $('#show_hide_password input').attr('type', 'text');
                                            $('#show_hide_password i').removeClass("fa-eye-slash");
                                            $('#show_hide_password i').addClass("fa-eye");
                                        }
                                    });
                                });
                            </script>
                            <label>Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control" name="password" placeholder="Masukkan Password"
                                    required autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Instansi</label>
                            <select class="form-control" name="instansi_id">
                                @foreach ($instansi as $opt_instansi)
                                    <option value="{{ $opt_instansi->id }}">{{ $opt_instansi->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
