# SISTEM INFORMASI AKADEMIK (SIAKAD) POLITEKNIK PIKSI GANESHA INDONESIA

[![Academic Information System](https://siakad.politeknik-kebumen.ac.id/assets/img/siakad_polda_logo.png)](https://siakad.politeknik-kebumen.ac.id)

## Overview

The Academic Information System is a web-based application designed to simplify the management of academic data within an educational institution. This system supports various features to facilitate academic administration, class scheduling, grade management, and academic reporting.

## Features

### User Roles

The system supports four distinct user roles:

1. Admin
2. Dosen
3. Staff
4. Mahasiswa (Student)

### Role-specific Functionalities

#### 1. Admin

The Admin has full access to master data within the system. This includes the ability to manage and edit fundamental 
information that underlies the operational aspects of the system, such as user data, 
curriculum details, and other system settings.

#### 2. Dosen 

The Dosen has access to view and manage data related to courses (matkul) and student grades (nilai). 
This means lecturers can input, edit, and monitor the grades of students in the courses they teach, 
as well as manage information about those courses.

#### 3. Mahasiswa

Mahasiswa can access data related to themselves, including personal information as a student, 
details about the courses they are enrolled in, their grades, and class schedules. 
This allows students to track their academic progress and interact with information relevant to their studies.

#### 4. Staff 

Staff members have access related to payments. This includes managing student payment data, 
monitoring payment status, setting up billing, and generating financial reports related to payment 
administration at the educational institution.

## ERD

![erd siakad(normalized)]()

## Installation

1. Clone the repository:
```
git clone https://github.com/your-username/siakadppgi.git
cd siakadppgi.git
```
2. Install dependencies:
```
composer install
npm install
npm run dev
```
3. Set up the environment:

Copy the .env.example file to .env and update the necessary environment variables.
```
cp .env.example .env
php artisan key:generate
```
4. Run database migrations:
```
php artisan migrate
```
5. Seed the database:
```
php artisan db:seed
```
6. Start the development server:
```
php artisan serve
```

## Contributing

We welcome contributions to this project! Please follow these steps to contribute:

Fork the repository:

1. Click the "Fork" button at the top right corner of this page to create a copy of this repository under your GitHub account.

2. Clone your forked repository:
```
git clone https://github.com/your-username/siakadppgi.git
cd siakadppgi.git
```
3. Create a new branch:
```
git checkout -b feature/your-feature-name
```
4. Make your changes and commit them:
```
git add .
git commit -m "Add a detailed description of your changes"
```
5. Push to your forked repository:
```
git push origin feature/your-feature-name
```
6. Create a pull request:

Open your forked repository on GitHub, select the new branch you created, and click "New pull request." Provide a clear description of your changes.

## Contact
For any questions or concerns, please contact the project maintainers at:
masdzukyarrouf16@gmail.com