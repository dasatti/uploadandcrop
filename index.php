<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--<script src="assets/jcrop/js/jquery.min.js"></script>-->
<script src="assets/jquery-1.11.0.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

    </head>
    <body>
        <?php
        // put your code here
        ?>
        
        <form method="post" action="" enctype="multipart/form-data" name="file_form">
            <input type="hidden" name="handleUpload" value="1">
            
            <label>Thumbnail: </label><input type="file" name="thumbnail" id="thumbnail"  onChange="uploadAndCrop();" accept="image/*"> 
        </form>
        
        <div>
            <div id="upload_error"></div>
            <img src=""  style="max-width: 200px; max-height: 200px;" id="final_thumbnail">
            <input type="hidden" name="change_thumb" id="change_thumb" value="0">
            <input type="hidden" name="cropped_thumbnail" id="cropped_thumbnail" value="">
        </div>
        
       <?php
        include "crop_modal.php";
       ?>
        
    </body>
</html>



