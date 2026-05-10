document.addEventListener('click', (event) => {
    const copyButton = event.target.closest('[data-copy]');
    if (!copyButton) {
        return;
    }

    const href = `${window.location.origin}${copyButton.dataset.copy}`;
    navigator.clipboard?.writeText(href);
    copyButton.textContent = 'Copied';
    window.setTimeout(() => {
        copyButton.textContent = 'Copy trip link';
    }, 1400);
});

document.addEventListener('change', (event) => {
    const checkbox = event.target.closest('.check-row input[type="checkbox"]');
    if (!checkbox) {
        return;
    }

    checkbox.closest('.check-row').classList.toggle('is-packed', checkbox.checked);
});
