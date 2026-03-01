# Leather Store PHP Application

A comprehensive E-commerce platform for leather products built with PHP. This project features a full customer-facing storefront and a robust administrative panel for managing the business.

This project was created primarily for **learning purposes**, demonstrating CRUD operations, authentication, PHPMailer for mail verification and notifications, database management, and containerized environments.

## 🚀 Features

### Admin Panel

* **User Management:** View, edit, and manage registered customers.
* **Product Management:** Create, update, and delete leather products (titles, descriptions, prices, and images).
* **Order Tracking:** Monitor customer purchases and status.

### User Space

* **Product Catalog:** Browse through the collection of leather goods.
* **Shopping Cart:** Select products and manage items before checkout.
* **Checkout System:** Purchase products seamlessly.
* **Email Notifications:** Receive automated emails for account actions or orders via SMTP.

---

## 🛠 Prerequisites

Before you begin, ensure you have the following installed:

* [Docker](https://docs.docker.com/desktop/setup/install/windows-install/)
* [Docker Compose](https://docs.docker.com/compose/install/)

You will also need a **Mail Account** (e.g., Gmail) configured for SMTP access. If using Gmail, you must generate an [App Password](https://support.google.com/accounts/answer/185833?hl=en).

---

## ⚙️ Setup & Installation

1. **Clone the repository:**
```bash
git clone https://github.com/habib-source/php_leather_store.git
cd php_leather_store

```


2. **Configure Environment Variables:**
Create a file named `.dockerenv` in the root directory and add your SMTP credentials:
```env
EMAIL_HOST=smtp.gmail.com
EMAIL_HOST_PORT=587
EMAIL_USE_TLS=TRUE
EMAIL=your_name@gmail.com
EMAIL_PASSWORD=your_gmail_app_password

```


3. **Launch the Application:**
Run the following command to build and start the containers:
```bash
docker compose up -d

```


4. **Access the App:**
Once the containers are running, open your browser and navigate to:
`http://localhost` (or the port specified in your docker-compose file).

---

## ⚖️ License

This project is open-source and available under the **GPL-3.0 License**. You are free to use, modify, and distribute it as you wish for your own learning or projects.

---
