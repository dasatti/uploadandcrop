
<script src="assets/jcrop/js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="assets/jcrop/css/jquery.Jcrop.css" type="text/css" />
<link rel="stylesheet" href="assets/style.css" type="text/css" />

<script>
    
    var jcrop_api, boundx, boundy,
        // Grab some information about the preview pane
        $preview, $pcnt, $pimg, xsize, ysize;
        
    $(document).ready(function(){
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),

        xsize = $pcnt.width(),
        ysize = $pcnt.height();
    });
        
    function updatePreview(c)
    {
      if (parseInt(c.w) > 0)
      {
        var rx = xsize / c.w;
        var ry = ysize / c.h;

        $pimg.css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
      }
    };
    
    function checkCoords()
    {
      if (parseInt($('#w').val())) return true;
      alert('Please select a crop region then press submit.');
      return false;
    };//
    
    function updateCoords(c)
    {
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);
      console.log(c.x,c.y,c.h,c.w);
    };

function uploadAndCrop(){
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        //if( $(this).width  )
        console.log($(this));
        var file_img = document.getElementById('thumbnail');
        var ftype = file_img.files[0].type;
        if(ftype=='image/png' || ftype=='image/gif' || ftype=='image/jpg' || ftype=='image/jpeg'
                || ftype=='image/bmp'){
                
        } else {
            alert('Invalid image file selected');
            $('#thumbnail').val('');
            return;
        }
        
//        var img = new Image();
//        img.file = file_img.files[0];
//        var reader=new FileReader();
//        reader.readAsDataURL(file_img);
//        console.log("Image ->",img);
//        return;
        
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(ev){
                //console.log(xhr.responseText);
                if(xhr.readyState === 4){
                    
                    if(xhr.responseText.indexOf("Error:")>=0){
                        document.getElementById('upload_error').innerHTML=xhr.responseText;
                        return ;
                    }
                    document.getElementById('upload_error').innerHTML="";
                    var imgHTML = "<img src=\"uploads/"+xhr.responseText+"\" id=\"crop_target\"\n\
                         class=\"img-responsive\">";
                    //alert(imgHTML);
                    document.getElementById('photo').innerHTML = imgHTML;
                    $pimg.attr('src',"uploads/"+xhr.responseText);
                    $('#crop_src').val("uploads/"+xhr.responseText);

                    $('#crop_target').Jcrop({
                        onChange: updatePreview,
                        onSelect: updateCoords,
                        aspectRatio: 1
                    },function(){
                        // Use the API to get the real image size
                        var bounds = this.getBounds();
                        boundx = bounds[0];
                        boundy = bounds[1];
                        // Store the API in the jcrop_api variable
                        jcrop_api = this;

                        // Move the preview into the jcrop container for css positioning
                        $preview.appendTo(jcrop_api.ui.holder);
                      });
                      
                      $('#myModal').modal();
                }
                

            };
            xhr.open('POST', './upload.php', true);
            //var files = document.getElementById('thumbnail');
            //var files = $('#thumbnail');
            //console.log(files);
            
            var formData = new FormData();
            formData.append('upload_and_crop_file',file_img.files[0]);
            formData.append('upload_and_crop_dest',"./uploads/");
            formData.append('action',"upload_and_crop");
            //console.log(formData);
            xhr.send(formData);
        
    } else {
        alert('The File APIs are not fully supported in this browser.');
    }
}


function crop(){
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(ev){
                if(xhr.readyState === 4) { ///complete
                    console.log(xhr.responseText);
                    //alert("Crop Result "+xhr.responseText);
                    $('#myModal').modal('hide');
                    document.getElementById('final_thumbnail').src=xhr.responseText;
                    $('#cropped_thumbnail').val(xhr.responseText);
                    $('#change_thumb').val(1);
                } else if(xhr.readState === 0) { }//uninitialized
                  else if(xhr.readState === 1) { }//loading
                  else if(xhr.readState === 2) { }//loaded
                  else if(xhr.readState === 3) { }//interactive
            }
            xhr.open('POST', './crop.php', true);
            var data = new FormData(document.forms.namedItem("crop_form"));
            console.log(data);
            xhr.send(data);

}


</script> 


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Choose Thumbnail</h4>
      </div>
      <div class="modal-body">
        <div id="filesInfo" width="100%">
            
            <div id="photo" width="70%" style="float:left; border:5px;"></div>
            <div id="preview-pane" width="30%" style="left:85%">
                <div class="preview-container">
                  <img src="" class="jcrop-preview" alt="Preview" id="preview-img"/>
                </div>
            </div>
            <form action="" method="post" onsubmit="return checkCoords();" name="crop_form">
                        <input type="hidden" name="src" value="" id="crop_src" />
                        <input type="hidden" name="path_to_dest" value="" id="crop_src" />
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" name="action" value="handle_crop" />
<!--			<input type="button" value="Crop Image" id="Crop"
                               onClick="crop()"/>-->
		</form>
            <div style="clear:both"></div>
        </div>
      </div>
      <div class="modal-footer">
          
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="crop()">Save</button>
      </div>
    </div>
  </div>
</div>
        
        
        
        
        