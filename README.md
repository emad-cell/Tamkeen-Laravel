# Tamkeen — تمكين 🌟

> A platform connecting people with special needs to verified associations offering specialized services.

![Status](https://img.shields.io/badge/Status-In%20Development-yellow)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![React](https://img.shields.io/badge/React-18-blue)

---

## 📌 About The Project

**Tamkeen (تمكين)** is a web platform designed to empower people with special needs by connecting them with trusted associations and NGOs that offer specialized services — such as therapy sessions, psychological support, and rehabilitation programs.

Think of it as a service marketplace, but purpose-built for the special needs community:

- 🏥 **Associations** list the services they offer
- 🙋 **Clients** browse and request those services
- 🛡️ **Admins** verify that associations are legitimate before they go live

---

## ✨ Key Features

### For Clients (People with Special Needs)

- Browse available services offered by verified associations
- Request services directly through the platform
- Share success stories with the community

### For Associations / NGOs

- Register and submit official documents for verification
- List and manage offered services (therapy, counseling, etc.)
- Manage job listings related to their services

### For Admins

- Review and approve/reject association registration requests
- Verify uploaded official documents before granting access
- Manage all users, services, and success stories
- Full control via a dedicated admin dashboard

---

## 🔐 Roles & Permissions

Built with **Spatie Laravel Permission** for fine-grained access control:

| Role          | Permissions                                                        |
| ------------- | ------------------------------------------------------------------ |
| `Admin`       | Manage Users, Manage Services, Manage Jobs, Manage Success Stories |
| `Association` | Manage Services, Manage Jobs                                       |
| `Client`      | Request Services, Add Success Stories                              |

---

## 🛠️ Tech Stack

| Layer        | Technology                          |
| ------------ | ----------------------------------- |
| Backend      | Laravel 12                          |
| Frontend     | React 18                            |
| Auth & Roles | Laravel Sanctum + Spatie Permission |
| Database     | MySQL                               |

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL

### Installation

```bash
# Clone the repositories
git clone https://github.com/emad-cell/Tamkeen-Laravel
git clone https://github.com/emad-cell/Tamkeen-React

# --- Backend Setup ---
cd Tamkeen-Laravel
composer install
cp .env.example .env
php artisan key:generate

# Configure your database in .env, then:
php artisan migrate --seed
php artisan storage:link
php artisan serve

# --- Frontend Setup ---
cd ../Tamkeen-React
npm install
npm run dev
```

### Default Admin Credentials

```
Email:    admin@example.com
Password: (set in seeder)
```

---

## 📁 Project Structure

```
Tamkeen-Laravel/     → REST API backend (Laravel 12)
Tamkeen-React/       → Frontend SPA (React)
```

---

## 🗺️ Roadmap

- [x] Role & permission system (Admin / Association / Client)
- [x] Association registration with document upload
- [x] Admin approval workflow
- [x] Service management
- [x] Success stories
- [ ] Service request flow (in progress)
- [ ] Notifications system
- [ ] Admin dashboard UI completion
- [ ] Deployment

---

## 👨‍💻 Author

**Emad Dayoub**

- GitHub: [@emad-cell](https://github.com/emad-cell)
- LinkedIn: [linkedin.com/in/emad-dayoub-354b95284](https://www.linkedin.com/in/emad-dayoub-354b95284)

---

> 🚧 This project is currently under active development.
