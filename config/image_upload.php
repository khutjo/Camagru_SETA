<?php

include "connection.php";

class Image_upload extends connection{
    private $image;
    public $errors = 0;
    
    function verify_image (){
        if (is_uploaded_file($_FILES['fileToUpload']['tmp_name']) && $image = getimagesize($_FILES["fileToUpload"]["tmp_name"]) &&
        $_FILES["fileToUpload"]["size"] < 500000 && $_FILES["fileToUpload"]["error"] == 0){
            $file_type = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
            if ($file_type == 'jpeg' || $file_type == 'png' || $file_type == 'jpg' || $file_type == 'gif'){
                
            }$this->$errors = 2;
        }
        else{
            $this->$errors = 1;
        }
    }

    function upload_image (){
        $sql = "INSERT INTO user_database.media (userlink ,likes ,unlikes, image_src) VALUE (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['picture', 0, 0, $target_file]);
    }   
}



function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen( $output_file, 'wb' ); 
    $data = explode( ',', $base64_string );
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    fclose( $ifp ); 
    return $output_file; 
}
?>
