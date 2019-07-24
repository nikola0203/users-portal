<?php
/**
 * Main template
 */

/**
 * Include header
 */
include 'template-parts/header.php';

$user = new User();

?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <h1>All profiles</h1>
      <div class="profiles-wrapper">
        <ul class="list-unstyled">
          <?php
          $users_data = $user->get_users();
          foreach ( $users_data as $user_data ) :
            ?>
            <li class="media">
              <img src="<?php echo $user->get_user_image_path( $user_data['id'] ); ?>" class="mr-lg-3">
              <div class="media-body">
                <h2 class="mt-0"><?php echo $user_data['first_name']; ?> <?php echo $user_data['last_name']; ?></h2>
                <p class="mb-0"><?php echo $user_data['about']; ?></p>
              </div>
            </li>
            <?php
          endforeach;
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php
/**
 * Include footer
 */
include 'template-parts/footer.php';
?>
