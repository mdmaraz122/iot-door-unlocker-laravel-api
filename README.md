**🔐 IoT Based Door Unlocker System Using Laravel REST API**
GitHub Repository: iot-door-unlocker-laravel-api

**An IoT-based smart door unlocking system built using Laravel REST API** and **ESP32**, allowing secure door control through a web dashboard with IP-based and passkey-based verification.

**🚀 Project Overview**

This project allows users to unlock a door remotely using a secure REST API.
Only one fixed IP address and a secret passkey are allowed to unlock the door, ensuring high security.

**The system includes:**
**1. A Laravel-based admin panel
2. Role & permission management
3. Unlock logs & reports
4. ESP32-based IoT hardware control**

**🛠️ Technologies Used**
**Backend**
1. Laravel (REST API)
2. PHP
3. MySQL
4. Laravel Authentication & Authorization

**IoT Hardware**
1. ESP32
2. Servo Motor
3. Jumper Wires
4. Battery (7.4V)
5. Charger
6. Traditional Door Lock
7. String mechanism

**✨ Features**
**🔹 Admin Panel**
1. Dashboard
2. Door Unlock System
   . Unlock with Passkey
   . Works only from one fixed IP address
3. User Management
   . Create, Update, Edit, Delete
   . Role-based access (User & Super Admin)
4. Role Management
   . Create, Update, Edit, Delete roles
   . Assign permissions
5. Permission Management
6. Unlock Logs (Reports)
   . View door unlock history
   . Filter by individual users
7. Settings
   . Secret API Key for verification
   . Fixed IP Address validation
   . Door will never unlock if IP or key doesn’t match

8. Profile Management
   . Update profile information
   . Change password
   . Update passkey

**🌐 API Security Flow**
1. ESP32 sends a request to the Laravel API
2. API verifies:
   . Secret Passkey
   . Fixed IP Address
3. If validation passes:
   . Door unlock signal is sent
4. If validation fails:
   . Door remains locked

**🔧 IoT Working Process**
1. ESP32 connects to WiFi
2. Sends REST API request to Laravel backend
3. Laravel validates credentials
4. ESP32 receives response
5. Servo motor rotates to unlock the door
6. Unlock activity is stored in the database

**📌 Note:**
Database structure and ESP32 source code are available in separate folders.


**📊 Unlock Log System**

1. Logs every unlock attempt
2. Stores:
   . User
   . Time & Date
   . Status
3. Allows filtering by specific users

**🔐 Security Highlights**
1. IP-based door access
2. Secret API key verification
3. Role-based permission system
4. Secure REST API communication

**📌 Future Improvements**
1. Mobile app integration
2. OTP-based unlocking
3. Face or fingerprint authentication
4. Real-time notifications

**👨‍💻 Author**

**Md. Maraz
Backend Developer | Laravel | IoT Enthusiast**

**⭐ Support
If you find this project useful, don’t forget to star ⭐ the repository!**
