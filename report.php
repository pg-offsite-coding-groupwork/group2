<?php
session_start();

require './library/azure.php';
require './library/upload.php';

// save your uploaded photo
$photo1Url = Upload::save($_FILES['photo1']);
$photo2Url = Upload::save($_FILES['photo2']);

// use Azure's api to detect face
$requestBody = <<<EOF
{
    "url":"{$photo1Url}"
}
EOF;

$rs = Azure::POST('https://api.cognitive.azure.cn/face/v1.0/detect', $requestBody);
// 如果要调试这个接口的返回值，请将下面一行取消注释
// echo '<hr />';var_dump($rs);echo '<hr />';exit;
$faceId1 = $rs[0]['faceId'];

$requestBody = <<<EOF
{
    "url":"{$photo2Url}"
}
EOF;
$rs = Azure::POST('https://api.cognitive.azure.cn/face/v1.0/detect', $requestBody);
// 如果要调试这个接口的返回值，请将下面一行取消注释
// echo '<hr />';var_dump($rs);echo '<hr />';exit;
$faceId2 = $rs[0]['faceId'];

// try to find a similar person in face list
$requestBody = <<<EOF
{    
    "faceId1":"{$faceId1}",
    "faceId2":"{$faceId2}"
}
EOF;
$rs = Azure::POST('https://api.cognitive.azure.cn/face/v1.0/verify', $requestBody);
// 如果要调试这个接口的返回值，请将下面一行取消注释
// echo '<hr />';var_dump($rs);echo '<hr />';exit;
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
    <link href="./assets/report.css" rel="stylesheet" type="text/css">
    <style>

    </style>    
  </head>
  <body>
    <div class="container report">
        <div class="report-head">
            <div class="twophoto">
                <div class="age-presenter">
                    <img class="uploaded" src='<?php echo $photo1Url;?>' alt='' />
                </div>
                <div class="age-presenter">
                    <img class="uploaded" src='<?php echo $photo2Url;?>' alt='' />
                </div>
            </div>

            <?php
            $msg = '';
            switch ($rs['resultCode']) {
                case 400:
                    $msg = $rs['response'];
                    break;
            }
            ?>
            <?php
            if ($msg !== '') {
            ?>
            <p class="text text-view intro"><?php echo $msg;?></p>  
            <?php
            } else {
            ?>
            <p class="text text-view intro">Same Person ?: <?php echo $rs['isIdentical'] ? 'YES' : 'NO';?></p> 
            <p class="text text-view intro">Confidence: <?php echo $rs['confidence'];?></p> 
            <?php
            }
            ?>
        </div>

        <div class="buttons">
            <button class="myproducts" onclick="window.location='index.php';">Retake Analysis</button>
        </div>
    </div>
 
  </body>
</html>
