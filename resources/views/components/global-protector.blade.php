<style>
    /* Global Loader / Disable Styles */
    .is-loading, .is-disabled-click {
        opacity: 0.65 !important;
        cursor: not-allowed !important;
        pointer-events: none !important;
        position: relative;
    }
    .is-loading {
        color: transparent !important; /* Sembunyikan teks asli jika loading */
    }
    .is-loading::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 1rem;
        height: 1rem;
        margin-top: -0.5rem;
        margin-left: -0.5rem;
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-top-color: #fff;
        border-radius: 50%;
        animation: global-spinner .6s linear infinite;
        z-index: 10;
    }
    /* Spinner berwarna gelap untuk tombol terang */
    .btn-light.is-loading::after,
    .bg-white.is-loading::after {
        border: 2px solid rgba(0, 0, 0, 0.2);
        border-top-color: #333;
    }

    @keyframes global-spinner {
        to { transform: rotate(360deg); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Penanganan Form Submit Standar
    document.addEventListener('submit', function(e) {
        if (e.defaultPrevented) return; // Fix: Jangan jalankan spinner jika submit dibatalkan (misal oleh onsubmit="return confirm()")

        const form = e.target;
        
        // Cek validitas HTML5 form (jika ada input required yg kosong, submit akan batal otomatis oleh browser)
        // Kita hanya mengunci jika form benar-benar valid.
        if (form.checkValidity && !form.checkValidity()) {
            return;
        }

        // Cari tombol submit dalam form ini
        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            // Cegah submit ganda jika sudah dalam state loading
            if (submitBtn.classList.contains('is-loading')) {
                e.preventDefault();
                return;
            }
            
            // Set loading state
            submitBtn.classList.add('is-loading');
            
            // Gunakan sedikit setTimeout untuk disable agar form tetap ter-submit.
            // Jika tombol langsung disabled di event listener, beberapa browser membatalkan pengiriman form.
            setTimeout(() => {
                submitBtn.disabled = true;
                const loadingText = submitBtn.getAttribute('data-loading-text');
                if (loadingText) {
                    // Jika butuh teks khusus dan bukan ikon muter, hapus class is-loading, ganti text manual
                    submitBtn.classList.remove('is-loading');
                    submitBtn.classList.add('is-disabled-click');
                    submitBtn.dataset.originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> ${loadingText}`;
                }
            }, 50);
        }
    });

    // 2. Debounce / Throttle Proteksi untuk Tombol Aksi (a href, button type button)
    // Menghindari klik 2x cepat pada link hapus atau aksi lainnya
    document.addEventListener('click', function(e) {
        const target = e.target.closest('.btn-action, .btn-debounce, a.bg-rose-50, a.bg-emerald-600, button.bg-rose-50');
        if (target && !target.closest('form')) {
            if (target.classList.contains('is-disabled-click')) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
            
            // Kunci tombol sejenak
            target.classList.add('is-disabled-click');
            setTimeout(() => {
                target.classList.remove('is-disabled-click');
            }, 1000); // 1 detik throttle
        }
    }, true);

    // 3. Interceptor Axios / Fetch untuk permintaan Asinkron (Jika digunakan di aplikasi)
    if (typeof window.axios !== 'undefined') {
        // Axios Request Interceptor
        axios.interceptors.request.use(function (config) {
            // Bisa menambahkan logika otomatis mencari tombol yg memicu request dan menambah class is-loading
            // Namun karena axios dipanggil via JS, lebih aman developer menambahkan class manual sebelum panggil axios
            // Atau kita sediakan helper global:
            document.body.classList.add('ajax-loading-cursor');
            return config;
        }, function (error) {
            document.body.classList.remove('ajax-loading-cursor');
            return Promise.reject(error);
        });

        // Axios Response Interceptor
        axios.interceptors.response.use(function (response) {
            document.body.classList.remove('ajax-loading-cursor');
            resetAllAjaxButtons();
            return response;
        }, function (error) {
            document.body.classList.remove('ajax-loading-cursor');
            resetAllAjaxButtons();
            return Promise.reject(error);
        });
    }
});

// Helper Function untuk Ajax Button
window.setButtonLoading = function(buttonEl, loadingText = null) {
    if(!buttonEl) return;
    if(loadingText) {
        buttonEl.dataset.originalText = buttonEl.innerHTML;
        buttonEl.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> ${loadingText}`;
        buttonEl.classList.add('is-disabled-click');
        buttonEl.disabled = true;
    } else {
        buttonEl.classList.add('is-loading');
        buttonEl.disabled = true;
    }
};

window.resetButtonLoading = function(buttonEl) {
    if(!buttonEl) return;
    buttonEl.classList.remove('is-loading', 'is-disabled-click');
    buttonEl.disabled = false;
    if (buttonEl.dataset.originalText) {
        buttonEl.innerHTML = buttonEl.dataset.originalText;
        delete buttonEl.dataset.originalText;
    }
};

function resetAllAjaxButtons() {
    document.querySelectorAll('.is-loading, .is-disabled-click').forEach(btn => {
        // Jangan reset tombol di dalam form, karena form submit akan pindah halaman
        if (!btn.closest('form')) {
            window.resetButtonLoading(btn);
        }
    });
}
</script>
