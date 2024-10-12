**User Registration System with Two-Factor Authentication**
**1.Description**

This repository contains a user registration and login 
system built with PHP, Bootstrap, and PHPMailer, 
incorporating two-factor authentication (2FA) using email-based OTP verification. 
After registering, users must verify their email by entering the OTP sent to their 
registered email address. Only verified users can log in and access the system.

**2.Features**
- User Registration with validation
- Login system with 2FA using OTP
- Email-based OTP verification via PHPMailer
- Bootstrap for styling and responsive design
- Database interactions using PDO
- Login protection with session management

**3.File Structure**
oop/

─ private/            # Contains the back-end logic
Database.php
User.php         # Handles user-related database operations
send-otp.php     # Sends OTP using PHPMailer

─ public/              # Contains front-end files
register.php     
login.php        
verify_otp.php  
index.php   

-src/
  -PHPMailer/
     -src/
     Exception.php
     PHPMailer.php
     SMTP.php

.gitignre
.gitattributes


