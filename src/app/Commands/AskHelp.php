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
      $db_details = $this->getArtisanDatabaseShow();
      $about = $this->getArtisanAboutOutput();
      $this->askGemini("Application data: $about - Database: $db_details - Question: $question");
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



  private function askGemini($question)
  {
    $this->info('Asking to Gemini...');

    $response = Http::withHeaders([
      'Content-Type' => 'application/json'
    ])->post(config('terminal-assistant.services.endpoint') . '?key=' . config('terminal-assistant.services.token'), [
      'contents' => [
        [
          'parts' => [
            ['text' => $question]
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
}
