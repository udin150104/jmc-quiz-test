export function init() {

  const myModal = new bootstrap.Modal(document.getElementById('form-modal'));
  const myModalDelete = new bootstrap.Modal(document.getElementById('delete-modal'));
  /**
   * Button Tambah
   */
  $(document).on("click", "#btn-add", function () {
    $("#title-form").html("Tambah Data");
    myModal.show();
  });

  /** Button edit */
  $(document).on('click', '.btn-edit', function () {
    const id = $(this).data('id');

    $.get(`/application/referensi/kabupaten/${id}`, function (response) {
      myModal.show();
      $("#title-form").html("Ubah Data");
      $('select[name="provinsi"]').val(response.provinsi_id);
      $('input[name="nama"]').val(response.nama);
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
      url: `/application/referensi/kabupaten/${initdel}`,
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

    const url = id ? `/application/referensi/kabupaten/${id}` : '/application/referensi/kabupaten';
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

    $.get('/application/referensi/kabupaten/api/data', {
      page: page,
      search: search,
      provinsi:provinsi
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
            recentRowIds.push(rowId); 
          }

          html += `
          <tr id="${rowId}" class="${isRecent ? 'table-info' : ''}">
            <td>${item.nama}</td>
            <td>${item.provinsi.nama}</td>
            <td class="text-center">
              <button type="button" class="btn btn-sm btn-secondary rounded-0 me-1 btn-edit" data-id="${item.id}">Ubah</button>
              <button type="button" class="btn btn-sm btn-danger rounded-0 btn-delete"  data-id="${item.id}">Hapus</button>
            </td>
          </tr>`;
        });
      } else {
        html += `<tr><td colspan="3" class="text-muted">Belum Ada Data</td></tr>`;
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



  // Panggil pertama kali
  loadData(1);

  $('#search').on('keyup', function (e) {
    if (e.key === 'Enter') {
      loadData(1);
    }
  });
  $("#filter-provinsi").on("change",function(e){
      loadData(1);
  });

  $("#btn-reset-filter").on("click",function(){
    $("#filter-provinsi").val("");
    $("#search").val("");
    $("#search").trigger(jQuery.Event('keyup', { key: 'Enter', keyCode: 13, which: 13 }));
  });
}
