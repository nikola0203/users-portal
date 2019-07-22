<?php
/**
 * Register template
 */

/**
 * Include header
 */
include 'template-parts/header.php';

$user = new User();
$utility = new Utility();

if ( isset ( $_POST['submit'] ) ) {
  $firstName = $_POST['first-name'];
  $lastName  = $_POST['last-name'];
  $username  = $_POST['username'];
  $password  = $_POST['password'];
  $email     = $_POST['email'];
  // Access code for email verification.
  $access_code = $utility->get_token();
  
  $registerUser = $user->register( $firstName, $lastName, $username, $password, $email, $access_code );

  if ( $registerUser ) {

    // Send confimation email.
    $body = "Thank you {$username} for registering to our portal!.<br /><br />";
    $body .= "Please click the following link to verify your email and login: <a href='http://usersportal.test/verify?access_code={$access_code}'>VERIFY</a> ";

    $subject = "Verification Email";

    $utility->send_email_php_mailer( $email, $subject, $body );

    // Registration success.
    // echo "<div class='text-center'>Registration successful <a href='/login'>Click here</a> to login</div>";

  } else {

    // Registration failed.
    echo "<div class='text-center'>Registration failed. Email or Username already exits please try again.</div>";
    
  }
}

?>

<div class="container mt-3">
  <h1 class="text-center">REGISTER</h1>
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <form action="" method="post">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="first-name">First Name</label>
            <input type="text" class="form-control" name="first-name" id="first-name" placeholder="First Name">
          </div>
          <div class="form-group col-md-6">
            <label for="last-name">Last Name</label>
            <input type="text" class="form-control" name="last-name" id="last-name" placeholder="Last Name">
          </div>
        </div>
        <div class="form-group">
          <label for="Username">Username</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        </div>
        <div class="form-group">
          <label for="Password">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="Email">Email</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Email">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
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
