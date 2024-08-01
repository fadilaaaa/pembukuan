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
                            @foreach ($kategori as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td><span class="badge {{ $item->class }}">{{ $item->nama }}</span></td>
                                    <td>
                                        <form action="{{ url('setting/' . $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-warning btn_edit"
                                                data-id="{{ $item->id }}" data-nama="{{ $item->nama }}">Edit</button>

                                            <input class="btn btn-danger" type="submit" value="Hapus">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
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
                <form action="" method="post" id="modalForm">
                    @csrf
                    <input id="modalMethod" type="hidden" name="_method">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5> --}}
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Kategori</label>
                            <input id="modalNama" name="nama" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#btnadd').click(function() {

                $('#modalForm').attr('action', '');
                $('#dialogmodal').modal('show');
            });
            $('.btn_edit').each(function() {
                const btn_edit = $(this)
                btn_edit.on('click', function() {
                    // console.log(this);
                    $('#modalMethod').val('put')
                    $('#modalNama').val(btn_edit.data('nama'))
                    $('#modalForm').attr('action', "{{ url('/setting') }}/" + btn_edit.data('id'));
                    $('#dialogmodal').modal('show');
                });
            });
        });
    </script>
@endpush
