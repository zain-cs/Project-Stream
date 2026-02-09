<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	// Set default path if not defined
	if (!isset($localPath)) {
		$localPath = ".";
	}
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo ($localPath); ?>/styles/styles.css" />
	<script type="text/javascript" src="<?php echo ($localPath); ?>/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="<?php echo ($localPath); ?>/js/function.js"></script>
	<title><?php echo (isset($pageTitle) && $pageTitle != "" ? $pageTitle : "") ?></title>
</head>

<body>
	<div class="header">
		<div class="pgSizeHeader">
			<a href="front.php" class="logo">Project Stream</a>

			<?php
			if (isset($_SESSION["email"]) && $_SESSION["email"] != "" && isset($_SESSION["userName"]) && $_SESSION["userName"] != "") {
				echo ('
                <div class="topMemSec" title="Member Section">
                    <div class="memberSignIn">
                        <span class="welcome-text">Hi, ' . $_SESSION["firstName"] . '</span>
                        <a id="icon" href="javascript:;">' . memberPicture($_SESSION["userPicture"], $_SESSION["userName"]) . '</a>
                    </div>
                    <div class="dropDown">
                        <ul>
                            <li><a href="dashboard.php">Dashboard</a></li> <li><a href="mailto:' . $_SESSION["email"] . '">' . $_SESSION["email"] . '</a></li>
                            <li><a href="sign-out.php" class="logout">Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            ');
			}
			?>
		</div>
	</div>
	<div class="mainCnts<?php echo (isset($mainClass) && $mainClass != "" ? $mainClass : ""); ?>"><!--main Contents-->