<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
        $encrypt = new EncryptionHandler();
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">
        <style type="text/css">
        div.formpage4col input[type="text"]{
            width: 180px;
        }
        </style>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Employee Vote Information") ?></h2></div>
            <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("English") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Sinhala") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Tamil") ?></label>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Vote Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtVoteCode"  name="txtVoteCode" type="text"  class="formInputText" maxlength="10" value="<?php echo $PayrollVote->vt_typ_user_code; ?>" />
            </div>
            <input id="VoteCode"  name="VoteCode" type="hidden"  class="formInputText" maxlength="10" value="<?php echo $PayrollVote->vt_typ_code; ?>" />
            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Vote Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtVoteName"  name="txtVoteName" type="text"  class="formInputText" value="<?php echo $PayrollVote->vt_typ_name; ?>" maxlength="200" />
            </div>


            <div class="centerCol">
                <input id="txtVoteNameSi"  name="txtVoteNameSi" type="text"  class="formInputText" value="<?php echo $PayrollVote->vt_typ_name_si; ?>" maxlength="200" />

            </div>
            <div class="centerCol">
                <input id="txtVoteNameTa"  name="txtVoteNameTa" type="text"  class="formInputText" value="<?php echo $PayrollVote->vt_typ_name_ta; ?>" maxlength="200" />

            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Vote Type") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                 <select name="cmbVoteType" class="formSelect" style="width: 190px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($PayrollVoteTypeList as $PayrollVoteType) {
 ?>
                            <option value="<?php echo $PayrollVoteType->vt_inf_type_code ?>" <?php if($PayrollVote->vt_inf_type_code== $PayrollVoteType->vt_inf_type_code){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "vt_inf_type_name";
                            } else {
                                $abcd = "vt_inf_type_name_" . $myCulture;
                            }
                            if ($PayrollVoteType->$abcd == "") {
                                echo $PayrollVoteType->vt_inf_type_name;
                            } else {
                                echo $PayrollVoteType->$abcd;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>



            <br class="clear"/>
            <br class="clear"/>
        <div class="formbuttons">
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>" tabindex="18"  onclick="goBack();"/>
        </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">

    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
<?php if ($editMode == true) { ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>

                       //Validate the form
                       $("#frmSave").validate({

            rules: {
                txtVoteCode:{required: true,noSpecialCharsOnly: true, maxlength:10},
                txtVoteName: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtVoteNameSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtVoteNameTa: {noSpecialCharsOnly: true, maxlength:200 },
                cmbVoteType:{required: true}
            },
            messages: {
                txtVoteCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtVoteName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtVoteNameSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtVoteNameTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                cmbVoteType:{required:"<?php echo __("This field is required") ?>"}
                

            }
        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('payroll/UpdateVoteDetails?id=' . $encrypt->encrypt($PayrollVote->vt_typ_code) . '&lock=1') ?>";
                           }
                           else {

                               $('#frmSave').submit();
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/VoteDetails')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           <?php if($PayrollVote->vt_typ_code){ ?>
                           location.href="<?php echo url_for('payroll/UpdateVoteDetails?id=' . $encrypt->encrypt($PayrollVote->vt_typ_code) . '&lock=0') ?>";
                           <?php }else{ ?>
                           location.href="<?php echo url_for('payroll/UpdateVoteDetails') ?>";    
                           <?php } ?>    
                   });
                   });
</script>
