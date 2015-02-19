<?php
if ($mode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>
<?php
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Disciplinary Actions") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">


            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Employee Name") ?> <span class="required">*</span></label>
            </div>

            <div class="centerCol">

<?php
if ($userCulture == "en") {


    $empName = 'emp_display_name';
} else {
    $feildName = 'emp_display_name_' . $userCulture;
    if ($disAct->Employee->$feildName == "") {
        $empName = 'emp_display_name';
    } else {
        $empName = 'emp_display_name_' . $userCulture;
    }
}
?>

                <input id="txtEmployeeName"  name="txtEmployeeName" type="text"  class="formInputText" value="<?php echo $defaultEmpName; ?>" readonly="readonly" maxlength="100" />
                <input id="txtHiddenDisID"  name="txtHiddenDisID" type="hidden"  class="formInputText" value="<?php echo $disAct->emp_dis_id; ?>" maxlength="100" />

            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Effective From") ?> </label>
            </div>



            <div class="centerCol">

                <input id="txtEfftFrom"  name="txtEfftFrom" type="text"  class="formInputText" value="<?php echo LocaleUtil::getInstance()->formatDate($disAct->emp_dis_effectfrom); ?>" maxlength="100" />
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Effective To") ?> </label>
            </div>

            <div class="centerCol">

                <input id="txtEfftTo"  name="txtEfftTo" type="text"  class="formInputText" value="<?php echo LocaleUtil::getInstance()->formatDate($disAct->emp_dis_effectto); ?>" maxlength="100" />

            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Action") ?> </label>
            </div>

            <div class="centerCol">

                <input id="txtAction"  name="txtAction" type="text"  class="formInputText" value="<?php echo $disAct->emp_dis_action; ?>" maxlength="50" />

            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtEbexamDesc"><?php echo __("Comment") ?> </label>
            </div>
            <div class="centerCol">
                <textarea id="txtComment" class="formTextArea" style="width: 400px; height: 75px;" tabindex="1" name="txtComment"><?php echo $disAct->emp_dis_comment; ?></textarea>
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
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>

</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<?php
                $sysConf = OrangeConfig::getInstance()->getSysConf();
                $sysConf = new sysConf();
                $inputDate = $sysConf->dateInputHint;
                $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>


                <script type="text/javascript">

                    $(document).ready(function() {

                        buttonSecurityCommon(null,"editBtn",null,null);


                        jQuery.validator.addMethod("dateValidate",
                        function(value, element) {

                            var hint = '<?php echo $dateHint; ?>';
                            var format = '<?php echo $format; ?>';
                            var txtEfftFrom = strToDate($('#txtEfftFrom').val(), format)
                            var txtEfftTo = strToDate($('#txtEfftTo').val(), format);

                            if (txtEfftTo && txtEfftFrom && (txtEfftTo < txtEfftFrom)) {
                                return false;
                            }
                            return true;
                        }, ""
                    );


                        $("#txtEfftFrom").datepicker({ dateFormat: '<?php echo $inputDate; ?>',changeYear: true,changeMonth: true });
                        $("#txtEfftTo").datepicker({ dateFormat: '<?php echo $inputDate; ?>',changeYear: true,changeMonth: true });

<?php if ($mode == 0) { ?>
                            $("#editBtn").show();
                            buttonSecurityCommon(null,null,"editBtn",null);
                            $('#frmSave :input').attr('disabled', true);
                            $('#editBtn').removeAttr('disabled');
                            $('#btnBack').removeAttr('disabled');
<?php } ?>


                        //Validate the form
                        $("#frmSave").validate({

                            rules: {
                                txtEfftFrom:{dateValidate: true,orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}},
                                txtEfftTo:{dateValidate: true,orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}},
                                txtAction: {noSpecialCharsOnly: true, maxlength:100 },
                                txtComment: {noSpecialCharsOnly: true, maxlength:200 }
                            },
                            messages: {
                                txtEfftFrom:{dateValidate: "<?php echo __("Effective From date should be less than to Effective to Date"); ?>",orange_date: '<?php echo __("Invalid date."); ?>'},
                                txtEfftTo:{dateValidate: "<?php echo __("Effective To date should be greater than to Effective to Date"); ?>", orange_date: '<?php echo __("Invalid date."); ?>' },
                                txtAction:{maxlength:"<?php echo __("Maximum 50 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                                txtComment:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}
                            },
                                submitHandler: function(form) {
                                $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                                form.submit();
                             }
                        });



                        // When click edit button
                        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                        // When click edit button
                        $("#editBtn").click(function() {
                            var editMode = $("#frmSave").data('edit');
                            if (editMode == 1) {
                                // Set lock = 1 when requesting a table lock

                                location.href="<?php echo url_for('pim/saveDisPlinaryaction?disId=' . $disAct->emp_dis_id . '&lock=1') ?>";
                            }
                            else {

                                $('#frmSave').submit();
                            }

                        });

                        //When click reset buton
                        $("#btnClear").click(function() {
                            location.href="<?php echo url_for('pim/saveDisPlinaryaction?disId=' . $disAct->emp_dis_id . '&lock=0') ?>";
                        });

                        //When Click back button
                        $("#btnBack").click(function() {
                            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/disciplinaryAction')) ?>";
        });

    });
</script>


