var canvass = document.getElementById('stickers');
var contexts = canvass.getContext('2d');
var imageObj = new Image();
name = "NULL";
imageObj.onload = function() {
    contexts.drawImage(imageObj, 0, 0, 255, 190);
};

function emoji0_set() {
    contexts.clearRect(0, 0, canvass.width, canvass.height);
    // imageObj.src = 'stickers/emoji0.png';
    name = "NULL";
}

function emoji1_set() {
    imageObj.src = '../stickers/emoji1.png';
}

function emoji2_set() {
    imageObj.src = '../stickers/emoji2.png';

}

function emoji3_set() {
    imageObj.src = '../stickers/emoji3.png';

}

function emoji4_set() {
    imageObj.src = '../stickers/emoji4.png';

}

function submit_it() {
    document.getElementById("get_sticker").value = name;
}

function upload_image() {
    var uploadrequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        uploadrequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            uploadrequest
                = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                uploadrequest
                    = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }
    uploadrequest.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //  window.alert("error");
        }
    };
    //   window.alert("hello");
    uploadrequest.open("post", "../config/upload.php", true);
    uploadrequest.send();

    setTimeout("location.reload(true);", 0);
    // document.location.href = canvas.toDataURL("image/png").replace("image/png", "media/octet-stream");
};

(function() {


    function startup() {

        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var video = document.getElementById('video');
        var mediaConfig = { video: true };

        var errBack = function(e) {
            console.log('An error has occurred!', e)
        };

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia(mediaConfig).then(function(stream) {
                video.srcObject = stream;
                video.play();
                context.drawImage(video, 0, 0, 600, 480);
            });
        } else if (navigator.getUserMedia) { // Standard
            navigator.getUserMedia(mediaConfig, function(stream) {
                video.src = stream;
                video.play();
                context.drawImage(video, 0, 0, 600, 480);
                context.drawImage(imageObj, 0, 0, 255, 190);
            }, errBack);
        } else if (navigator.webkitGetUserMedia) { // WebKit-prefixed
            navigator.webkitGetUserMedia(mediaConfig, function(stream) {
                video.srcObject = stream;
                video.play();
                context.drawImage(video, 0, 0, 600, 480);
                context.drawImage(imageObj, 0, 0, 255, 190);
            }, errBack);
        } else if (navigator.mozGetUserMedia) { // Mozilla-prefixed
            navigator.mozGetUserMedia(mediaConfig, function(stream) {
                video.srcObject = stream;
                video.play();
                context.drawImage(video, 0, 0, 600, 480);
                context.drawImage(imageObj, 0, 0, 255, 190);
            }, errBack);
        }


        document.getElementById('snap').addEventListener('click', function() {
            var ajaxRequest; // The variable that makes Ajax possible!

            try {
                ajaxRequest = new XMLHttpRequest();
            } catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {
                        alert("Your browser broke!");
                        return false;
                    }
                }
            }
            context.drawImage(video, 0, 0, 600, 600);

            var dataURL = canvas.toDataURL("image/png");
            console.log(dataURL);

            document.getElementById('preview').src = dataURL;
            xmlstring = dataURL + ',' + canvass.toDataURL("image/png");
            ajaxRequest.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {}
            };
            ajaxRequest.open("post", "../config/serverTime.php", true);
            ajaxRequest.send(xmlstring);
            setTimeout("location.reload(true);", 0);


        });

    }

    window.addEventListener('load', startup, false);
})();