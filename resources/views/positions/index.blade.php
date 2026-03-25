@extends('layouts.app')

@section('title', 'Manajemen Jabatan')

@section('actions')
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="resetForm()">
    <i class="fas fa-plus"></i> Tambah Jabatan
</button>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped w-100" id="datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Jabatan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formData" class="ajax-form" action="{{ route('positions.store') }}" method="POST">
                @csrf
                <div id="methodContainer"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="Masukkan nama jabatan...">
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('positions.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.btn-edit', function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            
            $('#modalTitle').text('Edit Jabatan');
            $('#formData').attr('action', url);
            $('#methodContainer').html('<input type="hidden" name="_method" value="PUT">');
            $('#name').val(name);
            $('#modalForm').modal('show');
        });
    });

    function resetForm() {
        $('#modalTitle').text('Tambah Jabatan');
        $('#formData').attr('action', "{{ route('positions.store') }}");
        $('#methodContainer').html('');
        $('#formData')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    }
</script>
@endpush
