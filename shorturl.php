<?php
require_once('./config.php');

// verify the url data has been posted to this script
if (isset($_POST['url']) && $_POST['url'] != '')
	$url = $_POST['url']; 
else
	$url = '';
	
	
	// verify that a url was provided and that it is a valid url
if ($url != '' && strlen($url) > 0){
	if ( validate_url($url) == true ){
		
		// create a connection to the database
		$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		$mysqli = new mysqli("localhost","root","admin","short_urls");

		// Check connection
		if ($mysqli -> connect_errno) {
		  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		  exit();
		}

		// create all the variables to save in the database
		$id = '';
		$code = generate_code();
		$timestamp = date("Y-m-d h:i:s");
		$count = 0;
		$status = 1;
		
		$insert = "INSERT INTO `short_urls` (`id`, `code`, `url`, `count`, `created_date`, `status`) VALUES (NULL, '$code', '$url', '$count', '$timestamp', '$status')";
		$result = mysqli_query($conn, $insert);
		
		// verify that the new record was created
		$query = mysqli_query($conn, "SELECT * FROM short_urls WHERE created_date='$timestamp' AND code='$code'");
		if ($data = mysqli_fetch_assoc($query)){
			/* SUCCESS POINT */
			
			echo URL_BASE . $code;
		}
		else
			echo 'Unable to shorten your url';
	}
	else
		echo 'Please enter a valid url';
}
else
	echo 'No url was found';
?>
