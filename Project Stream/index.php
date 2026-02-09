<?php
	include("includes/chk-session.php");	
	include("includes/config.php");
	//if alresy login
	if(isset($_SESSION["email"])&&$_SESSION["email"]<>""&&isset($_SESSION["userName"])&&$_SESSION["userName"]<>""){
		echo("<script>window.location.href = '".$localPath."/front.php';</script>");
	}
	//if alresy login
	
	include('includes/connect.php');
	$pageTitle = "Sign Up | Unite For Education";
	include("includes/header.php");
	
	$errorC = '';
	$errors = '';
?>
	<?php
    	if(isset($_POST["submit"])){
			$email = $link->real_escape_string($_POST["email"]);
			$password = $_POST["password"];
			
			$sqlQuery = "SELECT memberid,memberfirstname,memberlastname,memberusername,memberemail,memberpassword from tblmembers where memberemail='".$email."' limit 1";
			$sqlResults = $link->query($sqlQuery);
			$sqlNumRows = $sqlResults->num_rows;
			if($sqlNumRows>0){//that means user exists
				$row = $sqlResults->fetch_array(MYSQLI_ASSOC);
				if($row["memberpassword"]==$password){
					$_SESSION["firstName"] = $row["memberfirstname"];
					$_SESSION["lastName"] = $row["memberlastname"];
					$_SESSION["email"] = $row["memberemail"];
					$_SESSION["userName"] = $row["memberusername"];
					echo("<script>window.location.href = '".$localPath."/front.php';</script>");
				}else{
					$errors = "<li>Emial or Password is icorrect</li>";
					$errorC = "error";
				}//if not matched
			}else{//if not exists
				$errors = "<li>Emial or Password is icorrect</li>";
				$errorC = "error";
			}
		}//if submitted
	?>
	<div class="pgSize">
    	<h1>Sign In</h1>
    	<div class="leftSec">
			<?php
				if($errors<>''){
					echo('
						<ul class="errorsMsg">'.$errors.'</ul>
					');
				}
			?>
            <form method="post" action="">
            	<label class="<?php echo(isset($errorC)?$errorC:""); ?>">Email*:</label>
                <input type="text" name="email" value="<?php echo(isset($_POST["email"])?$_POST["email"]:"");?>" />
                <div class="sep"></div>
                <label class="<?php echo(isset($errorC)?$errorC:""); ?>">Password*:</label>
                <input type="password" name="password" value="<?php echo(isset($_POST["password"])?$_POST["password"]:"");?>" />
                <div class="sep"></div>
                <input type="submit" name="submit" value="Login" />
                <p class="note">If you have no account <a href="register.php">Register Free</a></p>
            </form>
        </div>
        <div class="rightSec">
        	<img src="images/sign-up-right.jpg" />
        </div>
    </div>
<?php
	include("includes/footer.php");
?>
