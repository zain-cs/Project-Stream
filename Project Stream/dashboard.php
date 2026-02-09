<?php
include("includes/config.php");
include("includes/chk-session.php");
include('includes/connect.php');
include("includes/top-member.php");

//if already logged in, redirect to front
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != "" && isset($_SESSION["userName"]) && $_SESSION["userName"] != "")) {
	header("Location: front.php");
	exit;
}

$pageTitle = "Dashboard | Unite For Education";
include("includes/header.php");

$start = 0;
if (!(isset($_GET["update"]) && $_GET["update"] != "")) {
	$start = 1;
}
$error = '';
$message = '';
?>
<div class="dashboard pgSize">
	<h1>Dashboard</h1>
	<div class="leftNav">
		<ul>
			<li id="tab-1" <?php echo (isset($_GET["update"]) && $_GET["update"] == "info" ? "class='active'" : ($start == 1 ? "class='active'" : "")); ?>>
				<a href="dashboard.php?update=info">Basic Information</a>
			</li>
			<li id="tab-2" <?php echo (isset($_GET["update"]) && $_GET["update"] == "picture" ? "class='active'" : ""); ?>>
				<a href="dashboard.php?update=picture">Update Picture</a>
			</li>
			<li id="tab-3" <?php echo (isset($_GET["update"]) && $_GET["update"] == "pass" ? "class='active'" : ""); ?>>
				<a href="dashboard.php?update=pass">Reset Password</a>
			</li>
			<li id="tab-4" <?php echo (isset($_GET["update"]) && $_GET["update"] == "email" ? "class='active'" : ""); ?>>
				<a href="dashboard.php?update=email">Change Email Address</a>
			</li>
			<li id="tab-5" <?php echo (isset($_GET["update"]) && $_GET["update"] == "files" ? "class='active'" : ""); ?>>
				<a href="dashboard.php?update=files">Files Uploaded By You</a>
			</li>
		</ul>
	</div>
	<!--left Navigation-->
	<?php
	//get member record
	$email = $link->real_escape_string($_SESSION["email"]);
	$sqlQuery = "SELECT * FROM tblmembers WHERE memberemail='" . $email . "' LIMIT 1";
	$sqlResults = $link->query($sqlQuery);
	$sqlNumRows = $sqlResults->num_rows;

	if ($sqlNumRows > 0) { //that means user exists
		$row = $sqlResults->fetch_array(MYSQLI_ASSOC);

		$memberID = $row["memberid"];
		$firstNameValue = $row["memberfirstname"];
		$lastNameValue = $row["memberlastname"];
		$emailValue = $row["memberemail"];
		$phoneValue = $row["memberphone"];
		$pictureValue = $row["memberpicture"];
		$addressValue = $row["memberaddress"];
		$bioValue = $row["memberbio"];
		$passwordValue = $row["memberpassword"];
		$userNameValue = $row["memberusername"];
	}

	//on click update information
	// BASIC INFO UPDATE
	if (isset($_POST["submitBasic"])) {
		$firstNameUpdate = ($_POST["firstname"] != "" ? $_POST["firstname"] : $firstNameValue);
		$lastNameUpdate = ($_POST["lasttname"] != "" ? $_POST["lasttname"] : $lastNameValue);

		$firstNameUpdate = $link->real_escape_string($firstNameUpdate);
		$lastNameUpdate = $link->real_escape_string($lastNameUpdate);
		$address = $link->real_escape_string($_POST["address"]);
		$phone = $link->real_escape_string($_POST["phone"]);
		$bio = $link->real_escape_string($_POST["bio"]);

		$sqlUpdate = "UPDATE tblmembers SET memberfirstname='" . $firstNameUpdate . "',memberlastname='" . $lastNameUpdate . "',memberaddress='" . $address . "',memberphone='" . $phone . "',memberbio='" . $bio . "' WHERE memberid=" . $memberID;
		$link->query($sqlUpdate);

		$_SESSION["firstName"] = $firstNameUpdate;
		$_SESSION["lastName"] = $lastNameUpdate;

		// Set success message
		$_SESSION['message'] = "Your personal information has been updated successfully!";

		header("Location: dashboard.php?update=info");
		exit;
	}
	?>

	<!--Right pages-->
	<div class="rightDashSec">
		<?php
		//on click update Picture
		if (isset($_POST["submitPicture"])) {
			if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0) {
				$baseValue = dirname(__FILE__);
				$upFilePath = "/members/" . $userNameValue;
				$myFileFeild = "picture";
				include("includes/upload-picture.php");

				$filename = $link->real_escape_string($filename);
				$sqlUpdate = "UPDATE tblmembers SET memberpicture='" . $filename . "' WHERE memberid=" . $memberID;
				$link->query($sqlUpdate);

				$_SESSION["userPicture"] = $filename;

				// Set success message
				$_SESSION['message'] = "Your picture has been changed successfully!";

				header("Location: dashboard.php?update=picture");
				exit;
			} else {
				$error = "<li>Please select a valid image file.</li>";
			}
		}
		//on click update Picture

		//on click password update
		if (isset($_POST["submitPassword"])) {
			if ($_POST["oldpassword"] == $passwordValue) {
				if ($_POST["newpassword"] == $_POST["confpassword"]) {
					$newpassword = $link->real_escape_string($_POST["newpassword"]);
					$sqlUpdate = "UPDATE tblmembers SET memberpassword='" . $newpassword . "' WHERE memberid=" . $memberID;
					$link->query($sqlUpdate);

					// Set success message
					$_SESSION['message'] = "Your password has been changed successfully!";

					header("Location: dashboard.php?update=pass");
					exit;
				} else {
					$error = "<li>Your Password does not match..!!</li>";
				}
			} else {
				$error = "<li>Your Old Password is incorrect..!!</li>";
			}
		}
		//on click password update

		//on click Update Email
		if (isset($_POST["submitEmail"])) {
			if ($_POST["oldemail"] == $emailValue) {
				$newemail = $link->real_escape_string($_POST["newemail"]);
				$sqlUpdate = "UPDATE tblmembers SET memberemail='" . $newemail . "' WHERE memberid=" . $memberID;
				$link->query($sqlUpdate);
				$_SESSION["email"] = $newemail;

				// Set success message
				$_SESSION['message'] = "Your email has been changed successfully!";

				header("Location: dashboard.php?update=email");
				exit;
			} else {
				$error = "<li>Your Email is incorrect...!!</li>";
			}
		}

		//on click Update Email
		?>
		<!--show update message-->
		<?php
		// Start session only if it hasn't been started yet
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		// Handle update messages
		// if (isset($_GET["update"]) && $_GET["update"] != "") {
		// 	switch ($_GET["update"]) {
		// 		case "info":
		// 			$_SESSION['message'] = "Your personal information has been updated successfully!";
		// 			break;
		// 		case "picture":
		// 			$_SESSION['message'] = "Your picture has been changed successfully!";
		// 			break;
		// 		case "pass":
		// 			$_SESSION['message'] = "Your password has been changed successfully!";
		// 			break;
		// 		case "email":
		// 			$_SESSION['message'] = "Your email has been changed successfully!";
		// 			break;
		// 	}
		// 	// Redirect to remove GET parameter
		// 	header("Location: dashboard.php");
		// 	exit();
		// }

		// Show messages
		if (isset($_SESSION['message'])) {
			echo '<div class="succMsh">' . $_SESSION['message'] . '</div>';
			unset($_SESSION['message']); // Clear message after showing
		}

		if ($error != "") {
			echo '<ul class="errorsMsg">' . $error . '</ul>';
		}
		?>




		<div id="expand-1" class="expandPnl <?php echo (isset($_GET["update"]) && $_GET["update"] == "info" ? "display" : ($start == 1 ? "display" : "")); ?>">
			<form method="post" action="">
				<label>First Name*:</label>
				<input type="text" name="firstname" value="<?php echo (isset($firstNameValue) ? $firstNameValue : ""); ?>" />
				<div class="sep"></div>
				<label>Last Name*:</label>
				<input type="text" name="lasttname" value="<?php echo (isset($lastNameValue) ? $lastNameValue : ""); ?>" />
				<div class="sep"></div>
				<label>Phone #:</label>
				<input type="text" placeholder="0000-0000000" name="phone" value="<?php echo (isset($phoneValue) ? $phoneValue : ""); ?>" />
				<div class="sep"></div>
				<label>Address:</label>
				<input type="text" name="address" value="<?php echo (isset($addressValue) ? $addressValue : ""); ?>" />
				<div class="sep"></div>
				<label>Bio:</label>
				<textarea name="bio" placeholder="Enter About Yourself..."><?php echo (isset($bioValue) ? $bioValue : ""); ?></textarea>
				<div class="sep"></div>
				<input type="submit" name="submitBasic" value="Update Information" />
			</form>
		</div>
		<div id="expand-2" class="expandPnl <?php echo (isset($_GET["update"]) && $_GET["update"] == "picture" ? "display" : ""); ?>">
			<form method="post" action="" enctype="multipart/form-data">
				<label>Update Picture:</label>
				<input name="picture" type="file" accept="image/*" />
				<div class="profilePrev">
					<?php echo memberPicture($pictureValue, $userNameValue); ?>
				</div>
				<div class="sep"></div>
				<input type="submit" name="submitPicture" value="Update Picture" />
			</form>
		</div>
		<div id="expand-3" class="expandPnl <?php echo (isset($_GET["update"]) && $_GET["update"] == "pass" ? "display" : ""); ?>">
			<form method="post" action="">
				<label>Old Password:</label>
				<input name="oldpassword" type="password" />
				<div class="sep"></div>
				<label>New Password:</label>
				<input name="newpassword" type="password" />
				<div class="sep"></div>
				<label>Confirm Password:</label>
				<input name="confpassword" type="password" />
				<div class="sep"></div>
				<input type="submit" name="submitPassword" value="Reset Password" />
			</form>
		</div>
		<div id="expand-4" class="expandPnl <?php echo (isset($_GET["update"]) && $_GET["update"] == "email" ? "display" : ""); ?>">
			<form method="post" action="">
				<label>Old Email:</label>
				<input name="oldemail" type="text" />
				<div class="sep"></div>
				<label>New Email:</label>
				<input name="newemail" type="text" />
				<div class="sep"></div>
				<input type="submit" name="submitEmail" value="Change Email" />
			</form>
		</div>
		<div id="expand-5" class="expandPnl <?php echo (isset($_GET["update"]) && $_GET["update"] == "files" ? "display" : "") ?>">
			<?php
			// Get files uploaded by this user
			$queryFiles = "SELECT * FROM tblfiles WHERE userid=" . $memberID . " ORDER BY fileid DESC";
			$resultFiles = $link->query($queryFiles);

			if ($resultFiles->num_rows > 0) {
				echo '<table class="files">
						<tr>
							<th>Sr #</th>
							<th>File Name</th>
							<th>Action</th>
						</tr>';

				$num = 1;
				while ($fileRow = $resultFiles->fetch_array(MYSQLI_ASSOC)) {
					echo '<tr>
							<td>' . $num . '</td>
							<td>' . $fileRow["filename"] . '</td>
							<td><a href="' . $localPath . '/posts/files/' . $fileRow["filename"] . '">Download</a></td>
						</tr>';
					$num++;
				}

				echo '</table>';
			} else {
				echo '<p>No Files uploaded yet...!!!</p>';
			}
			?>
		</div>
	</div>
	<!--Right pages-->
</div>
<?php
include("includes/footer.php");
?>