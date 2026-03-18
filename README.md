CV Management System

A secure, full-stack web application built for managing and displaying professional CVs. This project was developed as part of the DG1IAD Web Development module at Aston University.

Live Demo URL: http://250379035.cs2410-web01pvm.aston.ac.uk/index.php

Technologies Used

    Backend: PHP 8.x (Vanilla)

    Database: MySQL (using PDO for secure transactions)

    Frontend: HTML5, CSS3

    Tools: VS Code, phpMyAdmin, Webmin/Virtualmin

Features
Public Features

    CV Directory: View a list of all registered users with their basic information.

    Search Functionality: Filter the directory by name or key programming language using SQL LIKE queries.

    Detailed View: Access a full CV profile, including education history and professional links.

    User Registration: Sign up to create a personalized professional profile.

Registered User Features

    Secure Login: Session-based authentication system.

    Professional Dashboard: A private area to input and update profile summaries, education details, and external links (GitHub/LinkedIn).

    Automatic Link Formatting: URLs in the links section are automatically converted into clickable hyperlinks using regex.

Security Measures

Security was a primary focus of this implementation. The following measures are included:

    SQL Injection Protection: All database interactions utilize PDO Prepared Statements.

    Password Hashing: Passwords are encrypted using the password_hash() BCRYPT algorithm.

    XSS Prevention: All user-generated content is sanitized using htmlspecialchars() before rendering.

    Authorization Checks: Sensitive pages (like the dashboard) are protected by session-based checks to prevent unauthorized access.

    Form Validation: Server-side validation ensures valid email formats and required field completion.

Project Structure

    index.php - The public landing page and search interface.

    view_cv.php - Displays detailed information for a specific CV.

    register.php - Handles new user account creation.

    login.php - Authenticates users and starts sessions.

    dashboard.php - Private user area for updating CV data.

    db.php - Centralized PDO database connection configuration.

    logout.php - Securely terminates user sessions.

    cvs.sql - Database schema and table structure.

Setup Instructions

    Database Setup:

        Create a new MySQL database (e.g., astoncv).

        Import the provided cvs.sql file to set up the cvs table.

    Configuration:

        Open db.php and update the database credentials ($host, $db, $user, $pass) to match your local or server environment.

    Deployment:

        Upload all files to your server's public_html directory.

        Access the application via index.php.
        
Note: For security reasons, database credentials are excluded. Please create a config file with your own credentials to run this locally.
