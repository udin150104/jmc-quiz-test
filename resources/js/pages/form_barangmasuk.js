export function init() {
  function htmlListItem() {
    return `
      <tr>
        <td class="pe-2 pt-2"><input type="text" class="form-control rounded-0" name="nama_item[]"></td>
        <td class="pe-2 pt-2"><input type="text" class="form-control text-end rounded-0 currency" placeholder="Rp." name="harga[]"></td>
        <td class="pe-2 pt-2"><input type="number" class="form-control rounded-0" min="1" name="jumlah[]" value="1"></td>
        <td class="pe-2 pt-2"><input type="text" class="form-control rounded-0" name="satuan[]"></td>
        <td class="pe-2 pt-2"><input type="text" class="form-control form-control-plaintext text-end px-2 currency rounded-0" readonly disabled placeholder="Rp." name="total[]"></td>
        <td class="pe-2 pt-2"><input type="text" class="form-control rounded-0 datepicker" name="tgl_expired[]"></td>
        <td class="pt-2"><button type="button" class="btn rounded-0 btn-remove-row"><i class="bi bi-x-circle-fill text-danger"></i></button></td>
      </tr>
    `;
  }

  function formatRupiahCurrency(value, prefix = 'Rp. ') {
    let number_string = value.toString().replace(/[^,\d]/g, '');
    let split = number_string.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    if (ribuan) {
      let separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
    return prefix + rupiah;
  }

  function unformatRupiah(rp) {
    return parseInt(rp.replace(/[^0-9]/g, '')) || 0;
  }

  function updateTotal(row) {
    const harga = unformatRupiah(row.find('input[name="harga[]"]').val());
    const jumlah = parseInt(row.find('input[name="jumlah[]"]').val()) || 0;

    if (harga && jumlah) {
      const total = harga * jumlah;
      row.find('input[name="total[]"]').val(formatRupiahCurrency(total));
    } else {
      row.find('input[name="total[]"]').val('');
    }

    validateTotalLimit();
  }

  function validateTotalLimit() {
    const batas = unformatRupiah($('#batas').val());
    let totalKeseluruhan = 0;
    let lastRow = null;
    let calonTotal = 0;

    $('tr').each(function () {
      const totalInput = $(this).find('input[name="total[]"]');
      if (totalInput.length > 0) {
        const totalValue = unformatRupiah(totalInput.val());
        totalKeseluruhan += totalValue;
        lastRow = $(this);
        calonTotal = totalValue;
      }
    });

    if (batas > 0 && totalKeseluruhan > batas) {
      const totalSebelumnya = totalKeseluruhan - calonTotal;
      if (totalSebelumnya < batas) {
        alert('Total keseluruhan melebihi batas barang yang diizinkan!');
        lastRow.find('input[name="harga[]"]').val('').focus();
        lastRow.find('input[name="total[]"]').val('');
        lastRow.find('input[name="jumlah[]"]').val('1');
      }
    }
  }

  function initFlatpickr() {
    flatpickr('.datepicker', {
      dateFormat: "d/m/Y",
      locale: "id",
      allowInput: true,
      appendTo: document.body,
      onOpen: function (selectedDates, dateStr, instance) {
        setTimeout(() => instance.calendarContainer.classList.add('open'), 10);
      },
      yearSelectorType: 'dropdown',
    });
  }

  function bindGlobalEvents() {
    $(document)
      .on('click', '.btn-remove-row', function () {
        $(this).closest('tr').remove();
        validateTotalLimit();
      });

      $(document).on('click', '#add-row-table', function () {
        $("#list-item").append(htmlListItem());
        initFlatpickr();
        validateTotalLimit();
      });

      $(document).on('input', '.currency', function () {
        $(this).val(formatRupiahCurrency($(this).val()));
      });

      $(document).on('keypress', '.currency', function (e) {
        if (!/[0-9,]/.test(String.fromCharCode(e.which))) {
          e.preventDefault();
        }
      });

      $(document).on('keydown', 'input[type="number"]', function (e) {
        const allowed = [46, 8, 9, 27, 13, 37, 38, 39, 40];
        const ctrl = e.ctrlKey || e.metaKey;
        const ctrlKeys = [65, 67, 86, 88];
        if (allowed.includes(e.keyCode) || (ctrl && ctrlKeys.includes(e.keyCode))) return;
        if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) {
          if (e.keyCode < 96 || e.keyCode > 105) {
            e.preventDefault();
          }
        }
      });

      $(document).on('paste', 'input[type="number"]', function (e) {
        const data = (e.originalEvent || e).clipboardData.getData('text');
        if (!/^\d+$/.test(data)) e.preventDefault();
      });

      $(document).on('input', 'input[name="harga[]"], input[name="jumlah[]"]', function () {
        updateTotal($(this).closest('tr'));
      });

      $(document).on('change', 'input[name="jumlah[]"]', function () {
        updateTotal($(this).closest('tr'));
      });

      $(document).on('input', 'input[name="harga[]"]', function () {
        const caret = this.selectionStart;
        const val = unformatRupiah($(this).val()).toString();
        $(this).val(formatRupiahCurrency(val));
        this.setSelectionRange(caret, caret);
      });

      $(document).on('keypress', 'input[name="harga[]"]', function (e) {
        if (!/[0-9]/.test(String.fromCharCode(e.which))) e.preventDefault();
      });

      $(document).on('keypress', 'input[name="satuan[]"]', function (e) {
        if (!/^[a-zA-Z\s]+$/.test(String.fromCharCode(e.which))) e.preventDefault();
      });

      $(document).on('paste', 'input[name="satuan[]"]', function (e) {
        const pasted = (e.originalEvent || e).clipboardData.getData('text');
        if (!/^[a-zA-Z\s]+$/.test(pasted)) e.preventDefault();
      });

      $(document).on('input', '#batas', function () {
        validateTotalLimit();
      });

      $(document).on('click', '#submit-action', function (e) {
        const batas = unformatRupiah($('#batas').val());
        let totalKeseluruhan = 0;

        $('input[name="total[]"]').each(function () {
          totalKeseluruhan += unformatRupiah($(this).val());
        });

        if (batas > 0 && totalKeseluruhan > batas) {
          e.preventDefault();
          alert('Total keseluruhan melebihi batas yang diizinkan!');
        }
      });
  }

  function loadSubKategori(kategoriId, element = "#subkategori", callback = null) {
    $.get('/application/api/get-sub-kategori-by-kategori', { kategori: kategoriId }, function (response) {
      let html = `<option value="" hidden>Pilih Sub kategori</option>`;
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

  function initKategoriChangeEvents() {
    $("#kategori").on("change", function () {
      const kategori = $(this).val();
      $("#subkategori").html("");
      loadSubKategori(kategori);
      $("#batas").val('Pilih Sub Kategori Terlebih Dahulu');
    });

    $("#subkategori").on("change", function () {
      const limit = $(this).find("option:selected").data("limit");
      $("#batas").val(formatRupiahCurrency(limit)).trigger('input');
    });
  }

  initFlatpickr();
  bindGlobalEvents();
  initKategoriChangeEvents();
}
