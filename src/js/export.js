document.addEventListener('DOMContentLoaded', function () {
  const exportButton = document.querySelector('.еxport_button');

  exportButton.addEventListener('click', () => {
    const rows = Array.from(document.querySelectorAll('.website-tr'));

    // Сортувати за data-site-number
    rows.sort((a, b) => {
      const numA = parseInt(a.getAttribute('data-site-number') || 0);
      const numB = parseInt(b.getAttribute('data-site-number') || 0);
      return (numA || 0) - (numB || 0);
    });

    // Отримати заголовки
    const headers = Array.from(document.querySelectorAll('#header-row > div'))
      .map(h => h.getAttribute('data-sort') || '')
      .join(',');

    let csv = headers + '\n';

    // Отримати значення з кожного рядка
    rows.forEach(row => {
      const values = Array.from(row.children).map(cell => {
        let valEl = cell.querySelector('.row-value') || cell;
        return `"${valEl.textContent.trim()}"`;
      });
      csv += values.join(',') + '\n';
    });

    // Створити і завантажити CSV-файл
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'exported_table.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  });
});