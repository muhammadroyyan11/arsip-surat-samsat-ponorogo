@extends('layouts.app')

@section('title', 'Manajemen Staff')

@section('actions')
<a href="{{ route('staffs.export') }}" class="btn btn-success me-2">
    <i class="fas fa-file-excel"></i> Export Excel
</a>
<button class="btn btn-warning text-dark me-2" data-bs-toggle="modal" data-bs-target="#modalImport">
    <i class="fas fa-file-import"></i> Import Excel
</button>
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="resetForm()">
    <i class="fas fa-plus"></i> Tambah Staff
</button>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped w-100" id="datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>NIP</th>
                    <th>Nama Lengkap</th>
                    <th>Divisi</th>
                    <th>Jabatan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formData" class="ajax-form" action="{{ route('staffs.store') }}" method="POST">
                @csrf
                <div id="methodContainer"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" placeholder="Nomor Induk Pegawai">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Divisi <span class="text-danger">*</span></label>
                            <select name="division_id" id="division_id" class="form-select" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisions as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <select name="position_id" id="position_id" class="form-select" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach($positions as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="address" id="address" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('staffs.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Staff dari Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info py-2 small">
                        Pastikan file excel Anda memiliki header kolom (sesuai template Export): 
                        <br><b>nip, nama, no_hp, alamat, divisi, jabatan</b>
                        <br><a href="{{ route('staffs.template') }}" class="alert-link"><i class="fas fa-download"></i> Download Template</a>
                    </div>
                    <div class="mb-3">
                        <label>Pilih File Excel (.xlsx) <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx, .xls, .csv">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark">Import</button>
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
            ajax: "{{ route('staffs.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nip', name: 'nip' },
                { data: 'name', name: 'name' },
                { data: 'division_name', name: 'division.name', orderable: false, searchable: false },
                { data: 'position_name', name: 'position.name', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.btn-edit', function() {
            let url = $(this).data('url');
            
            $('#modalTitle').text('Edit Staff');
            $('#formData').attr('action', url);
            $('#methodContainer').html('<input type="hidden" name="_method" value="PUT">');
            
            $('#name').val($(this).data('name'));
            $('#nip').val($(this).data('nip'));
            $('#phone').val($(this).data('phone'));
            $('#address').val($(this).data('address'));
            $('#division_id').val($(this).data('division'));
            $('#position_id').val($(this).data('position'));
            
            $('#modalForm').modal('show');
        });
    });

    function resetForm() {
        $('#modalTitle').text('Tambah Staff');
        $('#formData').attr('action', "{{ route('staffs.store') }}");
        $('#methodContainer').html('');
        $('#formData')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    }
</script>
@endpush
