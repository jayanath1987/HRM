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
        <div class="mainHeading"><h2><?php echo __("Bank Details") ?></h2></div>
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
                <label for="txtLocationCode"><?php echo __("Bank Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtBankCode"  name="txtBankCode" type="text"  class="formInputText" maxlength="10" value="<?php echo $BankDetail->bank_user_code; ?>" />
            </div>
            <input id="BankCode"  name="BankCode" type="hidden"  class="formInputText" maxlength="10" value="<?php echo $BankDetail->bank_code; ?>" />
            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Bank Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtBankName"  name="txtBankName" type="text"  class="formInputText" value="<?php echo $BankDetail->bank_name; ?>" maxlength="200" />
            </div>


            <div class="centerCol">
                <input id="txtBankNameSi"  name="txtBankNameSi" type="text"  class="formInputText" value="<?php echo $BankDetail->bank_name_si; ?>" maxlength="200" />

            </div>
            <div class="centerCol">
                <input id="txtBankNameTa"  name="txtBankNameTa" type="text"  class="formInputText" value="<?php echo $BankDetail->bank_name_ta; ?>" maxlength="200" />

            </div>
            
            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Bank Address") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtBankAddress"  name="txtBankAddress" type="text"  class="formInputText" ><?php echo $BankDetail->bank_address; ?></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtBankAddressSi"  name="txtBankAddressSi" type="text"  class="formInputText" ><?php echo $BankDetail->bank_address_si; ?></textarea>

            </div>
            <div class="centerCol">
                <textarea id="txtBankAddressTa"  name="txtBankAddressTa" type="text"  class="formInputText" ><?php echo $BankDetail->bank_address_ta; ?></textarea>

            </div>

            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Parent Bank") ?> </label>
            </div>
            <div class="centerCol">
                 <select name="cmbParentBank" class="formSelect"  tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($ParentBankList as $ParentBank) {
 ?>
                            <option value="<?php echo $ParentBank->bank_code ?>" <?php if($ParentBank->bank_code== $BankDetail->bnk_mainbank){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "bank_name";
                            } else {
                                $abcd = "bank_name_" . $myCulture;
                            }
                            if ($ParentBank->$abcd == "") {
                                echo $ParentBank->bank_name." --> ".$ParentBank->bank_user_code;
                            } else {
                                echo $ParentBank->$abcd." --> ".$ParentBank->bank_user_code;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol" >
                <label  for="txtLocationCode"><?php echo __("Main Bank") ?><span class="required">*</span></label>
            </div>    
            <div class="centerCol" style="padding-left: 5px; padding-top: 7px;"><input name="chkmainbank" id="chkmainbank" style="width: 25px;" type="checkbox" value="1" <?php if($BankDetail->bnk_main=="1"){ echo "checked=checked"; } ?> ></input>
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
                txtBankCode:{required: true,noSpecialCharsOnly: true, maxlength:10},
                txtBankName: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtBankNameSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtBankNameTa: {noSpecialCharsOnly: true, maxlength:200 },
                txtBankAddress: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtBankAddressSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtBankAddressTa: {noSpecialCharsOnly: true, maxlength:200 }
                
            },
            messages: {
                txtBankCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBankName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBankNameSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBankNameTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBankAddress: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBankAddressSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBankAddressTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}
                
                

            }
        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('payroll/UpdateBankDetails?id=' . $encrypt->encrypt($BankDetail->bank_code) . '&lock=1') ?>";
                           }
                           else {

                               $('#frmSave').submit();
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/BankDetails')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           <?php if($BranchDetail->bbranch_code){ ?>
                           location.href="<?php echo url_for('payroll/UpdateBankDetails?id=' . $encrypt->encrypt($BankDetail->bank_code) . '&lock=0') ?>";
                           <?php }else{?>
                           location.href="<?php echo url_for('payroll/UpdateBankDetails?id=') ?>";    
                           <?php } ?>    
                        });
                   });
</script>
