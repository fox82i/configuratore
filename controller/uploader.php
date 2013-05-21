<?php
/***   Script from:   http://www.coursesweb.net/ajax/   ***/

$updir = '../Upload_file/';		// Directory for uploads
$max_size = 150480;			// Sets maxim size allowed for the uploaded files, in kilobytes --- 20MBYTE AL MOMENTO

// sets an array with the file types allowed
$file_type = array('application/vnd.ms-excel [official]', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/excel', 'application/download','text/plain');
$allowedExts=array('xls','txt');

// if the folder for upload (defined in $updir) doesn't exist, tries to create it (with CHMOD 0777)
if (!is_dir($updir)) mkdir($updir, 0777);

/** Loading the files on server **/

$result = array();          // Array to store the results and errors

// if receive a valid file from server
if (isset ($_FILES['file_up'])) {
  // checks the files received for upload
  for($f=0; $f < count($_FILES['file_up']['name']); $f++) {
    $fup = $_FILES['file_up']['name'][$f];       // gets the name of the file
    // checks to not be an empty field (the name of the file to have more then 1 character)
    if(strlen($fup)>1) {
      // checks if the file has the extension type allowed
      $type = end(explode('.', $_FILES['file_up']['name'][$f]));
	  
      if (in_array($type, $allowedExts) && in_array($_FILES["file_up"]["type"][$f],$file_type)) {
        // checks if the file has the size allowed
        if ($_FILES['file_up']['size'][$f]<=$max_size*1000) {
          // If there are no errors in the copying process
          if ($_FILES['file_up']['error'][$f]==0) {
            // Sets the path and the name for the file to be uploaded
           // $thefile = $updir . '/' . $fup;
            // If the file cannot be uploaded, it returns error message
            if (!move_uploaded_file ($_FILES['file_up']['tmp_name'][$f],$updir. $fup)) {
              $result[$f] = ' The file could not be copied, try again';
            }else {
              // store the name of the uploaded file
              $result[$f] = '<strong>'.$fup.'</strong> - OK';
            }
          }
        }else { 
			$result[$f] = 'The file <strong>'. $fup. '</strong> exceeds the maximum allowed size of <i>'. $max_size. 'KB</i>'; 
		}
      }else { 
		$result[$f] = 'File type extension <strong>.'. $type. '</strong> is not allowed or file type unknow'; 
	  }
    }
  }

   // Return the result
  $result2 = implode('<br /> ', $result);
  print_r ($result2);
  if ($result2){
	echo '<h4>Files uploaded:</h4> '.$result2;
	}else{
	echo "<h4><strong>Nothing to do...</strong></h4>";
	}
}else{	
	echo "<h4><strong>No file recived...</strong></h4>";
}
?>