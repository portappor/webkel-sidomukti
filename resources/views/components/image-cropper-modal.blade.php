<!-- Modal Crop Foto Universal (HD Resolution Auto-Adapter) -->
<div id="cropperModal" class="fixed inset-0 z-50 overflow-y-auto hidden" x-cloak>
    <!-- Overlay Backdrop -->
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity" onclick="window.CropHelper.close()"></div>

    <!-- Modal Box -->
    <div class="flex min-h-full items-center justify-center p-4 text-center">
        <div class="relative w-full max-w-3xl transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl transition-all border border-slate-100 flex flex-col gap-4">
            
            <!-- Header Modal -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121m5.121-5.121l7-7"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                            Potong & Sesuaikan Foto (HD Quality)
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase rounded-full">Auto Presets</span>
                        </h3>
                        <p class="text-xs text-slate-500">Atur posisi, skala, dan rasio foto agar otomatis pas dan beresolusi tinggi saat diunggah.</p>
                    </div>
                </div>
                <button type="button" onclick="window.CropHelper.close()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Cropper Canvas Container -->
            <div class="w-full bg-slate-900 rounded-xl overflow-hidden min-h-[340px] max-h-[480px] flex items-center justify-center relative shadow-inner">
                <img id="cropperImage" src="" alt="Gambar Crop" class="max-w-full block">
            </div>

            <!-- Controls Toolbar -->
            <div class="flex flex-wrap items-center justify-between gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200/80">
                <!-- Rasio Aspek Buttons -->
                <div class="flex items-center gap-1.5 flex-wrap text-xs">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mr-1">Rasio Pas:</span>
                    <button type="button" onclick="window.CropHelper.setRatio(16/9)" class="btn-aspect px-3 py-1.5 rounded-lg border border-slate-200 bg-white font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition shadow-2xs">
                        16:9 (Banner / Sampul Album)
                    </button>
                    <button type="button" onclick="window.CropHelper.setRatio(1)" class="btn-aspect px-3 py-1.5 rounded-lg border border-slate-200 bg-white font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition shadow-2xs">
                        1:1 (Pas Foto / Profil)
                    </button>
                    <button type="button" onclick="window.CropHelper.setRatio(4/3)" class="btn-aspect px-3 py-1.5 rounded-lg border border-slate-200 bg-white font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition shadow-2xs">
                        4:3 (Dokumentasi)
                    </button>
                    <button type="button" onclick="window.CropHelper.setRatio(3/4)" class="btn-aspect px-3 py-1.5 rounded-lg border border-slate-200 bg-white font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition shadow-2xs">
                        3:4 (Potret Resmi)
                    </button>
                    <button type="button" onclick="window.CropHelper.setRatio(NaN)" class="btn-aspect px-3 py-1.5 rounded-lg border border-slate-200 bg-white font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition shadow-2xs">
                        Bebas
                    </button>
                </div>

                <!-- Action Transform Buttons -->
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="window.CropHelper.rotate(-90)" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 rounded-lg text-slate-700 transition shadow-2xs" title="Putar Kiri (-90°)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                    </button>
                    <button type="button" onclick="window.CropHelper.rotate(90)" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 rounded-lg text-slate-700 transition shadow-2xs" title="Putar Kanan (+90°)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a8 8 0 00-8 8v2m18-10l-6 6m6-6l-6-6"></path></svg>
                    </button>
                    <button type="button" onclick="window.CropHelper.zoom(0.1)" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 rounded-lg text-slate-700 transition shadow-2xs" title="Perbesar (+)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                    </button>
                    <button type="button" onclick="window.CropHelper.zoom(-0.1)" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 rounded-lg text-slate-700 transition shadow-2xs" title="Perkecil (-)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM7 10h6"></path></svg>
                    </button>
                    <button type="button" onclick="window.CropHelper.reset()" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 rounded-lg text-slate-700 transition shadow-2xs" title="Reset Posisi">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="window.CropHelper.close()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition cursor-pointer">
                    Batal
                </button>
                <button type="button" onclick="window.CropHelper.applyCrop()" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs transition shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Terapkan & Export Foto HD
                </button>
            </div>

        </div>
    </div>
</div>

