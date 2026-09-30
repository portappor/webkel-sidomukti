import re

with open('d:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update navigationManager data
content = content.replace(
    "        addParentTitle: 'Profil',",
    "        addParentTitle: 'Profil',\n        addTitle: '',\n        addSlug: '',"
)

# 2. Update openAddModal
content = content.replace(
    "            this.addParentTitle = parentTitle || 'Profil';",
    "            this.addParentTitle = parentTitle || 'Profil';\n            this.addTitle = '';\n            this.addSlug = '';"
)

# 3. Update the inputs
old_inputs = """                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">
                                Nama Sub-Menu / Judul Halaman <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   required
                                   placeholder="Contoh: Prestasi & Penghargaan Kelurahan"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 bg-white placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">
                                Slug URL (/halaman/:slug) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="slug"
                                   placeholder="prestasi-kelurahan"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 bg-white placeholder-slate-400">
                        </div>"""

new_inputs = """                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">
                                Nama Sub-Menu / Judul Halaman <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   x-model="addTitle"
                                   @input="addSlug = addTitle.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')"
                                   required
                                   placeholder="Contoh: Prestasi & Penghargaan Kelurahan"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 bg-white placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">
                                Slug URL (/halaman/:slug) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="slug"
                                   x-model="addSlug"
                                   placeholder="prestasi-kelurahan"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 bg-slate-50 placeholder-slate-400">
                        </div>"""

content = content.replace(old_inputs, new_inputs)

with open('d:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Slug auto-generation logic added successfully!")
