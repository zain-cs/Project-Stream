<?php
	$fileErrors = 0;
	$filename = '';
	$uploadFileType = '';
	$myFullPath = $baseValue;
	
	if(isset($_FILES[$myFileFeild])){
		$myFile = $_FILES[$myFileFeild];
		
		// Check for upload errors
		if($myFile['error'] !== UPLOAD_ERR_OK){
			echo '<ul class="errorsMsg"><li>Upload error code: '.$myFile['error'].'</li></ul>';
			$fileErrors = 1;
			exit();
		}
		
		$filename = stripslashes($myFile['name']);
		$filename = basename($filename); // FIXED: Security - remove path info
	}//endif

	if($filename){//if file submitted
		$extensionEx = explode(".",$filename);
		$extension  = strtolower(end($extensionEx));
		
		// Normalize extensions
		if($extension == "jpeg")
			$extension = "jpg";	
		
		// Image files
		if($extension=="jpg" || $extension=="png" || $extension=="gif" || $extension=="webp" || $extension=="bmp" || $extension=="svg"){
			$uploadFileType = 'Image';
		}

		// Document and Archive files
		if($extension=="xls" || $extension=="xlsx" || $extension=="xlxs" || 
		   $extension=="doc" || $extension=="docx" || 
		   $extension=="ppt" || $extension=="pptx" ||
		   $extension=="zip" || $extension=="rar" || $extension=="7z" ||
		   $extension=="txt" || $extension=="cpp" || $extension=="pdf"){
			$uploadFileType = 'File';
		}

		// Audio files
		if($extension=="mp3" || $extension=="wav" || $extension=="ogg" || $extension=="m4a" || $extension=="aac"){
			$uploadFileType = 'Audio';
		}

		// Video files
		if($extension=="mp4" || $extension=="mov" || $extension=="avi" || $extension=="webm" || $extension=="mkv" || $extension=="flv"){
			$uploadFileType = 'Video';
		}

		
		if($uploadFileType==""){
			echo '<ul class="errorsMsg"><li>Unknown extension ('.$extension.')! 
			<br><strong>Allowed types:</strong>
			<br>• Images: jpg, png, gif, webp, bmp, svg
			<br>• Documents: doc, docx, xls, xlsx, ppt, pptx, pdf, txt, cpp
			<br>• Archives: zip, rar, 7z
			<br>• Audio: mp3, wav, ogg, m4a, aac
			<br>• Video: mp4, mov, avi, webm, mkv, flv
			</li></ul>';
			$fileErrors = 1;
		}else{
			// FIXED: Create full upload path
			$fullUploadPath = $myFullPath.$upFilePath;
			
			// FIXED: Check if folder exists, create if not
			if(!is_dir($fullUploadPath)){
				if(!mkdir($fullUploadPath, 0755, true)){
					echo '<ul class="errorsMsg"><li>Failed to create directory: '.$fullUploadPath.'</li></ul>';
					$fileErrors = 1;
					exit();
				}
			}
			
			// FIXED: Use move_uploaded_file instead of copy
			$destinationPath = $fullUploadPath."/".$filename;
			$moved = move_uploaded_file($myFile['tmp_name'], $destinationPath);
			
			if(!$moved){
				echo '<ul class="errorsMsg"><li>Upload unsuccessful! Could not move file to: '.$destinationPath.'</li></ul>';
				echo '<ul class="errorsMsg"><li>Check folder permissions (should be 0755 or 0777)</li></ul>';
				$fileErrors = 1;
				exit();
			}//endif moved
		}//end if unknown extension
	}//end if file submitted
	
	if($fileErrors==1)
	   exit();
	//endif
?>