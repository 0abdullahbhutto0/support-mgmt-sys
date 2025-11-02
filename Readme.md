# Support Ticket Management System

A comprehensive web-based customer support ticket management system built with **PHP** and **MySQL**.  
This application streamlines support operations by providing an organized platform for ticket creation, tracking, and resolution.

## Table of Contents
- [Features](#features)
- [Technology Stack](#technology-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Security Considerations](#security-considerations)
- [Future Enhancements](#future-enhancements)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Features

### User Features
- User registration and authentication
- Create support tickets with subject and description
- View personal ticket history and status
- Real-time threaded comments on tickets
- Track ticket status (Pending, Received, In Progress, Resolved)
- Search functionality for tickets
- Responsive design for mobile and desktop

### Admin Features
- Comprehensive dashboard with ticket statistics
- View all tickets across the system
- Update ticket status
- Respond to tickets via threaded comments
- Delete tickets with cascading comment removal
- Separate views for open and resolved tickets
- Advanced search and filtering capabilities

### System Features
- Role-based access control (User/Admin)
- Session management for secure authentication
- Timestamp tracking for audit trails
- Color-coded status indicators
- Auto-scroll to latest comments in threads
- Clean, modern user interface

## Technology Stack
**Frontend:** HTML5, CSS3, JavaScript  
**Backend:** PHP 7.4+  
**Database:** MySQL / MariaDB  
**Server:** Apache (XAMPP / WAMP / LAMP)

## System Requirements
- PHP 7.4 or higher
- MySQL 5.7 or MariaDB 10.2 or higher
- Apache Web Server
- Modern web browser (Chrome, Firefox, Safari, Edge)

## Installation

Clone the repository to your local machine:
```bash
git clone https://github.com/yourusername/support-mgmt-sys.git
```

Move the project folder to your web server directory:

```
XAMPP: C:\xampp\htdocs\support-mgmt-sys
WAMP:  C:\wamp\www\support-mgmt-sys
LAMP:  /var/www/html/support-mgmt-sys
```

Start Apache and MySQL services through your server control panel.  
Then access the application at:

```
http://localhost/support-mgmt-sys
```

## Database Setup

1. Open **phpMyAdmin** at [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Create a new database named `support_db`
3. Execute the following SQL commands:

```sql
CREATE DATABASE support_db;
USE support_db;

-- Users table
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
);

-- Tickets table
CREATE TABLE tickets (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Comments table
CREATE TABLE comments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

4. Update your database configuration in `db_connection.php`:

```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "support_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

## Usage

### For Users
- Registration: Navigate to the signup page and create an account
- Login: Use your credentials to access the user dashboard
- Create Ticket: Fill in the subject and description fields
- Track Status: View your tickets and their current status
- Add Comments: Communicate with support through ticket threads

### For Administrators
- Login: Use admin credentials to access the admin panel
- Dashboard: View statistics for all tickets
- Manage Tickets: Update status, respond to tickets, or delete as needed
- Search: Use the search bar to find specific tickets
- Resolution: Move tickets through workflow stages to resolution

## Project Structure

```
support-mgmt-sys/
├── index.php
├── login.php
├── signup.php
├── user.php
├── admin.php
├── thread.php
├── delete.php
├── style.css
├── db_connection.php
└── README.md
```

## Security Considerations

### Implemented Security Measures
- Password hashing using `password_hash()`
- Session-based authentication
- Role-based access control
- SQL injection prevention through prepared statements
- Input validation and sanitization

### Recommendations
- Use HTTPS in production environments
- Implement CSRF token protection
- Add rate limiting for login attempts
- Regular security audits and updates
- Enforce strong password policy

## Future Enhancements
- Email notifications for ticket updates
- File attachment support
- Priority levels for tickets
- SLA (Service Level Agreement) tracking
- Advanced reporting and analytics
- Multi-language support
- API for third-party integrations
- Real-time chat support
- Knowledge base integration
- Ticket assignment to specific agents

## Screenshots
- Landing Page – Show Image
- User Dashboard – Show Image
- Admin Panel – Show Image
- Ticket Thread – Show Image

## Contributing
Contributions are welcome!  
Follow these steps to contribute:

```bash
# 1. Fork the repository
# 2. Create a feature branch
git checkout -b feature/AmazingFeature

# 3. Commit your changes
git commit -m "Add some AmazingFeature"

# 4. Push to the branch
git push origin feature/AmazingFeature

# 5. Open a Pull Request
```

## License
This project is licensed under the **MIT License** – see the [LICENSE](LICENSE) file for details.

## Contact
For questions or support, please open an issue in the GitHub repository.

**Version:** 1.0.0  
**Last Updated:** November 2025  
**Maintainer:** Your Name
