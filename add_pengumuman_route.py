import re

routes_path = 'd:/portal-desa/webkel-sidomukti/routes/web.php'
with open(routes_path, 'r', encoding='utf-8') as f:
    routes_content = f.read()

# Insert public route for pengumuman
public_route = "\nRoute::get('/informasi/pengumuman', [App\\Http\\Controllers\\PublicAnnouncementController::class, 'index'])->name('announcements.index');\n"

# Insert after "Route::get('/profil/demografi', [App\Http\Controllers\ProfileController::class, 'demografi'])->name('profil.demografi');"
routes_content = re.sub(
    r"(Route::get\('/profil/demografi'.*?\n)",
    r"\1" + public_route,
    routes_content
)

with open(routes_path, 'w', encoding='utf-8') as f:
    f.write(routes_content)

print("Added public route for pengumuman")
