export function init() {

  function loadSubKategori(kategoriId, element = "#filter-sub-kategori", callback = null) {
    $.get('/application/api/get-sub-kategori-by-kategori', { kategori: kategoriId }, function (response) {
      let html = `<option value="" hidden>Semua Sub Kategori</option>`;
      if (response.length) {
        response.forEach((item) => {
          html += `<option value="${item.id}" data-limit="${item.limit_price}">${item.nama}</option>`;
        });
      } else {
        html += `<option value="" disabled>Belum ada data</option>`;
      }
      $(element).html(html);
      if (typeof callback === 'function') callback();
    });
  }


  $("#filter-kategori").on("change", function () {
    const kategori = $(this).val();
    $("#filter-sub-kategori").html("");
    loadSubKategori(kategori);
  });

  let formToSubmit = null;

  const modaldelete = new bootstrap.Modal(document.getElementById('delete-modal'));
  // Klik tombol hapus
  $(document).on('click', '.btn-show-delete-modal', function () {
    const id = $(this).data('id');
    formToSubmit = $(`form.delete-form[data-id="${id}"]`);
    modaldelete.show();
  });

  // Klik tombol batal
  $(document).on('click', "#btn-batal-delete", function () {
    modaldelete.hide();
    formToSubmit = null;
  });

  // Klik tombol "Ya, Yakin"
  $(document).on('click', '.delete-action', function () {
    if (formToSubmit) {
      formToSubmit.submit();
    }
  });

  const btn = $('#btn-search');

  $('#filter-kategori, #filter-sub-kategori, #filter-tahun').on('change', function () {
    btn.trigger('click'); // klik tombol search
  });

  $('#search').on('keyup', function (e) {
    if (e.key === 'Enter') {
      btn.trigger('click'); // klik tombol search
    }
  });
}
