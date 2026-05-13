# RBAC Product Management System

A Laravel-based web application implementing Role-Based Access Control (RBAC)
using the Spatie Laravel Permission package. The system provides different
levels of access for Admins, Managers, and Customers with a complete product
and category management system.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Roles & Permissions](#roles--permissions)
- [Default Credentials](#default-credentials)
- [Application Structure](#application-structure)
- [Usage Guide](#usage-guide)
- [Image Upload & Cropping](#image-upload--cropping)
- [Routes Reference](#routes-reference)
- [Deployment on Shared Hosting](#deployment-on-shared-hosting)
- [Security](#security)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## Overview

The RBAC Product Management System is a full-featured web application built
with Laravel that demonstrates a real-world implementation of role-based access
control. It allows different types of users to interact with the platform based
on their assigned roles and permissions.

- **Admins** have full control over the entire system
- **Managers** can manage products and categories
- **Customers** can browse and view products

Live URL: [https://rbac.task.nlciinstitute.com](https://rbac.task.nlciinstitute.com)

---

## Features

### Authentication
- User registration and login via Laravel Breeze
- Secure password hashing
- Remember me functionality
- Role assigned automatically on registration (Customer)
- Protected routes with middleware

### Role-Based Access Control
- Three distinct roles: Admin, Manager, Customer
- Granular permission system via Spatie Laravel Permission
- Middleware-protected routes
- Blade directive support (`@can`, `@hasrole`)

### Admin Panel
- Clean dashboard with system statistics
- Recent products overview
- Full user management (view, edit, assign roles, delete)
- All Manager capabilities included

### Product Management (Admin & Manager)
- Create, read, update products
- Delete products (Admin only)
- Image upload with Cropper.js (crop before save)
- Base64 image processing and storage
- Product status toggle (Active / Inactive)
- Pagination

### Category Management (Admin & Manager)
- Create and manage categories
- Auto-generated slugs
- Product count per category
- Prevent deletion of categories with products

### Customer Storefront
- Browse all active products
- Search by product name
- Filter by category
- View full product details
- Related products section

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 11.x |
| Authentication | Laravel Breeze |
| RBAC | Spatie Laravel Permission |
| Frontend | Bootstrap 5.3 |
| Icons | Bootstrap Icons 1.11 |
| Image Cropping | Cropper.js 1.6 |
| Database | MySQL |
| Storage | Laravel Storage (public disk) |
| PHP | 8.2+ |

---

## Requirements

- PHP >= 8.2
- MySQL >= 5.7 or MariaDB >= 10.3
- Composer
- Node.js & NPM
- Apache with `mod_rewrite` enabled
- PHP Extensions:
  - `pdo_mysql`
  - `mbstring`
  - `openssl`
  - `tokenizer`
  - `xml`
  - `ctype`
  - `json`
  - `bcmath`
  - `fileinfo`
  - `gd` or `imagick`

---

## Installation

### 1. Clone or Upload the Project

```bash
git clone https://github.com/Ai-wallah-official/rbac.git rbac
cd rbac