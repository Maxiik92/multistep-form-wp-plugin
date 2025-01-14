<?php
require_once plugin_dir_path(__FILE__) . '../mailer.php';

if (!defined('ABSPATH')) {
  exit;
}

function render_multistep_form()
{
  $steps = get_option('multistep_form_steps', 3);

  // importovat samostatne polia formulara
  include plugin_dir_path(__FILE__) . 'form-fields.php';

  $inputsPerStep = ceil(count($inputs) / $steps);
  ob_start();
  include plugin_dir_path(__FILE__) . '../templates/multistep-form.php';
  return ob_get_clean();
}

// zadefinovanie shortkodu multistep_form
add_shortcode('multistep_form', 'render_multistep_form');

add_action('wp_ajax_submit_multistep_form', 'handle_multistep_form_submission');
add_action('wp_ajax_nopriv_submit_multistep_form', 'handle_multistep_form_submission');

function handle_multistep_form_submission()
{
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    wp_send_json_error([
      'message' => 'Invalid request method.'
    ]);
  }

  $logger = Logger::getInstance();
  $formData = collectFormData();
  $errorFields = validateFormData($formData);

  if (!empty($errorFields)) {
    //posielame zoznam chybnych fieldov nemalo by byt ale nic lebo sa to validuje aj v browseri
    //no v pripade ze sa form submitne cez napr postmana
    wp_send_json_error([
      'message' => 'Fix input fields that are not valid: ' . implode($errorFields),
      'error_fields' => $errorFields,
    ]);
  }
  try {
    sendEmail($formData);
    $logger->success("Email successfully sent to: " . get_option('multistep_form_email'));
    wp_send_json_success(['message' => 'Form submitted successfully!']);
  } catch (Exception $error) {
    $logger->error($error->getMessage());
    wp_send_json_error([
      'message' => 'Error: ' . $error->getMessage()
    ]);
  }
}

function collectFormData()
{
  return [
    'name' => sanitize_text_field($_POST['name'] ?? ''),
    'email' => sanitize_email($_POST['email'] ?? ''),
    'country' => sanitize_text_field($_POST['country'] ?? ''),
    'phone_number' => sanitize_text_field($_POST['phone_number'] ?? ''),
    'company' => sanitize_text_field($_POST['company'] ?? ''),
    'address' => sanitize_textarea_field($_POST['address'] ?? ''),
    'postal_code' => sanitize_text_field($_POST['postal_code'] ?? ''),
    'age' => intval($_POST['age'] ?? 0),
    'music_genre' => sanitize_text_field($_POST['music_genre'] ?? ''),
    'form_rank' => intval($_POST['form_rank'] ?? 0),
  ];
}

function validateFormData(array $formData)
{
  $errorFields = [];
  foreach ($formData as $item => $value) {
    switch ($item) {
      case 'name':
      case 'country':
      case 'company':
      case 'address':
      case 'music_genre':
        if ($value === '') {
          $errorFields[] = $item;
        }
        break;
      case 'email':
        if ($value === '' || !is_email($value)) {
          $errorFields[] = $item;
        }
        break;
      case 'phone_number':
        if ($value === '' || !preg_match('/^\+?[1-9]\d{1,14}$/', $value)) {
          $errorFields[] = $item;
        }
        break;
      case 'postal_code':
      case 'age':
      case 'form_rank':
        if (!is_numeric($value)) {
          $errorFields[] = $item;
        }
        break;
      default:
        $errorFields[] = $item;
    }
  }
  return $errorFields;
}

function sendEmail(array $formData)
{
  $to = get_option('multistep_form_email');
  $logger = Logger::getInstance();

  if (!$to) {
    $message = 'Email address not set in the form settings.';
    $logger->error($message);
    wp_send_json_error([
      'message' => $message
    ]);
  }
  //zadefinuj nastavenia maileru
  //path je z priecinka includes
  $path = 'templates/multistep-form-mail-template.php';
  $mailer = new Mailer($path);
  $mailer->setSubject('New Form Submission');
  $mailer->setRecipient($to);

  if (isset($formData['music_genre'])) {
    $formData['music_genre'] = toReadableValue('music_genre', $formData);
  }
  $response = $mailer->send($formData);

  if ($response) {
    $logger->success('Email sent successfully with data :' . json_encode($formData));
    wp_send_json_success(['message' => 'Form submitted successfully!']);
  } else {
    $logger->error('failed to send email with data : ' . json_encode($formData));
    wp_send_json_error([
      'message' => 'Email could not be sent.'
    ]);
  }
}

function toReadableValue(string $key, array $formData)
{
  $readableMusicGenre = [
    "metal" => 'Metal',
    "blues" => "Blues",
    "pop" => "Pop",
    "electronic" => "Electronic",
    "hip-hop" => "Hip-Hop",
    "disco" => "Disco",
    "country" => "Country",
  ];
  return match ($key) {
    'music_genre' => $readableMusicGenre[$formData['music_genre']] ?? $formData['music_genre'],
    default => 'genre not defined',
  };
}