<?php
/**
 * Register template
 */

/**
 * Include header
 */
include 'template-parts/header.php';

?>

<h1 class="text-center">Register</h1>

<?php

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
  
  if ( empty ( $firstName ) || empty ( $lastName ) || empty ( $username ) || empty ( $password ) || empty ( $email ) ) {
    
    ?>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <?php if ( ! $firstName ) : ?>
            <div class="alert alert-danger">First name is required!</div>
          <?php endif; ?>
          <?php if ( ! $lastName ) : ?>
            <div class="alert alert-danger">Last name is required!</div>
          <?php endif; ?>
          <?php if ( ! $username ) : ?>
            <div class="alert alert-danger">Username is required!</div>
          <?php endif; ?>
          <?php if ( ! $password ) : ?>
            <div class="alert alert-danger">Password is required!</div>
          <?php endif; ?>
          <?php if ( ! $email ) : ?>
            <div class="alert alert-danger">Email is required!</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php

  } else {

    // Checking if the username or email is in the database.
    if ( $user->is_user_exist( $username, $email ) ) {
      
      ?>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="alert alert-danger">Username or Email already exist!</div>
          </div>
        </div>
      </div>
      <?php

    } else {

      $registerUser = $user->register( $firstName, $lastName, $username, $password, $email, $access_code );

      if ( $registerUser ) {
    
        // Send confimation email.
        $body = "Thank you {$username} for registering to our portal!.<br /><br />";
        $body .= "Please click the following link to verify your email and login: <a href='http://usersportal.test/verify?access_code={$access_code}'>http://usersportal.test/verify?access_code={$access_code}</a> ";
    
        $subject = "Verification Email";
    
        if ( $utility->send_email_php_mailer( $email, $subject, $body ) ) {
          
          ?>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-6">
                <div class="alert alert-success">Registration successful! <br> Verification link was sent to your email.</div>
              </div>
            </div>
          </div>
          <?php

          // Empty post variables
          unset($firstName);
          unset($lastName);
          unset($username);
          unset($password);
          unset($email);
          
        } else {
          
          ?>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-6">
                <div class="alert alert-danger">User was created but unable to send verification email.</div>
              </div>
            </div>
          </div>
          <?php

        }
    
      } else {

        ?>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6">
              <div class="alert alert-danger">Unable to create user.</div>
            </div>
          </div>
        </div>
        <?php

      }

    }

  }

}

?>

<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <form action="" method="post">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="first-name">First Name</label>
            <input type="text" value="<?php echo ( $firstName ) ? $firstName : "" ?>" class="form-control" name="first-name" id="first-name" placeholder="First Name">
          </div>
          <div class="form-group col-md-6">
            <label for="last-name">Last Name</label>
            <input type="text" value="<?php echo ( $lastName ) ? $lastName : "" ?>" class="form-control" name="last-name" id="last-name" placeholder="Last Name">
          </div>
        </div>
        <div class="form-group">
          <label for="Username">Username</label>
          <input type="text" value="<?php echo ( $username ) ? $username : "" ?>" class="form-control" name="username" id="username" placeholder="Username">
        </div>
        <div class="form-group">
          <label for="Password">Password</label>
          <input type="password" value="<?php echo ( $password ) ? $password : "" ?>" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="Email">Email</label>
          <input type="email" value="<?php echo ( $email ) ? $email : "" ?>" class="form-control" name="email" id="email" placeholder="Email">
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
