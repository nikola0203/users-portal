<?php
/**
 * Login template
 */

 /**
 * Include header
 */
include '../template-parts/header.php';

?>

<h1 class="text-center">Admin login</h1>

<?php

$user = new User();

if ( isset ( $_POST['submit'] ) ) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $login = $user->login( $username, $password );
  if ( $login ) {
    // Login success.
    header( "location:profile" );
  } else {
    // Login failed.
    ?>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="alert alert-danger">Wrong username or password.</div>
        </div>
      </div>
    </div>
    <?php
  }
}
?>

<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <form method="post">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</div>

<?php
/**
 * Include footer
 */
include '../template-parts/footer.php';
?>
