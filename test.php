<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php


        $img_r = imagecreatefromjpeg($this->src);
        
        $this->dest = ImageCreateTrueColor( $this->targ_w, $this->targ_h );
        
        imagecopyresampled($this->dest,$img_r,0,0,$x,$y,$this->targ_w,$this->targ_h,$w,$h);
        
        if(imagejpeg($this->dest, $output, $this->jpeg_quality))

?>
