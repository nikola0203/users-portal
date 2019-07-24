<?php
/**
 * Profile template
 */

/**
 * Include header
 */
include '../template-parts/header.php';

$user = new User();

if ( isset( $_POST['submit'] ) ) {
  
  foreach ( $_POST as $key => $value ) {

    $user->update_user_status( $value, $key );

  }

}

?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <form method="post">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">User ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">User Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $users_data = $user->get_dashboard_users();
            foreach ( $users_data as $user_data ) :
              ?>
              <tr>
                <th scope="row"><?php echo $user_data['id']; ?></th>
                <td><?php echo $user_data['first_name']; ?></td>
                <td><?php echo $user_data['last_name']; ?></td>
                <td>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="user-<?php echo $user_data['id'] ?>-status-enabled" name="<?php echo $user_data['id'] ?>" value="enabled" class="custom-control-input" <?php echo ( 'enabled' == $user_data['status'] ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="user-<?php echo $user_data['id'] ?>-status-enabled">Enable</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="user-<?php echo $user_data['id'] ?>-status-disabled" name="<?php echo $user_data['id'] ?>" value="disabled" class="custom-control-input" <?php echo ( 'disabled' == $user_data['status'] ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="user-<?php echo $user_data['id'] ?>-status-disabled">Disable</label>
                  </div>
                </td>
              </tr>
              <tr>
              <?php
            endforeach;
            ?>
          </tbody> 
        </table>
        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
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
