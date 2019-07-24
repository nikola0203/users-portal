<?php 

include_once 'database.php';

class User {

  protected $db;

  public function __construct(){
    $this->db = new Database_Connection();
		$this->db = $this->db->get_connection();
  }
	
	/**
	 * 
	 * Register user.
	 * 
	 * @param string $firstname
	 * @param string $lastname
	 * @param string $username
	 * @param string $password
	 * @param string $email
	 * @return bool
	 * 
	 */
	public function register( $firstname, $lastname, $username, $password, $email, $access_code, $user_role = 'default' ){

		$query = "INSERT INTO users SET first_name=:firstname, last_name=:lastname, username=:username, password=:password, email=:email, access_code=:access_code, user_role=:user_role";
		
		$stmt = $this->db->prepare( $query );

		$firstname   = htmlspecialchars( strip_tags( $firstname ) );
		$lastname    = htmlspecialchars( strip_tags( $lastname ) );
		$username    = htmlspecialchars( strip_tags( $username ) );
		$password    = htmlspecialchars( strip_tags( $password ) );
		$email       = htmlspecialchars( strip_tags( $email ) );
		$access_code = htmlspecialchars( strip_tags( $access_code ) );
		$user_role   = htmlspecialchars( strip_tags( $user_role ) );

		$password = password_hash( $password, PASSWORD_BCRYPT, array( "cost" => 12 ) );
		
		$stmt->bindValue( ":firstname", $firstname );
		$stmt->bindValue( ":lastname", $lastname );
		$stmt->bindValue( ":username", $username );
		$stmt->bindValue( ":password", $password );
		$stmt->bindValue( ":email", $email );
		$stmt->bindValue( ":access_code", $access_code );
		$stmt->bindValue( ":user_role", $user_role );

		if ( $stmt->execute() ) {
			
			return true;

		} else {

			return false;

		}

	}

	/**
	 * 
	 * Login user.
	 * 
	 * @param string $username
	 * @param string $password
	 * @return bool
	 * 
	 */
	public function login( $username, $password ) {
		
		$query = "SELECT id, password, verified_status FROM users WHERE username='$username'";
		
		$stmt = $this->db->prepare( $query );
		
		$stmt->execute();

		$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$verified_status = $user_data['verified_status'];

		if ( $verified_status == 1 && password_verify( $password, $user_data['password'] ) ) {

			$_SESSION['login'] = true;

			$_SESSION['id'] = $user_data['id'];

			return true;

		} else {
			
			return false;

		}
		
	}

	/**
	 * 
	 * Get session.
	 * 
	 * @return bool
	 * 
	 */
	public function get_login_session() {
		
		return $_SESSION['login'];

	}

	/**
	 * 
	 * Logout user.
	 * 
	 * @return void
	 * 
	 */
	public function logout() {
		
		$_SESSION['login'] = false;
		
		unset( $_SESSION );
		
		session_destroy();

	}

	/**
	 * 
	 * Return true if user is logged in.
	 * 
	 * @return bool
	 * 
	 */
	public function is_user_logged_in() {
		
		if ( $_SESSION['login'] ) {

			return true;

		}

		return false;

	}

	/**
	 * 
	 * Get user data.
	 * 
	 * @return array $user_data
	 * 
	 */
	public function get_user_data() {
		
		if ( isset( $_SESSION['id'] ) ) {

			$userID = $_SESSION['id'];
			
			$query = "SELECT * FROM users WHERE id='$userID'";

			$stmt = $this->db->prepare( $query );
		
			$stmt->execute();

			$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
	
			return $user_data;

		} else {
			
			return false;
			
		}

	}

