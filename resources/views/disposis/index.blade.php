@extends('layouts.app')

@section('title', 'Disposisi Saya')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="datatable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nomor Surat</th>
                        <th>Pengirim</th>
                        <th>Dari</th>
                        <th>Perihal</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header bg-info">
                <h5 class="modal-title fw-bold text-white">Detail Disposisi & Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold border-bottom">Informasi Surat</h6>
                        <table class="table table-sm">
                            <tr><td width="40%">Nomor Surat</td><td id="det_nomor"></td></tr>
                            <tr><td>Pengirim</td><td id="det_pengirim"></td></tr>
                            <tr><td>Kategori</td><td id="det_kategori"></td></tr>
                            <tr><td>Perihal</td><td id="det_perihal"></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold border-bottom">Instruksi Pimpinan</h6>
                        <table class="table table-sm">
                            <tr><td width="40%">Dari</td><td id="det_dari"></td></tr>
                            <tr><td>Sifat</td><td id="det_sifat"></td></tr>
                            <tr><td>Tenggat</td><td id="det_tenggat"></td></tr>
                        </table>
                        <div class="alert alert-warning">
                            <strong>Catatan:</strong> <br>
                            <span id="det_catatan"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('disposis.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nomor_surat', name: 'nomor_surat' },
                { data: 'pengirim', name: 'pengirim' },
                { data: 'dari', name: 'dari' },
                { data: 'surat_masuk.perihal', name: 'suratMasuk.perihal' },
                { data: 'status_label', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    function viewDetail(id) {
        axios.get(`/disposis/${id}`)
            .then(res => {
                let d = res.data.data;
                $('#det_nomor').text(d.surat_masuk.nomor_surat);
                $('#det_pengirim').text(d.surat_masuk.pengirim);
                $('#det_kategori').text(d.surat_masuk.kategori.name);
                $('#det_perihal').text(d.surat_masuk.perihal);
                $('#det_dari').text(d.from_user.name);
                $('#det_sifat').text(d.sifat);
                $('#det_tenggat').text(d.deadline || '-');
                $('#det_catatan').text(d.catatan_disposisi);
                $('#modalDetail').modal('show');
            });
    }

    function markDone(id) {
        Swal.fire({
            title: 'Konfirmasi Selesai?',
            text: "Pastikan tugas disposisi sudah Anda laksanakan.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Selesai!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(`/disposis/${id}/done`)
                    .then(res => {
                        Swal.fire('Berhasil', res.data.message, 'success');
                        $('#datatable').DataTable().ajax.reload();
                    });
            }
        });
    }
</script>
@endpush
