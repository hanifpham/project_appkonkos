import './bootstrap';

const onReady = (callback) => {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback);
    } else {
        callback();
    }
};

onReady(() => {
    // dropdown nav
    const dropdowns = document.querySelectorAll('.nav-dropdown');
    dropdowns.forEach((dropdown) => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const menu = dropdown.querySelector('.dropdown-menu');
        trigger?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdowns.forEach((d) => d !== dropdown && d.classList.remove('open'));
            dropdown.classList.toggle('open');
        });
        document.addEventListener('click', () => dropdown.classList.remove('open'));
        menu?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.remove('open');
        });
        menu?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => dropdown.classList.remove('open'));
        });
    });

    const modalOverlay = document.getElementById('loginModal');
    const loginTriggers = document.querySelectorAll('[data-login-trigger]');
    const closeButtons = document.querySelectorAll('[data-close-modal]');

    const toggleModal = (shouldOpen) => {
        if (!modalOverlay) return;
        modalOverlay.classList.toggle('active', shouldOpen);
        document.body.style.overflow = shouldOpen ? 'hidden' : '';
    };

    loginTriggers.forEach((btn) => btn.addEventListener('click', () => toggleModal(true)));
    closeButtons.forEach((btn) => btn.addEventListener('click', () => toggleModal(false)));

    modalOverlay?.addEventListener('click', (event) => {
        if (event.target === modalOverlay) {
            toggleModal(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            toggleModal(false);
        }
    });

    // booking proof modal
    const bookingProofOverlay = document.querySelector('[data-booking-proof]');
    const toggleBookingProof = (shouldOpen) => {
        if (!bookingProofOverlay) return;
        bookingProofOverlay.classList.toggle('is-visible', shouldOpen);
        document.body.style.overflow = shouldOpen ? 'hidden' : '';
    };

    const updateBookingProofContent = (data) => {
        if (!bookingProofOverlay) return;
        const setText = (selector, value) => {
            const el = bookingProofOverlay.querySelector(selector);
            if (el) el.textContent = value || '—';
        };

        setText('[data-proof-id]', data.id);
        setText('[data-proof-listing]', data.listing);
        setText('[data-proof-type]', data.type);
        setText('[data-proof-nama]', data.nama);
        setText('[data-proof-email]', data.email);
        setText('[data-proof-telepon]', data.telepon);
        setText('[data-proof-tanggal-pengajuan]', data.tanggalPengajuan);
        setText('[data-proof-tanggal-mulai]', data.tanggalMulai);
        setText('[data-proof-tanggal-selesai]', data.tanggalSelesai);
        setText('[data-proof-biaya]', data.biaya);

        const waNumber = (data.kontak || '').replace(/\\D+/g, '');
        const waLink = bookingProofOverlay.querySelector('[data-proof-wa-link]');
        const waNumberEl = bookingProofOverlay.querySelector('[data-proof-wa-number]');

        if (waNumberEl) waNumberEl.textContent = waNumber || 'Belum ada kontak';

        if (waLink && waNumber) {
            const message = encodeURIComponent(
                `Halo, saya ${data.nama || '-'} ingin konfirmasi booking ${data.listing || ''} dengan ID ${data.id || ''}.`
            );
            waLink.href = `https://wa.me/${waNumber}?text=${message}`;
            waLink.classList.remove('d-none');
        } else if (waLink) {
            waLink.classList.add('d-none');
        }
    };

    if (bookingProofOverlay?.dataset.autoOpen === 'true') {
        toggleBookingProof(true);
    }

    document.querySelectorAll('[data-booking-proof-trigger]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const dataset = btn.dataset;
            updateBookingProofContent({
                id: dataset.proofId,
                listing: dataset.proofListing,
                type: dataset.proofType,
                nama: dataset.proofNama,
                email: dataset.proofEmail,
                telepon: dataset.proofTelepon,
                tanggalPengajuan: dataset.proofTanggalPengajuan,
                tanggalMulai: dataset.proofTanggalMulai,
                tanggalSelesai: dataset.proofTanggalSelesai,
                biaya: dataset.proofBiaya + (dataset.proofPriceUnit || ''),
                kontak: dataset.proofKontak,
            });
            toggleBookingProof(true);
        });
    });

    document.querySelectorAll('[data-close-booking-proof]').forEach((btn) => {
        btn.addEventListener('click', () => toggleBookingProof(false));
    });

    bookingProofOverlay?.addEventListener('click', (event) => {
        if (event.target === bookingProofOverlay) {
            toggleBookingProof(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            toggleBookingProof(false);
        }
    });

    const printBookingProof = document.querySelector('[data-print-booking-proof]');
    printBookingProof?.addEventListener('click', () => window.print());

    // profile dropdown
    document.querySelectorAll('[data-profile-dropdown]').forEach((dropdown) => {
        const trigger = dropdown.querySelector('[data-profile-trigger]');
        const menu = dropdown.querySelector('[data-profile-menu]');
        if (!trigger || !menu) return;

        const closeMenu = () => menu.classList.remove('is-open');

        trigger.addEventListener('click', (event) => {
            event.stopPropagation();
            menu.classList.toggle('is-open');
        });

        menu.addEventListener('click', (event) => event.stopPropagation());
        menu.querySelectorAll('a, button').forEach((item) => {
            item.addEventListener('click', () => menu.classList.remove('is-open'));
        });
        document.addEventListener('click', closeMenu);
    });

    document.querySelectorAll('[data-profile-tabs]').forEach((tabsWrapper) => {
        const buttons = tabsWrapper.querySelectorAll('[data-tab-target]');
        const panels = tabsWrapper.parentElement.querySelectorAll('[data-profile-panel]');
        if (!buttons.length || !panels.length) return;

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-tab-target');

                buttons.forEach((btn) => btn.classList.toggle('is-active', btn === button));
                panels.forEach((panel) => {
                    const shouldShow = panel.dataset.profilePanel === target;
                    panel.classList.toggle('is-active', shouldShow);
                });
            });
        });
    });

    // reset search on reload to return to default state
    const searchForm = document.querySelector('[data-search-form]');
    if (searchForm) {
        const navigationEntry = performance.getEntriesByType('navigation')[0];
        const isReload = navigationEntry
            ? navigationEntry.type === 'reload'
            : performance.navigation && performance.navigation.type === performance.navigation.TYPE_RELOAD;

        if (isReload && window.location.search) {
            const resetUrl = searchForm.dataset.resetUrl || window.location.pathname;
            window.location.replace(resetUrl);
        }
    }

});
