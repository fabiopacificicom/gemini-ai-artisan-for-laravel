# Gemini AI Artisan for Laravel

Install the package in your laravel application then run `artisan list` to find out the available commands.

## Requirements

To use this package you need to provide a google gemini AI API KEY in your .env file add

- Google API for Gemini AI

```env
TERMINAL_ASSISTANT_TOKEN=your_api_key_here
TERMINAL_ASSISTANT_ENDPOINT=https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent

```

## Installation

@TODO

## HOW TO USE

Example usage

```bash
php artisan pacificdev:ask 
```

This will prompt for a question.

**Available options**
--table: provide a name of a table, the table structure context will be provided to Gemini to better support.
--model: this is set to gemini by default for now
--logs: The default yes, set to no to ignore your log file. (log file max 5000 characters)
