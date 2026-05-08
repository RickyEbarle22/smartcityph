# SmartCity PH

A next-generation Philippine government services portal — a stunning, dark, glassmorphic, citizen-first web app where Filipinos can discover, search, and access government services across all 17 regions.

> Built with CodeIgniter 4 · Three.js · GSAP · Leaflet · pure HTML/CSS/JS — themed with the Philippine flag colors (blue, red, gold) on a deep-space dark canvas.

---

## ✨ Highlights

- **3D animated city skyline** hero (Three.js r128) with the Philippine sun
- **GSAP** scroll-triggered cinematic animations
- **Region-based service search** with autocomplete (17 PH regions)
- **20+ real Philippine government services** across 8 categories
- **Citizen accounts** — register, sign in, edit profile, leave service feedback
- **Admin panel** with full CRUD for services, news, regions, users, reports
- **Interactive Leaflet map** with CartoDB Dark tiles (no API key)
- **Report an Issue** with photo upload + map location pin
- **Visual report tracker** with timeline progress UI
- **Government Transparency** dashboard with project budgets and progress
- **Emergency hotline directory** (911, 117, 160, 143, 1555, 8888, …)
- **Service ratings & reviews** (one per user, per service)
- **WCAG-aware** dark UI with high contrast and visible focus rings
- **Mobile-responsive** with reduced 3D complexity for smaller devices

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | CodeIgniter 4 (PHP 8.1+) |
| Database | MySQL via XAMPP — `127.0.0.1`, port `3306`, db `smartcityph` |
| Frontend | Vanilla HTML / CSS / JS (no React, Vue, or Tailwind) |
| 3D | Three.js r128 (CDN) |
| Animations | GSAP 3.12 + ScrollTrigger + AOS |
| Maps | Leaflet 1.9 + CartoDB Dark |
| Type | Poppins (headings) + Inter (body) |
| Icons | Font Awesome 6 |

## 🚀 Quick Start

```bash
# 1. Clone
git clone https://github.com/RickyEbarle22/smartcityph.git
cd smartcityph

# 2. Install dependencies
composer install

# 3. Set up environment
cp env .env
# Edit .env to match your XAMPP MySQL settings (port 3306 by default)

# 4. Create the database
mysql -u root -e "CREATE DATABASE smartcityph CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci"

# 5. Run migrations and seed
php spark migrate --all
php spark db:seed SmartCitySeeder

# 6. Run the dev server
php spark serve
# Or place inside XAMPP htdocs and visit http://localhost/smartcityph/public/
```

## 🔑 Default credentials

- **Admin**: `admin / admin123` → `/admin-login`
- **Sample citizen**: `juan@email.com / citizen123`

## 🗺️ Routes Overview

Public:
- `/` — 3D hero homepage
- `/services`, `/services/{slug}`, `/services/search`
- `/news`, `/news/{slug}`
- `/reports` (file an issue)
- `/track` (track a report by reference)
- `/transparency` — project & budget dashboard
- `/about`, `/contact`, `/emergency`

Citizen:
- `/login`, `/register`, `/logout`
- `/user/dashboard`, `/user/profile`, `/user/reports`

Admin (under `auth` filter):
- `/admin-login`, `/admin-logout`
- `/admin` (dashboard)
- `/admin/services|news|reports|regions|users` — full CRUD

API (JSON):
- `/api/services/search?q=&region_id=`
- `/api/regions`

## 🇵🇭 Built by

**Ricky G. Ebarle** — BSIT 3rd Year, CPSC

## 📄 License

MIT — built for the Filipino people.
