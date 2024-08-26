var $ = require("jquery");
//main table
$('.sort-table-js').on('click', function(){
  var n = $(this).data('sort-id');
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("mainsite-table");
  // arrow
  $('.sort-arrow').addClass('hidden');
  var arrow = $('.sort-table-js[data-sort-id="'+n+'"] .sort-arrow');
  if (arrow.hasClass("rotate-180")) {
    arrow.removeClass('rotate-180');
  } else {
    arrow.addClass('rotate-180');
  }
  arrow.removeClass('hidden').addClass('active');
  switching = true;
  dir = "asc";
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n].querySelector('.sort-value');
      y = rows[i + 1].getElementsByTagName("TD")[n].querySelector('.sort-value');;
      if (dir == "asc") {
        if (Number(x.innerHTML) > Number(y.innerHTML)) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (Number(x.innerHTML) < Number(y.innerHTML)) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
});

$('.sort-table-drop-js').on('click', function(){
  var n = $(this).data('sort-id');
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("drop-table");
  // arrow
  $('.sort-arrow').addClass('hidden');
  var arrow = $('.sort-table-drop-js[data-sort-id="'+n+'"] .sort-arrow');
  if (arrow.hasClass("rotate-180")) {
    arrow.removeClass('rotate-180');
  } else {
    arrow.addClass('rotate-180');
  }
  arrow.removeClass('hidden').addClass('active');
  switching = true;
  dir = "asc";
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n].querySelector('.sort-value-drop');
      y = rows[i + 1].getElementsByTagName("TD")[n].querySelector('.sort-value-drop');;
      if (dir == "asc") {
        if (Number(x.innerHTML) > Number(y.innerHTML)) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (Number(x.innerHTML) < Number(y.innerHTML)) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
});