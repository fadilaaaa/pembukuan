@extends('layouts.master')

@section('title', 'Tambah Arus Kas')

@section('content')
    <div class="container-fluid mx-0 px-0">
        <div class="col-xl-12">
            <div class="card shadow mb-1">
                <form action="{{ url('kelola-kas') }}" method="post" id="formStore">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Catat Arus Kas</h6>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ date('Y-m-d') }}" required>
                                <label for="kategori">Kategori</label>
                                <select id="kategori" class="form-control" name="kategori[]" required></select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jenis">Jenis</label>
                                <select id="jenis" class="form-control" name="jenis" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="masuk">Kas Masuk</option>
                                    <option value="keluar">Kas Keluar</option>
                                </select>
                                <label for="jumlah">Jumlah</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="currency" class="form-control" id="jumlah" name="jumlah" required>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                            </div>
                            <div class="form-group col-6 d-flex justify-content-around items-center" style="margin: auto">
                                <button id="submit" class="btn btn-primary">Simpan</button>
                                <button class="btn btn-secondary">Import</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#jenis').selectize({
                create: false,
                delimiter: ',',
                persist: false,
                maxItems: 1,
                sortField: 'text'
            });
            const dataKategori = @json($kat);
            console.log(dataKategori);
            const kat_sel = $('#kategori').selectize({
                delimiter: ',',
                persist: false,
                maxItems: null,
                options: dataKategori,
                labelField: 'text',
                valueField: 'value',
                searchField: 'text',

                create: false,
                render: {
                    item: function(item, escape) {
                        return `<span class="badge ${item.class} mr-1">${escape(item.text)}</span>`;
                    },
                }
            })
            $('#jumlah').on({
                keyup: function() {
                    $(this).val(function(index, value) {
                        return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    });
                }
            })
            $('#submit').on('click', function(event) {
                // event.preventDefault();
                console.log($('#jumlah').val());
                $('#jumlah').val($('#jumlah').val().replace(/\D/g, ""));
                $('#formStore').submit();
            })
        });
    </script>
@endpush
