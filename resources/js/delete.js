window.onload = () => {
    $('.delete').click(function() {
        Swal.fire({
            title: 'Czy na pewno chcesz usunąć rekord?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (!result.isConfirmed) return;
            $.ajax({
                method: 'DELETE',
                url: deleteUrl + $(this).data('id')
            })
            .done(function(response) {
                console.log(response);
                window.location.reload();
            })
            .fail(function(response) {
                Swal.fire({icon: 'error', title: 'Oops...', text: response.responseJSON.message})
            });
        });
    });
};