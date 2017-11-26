<?php
	header('Content-Type: application/json');
	if ($_SERVER['REQUEST_METHOD'] != "POST")  {
		echo set_error_response(400, 'Bad Request');
		exit();	
	}

	/*
	 *	Save Video To DB
 	*/
	$data = $_FILES["photo"];
	$msg = '';

	if ( !isset($_POST['token'])) {
		// todo validate token...
	 	echo set_error_response(403, 'Unauthorized');
	 	exit();
	}

	// Save thumbnail locally 
	if(isset($data) && $data["error"] == 0){
      $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
      $filename = $data["name"];
      $filetype = $data["type"];
      $filesize = $data["size"];
  
      // Verify file extension
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
  
      // Verify file size - 5MB maximum
      $maxsize = 1 * 1024 * 1024;
      if($filesize > $maxsize) {
      	$resp = array(
        	'message' => "Filesize too large."
        );
        http_response_code(400);
        echo json_encode($resp);
      } else {
	      // Verify MYME type of the file
	      if(in_array($filetype, $allowed)){
	          // Check whether file exists before uploading it
	          if(file_exists("public/assets/logos/" . $data["name"])){
	        	 	$resp = array(
			        	'message' => $data["name"] . " is already exists."
			        );
			        http_response_code(400);
			        echo json_encode($resp);
	          } else{
	            move_uploaded_file($data["tmp_name"], "public/assets/logos/" . $data["name"]);
	            $entry = array(
	            	'logo' => $data['name'],
	            	'title' => $_POST['title'],
	            	'url' => $_POST['url'],
	            	'active' => true
	            );
							$save = save_to_db('partners', $entry);
	            $save['message'] = "Your file was uploaded successfully. Refresh page to see updated logo list below.";
							http_response_code($save['status']);
							echo json_encode($save);
	          } 
	      } else{
	        $resp = array(
	        	'message' => "Error: There was a problem uploading your file. Please try again."
	        );
	        http_response_code(400);
	        echo json_encode($resp);
	      }
	    }
  } else{
    http_response_code(400);
		$resp = array(
    	'message' => "Error: Please make sure the form is complete (error code " . $data["error"] . ")."
    );
    echo json_encode($resp);
  }

	exit();