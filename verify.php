<?php
// Include User class.
include 'inc/user.php';
 
$user = new User();
 
// set access code
$access_code = isset( $_GET['access_code'] ) ? $_GET['access_code'] : "";

$user->access_code_exists( $access_code );

// If access code exists.
if( !$user->access_code_exists( $access_code ) ) {
  
  die( "ERROR: Access code not found." );

} else {

  // Update status.
  $verified_status = 1;
  $user->update_status_by_access_code( $verified_status, $access_code );
    
  // And the redirect to the login page.
  header( "location: login?action=email_verified" );

}
?>