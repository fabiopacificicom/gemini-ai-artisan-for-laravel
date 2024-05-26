<?php

namespace PacificDev\TerminalAssistant\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class AskHelp extends Command
{


  /** 
   * Signature
   * @var string
   */

  protected $signature = 'pacificdev:ask 
                          {--table=: Pass a table name to get help with it (optional)}
                          {--model=gemini: Pass a model to use [gemini, gpt] (optional)}
                          ';

  protected $description = "Ask help on your code with AI";

  /**
   * Run the command logic here
   */
  public function handle()
  {
    $this->info('You should only ask for support not for the solution, be wise - learn.');

    // get the question from the student
    $question = htmlspecialchars($this->ask('How can i help you today?'));
    //dd($question);

    // submit the request to a model

    if (Str::startsWith($this->option('model'), 'gemini')) {

      // gather specific app context
      $db_details = $this->getArtisanDatabaseShow();
      $about = $this->getArtisanAboutOutput();
      if ($this->option('table')) {
        $table_details = $this->getArtisanTableData($this->option('table'));
      }
      $logs = $this->extractLogFileData();
      // sumbit the request
      $this->askGemini("Application data: $about - Database: $db_details $table_details - Log file: $logs - Question: $question");
    }
  }

  /**
   * Define command's shedule
   * */

  function schedule(Schedule $schedule): void
  {
    // runs the command every minute?
    // $schedule->command(static::class)->everyMinute();
  }



  private function askGemini($question)
  {
    $this->info('Asking to Gemini...');

    $response = Http::withHeaders([
      'Content-Type' => 'application/json'
    ])->post(config('terminal-assistant.services.endpoint') . '?key=' . config('terminal-assistant.services.token'), [
      'contents' => [
        [
          'parts' => [
            ['text' => "You are PacificDev's ai-powered command line assistant. Your main task is to help the developer currently working on a Laravel Application. You will be provided with the application details and database information. Support the user with its enquiries at the best of your knowledge." . $question]
          ]
        ]
      ]
    ]);


    $response->onError(function ($error) {
      //dd($this->error($error));
      [$code, $message, $status] = json_decode($error, true);

      $this->error("ERROR! Status: $status Message: $message Code: $code");
      exit;
    });
    $this->info('Typing...');
    // provide the answer
    $answer = json_decode($response->body(), true);
    //dd($answer);
    // extract the response parts
    $parts = $answer['candidates'][0]['content']['parts'];
    // show a progress bar
    $bar = $this->output->createProgressBar(count($parts));
    // loop over each part and print their text
    foreach ($parts as $part) {
      $this->line($part['text']);
      $bar->advance();
    }
    $bar->finish();
  }

  /* Gathering context from the application */


  private function extractLogFileData()
  {
    $file = file_get_contents(storage_path('logs/laravel.log'));
    //dd($file);
    if (strlen($file) >= 50000) {
      $this->error('please reduce the size of the log file, max 2000 characters');
      exit;
    }
    return $file;
  }


  private function getArtisanTableData($table = null)
  {
    if (!$table) {
      return '';
    }
    // Call the 'about' Artisan command
    \Artisan::call('db:table', ['--no-ansi' => true, 'table' => $table]);

    // Get the output of the last command
    $output = \Artisan::output();

    return $output;
  }


  private function getArtisanDatabaseShow()
  {
    // Call the 'about' Artisan command
    \Artisan::call('db:show', ['--no-ansi' => true]);

    // Get the output of the last command
    $output = \Artisan::output();

    return $output;
  }



  private function getArtisanAboutOutput()
  {
    // Call the 'about' Artisan command
    \Artisan::call('about', ['--no-ansi' => true]);

    // Get the output of the last command
    $output = \Artisan::output();

    return $output;
  }
}
