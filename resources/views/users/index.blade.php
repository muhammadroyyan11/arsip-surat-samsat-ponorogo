@extends('layouts.app')

@section('title', 'Manajemen Users & Akses')

@section('actions')
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormUser" onclick="resetForm()">
    <i class="fas fa-user-plus"></i> Buat User Login
</button>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped w-100" id="datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal User -->
<div class="modal fade" id="modalFormUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDataUser" class="ajax-form" action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleUser">Buat User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pilih Staff <span class="text-danger">*</span></label>
                        <select name="staff_id" id="staff_id" class="form-select" required>
                            <option value="">-- Pilih Staff --</option>
                            @foreach($unregistered_staffs as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} - {{ $s->nip }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hanya staff yang belum memiliki akun login yang muncul.</small>
                    </div>
                    <div class="mb-3">
                        <label>Email Login <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" required>
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

<!-- Modal Akses -->
<div class="modal fade" id="modalAkses" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formAkses" class="ajax-form" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Hak Akses Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach($sections as $section)
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold border-bottom pb-2">{{ $section->section_name }}</h6>
                            @foreach($section->menus as $menu)
                            <div class="form-check">
                                <input class="form-check-input menu-checkbox" type="checkbox" name="menus[]" value="{{ $menu->id }}" id="menu_{{ $menu->id }}">
                                <label class="form-check-label" for="menu_{{ $menu->id }}">
                                    <i class="{{ $menu->icon }} fa-fw text-muted"></i> {{ $menu->menu_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan Akses</button>
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
            ajax: "{{ route('users.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'staff_name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    function resetForm() {
        $('#formDataUser')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    }

    function manageAccess(userId) {
        $('.menu-checkbox').prop('checked', false);
        $('#formAkses').attr('action', `/users/${userId}/access`);
        
        axios.get(`/users/${userId}/access`)
            .then(res => {
                let menus = res.data.menus;
                menus.forEach(menuId => {
                    $(`#menu_${menuId}`).prop('checked', true);
                });
                $('#modalAkses').modal('show');
            })
            .catch(err => {
                Swal.fire('Error', 'Gagal memuat akses', 'error');
            });
    }
</script>
@endpush
