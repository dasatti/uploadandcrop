<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['action']) && $_POST['action']=='handle_crop'){
    
    require_once dirname(__FILE__).'/classes/ImageCropper.php';
        
    $cropper = new ImageCropper();
    $src_a = explode(".",$_POST['src']);
    $ext = array_pop($src_a);
    $output = implode(".", $src_a)."_tn.".$ext;
    if(isset($_POST['path_to_dest']) && trim($_POST[''])!='path_to_dest'){
        $cropper->setPathToDest(trim($_POST['path_to_dest']));
    }
    if($cropper->crop($_POST['src'], $output, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'])){
        echo $cropper->getCroppedImage();
    } else {
        echo "error";
    }
    
}
?>
