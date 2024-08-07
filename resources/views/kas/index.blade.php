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
                                <select id="jenis" class="form-control" name="jenis">
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
                                <a id="pucer" class="btn btn-primary" style="display: none">Simpan &
                                    download
                                    voucher</a>
                                <button class="btn btn-secondary">Import</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dialogmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input id="modalMethod" type="hidden" name="_method">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Masukkan Nama Ketua & Bendahara</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Ketua</label>
                        <input id="ketua" name="ketua" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Bendahara</label>
                        <input id="bendahara" name="bendahara" type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input id="btnSubmit" type="submit" class="btn btn-primary" value="Submit" />
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('scripts')
    <script>
        const resetSubmit = () => {
            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation: false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            toastMixin.fire({
                animation: true,
                title: 'Data berhasil disimpan'
            });
            // $('#tanggal').val('');
            $('#kategori').val('');
            $('#jenis').val('');
            $('#jumlah').val('');
            $('#keterangan').val('');

            $('#ketua').val('');
            $('#bendahara').val('');
            $('#dialogmodal').modal('hide');

        }
        const submitPucer = () => {
            const tanggal = $('#tanggal').val();
            const jenis = 'keluar';
            const jumlah = $('#jumlah').val().replace(/\D/g, "");
            const kategori = $('#kategori').val();
            const keterangan = $('#keterangan').val();
            const ketua = $('#ketua').val();
            const bendahara = $('#bendahara').val();
            const data = {
                tanggal,
                jenis,
                jumlah,
                kategori,
                keterangan,
                ketua,
                bendahara
            }
            $.ajax({
                url: "{{ url('kelola-kas') }}" + '/pucer',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    resetSubmit();
                    window.location.href = '{{ url('pucer') }}/' + response.id + '?ketua=' + ketua +
                        '&bendahara=' + bendahara;
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
        $(document).ready(function() {
            $('#pucer').on('click', function(e) {
                e.preventDefault();
                $('#dialogmodal').modal('show');
                // submitPucer();
            })
            $('#btnSubmit').on('click', function(e) {
                e.preventDefault();
                const ketua = $('#ketua').val();
                const bendahara = $('#bendahara').val();
                if (ketua && bendahara) {
                    submitPucer();
                } else {
                    alert('Ketua dan Bendahara harus diisi');
                }
            })
            $('#jenis').selectize({
                create: false,
                delimiter: ',',
                persist: false,
                maxItems: 1,
                sortField: 'text',
                onChange: function(value) {
                    console.log($('#pucer'));
                    if (value == 'keluar') {
                        $('#submit').hide();
                        $('#pucer').show();
                    } else {
                        $('#submit').show();
                        $('#pucer').hide();
                    }
                }
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
