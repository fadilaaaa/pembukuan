@extends('layouts.master')

@section('title', 'Setting')

@section('content')
    <div class="container-fluid mx-0 px-0">
        <div class="col-xl-12">
            <div class="card shadow mb-1">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Kategori</h6>
                </div>
                <div class="card-body pt-1">
                    <div class="row mb-1">
                        <button id="btnadd" class="btn btn-success" data-toggle="modal"
                            data-target="#dialogmodal">Tambah</button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Badge</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Umum</td>
                                <td><span class="badge badge-success">Umum</span></td>
                                <td>
                                    <button class="btn btn-warning">Edit</button>
                                    <button class="btn btn-danger">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>BPJS</td>
                                <td><span class="badge badge-warning">BPJS</span></td>
                                <td>
                                    <button class="btn btn-warning">Edit</button>
                                    <button class="btn btn-danger">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dialogmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ url('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#btnadd').click(function() {
                $('#dialogmodal').modal('show');
            });
        });
    </script>
@endpush
