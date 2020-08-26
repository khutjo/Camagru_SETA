<?php
include "connection.php";

if (!isset($_SESSION))
    session_start();


$_SESSION['img_time_stamp'] = time();

$target_filer = "../media/test".$_SESSION['user_loged_in'].$_SESSION['img_time_stamp'].".png";
$target_dir = "../media/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $_SESSION['image_up'] = "it failed";
        $_SESSION['it failed were'] = 1;
        header("location:../pages/nope.php");
        $uploadOk = 0;
    }
}
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $_SESSION['image_up'] = "it failed";
    $_SESSION['it failed were'] = 2;
    header("location:../pages/nope.php");
    $uploadOk = 0;
}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $_SESSION['image_up'] = "it failed";
    $_SESSION['it failed were'] = 3;
    header("location:../pages/nope.php");
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    $_SESSION['image_up'] = "it failed";
    header("location:../pages/nope.php");
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_filer)) {
        $_SESSION['image_up'] = "success";
    } else {
        $_SESSION['image_up'] = "it failed";
        $_SESSION['it failed were'] = 5;
        header("location:../pages/nope.php");
    }
}

$stickercoded = base64_decode($_POST["sticker_used"]);
file_put_contents("../stickers/temp.png", $stickercoded);

$dest = imagecreatefrompng("media/test".$_SESSION['user_loged_in'].$_SESSION['img_time_stamp'].".png");
$src = imagecreatefrompng("../stickers/temp.png");

$width = ImageSx($src);
$height = ImageSy($src);
$x = $width;
$y = $height;

ImageCopyResampled($dest,$src,0,0,0,0,$x,$y,$width,$height);

header('Content-Type: image/jpeg');
imagepng($dest, "../media/test".$_SESSION['user_loged_in'].$_SESSION['img_time_stamp'].".png");

imagedestroy($dest);
imagedestroy($src);
unlink("../stickers/temp.png");
header("location:../pages/nope.php");
?>