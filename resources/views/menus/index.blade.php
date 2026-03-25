@extends('layouts.app')

@section('title', 'Manajemen Menu & Hirarki')

@section('actions')
<a href="{{ route('menu-sections.index') }}" class="btn btn-warning text-white me-2">
    <i class="fas fa-layer-group"></i> Kelola Section (Header)
</a>
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMenu" onclick="resetForm()">
    <i class="fas fa-plus"></i> Tambah Menu
</button>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped w-100" id="datatable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Section</th>
                            <th>Nama Menu</th>
                            <th>URL / Route</th>
                            <th>Icon</th>
                            <th>Urutan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Menu -->
<div class="modal fade" id="modalMenu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="formData" class="ajax-form" action="{{ route('menus.store') }}" method="POST">
                @csrf
                <div id="methodContainer"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Header Section <span class="text-danger">*</span></label>
                        <select name="section_id" id="section_id" class="form-select" required>
                            <option value="">-- Pilih Section --</option>
                            @foreach($sections as $s)
                            <option value="{{ $s->id }}">{{ $s->section_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" name="menu_name" id="menu_name" class="form-control" required placeholder="Contoh: Laporan Pajak">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL / Route Name <span class="text-danger">*</span></label>
                        <input type="text" name="url" id="url" class="form-control" required placeholder="Contoh: reports.index">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (FontAwesome) <span class="text-danger">*</span></label>
                        <input type="text" name="icon" id="icon" class="form-control" required placeholder="Contoh: fas fa-chart-bar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                        <input type="number" name="order" id="order" class="form-control" required value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permission Slug (Opsional)</label>
                        <input type="text" name="permission_slug" id="permission_slug" class="form-control" placeholder="Contoh: report-view">
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
            ajax: "{{ route('menus.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'section_name', name: 'section.section_name' },
                { data: 'menu_name', name: 'menu_name' },
                { data: 'url', name: 'url' },
                { data: 'icon', name: 'icon' },
                { data: 'order', name: 'order' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    function editMenu(id) {
        axios.get(`/menus/${id}`)
            .then(res => {
                let d = res.data.data;
                $('#modalTitle').text('Edit Menu');
                $('#formData').attr('action', `/menus/${id}`);
                $('#methodContainer').html('<input type="hidden" name="_method" value="PUT">');
                
                $('#section_id').val(d.section_id);
                $('#menu_name').val(d.menu_name);
                $('#url').val(d.url);
                $('#icon').val(d.icon);
                $('#order').val(d.order);
                $('#permission_slug').val(d.permission_slug);
                
                $('#modalMenu').modal('show');
            });
    }

    function resetForm() {
        $('#modalTitle').text('Tambah Menu Baru');
        $('#formData').attr('action', "{{ route('menus.store') }}");
        $('#methodContainer').html('');
        $('#formData')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    }
</script>
@endpush
