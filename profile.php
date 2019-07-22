<?php
/**
 * Profile template
 */

/**
 * Include header
 */
include 'template-parts/header.php';

$user = new User();

if ( isset( $_POST['submit'] ) ) {
  $firstName    = $_POST['first-name'];
  $lastName     = $_POST['last-name'];
  $about        = $_POST['about'];
  $public       = $_POST['profile-visibility'];
  $profileImage = $_FILES['profile-image'];
  $user->upload_file( $profileImage );
  $user->update_user_data( $firstName, $lastName, $about, $public );
}

$userData = $user->get_user_data();
$get_user_image = $user->get_user_image_path();

?>

<div class="container mt-3">
  <h1 class="text-center">PROFILE SETTINGS</h1>
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <form method="post" enctype="multipart/form-data">
        <div class="form-group row">
          <label for="first-name" class="col-sm-3 col-form-label">First Name</label>
          <div class="col-sm-9">
            <input type="text" name="first-name" value="<?php echo $userData['first_name']; ?>" class="form-control" id="first-name" placeholder="First Name">
          </div>
        </div>
        <div class="form-group row">
          <label for="last-name" class="col-sm-3 col-form-label">Last Name</label>
          <div class="col-sm-9">
            <input type="text" name="last-name" value="<?php echo $userData['last_name']; ?>" class="form-control" id="last-name" placeholder="Last Name">
          </div>
        </div>
        <div class="form-group row">
          <label for="user-textarea" class="col-sm-3 col-form-label">About me</label>
          <div class="col-sm-9">
            <textarea name="about" class="form-control" id="user-textarea" rows="6"><?php echo $userData['about']; ?></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="profile-image" class="col-sm-3 col-form-label">Profile image</label>
          <div class="col-sm-9">
            <div class="profile-image">
              <img src="<?php echo $get_user_image; ?>">
            </div>
            <input type="file" name="profile-image" class="form-control-file" id="profile-image">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-3">Profile</div>
          <div class="col-sm-9">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="public-profile" name="profile-visibility" value="1" class="custom-control-input" <?php echo ( 1 == $userData['public'] ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="public-profile">Public</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="private-profile" name="profile-visibility" value="0" class="custom-control-input" <?php echo ( 0 == $userData['public'] ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="private-profile">Private</label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-9 offset-sm-3">
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
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
