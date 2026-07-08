# Buddy Invoices

**Buddy Invoices** is an easy-to-use application designed to simplify the invoicing process for **Aparajitha**. With an intuitive interface and smart automation, it handles everything from invoice generation to payment tracking and purchase order management.

## 🚀 Features

- Configure client information and pricing models.
- Upload monthly data to auto-generate invoices with digital signatures.
- Automatically email invoices to clients.
- Track payments with ease.
- Manage purchase orders effortlessly.
- Real-time updates with Pusher integration.

## 🛠️ Tech Stack

- **Backend**: PHP 8.4, Laravel
- **Database**: MySQL 8, MongoDB
- **Frontend**: HTML5, CSS3, JavaScript, jQuery
- **Realtime**: Pusher
- **Version Control**: Git
- **Package Management**: Composer, npm

## ⚙️ Setup Instructions

Follow the steps below to set up the project locally:

1. **Clone the repository**
   ```bash
   git clone http://gitlab.myaparajitha.link/aparajithainvoices/aparajitha-invoices.git
   cd buddy-invoices
   ```

2. **Environment Setup**
   - Place the updated `.env` file in the root directory with all relevant credentials.

3. **Required PHP Extensions**
   Make sure the following extensions are installed and enabled:
   - `mongodb`
   - `sqlsrv`
   - `pdo_sqlsrv`

4. **Install Backend Dependencies**
   ```bash
   composer install --ignore-platform-reqs
   php artisan optimize:clear
   ```

5. **Install Frontend Dependencies** (optional)
   ```bash
   npm install
   ```

6. **Run the Application**
   ```bash
   php artisan serve
   ```

## 📦 Additional Notes

- Ensure Composer and npm are installed on your system.
- MongoDB and MySQL servers should be running and accessible.

## 📬 Contact

For questions, feedback, or support, please contact the project maintainer.
