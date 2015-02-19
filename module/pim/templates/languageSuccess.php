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
        <div class="mainHeading"><h2><?php echo __("Languages"); ?></h2></div>
        <div id="ErrorMSgSerRec">
            <?php echo message(); ?>
        </div>
        <div id="parentPaneLanguages" >
            <?php
            $fluencyTypes = array(EmployeeLanguage::FLUENCY_WRITING => __("Writing"),
                EmployeeLanguage::FLUENCY_SPEAKING => __("Speaking"),
                EmployeeLanguage::FLUENCY_READING => __("Reading"));
            $competencyTypes = array(EmployeeLanguage::COMPETENCY_POOR => __("Poor"),
                EmployeeLanguage::COMPETENCE_BASIC => __("Basic"),
                EmployeeLanguage::COMPETENCE_GOOD => __("Good"),
                EmployeeLanguage::COMPETENCY_MOTHER_TONGUE => __("Mother Tongue"));


            $empLanguages = $employee->languages;







            if (isset($postArr['EditMode']) && $postArr['EditMode'] == '1') {
                $editMode = false;
                $disabled = '';
            } else {
                $editMode = true;
                $disabled = 'disabled="disabled"';
            }
            ?>
            <form name="frmEmpLanguage" id="frmEmpLanguage" method="post" action="<?php echo url_for('pim/updateLanguage?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="txtLanCode" id="txtLanCode" value=""/>
                <input type="hidden" name="txtLanType" id="txtLanType" value=""/>

                <div id="addPaneLanguage" style="display:none;">

                    <div class="leftCol">
                        <label for="cmbLanName"><?php echo __("Language"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <select class="formSelect" <?php echo $disabled; ?> id="cmbLanName" name="cmbLanName">
                            <option value=""><?php echo __("--Select--"); ?></option>
                            <?php
                            //Define data columns according culture
                            $langNameCol = ($userCulture == "en") ? "lang_name" : "lang_name_" . $userCulture;
                            if ($languages) {
                                foreach ($languages as $lang) {
                                    $langName = $lang->$langNameCol == "" ? $lang->lang_name : $lang->$langNameCol;
                                    echo "<option value='{$lang->lang_code}'>{$langName}</option>";
                                }
                            }
                            ?>
                        </select>
                        <label id="lblLanName" style="display:none;font-weight:bold;"></label>
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="cmbLanFluency"><?php echo __("Fluency"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <select class="formSelect" <?php echo $disabled; ?> id="cmbLanFluency" name="cmbLanFluency">
                            <option value=""><?php echo __("--Select--"); ?></option>
                            <?php
                            foreach ($fluencyTypes as $id => $fluency) {
                                echo "<option value='" . $id . "'>" . $fluency . "</option>";
                            }
                            ?>
                        </select>
                        <label id="lblLanFluency" style="display:none;font-weight:bold;"></label>
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="cmbLanCompetency"><?php echo __("Competency"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <select class="formSelect" <?php echo $disabled; ?> id="cmbLanCompetency" name="cmbLanCompetency">
                            <option value=""><?php echo __("--Select--"); ?></option>
                            <?php
                            foreach ($competencyTypes as $id => $competency) {
                                echo "<option value='" . $id . "'>" . $competency . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br class="clear"/>


                    <div class="formbuttons">
                        <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditLanguage" id="btnEditLanguage"
                               value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" value="<?php echo __("Reset"); ?>" name="btnResetLanguage" id="btnResetLanguage"/>
                        <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackLanguage" />
                    </div>

                </div>
            </form>
            <form name="frmEmpDelLanguage" id="frmEmpDelLanguage" method="post" action="<?php echo url_for('pim/deleteLanguages?empNumber=' . $employee->empNumber); ?>">

                <div id="summaryPaneLanguage" >
                    <div class="subHeading"></div>
                    <div class="actionbar">
                        <div class="actionbuttons">


                            <input type="button" class="addbutton" id="btnAddLanguage"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>


                            <input type="button" class="delbutton" id="btnDelLanguage"
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
                                    <?php echo __('Language'); ?>
                                </td>
                                <td scope="col">
                                    <?php echo __('Fluency'); ?>
                                </td>
                                <td scope="col">
                                    <?php echo __('Competency'); ?>
                                </td>
                                <td style="display:none"></td>
                                <td style="display:none"></td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $row = 0;
                            foreach ($empLanguages as $empLang) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                                ?>

                                <tr class="<?php echo $cssClass ?>">
                                    <td>
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $empLang->lang_code . "|" . $empLang->emplang_type ?>' />
                                    </td>
                                    <td class="">
                                        <a href="#"><?php
                            if ($userCulture == 'en') {
                                echo $empLang->Language->lang_name;
                            } else {
                                $language = 'lang_name_' . $userCulture;
                                echo $empLang->Language->$language;
                                if ($empLang->Language->$language == null) {
                                    echo $empLang->Language->lang_name;
                                }
                            }
                                ?></a>
                                    </td>
                                    <td class="">
                                        <?php echo $fluencyTypes[$empLang->emplang_type] ?>
                                    </td>
                                    <td class="">
                                        <?php echo $competencyTypes[$empLang->emplang_competency] ?>
                                    </td>
                                    <td style="display:none">
                                        <?php echo $empLang->lang_code ?>
                                    </td>
                                    <td style="display:none">
                                        <?php echo $empLang->emplang_type ?>
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

    function getEmpLanguages(empNumber,langCode,langType){
        $.post("<?php echo url_for('pim/getEmpLanguageById') ?>",
        { empNumber: empNumber, langCode: langCode,langType: langType },
        function(data){

            if(data==null){
                alert("<?php echo __("record is not found") ?>");
                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/language')) ?>";
            }else{
                setEmpLanguageData(data);
            }

        },
        "json"
    );
    }

    function lockEmpLanguage(empNumber,langCode,langType){
        $.post("<?php echo url_for('pim/lockEmpLanguage') ?>",
        { empNumber: empNumber, langCode: langCode,langType: langType },
        function(data){
            if (data.recordLocked==true) {
                getEmpLanguages(empNumber,langCode,langType);
                $("#frmEmpLanguage").data('edit', '1'); // In edit mode
                setEmpLanguageAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
    );
    }

    function unlockEmpLanguage(empNumber,langCode,langType){
        $.post("<?php echo url_for('pim/unlockEmpLanguage') ?>",
        { empNumber: empNumber, langCode: langCode,langType: langType },
        function(data){
            getEmpLanguages(empNumber,langCode,langType);
            $("#frmEmpLanguage").data('edit', '0'); // In view mode
            setEmpLanguageAttributes();
        },
        "json"
    );
    }

    function setEmpLanguageData(data){
        $("#txtLanCode").val(data.lang_code);
        $("#txtLanType").val(data.emplang_type);
        $("#cmbLanName").val(data.lang_code);
        $("#cmbLanFluency").val(data.emplang_type);
        $("#cmbLanCompetency").val(data.emplang_competency);
    }

    function setEmpLanguageAttributes() {

        var editMode = $("#frmEmpLanguage").data('edit');
        if (editMode == 0) {
            $('#frmEmpLanguage :input').attr('disabled','disabled');

            $('#btnEditLanguage').removeAttr('disabled');
            $('#btnBackLanguage').removeAttr('disabled');

            $("#btnEditLanguage").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnEditLanguage").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {
            $('#frmEmpLanguage :input').removeAttr('disabled');

            $("#btnEditLanguage").attr('value',"<?php echo __("Save"); ?>");
            $("#btnEditLanguage").attr('title',"<?php echo __("Save"); ?>");
        }
    }

    $(document).ready(function() {

        $("#frmEmpLanguage").validate({
            rules: {
                cmbLanName : {required:true},
                cmbLanFluency : {required:true},
                cmbLanCompetency : {required:true}
            },
            messages: {
                cmbLanName: { required:"<?php echo __("This field is required."); ?>"},
                cmbLanFluency: { required:"<?php echo __("This field is required."); ?>"},
                cmbLanCompetency: { required:"<?php echo __("This field is required."); ?>"}
            },
            errorClass: "errortd",
            submitHandler: function(form) {
                $('#btnEditLanguage').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                form.submit();
            }
        });

        buttonSecurityCommon("btnAddLanguage",null,null,"btnDelLanguage");

        showPaneData('summaryPaneLanguage');
        hidePaneData('addPaneLanguage');

        // Edit a emergency contact in the list
        $('#frmEmpDelLanguage a').click(function() {

            buttonSecurityCommon(null,null,"btnEditLanguage",null);
            $('#ErrorMSgSerRe').hide();
            var row = $(this).closest("tr");
            var code = row.find('input.checkbox:first').val().split('|');

            var langName = row.find("td:nth-child(2)").text();
            var fluencyName = row.find("td:nth-child(3)").text();
            var langCode = code[0];
            var langType = code[1];

            getEmpLanguages(<?php echo $employee->empNumber ?>,langCode,langType);
            showPaneData('addPaneLanguage');
            hidePaneData('summaryPaneLanguage');

            $("#frmEmpLanguage").data('edit', '0'); // In view mode
            setEmpLanguageAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            $('#cmbLanName').css('display', 'none');
            $('#lblLanName').css('display', '');

            $('#cmbLanFluency').css('display', 'none');
            $('#lblLanFluency').css('display', '');

            $("#lblLanName").text(langName);
            $("#lblLanFluency").text(fluencyName);
        });

        // Add a emergency contact
        $('#btnAddLanguage').click(function() {
            $("#btnEditLanguage").show();
            buttonSecurityCommon(null,"btnEditLanguage",null,null);
            $('#ErrorMSgSerRe').hide();
            $("#txtLanCode").val('');
            $("#txtLanType").val('');
            $("#cmbLanName").val('');
            $("#cmbLanFluency").val('');
            $("#cmbLanCompetency").val('');

            showPaneData('addPaneLanguage');
            hidePaneData('summaryPaneLanguage');

            $("#frmEmpLanguage").data('edit', '2'); // In add mode
            setEmpLanguageAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            $('#cmbLanName').css('display', '');
            $('#lblLanName').css('display', 'none');

            $('#cmbLanFluency').css('display', '');
            $('#lblLanFluency').css('display', 'none');

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
        $("#btnDelLanguage").click(function() {
            $("#mode").attr('value', 'delete');
            if($("input[name='chkID[]']").is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
            }

            if (answer !=0 ) {
                $("#frmEmpDelLanguage").submit();
            } else {
                return false;
            }
        });

        // Switch edit mode or submit data when edit/save button is clicked
        $("#btnEditLanguage").click(function() {
            $('#ErrorMSgSerRe').hide();
            var editMode = $("#frmEmpLanguage").data('edit');
            if (editMode == 0) {
                lockEmpLanguage(<?php echo $employee->empNumber ?>,$('#txtLanCode').val(),$('#txtLanType').val());
                return false;
            }
            else {
                $('#frmEmpLanguage').submit();
            }
        });

        $('#btnBackLanguage').click(function() {
            $('#ErrorMSgSerRe').hide();
            showPaneData('summaryPaneLanguage');
            hidePaneData('addPaneLanguage');
        });

        $('#btnResetLanguage').click(function() {
            $('#ErrorMSgSerRe').hide();
            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            // 0 - view, 1 - edit, 2 - add
            var editMode = $("#frmEmpLanguage").data('edit');
            if (editMode == 1) {
                unlockEmpLanguage(<?php echo $employee->empNumber ?>,$('#txtLanCode').val(),$('#txtLanType').val());
                return false;
            }
            else {
                document.forms['frmEmpLanguage'].reset('');
            }
        });

    });
    //]]>
</script>