	/**
	 * 
	 * Update user data.
	 * 
	 * @param string $firstname
	 * @param string $lastname
	 * @param string $about
	 * @param bool $public
	 * @return bool
	 * 
	 */
	public function update_user_data( $firstname, $lastname, $about, $public ) {
		
		if ( isset( $_SESSION['id'] ) ) {
			
			$userID = $_SESSION['id'];
			
			$query = "UPDATE users SET first_name=:firstname, last_name=:lastname, about=:about, public=:public WHERE id=:userID";

			$stmt = $this->db->prepare( $query );
			
			$firstname = htmlspecialchars( strip_tags( $firstname ) );
			$lastname  = htmlspecialchars( strip_tags( $lastname ) );
			$about     = htmlspecialchars( strip_tags( $about ) );
			$public    = htmlspecialchars( strip_tags( $public ) );
			
			$stmt->bindValue( ":firstname", $firstname );
			$stmt->bindValue( ":lastname", $lastname );
			$stmt->bindValue( ":about", $about );
			$stmt->bindValue( ":userID", $userID );
			$stmt->bindValue( ":public", $public );

			$stmt->execute();

			return true;

		} else {
			
			return false;
			
		}

	}

	/**
	 * 
	 * Update user status.
	 * 
	 * @param string $status
	 * @param string $userID
	 * @return bool
	 * 
	 */
	public function update_user_status( $status, $userID ) {
		
			$query = "UPDATE users SET status=:status WHERE id=:userID AND status<>:status";

			$stmt = $this->db->prepare( $query );
			
			$status = htmlspecialchars( strip_tags( $status ) );
			$userID = htmlspecialchars( strip_tags( $userID ) );
			
			$stmt->bindValue( ":status", $status );
			$stmt->bindValue( ":userID", $userID );

			// $stmt->execute();

			if ( $stmt->execute() ) {
				
				return true;
				
			} else {

				return false;

			}
			

	}

	/**
	 * 
	 * Check if user exist.
	 * 
	 * @param string $username
	 * @param string $email
	 * @return bool
	 * 
	 */
	public function is_user_exist( $username, $email ) {
		
		$query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
		
		$stmt = $this->db->prepare( $query );
		
		$stmt->execute();
		
		if ( $stmt->rowCount() > 0 ) {

			return true;

		} else {

			return false;

		}
	}

	/**
	 * 
	 * Upload file file to the uploads directory.
	 * 
	 * @param string $profile_image
	 * 
	 */
	public function upload_file( $profile_image ) {

		if ( 0 == $profile_image['error'] ) {

			$userID = $_SESSION['id'];
			
			// Create user image dir.
			if ( !file_exists( 'uploads/'. $userID .'' ) ) {
				mkdir( 'uploads/' . $userID . '' );
			}

			$upload          = 1;
			$target_dir      = 'uploads/' . $userID . '/';
			$target_file     = $target_dir . basename( $profile_image["name"] );
			$image_file_type = pathinfo( $target_file, PATHINFO_EXTENSION );
			$check           = getimagesize( $profile_image["tmp_name"] );

			// Resize image.
			$this->resize_image( $profile_image );

			// If is not image.
			if( empty ( $check ) ) {
				echo "<center>File is not an image.</center>";
				$upload = 0;
			}
			// Check file size.
			elseif ( $profile_image["size"] > 500000 ) {
				echo "<center>Your file is too large.</center>";
				$upload = 0;
			}
			// Allow certain file formats.
			elseif( $image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" ) {
				echo "<center>Only JPG, JPEG, PNG & GIF files are allowed.</center>";
				$upload = 0;
			}
			// Check if $upload is set to 0 by an error.
			if ( 0 != $upload ) {

				// Empty dir before upload new image.
				$images = glob('' . $target_dir . '*'); // Get images.
				foreach( $images as $image ) {

					if( is_file( $image ) ) {

						unlink( $image ); // Delete image.

					}

				}

				if ( move_uploaded_file( $profile_image["tmp_name"], $target_file ) ) {		

					$query = "UPDATE users SET profile_image=:profile_image WHERE id=:userID";
					
					$stmt = $this->db->prepare( $query );
			
					$db_profile_image = htmlspecialchars( strip_tags( $profile_image["name"] ) );

					$stmt->bindValue( ":profile_image", $db_profile_image );
					$stmt->bindValue( ":userID", $userID );

					$stmt->execute();

					echo "<center><i><h4>The file " . basename( $profile_image["name"] ) . " has been uploaded.</h4></i></center>";

				} else {
				
					echo "<center>Sorry, there was an error uploading your file.</font></center>";

				}

			}

		}

	}

