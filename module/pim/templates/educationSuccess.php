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
        <div class="mainHeading"><h2><?php echo __("Education"); ?></h2></div>
        <div id="ErrorMSgSerRec">
            <?php echo message(); ?>
        </div>

        <div id="parentPaneducation" >
            <?php
            $empEducation = $employee->educationList;

            $allowEdit = $locRights['add'] || $locRights['ESS'] || $locRights['supervisor'];
            $allowDel = $locRights['delete'] || $locRights['ESS'] || $locRights['supervisor'];
            $disabled = $allowEdit ? '' : 'disabled="disabled"';



            if ($currentPane == 9) {
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

            <form name="frmEmpEducation" id="frmEmpEducation" method="post" action="<?php echo url_for('pim/updateEducation?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="txtEduCode" id="txtEduCode" value="" />

                <div id="addPaneEducation" style="display:none;">
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
                        <label for="cmbEduName"><?php echo __("Education"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <select class="formSelect" <?php echo $disabled; ?> id="cmbEduName" name="cmbEduName">
                            <option value="0"><?php echo __("--Select--"); ?></option>
<?php
            //Define data columns according culture
            $eduNameCol = ($userCulture == "en") ? "edu_name" : "edu_name_" . $userCulture;
            if ($unassignedEducationList) {
                foreach ($unassignedEducationList as $unEdu) {
                    $eduName = $unEdu->$eduNameCol == "" ? $unEdu->edu_name : $unEdu->$eduNameCol;
                    echo "<option value='{$unEdu->edu_code}'>{$eduName}</option>";
                }
            }
?>
                        </select>
                        <label id="lblEduName" style="display:none;font-weight:bold;"></label>
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtEduInstitute"><?php echo __("Institute Name"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEduInstitute" id="txtEduInstitute"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEduInstituteSI" id="txtEduInstituteSI"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEduInstituteTA" id="txtEduInstituteTA"
                               value="" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtEduStream"><?php echo __("Stream"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEduStream" id="txtEduStream"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEduStreamSI" id="txtEduStreamSI"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEduStreamTA" id="txtEduStreamTA"
                               value="" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtEduStartDate"><?php echo __("Start Date"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" name="txtEduStartDate" id="txtEduStartDate" value="">
                    </div>
                    <div class="centerCol">
                        <label for="txtEduEndDate"><?php echo __("End Date"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" name="txtEduEndDate" id="txtEduEndDate" value="">
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtEduIndex"><?php echo __("Index"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEduIndex" id="txtEduIndex"
                               value="" maxlength="50" />
                    </div>
                    <div class="centerCol">
                        <label for="chkEduConfirmed"><?php echo __("Result Confirmed"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="checkbox" class="formPIMCheckBox" name="chkEduConfirmed" id="chkEduConfirmed" <?php echo $disabled; ?> value="1" />
                    </div>
                    <br class="clear"/>


                    <div class="formbuttons">
                        <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditEducation" id="btnEditEducation"
                               value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" value="<?php echo __("Reset"); ?>" name="btnResetEducation" id="btnResetEducation"/>
                        <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackEducation" />
                    </div>

                </div>
            </form>
            <form name="frmEmpDelEducation" id="frmEmpDelEducation" method="post" action="<?php echo url_for('pim/deleteEducation?empNumber=' . $employee->empNumber); ?>">

                <div id="summaryPaneEducation" >
                    <div class="subHeading"></div>
                    <div class="actionbar">
                        <div class="actionbuttons">


                            <input type="button" class="addbutton" id="btnAddEducation"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>

                            <input type="button" class="delbutton" id="btnDelEducation"
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
<?php echo __('Education'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Institute Name'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Stream'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Start Date'); ?>
                                </td>
                                <td scope="col">
<?php echo __('End Date'); ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody>
<?php
                            $row = 0;
                            foreach ($empEducation as $empEdu) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;

                                //Define data columns according culture
                                $educationNameCol = ($userCulture == "en") ? "edu_name" : "edu_name_" . $userCulture;
                                $educationName = $empEdu->Education->$educationNameCol == "" ? $empEdu->Education->edu_name : $empEdu->Education->$educationNameCol;

                                $instituteCol = ($userCulture == "en") ? "edu_institute" : "edu_institute_" . $userCulture;
                                $institute = $empEdu->$instituteCol == "" ? $empEdu->edu_institute : $empEdu->$instituteCol;

                                $streamCol = ($userCulture == "en") ? "edu_stream" : "edu_stream_" . $userCulture;
                                $stream = $empEdu->$streamCol == "" ? $empEdu->edu_stream : $empEdu->$streamCol;
?>

                                <tr class="<?php echo $cssClass ?>">
                                    <td >
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $empEdu->edu_code ?>' />
                                    </td>
                                    <td class="">
                                        <a href="#"><?php echo $educationName; ?></a>
                                    </td>
                                    <td class="">
<?php echo $institute; ?>
                                    </td>
                                    <td class="">
<?php echo $stream; ?>
                                </td>
                                <td class="">
<?php echo LocaleUtil::getInstance()->formatDate($empEdu->edu_start_date); ?>
                                </td>
                                <td class="">
<?php echo LocaleUtil::getInstance()->formatDate($empEdu->edu_end_date); ?>
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

    function getEducation(empNumber,eduCode){
        $.post("<?php echo url_for('pim/getEducationById') ?>",
        { empNumber: empNumber, eduCode: eduCode },
        function(data){
            setEducationData(data);
        },
        "json"
    );
    }

    function lockEducation(empNumber,eduCode){
        $.post("<?php echo url_for('pim/lockEducation') ?>",
        { empNumber: empNumber, eduCode: eduCode },
        function(data){
            if (data.recordLocked==true) {
                getEducation(empNumber,eduCode);
                $("#frmEmpEducation").data('edit', '1'); // In edit mode
                setEducationAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
    );
    }

    function unlockEducation(empNumber,eduCode){
        $.post("<?php echo url_for('pim/unlockEducation') ?>",
        { empNumber: empNumber, eduCode: eduCode },
        function(data){
            getEducation(empNumber,eduCode);
            $("#frmEmpEducation").data('edit', '0'); // In view mode
            setEducationAttributes();
        },
        "json"
    );
    }

    function setEducationData(data){
        $("#txtEduCode").val(data.edu_code);
        $("#cmbEduName").val(data.edu_code);
        $("#txtEduInstitute").val(data.edu_institute);
        $("#txtEduInstituteSI").val(data.edu_institute_si);
        $("#txtEduInstituteTA").val(data.edu_institute_ta);
        $("#txtEduStream").val(data.edu_stream);
        $("#txtEduStreamSI").val(data.edu_stream_si);
        $("#txtEduStreamTA").val(data.edu_stream_ta);
        $("#txtEduStartDate").val(data.edu_start_date);
        $("#txtEduEndDate").val(data.edu_end_date);
        $("#txtEduIndex").val(data.edu_index_no);

        if (data.edu_confirmed_flg==1) {
            $('#chkEduConfirmed').attr('checked', 'checked');
        } else {
            $('#chkEduConfirmed').removeAttr('checked');
        }
    }

    function setEducationAttributes() {

        var editMode = $("#frmEmpEducation").data('edit');
        if (editMode == 0) {
            $('#frmEmpEducation :input').attr('disabled','disabled');

            $('#btnEditEducation').removeAttr('disabled');
            $('#btnBackEducation').removeAttr('disabled');

            $("#btnEditEducation").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnEditEducation").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {
            $('#frmEmpEducation :input').removeAttr('disabled');

            $("#btnEditEducation").attr('value',"<?php echo __("Save"); ?>");
            $("#btnEditEducation").attr('title',"<?php echo __("Save"); ?>");
        }
    }

    $(document).ready(function() {
    
        buttonSecurityCommon("btnAddEducation",null,null,"btnDelEducation");
        showPaneData('summaryPaneEducation');
        hidePaneData('addPaneEducation');
        $("#txtEduStartDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
        $("#txtEduEndDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });

        // Edit a edu Edueriance data in the list
        $('#frmEmpDelEducation a').click(function() {
        
            buttonSecurityCommon(null,null,"btnEditEducation",null);
            var row = $(this).closest("tr");
            var eduCode = row.find('input.checkbox:first').val();
            var eduName = row.find("td:nth-child(2)").text();
            getEducation(<?php echo $employee->empNumber ?>,eduCode);
            showPaneData('addPaneEducation');
            hidePaneData('summaryPaneEducation');

            $("#frmEmpEducation").data('edit', '0'); // In view mode
            setEducationAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            $('#cmbEduName').css('display', 'none');
            $('#lblEduName').css('display', '');

            $("#lblEduName").text(eduName);
        });

        // Add a edu Eduerience record
        $('#btnAddEducation').click(function() {
            $('#btnEditEducation').show();
            buttonSecurityCommon(null,"btnEditEducation",null,null);
            $("#txtEduCode").val('');
            $("#cmbEduName").val('');
            $("#txtEduInstitute").val('');
            $("#txtEduInstituteSI").val('');
            $("#txtEduInstituteTA").val('');
            $("#txtEduStream").val('');
            $("#txtEduStreamSI").val('');
            $("#txtEduStreamTA").val('');
            $("#txtEduStartDate").val('');
            $("#txtEduEndDate").val('');
            $("#txtEduIndex").val('');
            $('#chkEduConfirmed').attr('checked', '');

            showPaneData('addPaneEducation');
            hidePaneData('summaryPaneEducation');

            $("#frmEmpEducation").data('edit', '2'); // In add mode
            setEducationAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
        
            $('#cmbEduName').css('display', '');
            $('#lblEduName').css('display', 'none');
        });
    
        jQuery.validator.addMethod("eduEduStartBeforeEnd",
        function(value, element) {

            var hint = '<?php echo $dateHint; ?>';
            var format = '<?php echo $format; ?>';
            var fromDate = strToDate($('#txtEduStartDate').val(), format)
            var toDate = strToDate($('#txtEduEndDate').val(), format);

            if (fromDate && toDate && (fromDate >= toDate)) {
                return false;
            }
            return true;
        }, ""
    );

        jQuery.validator.addMethod("eduCode",
        function() {
            var editMode = $("#frmEmpEducation").data('edit');
            // Add = 2
            if (editMode!=2) {
                return true;
            } else {
                var code = $('#cmbEduName').val();
                return code != "0";
            }
        }, ""
    );
   
        $("#frmEmpEducation").validate({
            rules: {
                cmbEduName : {eduCode: true},
                txtEduInstitute : {required:true},
                txtEduStream : {required:true},
                txtEduStartDate : {orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, eduEduStartBeforeEnd:true },
                txtEduEndDate : {orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, eduEduStartBeforeEnd:true, required:true}
            },
            messages: {
                cmbEduName: '<?php echo __("This field is required.") ?>',
                txtEduInstitute: '<?php echo __("This field is required.") ?>',
                txtEduStream: '<?php echo __("This field is required.") ?>',
                txtEduStartDate : {orange_date: '<?php echo __("Invalid date."); ?>',
                    eduEduStartBeforeEnd: '<?php echo __("Invalid date period."); ?>'},
                txtEduEndDate : {orange_date: '<?php echo __("Invalid date."); ?>',
                    eduEduStartBeforeEnd: '<?php echo __("Invalid date period."); ?>',
                    required: '<?php echo __("This field is required.") ?>'}
            },
            errorClass: "errortd",
                   submitHandler: function(form) {
                   $('#btnEditEducation').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
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
        $("#btnDelEducation").click(function() {
            $("#mode").attr('value', 'delete');
            var answer="";
            if($("input[name='chkID[]']").is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
            }

            if (answer !=0 ) {
                $("#frmEmpDelEducation").submit();
            } else {
                return false;
            }
        });

        // Switch edit mode or submit data when edit/save button is clicked
        $("#btnEditEducation").click(function() {

            var editMode = $("#frmEmpEducation").data('edit');
            if (editMode == 0) {
                lockEducation(<?php echo $employee->empNumber ?>,$('#txtEduCode').val());
                return false;
            }
            else {
                $('#frmEmpEducation').submit();
            }
        });

        $('#btnBackEducation').click(function() {
            showPaneData('summaryPaneEducation');
            hidePaneData('addPaneEducation');
        });

        $('#btnResetEducation').click(function() {
            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            // 0 - view, 1 - edit, 2 - add
            var editMode = $("#frmEmpEducation").data('edit');
            if (editMode == 1) {
                unlockEducation(<?php echo $employee->empNumber ?>,$('#txtEduCode').val());
                return false;
            }
            else {
                document.forms['frmEmpEducation'].reset('');
            }
        });
    });
    //]]>
</script>