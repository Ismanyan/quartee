$(document).ready(function () {
    $('.edit-data').on('click', function () {
        const id = $(this).data('id');
        // ambil data dari get dan jika sudah berhasil di ambil lakukan fungsi sambil mengirimkan data hasilnya
        $.get('../config/edit-config.php?id=' + id, function (data) {
            const datas = $.parseJSON(data);
            // Jika berhasil ganti isi dari #content
            $('#id').val(datas.id);
            $('#name').val(datas.name);
            $('#nip').val(datas.nip);
            $('#role').val(datas.role_id);
            $('#ut').val(datas.unit_kerja);
            $('#datepickers').val(datas.ttl);
            $('#domain').val(datas.domain);
            $('#username').val(datas.username);
        });
    });


});