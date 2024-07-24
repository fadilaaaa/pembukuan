@extends('layouts.master')

@section('title', 'Riwayat Arus Kas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-11">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Arus Kas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="form-row col-12">
                                <div class="input-group col-md-6 col-xl-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Awal</span>
                                    </div>
                                    <input class="form-control " type="date" name="start" id="startDate">
                                </div>
                                <div class="input-group col-md-6 col-xl-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Akhir</span>
                                    </div>
                                    <input class="form-control " type="date" name="end" id="endDate">
                                </div>
                                <div class="input-group col-md-6 col-xl-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Kategori</span>
                                    </div>
                                    <select id="kategori" class="form-control" name="kategori[]" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">24 Juli 2024</td>
                                        <td>Kas Keluar</td>
                                        <td>
                                            {{-- <span class="badge badge-success">Umum</span> --}}
                                            <span class="badge badge-warning">BPJS</span>
                                            <span class="badge badge-danger">Hutang</span>
                                        </td>
                                        <td class="text-nowrap">Rp. 200.000</td>
                                        <td>Pasien BPJS a.n Zard al-Qaeda</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({

            });
            const dataFilterBox = $('#dataTable_filter');


        });
    </script>
    <script>
        $(document).ready(function() {
            // $('#dataTable_length').parent().hide()
            // $('#dataTable_filter').parent().addClass('col-md-12')
            $('#dataTable_info').parent().parent().prepend(`
        <div class="col-12" style="display: flex;justify-content: right">
            <a href="{{ url('admin/pengaduan/export') }}" class="btn btn-primary" >
                Export Excel
            </a>
        </div>
        `);
            const dataKategori = [{
                    value: 1,
                    text: 'Tagihan BPJS',
                    class: 'badge-success'
                },
                {
                    value: 2,
                    text: 'Pembayaran BPJS',
                    class: 'badge-warning'
                }
            ];
            $('#kategori').selectize({
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
        });
    </script>
@endpush
