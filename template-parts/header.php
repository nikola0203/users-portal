<?php
/**
 * Header template
 */
session_start();

define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/' );

// Include User class.
include ABSPATH . 'inc/utility.php';
include ABSPATH . 'inc/user.php';

$user = new User();

if ( isset( $_GET['q'] ) ) {
  $user->logout();
  header( "location:login" );
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../dist/css/style.min.css">
  <title>Users Portal</title>
</head>

<header>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="/">Users Portal</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <?php if ( ! $user->is_user_logged_in() ) : ?>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <?php endif; ?>
          <?php if ( $user->is_user_logged_in() ) : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="<?php echo $user->get_profile_image_path(); ?>" class="rounded-circle menu-user-icon" alt="">
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="/profile">Profile</a>
              <a class="dropdown-item" href="?q=logout">Logout</a>
            </div>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

<body>

<div class="site-body">