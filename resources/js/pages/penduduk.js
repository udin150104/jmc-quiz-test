export function init() {

  const myModal = new bootstrap.Modal(document.getElementById('form-modal'));
  const myModalDelete = new bootstrap.Modal(document.getElementById('delete-modal'));
  /**
   * Button Tambah
   */
  $(document).on("click", "#btn-add", function () {
    $("#title-form").html("Tambah Data");
    myModal.show();
    flatpickr('input[name="tanggal_lahir"]', {
      defaultDate: new Date(),
      dateFormat: "d/m/Y",
      locale: "id",
      allowInput: true,
      static: true,
      appendTo: document.body,
      // yearSelectorType: 'dropdown',
      onOpen: function (selectedDates, dateStr, instance) {
        // Menunda penutupan yang mungkin terjadi akibat modal
        setTimeout(() => {
          instance.calendarContainer.classList.add('open');
        }, 10);
      },
      yearSelectorType: 'dropdown',
    });
  });

  /** Button edit */
  $(document).on('click', '.btn-edit', function () {
    const id = $(this).data('id');

    $.get(`/application/penduduk/${id}`, function (response) {
      myModal.show();
      $("#title-form").html("Ubah Data");
      $('input[name="nik"]').val(response.nik);
      $('input[name="nama"]').val(response.nama);
      const dateObj = new Date(response.tanggal_lahir);
      flatpickr('input[name="tanggal_lahir"]', {
        defaultDate: dateObj,
        dateFormat: "d/m/Y",
        locale: "id",
        allowInput: true,
        static: true,
        appendTo: document.body,
        // yearSelectorType: 'dropdown',
        onOpen: function (selectedDates, dateStr, instance) {
          // Menunda penutupan yang mungkin terjadi akibat modal
          setTimeout(() => {
            instance.calendarContainer.classList.add('open');
          }, 10);
        },
        yearSelectorType: 'dropdown',
      });

      $('input[name="jenis_kelamin"][value="' + response.jenis_kelamin + '"]').prop('checked', true);
      $('select[name="provinsi"]').val(response.provinsi_id).trigger('change');
      loadKabupaten(response.provinsi_id, function () {
        $('select[name="kabupaten"]').val(response.kabupaten_id);
      });
      $('textarea[name="alamat"]').val(response.alamat);
      $('#form-data').attr('data-id', id);
    });
  });

  let initdel;

  $(document).on("click", ".btn-delete", function () {
    const id = $(this).data('id');
    initdel = id;
    myModalDelete.show();
  });

  $(document).on('click', '.delete-action', function () {

    $.ajax({
      url: `/application/penduduk/${initdel}`,
      type: 'DELETE',
      success: function (response) {
        let page = $("#pagination .page-item.active .page-link").data('page') || 1;
        loadData(page);
        $("#btn-batal-delete").trigger("click");
      },
      error: function (xhr) {
        console.error(xhr.responseText);
      }
    });
  });


  $(document).on("click", "#submit-action", function () {
    $('.help').html('');
    const form = $("#form-data");
    const formData = form.serialize();
    const id = form.attr('data-id');

    const url = id ? `/application/penduduk/${id}` : '/application/penduduk';
    const method = id ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      method: method,
      data: formData,
      success: function (response) {
        let page = $("#pagination .page-item.active .page-link").data('page') || 1;
        loadData(page);
        $("#btn-batal").trigger("click");

      },
      error: function (xhr) {
        if (xhr.status === 422) {
          const errors = xhr.responseJSON.errors;
          for (const key in errors) {
            $(`#${key}-help`).html(errors[key][0]);
          }
        }
      }
    });
  });


  /** close modal form */
  $(document).on("click", "#btn-batal", function () {
    $('.help').html('');
    $("#form-data").get(0).reset();
    $("#form-data").removeAttr('data-id', "");
    myModal.hide();
  });

  /** close modal delete */
  $(document).on("click", "#btn-batal-delete", function () {
    initdel = null;
    myModalDelete.hide();
  });

  /** render pagination */
  function renderPagination(response, maxVisible = 5) {
    const currentPage = response.current_page;
    const lastPage = response.last_page;

    let html = '';

    const makePage = (page, label = null, active = false, disabled = false) => {
      return `
      <li class="page-item ${active ? 'active' : ''} ${disabled ? 'disabled' : ''} rounded-0">
        <a class="page-link  rounded-0" href="#" data-page="${!disabled ? page : ''}">
          ${label ?? page}
        </a>
      </li>`;
    };

    // Tombol Previous
    html += makePage(currentPage - 1, '<i class="bi bi-caret-left"></i>', false, currentPage === 1);

    // Jika halaman <= maxVisible, tampilkan semuanya
    if (lastPage <= maxVisible + 2) {
      for (let i = 1; i <= lastPage; i++) {
        html += makePage(i, null, i === currentPage);
      }
    } else {
      // Halaman pertama
      html += makePage(1, null, currentPage === 1);

      let start = Math.max(2, currentPage - Math.floor(maxVisible / 2));
      let end = Math.min(lastPage - 1, currentPage + Math.floor(maxVisible / 2));

      if (start > 2) {
        html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
      }

      for (let i = start; i <= end; i++) {
        html += makePage(i, null, i === currentPage);
      }

      if (end < lastPage - 1) {
        html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
      }

      // Halaman terakhir
      html += makePage(lastPage, null, currentPage === lastPage);
    }

    // Tombol Next
    html += makePage(currentPage + 1, '<i class="bi bi-caret-right"></i>', false, currentPage === lastPage);

    $('#pagination').html(html);
  }
  /** klick handle paginasi */
  $(document).on('click', '#pagination .page-link', function (e) {
    e.preventDefault();
    const targetPage = parseInt($(this).data('page'));
    if (!isNaN(targetPage)) {
      loadData(targetPage);
    }
  });


  function loadData(page = 1) {
    const search = $('#search').val();
    const provinsi = $('#filter-provinsi').val();
    const kabupaten = $('#filter-kabupaten').val();

    $.get('/application/penduduk/api/data', {
      page: page,
      search: search,
      provinsi: provinsi,
      kabupaten: kabupaten,
    }, function (response) {
      let html = '';
      const now = new Date();
      const recentRowIds = [];
      if (response.data.length > 0) {
        response.data.forEach((item) => {
          const createdAtString = item.created_at ? item.created_at.replace(' ', 'T') : null;

          let isRecent = false;
          if (createdAtString) {
            const createdAt = new Date(createdAtString);
            const diffMs = now - createdAt;
            isRecent = diffMs <= 60 * 800;
          }

          const rowId = `row-${item.id}`;

          if (isRecent) {
            recentRowIds.push(rowId); // tandai ID-nya untuk nanti
          }

          html += `
          <tr id="${rowId}" class="${isRecent ? 'table-info' : ''}">
            <td>${item.nama}</td>
            <td class="text-center">${item.umur} <small class="text-muted">tahun</small></td>
            <td>${item.alamat}</td>
            <td class="text-center">
              <button type="button" class="btn btn-sm btn-secondary rounded-0 me-1 btn-edit" data-id="${item.id}">Ubah</button>
              <button type="button" class="btn btn-sm btn-danger rounded-0 btn-delete"  data-id="${item.id}">Hapus</button>
            </td>
          </tr>`;
        });
      } else {
        html += `<tr><td colspan="4" class="text-muted">Belum Ada Data</td></tr>`;
      }

      $('#table-list tbody').html(html);
      renderPagination(response);

      recentRowIds.forEach((id) => {
        setTimeout(() => {
          $(`#${id}`).removeClass('table-info');
        }, 100000);
      });
    });
  }

  loadData(1);

  $('#search').on('keyup', function (e) {
    if (e.key === 'Enter') {
      loadData(1);
    }
  });
  $("#filter-provinsi").on("change", function (e) {

    const provinsi = $(this).val();
    $("#filter-kabupaten").html("");
    loadKabupaten(provinsi, "#filter-kabupaten");
    loadData(1);

  })
  $("#filter-kabupaten").on("change", function (e) {
    loadData(1);
  })

  function loadKabupaten(provinsiId, element = "#kabupaten", callback = null) {
    $.get('/application/api/get-kabupaten-by-provinsi', {
      provinsi: provinsiId
    }, function (response) {
      let html = `<option value="">Pilih Kabupaten</option>`;
      response.forEach((item) => {
        html += `<option value="${item.id}">${item.nama}</option>`;
      });
      $(element).html(html);

      if (typeof callback === 'function') {
        callback();
      }
    });
  }

  $("#provinsi").on("change", function () {
    const provinsi = $(this).val();
    $("#kabupaten").html("");
    loadKabupaten(provinsi);
  });

  $("#btn-reset-filter").on("click", function () {
    $("#filter-provinsi, #filter-kabupaten").val("");
    $("#search").val("");
    $("#search").trigger(jQuery.Event('keyup', { key: 'Enter', keyCode: 13, which: 13 }));
  });
}
