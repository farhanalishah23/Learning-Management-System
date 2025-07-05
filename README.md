# 🎓 Learning Management System – Laravel 7

A complete **Learning Management System (LMS)** built using **Laravel 7**, supporting **three roles**: **Admin, Teacher, and Student**. This LMS allows admin to manage teachers, teachers to manage courses and create questions, and students to register, enroll in courses, and submit answers. The app includes full **role-based access control**, dynamic **AJAX-based interactions**, and **teacher-assigned grading**.

---

## 🚀 Features

### 👨‍🏫 Admin
- Create/manage teachers
- View all students and courses
- Assign course categories
- Manage platform content

### 🧑‍🏫 Teacher
- Create courses
- Add questions to courses (via AJAX modal)
- View enrolled students
- Grade student responses (marking system)

### 👨‍🎓 Student
- Register/Login to platform
- Enroll in available courses
- View teacher's questions dynamically
- Submit answers (AJAX)
- See grades from teacher

---

## 🛠️ Tech Stack

| Framework   | Template | Frontend | DB       | AJAX |
|-------------|----------|----------|----------|------|
| Laravel 7   | Blade    | Bootstrap 4 | MySQL | jQuery (AJAX) |

---

## 🔐 Role-Based Access (via Middleware)

The app uses custom **Laravel middleware** to secure routes:

| Route         | Accessible By     |
|---------------|-------------------|
| `/admin/*`    | Admin only        |
| `/teacher/*`  | Teacher only      |
| `/student/*`  | Student only      |

Middleware ensures only the correct user type accesses each section.

---

## 📂 Folder Structure

```
/app
/routes
/resources/views
  ├── /admin
  ├── /teacher
  ├── /student
/public
```

---

## 📦 Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/your-username/laravel-lms.git
cd laravel-lms
```

### 2️⃣ Install Dependencies

```bash
composer install
```

### 3️⃣ Setup `.env`

```bash
cp .env.example .env
```

Edit the DB and mail config:

```env
DB_DATABASE=lms_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Run Migrations

```bash
php artisan migrate
php artisan db:seed  # If seeder added for roles
```

### 5️⃣ Serve the App

```bash
php artisan serve
```

Visit: `http://localhost:8000`

---

## ⚙️ AJAX Question Submission Flow

- Teacher adds a question → AJAX modal opens → Question saved without page reload  
- Student views question list → Submits answer via AJAX  
- Teacher reviews and assigns marks

---

## 🧪 Sample Roles (Dummy Accounts)

```text
Admin:
  Email: admin@yopmail.com
  Password: 12345678

Teacher:
  Created by admin panel

Student:
  Registers from frontend
```


## 📄 License

This project is open-source and free to use.


