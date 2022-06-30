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
                                <h2>Cek Status User</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content">
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <div class="panel">
                                                <form action="{{ route('super-cekuserpost') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label>Masukkan NIK</label><br />
                                                        <div class="form-group">
                                                            <input type="text" name="nik" class="form-control"
                                                                required autocomplete="off" placeholder="Masukkan NIK">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3">Cek Status</button>
                                                </form>
                                                @if (session('Sukses'))
                                                    <table class="table table-bordered mt-3">
                                                        <thead>
                                                            <tr>
                                                                <th>NIK</th>
                                                                <th>Status Code</th>
                                                                <th>Status</th>
                                                                <th>Message</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ session('NIK') }}</td>
                                                                <td>{{ session('Sukses')['status_code'] }}</td>
                                                                <td>{{ session('Sukses')['status'] }}</td>
                                                                <td>{{ session('Sukses')['message'] }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
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
                    <div class="footer">
                        <div class="row">
                            <div class="col-lg-3">
                                <img width="210" src="{{ asset('master/images/logo/footer.jfif') }}" alt="#"/>
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
        </div>
    @endsection
