# Career Quest

![HTML](https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white)

## Overview

**Career Quest** is a web application designed to provide a comprehensive platform for job seekers and employers. With features such as user authentication, job posting, application management, and administrative controls, it facilitates efficient job searching and recruitment processes.

### Key Features

- **User Authentication**:
  - Login and Logout for job seekers, employers, and administrators.
  
- **Role-based Access**:
  - Job Seeker: Can search and apply for jobs.
  - Employer: Can post jobs and review applications.
  - Admin: Can manage user accounts and oversee job postings.

- **Job Posting and Management**:
  - Employers can create, update, and delete job posts.

- **Application Management**:
  - Job seekers can apply for jobs.
  - Employers can review, accept, or reject applications.

## Installation Guide

### Prerequisites
- **XAMPP**: Download and install XAMPP from [Apache Friends](https://www.apachefriends.org/download.html).

### Steps to Set Up the Project

1. **Install XAMPP**:
   - Follow the installation instructions provided on the XAMPP website to set up Apache and MariaDB (MySQL).

2. **Set Up the Project in `htdocs`**:
   - Download or clone this project repository to your local machine.
   - Copy the entire project folder to the `htdocs` directory inside your XAMPP installation folder (e.g., `C:\xampp\htdocs\CareerQuest`).

3. **Start Apache and MySQL**:
   - Open the XAMPP Control Panel.
   - Start the Apache and MySQL services.

4. **Database Setup**:
   - Open your web browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - Create a new database named `career_quest`.
   - Import the provided SQL file (if available) into this database to set up the required tables. 
     - To do this, click on your `career_quest` database, go to the "Import" tab, and select the SQL file to upload.

5. **Database Configuration in the Project**:
   - Open the project folder in a code editor.
   - Go to the file where database credentials are configured (e.g., `_dbconnect.php`).
   - Update the database connection details as needed:
     ```php
     $servername = "localhost";
     $username = "root"; // Default username in XAMPP
     $password = "";     // Default password in XAMPP is empty
     $dbname = "career_quest"; // Your database name
     ```

### Running the Project

1. Open a web browser and go to [http://localhost/CareerQuest](http://localhost/CareerQuest) to access the application.
2. Follow the on-screen prompts to interact with the application:
   - Sign up or log in as a job seeker, employer, or administrator.
   - Explore the available functionalities such as job posting, job applications, and profile management.

## Screenshots

<img src="./screenshots/1.png" width="60%" /> <br>
<img src="./screenshots/2.png" width="60%" /> <br>
<img src="./screenshots/3.png" width="60%" /> <br>

<!-- ## Contributors -->

<!-- - [Pakshal Mahavir Ranawat](https://ranawatpakshal.co.in/)
  - [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/pakshal-ranawat/)
  - [![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/PAKSHAL31)

--- -->