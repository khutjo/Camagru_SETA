<?php
$errors = 0;

include "../config/connection.php";
if (!isset($_SESSION['TechCOM']) && !isset($_SESSION['user_loged_in']) && $_SESSION['TechCOM'] != 'its_on'){
    echo "<script>window.close();</script>";
    header("location:../index.php");
}

class upload_file extends connection {
    function upload_pic ($target_file){
        $sql = "INSERT INTO user_database.media (userlink, comment_tag, likes, dislikes, image_src) VALUE (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([1, 1, 100, 0, base64_encode(file_get_contents($target_file))]);
        unlink($target_file);
    echo "<script type='text/javascript'>alert('picture uploaded');</script>";        
    }
}

if (isset($_POST['logout']) &&$_POST['logout'] == "LOGOUT"){
    unset($_SESSION['TechCOM']);
    echo "<script>window.close();</script>";
    header("location:../index.php");
}


if (isset($_POST['submit']) && $_POST['submit'] == "Upload Image"){
        $target_dir = "../media/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
            $connect = new upload_file ($dsn, $user, $password);
            $dest = imagecreatefromjpeg($target_file);
            $src = imagecreatefromjpeg("../media/");
            imagecopymerge($dest, $src, 10, 10, 0, 0, 100, 47, 75);
            imagedestroy($src);
        }
        else {echo "its me<br />";
        print_r($_FILES["fileToUpload"]);
        }
}

?>
<html>
<head>
<link rel="shortcut icon" type="image/x-icon" href="../web_logo.png" />
<link rel="stylesheet" href="../CSS/main_page_style.css">
</head>
<body class="picture_time">
<div class="top_div">
    <img class="home_logo" src="../web_logo.png" alt="home">
    <b style="font-family: Arial, Helvetica, sans-serif; font-size: 56px; color: white;">CAM A GROUX</b>
    <div class="logout_form_div">
    <form method="post">
    <input class="logout_buttom" type="submit" name="logout" value="LOGOUT" >
    </form>
    </div>
</div>
<div class="pic_div">
<?php echo $target_file;?>

</div>
</body>
<html>