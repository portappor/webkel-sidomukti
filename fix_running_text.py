import re

layout_path = 'd:/portal-desa/webkel-sidomukti/resources/views/layouts/app.blade.php'
with open(layout_path, 'r', encoding='utf-8') as f:
    layout_content = f.read()

# We need to replace the div wrappers in the announcements loop with anchor tags
pattern = r'<div class="inline-flex items-center gap-2\.5 cursor-pointer group">(.*?)</div>\s*@endforeach'

def replace_with_a(match):
    inner = match.group(1)
    # The inner content actually has another div inside which is closed before @endforeach. 
    # Wait, the structure is:
    # <div class="inline-flex items-center gap-2.5 cursor-pointer group">
    #     <div class="flex items-center gap-2.5 ...">...</div>
    #     <div class="mx-7 w-1 h-1 ..."></div>
    # </div>
    return None

# It's safer to just do string replacement since the structure is exact.
old_tag = '<div class="inline-flex items-center gap-2.5 cursor-pointer group">'
new_tag = '<a href="{{ route(\'announcements.index\') }}" class="inline-flex items-center gap-2.5 cursor-pointer group">'

layout_content = layout_content.replace(old_tag, new_tag)

# But wait! We need to change the closing </div> of that tag to </a>.
# Since it's right before the @endforeach...
old_end = """                                    <div class="mx-7 w-1 h-1 bg-emerald-400 rotate-45 shadow-[0_0_6px_rgba(52,211,153,0.9)] shrink-0 group-hover:bg-emerald-500 group-hover:scale-150 transition-all duration-500"></div>
                                </div>
                            @endforeach"""
new_end = """                                    <div class="mx-7 w-1 h-1 bg-emerald-400 rotate-45 shadow-[0_0_6px_rgba(52,211,153,0.9)] shrink-0 group-hover:bg-emerald-500 group-hover:scale-150 transition-all duration-500"></div>
                                </a>
                            @endforeach"""

layout_content = layout_content.replace(old_end, new_end)

with open(layout_path, 'w', encoding='utf-8') as f:
    f.write(layout_content)

print("Replaced div with a tags in layouts/app.blade.php")
