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


<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("License"); ?></h2></div>
        <div id="ErrorMSg">
            <?php echo message(); ?>
        </div>
        <div id="parentPaneLicense" >
            <?php
            $empLicense = $employee->licenses;

            $allowEdit = $locRights['add'] || $locRights['ESS'] || $locRights['supervisor'];
            $allowDel = $locRights['delete'] || $locRights['ESS'] || $locRights['supervisor'];
            $disabled = $allowEdit ? '' : 'disabled="disabled"';



            if ($currentPane == 12) {
                include_partial('pim_form_errors', array('sf_user' => $sf_user));
            }

            if (isset($postArr['EditMode']) && $postArr['EditMode'] == '1') {
                $editMode = false;
                $disabled = '';
            } else {
                $editMode = true;
                $disabled = 'disabled="disabled"';
            }

            $sysConf = OrangeConfig::getInstance()->getSysConf();
            $dateHint = $sysConf->getDateInputHint();
            $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
            ?>

            <form name="frmEmpLicense" id="frmEmpLicense" method="post" action="<?php echo url_for('pim/updateLicense?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="txtLicSeqNo" id="txtLicSeqNo" value="" />

                <div id="addPaneLicense" style="display:none;">
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
                        <label for="txtLicNumber"><?php echo __("License Number"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtLicNumber" id="txtLicNumber"
                               value="" maxlength="50" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtLicType"><?php echo __("License Type"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtLicType" id="txtLicType"
                               value="" maxlength="50" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtLicTypeSI" id="txtLicTypeSI"
                               value="" maxlength="50" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtLicTypeTA" id="txtLicTypeTA"
                               value="" maxlength="50" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtLicIssueDate"><?php echo __("Issue Date"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" name="txtLicIssueDate" id="txtLicIssueDate" value="">
                    </div>
                    <div class="centerCol">
                        <label for="txtLicExpiryDate"><?php echo __("Expiry Date"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" name="txtLicExpiryDate" id="txtLicExpiryDate" value="">
                    </div>
                    <br class="clear"/>


                    <div class="formbuttons">
                        <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditLicense" id="btnEditLicense"
                               value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" value="<?php echo __("Reset"); ?>" name="btnResetLicense" id="btnResetLicense"/>
                        <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackLicense" />
                    </div>

                </div>
            </form>
            <form name="frmEmpDelLicense" id="frmEmpDelLicense" method="post" action="<?php echo url_for('pim/deleteLicense?empNumber=' . $employee->empNumber); ?>">

                <div id="summaryPaneLicense" >
                    <div class="subHeading"></div>
<div class="actionbar">
                        <div class="actionbuttons">


                            <input type="button" class="addbutton" id="btnAddLicense"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>


                            <input type="button" class="delbutton" id="btnDelLicense"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Delete"); ?>" title="<?php echo __("Delete"); ?>"/>


                        </div>
                    </div>
                    <table width="550" cellspacing="0" cellpadding="0" class="data-table">
                        <thead>
                            <tr>
                                <td width="50">
                                    <input type="checkbox" class="checkbox" name="chkAllCheck" value="" id="chkAllCheck" />
                                </td>
                                <td scope="col">
<?php echo __('License Number'); ?>
                                </td>
                                <td scope="col">
<?php echo __('License Type'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Issue Date'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Expiry Date'); ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody>
<?php
            $row = 0;
            foreach ($empLicense as $empLic) {
                $cssClass = ($row % 2) ? 'even' : 'odd';
                $row = $row + 1;

                //Define data columns according culture
                $licenseTypeCol = ($userCulture == "en") ? "lic_type" : "lic_type_" . $userCulture;
                $licenseType = $empLic->$licenseTypeCol == "" ? $empLic->lic_type : $empLic->$licenseTypeCol;
?>

                            <tr class="<?php echo $cssClass ?>">
                                <td >
                                    <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $empLic->lic_seqno ?>' />
                                </td>
                                <td class="">
                                    <a href="#"><?php echo $empLic->lic_number; ?></a>
                                </td>
                                <td class="">
<?php echo $licenseType; ?>
                                </td>
                                <td class="">
<?php echo LocaleUtil::getInstance()->formatDate($empLic->lic_issue_date); ?>
                                </td>
                                <td class="">
<?php echo LocaleUtil::getInstance()->formatDate($empLic->lic_expiry_date); ?>
                                </td>
                            </tr>
<?php } ?>
                        </tbody>

                    </table>
                </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[

    function getLicense(empNumber,seqNo){
        $.post("<?php echo url_for('pim/getLicenseById') ?>",
        { empNumber: empNumber, seqNo: seqNo },
        function(data){
            if(data==null){
                alert("<?php echo __("record is not found") ?>");
                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/license')) ?>";
            }else{
                setLicenseData(data);
            }
                    
        },
        "json"
    );
    }

    function lockLicense(empNumber,seqNo){
        $.post("<?php echo url_for('pim/lockLicense') ?>",
        { empNumber: empNumber, seqNo: seqNo },
        function(data){
            if (data.recordLocked==true) {
                getLicense(empNumber,seqNo);
                $("#frmEmpLicense").data('edit', '1'); // In edit mode
                setLicenseAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
    );
    }

    function unlockLicense(empNumber,seqNo){
        $.post("<?php echo url_for('pim/unlockLicense') ?>",
        { empNumber: empNumber, seqNo: seqNo },
        function(data){
            getLicense(empNumber,seqNo);
            $("#frmEmpLicense").data('edit', '0'); // In view mode
            setLicenseAttributes();
        },
        "json"
    );
    }

    function setLicenseData(data){
        $("#txtLicSeqNo").val(data.lic_seqno);
        $("#txtLicNumber").val(data.lic_number);
        $("#txtLicType").val(data.lic_type);
        $("#txtLicTypeSI").val(data.lic_type_si);
        $("#txtLicTypeTA").val(data.lic_type_ta);
        $("#txtLicIssueDate").val(data.lic_issue_date);
        $("#txtLicExpiryDate").val(data.lic_expiry_date);
    }

    function setLicenseAttributes() {

        var editMode = $("#frmEmpLicense").data('edit');
        if (editMode == 0) {
            $('#frmEmpLicense :input').attr('disabled','disabled');

            $('#btnEditLicense').removeAttr('disabled');
            $('#btnBackLicense').removeAttr('disabled');

            $("#btnEditLicense").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnEditLicense").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {
            $('#frmEmpLicense :input').removeAttr('disabled');

            $("#btnEditLicense").attr('value',"<?php echo __("Save"); ?>");
            $("#btnEditLicense").attr('title',"<?php echo __("Save"); ?>");
        }
    }

    $(document).ready(function() {
        buttonSecurityCommon("btnAddLicense",null,null,"btnDelLicense");
        showPaneData('summaryPaneLicense');
        hidePaneData('addPaneLicense');
        $("#txtLicIssueDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
        $("#txtLicExpiryDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });

        // Edit a work experiance data in the list
        $('#frmEmpDelLicense a').click(function() {
        
            buttonSecurityCommon(null,null,"btnEditLicense",null);
            $("#ErrorMSg").hide();
            var row = $(this).closest("tr");
            var seqNo = row.find('input.checkbox:first').val();
            getLicense(<?php echo $employee->empNumber ?>,seqNo);
            showPaneData('addPaneLicense');
            hidePaneData('summaryPaneLicense');

            $("#frmEmpLicense").data('edit', '0'); // In view mode
            setLicenseAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
        });

        // Add a work experience record
        $('#btnAddLicense').click(function() {
        
            $('#btnEditLicense').show();
            buttonSecurityCommon(null,"btnEditLicense",null,null);
            $("#ErrorMSg").hide();
            $("#txtLicSeqNo").val('');
            $("#txtLicNumber").val('');
            $("#txtLicType").val('');
            $("#txtLicTypeSI").val('');
            $("#txtLicTypeTA").val('');
            $("#txtLicIssueDate").val('');
            $("#txtLicExpiryDate").val('');

            showPaneData('addPaneLicense');
            hidePaneData('summaryPaneLicense');

            $("#frmEmpLicense").data('edit', '2'); // In add mode
            setLicenseAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
        });

        jQuery.validator.addMethod("licenseStartBeforeEnd",
        function(value, element) {

            var hint = '<?php echo $dateHint; ?>';
            var format = '<?php echo $format; ?>';
            var fromDate = strToDate($('#txtLicIssueDate').val(), format)
            var toDate = strToDate($('#txtLicExpiryDate').val(), format);

            if (fromDate && toDate && (fromDate >= toDate)) {
                return false;
            }
            return true;
        }, ""
    );

        $("#frmEmpLicense").validate({
            rules: {
                txtLicNumber : {required:true},
                txtLicType : {required:true},
                txtLicIssueDate : {orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, licenseStartBeforeEnd:true, required:true },
                txtLicExpiryDate : {orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, licenseStartBeforeEnd:true}
            },
            messages: {
                txtLicNumber: '<?php echo __("This field is required.") ?>',
                txtLicType: '<?php echo __("This field is required.") ?>',
                txtLicIssueDate : {orange_date: '<?php echo __("Invalid date."); ?>',
                    licenseStartBeforeEnd: '<?php echo __("Invalid date period."); ?>',
                    required: '<?php echo __("This field is required.") ?>'},
                txtLicExpiryDate : {orange_date: '<?php echo __("Invalid date."); ?>',
                    licenseStartBeforeEnd: '<?php echo __("Invalid date period."); ?>'
                    }
            },
            errorClass: "errortd",
                   submitHandler: function(form) {
                   $('#btnEditLicense').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                   form.submit();
             }
        });

        // When Click Main Tick box
        $("#chkAllCheck").click(function() {
            if ($('#chkAllCheck').attr('checked')){
                $('.innercheckbox').attr('checked','checked');
            }else{
                $('.innercheckbox').removeAttr('checked');
            }
        });

        $(".innercheckbox").click(function() {
            if($(this).attr('checked')) {

            }else {
                $('#chkAllCheck').removeAttr('checked');
            }
        });
        var answer=0;
        //When click remove button
        $("#btnDelLicense").click(function() {
            $("#mode").attr('value', 'delete');
            if($("input[name='chkID[]']").is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
            }

            if (answer !=0 ) {
                $("#frmEmpDelLicense").submit();
            } else {
                return false;
            }
        });

        // Switch edit mode or submit data when edit/save button is clicked
        $("#btnEditLicense").click(function() {
            $('#ErrorMSgSerRe').hide();
            var editMode = $("#frmEmpLicense").data('edit');
            if (editMode == 0) {
                lockLicense(<?php echo $employee->empNumber ?>,$('#txtLicSeqNo').val());
                return false;
            }
            else {
                $('#frmEmpLicense').submit();
            }
        });

        $('#btnBackLicense').click(function() {
            $("#ErrorMSg").hide();
            showPaneData('summaryPaneLicense');
            hidePaneData('addPaneLicense');
        });

        $('#btnResetLicense').click(function() {
            $("#ErrorMSg").hide();
            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            // 0 - view, 1 - edit, 2 - add
            var editMode = $("#frmEmpLicense").data('edit');
            if (editMode == 1) {
                unlockLicense(<?php echo $employee->empNumber ?>,$('#txtLicSeqNo').val());
                return false;
            }
            else {
                document.forms['frmEmpLicense'].reset('');
            }
        });
    });
    //]]>
</script>