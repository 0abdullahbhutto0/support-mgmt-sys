# Support Ticket Management System

A comprehensive web-based customer support ticket management system built with **PHP** and **MySQL**.  
This application streamlines support operations by providing an organized platform for ticket creation, tracking, and resolution.

## Table of Contents
- [Features](#features)
- [Technology Stack](#technology-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)

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
- bash
- git clone https://github.com/yourusername/support-mgmt-sys.git
- Move the project folder to your web server directory:
- XAMPP: C:\xampp\htdocs\support-mgmt-sys
- Start Apache and MySQL services through your server control panel.  
- Then access the application at:
- http://localhost/support-mgmt-sys

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

support-mgmt-sys/
├── index.php
├── login.php
├── adminlogin.php
├── signup.php
├── user.php
├── admin.php
├── thread.php
├── delete.php
├── landing.html
├── styles.css
├── layout.css
├── auth.css
├── database.php
└── README.md