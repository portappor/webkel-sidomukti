import os
import glob

base_dir = 'resources/views/dashboard'
index_files = glob.glob(os.path.join(base_dir, '*/index.blade.php'))

for file_path in index_files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # 1. Update the table container
    content = content.replace('bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden', 'bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden p-2 sm:p-4')
    
    # 2. Update page title section
    content = content.replace('<div class="mb-6 flex justify-between items-center">', '<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">')
    
    # 3. Update buttons
    content = content.replace('bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition flex items-center gap-2', 'bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-green-600/30 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2')
    content = content.replace('bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition flex items-center gap-2', 'bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-600/30 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2')
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)

print(f'Updated {len(index_files)} CRUD index files.')
