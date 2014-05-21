<?php
	if (count($_POST) > 0)
	{
		$response = array();
		$brand = $_POST['brand'];
		$filename = $_POST['filename'];
		$path = "../".$brand;
		clearstatcache();
		if (file_exists($path."/".$filename))
		{
			$response["code"] = 101;
			$response["msg"] = "File with this brand and file name already exists.";
		}else
		{
			if(!(file_exists($path) && is_dir($path)))
			{
				mkdir($path);
			}
			if ($_FILES["file"]["error"] > 0)
    		{
    			$response["code"] = 102;
				$response["msg"] = "File upload error ".$_FILES["file"]["error"];
			}else
			{
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $path."/".$filename))
				{
					$response["code"] = 0;
					$response["msg"] = "Upload completed";
				}else
				{
					$response["code"] = 100;
					$response["msg"] = "Could not upload";
				}
				
			}
		}
		echo json_encode($response);
	}else
	{
		?>
			<form method="post" enctype="multipart/form-data">
				<input name="brand"/>
				<input name="filename"/>
				<input id="file" type="file" name="file"> 
				<input type="submit" value="upload"/>
			</form>
		<?php
	}
?>
