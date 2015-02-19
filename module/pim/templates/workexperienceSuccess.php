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
        <div class="mainHeading"><h2><?php echo __("Work experience"); ?></h2></div>
        <div id="ErrorMSgSerRec">
            <?php echo message(); ?>
        </div>
        <div id="parentPaneWorkExperience" >

            <?php
            $workExperience = $employee->workExperience;

            $allowEdit = $locRights['add'] || $locRights['ESS'] || $locRights['supervisor'];
            $allowDel = $locRights['delete'] || $locRights['ESS'] || $locRights['supervisor'];
            $disabled = $allowEdit ? '' : 'disabled="disabled"';



            if ($currentPane == 17) {
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

            <form name="frmEmpWorkExperience" id="frmEmpWorkExperience" method="post" action="<?php echo url_for('pim/updateWorkExperience?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="txtExpSeqNo" id="txtExpSeqNo" value="" />

                <div id="addPaneWorkExperience" style="display:none;">
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
                        <label for="txtExpCompanyName"><?php echo __("Company Name"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtExpCompanyName" id="txtExpCompanyName"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtExpCompanyNameSI" id="txtExpCompanyNameSI"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtExpCompanyNameTA" id="txtExpCompanyNameTA"
                               value="" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtExpJobTitle"><?php echo __("Job Title"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtExpJobTitle" id="txtExpJobTitle"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtExpJobTitleSI" id="txtExpJobTitleSI"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtExpJobTitleTA" id="txtExpJobTitleTA"
                               value="" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtExpStartDate"><?php echo __("Start Date"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" name="txtExpStartDate" id="txtExpStartDate" value="">
                    </div>
                    <div class="centerCol">
                        <label for="txtExpEndDate"><?php echo __("End Date"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" name="txtExpEndDate" id="txtExpEndDate" value="">
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtExpComment"><?php echo __("Comments"); ?></label>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtExpComment" id="txtExpComment" maxlength="200"></textarea>
                    </div>
                    <div class="centerCol" >
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtExpCommentSI" id="txtExpCommentSI" maxlength="200"></textarea>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtExpCommentTA" id="txtExpCommentTA" maxlength="200"></textarea>
                    </div>
                    <br class="clear"/>

<!--                    <div class="leftCol">
                        <label for="chkExpInternal"><?php echo __("Internal"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="checkbox" class="formPIMCheckBox" name="chkExpInternal" id="chkExpInternal" <?php echo $disabled; ?> value="1" />
                    </div>
                    <br class="clear"/>-->


                    <div class="formbuttons">
                        <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditWorkExperience" id="btnEditWorkExperience"
                               value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" value="<?php echo __("Reset"); ?>" name="btnResetWorkExperience" id="btnResetWorkExperience"/>
                        <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackWorkExperience" />
                    </div>

                </div>
            </form>
            <form name="frmEmpDelWorkExperience" id="frmEmpDelWorkExperience" method="post" action="<?php echo url_for('pim/deleteWorkExperience?empNumber=' . $employee->empNumber); ?>">

                <div id="summaryPaneWorkExperience" >
                    <div class="subHeading"></div>
                    <div class="actionbar">
                        <div class="actionbuttons">


                            <input type="button" class="addbutton" id="btnAddWorkExperience"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>


                            <input type="button" class="delbutton" id="btnDelWorkExperience"
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
<?php echo __('Company Name'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Job Title'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Start Date'); ?>
                                </td>
                                <td scope="col">
<?php echo __('End Date'); ?>
                                </td>
<!--                                <td scope="col">
<?php echo __('Internal'); ?>
                                </td>-->
                            </tr>
                        </thead>

                        <tbody>
<?php
            $row = 0;
            foreach ($workExperience as $workExp) {
                $cssClass = ($row % 2) ? 'even' : 'odd';
                $row = $row + 1;

                //Define data columns according culture
                $companyNameCol = ($userCulture == "en") ? "eexp_company" : "eexp_company_" . $userCulture;
                $companyName = $workExp->$companyNameCol == "" ? $workExp->eexp_company : $workExp->$companyNameCol;

                $jobTitleCol = ($userCulture == "en") ? "eexp_jobtitle" : "eexp_jobtitle_" . $userCulture;
                $jobTitle = $workExp->$jobTitleCol == "" ? $workExp->eexp_jobtitle : $workExp->$jobTitleCol;

                $internal = ($workExp->eexp_internal_flg == 1) ? '<img src="' . public_path("../../themes/beyondT/icons/flag.gif") . '" alt="internal" width="22" height="19" title="Internal"/>' : '';
?>

                            <tr class="<?php echo $cssClass ?>">
                                <td >
                                    <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $workExp->eexp_seqno ?>' />
                                </td>
                                <td class="">
                                    <a href="#"><?php echo $companyName; ?></a>
                                </td>
                                <td class="">
<?php echo $jobTitle; ?>
                                </td>
                                <td class="">
<?php echo LocaleUtil::getInstance()->formatDate($workExp->eexp_from_date); ?>
                                </td>
                                <td class="">
<?php echo LocaleUtil::getInstance()->formatDate($workExp->eexp_to_date); ?>
                                </td>
<!--                                <td class="">
<?php echo $internal; ?>
                                </td>-->
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

    function getWorkExperience(empNumber,seqNo){
        $.post("<?php echo url_for('pim/getWorkExperienceById') ?>",
        { empNumber: empNumber, seqNo: seqNo },
        function(data){
            setWorkExperienceData(data);
        },
        "json"
    );
    }

    function lockWorkExperience(empNumber,seqNo){
        $.post("<?php echo url_for('pim/lockWorkExperience') ?>",
        { empNumber: empNumber, seqNo: seqNo },
        function(data){
            if (data.recordLocked==true) {
                getWorkExperience(empNumber,seqNo);
                $("#frmEmpWorkExperience").data('edit', '1'); // In edit mode
                setWorkExperienceAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
    );
    }

    function unlockWorkExperience(empNumber,seqNo){
        $.post("<?php echo url_for('pim/unlockWorkExperience') ?>",
        { empNumber: empNumber, seqNo: seqNo },
        function(data){
            getWorkExperience(empNumber,seqNo);
            $("#frmEmpWorkExperience").data('edit', '0'); // In view mode
            setWorkExperienceAttributes();
        },
        "json"
    );
    }

    function setWorkExperienceData(data){
        $("#txtExpSeqNo").val(data.eexp_seqno);
        $("#txtExpCompanyName").val(data.eexp_company);
        $("#txtExpCompanyNameSI").val(data.eexp_company_si);
        $("#txtExpCompanyNameTA").val(data.eexp_company_ta);
        $("#txtExpJobTitle").val(data.eexp_jobtitle);
        $("#txtExpJobTitleSI").val(data.eexp_jobtitle_si);
        $("#txtExpJobTitleTA").val(data.eexp_jobtitle_ta);
        $("#txtExpStartDate").val(data.eexp_from_date);
        $("#txtExpEndDate").val(data.eexp_to_date);
        $("#txtExpComment").val(data.eexp_comments);
        $("#txtExpCommentSI").val(data.eexp_comments_si);
        $("#txtExpCommentTA").val(data.eexp_comments_ta);


//        if (data.eexp_internal_flg==1) {
//            $('#chkExpInternal').attr('checked', 'checked');
//        } else {
//            $('#chkExpInternal').removeAttr('checked');
//        }
    }

    function setWorkExperienceAttributes() {

        var editMode = $("#frmEmpWorkExperience").data('edit');
        if (editMode == 0) {
            $('#frmEmpWorkExperience :input').attr('disabled','disabled');

            $('#btnEditWorkExperience').removeAttr('disabled');
            $('#btnBackWorkExperience').removeAttr('disabled');

            $("#btnEditWorkExperience").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnEditWorkExperience").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {
            $('#frmEmpWorkExperience :input').removeAttr('disabled');

            $("#btnEditWorkExperience").attr('value',"<?php echo __("Save"); ?>");
            $("#btnEditWorkExperience").attr('title',"<?php echo __("Save"); ?>");
        }
    }

    $(document).ready(function() {
    
        buttonSecurityCommon("btnAddWorkExperience",null,null,"btnDelWorkExperience");
        showPaneData('summaryPaneWorkExperience');
        hidePaneData('addPaneWorkExperience');
        $("#txtExpStartDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
        $("#txtExpEndDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
    
        // Edit a work experiance data in the list
        $('#frmEmpDelWorkExperience a').click(function() {
        
            buttonSecurityCommon(null,null,"btnEditWorkExperience",null);
            var row = $(this).closest("tr");
            var seqNo = row.find('input.checkbox:first').val();
            getWorkExperience(<?php echo $employee->empNumber ?>,seqNo);
            showPaneData('addPaneWorkExperience');
            hidePaneData('summaryPaneWorkExperience');

            $("#frmEmpWorkExperience").data('edit', '0'); // In view mode
            setWorkExperienceAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
        });

        // Add a work experience record
        $('#btnAddWorkExperience').click(function() {
            $('#btnEditWorkExperience').show();
            buttonSecurityCommon(null,"btnEditWorkExperience",null,null);
            $("#txtExpSeqNo").val('');
            $("#txtExpCompanyName").val('');
            $("#txtExpCompanyNameSI").val('');
            $("#txtExpCompanyNameTA").val('');
            $("#txtExpJobTitle").val('');
            $("#txtExpJobTitleSI").val('');
            $("#txtExpJobTitleTA").val('');
            $("#txtExpStartDate").val('');
            $("#txtExpEndDate").val('');
            $("#txtExpComment").val('');
            $("#txtExpCommentSI").val('');
            $("#txtExpCommentTA").val('');
//            $('#chkExpInternal').attr('checked', '');

            showPaneData('addPaneWorkExperience');
            hidePaneData('summaryPaneWorkExperience');

            $("#frmEmpWorkExperience").data('edit', '2'); // In add mode
            setWorkExperienceAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
        });

        // TODO: Move these to a javascript file
        // validation code is based on old javascript methods
        //
        jQuery.validator.addMethod("workExpStartBeforeEnd",
        function(value, element) {

            var hint = '<?php echo $dateHint; ?>';
            var format = '<?php echo $format; ?>';
            var fromDate = strToDate($('#txtExpStartDate').val(), format)
            var toDate = strToDate($('#txtExpEndDate').val(), format);

            if (fromDate && toDate && (fromDate >= toDate)) {
                return false;
            }
            return true;
        }, ""
    );

        $("#frmEmpWorkExperience").validate({
            rules: {
                txtExpCompanyName : {required:true},
                txtExpJobTitle : {required:true},
                txtExpStartDate : {orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, workExpStartBeforeEnd:true, required:true },
                txtExpEndDate : {orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, workExpStartBeforeEnd:true, required:true}
            },
            messages: {
                txtExpCompanyName: '<?php echo __("This field is required.") ?>',
                txtExpJobTitle: '<?php echo __("This field is required.") ?>',
                txtExpStartDate : { orange_date: '<?php echo __("Invalid date."); ?>',
                    workExpStartBeforeEnd: '<?php echo __("Invalid date period."); ?>',
                    required: '<?php echo __("This field is required.") ?>'},
                txtExpEndDate : {orange_date: '<?php echo __("Invalid date."); ?>',
                    workExpStartBeforeEnd: '<?php echo __("Invalid date period."); ?>',
                    required: '<?php echo __("This field is required.") ?>'}
            },
            errorClass: "errortd",

            submitHandler: function(form) {
                $('#btnEditWorkExperience').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
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

        //When click remove button
        var answer=0;
        $("#btnDelWorkExperience").click(function() {
            $("#mode").attr('value', 'delete');
            if($("input[name='chkID[]']").is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
            }

            if (answer !=0 ) {
                $("#frmEmpDelWorkExperience").submit();
            } else {
                return false;
            }
        });

        // Switch edit mode or submit data when edit/save button is clicked
        $("#btnEditWorkExperience").click(function() {

            var editMode = $("#frmEmpWorkExperience").data('edit');
            if (editMode == 0) {
                lockWorkExperience(<?php echo $employee->empNumber ?>,$('#txtExpSeqNo').val());
                return false;
            }
            else {
                $('#frmEmpWorkExperience').submit();

            }
        });

        $('#btnBackWorkExperience').click(function() {
            showPaneData('summaryPaneWorkExperience');
            hidePaneData('addPaneWorkExperience');
        });

        $('#btnResetWorkExperience').click(function() {
            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            // 0 - view, 1 - edit, 2 - add
            var editMode = $("#frmEmpWorkExperience").data('edit');
            if (editMode == 1) {
                unlockWorkExperience(<?php echo $employee->empNumber ?>,$('#txtExpSeqNo').val());
                return false;
            }
            else {
                document.forms['frmEmpWorkExperience'].reset('');
            }
        });
    });
    //]]>
</script>