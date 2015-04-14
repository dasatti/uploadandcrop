<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Uploader
 *
 * @author danish
 * @email dasatti@gmail.com
 * @skype dasatti
 */
class Uploader {
    //put your code here
    
    private $file; //$_FILE from the form
    
    private $uploaded_file;
    
    private $uploadOk = true;
    
    public $allow_only_image = true; //allow only image uploads
    
    public $target_dir = "uploads/"; // where to upload
    
    public $allowed_array = array('jpg','jpeg','png','gif','pdf','txt'); //allowed extension types
    
    public $max_size = 500000; //max file size to upload
    
    public $allow_overwrite = true; //overwrite if file exists
    
    private $debug = array(); //debug data
    
    private $random_name = true; //upload file with random name
    
    private $filename = ""; //filename without path
    
    private $image_info; //metadata for image files
    
    private $max_img_width = 0; //check max image with before upload
    
    private $max_img_height = 0; //check max image height before upload
    
    private $min_img_width = 0; //check min image with before upload
    
    private $min_img_height = 0; //check min image height before upload
    
    private $error="";
    
    
    public function set_target_dir($dir){
        if(trim($dir)!='') $this->target_dir = $dir;
    }
    
    public function get_debug_info(){
        return $this->debug;
    }
    
    public function debug(){
        print_r($this->debug);
    }
    
    public function get_error(){
        return $this->error;
    }
    
    public function error(){
        echo $this->error;
    }
    
    public function get_uploaded_file(){
        return $this->uploaded_file;
    }
    
    public function get_uploaded_file_name(){
        return $this->filename;
    }
    
    public function get_uploaded_file_dir(){
        return $this->target_dir;
    }

    public function set_img_max_width($width){
        $this->max_img_width = $width;
    }
    
    public function get_img_max_width(){
        return $this->max_img_width ;
    }
    
    public function set_img_max_height($height){
        $this->max_img_height=$height;
    }
    
    public function get_img_max_height(){
        return $this->max_img_height;
    }

    public function set_img_min_width($width){
        $this->min_img_width = $width;
    }
    
    public function get_img_min_width(){
        return $this->min_img_width ;
    }
    
    public function set_img_min_height($height){
        $this->min_img_height=$height;
    }
    
    public function get_img_min_height(){
        return $this->min_img_height;
    }


    function upload_file($_file){
        
        $this->file = $_file;
        
        $this->filename = basename($this->file["name"]);
        
        


        $target_file = $this->target_dir . $this->filename;
        $this->uploadOk = 1;
        
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         
        if($this->allow_only_image){
            $check = getimagesize($this->file["tmp_name"]);
            if($check !== false) {
                $this->debug[] = "File is an image - " . $check["mime"] . ".";
                
            } else {
                $this->debug[] = "File is not an image.";
                $this->error = "File is not an image.";
                $this->uploadOk = false;
            }
            
            $this->image_info = getimagesize($this->file["tmp_name"]);
            //print_r($image_info);die;
            
            if($this->max_img_width > 0 && $this->image_info[0]>$this->max_img_width){
                $this->debug[] = "Image width must be smaller than $this->max_img_width px";
                $this->error = "Image width must be smaller than $this->max_img_width px";
                $this->uploadOk = false;
            }
            
            if($this->max_img_height > 0 && $this->image_info[0]>$this->max_img_height){
                $this->debug[] = "Image height must be smaller than $this->max_img_height";
                $this->error = "Image height must be smaller than $this->max_img_height";
                $this->uploadOk = false;
            }
            
            
            if($this->min_img_width > 0 && $this->image_info[0]<$this->min_img_width){
                $this->debug[] = "Image width must be greater than $this->min_img_width";
                $this->error = "Image width must be greater than $this->min_img_width";
                $this->uploadOk = false;
            }
            
            if($this->min_img_height > 0 && $this->image_info[0]>$this->min_img_height){
                $this->debug[] = "Image height must be greater than $this->min_img_height";
                $this->error = "Image height must be greater than $this->min_img_height";
                $this->uploadOk = false;
            }
        }
        
        $dest_file = $target_file;
        
        if($this->random_name){
            $this->filename = md5(rand() * time()).".".$imageFileType;
            $dest_file = $this->target_dir.$this->filename;
        }
        
        // Check if file already exists
        if (!$this->allow_overwrite && file_exists($dest_file)) {
            $this->debug[] = "Sorry, file already exists.";
            $this->error = "Sorry, file already exists.";
            $this->uploadOk = false;
        }
        // Check file size
        if ($this->max_size>0 && $this->file["size"] > $this->max_size) {
            $this->debug[] = "Sorry, your file is too large.";
            $this->error = "Sorry, your file is too large.";
            $this->uploadOk = false;
        }
        // Allow certain file formats
        if(!in_array($imageFileType, $this->allowed_array) ) {
            $this->debug[] = "Sorry, Invalid file type.";
            $this->error = "Sorry, Invalid file type.";
            $this->uploadOk = false;
        }
        // Check if $uploadOk is set to 0 by an error
        if (!$this->uploadOk) {
            //$msg = "Sorry, your file was not uploaded.";
            return false;
        }
        
        // if everything is ok, try to upload file
        
        if (move_uploaded_file($this->file["tmp_name"], $dest_file)) {
            $this->uploaded_file = $dest_file;
            $this->debug[]= "The file ". basename( $this->file["name"]). " has been uploaded.";
            return true;
        } else {
            $this->debug[] = "Sorry, there was an error uploading your file.";
            $this->error = "Sorry, there was an error uploading your file.";
            return false;
        }
        
    }
    
    
    
    
}

?>
