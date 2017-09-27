<h1 align="center">
YOYO-Industrial-Team-Project
</h1>

<p align="center">
<a href="https://travis-ci.org/jameshmread/YOYO-Industrial-Team-Project"><img src="https://travis-ci.org/jameshmread/YOYO-Industrial-Team-Project.svg?branch=master" alt="Build Status"></a>
<a href="https://www.codacy.com/app/j.h.m.read/YOYO-Industrial-Team-Project?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jameshmread/YOYO-Industrial-Team-Project&amp;utm_campaign=Badge_Grade"><img src="https://img.shields.io/codacy/grade/2ab4e59d38b24ebeab16992887a423ce.svg" alt="Codacy Status"></a>
</p>

## Requirements

PHP 7.0 and later  
Composer Package Manager  
NodeJS + npm  
MariaDB (or MySQL)

## Installation

1. Clone repository
1. Run `composer install`
1. Run `npm install`
1. Run `npm run dev`
1. Copy the `.env.example` to `.env` file, ensuring to put in your MariaDB details
1. Run `php artisan migrate`
1. Run `php artisan key:generate`
