import re

with open('d:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update navigationManager data
content = content.replace(
    "        addSlug: '',",
    "        addSlug: '',\n        addImageUrl: '',\n        addImageName: '',"
)

# 2. Update openAddModal
content = content.replace(
    "            this.addSlug = '';",
    "            this.addSlug = '';\n            this.addImageUrl = '';\n            this.addImageName = '';"
)

# 3. Add handleImageUpload function
# Find where to insert it, maybe after openAddModal
handle_image_fn = """
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.addImageName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.addImageUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.addImageName = '';
                this.addImageUrl = '';
            }
        },"""

content = content.replace(
    "        openAddModal(parentId, parentTitle) {",
    handle_image_fn + "\n\n        openAddModal(parentId, parentTitle) {"
)

# 4. Update the HTML
old_html = """                            <!-- Preview Box -->
                            <div class="w-24 h-24 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-300 text-xs font-medium shrink-0">
                                Tanpa Foto
                            </div>
                            <div class="flex-grow space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" placeholder="URL gambar atau unggah berkas foto..." class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-white text-slate-600 focus:outline-none pointer-events-none" readonly>
                                    <button type="button" class="shrink-0 flex items-center gap-2 px-4 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-bold text-sm rounded-xl transition shadow-md relative overflow-hidden">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Pilih Foto
                                        <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    </button>
                                </div>"""

new_html = """                            <!-- Preview Box -->
                            <div class="w-24 h-24 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-300 text-xs font-medium shrink-0 overflow-hidden relative group">
                                <template x-if="addImageUrl">
                                    <img :src="addImageUrl" class="w-full h-full object-cover" alt="Preview">
                                </template>
                                <template x-if="!addImageUrl">
                                    <span>Tanpa Foto</span>
                                </template>
                                <button type="button" x-show="addImageUrl" @click="addImageUrl=''; addImageName=''; $refs.fileInput.value=''" class="absolute inset-0 bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="flex-grow space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" :value="addImageName" placeholder="URL gambar atau unggah berkas foto..." class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-white text-slate-600 focus:outline-none pointer-events-none" readonly>
                                    <button type="button" class="shrink-0 flex items-center gap-2 px-4 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-bold text-sm rounded-xl transition shadow-md relative overflow-hidden">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Pilih Foto
                                        <input type="file" name="image" x-ref="fileInput" @change="handleImageUpload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    </button>
                                </div>"""

content = content.replace(old_html, new_html)

with open('d:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Image preview logic added successfully!")
