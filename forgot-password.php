<?php
/**
 * Login template
 */

/**
 * Include header
 */
include 'template-parts/header.php';

$user = new User();
$utility = new Utility();

if ( isset ( $_POST['submit'] ) ) {

  $email = $_POST['email'];

  if( $user->email_exists( $email ) ) {

    // Update access code.
    $access_code = $utility->get_token();

    if( $user->update_access_code( $access_code, $email ) ) {

      // Send reset link.
      $body = "Hi there.<br /><br />";
      $body .= "Please click the following link to reset your password: <a href='http://usersportal.test/reset-password?access_code={$access_code}'>RESET PASSWORD LINK</a>";
      
      $subject = "Reset Password";
      
      $send_to_email = $_POST['email'];

      $utility->send_email_php_mailer( $send_to_email, $subject, $body );

    } else {
      
      echo "<div class='alert alert-danger'>ERROR: Unable to update access code.</div>";

    }

  } else {
    echo "<div class='alert alert-danger'>Your email cannot be found.</div>";
  }

}

?>

<div class="container mt-3">
  <h1 class="text-center">FORGOT PASSORD</h1>
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <form method="post">
        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Your email" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Send Reset Link</button>
      </form>
    </div>
  </div>
</div>

<?php
/**
 * Include footer
 */
include 'template-parts/footer.php';
?>
