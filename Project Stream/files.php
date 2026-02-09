<?php
include("includes/config.php");
include("includes/chk-session.php");
include('includes/connect.php');
include("includes/top-member.php");
$pageTitle = "All Files | Unite For Education";
$mainClass = " fontPage";
include("includes/header.php");
?>
<div class="pgSize">
	<div class="allFiles">
		<h2>All files uploaded by students...</h2>

		<table class="files">
			<tr>
				<th>Sr #</th>
				<th>File Name</th>
				<th>Type</th>
				<th>Uploaded By</th>
				<th>Action</th>
			</tr>

			<?php
			$queryfiles = "SELECT * FROM tblfiles ORDER BY fileid DESC";
			$resultfiles = $link->query($queryfiles);

			if ($resultfiles && $resultfiles->num_rows > 0) {

				$num = 1;

				while ($rowsFiles = $resultfiles->fetch_array(MYSQLI_ASSOC)) {

					// Safe filename extract
					$fileName = $rowsFiles["filename"] ?? "";
					if (trim($fileName) == "") {
						$fileName = "unknown-file";
					}

					// Safe user extract
					$userid = isset($rowsFiles["userid"]) ? (int)$rowsFiles["userid"] : 0;

					$uFirst = "Unknown";
					$uLast  = "";

					if ($userid > 0) {
						$queryInner = "SELECT memberfirstname, memberlastname 
                                       FROM tblmembers WHERE memberid=" . $userid;
						$resultInner = $link->query($queryInner);

						if ($resultInner && $resultInner->num_rows > 0) {
							$rowsInner = $resultInner->fetch_array(MYSQLI_ASSOC);
							$uFirst = $rowsInner["memberfirstname"] ?? "Unknown";
							$uLast  = $rowsInner["memberlastname"] ?? "";
						}
					}

					// Extract file extension safely
					$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
					if ($ext == "") {
						$ext = "unknown";
					}

					// Normalize extensions
					if ($ext == "docx") {
						$ext = "doc";
					}
					if ($ext == "xlsx") {
						$ext = "xlxs";
					}

					// Build file icon / image
					if (in_array($ext, ["jpg", "jpeg", "png", "gif"])) {
						$img = '<img src="' . $localPath . '/posts/files/' . $fileName . '" />';
					} else {
						// Normalize extension names
						if ($ext == "docx") $ext = "doc";
						if ($ext == "xlsx") $ext = "xlsx";

						// Generate image path
						$iconUrl = $localPath . "/images/files-icons/" . $ext . ".jpg";
						$fallbackUrl = $localPath . "/images/files-icons/default.jpg";

						// Use fallback if icon missing
						$img = '<img src="' . $iconUrl . '" onerror="this.onerror=null;this.src=\'' . $fallbackUrl . '\';" alt="' . $ext . '" />';
					}




					echo ('
                        <tr>
                            <td>' . $num . '</td>
                            <td>' . $fileName . '</td>
                            <td class="img">' . $img . '</td>
                            <td>' . $uFirst . ' ' . $uLast . '</td>
                            <td><a href="' . $localPath . '/posts/files/' . $fileName . '" target="_blank">Download</a></td>
                        </tr>
                    ');

					$num++;
				}
			} else {
				echo '<tr><td colspan="5" style="text-align:center; padding:20px;">No files uploaded yet.</td></tr>';
			}
			?>

		</table>
	</div>
</div>

<?php include("includes/footer.php"); ?>