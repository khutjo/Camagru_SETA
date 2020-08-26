<?php

include "../config/new_account.php";
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['TechCOM']) && !isset($_SESSION['user_loged_in']) && $_SESSION['TechCOM'] != 'its_on'){
  echo "<script>window.close();</script>";
  header("location:../index.php");
}

if (!isset($_SESSION['img_time_stamp'])){
$_SESSION['img_time_stamp'] = time();
}

if (isset($_SESSION['image_up']) && $_SESSION['image_up'] == "success"){
  echo "<script type='text/javascript'>alert('image upload success');</script>";
  unset($_SESSION['image_up']);
}
else if (isset($_SESSION['image_up']) && $_SESSION['image_up'] == "it failed"){
  echo "<script type='text/javascript'>alert('image upload failed(",$_SESSION['it failed were'],")');</script>";
  unset($_SESSION['image_up']);
}
    
if (!file_exists ("../media/test".$_SESSION['user_loged_in'].$_SESSION['img_time_stamp'].".png")){
  copy("../media/resource/temp_user_img.png", "../media/test".$_SESSION['user_loged_in'].$_SESSION['img_time_stamp'].".png");
}
?>
<html>

<head>
    <link rel="shortcut icon" type="image/x-icon" href="../web_logo.png" />
    <link rel="stylesheet" href="../CSS/nope_inc.css">
</head>

<body class="home_screen_background">
    <nav>
        <div class="top_div">
            <a href="main_page.php"><img class="home_logo" src="../web_logo.png" alt="home"></a>
            <div>

                <div class="dropdown">
                    <button class="dropbtn"><?php echo $_SESSION['user_loged_in'];?></button>
                    <div class="dropdown-content">
                        <a href="main_page.php">Home</a>
                        <a href="../config/logout.php">Logout</a>
                        <a href="account_settings.php">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div style="height: 540px; width: 900px; margin: 20px auto;">
        <div
            style="height: 1060px; width: 640px; border-radius: 10px; background: rgba(0, 0, 0, 0.489);margin: 20px auto; float: left;">
            <form action="../config/prepare_upload.php" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input style="display: none;" name="sticker_used" id="get_sticker" value="">
                <input type="submit" value="Upload Image" name="submit" onclick="submit_it()">
            </form>
            <video id="video" height="458px" width="600px" style="margin:13px 20px;" autoplay></video>
            <button id="snap" style="margin: 0px auto;">Snap Photo</button>
            <button id="upload_butt" style="" onclick="upload_image()">upload</button>
            <img id="preview" style="height: 480px; width: 600px; margin: 20px 20px;"
                src='../media/test<?php echo $_SESSION['user_loged_in'].$_SESSION['img_time_stamp'];?>.png' alt="just">
            <canvas id="stickers" height="190" width="255" style="margin: -1040px 20px;"></canvas>
        </div>
        <div
            style="height: 520px; width: 240px; border-radius: 10px; background: rgba(0, 0, 0, 0.489);float: right; margin: 20px auto; overflow-y: scroll;">
            <img style="margin: 5px 15px; height:190; width:190;" onclick="emoji0_set()" src="../stickers/emoji0.png"
                alt="sticker">
            <img style="margin: 5px 15px; height:190; width:190;" onclick="emoji1_set()" src="../stickers/emoji1.png"
                alt="sticker">
            <img style="margin: 5px 15px; height:190; width:190;" onclick="emoji2_set()" src="../stickers/emoji2.png"
                alt="sticker">
            <img style="margin: 5px 15px; height:190; width:190;" onclick="emoji3_set()" src="../stickers/emoji3.png"
                alt="sticker">
            <img style="margin: 5px 15px; height:190; width:190;" onclick="emoji4_set()" src="../stickers/emoji4.png"
                alt="sticker">
        </div>
        <div>
            <div class="bottom_div_bar">
                <script src="../inc_js/hcamera_file.js"></script>
                <img style="margin: 100px 0px;width: 600px; height:600px; display: none; " id="canvasImg" alt='yes'>
                <canvas id="canvas" style="display: none;" width="600px" height="600px"></canvas>
            </div>
        </div>
        <div style="height: 520px; width: 240px; border-radius: 10px; background: rgba(0, 0, 0, 0.489);float: right; margin: 20px auto; overflow-y: scroll;">
            <?php $my_details = new get_my_pictures_from_database($dsn, $user, $password);
              foreach ($my_details->my_pictures as $old_photos){
                echo '<img style="height: 200px; width: 200px; margin: 10px;" src="data:image/jpeg;base64,'.$old_photos[4].'" alt="preview">'; 
              } ?>
            

        </div>
</body>

</html>