import './bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $;

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import flatpickr from "flatpickr";
import { Indonesian } from "flatpickr/dist/l10n/id.js";

//load style 
import 'bootstrap/dist/css/bootstrap.min.css';
import "flatpickr/dist/flatpickr.min.css";


// set flatpickr general
flatpickr.localize(Indonesian);

// flatpickr(".datepicker-max-now", {
//   dateFormat: "d/m/Y", 
//   maxDate: "today",    
//   locale: "id",
//   allowInput: true,
//   appendTo: document.body,
//   yearSelectorType: 'dropdown',
//   onOpen: function(selectedDates, dateStr, instance) {
//     // Menunda penutupan yang mungkin terjadi akibat modal
//     setTimeout(() => {
//       instance.calendarContainer.classList.add('open');
//     }, 10);
//   }
// });


const page = document.body.dataset.page;

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
  },
});

if (page) {
  import(`./pages/${page}.js`)
    .then((module) => {
      if (typeof module.init === 'function') {
        module.init();
      }
    })
    .catch((error) => {
      console.error(`Gagal memuat modul untuk halaman "${page}"`, error);
    });
};


if(document.getElementById('toggleSidebar')){
  const toggleButton = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const layoutWrapper = document.getElementById('layoutWrapper');

  const secondToggleSidebar = document.getElementById('secondToggleSidebar');

  toggleButton.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');
    setTimeout(() => {
      layoutWrapper.classList.toggle('showmenu');
    }, 100);
  });
  secondToggleSidebar.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');
    setTimeout(() => {
      layoutWrapper.classList.toggle('showmenu');
    }, 100);
  });
}