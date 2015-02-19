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
        <div class="mainHeading"><h2><?php echo __("Branch Details") ?></h2></div>
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
                <label for="txtLocationCode"><?php echo __("Branch Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtBranchCode"  name="txtBranchCode" type="text"  class="formInputText" maxlength="10" value="<?php echo $BranchDetail->bbranch_user_code; ?>" />
            </div>
            <input id="BranchCode"  name="BranchCode" type="hidden"  class="formInputText" maxlength="10" value="<?php echo $BranchDetail->bbranch_code; ?>" />
            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Branch Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtBranchName"  name="txtBranchName" type="text"  class="formInputText" value="<?php echo $BranchDetail->bbranch_name; ?>" maxlength="120" />
            </div>


            <div class="centerCol">
                <input id="txtBranchNameSi"  name="txtBranchNameSi" type="text"  class="formInputText" value="<?php echo $BranchDetail->bbranch_name_si; ?>" maxlength="120" />

            </div>
            <div class="centerCol">
                <input id="txtBranchNameTa"  name="txtBranchNameTa" type="text"  class="formInputText" value="<?php echo $BranchDetail->bbranch_name_ta; ?>" maxlength="120" />

            </div>
            
            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Branch Address") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtBranchAddress"  name="txtBranchAddress" type="text"  class="formInputText" ><?php echo $BranchDetail->bbranch_address; ?></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtBranchAddressSi"  name="txtBranchAddressSi" type="text"  class="formInputText" ><?php echo $BranchDetail->bbranch_address_si; ?></textarea>

            </div>
            <div class="centerCol">
                <textarea id="txtBranchAddressTa"  name="txtBranchAddressTa" type="text"  class="formInputText" ><?php echo $BranchDetail->bbranch_address_ta; ?></textarea>

            </div>

            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Bank Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                 <select name="cmbBank" id="cmbBank" class="formSelect"  tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($BankList as $Bank) {
 ?>
                            <option value="<?php echo $Bank->bank_code ?>" <?php if($Bank->bank_code== $BranchDetail->bank_code){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "bank_name";
                            } else {
                                $abcd = "bank_name_" . $myCulture;
                            }
                            if ($Bank->$abcd == "") {
                                echo $Bank->bank_name." --> ".$Bank->bank_user_code;
                            } else {
                                echo $Bank->$abcd." --> ".$Bank->bank_user_code;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol" >
                <label  for="txtLocationCode"><?php echo __("Slip Transfer") ?><span class="required">*</span></label>
            </div>    
            <div class="centerCol" style="padding-left: 5px; padding-top: 7px;"><input name="chkslip" id="chkslip" style="width: 25px;" type="checkbox" value="1" <?php if($BranchDetail->bbranch_sliptransfers_flg=="1"){ echo "checked=checked"; } ?> ></input>
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
                txtBranchCode:{required: true,noSpecialCharsOnly: true, maxlength:10},
                txtBranchName: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtBranchNameSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtBranchNameTa: {noSpecialCharsOnly: true, maxlength:200 },
                txtBranchAddress: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtBranchAddressSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtBranchAddressTa: {noSpecialCharsOnly: true, maxlength:200 },
                cmbBank:{required: true}
                
            },
            messages: {
                txtBranchCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBranchName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBranchNameSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBranchNameTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBranchAddress: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBranchAddressSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBranchAddressTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                cmbBank:{required:"<?php echo __("This field is required") ?>"}
                

            }
        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('payroll/UpdateBranchDetails?id=' . $encrypt->encrypt($BranchDetail->bbranch_code) . '&lock=1') ?>";
                           }
                           else {

                               $('#frmSave').submit();
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/BranchDetails')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           <?php if($BranchDetail->bbranch_code){ ?>
                           location.href="<?php echo url_for('payroll/UpdateBranchDetails?id=' . $encrypt->encrypt($BranchDetail->bbranch_code) . '&lock=0') ?>";
                           <?php }else{?>
                           location.href="<?php echo url_for('payroll/UpdateBranchDetails') ?>";
                           <?php } ?>
                        });
                   });
</script>
