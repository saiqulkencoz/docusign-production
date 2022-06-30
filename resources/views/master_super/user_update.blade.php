@extends('master_super.master')

@section('content')
    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title">
                        <h2>Dashboard</h2>
                    </div>
                </div>
            </div>
            <!-- main -->
            <div class="row column2 graph margin_bottom_30">
                <div class="col-md-l2 col-lg-12">
                    <div class="white_shd full">
                        <div class="full graph_head">
                            <div class="heading1 margin_0">
                                <h2>Edit Data User</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content">
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <form action="/super/user/update/{{ $user->id }}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama" placeholder="Masukkan Nama"
                                                        class="form-control" value="{{ $user->nama }}" required
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <label>NIK</label>
                                                    <input type="text" name="nip" placeholder="Masukkan NIP"
                                                        class="form-control" value="{{ $user->nik }}" required
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <select class="form-control" name="role">
                                                        @if ($user->role == 'admin')
                                                            <option value="admin" selected>Admin</option>
                                                        @else
                                                            <option value="kepala dinas" selected>Kepala Dinas</option>
                                                        @endif
                                                        <option value="" disabled>===============================
                                                        </option>
                                                        <option value="admin">Admin</option>
                                                        <option value="kepala dinas">Kepala Dinas</option>
                                                    </select>
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
                                                    <label>Password BSRE</label>
                                                    <div class="input-group" id="show_hide_password">
                                                        <input type="password" class="form-control" name="pass_bsre"
                                                            placeholder="Masukkan Password BSRE" autocomplete="off"
                                                            value="{{ $user->pass_bsre }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <a href=""><i class="fa fa-eye-slash"
                                                                        aria-hidden="true"></i></a></span>
                                                        </div>
                                                    </div>
                                                    <small style="font-style: italic">*Masukkan hanya jika ingin membuat
                                                        akun Kepala Dinas</small>
                                                </div>
                                                <div class="form-group">
                                                    <label>Instansi</label>
                                                    <select class="form-control" name="instansi_id">
                                                        <option value="{{ $user->instansi->id }}" selected>
                                                            {{ $user->instansi->nama }}</option>
                                                        <option value="" disabled>===============================
                                                        </option>
                                                        @foreach ($instansi as $opt_instansi)
                                                            <option value="{{ $opt_instansi->id }}">
                                                                {{ $opt_instansi->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-warning btn-lg"
                                                    style="width: 15%">Update</button>
                                            </form>
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
@endsection