	/**
	 * 
	 * Get user profile image.
	 * 
	 * @return string $user_image_path
	 * 
	 */
	public function get_profile_image_path() {
		
		if ( isset( $_SESSION['id'] ) ) {
			
			$userID = $_SESSION['id'];

			$query = "SELECT profile_image FROM users WHERE id='$userID'";

			$stmt = $this->db->prepare( $query );
		
			$stmt->execute();

			$profile_image_name = $stmt->fetch(PDO::FETCH_ASSOC);

			$user_image_path = '../uploads/' . $userID . '/' . $profile_image_name['profile_image'] . '';
	
			return $user_image_path;

		}

	}
	
	/**
	 * 
	 * Resize prfile image.
	 * 
	 * @param string $profile_image
	 * 
	 */
	public function resize_image( $profile_image ) {
		$userID            = $_SESSION['id'];
		$max_size          = 150;
		$thumb_height      = 150;
		$thumb_width       = 150;
		$file_name         = $profile_image['tmp_name'];
		$target_filename   = $file_name;
		list( $width, $height ) = getimagesize( $file_name );
		$ratio             = $width / $height;
		$target_dir        = 'uploads/' . $userID . '/';
		$target_file       = $target_dir . basename( $profile_image["name"] );
		$image_file_type   = pathinfo( $target_file, PATHINFO_EXTENSION );

		if( $ratio > 1) {
			$new_width = $max_size;
			$new_height = $max_size / $ratio;
		} else {
			$new_width = $max_size * $ratio;
			$new_height = $max_size;
		}

		// Get the original image.
		$original_image = imagecreatefromstring( file_get_contents( $file_name ) );

		// Create new image.
		$new_image = imagecreate( $thumb_height, $thumb_width ); 

		$x_offset = ( $thumb_width - $new_width ) / 2;
		$y_offset = ( $thumb_height - $new_height ) / 2;

		// Define black background image.
		$black_image = imagecolorallocate( $new_image, 0, 0, 0 );
				
		imagecopyresampled( $new_image, $original_image, $x_offset, $y_offset, 0, 0, $new_width, $new_height, $width, $height );

		if( "jpg" == $image_file_type || "jpeg" == $image_file_type ) {

			imagejpeg( $new_image, $target_filename, 100 );

		} elseif( "png" == $image_file_type ) {

			imagepng( $new_image, $target_filename );

		}

		imagedestroy( $new_image );

	}

	/**
	 * 
	 * Check if given access_code exist in the database.
	 * 
	 * @param string $access_code
	 * 
	 */
	public function access_code_exists( $access_code ) {
	
		$query = "SELECT id FROM users WHERE access_code=:access_code LIMIT 0,1";

		$stmt = $this->db->prepare( $query );

		$access_code = htmlspecialchars( strip_tags( $access_code ) );

		$stmt->bindParam( ':access_code', $access_code );

		$stmt->execute();

		$row = $stmt->rowCount();

		if( $row > 0 ) {
			
			return true;

		} else {

			return false;

		}

	}

