# Project Stream

<div align="center">

![Project Stream](https://img.shields.io/badge/Project-Stream-blue)
![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)

**A Student Collaboration Platform for Sharing Educational Resources**

*5th Semester Web Programming Project - BS Computer Science*

[Features](#features) • [Installation](#installation) • [Usage](#usage) • [Technologies](#technologies) • [Screenshots](#screenshots)

</div>

---

## 📋 Table of Contents

- [About the Project](#about-the-project)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Project Structure](#project-structure)
- [Usage](#usage)
- [Security Features](#security-features)
- [Future Enhancements](#future-enhancements)
- [Contributing](#contributing)
- [Author](#author)
- [Acknowledgments](#acknowledgments)

---

## 🎓 About the Project

**Project Stream** is a web-based educational platform developed as a semester project for the 5th semester Web Programming course at the **University of Agriculture, PARS Campus, Faisalabad**. The platform addresses the challenge of efficient resource sharing among students by providing a centralized system for uploading, viewing, and managing educational materials.

### Background

In academic settings, students often struggle with accessing and sharing lecture notes, study materials, and resources efficiently. Traditional methods like email attachments or physical copies are cumbersome and prone to loss. Project Stream solves this by offering a secure, user-friendly web portal where students can:

- Register and manage their profiles
- Upload and share study materials
- Access shared documents from peers
- Manage their personal uploads with full CRUD operations

### Project Information

- **Course**: Web Programming
- **Semester**: 5th (Morning Section)
- **Session**: 2025-2026
- **Institution**: University of Agriculture, PARS Campus, Faisalabad
- **Date**: December 24, 2025

---

## ✨ Features

### 🔐 User Authentication
- **Secure Registration** - Create account with username, email, password, bio, and address
- **Login System** - Session-based authentication with security checks
- **Password Management** - Reset password through dashboard
- **Logout** - Secure session termination

### 📁 Document Management
- **Upload Posts** - Share lecture notes with title, description, and file attachments
- **Supported File Types**: 
  - Documents: PDF, DOCX, TXT, CPP
  - Archives: RAR, ZIP
  - Spreadsheets: XLSX
  - Images: JPG, PNG, GIF
- **View All Documents** - Browse all shared resources with visual file type icons
- **Personal Management** - Edit and delete your own uploads
- **File Size Limit** - Up to 10MB per file

### 👤 User Dashboard
- **Profile Customization**
  - Upload/change profile picture
  - Update email address
  - Edit bio and personal information
  - Modify contact details and address
- **Personal Statistics** - View your uploaded files count
- **Account Management** - Comprehensive profile control panel

### 🎨 User Interface
- **Clean & Intuitive Design** - Custom CSS with image-based themes
- **Responsive Navigation** - Consistent header and footer across pages
- **Visual File Icons** - Easy identification of file types
- **Interactive Forms** - Client-side validation with JavaScript/jQuery

---

## 🛠️ Technologies Used

### Backend
- **PHP 7.4+** - Server-side scripting and business logic
- **MySQL 5.7+** - Relational database management
- **phpMyAdmin** - Database administration interface

### Frontend
- **HTML5** - Semantic page structure
- **CSS3** - Custom styling and responsive design
- **JavaScript** - Client-side interactivity
- **jQuery 1.9.1** - DOM manipulation and AJAX

### Development Environment
- **XAMPP** - Local development server (Apache + MySQL + PHP)
- **Apache Server** - Web server
- **VSCode** - Code editor (recommended)

### Architecture
- **MVC Pattern** - Separation of concerns
- **Session Management** - Secure user state handling
- **PDO/MySQLi** - Database abstraction layer
- **File System** - Organized directory structure

---

## 💻 System Requirements

### Server Requirements
- **XAMPP** (or equivalent LAMP/WAMP stack)
- **PHP** version 7.4 or higher
- **MySQL** version 5.7 or higher
- **Apache** web server
- **Minimum 100MB** disk space

### Client Requirements
- **Modern Web Browser**
  - Google Chrome (recommended)
  - Mozilla Firefox
  - Microsoft Edge
  - Safari
- **JavaScript enabled**
- **Cookies enabled**

---

## 🚀 Installation

Follow these steps to set up Project Stream on your local machine:

### Step 1: Clone the Repository

```bash
# Clone this repository
git clone https://github.com/YOUR-USERNAME/project-stream.git

# Navigate to the project directory
cd project-stream
```

### Step 2: Move to XAMPP Directory

```bash
# Copy the project to xampp/htdocs folder
# Windows:
C:\xampp\htdocs\project-stream

# Linux:
/opt/lampp/htdocs/project-stream

# macOS:
/Applications/XAMPP/htdocs/project-stream
```

### Step 3: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Start **Apache** server
3. Start **MySQL** server

### Step 4: Create Required Directories

Create these directories if they don't exist:

```
project-stream/
├── members/          (for user profile pictures)
└── posts/
    └── files/        (for uploaded documents)
```

---

## 🗄️ Database Setup

### Option 1: Using phpMyAdmin (Recommended)

1. Open your browser and navigate to: `http://localhost/phpmyadmin`
2. Click **"New"** to create a new database
3. Name it: `project_stream` (or your preferred name)
4. Set collation to: `utf8mb4_unicode_ci`
5. Click **"Import"** tab
6. Choose the file: `database/database.sql` from the project folder
7. Click **"Go"** to import

### Option 2: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE project_stream;

# Use the database
USE project_stream;

# Import the SQL file
SOURCE path/to/project-stream/database/database.sql;

# Exit
exit;
```

### Database Tables

The database includes three main tables:

1. **tblmembers** - Stores user account information
   - memberid (Primary Key)
   - memberfirstname, memberlastname
   - memberusername, memberemail
   - memberpassword (hashed)
   - memberphone, memberaddress
   - memberpicture, memberbio

2. **tblfiles** - Stores uploaded file information
   - fileid (Primary Key)
   - filename, filepath
   - userid (Foreign Key)
   - uploaddate

3. **tblposts** - Stores post/document details
   - postid (Primary Key)
   - posttitle, postdescription
   - userid (Foreign Key)
   - created_at

---

## 📂 Project Structure

```
project-stream/
│
├── database/
│   └── database.sql              # Database schema and structure
│
├── includes/
│   ├── config.php                # Configuration settings (create from config-sample.php)
│   ├── connect.php               # Database connection
│   ├── header.php                # Common header
│   ├── footer.php                # Common footer
│   ├── chk-session.php          # Session validation
│   ├── top-member.php           # Member navigation
│   └── upload-picture.php       # Picture upload handler
│
├── members/
│   └── {username}/              # User-specific folders for profile pictures
│
├── posts/
│   └── files/                   # Uploaded documents storage
│
├── images/
│   ├── files-icons/             # File type icons
│   └── Background-Screen1.jpg   # UI backgrounds
│
├── index.php                    # Login page
├── register.php                 # Registration page
├── front.php                    # Main dashboard after login
├── dashboard.php                # User profile management
├── files.php                    # View all uploaded files
├── sign-out.php                 # Logout handler
├── signin.css                   # Authentication styling
│
├── .gitignore                   # Git ignore rules
└── README.md                    # This file
```

---

## 🎯 Usage

### 1. Access the Application

Open your web browser and navigate to:
```
http://localhost/project-stream
```

### 2. Register a New Account

1. Click on **"Register Free"** link
2. Fill in the registration form:
   - First Name
   - Last Name
   - Email Address
   - Password
   - Confirm Password
3. Click **"Register"** button
4. You'll be automatically logged in

### 3. Login

1. Enter your email address
2. Enter your password
3. Click **"Login"** button

### 4. Upload Documents

1. After login, navigate to **Upload Post** section
2. Enter post title and description
3. Choose a file (PDF, DOCX, TXT, etc.)
4. Click **"Upload"**

### 5. View Shared Documents

1. Go to **"All Files"** section
2. Browse all uploaded documents
3. Click **"Download"** to access any file
4. View file type through visual icons

### 6. Manage Your Profile

1. Click on **"Dashboard"**
2. Available options:
   - **Basic Information** - Update name, phone, address, bio
   - **Update Picture** - Upload profile photo
   - **Reset Password** - Change your password
   - **Change Email** - Update email address
   - **Files Uploaded By You** - View your uploads

### 7. Manage Your Posts

1. Navigate to **"My Posts"**
2. Edit or delete your uploaded documents
3. View statistics of your contributions

---

## 🔒 Security Features

### Authentication & Authorization
- ✅ **Session Management** - Secure user sessions with `chk-session.php`
- ✅ **Password Hashing** - Passwords stored securely (Note: Current version needs upgrade to `password_hash()`)
- ✅ **Login Validation** - Server-side credential verification

### Data Protection
- ✅ **SQL Injection Prevention** - Using `real_escape_string()` and prepared statements
- ✅ **XSS Protection** - HTML special characters sanitization
- ✅ **File Upload Validation** - MIME type checking and file extension verification

### Access Control
- ✅ **Protected Pages** - Session checks on all authenticated pages
- ✅ **User Isolation** - Users can only edit/delete their own content
- ✅ **Directory Permissions** - Proper folder permissions for uploads

### Recommended Security Improvements

⚠️ **Important Security Notes:**

The current version has some security aspects that should be improved before production deployment:

1. **Upgrade Password Storage** - Implement `password_hash()` and `password_verify()`
2. **Use Prepared Statements** - Replace all direct SQL queries with PDO prepared statements
3. **Add CSRF Protection** - Implement tokens for forms
4. **Enhance File Validation** - Add more robust file type checking
5. **SSL/HTTPS** - Use encrypted connections in production

---

## 🔮 Future Enhancements

### Planned Features
- [ ] **Search & Filter** - Search documents by title, type, or author
- [ ] **Categories/Tags** - Organize documents by subject/topic
- [ ] **Notifications** - Email alerts for new uploads
- [ ] **Admin Panel** - Moderate content and manage users
- [ ] **Download Statistics** - Track file downloads
- [ ] **Comments Section** - Discussion on shared documents
- [ ] **Rating System** - Rate quality of shared materials

### Technical Improvements
- [ ] **Cloud Deployment** - Deploy on Heroku, AWS, or DigitalOcean
- [ ] **Mobile Responsiveness** - Optimize for mobile devices
- [ ] **RESTful API** - Enable mobile app integration
- [ ] **Real-time Updates** - WebSocket for live notifications
- [ ] **CDN Integration** - Faster file delivery
- [ ] **Two-Factor Authentication** - Enhanced security

### UI/UX Enhancements
- [ ] **Modern Framework** - Migrate to Bootstrap or Tailwind CSS
- [ ] **Dark Mode** - Theme switching option
- [ ] **Drag & Drop Upload** - Improved file upload experience
- [ ] **Progress Bars** - Visual upload progress
- [ ] **Advanced Dashboard** - Analytics and insights

---

## 🤝 Contributing

This is an academic project, but contributions and suggestions are welcome!

### How to Contribute

1. **Fork the Repository**
   ```bash
   git clone https://github.com/YOUR-USERNAME/project-stream.git
   ```

2. **Create a Feature Branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```

3. **Commit Your Changes**
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```

4. **Push to the Branch**
   ```bash
   git push origin feature/AmazingFeature
   ```

5. **Open a Pull Request**

### Contribution Guidelines
- Follow the existing code style
- Add comments for complex logic
- Test thoroughly before submitting
- Update documentation as needed

---

## 👨‍💻 Author

**Muhammad Zain-ul-Abidin**
- **Registration Number**: 2023-ag-8037
- **Program**: BS Computer Science (BSCS)
- **Semester**: 5th Morning Section
- **Session**: 2025-2026
- **Institution**: University of Agriculture, PARS Campus, Faisalabad

### Connect with Me
- GitHub: [@YOUR-GITHUB-USERNAME](https://github.com/YOUR-GITHUB-USERNAME)
- LinkedIn: [Your LinkedIn Profile](https://linkedin.com/in/your-profile)
- Email: your.email@example.com

---

## 🙏 Acknowledgments

Special thanks to:

- **University of Agriculture, Faisalabad** - For providing the educational environment
- **Department of Computer Science** - For guidance and support
- **Web Programming Course Instructor** - For valuable feedback and mentorship
- **Classmates** - For testing and suggestions
- **Open Source Community** - For excellent documentation and resources

### Resources & References

- [PHP Official Documentation](https://www.php.net/manual/en/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [jQuery API Documentation](https://api.jquery.com/)
- [XAMPP Installation Guide](https://www.apachefriends.org/)
- [W3Schools Web Tutorials](https://www.w3schools.com/)

---

## 📄 License

This project is created for educational purposes as part of the BS Computer Science curriculum at the University of Agriculture, Faisalabad.

```
MIT License

Copyright (c) 2025 Muhammad Zain-ul-Abidin

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 📞 Support

If you encounter any issues or have questions:

1. **Check Documentation** - Review this README thoroughly
2. **Check Issues** - Browse existing GitHub issues
3. **Create New Issue** - Submit a detailed bug report or feature request
4. **Contact Author** - Reach out via email for academic queries

---

## 📊 Project Status

- ✅ **Phase 1**: Core Features - COMPLETED
- ✅ **Phase 2**: User Authentication - COMPLETED
- ✅ **Phase 3**: File Management - COMPLETED
- ✅ **Phase 4**: Dashboard - COMPLETED
- 🔄 **Phase 5**: Security Enhancements - IN PROGRESS
- ⏳ **Phase 6**: Deployment - PLANNED

---

<div align="center">

### ⭐ Star this repository if you found it helpful!

**Made with ❤️ for the Student Community**

*Project Stream - Connecting Students Through Knowledge Sharing*

![University Logo](https://img.shields.io/badge/UAF-PARS%20Campus-green)
![Academic Year](https://img.shields.io/badge/Academic%20Year-2025--2026-blue)
![Semester](https://img.shields.io/badge/Semester-5th-orange)

</div>

---

**Last Updated**: February 2026  
**Version**: 1.0.0  
**Status**: Active Development
