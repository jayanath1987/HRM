<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
<link href="<?php echo public_path('../../themes/orange/css/style.css') ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo public_path('../../themes/orange/css/message.css') ?>" rel="stylesheet" type="text/css"/>
<!--[if lte IE 6]>
<link href="<?php echo public_path('../../themes/orange/css/IE6_style.css') ?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<!--[if IE]>
<link href="<?php echo public_path('../../themes/orange/css/IE_style.css') ?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<script type="text/javascript" src="<?php echo public_path('../../themes/orange/scripts/style.js'); ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/archive.js'); ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.form.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<?php echo javascript_include_tag('orangehrm.validate.js'); ?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/showhidepane.js'); ?>"></script>
<?php
$allowEdit = ($locRights['admin'] && $locRights['add']) || $locRights['supervisor'];
$allowDel = ($locRights['admin'] && $locRights['delete']) || $locRights['supervisor'];
$disabled = $allowEdit ? '' : 'disabled="disabled"';
?>
<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Photograph"); ?></h2></div>
        <div id="errMessage">
            <?php include_partial('pim_form_errors', array('sf_user' => $sf_user)); ?>
            <?php echo message(); ?>
            <?php
            $encrypt = new EncryptionHandler();
            ?>
        </div>

        <form name="frmEmpPhoto" id="frmEmpPhoto" method="post" enctype="multipart/form-data"
              action="<?php echo url_for('pim/photoGraph?empNumber=' . $employee->empNumber); ?>">
<?php
            if (isset($getArr['message'])) {

                $expString = $getArr['message'];
?>
                  <?php } ?>
            <input type="hidden" name="EmpID" value="<?php echo $employee->empNumber; ?>"/>
            <div class="" >
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />

                <span id="Currentimage">

                    <img id="currentImage" style="width:100px; height:120px; padding: 25px;" alt="Employee Photo"
                         src="<?php echo url_for("pim/viewPhoto?id=" . $encrypt->encrypt($employee->empNumber)); ?>" /><br />
                    <span id="imageHint" style="padding-left:10px;"><?php //echo __("Click on the photo to see the full size image"); ?></span>
                </span>
                <br />

                <label for="photofile"><?php echo __("Select a Photo"); ?></label>
                <input type="file" name="photofile" id="photofile" class="formFileInput" accept="image/gif,image/jpeg,image/png"
<?php echo $disabled; ?> />
                <label for="photofile" id="imageSizeRule"><?php echo __("Photograph Size 1 MB"); ?> <?php echo __("3.5 cm * 1.5 cm"); ?></label>

                <br />
                &nbsp;
                <div class="formbuttons">
                    <input type="button" value="<?php echo __("Save"); ?>" class="savebutton" id="savePicBtn"
                           onmouseout="moutButton(this)" onmouseover="moverButton(this)" />
                    <input type="reset" name="btnResetPhoto" id="btnResetPhoto" value="<?php echo __('Reset'); ?>" class="resetbutton" />

                    <input type="button" value="<?php echo __("Delete"); ?>" class="delbutton" id="deletePicBtn"
                           onmouseout="moutButton(this)" onmouseover="moverButton(this)"/>

                </div>

            </div>
        </form>
    </div>
</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<script type="text/javaScript"><!--//--><![CDATA[//><!--
    function getPhotodetails(empNumber){
        $.post("<?php echo url_for('pim/photoDetails') ?>",
        { empNumber: empNumber },
        function(data){
            if(data==null){
            }else{
            }

        },
        "json"
    );
    }
    function setCurrentPhoto(data){

    }

    function lockPhoto(empNumber){
        $.post("<?php echo url_for('pim/lockPhoto') ?>",
        { empNumber: empNumber },
        function(data){
            if (data.recordLocked==true) {
                getPhotodetails(empNumber);
                $("#frmEmpPhoto").data('edit', '1'); // In edit mode
                setPhotoAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
    );
    }

    function unlockPhoto(empNumber){
        $.post("<?php echo url_for('pim/unlockPhoto') ?>",
        { empNumber: empNumber },
        function(data){
            getPhotodetails(empNumber);
            $("#frmEmpPhoto").data('edit', '0'); // In view mode
            setPhotoAttributes();
        },
        "json"
    );
    }
    function setPhotoAttributes() {

        var editMode = $("#frmEmpPhoto").data('edit');
        if (editMode == 0) {
            $('#frmEmpPhoto :input').attr('disabled','disabled');
            $('#savePicBtn').removeAttr('disabled');

            $("#savePicBtn").attr('value',"<?php echo __("Edit"); ?>");
            $("#savePicBtn").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {
            $('#frmEmpPhoto :input').removeAttr('disabled');

            $("#savePicBtn").attr('value',"<?php echo __("Save"); ?>");
            $("#savePicBtn").attr('title',"<?php echo __("Save"); ?>");
        }
    }



    $(document).ready(function() {
        var flag="<?php echo $flag; ?>";
       
        if(flag=="1"){
history.go(-1);
   
        }
          

        buttonSecurityCommon(null,null,"savePicBtn","deletePicBtn");

        $("#frmEmpPhoto").data('edit', '0'); // In view mode
        setPhotoAttributes();

        $("#currentImage").click(function() {
            window.open(this.src);
        });

        $("#deletePicBtn").click(function() {


            $.post("<?php echo url_for('pim/photoDetails') ?>",
            { empNumber: "<?php echo $employee->empNumber ?>" },
            function(data){
                if(data==null){
                    alert('<?php echo __("There is a no photograph to delete") ?>');
                }else{
                    if (!confirm('<?php echo __("Are you sure you want to delete the photograph"); ?>?')) {
                        return;
                    }
                    var form = $('#frmEmpPhoto');

                    form.attr('action', '<?php echo url_for('pim/deletePhoto?empNumber=' . $employee->empNumber); ?>');
                    
                    form.submit();
                }

            },
            "json"
        );


        });


        $("#savePicBtn").click(function() {

            var editMode = $("#frmEmpPhoto").data('edit');
            if (editMode == 0) {
                lockPhoto("<?php echo $employee->empNumber ?>");
                return false;
            }
            else {
                var file = $('#photofile').val().trim();
                if (file == '') {
                    alert('<?php echo __("Please select a photograph"); ?>');
                    return;
                }
                
                $('#frmEmpPhoto').submit();
            }



        });
        $('#btnResetPhoto').click(function() {

            var editMode = $("#frmEmpPhoto").data('edit');
            if (editMode == 1) {
                
                document.forms['frmEmpPhoto'].reset('');
                unlockPhoto("<?php echo $employee->empNumber ?>");
                return false;
            }
            else {
                 
                document.forms['frmEmpPhoto'].reset('');
            }
        });

    });


       //--><!]]></script>