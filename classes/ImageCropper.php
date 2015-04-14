<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageCropper
 *
 * @author danish
 * @email dasatti@gmail.com
 * @skype dasatti
 */
class ImageCropper {
    //put your code here
    
    private $src = "";
    
    private $dest;
    
    private $output = "";
    
    public $targ_w = 300;
    
    public $targ_h = 300;
    
    private $quality = 90;
    
    private $format =2; //1=gif,2=jpg,3=png,6=bmp
    
    private $path_to_dest = "";
    
    public $delete_src = true;


    /**
     * 
     * @param type $width width of output image
     * @param type $height height of output image
     */
    public function setCropSize($width,$height){
        $this->targ_w = $width;
        $this->targ_h = $height;
    }
    
    /**
     * 
     * @return type array
     * description: return array with width and height of output image
     */
    public function getCropSize(){
        return array('width'=>  $this->targ_w,'height'=>  $this->targ_h);
    }
    
    /**
     * 
     * @param type $quality
     * description: set quality for jpg
     */
    public function setQuality($quality){
        if($quality>0 && $quality<=100) $this->quality = $quality;
    }
    
    /**
     * 
     * @return type get current quality for jpg
     */
    public function getQuality(){
        return $this->quality;
    }
    
    public function setPathToDest($path){
        $this->path_to_dest = $path;
    }
    
    public function getpathToDest(){
        return $this->path_to_dest;
    }
    
    /**
     * 
     * @param type $src path of input image
     * @param type $output path of output image
     * @param type $x crop start x
     * @param type $y crop start y
     * @param type $w width of cropped image
     * @param type $h height of cropped image
     * @return boolean
     */
    public function crop($src, $output, $x, $y, $w, $h){
        //print_r(func_get_args());die;
        $this->src = $src;
        $this->output = $output;
        
        $img_r = $this->imageCreate($this->path_to_dest.$this->src);
        $this->dest = ImageCreateTrueColor( $this->targ_w, $this->targ_h );
        imagecopyresampled($this->dest,$img_r,0,0,$x,$y,$this->targ_w,$this->targ_h,$w,$h);
      
        //$this->dest = ImageCreateTrueColor( 100, 100 );
        //imagecopyresampled($this->dest,$img_r,0,0,$x,$y,100,100,100,100);
        //bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
        
        
        if($this->saveImage($this->output)){
            if($this->delete_src){
                unlink($this->path_to_dest.$this->src);
            }
                return true;
        }
        else return false;
        
    }
    
    /**
     * 
     * @return type string
     * description : return path of output image
     */
    public function getCroppedImage(){
        return $this->output;
    }
    
    /**
     * 
     * @param type $src
     * @return boolean
     */
    private function imageCreate($src){
        $this->format = exif_imagetype($src);
        $allowedTypes = array(1,2,3,6);
        if (!in_array($this->format, $allowedTypes)) { 
            return false; 
        }
        
        switch ($this->format){
            case 1:
                $im = imageCreateFromGif($src); 
                break;
            case 2:
                $im = imageCreateFromJpeg($src);
                break;
            case 3:
                $im = imageCreateFromPng($src); 
                break;
            case 6:
                $im = imageCreateFromBmp($src);
                break;
        }
        
        return $im;
    }
    
    /**
     * 
     * @param type $output
     * @return boolean
     */
    private function saveImage($output){
        
        // Save GIF
        if($this->format == 1) {
            if(imageGIF($this->dest, $this->path_to_dest.$output)) return true;
            return false;
        }
        // Save JPEG
        elseif($this->format == 2) {
            if(imageJPEG($this->dest, $this->path_to_dest.$output, $this->quality)) return true;
            else return false;
        }
        // Save PNG
        elseif($this->format == 3) {
            if(imagePNG($this->dest, $this->path_to_dest.$output)) return true;
            else return false;
        }
        // Save WBMP
        elseif($this->format == 6) {
            if(imagewbmp($this->dest, $this->path_to_dest.$output)) return true;
            else return false;
        }

        
        else return false;
    }
    
}

?>
