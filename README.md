# Gemini AI Artisan for Laravel 11

Use AI to ask support about your laravel application without leaving the command line. 

This is what happens when you ask a question about your app using the `pacificdev:ask` command:
- the selected LLM is provided with context from your laravel application, 
- the database structure is provided to the model
- application details as show by the about command are provided as context
- the laravel.log file is proivided as context by default ( limited to 50000 characters ) 
- a specific table structure can be provided when using `--table=table_name`

## Requirements

To use this package you need to:

- install laravel (any version from 9.x and up)
- add db credentials to your .env file
- insert in the .env file the GeminiPro AI API KEY [read more](https://ai.google.dev/gemini-api/docs/api-key)


## Installation

```bash
composer create-project laravel/laravel example-app
# After the db is connected, install the package by running
composer require pacificdev/terminal-assistant
```

### Google API for Gemini AI
Once you generated your api key from the google console, add this two lines to your .env file
```env
TERMINAL_ASSISTANT_TOKEN=your_api_key_here
TERMINAL_ASSISTANT_ENDPOINT=https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent

```

> replace your_api_key_here with the api key you generated in the google console


## Usage

After the installation is successful you can run the command below to send your question to the assistant. 


```bash
php artisan pacificdev:ask 
```

This package is intended to offer a single shot question/answer not a chat experience. Its purpose is not to develop your application but support you while you do so. 

**Available options**:

1. --table: provide a name of a table, the table structure context will be provided to Gemini to better support.
2. --model: this is set to gemini by default for now
3. --logs: The default yes, set to no to ignore your log file. (log file max 5000 characters)
