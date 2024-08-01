@extends('layouts.master')

@section('title', 'Riwayat Arus Kas')
{{-- @dd($kas[0]) --}}
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-11">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Arus Kas</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="row mb-2">
                                <div class="form-row col-12">
                                    <div class="input-group col-md-6 col-xl-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Awal</span>
                                        </div>
                                        <input value="{{ $start_date }}" class="form-control " type="date"
                                            name="start" id="startDate">
                                    </div>
                                    <div class="input-group col-md-6 col-xl-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Akhir</span>
                                        </div>
                                        <input value="{{ $end_date }}" class="form-control " type="date"
                                            name="end" id="endDate">
                                    </div>
                                    <div class="input-group col-md-6 col-xl-5">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Kategori</span>
                                        </div>
                                        <select id="kategori" class="form-control" name="kategori[]" required></select>
                                    </div>
                                    <button class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="table-active">
                                        <th>Nomor Kas</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th class="no-sort">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kas as $item)
                                        <tr
                                            @if ($item->jenis == 'keluar') class="table-danger"
                                            @else
                                            class="table-info" @endif>
                                            <td data-sort="{{ $item->id }}" class="text-nowrap">{{ $item->no_kas }}</td>
                                            <td data-sort="{{ $item->created_at }}" class="text-nowrap">{{ $item->tanggal }}
                                            </td>
                                            @if ($item->jenis == 'masuk')
                                                <td>Kas Masuk</td>
                                            @else
                                                <td>Kas Keluar</td>
                                            @endif
                                            <td>
                                                @if ($item->kategoris)
                                                    @foreach ($item->kategoris as $kategori)
                                                        <span class="badge {{ $kategori->class }}">{{ $kategori->nama }}
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-nowrap">Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                            <td>{{ $item->keterangan }}</td>
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
    <div class="modal fade" id="dialogmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('/cetak-laporan') }}" method="post" id="modalForm">
                    @csrf
                    <input id="modalMethod" type="hidden" name="_method">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cetak Laporan</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="input-group col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Awal</span>
                                </div>
                                <input class="form-control " type="date" name="start" id="LapstartDate">
                            </div>
                            <div class="input-group col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Akhir</span>
                                </div>
                                <input class="form-control " type="date" name="end" id="LapendDate">
                            </div>
                        </div>
                        {{-- <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Kategori</span>
                            </div>
                            <select id="Lapkategori" class="form-control" name="kategori[]" required></select>
                        </div> --}}
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Ketua</span>
                            </div>
                            <input class="form-control " type="text" name="ketua">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Bendahara</span>
                            </div>
                            <input class="form-control " type="text" name="bendahara">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Cetak" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // $('#dialogmodal').modal('show');
            $('#dataTable').DataTable({
                order: [],
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });
            const dataFilterBox = $('#dataTable_filter');


        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable_length').parent().html(`
        <div class="col-12" id="btn_cetak">
            <button href="{{ url('admin/pengaduan/export') }}" class="btn btn-warning" >
                Cetak Laporan
            </button>
        </div>
        `)
            $('#btn_cetak').on('click', function(e) {
                e.preventDefault();
                $('#dialogmodal').modal('show');
            })
            // $('#dataTable_filter').parent().addClass('col-md-12')
            // $('#dataTable_info').parent().parent().prepend();


            var dataKategori = @json($kat);
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
            const lap_kat_sel = $('#Lapkategori').selectize({
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
            console.log({!! json_encode($selected_kategori) !!});
            const kat_sel_control = kat_sel[0].selectize;
            kat_sel_control.setValue({!! json_encode($selected_kategori) !!});
        });
    </script>
@endpush
