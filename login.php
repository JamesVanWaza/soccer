<?php
include 'login-header.php';
/*This section processes submissions from the login form*/
/*Check if the form has been submitted*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//Connect to the database
	require 'mysqli-connect.php';
//Validate the email address
	if (!empty($_POST['email'])) {
		$e = mysqli_real_escape_string($dbcon, trim($_POST['email']));
	} else {
		$e = FALSE;
		echo '<p class="alert-box alert round">You forgot to enter your email address:<br><a href="#" class="close">&times;</p>';
	}
	//Validate the password
	if (!empty($_POST['psword'])) {
		$p = mysqli_real_escape_string($dbcon, trim($_POST['psword']));
	} else {
		$p = FALSE;
		echo '<p class="alert-box alert round">You forgot to enter your password:<br><a href="#" class="close">&times;</p>';
	}
	if ($e && $p) {
		/*If no problems*/
		/*Retrieve the user_id, first_name and user_level for that email/password combination*/
		$q = "SELECT user_id, fname, user_level FROM admintable WHERE (email='$e' AND psword=SHA1('$p'))";
		/*Run the query and assign it to the variable $result*/
		$result = mysqli_query($dbcon, $q);
		/*Count the number of rows that match the email/password combination*/

		if (@mysqli_num_rows($result) == 1) {
			/*If one database row (record) matches the input: -
			Start the session, fetch the record and insert the three values in an array
			 */
			ob_start();
			session_start();
			$_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
			//Ensure that the user level is an integer.
			$_SESSION['user_level'] = (int) $_SESSION['user_level'];
			/*Use a ternary operator to set the URL*/
			$url = ($_SESSION['user_level'] === 1) ? 'admin-page.php' : 'members-page.php';
			header('Location: ' . $url); /*Make the browser load either the members or the admin pag*/
			exit(); //Cancel the rest of the script
			mysqli_free_result($result);
			mysqli_close($dbcon);
			ob_end_flush();
		} else {
			//No Match was made
			echo '<p class="alert-box alert round">The email address and password entered do not match our records<br><a href="#" class="close">&times;</p>';
		}
	} else {
		//If there was a  problem
		echo '<p class="alert-box alert round">Please try again<br><a href="#" class="close">&times;</p>';
	}
	mysqli_close($dbcon);
}//End of Submit Conditional
?>
<h2 class="text-center">Login</h2>
<!--display the form on the screen-->
<form action="login.php" method="post">
  <div class="row"><!--Beginning of First Row-->
    <div class="large-6 medium-6 columns">
      <label>Email Address:
         <input id="email" type="email" name="email" size="50" maxlength="50" placeholder="Email" value="<?php if (isset($_POST['email'])) {
	echo $_POST['email'];
}
?>"/>
      </label>
    </div>
  </div><!--End of Second Row-->
  <div class="row"><!--Beginning of Second Row-->
    <div class="large-6 medium-6 small-12 columns">
      <label>Password
        <input id="psword" type="password" name="psword" size="12" maxlength="12" placeholder="Password" value="<?php if (isset($_POST['psword'])) {
	echo $_POST['psword'];
}
?>"/>
      </label><span>Between 8 and 12 characters</span>
    </div>
      <div class="large-12 small-12 columns">
    <input type="submit" id="submit" name="submit" class="button [radius round alert]" value="Login">
  </div>
    </div><!--End of Third Row-->
</form>
