<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// IMPORTANT: connect.php should already be included in parent file
// If not, uncomment the line below:
// include("connect.php");

if (
    isset($_SESSION["email"]) && $_SESSION["email"] !== "" &&
    isset($_SESSION["userName"]) && $_SESSION["userName"] !== ""
) {
    // Use prepared statement for safety
    $stmt = $link->prepare("SELECT * FROM tblmembers WHERE memberemail = ? LIMIT 1");
    $stmt->bind_param("s", $_SESSION["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["memid"]       = $row["memberid"];
        $_SESSION["firstName"]   = $row["memberfirstname"];
        $_SESSION["lastName"]    = $row["memberlastname"];
        $_SESSION["email"]       = $row["memberemail"];
        $_SESSION["userName"]    = $row["memberusername"];
        $_SESSION["userPhone"]   = $row["memberphone"];  // FIXED: Was userEmail, should be userPhone
        $_SESSION["userPicture"] = $row["memberpicture"];
    } else {
        // User email exists in session but NOT in database
        session_destroy();
        echo "<script>window.location.href = '" . $localPath . "/';</script>";
        exit;
    }
    
    $stmt->close();
} else {
    // Session variables missing → redirect to login
    echo "<script>window.location.href = '" . $localPath . "/';</script>";
    exit;
}
?>