<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//if ($_POST) {
//    define('UPLOAD_DIR', 'uploads/');
//    $img = $_POST['image'];
//    $img = str_replace('data:image/jpeg;base64,', '', $img);
//    $img = str_replace(' ', '+', $img);
//    $data = base64_decode($img);
//    $file = UPLOAD_DIR . uniqid() . '.jpg';
//    $success = file_put_contents($file, $data);
//    print $success ? $file : 'Unable to save the file.';
//}





if(isset($_POST['action']) && $_POST['action']=='upload_and_crop'){
    
    //print_r($_FILES['upload_and_crop_file']);
    require_once dirname(__FILE__).'/classes/Uploader.php';
        
    if(!empty($_FILES['upload_and_crop_file'])){
        $uploader = new Uploader();
        
        //set min/max width/height of image, comment if not required
        $uploader->set_img_max_width(700);
        $uploader->set_img_max_width(700);
        $uploader->set_img_min_width(100);
        $uploader->set_img_min_width(100);
        
        if(isset($_POST['upload_and_crop_dest']) && trim($_POST['upload_and_crop_dest'])!=''){
            $uploader->set_target_dir(trim($_POST['upload_and_crop_dest']));
        }
        if($uploader->upload_file($_FILES['upload_and_crop_file'])){
            echo $uploader->get_uploaded_file_name();
        } else {
            echo "Error: ";
            $uploader->error();
        }
    }
}

?>
