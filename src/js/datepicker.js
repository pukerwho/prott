document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[datepicker]').forEach(el => {
    new Datepicker(el, { language: 'uk', format: 'dd.mm.yyyy', weekStart: 1 });
  });
});


