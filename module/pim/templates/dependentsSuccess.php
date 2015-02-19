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
 *
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
<div id="parentPaneDependent" >
    <?php
    $dependents = $employee->dependents;
    $numContacts = count($dependents);
    $haveContacts = $numContacts > 0;



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
    <div id="personal" class="pimpanel formPIM">
        <div class="outerbox">
            <div class="mainHeading"><h2><?php echo __("Dependents"); ?></h2></div>
            <div id="errMessage">
<?php echo message(); ?>
            </div>
            <form name="frmEmpDependent" id="frmEmpDependent" method="post" action="<?php echo url_for('pim/updateDependent?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="txtDepSeqNo" id="txtDepSeqNo" value="" />

                <div id="addPaneDependent" style="display:none;">
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
                        <label for="txtDepName"><?php echo __("Name"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtDepName" id="txtDepName"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtDepNameSI" id="txtDepNameSI"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtDepNameTA" id="txtDepNameTA"
                               value="" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="cmbDepRelationship"><?php echo __("Relationship"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <select class="formSelect" <?php echo $disabled; ?> id="cmbDepRelationship" name="cmbDepRelationship">
                            <option value="0"><?php echo __("--Select--"); ?></option>
<?php
    //Define data columns according culture
    $relationshipCol = ($userCulture == "en") ? "rel_name" : "rel_name_" . $userCulture;
    if ($empRelationships) {
        foreach ($empRelationships as $relationship) {
            $relName = $relationship->$relationshipCol == "" ? $relationship->rel_name : $relationship->$relationshipCol;
            echo "<option value='{$relationship->rel_code}'>{$relName}</option>";
        }
    }
?>
                        </select>
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtDepDOB"><?php echo __("Date Of Birth"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" name="txtDepDOB" id="txtDepDOB" value="">
                    </div>
                    <br class="clear"/>

                    <div id="paneWorkData">
                        <div class="leftCol">
                            <label for="txtDepWorkplace"><?php echo __("Work Place"); ?></label>
                        </div>
                        <div class="centerCol">
                            <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepWorkplace" id="txtDepWorkplace" maxlength="200"></textarea>
                        </div>
                        <div class="centerCol">
                            <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepWorkplaceSI" id="txtDepWorkplaceSI" maxlength="200"></textarea>
                        </div>
                        <div class="centerCol">
                            <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepWorkplaceTA" id="txtDepWorkplaceTA" maxlength="200"></textarea>
                        </div>
                        <br class="clear"/>
                    </div>

                    <div id="paneChildData">
                        <div class="leftCol">
                            <label for="txtDepEduCenter"><?php echo __("Name of the School"); ?></label>
                        </div>
                        <div class="centerCol">
                            <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtDepEduCenter" id="txtDepEduCenter"
                                   value="" maxlength="100" />
                        </div>
                        <div class="centerCol">
                            <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtDepEduCenterSI" id="txtDepEduCenterSI"
                                   value="" maxlength="100" />
                        </div>
                        <div class="centerCol">
                            <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtDepEduCenterTA" id="txtDepEduCenterTA"
                                   value="" maxlength="100" />
                        </div>
                        <br class="clear"/>

                        <div class="leftCol">
                            <label for="txtDepAddress"><?php echo __("Address"); ?></label>
                        </div>
                        <div class="centerCol">
                            <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepAddress" id="txtDepAddress" maxlength="200"></textarea>
                        </div>
                        <div class="centerCol">
                            <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepAddressSI" id="txtDepAddressSI" maxlength="200"></textarea>
                        </div>
                        <div class="centerCol">
                            <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepAddressTA" id="txtDepAddressTA" maxlength="200"></textarea>
                        </div>
                        <br class="clear"/>
                    </div>

                    <div class="leftCol">
                        <label for="txtDepComment"><?php echo __("Comments"); ?></label>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepComment" id="txtDepComment" maxlength="200"></textarea>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepCommentSI" id="txtDepCommentSI" maxlength="200"></textarea>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtDepCommentTA" id="txtDepCommentTA" maxlength="200"></textarea>
                    </div>
                    <br class="clear"/>

                    <div class="formbuttons">
                        <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditDependent" id="btnEditDependent"
                               value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" value="<?php echo __("Reset"); ?>" name="btnResetDependent" id="btnResetDependent"/>
                        <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackDependent" />
                    </div>
                </div>
            </form>
            <form name="frmEmpDelDependent" id="frmEmpDelDependent" method="post" action="<?php echo url_for('pim/deleteDependents?empNumber=' . $employee->empNumber); ?>">

                <div id="summaryPaneDependent" >
                    <div class="subHeading"></div>
                    <div class="actionbar">
                        <div class="actionbuttons">

                            <input type="button" class="addbutton" id="btnAddDependent"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>

                            <input type="button" class="delbutton" id="btnDelDependent"
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
<?php echo __('Name'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Relationship'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Date Of Birth'); ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody>
<?php
                            $row = 0;
                            foreach ($dependents as $empDependent) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;

                                //Define data columns according culture
                                $dependentNameCol = ($userCulture == "en") ? "name" : "name_" . $userCulture;
                                $dependentName = $empDependent->$dependentNameCol == "" ? $empDependent->name : $empDependent->$dependentNameCol;

                                $relNameCol = ($userCulture == "en") ? "rel_name" : "rel_name_" . $userCulture;
                                $relName = $empDependent->EmpRelationship->$relNameCol == "" ? $empDependent->EmpRelationship->rel_name : $empDependent->EmpRelationship->$relNameCol;

                                $addressCol = ($userCulture == "en") ? "address" : "address_" . $userCulture;
                                $address = $empDependent->$addressCol == "" ? $empDependent->address : $empDependent->$addressCol;

                                $dob = $empDependent->birthday;
?>

                                <tr class="<?php echo $cssClass ?>">
                                    <td >
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $empDependent->seqno ?>' />
                                    </td>
                                    <td class="">
                                        <a href="#"><?php echo $dependentName ?></a>
                                    </td>
                                    <td class="">
<?php echo $relName ?>
                                    </td>
                                    <td class="">
<?php echo LocaleUtil::getInstance()->formatDate($dob); ?>
                                </td>                               
                            </tr>
<?php } ?>
                        </tbody>

                    </table>
                </div>
            </form>
<?php //}  ?>
        </div>
    </div>
</div>
<?php         $e = getdate();
        $today = date("Y-m-d", $e[0]); 
        ?>
<script type="text/javascript">
    //<![CDATA[

    function getDependentContacts(empNumber,seqNo){
        $.post("<?php echo url_for('pim/getDependentContactById') ?>",
                        { empNumber: empNumber, seqNo: seqNo },
                        function(data){
                            if(data==null){
                                alert("<?php echo __("record is not found") ?>");
                                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/dependents')) ?>";
                            }else{
                                setDependentData(data);
                            }
                        },
                        "json"
                    );
                    }

                    function lockDependentContacts(empNumber,seqNo){
                        $.post("<?php echo url_for('pim/lockDependentContact') ?>",
                        { empNumber: empNumber, seqNo: seqNo },
                        function(data){
                            if (data.recordLocked==true) {
                                getDependentContacts(empNumber,seqNo);
                                $("#frmEmpDependent").data('edit', '1'); // In edit mode
                                setDependentAttributes();
                            }else {
                                alert("<?php echo __("Record Locked.") ?>");
                            }
                        },
                        "json"
                    );
                    }

                    function unlockDependentContacts(empNumber,seqNo){
                        $.post("<?php echo url_for('pim/unlockDependentContact') ?>",
                        { empNumber: empNumber, seqNo: seqNo },
                        function(data){
                            getDependentContacts(empNumber,seqNo);
                            $("#frmEmpDependent").data('edit', '0'); // In view mode
                            setDependentAttributes();
                        },
                        "json"
                    );
                    }

                    function setDependentData(data){
                        $("#txtDepSeqNo").val(data.seqno);
                        $("#txtDepName").val(data.name);
                        $("#txtDepNameSI").val(data.name_si);
                        $("#txtDepNameTA").val(data.name_ta);
                        $("#cmbDepRelationship").val(data.rel_code);
                        $("#txtDepDOB").val(data.birthday);
                        $("#txtDepWorkplace").val(data.workplace);
                        $("#txtDepWorkplaceSI").val(data.workplace_si);
                        $("#txtDepWorkplaceTA").val(data.workplace_ta);
                        $("#txtDepEduCenter").val(data.education_center);
                        $("#txtDepEduCenterSI").val(data.education_center_si);
                        $("#txtDepEduCenterTA").val(data.education_center_ta);
                        $("#txtDepAddress").val(data.address);
                        $("#txtDepAddressSI").val(data.address_si);
                        $("#txtDepAddressTA").val(data.address_ta);
                        $("#txtDepComment").val(data.comments);
                        $("#txtDepCommentSI").val(data.comments_si);
                        $("#txtDepCommentTA").val(data.comments_ta);

                        // School details displayed only for son and daughter
                        if(data.rel_code == '2' || data.rel_code == '8')
                        {
                            $("#paneChildData").show();
                            $("#paneWorkData").hide();
                        }else
                        {
                            $("#paneChildData").hide();
                            $("#paneWorkData").show();
                        }
                    }

                    function setDependentAttributes() {

                        var editMode = $("#frmEmpDependent").data('edit');
                        if (editMode == 0) {
                            $('#frmEmpDependent :input').attr('disabled','disabled');

                            $('#btnEditDependent').removeAttr('disabled');
                            $('#btnBackDependent').removeAttr('disabled');

                            $("#btnEditDependent").attr('value',"<?php echo __("Edit"); ?>");
                            $("#btnEditDependent").attr('title',"<?php echo __("Edit"); ?>");
                        }
                        else {
                            $('#frmEmpDependent :input').removeAttr('disabled');

                            $("#btnEditDependent").attr('value',"<?php echo __("Save"); ?>");
                            $("#btnEditDependent").attr('title',"<?php echo __("Save"); ?>");
                        }
                    }

                    $(document).ready(function() {

                        buttonSecurityCommon("btnAddDependent",null,null,"btnDelDependent");
                        showPaneData('summaryPaneDependent');
                        hidePaneData('addPaneDependent');
                        $("#txtDepDOB").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });

                        // Edit a emergency contact in the list
                        $('#frmEmpDelDependent a').click(function() {

                            buttonSecurityCommon(null,null,"btnEditDependent",null);
                            $("#errMessage").hide();
                            var row = $(this).closest("tr");
                            var seqNo = row.find('input.checkbox:first').val();
                            getDependentContacts(<?php echo $employee->empNumber ?>,seqNo);
                            showPaneData('addPaneDependent');
                            hidePaneData('summaryPaneDependent');

                            $("#frmEmpDependent").data('edit', '0'); // In view mode
                            setDependentAttributes();

                            // hide validation error messages
                            $("label.errortd[generated='true']").css('display', 'none');
                        });
                        
                        //Translatioon
                        
                        $('#txtDepName').blur(function() {

                        $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                        { inputName: $('#txtDepName').val(), sourceLanguage: 0,type: "N",currentLan:"E" },

                        function(data){
                        if(data!=null){

                        if($("#txtDepNameSI").val()==""){
                        $("#txtDepNameSI").val(data.sinhala);
                        }
                         if($("#txtDepNameTA").val()==""){
                        $("#txtDepNameTA").val(data.tamil);
                         }
                        }
                        },
                        "json"
                        );

                        });
                        $('#txtDepNameSI').blur(function() {

                        $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                        { inputName: $('#txtDepNameSI').val(), sourceLanguage: 0,type: "N",currentLan:"S" },

                        function(data){
                        if(data!=null){

                        if($("#txtDepName").val()==""){
                        $("#txtDepName").val(data.english);
                        }
                        if($("#txtDepNameTA").val()==""){
                        $("#txtDepNameTA").val(data.tamil);
                        }
                        }
                        },
                        "json"
                        );

                        });
                        $('#txtDepNameTA').blur(function() {

                        $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                        { inputName: $('#txtDepNameTA').val(), sourceLanguage: 0,type: "N",currentLan:"T" },

                        function(data){
                        if(data!=null){

                        if($("#txtDepName").val()==""){
                        $("#txtDepName").val(data.english);
                        }
                        if($("#txtDepNameSI").val()==""){
                        $("#txtDepNameSI").val(data.sinhala);
                        }
                        }
                        },
                        "json"
                        );

                    });

                        
                        
                        //End Translation

                        // Add a dependent contact
                        $('#btnAddDependent').click(function() {

                            $('#btnEditDependent').show();
                            buttonSecurityCommon(null,"btnEditDependent",null,null);
                            $("#errMessage").hide();
                            $("#txtDepSeqNo").val('');
                            $("#txtDepName").val('');
                            $("#txtDepNameSI").val('');
                            $("#txtDepNameTA").val('');
                            $("#cmbDepRelationship").val('0');
                            $("#txtDepDOB").val('');
                            $("#txtDepWorkplace").val('');
                            $("#txtDepWorkplaceSI").val('');
                            $("#txtDepWorkplaceTA").val('');
                            $("#txtDepEduCenter").val('');
                            $("#txtDepEduCenterSI").val('');
                            $("#txtDepEduCenterTA").val('');
                            $("#txtDepAddress").val('');
                            $("#txtDepAddressSI").val('');
                            $("#txtDepAddressTA").val('');
                            $("#txtDepComment").val('');
                            $("#txtDepCommentSI").val('');
                            $("#txtDepCommentTA").val('');

                            showPaneData('addPaneDependent');
                            hidePaneData('summaryPaneDependent');

                            $("#frmEmpDependent").data('edit', '2'); // In add mode
                            setDependentAttributes();

                            // hide validation error messages
                            $("label.errortd[generated='true']").css('display', 'none');

                            $("#paneChildData").hide();
                            $("#paneWorkData").show();

                        });

                        $("#frmEmpDependent").validate({
                            rules: {
                                txtDepName : {required:true, noSpecialChars: true},
                                txtDepNameSI : {noSpecialChars: true},
                                txtDepNameTA : {noSpecialChars: true},
                                cmbDepRelationship : {comboSelected: true},
                                txtDepDOB : {orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}}
                            },
                            messages: {
                                txtDepName: {required: '<?php echo __("This field is required.") ?>', noSpecialChars: '<?php echo __("This field contains invalid characters.") ?>'},
                                txtDepNameSI: {noSpecialChars: '<?php echo __("This field contains invalid characters.") ?>'},
                                txtDepNameTA: {noSpecialChars: '<?php echo __("This field contains invalid characters.") ?>'},
                                cmbDepRelationship: {comboSelected: '<?php echo __("This field is required.") ?>'},
                                txtDepDOB: {orange_date: '<?php echo __("Invalid date."); ?>'}
                            },
                            errorClass: "errortd",
                               submitHandler: function(form) {
                               $('#btnEditDependent').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
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
                        $("#btnDelDependent").click(function() {
                            $("#mode").attr('value', 'delete');
                            if($("input[name='chkID[]']").is(':checked')){
                                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
                            } else {
                                alert("<?php echo __("Select at least one check box to delete") ?>");
                            }

                            if (answer !=0 ) {
                                $("#frmEmpDelDependent").submit();
                            } else {
                                return false;
                            }
                        });

                        // Switch edit mode or submit data when edit/save button is clicked
                        $("#btnEditDependent").click(function() {

                            var editMode = $("#frmEmpDependent").data('edit');
                            if($('#txtDepDOB').val()>'<?php echo $today; ?>' ){
                                alert("<?php echo __("Date of Birth can not be future Date.") ?>");
                                return false;
                            }
                            if (editMode == 0) {

                                lockDependentContacts(<?php echo $employee->empNumber ?>,$('#txtDepSeqNo').val());
                                return false;
                            }
                            else {
                                $('#frmEmpDependent').submit();
                            }
                        });

                        $('#btnBackDependent').click(function() {
                            $("#errMessage").hide();
                            showPaneData('summaryPaneDependent');
                            hidePaneData('addPaneDependent');
                        });

                        $('#btnResetDependent').click(function() {
                            // hide validation error messages
                            $("label.errortd[generated='true']").css('display', 'none');

                            // 0 - view, 1 - edit, 2 - add
                            var editMode = $("#frmEmpDependent").data('edit');
                            if (editMode == 1) {
                                unlockDependentContacts(<?php echo $employee->empNumber ?>,$('#txtDepSeqNo').val());
                return false;
            }
            else {
                document.forms['frmEmpDependent'].reset('');
            }
        });

        //Change State drop down when select US
        $("#cmbDepRelationship").change(function() {

            if($("#cmbDepRelationship").val() == '2' || $("#cmbDepRelationship").val() == '8')
            {
                $("#paneChildData").show();
                $("#paneWorkData").hide();
            }else
            {
                $("#paneChildData").hide();
                $("#paneWorkData").show();
            }
        });

    });
    //]]>
</script>