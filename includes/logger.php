<?php


class Logger
{
  private string $logFile;
  private static $instance = null;

  public function __construct(string $logFile = null)
  {
    $this->logFile = $logFile ?? WP_CONTENT_DIR . '/debug.log';
  }

  public static function getInstance($logFile = null)
  {
    if (null === static::$instance) {
      static::$instance = new static($logFile);
    }
    return static::$instance;
  }

  private function log_event(string $message, string $type = "INFO")
  {
    //Ak nieje zapnute logovanie neloguj
    if (!WP_DEBUG) {
      return;
    }

    $timestamp = date('Y-m-d H:i:s');
    $formattedMessage = "[{$timestamp} [{$type}] : {$message}";

    if ($this->logFile) {
      file_put_contents($this->logFile, $formattedMessage, FILE_APPEND);
    } else {
      error_log($formattedMessage);
    }
  }

  public function error(string $message)
  {
    $this->log_event($message, 'ERROR');
  }

  public function info(string $message)
  {
    $this->log_event($message);
  }

  public function success(string $message)
  {
    $this->log_event($message, 'SUCCESS');
  }
}

