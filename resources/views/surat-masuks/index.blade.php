@extends('layouts.app')

@section('title', 'Surat Masuk')

@section('actions')
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="resetForm()">
    <i class="fas fa-plus"></i> Tambah Surat Masuk
</button>
@endsection

@section('content')
<div class="card">
    <div class="card-body border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="datatable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nomor Surat</th>
                        <th>Tgl Surat</th>
                        <th>Tgl Terima</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Kategori</th>
                        <th>Pencatat</th>
                        <th>File</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form id="formData" class="ajax-form" action="{{ route('surat-masuks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="methodContainer"></div>
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Surat Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor Surat <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori Surat <span class="text-danger">*</span></label>
                            <select name="kategori_id" id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategories as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Surat <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Diterima <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_terima" id="tanggal_terima" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Pengirim <span class="text-danger">*</span></label>
                            <input type="text" name="pengirim" id="pengirim" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Perihal Surat <span class="text-danger">*</span></label>
                            <textarea name="perihal" id="perihal" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">File Lampiran (PDF/Doc/Img, max 5MB)</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                            <small class="text-muted">Kosongkan jika tidak ingin mngubah file (saat edit).</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Disposisi -->
<div class="modal fade" id="modalDisposisi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="formDisposisi" class="ajax-form" action="{{ route('disposis.store') }}" method="POST">
                @csrf
                <input type="hidden" name="surat_masuk_id" id="disp_surat_id">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold text-white">Kirim Disposisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipe Target <span class="text-danger">*</span></label>
                        <select name="target_type" id="target_type" class="form-select" required onchange="toggleTargetInput()">
                            <option value="staff">Per Staff (Personal)</option>
                            <option value="division">Per Divisi (Broadcast)</option>
                            <option value="all">Semua Staff (Broadcast All)</option>
                        </select>
                    </div>
                    <div class="mb-3" id="target_staff_container">
                        <label class="form-label fw-semibold">Pilih Staff <span class="text-danger">*</span></label>
                        <select name="to_user_id" id="to_user_id" class="form-select">
                            <option value="">-- Pilih Penerima --</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="target_division_container" style="display:none;">
                        <label class="form-label fw-semibold">Pilih Divisi <span class="text-danger">*</span></label>
                        <select name="division_id" id="division_id" class="form-select">
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisions as $div)
                            <option value="{{ $div->id }}">{{ $div->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sifat <span class="text-danger">*</span></label>
                        <select name="sifat" class="form-select" required>
                            <option value="Biasa">Biasa</option>
                            <option value="Penting">Penting</option>
                            <option value="Segera">Segera</option>
                            <option value="Rahasia">Rahasia</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tenggat Waktu (Sensitif SAMSAT)</label>
                        <input type="date" name="deadline" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Instruksi / Catatan <span class="text-danger">*</span></label>
                        <textarea name="catatan_disposisi" class="form-control" rows="3" required placeholder="Contoh: Segera tindaklanjuti, buat laporan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white"><i class="fas fa-paper-plane"></i> Kirim Disposisi</button>
                </div>
            </form>
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
            ajax: "{{ route('surat-masuks.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nomor_surat', name: 'nomor_surat' },
                { data: 'tanggal_surat', name: 'tanggal_surat' },
                { data: 'tanggal_terima', name: 'tanggal_terima' },
                { data: 'pengirim', name: 'pengirim' },
                { data: 'perihal', name: 'perihal' },
                { data: 'kategori_name', name: 'kategori.name', orderable: false, searchable: false },
                { data: 'user_name', name: 'user.name', orderable: false, searchable: false },
                { data: 'file_link', name: 'file_link', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.btn-edit', function() {
            let url = $(this).data('url');
            
            $('#modalTitle').text('Edit Surat Masuk');
            $('#formData').attr('action', url);
            
            $('#methodContainer').html('<input type="hidden" name="_method" value="PUT">');
            
            $('#nomor_surat').val($(this).data('nomor'));
            $('#tanggal_surat').val($(this).data('tglsurat'));
            $('#tanggal_terima').val($(this).data('tglterima'));
            $('#pengirim').val($(this).data('pengirim'));
            $('#perihal').val($(this).data('perihal'));
            $('#kategori_id').val($(this).data('kategori'));
            $('#file').val('');
            
            $('#modalForm').modal('show');
        });
    });

    function openDisposisi(id) {
        $('#formDisposisi')[0].reset();
        $('#disp_surat_id').val(id);
        $('#modalDisposisi').modal('show');
    }

    function resetForm() {
        $('#modalTitle').text('Tambah Surat Masuk');
        $('#formData').attr('action', "{{ route('surat-masuks.store') }}");
        $('#methodContainer').html('');
        $('#formData')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    }

    function toggleTargetInput() {
        const type = $('#target_type').val();
        if (type == 'staff') {
            $('#target_staff_container').show();
            $('#to_user_id').prop('required', true);
            $('#target_division_container').hide();
            $('#division_id').prop('required', false);
        } else if (type == 'division') {
            $('#target_staff_container').hide();
            $('#to_user_id').prop('required', false);
            $('#target_division_container').show();
            $('#division_id').prop('required', true);
        } else {
            $('#target_staff_container').hide();
            $('#to_user_id').prop('required', false);
            $('#target_division_container').hide();
            $('#division_id').prop('required', false);
        }
    }

    // Call it initially just in case
    toggleTargetInput();
</script>
@endpush
