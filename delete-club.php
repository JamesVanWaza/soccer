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
<h2 class="text-center">Delete a Record</h2>
<?php
// Check for a valid user ID, through GET or POST:
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
	// From view-users.php
	$id = $_GET['id'];
} elseif
((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
	// Form submission.
	$id = $_POST['id'];
} else {
	// If no valid ID, stop the script.
	echo "<p class='alert-box alert round'>This page has been accessed in error</p>";
	include 'footer.php';
	exit();
}
require 'mysqli-connect.php';
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['sure'] == 'Yes') {
		// Delete the record.
		// Make the query:
		$q = "DELETE FROM logindb WHERE user_id=$id LIMIT 1";
		$result = @mysqli_query($dbcon, $q);
		if (mysqli_affected_rows($dbcon) == 1) {
			// If it ran OK.
			// Print a message:
			echo '<div data-alert class="alert-box success radius">
  <i class="fa fa-check fa-2x"> Success !</i>
  <br>
  <h4 class="text-center">The user has been deleted.</h4>
  <a href="#" class="close">&times;</a>
</div>';
		} else {// If the query did not run OK.
			echo '<div data-alert class="alert-box alert round">
  <p class="text-center">The following error(s) occurred:<br>
   <a href="#" class="close">&times;</a>
</div>'; // Public message.
			echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	} else {
		// No confirmation of deletion.
		echo '<h3>The user has NOT been deleted.</h3>';
	}
} else {
	// Show the form.
	// Retrieve the user's information:
	$q = "SELECT fname, lname, email  FROM logindb WHERE user_id=$id";
	$result = @mysqli_query($dbcon, $q);
	if (mysqli_num_rows($result) == 1) {
		// Valid user ID, show the form.
		// Get the user's information:
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		// Display the record being deleted:
		echo "<h3>Are you sure you want to permanently delete $row[0]?</h3>";
		// Create the form:
		echo '<form action="delete-record.php" method="post">
    <div class="row">
      <div class="large-6 medium-6 small-12 columns">
        <label>
          <input id="submit-yes" class="button radius" type="submit" name="sure" value="Yes">
        </label>
      </div>
      <div class="large-6 medium-6 small-12 columns">
        <label>
         <input id="submit-no" class="button alert" type="submit" name="sure" value="No">
        </label>
      </div>
      <div class="large-6 medium-6 small-12 columns">
        <label>
         <input type="hidden" name="id" value="' . $id . '">
        </label>
      </div>
    </form>';

	} else {
		// Not a valid user ID.
		echo '<p class="alert-box alert round">This page has been accessed in error</p>'; /*Error message*/
	}
}// End of the main submission conditional.
mysqli_close($dbcon);
include 'footer.php';
?>
