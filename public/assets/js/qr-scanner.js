'use strict';

(function () {
    const modal    = document.getElementById('qrModal');
    const openBtn  = document.getElementById('qrNavBtn');
    const closeBtn = document.getElementById('qrClose');
    const backdrop = document.getElementById('qrBackdrop');

    if (!modal || !openBtn) return;

    let scanner = null;
    let running = false;

    function openModal() {
        modal.hidden = false;
        document.body.style.overflow = 'hidden';
        startScanner();
    }

    function closeModal() {
        stopScanner();
        modal.hidden = true;
        document.body.style.overflow = '';
    }

    function startScanner() {
        if (running || typeof Html5Qrcode === 'undefined') return;
        running = true;
        scanner = new Html5Qrcode('qrReader');
        scanner.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 240, height: 240 } },
            onScanSuccess,
            null
        ).catch(() => {
            running = false;
        });
    }

    function stopScanner() {
        if (scanner && running) {
            scanner.stop().catch(() => {}).finally(() => {
                running = false;
                scanner = null;
            });
        }
    }

    function onScanSuccess(decodedText) {
        closeModal();
        try {
            const scanned = new URL(decodedText);
            const appBase = new URL(document.baseURI);
            // Only navigate to same-origin URLs matching this app
            if (scanned.origin === appBase.origin) {
                window.location.href = scanned.href;
            } else {
                // External URL — confirm before leaving
                if (confirm(decodedText + '\n\n¿Abrir este enlace?')) {
                    window.location.href = scanned.href;
                }
            }
        } catch {
            // Not a URL — show the raw text
            alert(decodedText);
        }
    }

    openBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.hidden) closeModal();
    });
})();
