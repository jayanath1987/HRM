<?php
if ($mode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div id="status"></div>
    <div class="outerbox">

        <div class="mainHeading"><h2><?php echo __("Transaction Type Information (Detail View)") ?></h2></div>
        <div class="navigation">
            <?php
            echo message();
            $encryption = new EncryptionHandler();
            ?>
        </div>
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
                <label class="controlLabel" for="lblCode"><?php echo __("Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <?php
                if (strlen($tType->trn_typ_user_code)) {
                    $typeID = $tType->trn_typ_user_code;
                } else {
                    $typeID = $defaultTId;
                }
                ?>
                <input id="txtTID"  name="txtTID" type="hidden"  class="formInputText" value="<?php echo $tType->trn_typ_code ?>"  maxlength="10" />
                <input id="txtCode"  name="txtCode" type="text"  class="formInputText" value="<?php echo $typeID ?>"  maxlength="10" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtName"  name="txtName" type="text"  class="formInputText" value="<?php echo $tType->trn_typ_name; ?>"  maxlength="100"/>
            </div>
            <div class="centerCol">
                <input id="txtNameSi"  name="txtNameSi" type="text"  class="formInputText" value="<?php echo $tType->trn_typ_name_si; ?>"  maxlength="100"/>
            </div>
            <div class="centerCol">
                <input id="txtNameTa"  name="txtNameTa" type="text"  class="formInputText" value="<?php echo $tType->trn_typ_name_ta; ?>"  maxlength="100"/>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode" ><?php echo __("Period") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbPeriod" id="cmbPeriod" class="formSelect" style="width: 160px;">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <option value="1" <?php if ($tType->trn_typ_type == "1")
                    echo "selected"; ?>><?php echo __("Fixed"); ?></option>
                    <option value="0" <?php if ($tType->trn_typ_type == "0")
                                echo "selected"; ?>><?php echo __("Varible"); ?></option>
                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Type") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <?php
                $sysConf = new sysConf();
                ?>

                <select name="cmbType" id="cmbType" class="formSelect" style="width: 160px;">
                    <option value=""><?php echo __("--Select--") ?></option>
  <?php if($tType->trn_typ_code !=null && $tType->erndedcon == "1"){ ?>                  
                    <option value="<?php echo $sysConf->BSalTypecode ?>" <?php if ($tType->erndedcon == "1")
                    echo "selected"; ?>><?php echo __("Basic Salary"); ?></option>
  <?php } ?>                  
                    <option value="<?php echo $sysConf->ContributCode ?>" <?php if ($tType->erndedcon == "0")
                                echo "selected"; ?>><?php echo __("Contibution"); ?></option>
                    <option value="<?php echo $sysConf->DeductCode ?>" <?php if ($tType->erndedcon == "-1")
                                echo "selected"; ?>><?php echo __("Deduction"); ?></option>
                    <option value="<?php echo $sysConf->Earncode ?>" <?php if ($tType->erndedcon == "2")
                                echo "selected"; ?>><?php echo __("Earning"); ?></option>
                </select>
            </div>
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
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>

</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<script type="text/javascript">

    $(document).ready(function() {

        buttonSecurityCommon(null,"editBtn",null,null);



<?php if ($mode == 0) { ?>
                                               $("#editBtn").show();
                                               buttonSecurityCommon(null,null,"editBtn",null);
                                               $('#frmSave :input').attr('disabled', true);
                                               $('#editBtn').removeAttr('disabled');
                                               $('#btnBack').removeAttr('disabled');
<?php } ?>


                               $("#frmSave").validate({

                                   rules: {
                                       txtCode:{required: true,noSpecialCharsOnly: true, maxlength:10},
                                       txtName: { required: true,noSpecialCharsOnly: true, maxlength:100 },
                                       txtNameSi: {noSpecialCharsOnly: true, maxlength:100 },
                                       txtNameTa: {noSpecialCharsOnly: true, maxlength:100 },
                                       cmbPeriod:{required: true},
                                       cmbType:{required: true}
                                   },
                                   messages: {
                                       txtCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                                       txtName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                                       txtNameSi:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                                       txtNameTa:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                                       cmbPeriod:{required:"<?php echo __("This field is required") ?>"},
                                       cmbType:{required:"<?php echo __("This field is required") ?>"}



                                   }
                               });



                               // When click edit button
                               $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                               // When click edit button
                               $("#editBtn").click(function() {
                                   var editMode = $("#frmSave").data('edit');
                                   if (editMode == 1) {
                                       // Set lock = 1 when requesting a table lock
                                
                                       location.href="<?php echo url_for('payroll/TransActionTypeInfo?tId=' . $encryption->encrypt($tType->trn_typ_code) . '&lock=1') ?>";
                                   }
                                   else {
                                
                                       $('#frmSave').submit();
                                   }

                               });

                               //When click reset buton
                               $("#btnClear").click(function() {
                                   location.href="<?php echo url_for('payroll/TransActionTypeInfo?tId=' . $encryption->encrypt($tType->trn_typ_code) . '&lock=0') ?>";
                               });

                               //When Click back button
                               $("#btnBack").click(function() {
                                   location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/TransActiontypeSummary')) ?>";
                               });

                           });
</script>


