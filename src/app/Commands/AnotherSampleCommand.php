<?php

namespace PacificDev\TerminalAssistant\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class AnotherSampleCommand extends Command
{


  /** 
   * Signature
   * @var string
   */

  protected $signature = 'pacificdev:another_command 
                          {first: this is the value (required)}
                          {another-one: this is a required value (required)}
                          {--another-optional: is this required? nope (optional) }
                          ';

  protected $description = "template package for laravel commands";

  /**
   * Run the command logic here
   */
  public function handle()
  {
    $this->info('Write a nice package');
  }

  /**
   * Define command's shedule
   * */

  function schedule(Schedule $schedule): void
  {
    // runs the command every minute?
    // $schedule->command(static::class)->everyMinute();
  }
}
