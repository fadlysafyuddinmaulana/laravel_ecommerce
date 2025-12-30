# 🛒 E-Commerce Laravel With Database PostgreSQL

## About Project

This project focuses on developing an e-commerce system built with Laravel that includes CRUD functionality, a PostgreSQL database, multi-role implementation, account verification, and RESTful API testing.

The project is built with:

- **Laravel** as the backend framework
- **PostgreSQL** as the database
- **AdminLTE** for dashboard admin UI
- **Furni** for user UI

---

## Requirements

- PHP >= 8.x
- Composer
- PostgreSQL
- Node.js & npm (if you use frontend build tools)
- Git

---

## Installation

git clone [Laravel_Eccomerece](https://github.com/fadlysafyuddinmaulana/laravel_ecommerce.git)

cd laravel_ecommerce
composer install

cp .env.example .env
php artisan key:generate

---

## Key Features

- 🛍️ **Product catalog and CRUD**: Manage products with create, read, update, and delete operations, including details like name, price, stock, description, and images.
- 🧺 **Shopping cart and checkout**: Allow users to add products to a cart, update quantities, and complete orders through a simple checkout flow.
- 👤 **User accounts and roles**: Support registration, login, and multiple roles such as admin, seller, and customer with different permissions.
- 📦 **Order management**: Track orders, view order history, and update order status (pending, processed, shipped, completed).
- 📱💻 **Responsive design**: Ensure the site works well on mobile and desktop so users can shop comfortably on any device.
- 📧 **Email verification**: Send verification emails after registration to confirm the user’s email address and enhance account security.
- 🔍 **Product search and filtering**: Search bar, filter by category/price, and sorting to make it easier for users to find products.

---

## How to Use / Setup

If you want to use or extend this project, you can:

Configure the **database connection** to PostgreSQL and **mail verification** in the Laravel environment file (`.env`).

### 1. Configure database connection

- Open the `.env` file in the root of this project and find the lines starting with `DB_` (`DB_CONNECTION`, `DB_HOST`, etc.).
- In the current setup, PostgreSQL is used. If you want to use another database (for example MySQL), you can adjust `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.

```
DB_CONNECTION=your_vendor_database
DB_HOST=127.0.0.1
DB_PORT=your_port_database
DB_DATABASE=your_name_database
DB_USERNAME=your_username_database
DB_PASSWORD=your_password_database
```

### 2. Configure email verification

- Before editing the `.env`, complete the 2‑step verification for the email account you will use.
- On the Google Security page, go to **App passwords** and create a new application (for example, named `Laravel`). If you cannot find it, go directly to this page: [App Password](https://myaccount.google.com/apppasswords).
- Save the generated 16‑digit app password without spaces; this value will be used as `MAIL_PASSWORD`.
- After everything is set in the `.env` file, you can test the verification feature.

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587 //default_port
MAIL_USERNAME= your_email
MAIL_PASSWORD= your_app_password
MAIL_FROM_ADDRESS="your_email"
MAIL_FROM_NAME="${APP_NAME}" //Default_From_Name
```

> Note: The app password name is not important; only the generated password is used. Make sure to remove spaces from the 16‑digit password. You can use either a new email account or your existing email account for this setup, but using a new email is recommended for better separation and security.

### 3. Install and test API

To prepare and test the RESTful API module, run:

```
php artisan install:api
php artisan migrate
php artisan serve
```

After that, you can test the API endpoints (such as products or orders) using tools like Postman or Insomnia.

---

## API Endpoints (Example)

```
GET /api/products # List all products
GET /api/products/{id} # Get product detail
POST /api/products # Create new product
PUT /api/products/{id} # Update product
DELETE /api/products/{id} # Delete product

GET /api/orders # List all orders
GET /api/orders/{id} # Get order detail
POST /api/orders # Create new order
PUT /api/orders/{id} # Update order status
DELETE /api/orders/{id} # Cancel/delete order
```

---

## Demo Accounts (Optional Example)

```
Admin: admin@example.com / password
Seller: seller@example.com / password
Customer: customer@example.com / password
```

## Closing

This project is designed as a learning and portfolio-ready e-commerce application built with Laravel and PostgreSQL. Feel free to fork, modify, and extend it according to your needs, and contributions or suggestions are always welcome.