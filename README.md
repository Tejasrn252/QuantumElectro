<div align="center">

<img src="public/images/banner.svg" alt="QuantumElectro Banner" width="100%" style="max-width:1100px;border-radius:12px;box-shadow:0 12px 40px rgba(2,6,23,0.6)"/>

<!-- toc -->

- [Spotlight](#spotlight)
- [Screenshots & Demo](#screenshots--demo)
- [Highlights](#highlights)
- [Quick Start (local)](#quick-start-local)
- [File map](#file-map)
- [Roadmap](#roadmap)
- [Credits](#credits)

<!-- tocstop -->

### A stylish electronics storefront built with HTML, CSS, JavaScript, PHP, and MySQL

[![Repo Status](https://img.shields.io/badge/Status-Live%20Project-16a34a?style=for-the-badge)](#)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![UI](https://img.shields.io/badge/UI-Gradient%20Driven-0f172a?style=for-the-badge)](#)

</div>

## Spotlight

QuantumElectro is not a plain storefront clone. It is designed to feel energetic and premium with colorful gradients, animated interactions, and practical shopping/account workflows.

- Strong visual identity with vivid gradient components
- Modern page transitions and hover depth
- Authentication and user session flow using PHP
- Database-backed forms and account actions
- Multi-page catalog structure for products and details

## Screenshots & Demo

Here are a few screenshots from the current project. To include an animated demo, add `demo.gif` to `public/images/` and it will show below.

<div align="center">
	<img src="public/images/Screenshot%202025-03-18%20164453.png" alt="QuantumElectro Preview" width="600" style="margin:8px; border-radius:8px; box-shadow:0 8px 30px rgba(99,102,241,0.18)" />
	<img src="public/images/WhatsApp%20Image%202025-03-18%20at%2017.25.34_d9340a53.jpg" alt="Preview 2" width="260" style="margin:8px; border-radius:8px; box-shadow:0 8px 30px rgba(139,92,246,0.12)" />
</div>

I added an inline animated SVG demo below — it renders on GitHub and shows a subtle simulated interaction. If you prefer a GIF instead, provide `public/images/demo.gif` and I'll swap it in.

<div align="center">
	<object data="public/images/demo.svg" type="image/svg+xml" width="820" height="300">Your browser does not support SVG.</object>
</div>

## What You Get

A polished multi-page electronics storefront with a gradient-driven UI, PHP authentication, and a working cart flow. The repository is organized into `frontend/`, `backend/`, and `public/` to make deployment and maintenance straightforward.

---

## Why this feels premium

- Vivid gradient system that reads well on light and dark screens
- Playful micro-interactions on hero, cards, and CTAs
- PHP-powered auth with session handling and password hashing
- Clean separation: `frontend/`, `backend/`, `public/` for easy deploy

---

## Eye Candy (Screenshots)

<div align="center">
	<img src="public/images/Screenshot%202025-03-18%20164453.png" alt="Hero preview" width="720" style="margin:8px;border-radius:10px;" />
	<img src="public/images/WhatsApp%20Image%202025-03-18%20at%2017.25.34_d9340a53.jpg" alt="Detail preview" width="320" style="margin:8px;border-radius:10px;" />
</div>

> Want a GIF demo? Add `public/images/demo.gif` and I'll embed it automatically.

---

## Highlights

- Multi-page product experience (no SPA required)
- Cart flow and order success path
- Register / login / profile / my-orders pages
- Contact form connected to `backend/save_contact.php`

---

## Quick Start (local)

1. Copy the project into your XAMPP `htdocs`.
2. Start Apache + MySQL from the XAMPP control panel.
3. Create the `quantumelectro` database and import any provided schema.
4. Update DB credentials in `backend/db.php`.
5. Visit:

```text
http://localhost/QuantumElectro/
```

Optional: run the PHP built-in server from the project root:

```bash
php -S 127.0.0.1:8000
```

---

## File map

```text
frontend/   # public-facing HTML/CSS/JS
backend/    # PHP endpoints and auth
public/     # images and static assets
index.php   # entry that routes to frontend
```

---

## Roadmap

- Payment gateway (Stripe/PayPal)
- Admin panel + product management
- Search, filters, and sorting UX
- Lightweight API wrapper

---

## Credits

Built and designed by Tejasrn252 — reach out with feedback or collaboration ideas.

If this project inspires you, give it a star and share your feedback.