	/**
	 * 
	 * Update verified_status, used in email verification.
	 * 
	 * @param string $verified_status
	 * @param string $access_code
	 * @return bool
	 * 
	 */
	public function update_status_by_access_code( $verified_status, $access_code ) {
	
		$query = "UPDATE users SET verified_status=:verified_status WHERE access_code=:access_code";

		$stmt = $this->db->prepare( $query );

		$verified_status = htmlspecialchars( strip_tags( $verified_status ) );
		$access_code     = htmlspecialchars( strip_tags( $access_code ) );

		$stmt->bindParam(':verified_status', $verified_status );
		$stmt->bindParam(':access_code', $access_code );

		if( $stmt->execute() ) {
		
			return true;
		
		}
		
		return false;

	}

	/**
	 * 
	 * Update access_code, used in forgot password.
	 * 
	 * @param string $access_code
	 * @param string $email
	 * @return bool
	 * 
	 */
	public function update_access_code( $access_code, $email ){
	
		$query = "UPDATE users SET access_code=:access_code WHERE email=:email";

		$stmt = $this->db->prepare($query);

		$access_code = htmlspecialchars( strip_tags( $access_code ) );
		$email       = htmlspecialchars( strip_tags( $email ) );

		$stmt->bindParam( ':access_code', $access_code );
		$stmt->bindParam( ':email', $email );

		$stmt->execute();

		if( $stmt->execute() ) {

			return true;

		}

		return false;
		
	}

	/**
	 * 
	 * Check if email exist in the database.
	 * 
	 * @param string $email
	 * @return bool
	 * 
	 */
	public function email_exists( $email ) {
		
		$query = "SELECT * FROM users WHERE email=:email";
		
		$stmt = $this->db->prepare( $query );

		$email = htmlspecialchars( strip_tags( $email ) );

		$stmt->bindParam( ':email', $email );
		
		$stmt->execute();
		
		if ( $stmt->rowCount() > 0 ) {

			return true;

		} else {

			return false;

		}
	}

	/**
	 * 
	 * Update password, used in forgot password.
	 * 
	 * @param string $password
	 * @param string $access_code
	 * @return bool
	 * 
	 */
	function update_password( $password, $access_code ){

		$query = "UPDATE users SET password=:password WHERE access_code=:access_code";

		$stmt = $this->db->prepare( $query );

		$password    = htmlspecialchars( strip_tags( $password ) );
		$access_code = htmlspecialchars( strip_tags( $access_code ) );

		$password_hash = password_hash( $password, PASSWORD_BCRYPT, array( "cost" => 12 ) );

		$stmt->bindParam( ':password', $password_hash );
		$stmt->bindParam( ':access_code', $access_code );

		if( $stmt->execute() ) {

			return true;

		} else {

			return false;

		}

	}

	/**
	 * 
	 * Get user data.
	 * 
	 * @return array $user_data
	 * 
	 */
	public function get_users() {

		if ( $this->is_user_logged_in() ) {
			
			$query = "SELECT * FROM users WHERE verified_status=1 AND status='enabled' AND user_role='default'";

		} else {

			$query = "SELECT * FROM users WHERE verified_status=1 AND status='enabled' AND user_role='default' AND public=1";

		}

		$stmt = $this->db->prepare( $query );
	
		$stmt->execute();

		$user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $user_data;

	}

	/**
	 * 
	 * Get user data.
	 * 
	 * @return array $user_data
	 * 
	 */
		public function get_dashboard_users() {
			
			$query = "SELECT * FROM users WHERE user_role='default'";

			$stmt = $this->db->prepare( $query );
		
			$stmt->execute();

			$user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $user_data;

		}

	/**
	 * 
	 * Get user profile image.
	 * 
	 * @return string $user_image_path
	 * 
	 */
	public function get_user_image_path( $userID ) {
		
		if ( $userID ) {
			
			$query = "SELECT profile_image FROM users WHERE id='$userID'";

			$stmt = $this->db->prepare( $query );
		
			$stmt->execute();

			$profile_image_name = $stmt->fetch(PDO::FETCH_ASSOC);

			$user_image_path = '../uploads/' . $userID . '/' . $profile_image_name['profile_image'] . '';
	
			return $user_image_path;

		}

	}

}



