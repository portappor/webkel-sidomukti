import re

# 1. Clean HomeController.php
home_path = 'd:/portal-desa/webkel-sidomukti/app/Http/Controllers/HomeController.php'
with open(home_path, 'r', encoding='utf-8') as f:
    home_content = f.read()

home_content = re.sub(r'use App\\Models\\SurveiKepuasan;\n', '', home_content)
home_content = re.sub(r'\s*// Ambil data survei kepuasan masyarakat \(SKM\) aktif\s*\$surveiKepuasan = SurveiKepuasan::where\(\'is_active\', true\)->latest\(\)->first\(\) \?\? SurveiKepuasan::first\(\);\n', '', home_content)
home_content = home_content.replace(", 'surveiKepuasan'", "")

with open(home_path, 'w', encoding='utf-8') as f:
    f.write(home_content)

# 2. Clean routes/web.php
routes_path = 'd:/portal-desa/webkel-sidomukti/routes/web.php'
with open(routes_path, 'r', encoding='utf-8') as f:
    routes_content = f.read()

routes_content = re.sub(r'// Survei Kepuasan Masyarakat \(SKM / IKM\) Routes \(Public\).*?name\(\'survei\.download\'\);\n', '', routes_content, flags=re.DOTALL)
routes_content = re.sub(r'\s*// Kelola Survei Kepuasan Masyarakat \(SKM / IKM\) Admin Routes.*?name\(\'dashboard\.survei\.destroy\'\);\n', '', routes_content, flags=re.DOTALL)
routes_content = re.sub(r'\s*Route::get\(\'/dashboard/survei\', \[App\\Http\\Controllers\\Dashboard\\SurveiAdminController::class, \'index\'\]\)->name\(\'dashboard\.survei\.index\'\);\n', '', routes_content)

with open(routes_path, 'w', encoding='utf-8') as f:
    f.write(routes_content)

# 3. Clean DatabaseSeeder.php
seeder_path = 'd:/portal-desa/webkel-sidomukti/database/seeders/DatabaseSeeder.php'
with open(seeder_path, 'r', encoding='utf-8') as f:
    seeder_content = f.read()

seeder_content = seeder_content.replace("            SurveiKepuasanSeeder::class,\n", "")

with open(seeder_path, 'w', encoding='utf-8') as f:
    f.write(seeder_content)

print("HomeController, routes, and DatabaseSeeder cleaned up successfully!")
