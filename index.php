<?php
	// require the include files that has all the back-end functionality
	require_once('./config.php');
	
	// check to see if a code has been supplied and process it
	if (isset($_GET['code']) && $_GET['code'] != '' && strlen($_GET['code']) > 0){
		$code = $_GET['code']; 
		
		// validate the code against the database
		$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		$query = mysqli_query($conn, "SELECT * FROM short_urls WHERE code='$code'");
		if (mysqli_num_rows($query) == 1){
			
			// retrieve the data from the database
			$data = mysqli_fetch_assoc($query);
			
			// update the counter in the database
			mysqli_query($conn, "UPDATE short_urls SET count='" . ($data['count']) + 1 . "' WHERE id='". ($data['id'])."'");
			
			/* ADD EXTRA STUFF HERE IF DESIRED */
			
			// set some header data and redirect the user to the url
			header("Expires: Mon, 26 Jul 2022 05:00:00 GMT");
			header("Cache-Control: no-cache");
			header("Pragma: no-cache");

			header("Location: " . $data['url']);
			
			die();
		}
		else
			$message = '<font color="red">Unable to redirect to your url</font>';
	}
?>



<body>
	<div id="wrapper" style="text-align:center">
		<div id="header">
			<h1>url shortener</h1>
		</div>
		<div id="content">
			<h3 class="topper">Enter an url below to create short url.</h3>
			
			<table class="mainForm" style="margin-left:auto;margin-right:auto">
				<form method="post" action="#" name="shortUrlForm" id="shortUrlForm">
					<tr>
						<td align="right"><input type="text" name="url" id="url" value="" placeholder="http://" style="width: 100%;" /></td>
						<td align="left" width="1"><input type="submit" name="lesnBtn" value="create short url" /></td>
					</tr>
				</form>
			</table>
			
			<h3 id="message" class="success"><?php echo ( isset($message) ? $message : '' );  ?></h3>
			
			<div class="meta">
				There are currently <b id="counter"><?php echo number_format(count_urls()); ?></b> short urls.
			</div>
		</div>
	</div>	
</body>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
	// ready the sites javascript for use after the page has loaded
	$(document).ready(function(){
		// process the form submission using javascript
		$("#shortUrlForm").submit(function(event){
			// get the url to be shortened
			var url = $("#url").val();
			if ($.trim(url) != ''){
				// submit all of the required data via post to the processing script
				$.post("./shorturl.php", {url:url}, function(data){
					
					// process the returned data from the post
					if (data.substring(0, 7) == 'http://' || data.substring(0, 8) == 'https://'){
						$("#url").val(data).focus();
						
						// display a success message to the user
						$("#message").html('The given url has been shortened!');
						
						// update the counter shown on the page
						var counter = $("#counter").text();
						$("#counter").text(parseInt(counter) + 1);
					}
					else
						$("#message").html(data);
				});	
			}
			
			// select the text box after form submission
			$("#url").focus();
			
			// prevent the form from reloading the page
			return false;
		});
		
		// select the text box on page load
		$("#url").focus();
	});
</script>
