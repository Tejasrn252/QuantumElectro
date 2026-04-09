<div align="center">

# QuantumElectro

### Electro Storefront With Bold UI, PHP Auth, and Smooth Shopping Flow

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Frontend](https://img.shields.io/badge/HTML%20%7C%20CSS%20%7C%20JS-UI-0A0A0A?style=for-the-badge)](#)
[![Status](https://img.shields.io/badge/Status-Active-16A34A?style=for-the-badge)](#)

</div>

---

## What Is QuantumElectro?

QuantumElectro is a multi-page e-commerce web project focused on modern visuals, product storytelling, and practical account flow.
It combines static product experiences with PHP-powered authentication and database integration.

### Visual Direction
- Gradient-driven brand styling
- High-contrast components and hover depth
- Animated interactions for hero, cards, and buttons
- Mobile-friendly responsive layout

---

## Feature Highlights

| Area | Includes |
|---|---|
| Storefront | Home page, product listing, category/product detail pages |
| Commerce Flow | Cart page, checkout success path, order history pages |
| User Accounts | Register, login, logout, profile, auth status checks |
| Backend | PHP scripts with MySQL connection and persistence |
| Support | Contact form and save endpoint |

---

## Project Map

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
|- db.php
|- style.css
|- script.js
|- images/
`- product pages (*.html)
```

---

## Tech Stack

- Frontend: HTML5, CSS3, JavaScript
- Backend: PHP
- Database: MySQL
- Environment: XAMPP (Apache + MySQL)

---

## Quick Start (Local)

1. Place project inside your XAMPP htdocs directory.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Create database and required tables in MySQL.
4. Update connection values in db.php if needed.
5. Open in browser:

```bash
http://localhost/QuantumElectro/
```

Optional (if using PHP built-in server):

```bash
php -S 127.0.0.1:8000
```

---

## Core Pages

- Home: index.html
- Products Grid: products.html
- Cart: cart.html
- Contact: contact.html
- Login: login.php
- Register: register.php
- Profile: profile.php
- Orders: my-orders.php

---

## Security and Quality Notes

- Password hashing is used for credential safety
- Input sanitization and validation paths are present
- DB interactions are structured for practical integration
- Session-based auth workflow is implemented

---

## Why This Repo Looks Different

QuantumElectro intentionally avoids plain catalog aesthetics.
The UI language uses energetic gradients, bolder contrast, and interactive depth to feel more like a brand experience than a template storefront.

---

## Roadmap Ideas

- Payment gateway integration
- Search and filter system
- Product reviews and ratings
- Admin panel for catalog management
- API-first backend evolution

---

## Author

Built by Tejasrn252

If you like the project, star the repository and share feedback.
