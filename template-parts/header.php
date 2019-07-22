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

// $userID = $_SESSION['id'];

if ( isset( $_GET['q'] ) ) {
  $user->logout();
  header( "location:login" );
}

// if ( $_SESSION['login'] ) {
//   echo "USER IS LOGGED IN";
// }

// var_dump($_SESSION);

// echo "<pre>";
// $userData = $user->get_user_data();
// print_r($userData['first_name']);
// echo "</pre>";

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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="/">Users Portal</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/register">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/profile">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?q=logout">Logout</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown link
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<body>