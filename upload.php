<?php
// 如果接收到了上传的文件
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = $_SESSION['uid'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Olay</title>
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta name="App-Config" content="fullscreen=yes,useHistoryState=yes,transition=yes">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <link href="./assets/style.css" rel="stylesheet" type="text/css">
    <link href="./assets/upload.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  <div class="container upload">
    <div class="headbar">
        <p class="h1">FOR THE MOST ACCURATE SKIN ANALYSIS</p>
    </div>

    <div class="list">
        <form method="post" id='photo_form' enctype='multipart/form-data' action="report.php">
        <ol>
            <li class="list0"> Take first photo
            <input style='' class="upload" type='file' name='photo1' id='photo1' value='' />
            </li>

            <li class="list1"> Take second photo
            <input style='' class="upload" type='file' name='photo2' id='photo2' value='' />
            </li>

            <li class="list2"> Fire
            <button class="upload" id='start'>Start Analysis</button>
            </li>
        </ol>


        </form>
    </div>
</div>
<div id='uploading' class='uploading'>
    <div id='uploadingText'>
        Uploading ...
    </div>
</div>
<iframe name='iframe' id='iframe' border='0' style='border: 0px;'></iframe>
<script type='text/javascript' src='assets/jquery-3.2.1.min.js'></script>
<script type='text/javascript'>
$(function () {
    $('#photo_form').submit(function () {
        $('#uploading').show();
    })
});
</script>
  </body>
</html>
