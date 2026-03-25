// Global AJAX Form Handler
$(document).on('submit', '.ajax-form', function(e) {
    e.preventDefault();
    let form = $(this);
    let url = form.attr('action');
    let method = form.attr('method') || 'POST';
    let formData = new FormData(this);
    let btn = form.find('button[type="submit"]');
    let originalText = btn.html();

    btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
    
    // Clear previous errors
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();

    axios.post(url, formData, {
        headers: {
            'X-HTTP-Method-Override': method
        }
    })
    .then(response => {
        if(response.data.success) {
            Swal.fire('Berhasil!', response.data.message, 'success');
            $('.modal').modal('hide');
            form.trigger('reset');
            if($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().ajax.reload(null, false);
            }
        }
    })
    .catch(error => {
        if(error.response && error.response.status === 422) {
            let errors = error.response.data.errors;
            for(let field in errors) {
                let input = form.find(`[name="${field}"]`);
                if(!input.length) input = form.find(`[name="${field}[]"]`);
                input.addClass('is-invalid');
                input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
            }
        } else {
            Swal.fire('Error!', error.response?.data?.message || 'Terjadi kesalahan sistem.', 'error');
        }
    })
    .finally(() => {
        btn.html(originalText).prop('disabled', false);
    });
});

// Global Delete Action
$(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    let url = $(this).data('url');
    let name = $(this).data('name') || 'Data ini';

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Ingin menghapus ${name}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(url)
            .then(response => {
                if(response.data.success) {
                    Swal.fire('Terhapus!', response.data.message, 'success');
                    if($.fn.DataTable.isDataTable('#datatable')) {
                        $('#datatable').DataTable().ajax.reload(null, false);
                    }
                }
            })
            .catch(error => {
                Swal.fire('Error!', error.response?.data?.message || 'Terjadi kesalahan sistem.', 'error');
            });
        }
    });
});
