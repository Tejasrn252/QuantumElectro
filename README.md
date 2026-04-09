<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&height=220&text=QuantumElectro&fontAlign=50&fontAlignY=40&color=0:0ea5e9,30:6366f1,70:8b5cf6,100:ec4899&fontColor=ffffff&desc=Vibrant%20E-Commerce%20Experience&descAlign=50&descAlignY=62" alt="QuantumElectro Banner" />

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

## Preview

<div align="center">
	<img src="images/Screenshot%202025-03-18%20164453.png" alt="QuantumElectro Preview" width="860" />
</div>

## What You Get

| Module | Pages and Capabilities |
|---|---|
| Store Experience | Home, products grid, product detail pages |
| User Journey | Register, login, logout, profile, auth checks |
| Commerce Flow | Cart, order success, order history |
| Contact Layer | Contact form UI + save endpoint |
| Platform | PHP backend scripts + MySQL integration |

## Visual Language

- Color direction: indigo, purple, pink with bold contrast accents
- Depth effects: layered shadows and lift-on-hover cards
- Motion: subtle transitions for cards, buttons, and key sections
- Responsive behavior: layouts adapt for desktop and mobile widths

## Stack

- Frontend: HTML5, CSS3, JavaScript
- Backend: PHP
- Database: MySQL
- Local environment: XAMPP (Apache + MySQL)

## Architecture Snapshot

```mermaid
flowchart LR
	A[User Browser] --> B[HTML CSS JS Pages]
	B --> C[PHP Endpoints]
	C --> D[(MySQL Database)]
	C --> E[Session State]
	B --> F[Cart and Product Views]
```

## Core Files

```text
QuantumElectro/
|- index.html
|- products.html
|- cart.html
|- contact.html
|- login.php
|- register.php
|- profile.php
|- my-orders.php
|- order-success.php
|- db.php
|- script.js
|- style.css
`- images/
```

## Quick Start

1. Move the project into your XAMPP htdocs folder.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Create the project database and required tables.
4. Verify DB credentials in db.php.
5. Open this URL:

```text
http://localhost/QuantumElectro/
```

Optional local server mode:

```bash
php -S 127.0.0.1:8000
```

## Security and Reliability

- Password hashing for credentials
- Validation and sanitization pathways
- Session-based authentication flow
- Structured PHP to DB interaction layer

## Roadmap

- Payment gateway integration
- Search and advanced filtering
- Product ratings and reviews
- Admin dashboard for inventory/content management
- API-first backend expansion

## Creator

Built by Tejasrn252.

If this project inspires you, give it a star and share your feedback.
