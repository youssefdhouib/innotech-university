<div align="center">

<img src="frontend-innotech/src/assets/logo.png" alt="InnoTech University Logo" width="120" />

# 🎓 InnoTech University

### A Modern University Web Platform

**Full-Stack · Multi-Language · RESTful API · Angular 19 + Laravel 12**

[![Angular](https://img.shields.io/badge/Angular-19-DD0031?style=for-the-badge&logo=angular&logoColor=white)](https://angular.io)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.7-3178C6?style=for-the-badge&logo=typescript&logoColor=white)](https://typescriptlang.org)

---

</div>

## 🎬 Demo

> 📹 **Video demo coming soon!**
>
> <!-- Replace the line below with your actual video URL after recording -->
> <!-- [![Watch Demo](https://img.shields.io/badge/Watch-Demo-red?style=for-the-badge&logo=youtube)](YOUR_VIDEO_URL) -->

---

## 📖 About The Project

**InnoTech University** is a fully-featured university web platform built as a complete full-stack application. It enables students to explore academic programs, browse the teaching staff, read university news & events, and submit pre-registration applications — all in **3 languages** (French, Arabic, English) with real-time language switching.

The platform is designed with a clean, professional interface using **Angular 19** on the frontend and a **Laravel 12 REST API** on the backend, with a fully translatable MySQL database.

---

## ✨ Key Features

| Feature | Description |
|---|---|
| 🌍 **Multilingual (i18n)** | Full support for **French, Arabic & English** — UI + database content |
| 👨‍🏫 **Professor Profiles** | Browse the teaching team with photos, specializations, and full detail pages |
| 📚 **Degrees & Programs** | Explore Licence and Master programs with departmental filtering |
| 🏛️ **Departments** | Dedicated pages for each department with their associated programs |
| 📰 **News & Events** | University news and upcoming events with category filtering |
| 📝 **Pre-registration** | Full application form with document uploads and email confirmation flow |
| 📧 **Email System** | Branded email notifications via Laravel Mail with custom templates |
| 🤖 **AI Chatbot** | Integrated chatbot assistant for student queries |
| 📞 **Contact Page** | Contact form with backend validation |
| 🔒 **Signed URL Flow** | Secure email confirmation via Laravel signed URLs |

---

## 🛠️ Tech Stack

### Frontend
- **Angular 19** — Standalone components, lazy-loaded routes
- **PrimeNG 19** — UI component library
- **ngx-translate** — Runtime i18n with JSON locale files
- **RxJS** — Reactive state and HTTP management
- **TypeScript 5.7**

### Backend
- **Laravel 12** (PHP 8.2) — RESTful API
- **MySQL** — Translatable database with `_translations` tables
- **Laravel Mail** — Branded email notifications
- **L5-Swagger** — Auto-generated API documentation
- **Sanctum / Signed URLs** — Secure authentication flows

---

## 📁 Project Structure

```
innotech-university/
├── backend-innotech/          # Laravel 12 REST API
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── API/V1/        # API Controllers
│   │   │   │   ├── ProfessorController.php
│   │   │   │   ├── DepartmentController.php
│   │   │   │   ├── DegreeController.php
│   │   │   │   ├── ProgramController.php
│   │   │   │   ├── NewsController.php
│   │   │   │   ├── PreinscriptionController.php
│   │   │   │   ├── ConfirmationController.php
│   │   │   │   ├── DocumentController.php
│   │   │   │   └── ContactController.php
│   │   │   └── ChatbotController.php
│   ├── resources/views/vendor/mail/   # Custom email templates
│   └── storage/app/public/            # Uploaded files & assets
│
└── frontend-innotech/         # Angular 19 SPA
    └── src/
        ├── app/
        │   ├── pages/         # 13 feature pages
        │   │   ├── home/
        │   │   ├── professors/ & professor-details/
        │   │   ├── departments/ & department-detail/
        │   │   ├── degrees/ & degree-detail/
        │   │   ├── news/ & news-details/
        │   │   ├── preinscription/
        │   │   ├── about/
        │   │   ├── contact/
        │   │   └── confirmation/
        │   ├── core/
        │   │   ├── services/  # API service layer
        │   │   ├── models/    # TypeScript interfaces
        │   │   ├── interceptors/  # Auth + language headers
        │   │   └── state/     # Reactive language state
        │   └── shared/components/   # Header, Footer, Chatbot, etc.
        └── assets/i18n/       # ar.json | fr.json | en.json
```

---

## 🚀 Getting Started

### Prerequisites

- **PHP** >= 8.2
- **Composer**
- **Node.js** >= 18 & **npm**
- **MySQL** database

---

### Backend Setup

```bash
# 1. Navigate to backend
cd backend-innotech

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and configure it
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure your .env database credentials
#    DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Run migrations
php artisan migrate

# 7. Link storage for public files
php artisan storage:link

# 8. Start the API server
php artisan serve
```

> API runs at: `http://localhost:8000`

---

### Frontend Setup

```bash
# 1. Navigate to frontend
cd frontend-innotech

# 2. Install Node dependencies
npm install

# 3. Start the dev server
npm start
```

> App runs at: `http://localhost:4200`

---

## 🌐 API Overview

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/professors` | List all professors (language-aware) |
| `GET` | `/api/professors/slug/{slug}` | Get professor by slug |
| `GET` | `/api/departments` | List all departments |
| `GET` | `/api/degrees` | List all degrees/programs |
| `GET` | `/api/news` | List news articles |
| `GET` | `/api/news?category=event` | Filter by category |
| `POST` | `/api/preinscription` | Submit pre-registration |
| `GET` | `/api/confirmation` | Confirm application via signed URL |
| `POST` | `/api/contact` | Submit contact form |
| `POST` | `/api/chatbot` | Query the AI assistant |

> All endpoints support the `Accept-Language` header for multilingual responses (`fr`, `ar`, `en`).

---

## 📸 Screenshots

> _Screenshots coming soon!_

---

## 🤝 Contributing

This is an academic project. Contributions, issues, and feature requests are welcome!

---

## 📄 License

Distributed under the **MIT License**.

---

<div align="center">

Made with ❤️ for **InnoTech University**

</div>
