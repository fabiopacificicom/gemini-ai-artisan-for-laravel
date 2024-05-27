# Gemini AI Artisan for Laravel 11

Install the package in your laravel application then run `artisan list` to find out the available commands.

## Requirements

To use this package you need to:

- establish db connection by editing your application .env file.
- create and provide a google gemini AI API KEY in your .env file

### Google API for Gemini AI

```env
TERMINAL_ASSISTANT_TOKEN=your_api_key_here
TERMINAL_ASSISTANT_ENDPOINT=https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent

```

## Installation

```bash
composer create-project laravel/laravel example-app
# After the db is connected, install the package by running
composer require pacificdev/terminal-assistant

```

## HOW TO USE

```bash
php artisan pacificdev:ask 
```

This will prompt for a question.

**Available options**:

1. --table: provide a name of a table, the table structure context will be provided to Gemini to better support.
2. --model: this is set to gemini by default for now
3. --logs: The default yes, set to no to ignore your log file. (log file max 5000 characters)
