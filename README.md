# Taskline

A focused personal task manager built with Laravel, SQLite, Blade, and Vite.

## Project Purpose

Taskline helps users organize daily work by creating tasks, reviewing their current list, updating task details, deleting finished or unnecessary tasks, and marking tasks as pending or completed.

## Project Information

- Project Code: WST21-PM-2026-SF
- Student Name: Jeff Petallana
- Course & Year: BSIT-2
- Database Used: SQLite

## Features

- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status

## Run locally

```bash
composer install
npm install
php artisan migrate
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000`. The dashboard supports adding, editing, deleting, and toggling tasks between pending and completed.