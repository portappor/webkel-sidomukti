import re

# 1. Remove from home.blade.php
home_path = 'd:/portal-desa/webkel-sidomukti/resources/views/home.blade.php'
with open(home_path, 'r', encoding='utf-8') as f:
    home_content = f.read()

# Using regex to remove the Widget Ringkasan SKM
# It starts with "                        <!-- Widget Ringkasan Indeks Kepuasan Masyarakat (IKM) -->"
# and ends with "                        @endif" before "                    </div>"

skm_widget_pattern = r'(\s*<!-- Widget Ringkasan Indeks Kepuasan Masyarakat \(IKM\) -->\s*@if\(isset\(\$surveiKepuasan\) && \$surveiKepuasan\).*?</div>\s*@endif\n)'
home_content = re.sub(skm_widget_pattern, '\n', home_content, flags=re.DOTALL)

with open(home_path, 'w', encoding='utf-8') as f:
    f.write(home_content)

# 2. Remove from admin-sidebar.blade.php
sidebar_path = 'd:/portal-desa/webkel-sidomukti/resources/views/components/admin-sidebar.blade.php'
with open(sidebar_path, 'r', encoding='utf-8') as f:
    sidebar_content = f.read()

desktop_link = """                <a href="{{ route('dashboard.survei.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.survei.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.survei.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Survei Kepuasan (SKM)</span>
                </a>\n\n"""

mobile_link = """                    <a href="{{ route('dashboard.survei.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.survei.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Survei Kepuasan (SKM)</a>\n"""

sidebar_content = sidebar_content.replace(desktop_link, '')
sidebar_content = sidebar_content.replace(mobile_link, '')

with open(sidebar_path, 'w', encoding='utf-8') as f:
    f.write(sidebar_content)

print("SKM features removed successfully!")
