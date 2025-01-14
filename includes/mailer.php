<?php

class Mailer
{
  private string $subject;
  private array $recipient;
  private array $headers;

  /**
   * @param string $path relativna cesta k templatu na vytvorenie emailu
   */
  public function __construct(private string $path)
  {
    $this->headers = [
      'Content-Type:text/html; charset=UTF-8',
      'From:wordpres@vigeozadanie.com'
    ];
  }

  /**
   * Zadefinuj subject emailu
   * @param string $subject
   * @return void
   */
  public function setSubject(string $subject)
  {
    $this->subject = $subject;
  }

  /**
   * Zadefinuj prijemcu e-mailu
   * @param string|array $recipient
   * @return void
   */
  public function setRecipient(string|array $recipient)
  {
    if (is_array($recipient)) {
      $this->recipient = array_merge($this->recipient, $recipient);
    } else {
      $this->recipient[] = $recipient;
    }
  }

  /**
   * Vytvor spravu z poskytnuteho templatu a premennych 
   * @param mixed $formData
   * @throws \Exception
   * @return bool|string
   */
  public function send(?array $formData = null): bool|string
  {
    if (empty($this->subject) || empty($this->recipient)) {
      throw new Exception('Subject or recipient not set.');
    }

    $message = $this->createMessage($formData);
    return wp_mail($this->recipient, $this->subject, $message, $this->headers);
  }

  private function createMessage(?array $formData = null): bool|string
  {
    $templatePath = plugin_dir_path(__FILE__) . $this->path;
    if (!file_exists($templatePath)) {
      throw new Exception("Email template file does not exist: $templatePath");
    }

    ob_start();
    include $templatePath;
    return ob_get_clean();
  }
}