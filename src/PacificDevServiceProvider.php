<?php

namespace PacificDev\TerminalAssistant;

use Illuminate\Support\ServiceProvider;


use PacificDev\TerminalAssistant\Commands\AskHelp;
//use PacificDev\TerminalAssistant\Commands\AnotherSampleCommand;

class PacificDevServiceProvider extends ServiceProvider
{


  function register()
  {
    $this->mergeConfigFrom(
      __DIR__ . '/config/terminal-assistant.php',
      'terminal-assistant'
    );
  }
  function boot()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        AskHelp::class,
      ]);
    }
  }
}
