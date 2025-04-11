var $ = require("jquery");

$('.modal-open-js').on("click", function () {
  let modalId = $(this).data('modal-id');
  $('.modal[data-modal-id=' + modalId + ']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

$('.detail-click-js').on("click", function () {
  let detailId = $(this).data('detail-id');
  $('.detail-modal[data-detail-modal=' + detailId + ']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

$('.date-click-js').on("click", function () {
  let dateId = $(this).data('date-id');
  $('.date-modal[data-date-modal=' + dateId + ']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

$('.value-modal-js').on("click", function () {
  let modalId = $(this).data('modal-id');
  $('.chart-modal[data-modal-id=' + modalId + ']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

$('.edit-modal-js').on("click", function () {
  let modalId = $(this).data('modal-id');
  $('.edit-modal[data-modal-id=' + modalId + ']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

document.addEventListener('click', function (e) {
  if (e.target.classList.value === 'modal-content') {
    $('.modal-bg').removeClass('open');
    $('.detail-modal').removeClass('open');
    $('.date-modal').removeClass('open');
    $('.chart-modal').removeClass('open');
    $('.edit-modal').removeClass('open');
    $('.modal').removeClass('open');
    $('body').removeClass('overflow-hidden');
  }
});

var clipboard = new Clipboard('.copy-click');

clipboard.on('success', function (e) {
  $('.copy-tooltip[data-copy-text="' + e.text + '"]').removeClass('hidden');
  setTimeout(function () {
    $('.copy-tooltip[data-copy-text="' + e.text + '"]').addClass('hidden');
  }, 2000);
});

//нумерація 
function updateRowNumbers() {
  const rows = document.querySelectorAll('.website-tr');
  rows.forEach((row, index) => {
    const indexEl = row.querySelector('.row-index');
    if (indexEl) {
      indexEl.textContent = index + 1;
    }
  });
}

//Швидкий пошук дропів
$("#search_drop_box").keyup(function () {
  var filter = $(this).val();
  filter = filter.toLowerCase();
  $("#drop-table .drop-tr").each(function () {
    var metadata = $(this).data("metadata");
    var regexp = new RegExp(filter);
    var metadatastring = "";
    metadatastring = metadatastring.toLowerCase();

    if (typeof metadata.tag != "undefined") {
      metadatastring = metadata.tag.join(" ");
    }
    if (metadatastring.toLowerCase().search(regexp) < 0) {
      $(this).hide();
    }
    else {
      $(this).show();
    }
  });
});

//Швидкий пошук сайтів
$("#search_websites_box").keyup(function () {
  var filter = $(this).val();
  filter = filter.toLowerCase();
  $("#mainsite-table .website-tr").each(function () {
    var metadata = $(this).data("metadata");
    var regexp = new RegExp(filter);
    var metadatastring = "";
    metadatastring = metadatastring.toLowerCase();

    if (typeof metadata.tag != "undefined") {
      metadatastring = metadata.tag.join(" ");
    }
    if (metadatastring.toLowerCase().search(regexp) < 0) {
      $(this).hide();
    }
    else {
      $(this).show();
    }
    updateRowNumbers();
  });
});

updateRowNumbers();

//Чекбокс порівняння
const toggle = document.querySelector('input[type="checkbox"]');
const diffs = document.querySelectorAll('.value-diff');

const updateVisibility = () => {
  diffs.forEach(el => {
    style = toggle.checked ? '' : 'display:none';
    el.setAttribute('style', style);
  });
};
if (toggle) {
  toggle.addEventListener('change', updateVisibility);
}

updateVisibility(); // оновити після завантаження

//сортування 
let currentSortKey = null;
let sortAscending = false;
const headers = document.querySelectorAll("[data-sort]");
const table = document.querySelector("#mainsite-table");
if (table) {
  rows = Array.from(table.querySelectorAll(".website-tr"));
}

const headerRow = document.getElementById("header-row");

headers.forEach(header => {
  header.classList.add("cursor-pointer");

  header.addEventListener("click", () => {
    const sortKey = header.getAttribute("data-sort");
    if (!sortKey) return;

    if (currentSortKey === sortKey) {
      sortAscending = !sortAscending;
    } else {
      currentSortKey = sortKey;
      sortAscending = false;
    }

    // Очистити всі стрілки
    document.querySelectorAll(".sort-direction").forEach(el => el.textContent = "");

    // Показати стрілку у поточному заголовку
    const arrowSpan = header.querySelector(".sort-direction");
    arrowSpan.textContent = sortAscending ? "🔽" : "🔼";

    // Сортування рядків
    rows.sort((a, b) => {
      const aVal = parseFloat(a.querySelector(`.${sortKey} .sort-value`)?.textContent || 0);
      const bVal = parseFloat(b.querySelector(`.${sortKey} .sort-value`)?.textContent || 0);
      return sortAscending ? aVal - bVal : bVal - aVal;
    });

    // Виділити жирним заголовок і відповідні клітинки
    headers.forEach(h => h.classList.remove("font-bold"));
    header.classList.add("font-bold");

    rows.forEach(row => {
      row.querySelectorAll("div").forEach(cell => {
        cell.classList.remove("font-bold");
      });
      const targetCell = row.querySelector(`.${sortKey}`);
      if (targetCell) targetCell.classList.add("font-bold");
    });

    rows.forEach(row => table.appendChild(row));

    // Сховати підсвітку позиції
    document.querySelectorAll(".position_change").forEach(el => el.style.display = 'none');

    // Перемістити колонку в заголовку
    const urlIndex = 1;
    const allHeaderCells = Array.from(headerRow.children);
    const targetIndex = allHeaderCells.indexOf(header);
    if (targetIndex > -1 && targetIndex !== urlIndex + 1) {
      headerRow.removeChild(header);
      headerRow.insertBefore(header, headerRow.children[urlIndex + 1]);
    }

    // Перемістити відповідні колонки в кожному рядку
    rows.forEach(row => {
      const cells = Array.from(row.children);
      const targetCell = cells[targetIndex];
      if (targetCell && targetIndex !== urlIndex + 1) {
        row.removeChild(targetCell);
        row.insertBefore(targetCell, row.children[urlIndex + 1]);
      }
    });
  });
});
