<?php

?>
  <style>
    body { font: normal 100.01%/1.375 "Helvetica Neue",Helvetica,Arial,sans-serif; }
    .centerCol{
        width: 400px;
    }
    

  </style>
  <link href="<?php echo public_path('../../scripts/signature-pad/assets/jquery.signaturepad.css')?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>-->



  <div class="formpage4col" style="">
    <div class="navigation">


    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Signature") ?></h2></div>
        <?php echo message() ?>
        <form enctype="multipart/form-data" name="frmSave" id="frmSave" method="post"  action="" style="width: 800px; height: 300px;" >

            <div class="leftCol" style="width: 180px;">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol" style="padding-top: 8px;">
                <input type="text" name="txtEmployee" disabled="disabled" id="txtEmployee" value="" readonly="readonly"/>
                <input type="hidden"  name="txtEmpId" id="txtEmpId" value=""/>
<!--            </div>
            <div class="centerCol" style="padding-top: 8px;width: 25px;">-->
                <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; ?> />
            </div>
            <br class="clear">

            <div class="leftCol" style="width: 180px;">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Signature") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol" style="padding-top: 8px;">
                <div class="sigPad" style="width: 300px; height: 200px;">

    <div class="sig sigWrapper" style="width: 300px; height: 200px;">

        <canvas class="pad" width="300" height="200" id="pad" ></canvas>
        <input type="hidden" name="output" class="output" id="output">
      <br class="clear"/>
    </div>
                    <div>
                    <canvas id="myCanvas" name="myCanvas" width="300" height="200" style="display:none;"></canvas>
                    <input type="hidden" name="signature" id="signature" value="">
                    </div>    
            </div>
            </div>
            
            <br class="clear"/>
            <input type="hidden" name="hiddeni" id="hiddeni" value="<?php if (strlen($i)
        )
            echo $i;
        ?>"/>
            <div class="formbuttons">
                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                       value="<?php echo $editMode ? __("Save") : __("Save"); ?>"
                       title="<?php echo $editMode ? __("Save") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />
<!--                <input type="button" id="ann" value="asdadads" />-->

            </div>
        </form>
    </div>

</div>
<script type="text/javascript" src="<?php echo public_path('../../scripts/signature-pad/jquery.signaturepad.js')?>" ></script>
<script type="text/javascript">
//$(function() {
//	$('#sig').signature({guideline: true, 
//    guidelineOffset: 25, guidelineIndent: 20, guidelineColor: '#ff0000'});
//        $('#sig').signature({syncField: '#jsonval'});  
//
//
//$('#ann').click(function() { 
//    $('#redrawSignature').signature('draw', $('#jsonval').val()); 
//}); 
// 
//$('#redrawSignature').signature({disabled: true});
//
//});


    
    
    
                           function SelectEmployee(data) {

                               myArr = new Array();
                               lol = new Array();
                               myArr = data.split('|');
                               $("#txtEmpId").val(myArr[0]);
                                $("#txtEmployee").val(myArr[1]);
                           }





                           $(document).ready(function() {
//                              var canvas = document.getElementById('myCanvas');
//                              var context = canvas.getContext('2d');
//
//                              // draw cloud
//                              context.beginPath();
//                              context.moveTo(170, 80);
//                              context.bezierCurveTo(130, 100, 130, 150, 230, 150);
//                              context.bezierCurveTo(250, 180, 320, 180, 340, 150);
//                              context.bezierCurveTo(420, 150, 420, 120, 390, 100);
//                              context.bezierCurveTo(430, 40, 370, 30, 340, 50);
//                              context.bezierCurveTo(320, 5, 250, 20, 250, 50);
//                              context.bezierCurveTo(200, 5, 150, 20, 170, 80);
//                              context.closePath();
//                              context.lineWidth = 5;
//                              context.fillStyle = '#8ED6FF';
//                              context.fill();
//                              context.strokeStyle = '#0000ff';
//                              context.stroke();
//
//                              // save canvas image as data url (png format by default)
//                              var dataURL = canvas.toDataURL();
//
//                              $("#abc").val(dataURL);
//                              // set canvasImg image src to dataURL
//                              // so it can be saved as an image
//                              document.getElementById('canvasImg').src = dataURL;
                              
                              
                           //$('.sigPad').signaturePad();
                           $('.sigPad').signaturePad({drawOnly:true,lineWidth:0,errorMessageDraw:"" });
                               //Validate the form


                               // When click edit button
                               $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                               $("#editBtn").click(function() {
                                   if($("#txtEmpId").val() == ""){
                                       alert("Please Select a Employee");
                                       return false;
                                   }
                                   if($("#output").val() == ""){
                                       alert("Please Enter Signature");
                                       return false;
                                   }
                                var canvas = document.getElementById('pad');
                                var context = canvas.getContext('2d');
                                context.fill();
                                var dataURL = canvas.toDataURL();
                                $("#signature").val(dataURL);
                                   $('#frmSave').submit();


                               });

                               $('#empRepPopBtn').click(function() {

                                   var popup = window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee'); ?>', 'Locations', 'height=450,width=800,resizable=1,scrollbars=1');


                                   if (!popup.opener)
                                       popup.opener = self;
                                   popup.focus();
                               });





                               //When click reset buton
                               $("#btnClear").click(function() {


                                   location.href = "<?php echo url_for('pim/Signature') ?>";

                               });





                           });
                           // ]]>
</script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/signature-pad/assets/json2.min.js')?>" ></script>