<script>
window.CropHelper = (function() {
    let cropper = null;
    let targetInput = null;
    let targetPreviewImg = null;
    let originalFile = null;

    return {
        init: function() {
            // Auto bind event listener pada seluruh input file gambar yang tidak memiliki atribut data-no-crop
            document.addEventListener('change', function(e) {
                if (e.target && e.target.matches('input[type="file"][accept*="image"]') && !e.target.dataset.noCrop) {
                    if (e.target.files && e.target.files[0]) {
                        window.CropHelper.open(e.target);
                    }
                }
            });
        },

        open: function(inputElement, overrideFile = null) {
            targetInput = inputElement;
            const file = overrideFile || (inputElement.files ? inputElement.files[0] : null);
            if (!file) return;

            originalFile = file;

            // Cari preview image terdekat atau berdasarkan data-preview attribute
            if (inputElement.dataset.preview) {
                targetPreviewImg = document.querySelector(inputElement.dataset.preview);
            } else {
                let container = inputElement.closest('div') || inputElement.parentElement;
                targetPreviewImg = container.querySelector('img') || (container.parentElement ? container.parentElement.querySelector('img') : null);
            }

            const modal = document.getElementById('cropperModal');
            const img = document.getElementById('cropperImage');

            const reader = new FileReader();
            reader.onload = function(evt) {
                img.src = evt.target.result;
                modal.classList.remove('hidden');

                if (cropper) {
                    cropper.destroy();
                }

                // Tentukan rasio default berdasarkan data-ratio atau nama/ID input
                let defaultRatio = NaN;
                const customRatio = inputElement.dataset.ratio;
                const inputName = ((inputElement.name || '') + ' ' + (inputElement.id || '')).toLowerCase();

                if (customRatio) {
                    if (customRatio === '16/9' || customRatio === '16:9') defaultRatio = 16 / 9;
                    else if (customRatio === '1/1' || customRatio === '1:1') defaultRatio = 1;
                    else if (customRatio === '4/3' || customRatio === '4:3') defaultRatio = 4 / 3;
                    else if (customRatio === '3/4' || customRatio === '3:4') defaultRatio = 3 / 4;
                    else defaultRatio = parseFloat(customRatio);
                } else if (inputName.match(/lurah|avatar|pas_foto|profile|user|foto_lurah/)) {
                    defaultRatio = 1; // Square 1:1 untuk pas foto/lurah/avatar
                } else if (inputName.match(/cover|thumbnail|banner|image|photo|galleries|post|foto/)) {
                    defaultRatio = 16 / 9; // 16:9 Banner/Sampul Album/Berita
                }

                cropper = new Cropper(img, {
                    aspectRatio: defaultRatio,
                    viewMode: 1,
                    autoCropArea: 0.95,
                    responsive: true,
                    restore: false,
                });
            };
            reader.readAsDataURL(file);
        },

        setRatio: function(ratio) {
            if (cropper) {
                cropper.setAspectRatio(ratio);
            }
        },

        rotate: function(degree) {
            if (cropper) {
                cropper.rotate(degree);
            }
        },

        zoom: function(ratio) {
            if (cropper) {
                cropper.zoom(ratio);
            }
        },

        reset: function() {
            if (cropper) {
                cropper.reset();
            }
        },

        close: function() {
            const modal = document.getElementById('cropperModal');
            modal.classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        },

        applyCrop: function() {
            if (!cropper || !targetInput) return;

            let canvasOptions = {
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            };

            const aspect = cropper.options.aspectRatio;
            if (aspect && Math.abs(aspect - (16/9)) < 0.05) {
                canvasOptions.width = 1920;
                canvasOptions.height = 1080;
            } else if (aspect && Math.abs(aspect - 1) < 0.05) {
                canvasOptions.width = 1000;
                canvasOptions.height = 1000;
            } else if (aspect && Math.abs(aspect - (4/3)) < 0.05) {
                canvasOptions.width = 1600;
                canvasOptions.height = 1200;
            } else if (aspect && Math.abs(aspect - (3/4)) < 0.05) {
                canvasOptions.width = 1200;
                canvasOptions.height = 1600;
            } else {
                canvasOptions.maxWidth = 1920;
                canvasOptions.maxHeight = 1920;
            }

            cropper.getCroppedCanvas(canvasOptions).toBlob(function(blob) {
                if (!blob) return;

                const croppedFile = new File([blob], originalFile ? originalFile.name : 'cropped-hd-image.jpg', {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });

                // Masukkan berkas hasil crop ke file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                targetInput.files = dataTransfer.files;

                // Perbarui gambar preview di halaman secara instant
                if (targetPreviewImg) {
                    targetPreviewImg.src = URL.createObjectURL(blob);
                    targetPreviewImg.classList.remove('hidden');
                    const parentContainer = targetPreviewImg.closest('.hidden');
                    if (parentContainer) {
                        parentContainer.classList.remove('hidden');
                    }
                }

                window.CropHelper.close();
            }, 'image/jpeg', 0.95);
        }
    };
})();

document.addEventListener('DOMContentLoaded', function() {
    window.CropHelper.init();
});
</script>
