<?php
/**
 * Include header.
 */
include 'template-parts/header.php';
 
$user = new User();
 
// Get access code.
$access_code = isset( $_GET['access_code'] ) ? $_GET['access_code'] : "";

if ( isset ( $_POST['submit'] ) ) {
  
  $password = $_POST['password'];

  // Reset password.
  if( $user->update_password( $password, $access_code ) ) {

    echo "<div class='alert alert-info'>Password was reset. Please <a href='/login'>login.</a></div>";

  } else {

    echo "<div class='alert alert-danger'>Unable to reset password.</div>";

  }

}

if( ! $user->access_code_exists( $access_code ) ) {
  
  die('Access code not found.');

} else {
  ?>
  <div class="container mt-3">
    <h1 class="text-center">Reset password</h1>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form method="post">
          <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Your password" required>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
  <?php
}

/**
 * Include footer
 */
include 'template-parts/footer.php';
?>
