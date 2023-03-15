require('./bootstrap');

Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

$('table.table tbody tr').click(function() {
    $(this).parent().find('tr.tr-selected').removeClass('tr-selected').addClass('tr-hover');
    $(this).removeClass('tr-hover').addClass('tr-selected');
})