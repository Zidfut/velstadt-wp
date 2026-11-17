document.addEventListener('DOMContentLoaded', () => {
    const panel = document.querySelector('[data-demo-panel]');

    if (!panel) {
        return;
    }

    panel.addEventListener('wpcf7mailsent', (event) => {
        const form = panel.querySelector('[data-demo-form]');
        const success = panel.querySelector('[data-demo-success]');
        const description = success.querySelector('[data-demo-success-description]');
        const email = event.detail?.inputs?.find((input) => input.name === 'demo-email')?.value || '';
        const parts = description.dataset.template.split('{email}');

        description.replaceChildren();
        parts.forEach((part, index) => {
            if (index) {
                const address = document.createElement('strong');
                address.textContent = email;
                description.append(address);
            }
            description.append(document.createTextNode(part));
        });

        form.hidden = true;
        success.hidden = false;
        panel.classList.add('is-success');
        panel.setAttribute('aria-labelledby', 'demo-success-title');
        const title = success.querySelector('[data-demo-success-title]');
        title.id = 'demo-success-title';
        title.focus({ preventScroll: true });
        if (panel.getBoundingClientRect().top < 0) {
            panel.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth', block: 'start' });
        }
    });

    panel.addEventListener('wpcf7invalid', () => {
        requestAnimationFrame(() => {
            panel.querySelector('input[aria-invalid="true"], select[aria-invalid="true"], textarea[aria-invalid="true"]')?.focus();
        });
    });
});
