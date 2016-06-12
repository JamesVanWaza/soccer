<?php
include_once 'nav-admin.php';
require 'mysqli-connect.php';
/** This script performs an INSERT query that adds a record to the users table */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    /** Initialize an error array */
    $errors = array();

    /** Was the Name Soccer Club Entered */
    if (empty($_POST['noc'])) {
        $errors[] = 'You did not enter the name of the club';
    } else {
        $nc = mysqli_real_escape_string($dbcon, trim($_POST['noc']));
    }

    /** Was the league entered */
    if (empty($_POST['league'])) {
        $errors[] = 'You did not enter the league of the club.';
    } else {
        $le = mysqli_real_escape_string($dbcon, trim($_POST['league']));
    }

    /** Was the country entered? */
    if (empty($_POST['country'])) {
        $errors[] = 'You did not enter your country on where the club is located.';
    } else {
        $cy = mysqli_real_escape_string($dbcon, trim($_POST['country']));
    }

    /** Was the website url entered? */
    if (empty($_POST['weburl'])) {
        $errors[] = 'You did not enter the website url for the club.';
    } else {
        $wl = mysqli_real_escape_string($dbcon, trim($_POST['weburl']));
    }

    /** Was the address entered? */
    if (empty($_POST['address'])) {
        $errors[] = 'You did not enter the club address.';
    } else {
        $as = mysqli_real_escape_string($dbcon, trim($_POST['address']));
    }

    /** Start of the successful section after all the fields were filled out */
    if (empty($errors)) {
        /** If no problems were encountered when filling the form, register the data in the database */

        /** Make the Query */
        $r = "INSERT INTO `soccer`.`clubs` (`id`, `noc`, `league`, `country`, `weburl`, `address`, `datecreated`)";
        $r .= "VALUES (`id`, '$nc', '$le', '$cy', '$wl', '$as', NOW())";
        $result = @mysqli_query($dbcon, $r); /** Run the Query */

        /** Insert Success Message */
        if ($result) {
            echo "Yes Data was entered in the Database";
            exit();
        } else {
            /** If the form handler or database contained errors */
            echo '<h2 class="text-center">System Error</h2>
            <div data-alert class="alert-box alert round">
			<p class="text-center">You could not be registered due to a system error. We apologize for any inconvenience.<a href="#" class="close">&times;</a></p></div>';

            /** Debug the Error Message */
            echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
        }/** End of Insert Success Clause */

        mysqli_close($dbcon); /** Close the database connection. */

        /** Include the footer and quit the script: */
        include 'footer.php';

        exit();
    } else {
        /** Display the errors */
        echo '<h2 class="text-center">Error!</h2>
        		<p class="alert-box alert round">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            /** Print each error */
            echo " - $msg<br>\n";
        }
        echo '</p><h3>Please try again.</h3><p><br></p>';
    }/** End of if (empty($errors)) IF. */

}/** End of the main submit */
?>
<h2 class="text-center">Register</h2>

	<!--display the form on the screen-->
	<form action="create-club.php" method="post">
		<div class="row"><!--Beginning of First Row-->
			<div class="large-6 medium-6 small-12 columns">
				<label>Name of Club
					<input id="noc"
					type="text"
					name="noc"
					size="30"
					maxlength="30"
					placeholder="Club Name"
					value="<?php if (isset($_POST['noc'])) {echo $_POST['noc'];}
?>"/>
				</label>
			</div>

			<div class="large-6 medium-6 small-12 columns">
				<label>League
                <select name="league" id="league">
                	<option value="<?php if (isset($_POST['league'])) {echo $_POST['league'];}
?>">Bundesliga (Div 1)</option>
                    <option value="<?php if (isset($_POST['league'])) {echo $_POST['league'];}
?>">Gibraltar (Div 1)</option>
<option value="<?php if (isset($_POST['league'])) {echo $_POST['league'];}
?>">La Liga (Div 1)</option>
                </select>
				</label>
			</div><!--End of First Row-->
		</div><!--End of First Row-->


		<div class="row"><!--Beginning of Second Row-->
			<div class="large-6 medium-6 small-12 columns">
				<label>Country
                	<select name="country" id="country">
                    	<option value="<?php if (isset($_POST['country'])) {
    echo $_POST['country'];}
?>">Gibraltar</option>
                		<option value="<?php if (isset($_POST['country'])) {
    echo $_POST['country'];}
?>">Spain</option>
                		<option value="<?php if (isset($_POST['country'])) {
    echo $_POST['country'];}
?>">USA</option>
                	</select>
				</label>
			</div>

			<div class="large-6 medium-6 small-12 columns">
				<label>Website URL
					<input id="weburl"
						type="url"
						name="weburl"
						size="50"
						maxlength="50"
						placeholder="Website URL"
						value="<?php if (isset($_POST['weburl'])) {
    echo $_POST['weburl'];}
?>"/>
				</label>
			</div>

			<div class="large-12 medium-12 small-12 columns">
				<label>Address
                	<textarea name="address" id="address" cols="30" rows="10" placeholder="Address" value="<?php if (isset($_POST['address'])) {
    echo $_POST['address'];}
?>" ></textarea>
				</label>
			</div>
		</div><!--End of Second Row-->

		<div class="row"><!--Beginning of Third Row-->
			<div class="large-12 small-12 columns">
				<input type="submit" id="submit" name="submit" class="tiny button [radius round]" value="Register">
			</div>
		</div><!--End of Third Row-->
	</form>
<?php include 'footer.php';?>
