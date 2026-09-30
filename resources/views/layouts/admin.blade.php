<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - Kelurahan Sidomukti</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ $app_logo }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <!-- Alpine.js & Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Cropper.js CSS & JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }

        /* === Rich Text HTML Content (TinyMCE / Markdown) List & Format Styles === */
        .prose ol, .rich-content ol, .content-body ol {
            list-style-type: decimal !important;
            padding-left: 1.75rem !important;
            margin-top: 0.5rem !important;
            margin-bottom: 0.75rem !important;
        }

        .prose ul, .rich-content ul, .content-body ul {
            list-style-type: disc !important;
            padding-left: 1.75rem !important;
            margin-top: 0.5rem !important;
            margin-bottom: 0.75rem !important;
        }

        .prose li, .rich-content li, .content-body li {
            margin-bottom: 0.375rem !important;
            padding-left: 0.25rem !important;
            display: list-item !important;
            list-style-position: outside !important;
        }

        .prose p, .rich-content p, .content-body p {
            margin-bottom: 0.75rem !important;
        }

        /* === Page Entry Animations === */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.45s ease-out both;
        }

        /* === DataTables — Clean Style === */
        .dataTables_wrapper {
            padding: 0;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0.75rem;
        }
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0;
            border-radius: 0.625rem;
            padding: 0.4rem 0.85rem;
            background-color: #f8fafc;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-size: 0.8125rem;
            color: #334155;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34,197,94,0.12);
            background-color: #ffffff;
        }
        table.dataTable {
            border-collapse: collapse !important;
            margin-top: 0.75rem !important;
            margin-bottom: 0.75rem !important;
            width: 100% !important;
        }
        table.dataTable thead th {
            background-color: #f8fafc;
            color: #94a3b8;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.875rem 1.25rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-top: none !important;
        }
        table.dataTable tbody td {
            padding: 0.875rem 1.25rem !important;
            border-bottom: 1px solid #f8fafc !important;
            color: #334155;
            font-size: 0.875rem;
            vertical-align: middle;
        }
        table.dataTable tbody tr {
            transition: background-color 0.15s;
        }
        table.dataTable tbody tr:hover {
            background-color: #f0fdf4 !important;
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid #f1f5f9 !important;
        }
        /* Info & length text */
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length { font-size: 0.8125rem; color: #94a3b8; }
        /* Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.5rem !important;
            border: 1px solid transparent !important;
            background: transparent !important;
            padding: 0.35rem 0.7rem !important;
            margin-left: 0.2rem;
            transition: all 0.15s;
            font-size: 0.8125rem;
            color: #64748b !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            border-color: #e2e8f0 !important;
            color: #1e293b !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #22c55e !important;
            color: white !important;
            border-color: #16a34a !important;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(34,197,94,0.25);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            color: #cbd5e1 !important;
            cursor: default;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-hidden selection:bg-green-100 selection:text-green-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Component -->
        <x-admin-sidebar />

        <!-- Main Content Area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-slate-50">
            
            <!-- Navbar Component -->
            <x-admin-navbar />

            <!-- Main Content -->
            <main class="w-full flex-grow p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
            
            <!-- Footer Admin -->
            <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center text-sm text-slate-500 font-medium">
                &copy; {{ date('Y') }} Sistem Informasi Kelurahan Sidomukti. Hak Cipta Dilindungi.
            </footer>
        </div>

    </div>

    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            if ($('#dataTable').length) {
                $('#dataTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                    },
                    "pageLength": 10,
                    "ordering": true,
                    "info": true
                });
            }
        });
    </script>
    <script>
        // System Floating Toast Notification
        window.showToastNotification = function(options) {
            let title = 'AKSES DITOLAK!';
            let message = '';
            let type = 'error';

            if (typeof options === 'string') {
                const cleanStr = options.trim();
                const parts = cleanStr.split('\n\n');
                if (parts.length > 1) {
                    title = parts[0].replace(/^[^\w\s\-\!]+/, '').trim() || 'AKSES DITOLAK!';
                    message = parts.slice(1).join('<br>').replace(/\n/g, '<br>');
                } else {
                    message = cleanStr.replace(/\n/g, '<br>');
                }
            } else if (typeof options === 'object') {
                title = options.title || 'PERHATIAN';
                message = (options.message || '').replace(/\n/g, '<br>');
                type = options.type || 'error';
            }

            let container = document.getElementById('toastNotificationContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastNotificationContainer';
                container.className = 'fixed top-5 right-5 z-[999999] flex flex-col gap-3 max-w-md w-full pointer-events-none px-4 sm:px-0';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = `pointer-events-auto w-full bg-slate-900/95 text-white rounded-2xl p-4 shadow-2xl border ${
                type === 'error' ? 'border-rose-500/50 shadow-rose-950/40' : 'border-emerald-500/50 shadow-emerald-950/40'
            } backdrop-blur-md transform transition-all duration-300 -translate-y-4 opacity-0 flex items-start gap-3.5 relative overflow-hidden`;

            const iconHtml = type === 'error' 
                ? `<div class="p-2.5 bg-rose-500/20 text-rose-400 rounded-xl border border-rose-500/30 shrink-0 mt-0.5">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                   </div>`
                : `<div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-xl border border-emerald-500/30 shrink-0 mt-0.5">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                   </div>`;

            toast.innerHTML = `
                <div class="absolute left-0 top-0 bottom-0 w-1.5 ${type === 'error' ? 'bg-rose-500' : 'bg-emerald-500'}"></div>
                ${iconHtml}
                <div class="flex-1 pr-6">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full ${
                            type === 'error' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30'
                        }">${type === 'error' ? 'AKSES DITOLAK' : 'NOTIFIKASI'}</span>
                    </div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-white tracking-tight">${title}</h4>
                    <div class="text-xs text-slate-300 mt-1 leading-relaxed font-medium">${message}</div>
                </div>
                <button type="button" class="absolute top-3.5 right-3.5 text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;

            const closeBtn = toast.querySelector('button');
            closeBtn.onclick = function() {
                toast.classList.add('-translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            };

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('-translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.classList.add('-translate-y-4', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 6000);
        };

        // Override native window.alert globally to use floating toast card
        window.alert = function(msg) {
            window.showToastNotification(msg);
        };

        window.validatePdfUpload = function(input, labelId = null, defaultLabelText = 'Pilih Berkas PDF', maxSizeMB = 10) {
            const file = input.files ? input.files[0] : null;
            if (!file) {
                if (labelId) {
                    const labelEl = document.getElementById(labelId);
                    if (labelEl) labelEl.textContent = defaultLabelText;
                }
                return true;
            }

            const isPdf = (file.type && file.type.toLowerCase() === 'application/pdf') || /\.pdf$/i.test(file.name);

            if (!isPdf) {
                input.value = '';
                if (labelId) {
                    const labelEl = document.getElementById(labelId);
                    if (labelEl) labelEl.textContent = defaultLabelText;
                }
                alert('🚫 AKSES DITOLAK!\n\nBerkas \'' + file.name + '\' tidak diperbolehkan.\n\nHanya berkas Dokumen PDF (.pdf) yang diperbolehkan!');
                return false;
            }

            const maxSizeBytes = maxSizeMB * 1024 * 1024;
            if (file.size > maxSizeBytes) {
                input.value = '';
                if (labelId) {
                    const labelEl = document.getElementById(labelId);
                    if (labelEl) labelEl.textContent = defaultLabelText;
                }
                alert('🚫 AKSES DITOLAK!\n\nUkuran berkas \'' + file.name + '\' terlalu besar (' + (file.size / 1048576).toFixed(1) + 'MB).\n\nMaksimal ukuran berkas yang diperbolehkan adalah ' + maxSizeMB + 'MB.');
                return false;
            }

            if (labelId) {
                const labelEl = document.getElementById(labelId);
                if (labelEl) labelEl.textContent = file.name;
            }

            return true;
        };

        window.validateDocumentOrImageUpload = function(input, labelId = null, defaultLabelText = 'Pilih Berkas PDF / Gambar', maxSizeMB = 10) {
            const file = input.files ? input.files[0] : null;
            if (!file) {
                if (labelId) {
                    const labelEl = document.getElementById(labelId);
                    if (labelEl) labelEl.textContent = defaultLabelText;
                }
                return true;
            }

            const isPdf = (file.type && file.type.toLowerCase() === 'application/pdf') || /\.pdf$/i.test(file.name);
            const isImage = (file.type && file.type.toLowerCase().startsWith('image/')) || /\.(jpe?g|png|webp|gif|svg)$/i.test(file.name);

            if (!isPdf && !isImage) {
                input.value = '';
                if (labelId) {
                    const labelEl = document.getElementById(labelId);
                    if (labelEl) labelEl.textContent = defaultLabelText;
                }
                alert('🚫 AKSES DITOLAK!\n\nBerkas \'' + file.name + '\' tidak diperbolehkan.\n\nHanya berkas Dokumen PDF atau Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan!');
                return false;
            }

            const maxSizeBytes = maxSizeMB * 1024 * 1024;
            if (file.size > maxSizeBytes) {
                input.value = '';
                if (labelId) {
                    const labelEl = document.getElementById(labelId);
                    if (labelEl) labelEl.textContent = defaultLabelText;
                }
                alert('🚫 AKSES DITOLAK!\n\nUkuran berkas \'' + file.name + '\' terlalu besar (' + (file.size / 1048576).toFixed(1) + 'MB).\n\nMaksimal ukuran berkas yang diperbolehkan adalah ' + maxSizeMB + 'MB.');
                return false;
            }

            if (labelId) {
                const labelEl = document.getElementById(labelId);
                if (labelEl) labelEl.textContent = file.name;
            }

            return true;
        };

        window.validateImageUpload = function(input, labelId = null, defaultLabelText = 'Pilih Berkas Foto', maxSizeMB = 5) {
            if (!input.files || input.files.length === 0) {
                if (labelId) {
                    const labelEl = document.getElementById(labelId);
                    if (labelEl) labelEl.textContent = defaultLabelText;
                }
                return true;
            }

            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const isImage = (file.type && file.type.toLowerCase().startsWith('image/')) || /\.(jpe?g|png|webp|gif|svg)$/i.test(file.name);

                if (!isImage) {
                    input.value = '';
                    if (labelId) {
                        const labelEl = document.getElementById(labelId);
                        if (labelEl) labelEl.textContent = defaultLabelText;
                    }
                    alert('🚫 AKSES DITOLAK!\n\nBerkas \'' + file.name + '\' bukan merupakan berkas FOTO / GAMBAR.\n\nSistem secara otomatis menolak unggahan berkas selain foto atau gambar (JPG, PNG, JPEG, WEBP, GIF, SVG). Silakan unggah berkas berupa FOTO atau GAMBAR!');
                    return false;
                }

                const maxSizeBytes = maxSizeMB * 1024 * 1024;
                if (file.size > maxSizeBytes) {
                    input.value = '';
                    if (labelId) {
                        const labelEl = document.getElementById(labelId);
                        if (labelEl) labelEl.textContent = defaultLabelText;
                    }
                    alert('🚫 AKSES DITOLAK!\n\nUkuran berkas gambar \'' + file.name + '\' terlalu besar (' + (file.size / 1048576).toFixed(1) + 'MB).\n\nMaksimal ukuran file foto/gambar yang diperbolehkan adalah ' + maxSizeMB + 'MB.');
                    return false;
                }
            }

            if (labelId) {
                const labelEl = document.getElementById(labelId);
                if (labelEl) {
                    labelEl.textContent = input.files.length > 1 ? input.files.length + ' Foto Dipilih' : input.files[0].name;
                }
            }

            return true;
        };

        window.validateImageUrlInput = function(input) {
            const val = input.value ? input.value.trim() : '';
            if (!val) return true;

            const isImageUrl = /^https?:\/\/.+/i.test(val) && /\.(jpe?g|png|webp|gif|svg)($|\?|#)/i.test(val);
            if (!isImageUrl) {
                input.value = '';
                input.dispatchEvent(new Event('input'));
                alert('🚫 AKSES DITOLAK!\n\nTautan URL foto \'' + val + '\' tidak diperbolehkan.\n\nHanya tautan URL berkas Foto / Gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg) yang diperbolehkan!');
                return false;
            }
            return true;
        };

        // Global capture listener to intercept file selection before any local or inline change handlers
        document.addEventListener('change', function(e) {
            const input = e.target;
            if (!input || input.tagName !== 'INPUT' || input.type !== 'file' || !input.files || input.files.length === 0) {
                return;
            }

            const accept = (input.getAttribute('accept') || '').toLowerCase();
            const isStrictPhoto = accept.includes('image') && !accept.includes('pdf');
            const isDocOrPhoto = accept.includes('pdf') && accept.includes('image');
            const isStrictPdf = accept.includes('pdf') && !accept.includes('image');

            if (isStrictPhoto) {
                if (!window.validateImageUpload(input)) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
            } else if (isDocOrPhoto) {
                if (!window.validateDocumentOrImageUpload(input)) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
            } else if (isStrictPdf) {
                if (!window.validatePdfUpload(input)) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
            }
        }, true);

        // Global capture listener for image URL fields (foto, logo, thumbnail, slide background)
        ['change', 'blur'].forEach(function(eventType) {
            document.addEventListener(eventType, function(e) {
                const input = e.target;
                if (!input || input.tagName !== 'INPUT' || (input.type !== 'url' && input.type !== 'text')) {
                    return;
                }

                const name = (input.name || '').toLowerCase();
                const placeholder = (input.placeholder || '').toLowerCase();
                const isImageField = name.includes('foto') || name.includes('photo') || name.includes('logo') || name.includes('thumbnail') || name.includes('background') || name.includes('gambar') || name.includes('bagan') || placeholder.includes('gambar') || placeholder.includes('foto');

                if (isImageField && (name.endsWith('_url') || name.includes('[background_url]') || input.dataset.type === 'image-url')) {
                    if (!window.validateImageUrlInput(input)) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    }
                }
            }, true);
        });
    </script>

    <!-- Modal Universal Image Cropper -->
    <x-image-cropper-modal />

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            

            
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#10b981',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-200',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    title: 'text-xl font-bold text-slate-800',
                    htmlContainer: 'text-slate-600 font-medium'
                }
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#f43f5e',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-200',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    title: 'text-xl font-bold text-slate-800',
                    htmlContainer: 'text-slate-600 font-medium'
                }
            });
            @endif

            @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                html: {!! json_encode(session('warning')) !!},
                confirmButtonColor: '#f59e0b',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-200',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    title: 'text-xl font-bold text-slate-800',
                    htmlContainer: 'text-slate-600 font-medium'
                }
            });
            @endif

            @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                html: {!! json_encode(session('info')) !!},
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-200',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    title: 'text-xl font-bold text-slate-800',
                    htmlContainer: 'text-slate-600 font-medium'
                }
            });
            @endif
        });
    </script>
    <!-- Global Proteksi Double Click & Form Submit -->
    <x-global-protector />
</body>
</html>
