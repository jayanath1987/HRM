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
        <div class="mainHeading"><h2><?php echo __("Skills"); ?></h2></div>
        <div id="ErrorMSgSerRec">
            <?php echo message(); ?>
        </div>
        <div id="parentPaneSkills" >
            <?php
            $empSkills = $employee->skills;

            $allowEdit = $locRights['add'] || $locRights['ESS'] || $locRights['supervisor'];
            $allowDel = $locRights['delete'] || $locRights['ESS'] || $locRights['supervisor'];
            $disabled = $allowEdit ? '' : 'disabled="disabled"';




            include_partial('pim_form_errors', array('sf_user' => $sf_user));


            if (isset($postArr['EditMode']) && $postArr['EditMode'] == '1') {
                $editMode = false;
                $disabled = '';
            } else {
                $editMode = true;
                $disabled = 'disabled="disabled"';
            }
            ?>

            <form name="frmEmpSkill" id="frmEmpSkill" method="post" action="<?php echo url_for('pim/updateSkill?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="txtSkillCode" id="txtSkillCode" value="" />
                <div id="addPaneSkill" style="display:none;">
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
                        <label for="cmbSkillName"><?php echo __("Skill"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <select class="formSelect" <?php echo $disabled; ?> id="cmbSkillName" name="cmbSkillName">
                            <option value="0"><?php echo __("--Select--"); ?></option>
                            <?php
                            //Define data columns according culture
                            $skillNameCol = ($userCulture == "en") ? "skill_name" : "skill_name_" . $userCulture;
                            if ($unassignedSkills) {
                                foreach ($unassignedSkills as $unSkill) {
                                    $skillName = $unSkill->$skillNameCol == "" ? $unSkill->skill_name : $unSkill->$skillNameCol;
                                    echo "<option value='{$unSkill->skill_code}'>{$skillName}</option>";
                                }
                            }
                            ?>
                        </select>
                        <label id="lblSkillName" style="display:none;font-weight:bold;"></label>
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtSkillYears"><?php echo __("Years of Experience"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtSkillYears" id="txtSkillYears"
                               value="" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtSkillComment"><?php echo __("Comments"); ?></label>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtSkillComment" id="txtSkillComment" maxlength="200"></textarea>
                    </div>
                    <div class="centerCol" >
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtSkillCommentSI" id="txtSkillCommentSI" maxlength="200"></textarea>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtSkillCommentTA" id="txtSkillCommentTA" maxlength="200"></textarea>
                    </div>
                    <br class="clear"/>


                    <div class="formbuttons">
                        <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditSkill" id="btnEditSkill"
                               value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" value="<?php echo __("Reset"); ?>" name="btnResetSkill" id="btnResetSkill"/>
                        <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackSkill" />
                    </div>

                </div>
            </form>
            <form name="frmEmpDelSkill" id="frmEmpDelSkill" method="post" action="<?php echo url_for('pim/deleteSkill?empNumber=' . $employee->empNumber); ?>">

                <div id="summaryPaneSkill" >
                    <div class="subHeading"></div>
                    <div class="actionbar">
                        <div class="actionbuttons">


                            <input type="button" class="addbutton" id="btnAddSkill"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>


                            <input type="button" class="delbutton" id="btnDelSkill"
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
                                    <?php echo __('Skill'); ?>
                                </td>
                                <td scope="col">
                                    <?php echo __('Years of Experience'); ?>
                                </td>
                                <td scope="col">
                                    <?php echo __('Comments'); ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                    $row = 0;
                                    foreach ($empSkills as $empSkill) {
                                        $cssClass = ($row % 2) ? 'even' : 'odd';
                                        $row = $row + 1;

                                        //Define data columns according culture
                                        $skillNameCol = ($userCulture == "en") ? "skill_name" : "skill_name_" . $userCulture;
                                        $skillName = $empSkill->Skill->$skillNameCol == "" ? $empSkill->Skill->skill_name : $empSkill->Skill->$skillNameCol;

                                        $skillCommentCol = ($userCulture == "en") ? "eskill_comments" : "eskill_comments_" . $userCulture;
                                        $skillComment = $empSkill->$skillCommentCol == "" ? $empSkill->eskill_comments : $empSkill->$skillCommentCol;
                            ?>

                                        <tr class="<?php echo $cssClass ?>">
                                            <td >
                                                <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $empSkill->skill_code ?>' />
                                            </td>
                                            <td class="">
                                                <a href="#"><?php echo $skillName; ?></a>
                                            </td>
                                            <td class="">
<?php echo $empSkill->eskill_years; ?>
                                            </td>
                                            <td class="">
<?php echo $skillComment; ?>
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

    function getSkill(empNumber,skillCode){
        $.post("<?php echo url_for('pim/getSkillById') ?>",
                { empNumber: empNumber, skillCode: skillCode },
                function(data){
                    setSkillData(data);
                },
                "json"
            );
            }

            function lockSkill(empNumber,skillCode){
                $.post("<?php echo url_for('pim/lockSkill') ?>",
                { empNumber: empNumber, skillCode: skillCode },
                function(data){
                    if (data.recordLocked==true) {
                        getSkill(empNumber,skillCode);
                        $("#frmEmpSkill").data('edit', '1'); // In edit mode
                        setSkillAttributes();
                    }else {
                        alert("<?php echo __("Record Locked.") ?>");
                    }
                },
                "json"
            );
            }

            function unlockSkill(empNumber,skillCode){
                $.post("<?php echo url_for('pim/unlockSkill') ?>",
                { empNumber: empNumber, skillCode: skillCode },
                function(data){
                    getSkill(empNumber,skillCode);
                    $("#frmEmpSkill").data('edit', '0'); // In view mode
                    setSkillAttributes();
                },
                "json"
            );
            }

            function setSkillData(data){
                $("#txtSkillCode").val(data.skill_code);
                $("#cmbSkillName").val(data.skill_code);
                $("#txtSkillYears").val(data.eskill_years);
                $("#txtSkillComment").val(data.eskill_comments);
                $("#txtSkillCommentSI").val(data.eskill_comments_si);
                $("#txtSkillCommentTA").val(data.eskill_comments_ta);
            }

            function setSkillAttributes() {

                var editMode = $("#frmEmpSkill").data('edit');
                if (editMode == 0) {
                    $('#frmEmpSkill :input').attr('disabled','disabled');

                    $('#btnEditSkill').removeAttr('disabled');
                    $('#btnBackSkill').removeAttr('disabled');

                    $("#btnEditSkill").attr('value',"<?php echo __("Edit"); ?>");
                    $("#btnEditSkill").attr('title',"<?php echo __("Edit"); ?>");
                }
                else {
                    $('#frmEmpSkill :input').removeAttr('disabled');

                    $("#btnEditSkill").attr('value',"<?php echo __("Save"); ?>");
                    $("#btnEditSkill").attr('title',"<?php echo __("Save"); ?>");
                }
            }

            $(document).ready(function() {

                buttonSecurityCommon("btnAddSkill",null,null,"btnDelSkill");
                showPaneData('summaryPaneSkill');
                hidePaneData('addPaneSkill');

                // Edit a work experiance data in the list
                $('#frmEmpDelSkill a').click(function() {


                    buttonSecurityCommon(null,null,"btnEditSkill",null);
                    var row = $(this).closest("tr");
                    var skillCode = row.find('input.checkbox:first').val();
                    var skillName = row.find("td:nth-child(2)").text();
                    getSkill(<?php echo $employee->empNumber ?>,skillCode);
                    showPaneData('addPaneSkill');
                    hidePaneData('summaryPaneSkill');

                    $("#frmEmpSkill").data('edit', '0'); // In view mode
                    setSkillAttributes();

                    // hide validation error messages
                    $("label.errortd[generated='true']").css('display', 'none');

                    $('#cmbSkillName').css('display', 'none');
                    $('#lblSkillName').css('display', '');

                    $("#lblSkillName").text(skillName);
                });

                // Add a skill record
                $('#btnAddSkill').click(function() {

                    $("#btnEditSkill").show();

                    buttonSecurityCommon(null,"btnEditSkill",null,null);

                    $("#txtSkillCode").val('');
                    $("#cmbSkillName").val('');
                    $("#txtSkillYears").val('');
                    $("#txtSkillComment").val('');
                    $("#txtSkillCommentSI").val('');
                    $("#txtSkillCommentTA").val('');

                    showPaneData('addPaneSkill');
                    hidePaneData('summaryPaneSkill');

                    $("#frmEmpSkill").data('edit', '2'); // In add mode
                    setSkillAttributes();

                    // hide validation error messages
                    $("label.errortd[generated='true']").css('display', 'none');

                    $('#cmbSkillName').css('display', '');
                    $('#lblSkillName').css('display', 'none');

                });

                jQuery.validator.addMethod("skillCode",
                function() {
                    var editMode = $("#frmEmpSkill").data('edit');
                    // Add = 2
                    if (editMode!=2) {
                        return true;
                    } else {
                        var code = $('#cmbSkillName').val();
                        return code != "0";
                    }
                }, ""
            );

                $("#frmEmpSkill").validate({

                    rules: {
                        cmbSkillName : {skillCode:true},
                        txtSkillYears : {noSpecialCharsOnly: true,maxlength:100 },
                        txtSkillComment : {noSpecialCharsOnly: true,maxlength:200 },
                        txtSkillCommentSI : {noSpecialCharsOnly: true,maxlength:200 },
                        txtSkillCommentTA : {noSpecialCharsOnly: true,maxlength:200 }
                    },
                    messages: {
                        cmbSkillName: "<?php echo __("This field is required."); ?>",
                        txtSkillYears: {maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                        txtSkillComment: {maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                        txtSkillCommentSI: {maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                        txtSkillCommentTA: {maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}
                        
                        
                    },
                    errorClass: "errortd",
                   submitHandler: function(form) {
                   $('#btnEditSkill').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
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
                $("#btnDelSkill").click(function() {
                    $("#mode").attr('value', 'delete');
                    if($("input[name='chkID[]']").is(':checked')){
                        answer = confirm("<?php echo __("Do you really want to delete?") ?>");
                    } else {
                        alert("<?php echo __("Select at least one check box to delete") ?>");
                    }

                    if (answer !=0 ) {
                        $("#frmEmpDelSkill").submit();
                    } else {
                        return false;
                    }
                });

                // Switch edit mode or submit data when edit/save button is clicked
                $("#btnEditSkill").click(function() {

                    var editMode = $("#frmEmpSkill").data('edit');
                    if (editMode == 0) {
                        lockSkill(<?php echo $employee->empNumber ?>,$('#txtSkillCode').val());
                        return false;
                    }
                    else {
                        $('#frmEmpSkill').submit();
                    }
                });

                $('#btnBackSkill').click(function() {
                    showPaneData('summaryPaneSkill');
                    hidePaneData('addPaneSkill');
                });

                $('#btnResetSkill').click(function() {
                    // hide validation error messages
                    $("label.errortd[generated='true']").css('display', 'none');

                    // 0 - view, 1 - edit, 2 - add
                    var editMode = $("#frmEmpSkill").data('edit');
                    if (editMode == 1) {
                        unlockSkill(<?php echo $employee->empNumber ?>,$('#txtSkillCode').val());
                return false;
            }
            else {
                document.forms['frmEmpSkill'].reset('');
            }
        });
    });
    //]]>
</script>