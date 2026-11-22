document.addEventListener('DOMContentLoaded', () => {
    const catalog = document.querySelector('[data-reports-catalog]');
    if (!catalog) return;

    const results = catalog.querySelector('[data-reports-results]');
    const status = catalog.querySelector('[data-reports-status]');
    let controller;

    const load = async (url, { append = false, history = true, focus = false } = {}) => {
        controller?.abort();
        controller = new AbortController();
        results.setAttribute('aria-busy', 'true');
        results.querySelector('[data-reports-more]')?.setAttribute('aria-disabled', 'true');
        status.textContent = 'Loading reports…';

        try {
            const response = await fetch(url, { signal: controller.signal });
            if (!response.ok) throw new Error('Catalog request failed');
            const doc = new DOMParser().parseFromString(await response.text(), 'text/html');
            const next = doc.querySelector('[data-reports-results]');
            if (!next) return;

            let focusTarget;
            if (append) {
                const cards = [...next.querySelectorAll('[data-report-id]')];
                const existing = new Set([...results.querySelectorAll('[data-report-id]')].map(card => card.dataset.reportId));
                const newCards = cards.filter(card => !existing.has(card.dataset.reportId));
                results.querySelector('[data-reports-grid]').append(...newCards);
                results.querySelector('.reports__more')?.remove();
                const more = next.querySelector('.reports__more');
                if (more) results.append(more);
                focusTarget = newCards[0]?.querySelector('.reports__card-content a');
                status.textContent = `${results.querySelectorAll('[data-report-id]').length} reports shown.`;
            } else {
                results.replaceChildren(...next.childNodes);
                const nextCategories = doc.querySelector('.reports__categories');
                catalog.querySelector('.reports__categories').replaceChildren(...nextCategories.childNodes);
                focusTarget = catalog.querySelector('[data-reports-filter][aria-current]');
                status.textContent = next.querySelector('[data-reports-count]')?.textContent || 'Reports updated.';
                if (history) window.history.pushState(null, '', url);
            }
            if (focus) focusTarget?.focus({ preventScroll: true });
        } catch (error) {
            if (error.name !== 'AbortError') status.textContent = 'Could not load reports. Please try again.';
        } finally {
            results.removeAttribute('aria-busy');
            results.querySelector('[data-reports-more]')?.removeAttribute('aria-disabled');
        }
    };

    catalog.addEventListener('click', event => {
        const link = event.target.closest('[data-reports-filter], [data-reports-more]');
        if (!link || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
        event.preventDefault();
        const append = link.matches('[data-reports-more]');
        if (append && results.hasAttribute('aria-busy')) return;
        load(link.href, { append, focus: event.detail === 0 });
    });

    window.addEventListener('popstate', () => load(window.location.href, { history: false }));
});
