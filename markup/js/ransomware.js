document.addEventListener('DOMContentLoaded', () => {
    const catalog = document.querySelector('[data-ransomware-catalog]');
    if (!catalog) return;

    const results = catalog.querySelector('[data-ransomware-results]');
    const status = catalog.querySelector('[data-ransomware-status]');
    let controller;
    let requestId = 0;
    let searchTimer;

    const load = async (url, { append = false, history = true, focus = false } = {}) => {
        controller?.abort();
        controller = new AbortController();
        const currentRequest = ++requestId;
        results.setAttribute('aria-busy', 'true');
        const previousMore = results.querySelector('[data-ransomware-more]');
        previousMore?.setAttribute('aria-disabled', 'true');
        status.textContent = 'Loading profiles…';

        try {
            const response = await fetch(url, { signal: controller.signal });
            if (!response.ok) throw new Error('Catalog request failed');
            const doc = new DOMParser().parseFromString(await response.text(), 'text/html');
            const next = doc.querySelector('[data-ransomware-results]');
            if (!next || currentRequest !== requestId) return;
            let focusTarget;

            if (append) {
                const cards = [...next.querySelectorAll('[data-profile-id]')];
                const existing = new Set([...results.querySelectorAll('[data-profile-id]')].map(card => card.dataset.profileId));
                const newCards = cards.filter(card => !existing.has(card.dataset.profileId));
                results.querySelector('[data-ransomware-grid]').append(...newCards);
                const more = next.querySelector('.ransomware__more');
                results.querySelector('.ransomware__more')?.remove();
                if (more) results.append(more);
                focusTarget = newCards[0]?.querySelector('a');
                status.textContent = `${results.querySelectorAll('[data-profile-id]').length} profiles shown.`;
            } else {
                results.replaceChildren(...next.childNodes);
                const nextFilters = doc.querySelector('.ransomware__filters');
                const form = catalog.querySelector('[data-ransomware-search]');
                const nextForm = nextFilters.querySelector('[data-ransomware-search]');
                const category = nextForm.querySelector('[name="ransomware_category"]');
                form.querySelector('[name="ransomware_category"]')?.remove();
                if (category) form.prepend(category);
                // Keep the focused input while typing; replace the category links only.
                catalog.querySelector('.ransomware__categories').replaceChildren(...nextFilters.querySelector('.ransomware__categories').childNodes);
                focusTarget = catalog.querySelector('[data-ransomware-filter][aria-current]');
                status.textContent = next.querySelector('[data-ransomware-count]')?.textContent || 'Profiles updated.';
                if (history) window.history.pushState(null, '', url);
            }
            if (focus) focusTarget?.focus({ preventScroll: true });
        } catch (error) {
            if (error.name !== 'AbortError' && currentRequest === requestId) {
                status.textContent = 'Could not load profiles. Please try again.';
            }
        } finally {
            if (currentRequest === requestId) {
                results.removeAttribute('aria-busy');
                results.querySelector('[data-ransomware-more]')?.removeAttribute('aria-disabled');
            }
        }
    };

    const search = () => {
        const form = catalog.querySelector('[data-ransomware-search]');
        const url = new URL(form.action);
        new FormData(form).forEach((value, name) => { if (value) url.searchParams.set(name, value); });
        load(url.href);
    };

    catalog.addEventListener('submit', event => {
        if (!event.target.matches('[data-ransomware-search]')) return;
        event.preventDefault();
        clearTimeout(searchTimer);
        search();
    });
    catalog.querySelector('[name="ransomware_search"]').addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(search, 300);
    });
    catalog.addEventListener('click', event => {
        const link = event.target.closest('[data-ransomware-filter], [data-ransomware-more]');
        if (!link || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
        event.preventDefault();
        clearTimeout(searchTimer);
        const append = link.matches('[data-ransomware-more]');
        if (append && results.hasAttribute('aria-busy')) return;
        const url = new URL(link.href);
        if (!append) {
            const value = catalog.querySelector('[name="ransomware_search"]').value.trim();
            if (value) url.searchParams.set('ransomware_search', value);
            else url.searchParams.delete('ransomware_search');
        }
        load(url.href, { append, focus: event.detail === 0 });
    });
    window.addEventListener('popstate', () => {
        clearTimeout(searchTimer);
        catalog.querySelector('[name="ransomware_search"]').value = new URL(window.location.href).searchParams.get('ransomware_search') || '';
        load(window.location.href, { history: false });
    });
});
