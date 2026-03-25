@extends('layouts.app')

@section('title', 'Manajemen Section Menu (Header)')

@section('actions')
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSection" onclick="resetForm()">
    <i class="fas fa-plus"></i> Tambah Section
</button>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped w-100" id="datatable">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th>Nama Section</th>
                    <th>Urutan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Section -->
<div class="modal fade" id="modalSection" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="formData" class="ajax-form" action="{{ route('menu-sections.store') }}" method="POST">
                @csrf
                <div id="methodContainer"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Section <span class="text-danger">*</span></label>
                        <input type="text" name="section_name" id="section_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                        <input type="number" name="order" id="order" class="form-control" required value="1">
                    </div>
                </div>
                <div class="modal-footer bg-light">
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
            ajax: "{{ route('menu-sections.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'section_name', name: 'section_name' },
                { data: 'order', name: 'order' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    function editSection(id) {
        axios.get(`/menu-sections/${id}`)
            .then(res => {
                let d = res.data.data;
                $('#modalTitle').text('Edit Section');
                $('#formData').attr('action', `/menu-sections/${id}`);
                $('#methodContainer').html('<input type="hidden" name="_method" value="PUT">');
                $('#section_name').val(d.section_name);
                $('#order').val(d.order);
                $('#modalSection').modal('show');
            });
    }

    function resetForm() {
        $('#modalTitle').text('Tambah Section');
        $('#formData').attr('action', "{{ route('menu-sections.store') }}");
        $('#methodContainer').html('');
        $('#formData')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    }
</script>
@endpush
