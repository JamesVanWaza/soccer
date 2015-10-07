<?php
ob_start();
session_start();

if (!isset($_SESSION['user_level']) or ($_SESSION['user_level'] != 1)) {
	header("Location: login.php");
	exit();
}

include 'header-members.php';

ob_end_flush();
?>
<h2 class="text-center">Edit a Record</h2>
<?php

// After clicking the Edit link in the found_record.php page, the editing interface appears
// The code looks for a valid user ID, either through GET or POST:

if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
	// From view-users.php
	$id = $_GET['id'];
} elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
	// Form submission.
	$id = $_POST['id'];
} else {
	// If no valid ID, stop the script
	echo '<p class="alert-box alert round">This page has been accessed in error.</p>';
	include 'footer.php';

	exit();
}

require 'mysqli-connect.php';

// Has the form been submitted?

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();

	// Look for the first name

	if (empty($_POST['fname'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbcon, trim($_POST['fname']));
	}

	// Look for the last name

	if (empty($_POST['lname'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbcon, trim($_POST['lname']));
	}

	// Look for the email address

	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbcon, trim($_POST['email']));
	}

	if (empty($errors)) {
		// If everything's OK

		//  Check that the email address is not already in the database

		$q = "SELECT user_id FROM logindb WHERE email='$e' AND user_id != $id";
		$result = @mysqli_query($dbcon, $q);
		if (mysqli_num_rows($result) == 0) {

			// Make the update query:

			$q = "UPDATE logindb SET fname='$fn', lname='$ln', email='$e' WHERE user_id=$id LIMIT 1";
			$result = @mysqli_query($dbcon, $q);
			if (mysqli_affected_rows($dbcon) == 1) {
				// If it ran OK

				// Echo a message if the edit was satisfactory:

				echo '<div data-alert class="alert-box success radius">
  <i class="fa fa-check fa-2x"> Success !</i>
  <br>
  <h3 class="text-center">The user has been edited.</h3>
  <a href="#" class="close">&times;</a>
</div>';
				exit();
			} else {
				// Echo a message if the query failed.
				echo '<p class="alert-box alert round">The user was not edited due to a system error.
	We apologize for any inconvenience.</p>'; // Public message.

				// echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>'; // Debugging message.

			}
		} else {
			// Already registered
			echo '<p class="alert-box alert round">The email address is not acceptable because it is already registered for another member</p>';
		}
	} else {
		// Display the errors.
		echo '<div data-alert class="alert-box alert round">
	 	<p class="text-center">The following error(s) occurred:<br />';
		foreach ($errors as $msg) {
			echo " - $msg <br /> \n";
		}

		echo '<a href="#" class="close">&times;</a></div></p><p>Please try again.</p>';
	}// End of if (empty($errors))section.
}// End of the conditionals

// Select the user's information:

$q = "SELECT fname, lname, email FROM logindb WHERE user_id=$id";
$result = @mysqli_query($dbcon, $q);

if (mysqli_num_rows($result) == 1) {
	// Valid user ID, display the form.

	// Get the user's information:

	$row = mysqli_fetch_array($result, MYSQLI_NUM);

	// Create the form:

	echo '<form action="edit-record.php" method="post">
  <div class="row">
    <div class="large-6 medium-6 small-12 columns">
      <label>First Name
        <input id="fname" type="text" name="fname" size="30" maxlength="30" placeholder="First Name" value=" ' . $row[0] . '"/>
      </label>
    </div>
     <div class="large-6 medium-6 small-12 columns">
      <label>Last Name
        <input id="lname" type="text" name="lname" size="40" maxlength="40" placeholder="Last Name" value=" ' . $row[1] . '"/>
      </label>
    </div>
  </div><!--End of First Row-->
  <div class="row"><!--Beginning of Second Row-->
    <div class="large-12 small-12 columns">
      <label>Email
         <input id="email" type="email" name="email" size="50" maxlength="50" placeholder="Email" value=" ' . $row[2] . '"/>
      </label>
    </div>
      <div class="large-12 small-12 columns">
    <input type="submit" id="submit" name="submit" class="button [radius round]" value="Edit">
    <br /><input type="hidden" name="id" value="' . $id . '">
  </div>
    </div><!--End of Third Row-->
</form>';
} else {
	// The user could not be validated
	echo '<p class="alert-box alert round">This page has been accessed by an unauthorized person.</p>';
}

mysqli_close($dbcon);
include 'footer.php';
?>
