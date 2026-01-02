# Naimat Store 🛒

A PHP & MySQL based e-commerce web application developed using XAMPP.

## 📌 Features
- User authentication (Login / Register)
- Product listing
- Admin dashboard
- MySQL database integration
- Responsive UI

## 🛠️ Technologies Used
- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- XAMPP

## 📂 Project Structure
naimat-store/
├── assets/
├── includes/
├── admin/
├── sql/
│   └── naimat_store.sql
├── index.php
├── README.md


## ⚙️ Setup Instructions (Localhost)

1. Install **XAMPP**
2. Clone this repository:
```bash
git clone https://github.com/your-username/naimat-store.git

C:\xampp\htdocs\
Start Apache & MySQL
Import database:
Open phpMyAdmin
Create database naimat_store
Import sql/naimat_store.sql
Update database connection in includes/db.php

$host = "localhost";
$user = "root";
$password = "";
$database = "naimat_store";

📄 License

---

## ✅ 4️⃣ GitHub Par Publish Karne Ke Steps

### 🔹 Terminal / Git Bash
```bash
cd naimat-store
git init
git add .
git commit -m "Initial commit - PHP MySQL project"
git branch -M main
git remote add origin https://github.com/username/naimat-store.git
git push -u origin main
