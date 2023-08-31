<?php 
 
$statusMsg = ''; 
$img_err = '';
// File upload directory 
$targetDir = "../uploads/"; 

// Pulling the last created ID from the database (product) and using that ID as the product foreign key
$product_id = mysqli_insert_id($conn);

    if(!empty($_FILES["file"]["name"])){ 
        // Stripping the file name from the submission
        $file_name = basename($_FILES["file"]["name"]); 
    
        // Preparing the path to the uploads file where all user submitted images are stored
        $targetFilePath = $targetDir . $file_name;
      
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
    
        // Allow certain file formats 
        //MIME Type checking needs to be inserted
        $allowTypes = array('jpg','png','jpeg'); 

        //Validating that the image is valid
        if(in_array($fileType, $allowTypes)){ 
        
        // Saving the image to the upload file
        $result = move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
        
        // Upload file to server 
        // Verifying that the file was valid and saved in the upload files otherwise an error will be thrown and nothing
        // will be submitted to the database
        if($result){ 
        $sql = "INSERT INTO images (file_name, product_id) VALUES (?, ?)";
        
        // handles image upload into the database
        // Using mysqli_prepare to clean the data and prevent any sql injections
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "si", $param_file_name, $param_product_id);
                
                // Set parameters
                $param_file_name = $file_name;
                $param_product_id = $product_id;      
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Records created successfully. Redirect to landing page
                    header("location: ../index.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }else{
            echo "eek it did not work";
        }
    } else {
        $img_err = "Please enter a valid file type .jpg .png .jpeg";
    }
}
 
// Display status message 
echo $statusMsg; 
return $img_err;


?>