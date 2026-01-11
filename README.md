🔐 IoT Based Door Unlocker System Using Laravel REST API

GitHub Repository: iot-door-unlocker-laravel-api

An IoT-based smart door unlocking system built using Laravel REST API and ESP32, allowing secure door control through a web dashboard with IP-based and passkey-based verification.

🚀 Project Overview

This project allows users to unlock a door remotely using a secure REST API.
Only one fixed IP address and a secret passkey are allowed to unlock the door, ensuring high security.

The system includes:

A Laravel-based admin panel

Role & permission management

Unlock logs & reports

ESP32-based IoT hardware control

🛠️ Technologies Used
Backend

Laravel (REST API)

PHP

MySQL

Laravel Authentication & Authorization

IoT Hardware

ESP32

Servo Motor

Jumper Wires

Battery (7.4V)

Charger

Traditional Door Lock

String mechanism

✨ Features
🔹 Admin Panel

Dashboard

Door Unlock System

Unlock with Passkey

Works only from one fixed IP address

User Management

Create, Update, Edit, Delete

Role-based access (User & Super Admin)

Role Management

Create, Update, Edit, Delete roles

Assign permissions

Permission Management

Unlock Logs (Reports)

View door unlock history

Filter by individual users

Settings

Secret API Key for verification

Fixed IP Address validation

Door will never unlock if IP or key doesn’t match

Profile Management

Update profile information

Change password

Update passkey

🌐 API Security Flow

ESP32 sends a request to the Laravel API

API verifies:

Secret Passkey

Fixed IP Address

If validation passes:

Door unlock signal is sent

If validation fails:

Door remains locked

🔧 IoT Working Process

ESP32 connects to WiFi

Sends REST API request to Laravel backend

Laravel validates credentials

ESP32 receives response

Servo motor rotates to unlock the door

Unlock activity is stored in the database

📂 Project Structure
├── app/
├── database/
│   ├── migrations/
│   └── database.sql
├── routes/
│   └── api.php
├── public/
├── resources/
├── esp32/
│   └── esp32_code.ino
└── README.md


📌 Note:
Database structure and ESP32 source code are available in separate folders.

📊 Unlock Log System

Logs every unlock attempt

Stores:

User

Time & Date

Status

Allows filtering by specific users

🔐 Security Highlights

IP-based door access

Secret API key verification

Role-based permission system

Secure REST API communication

📌 Future Improvements

Mobile app integration

OTP-based unlocking

Face or fingerprint authentication

Real-time notifications

👨‍💻 Author

Md. Maraz
Backend Developer | Laravel | IoT Enthusiast

⭐ Support

If you find this project useful, don’t forget to star ⭐ the repository!
