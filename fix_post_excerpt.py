import re

# 1. Update PostController.php
controller_path = 'd:/portal-desa/webkel-sidomukti/app/Http/Controllers/PostController.php'
with open(controller_path, 'r', encoding='utf-8') as f:
    controller_content = f.read()

# Replace 'excerpt' => $request->excerpt, with auto-generation from content
controller_content = controller_content.replace(
    "'excerpt' => $request->excerpt,", 
    "'excerpt' => \\Illuminate\\Support\\Str::limit(strip_tags($request->content), 200),"
)

with open(controller_path, 'w', encoding='utf-8') as f:
    f.write(controller_content)


# 2. Update index.blade.php
blade_path = 'd:/portal-desa/webkel-sidomukti/resources/views/dashboard/posts/index.blade.php'
with open(blade_path, 'r', encoding='utf-8') as f:
    blade_content = f.read()

# Remove create excerpt block
create_excerpt_block = """                <div>
                    <label for="create_excerpt" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Ringkasan (TinyMCE)</label>
                    <textarea name="excerpt" id="create_excerpt" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm" placeholder="Tuliskan ringkasan singkat artikel ini...">{{ old('_form_type') === 'create' ? old('excerpt') : '' }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Jika kosong, ringkasan akan diambil dari awal isi konten.</p>
                </div>"""
blade_content = blade_content.replace(create_excerpt_block, '')

# Remove edit excerpt block
edit_excerpt_block = """                <div>
                    <label for="edit_excerpt" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Ringkasan (TinyMCE)</label>
                    <textarea name="excerpt" id="edit_excerpt" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm" placeholder="Tuliskan ringkasan singkat artikel ini..."></textarea>
                </div>"""
blade_content = blade_content.replace(edit_excerpt_block, '')

# Remove JS initializations and updates
blade_content = re.sub(r'\s*document\.getElementById\(\'create_excerpt\'\)\.value = \'\';', '', blade_content)
blade_content = re.sub(r'\s*document\.getElementById\(\'edit_excerpt\'\)\.value = excerpt \|\| \'\';', '', blade_content)
blade_content = re.sub(r'\s*ensureTinyMCE\(\'create_excerpt\'.*?\);', '', blade_content)
blade_content = re.sub(r'\s*ensureTinyMCE\(\'edit_excerpt\'.*?\);', '', blade_content)

with open(blade_path, 'w', encoding='utf-8') as f:
    f.write(blade_content)

print("Excerpts have been successfully fixed!")
