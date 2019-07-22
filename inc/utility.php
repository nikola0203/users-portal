<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require ABSPATH . 'vendor/autoload.php';

class Utility {

  /**
   * 
   * Generate a unique string of characters for the access code
   * 
   * @param int $length.
   * 
   */
  public function get_token( $length = 32 ) {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    for ( $i = 0; $i < $length; $i++ ) {
      $token .= $codeAlphabet[ $this->crypto_rand_secure( 0, strlen( $codeAlphabet ) ) ];
    }
    return $token;
  }


  /**
   * 
   * Create a random number between $min and $max.
   * 
   * @param int $min
   * @param int $max
   * 
   */
  public function crypto_rand_secure( $min, $max ) {
    $range = $max - $min;
    if ( $range < 0 )
      return $min;
    $log = log( $range, 2 );
    $bytes = (int) ( $log / 8 ) + 1;
    $bits = (int) $log + 1;
    $filter = (int) ( 1 << $bits ) - 1;
    do {
      $rnd = hexdec( bin2hex( openssl_random_pseudo_bytes ( $bytes ) ) );
      $rnd = $rnd & $filter;
    } while ( $rnd >= $range );
    return $min + $rnd;
  }

  /**
   * 
   * Send emal using PHP Mailer.
   * 
   * @param string $send_to_email
   * @param string $subject
   * @param string $body
   * 
   */
  public function send_email_php_mailer( $send_to_email, $subject, $body ) {

    $mail = new PHPMailer(true);

    // Server settings.
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host       = 'smtp.mailtrap.io';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                // Enable SMTP authentication
    $mail->Username   = '93af8d8520a181';    // SMTP username
    $mail->Password   = '30467fd89ace58';    // SMTP password
    $mail->SMTPSecure = 'tls';               // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 2525;                // TCP port to connect to

    // Recipients.
    $mail->setFrom('from@example.com', 'Mailer');
    // $mail->addAddress($send_to_email, 'Joe User'); // Add a recipient
    $mail->addAddress($send_to_email);               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;

    if( $mail->send() ) {

      echo "<div class='alert alert-success'>
        Verification link was sent to your email. Click that link to login.
      </div>";

    } else {

      echo "<div class='alert alert-danger'>
        User was created but unable to send verification email. Please contact admin.
      </div>";

    }

  }

}

?>
