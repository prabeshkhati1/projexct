document.addEventListener('DOMContentLoaded', () => {
    const containers = document.querySelectorAll('[data-filter-container]');
    containers.forEach(container => {
        const scope = container.dataset.filterContainer;
        const search = document.querySelector(`[data-filter-search="${scope}"]`);
        const checks = document.querySelectorAll(`[data-filter-check="${scope}"]`);
        const sort = document.querySelector(`[data-filter-sort="${scope}"]`);
        const count = document.querySelector(`[data-filter-count="${scope}"]`);
        const cards = Array.from(container.querySelectorAll('[data-filter-card]'));

        function applyFilters() {
            const query = search ? search.value.trim().toLowerCase() : '';
            const selected = Array.from(checks).filter(c => c.checked && c.value !== 'All').map(c => c.value.toLowerCase());
            let visible = cards.filter(card => {
                const title = (card.dataset.title || '').toLowerCase();
                const category = (card.dataset.category || '').toLowerCase();
                const text = (card.textContent || '').toLowerCase();
                const matchSearch = !query || title.includes(query) || category.includes(query) || text.includes(query);
                const matchCategory = selected.length === 0 || selected.includes(category);
                return matchSearch && matchCategory;
            });

            if (sort) {
                const value = sort.value;
                visible.sort((a, b) => {
                    if (value === 'rating') return Number(b.dataset.rating || 0) - Number(a.dataset.rating || 0);
                    if (value === 'oldest') return String(a.dataset.date || '').localeCompare(String(b.dataset.date || ''));
                    return String(b.dataset.date || '').localeCompare(String(a.dataset.date || ''));
                });
                visible.forEach(card => container.appendChild(card));
            }

            cards.forEach(card => card.style.display = visible.includes(card) ? '' : 'none');
            if (count) count.textContent = `Showing ${visible.length} of ${cards.length} results`;
        }

        if (search) search.addEventListener('input', applyFilters);
        checks.forEach(check => check.addEventListener('change', applyFilters));
        if (sort) sort.addEventListener('change', applyFilters);
        applyFilters();
    });
});
