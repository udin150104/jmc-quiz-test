export function init() {
  const formModal = new bootstrap.Modal(document.getElementById('form-modal'));
  const deleteModal = new bootstrap.Modal(document.getElementById('delete-modal'));

  /** render pagination */
  function renderPagination(response, maxVisible = 5) {
    const currentPage = response.current_page;
    const lastPage = response.last_page;

    let html = '';

    const makePage = (page, label = null, active = false, disabled = false) => {
      return `
      <li class="page-item ${active ? 'active active-page' : ''} ${disabled ? 'disabled' : ''} rounded-0">
        <a class="page-link ${active ? '' : 'text-dark'}  rounded-0" href="#" data-page="${!disabled ? page : ''}">
          ${label ?? page}
        </a>
      </li>`;
    };

    // Tombol Previous
    html += makePage(currentPage - 1, '<i class="bi bi-caret-left"></i> Sebelumnya' , false, currentPage === 1);

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
    html += makePage(currentPage + 1, 'Selanjutnya <i class="bi bi-caret-right"></i>', false, currentPage === lastPage);

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
  let sort = 'ASC';
  let sortBy;
  $(document).on("click",".sort",function(){
    sortBy =  $(this).data('order');
    sort = sort === 'ASC'? 'DESC' : 'ASC';

    const clicked = $(this);

    const label = clicked.clone().children().remove().end().text().trim();

    const arrow = (sort === 'ASC')
        ? ' <i class="bi bi-arrow-up"></i>'
        : ' <i class="bi bi-arrow-down"></i>';

    $(".sort").each(function () {
        const resetLabel = $(this).clone().children().remove().end().text().trim();
        $(this).html(resetLabel);
    });

    clicked.html(arrow + label);

    loadData(1);
  });
  loadData(1);
  function loadData(page = 1) {
    const search = $('#search').val();

    $.get('/application/master/sub-kategori/api/data', {
      page: page,
      search: search,
      sortBy : sortBy,
      sort : sort,
    }, function (response) {
      let html = '';
      const now = new Date();
      const recentRowIds = []; // simpan ID baris yang perlu ditandai

      if (response.data.length > 0) {
        response.data.forEach((item, index) => {
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
          let no =  page>1 ? `${page} ${(index+1)}`: index+1;

          let value = item.limit_price.replace(/[^0-9]/g, '');        
          // Format jadi ribuan (misal: 1500000 → 1.500.000)
          let price = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

          html += `
          <tr id="${rowId}" >
            <td class="text-center">${no}</td>
            <td class="text-center">
              <button type="button" class="btn btn-sm rounded-0 me-1 btn-edit" data-id="${item.id}">
                <i class="bi bi-pencil"></i>
              </button>
              <button type="button" class="btn btn-sm text-danger rounded-0 btn-delete"  data-id="${item.id}">
                <i class="bi bi-trash"></i>
              </button>
            </td>
            <td>${item.kategori.nama}</td>
            <td>${item.nama}</td>
            <td class="text-end">${price}</td>
          </tr>`;
        });
      } else {
        html += `<tr><td colspan="5" class="text-muted">Belum Ada Data</td></tr>`;
      }

      // Render dulu ke DOM
      $('#table-list tbody').html(html);
      renderPagination(response);
    });
  }
  $(document).on("click","#btn-search",function(){
    loadData(1);
  });
  $('#search').on('keyup', function (e) {
    if (e.key === 'Enter') {
      loadData(1);
    }
  });
  $(document).on("click","#btn-add",function(){
    formModal.show();
  });
  $(document).on("click",".btn-batal",function(){
    $('.help').html('');
    $("#form-data").get(0).reset();
    $("#form-data").removeAttr('data-id', "");
    formModal.hide();
  });
    $(document).on("click", "#submit-action", function () {
    $('.help').html('');
    const form = $("#form-data");
    const formData = form.serialize();
    const id = form.attr('data-id');

    const url = id ? `/application/master/sub-kategori/${id}` : '/application/master/sub-kategori';
    const method = id ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      method: method,
      data: formData,
      success: function (response) {
        let message = response.message;
        $("#toast-message").show();
        $("#toast-message .toast-body").html(message);
        let page = $("#pagination .page-item.active .page-link").data('page') || 1;
        loadData(page);
        $(".btn-batal").trigger("click");

        setTimeout(function(){
          $("#toast-message").hide();
        $("#toast-message .toast-body").html('');
        },5000)

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
  $(document).on('click', '.btn-edit', function () {
    const id = $(this).data('id');
    $.get(`/application/master/sub-kategori/${id}`, function (response) {
      // console.log(response);
      formModal.show();
      let value = response.limit_price.replace(/[^0-9]/g, '');        
      // Format jadi ribuan (misal: 1500000 → 1.500.000)
      let price = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      $('input[name="batas"]').val(price);
      $('select[name="kategori"]').val(response.kategori_id);
      $('input[name="nama"]').val(response.nama);
      $('#form-data').attr('data-id', id);
    });
  });
  let initdel;
  $(document).on("click", "#btn-batal-delete", function () {
    initdel = null;
    deleteModal.hide();
  });
  $(document).on("click", ".btn-delete", function () {
    const id = $(this).data('id');
    initdel = id;
    deleteModal.show();
  });
  $(document).on('click', '.delete-action', function () {
    $.ajax({
      url: `/application/master/sub-kategori/${initdel}`,
      type: 'DELETE',
      success: function (response) {
        let message = response.message;
        $("#toast-message").show();
        $("#toast-message .toast-body").html(message);
        let page = $("#pagination .page-item.active .page-link").data('page') || 1;
        loadData(page);
        $("#btn-batal-delete").trigger("click");
        
        setTimeout(function(){
          $("#toast-message").hide();
          $("#toast-message .toast-body").html('');
        },5000)
      },
      error: function (xhr) {
        // alert('Gagal menghapus data.');
        console.error(xhr.responseText);
      }
    });
  });
  const hargaInput = document.getElementById('batas');

    hargaInput.addEventListener('input', function () {
        // Hilangkan semua selain angka
        let value = this.value.replace(/[^0-9]/g, '');        
        // Format jadi ribuan (misal: 1500000 → 1.500.000)
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        // Tambahkan penanda @ga
        this.value = value;
    });

    hargaInput.addEventListener('blur', function () {
        // Jika kosong, kosongkan field
        if (!this.value.replace(/[^0-9]/g, '')) {
            this.value = '';
        }
    });
}
