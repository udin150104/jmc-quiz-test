export function init() {
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

    $.get('/application/laporan/kabupaten/api/data', {
      page: page,
      search: search,
      provinsi: provinsi,
    }, function (response) {
      let html = '';
      const now = new Date();
      const recentRowIds = []; // simpan ID baris yang perlu ditandai

        // console.log(response.data);
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
          <tr id="${rowId}" >
            <td>${item.nama}</td>
            <td>${item.nama_provinsi}</td>
            <td class="text-end">
              ${item.penduduk_count} <small>Penduduk</small>
            </td>
          </tr>`;
        });
      } else {
        html += `<tr><td colspan="3" class="text-muted">Belum Ada Data</td></tr>`;
      }

      // Render dulu ke DOM
      $('#table-list tbody').html(html);
      renderPagination(response);

      // Setelah baris dirender, baru hilangkan warna hijau
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

}
