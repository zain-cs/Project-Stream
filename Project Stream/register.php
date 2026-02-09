<?php
	include("includes/config.php");
	include("includes/chk-session.php");
	include('includes/connect.php');
	$pageTitle = "Register | Unite For Education";
	include("includes/header.php");
	
	$errorC = array();
	$errors = '';
?>
	<?php
    	//on submit
			if(isset($_POST["submit"])&&$_POST["submit"]<>""){
				if(isset($_POST["firstname"])&&$_POST["firstname"]==""){
					$errors .= '<li>Enter Your First Name</li>';
					$errorC[0] = "error";
				}
				if(isset($_POST["lasttname"])&&$_POST["lasttname"]==""){
					$errors .= '<li>Enter Your Last Name</li>';
					$errorC[1] = "error";
				}
				if(isset($_POST["email"])&&$_POST["email"]==""){
					$errors .= '<li>Enter Your Email</li>';
					$errorC[2] = "error";
				}else{
					if(!(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))) {
						$errors .= '<li>Enter a Valid Email Address</li>';	
						$errorC[2] = "error";
					}
				}
				if(isset($_POST["password"])&&$_POST["password"]==""){
					$errors .= '<li>Choose a secure password</li>';
					$errorC[3] = "error";
				}
				
				if($_POST["password"]<>$_POST["conPassowrd"]){
					$errors .= '<li>Confirm password Not Matched.</li>';
					$errorC[4] = "error";
				}
			}
		//on submit
	?>
	<div class="pgSize">
    	<h1>Register</h1>
        <?php
        	if($errors<>''){
				echo('
					<ul class="errorsMsg">'.$errors.'</ul>
				');
			}
		?>
        <form method="post" action="">
            <label class="<?php echo(isset($errorC[0])?$errorC[0]:""); ?>">First Name*:</label>
            <input type="text" name="firstname" value="<?php echo(isset($_POST["firstname"])?$_POST["firstname"]:"");?>" />
            <div class="sep"></div>
            <label class="<?php echo(isset($errorC[1])?$errorC[1]:""); ?>">Last Name*:</label>
            <input type="text" name="lasttname" value="<?php echo(isset($_POST["lasttname"])?$_POST["lasttname"]:"");?>" />
            <div class="sep"></div>
            <label class="<?php echo(isset($errorC[2])?$errorC[2]:""); ?>">Email*:</label>
            <input type="text" name="email" value="<?php echo(isset($_POST["email"])?$_POST["email"]:"");?>" />
            <div class="sep"></div>
            <label class="<?php echo(isset($errorC[3])?$errorC[3]:""); ?>">Password*:</label>
            <input type="password" name="password" value="<?php echo(isset($_POST["password"])?$_POST["password"]:"");?>" />
            <div class="sep"></div>
            <label class="<?php echo(isset($errorC[4])?$errorC[4]:""); ?>">Comfirm Password*:</label>
            <input type="password" name="conPassowrd" value=""/>
            <div class="sep"></div>
            <input type="submit" name="submit" value="Register" /> 
            <a class="btnCncl" href="<?php echo($localPath."/"); ?>">Cancel</a>
        </form>
    </div>
    <?php
		//save to database
		if(isset($_POST["submit"])&&$errors==""){
			//create user nameeeee
				$userName = explode("@",$_POST["email"]);
				$userName = $userName[0]; // FIXED: Get the actual username string
			//create user nameeeee
			
			$firstname = $link->real_escape_string($_POST["firstname"]);
			$lasttname = $link->real_escape_string($_POST["lasttname"]);
			$email = $link->real_escape_string($_POST["email"]);
			$password = $link->real_escape_string($_POST["password"]); // FIXED: Added escaping
			
			$sqlQuery = "INSERT INTO tblmembers(memberfirstname,memberlastname,memberusername,memberemail,memberpassword) VALUES ('".$firstname."','".$lasttname."' ,'".$userName."','".$email."','".$password."')";
			
			if($link->query($sqlQuery)){
				// FIXED: Create user folder immediately after registration
				$userFolder = "members/".$userName;
				if(!is_dir($userFolder)){
					mkdir($userFolder, 0755, true);
				}
				
				//create session variables for logn info
				$_SESSION["firstName"] = $_POST["firstname"];
				$_SESSION["lastName"] = $_POST["lasttname"];
				$_SESSION["email"] = $_POST["email"];
				$_SESSION["userName"] = $userName;
				//create session variables for logn info
				
				echo("<script>window.location.href = '".$localPath."/front.php';</script>");
			} else {
				echo '<ul class="errorsMsg"><li>Registration failed. Please try again.</li></ul>';
			}
		}
		//save to database
	?>
<?php
	include("includes/footer.php");
?>