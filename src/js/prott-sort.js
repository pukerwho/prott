document.addEventListener("DOMContentLoaded", function () {
    const tables = document.querySelectorAll(".prott-table");

    tables.forEach((table) => {
        const headers = table.querySelectorAll(".prott-sort-js"); // Заголовки для сортування
        const tbody = table.querySelector("tbody");

        headers.forEach((header) => {
            const arrow = header.querySelector(".sort-arrow");

            header.addEventListener("click", function () {
                const rows = Array.from(tbody.rows);
                const columnIndex = Array.from(header.parentNode.children).indexOf(header); // Індекс колонки
                const isAscending = header.classList.contains("asc");

                // Скидаємо класи сортування на всіх заголовках
                headers.forEach(h => {
                    h.classList.remove("asc", "desc");
                    const otherArrow = h.querySelector(".sort-arrow");
                    if (otherArrow) otherArrow.classList.add("hidden");
                });

                // Встановлюємо новий стан для поточного стовпця
                header.classList.toggle("asc", !isAscending);
                header.classList.toggle("desc", isAscending);

                // Відображаємо стрілку та змінюємо її напрямок
                if (arrow) {
                    arrow.classList.remove("hidden");
                    arrow.style.transform = isAscending ? "rotate(180deg)" : "rotate(0deg)";
                }

                // Сортуємо рядки
                rows.sort((rowA, rowB) => {
                    const cellA = rowA.cells[columnIndex]?.querySelector(".data-sort-prott");
                    const cellB = rowB.cells[columnIndex]?.querySelector(".data-sort-prott");

                    if (!cellA || !cellB) {
                        console.warn(`Не знайдено .data-sort-prott у колонці ${columnIndex + 1}`);
                        return 0; // Якщо елементи не знайдені, не сортуємо
                    }

                    const textA = cellA.innerText.trim();
                    const textB = cellB.innerText.trim();

                    console.log(`Сортуємо: "${textA}" проти "${textB}"`); // Лог для перевірки значень

                    // Якщо це колонка "Дата", парсимо як дату
                    if (header.getAttribute("data-sort-id") === "3") {
                        const dateA = new Date(textA.split(",").join(""));
                        const dateB = new Date(textB.split(",").join(""));
                        return isAscending ? dateA - dateB : dateB - dateA;
                    }

                    // Для всього іншого сортуємо як текст
                    return isAscending
                        ? textA.localeCompare(textB, "uk")
                        : textB.localeCompare(textA, "uk");
                });

                // Додаємо відсортовані рядки назад у таблицю
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
});