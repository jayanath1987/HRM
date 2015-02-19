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
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<?php echo javascript_include_tag('orangehrm.validate.js'); ?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/showhidepane.js'); ?>"></script>

<div id="parentPaneEmgContact" >
    <?php
    $emergencyContacts = $employee->emergencyContacts;
    $numContacts = count($emergencyContacts);
    $haveContacts = $numContacts > 0;

    $allowEdit = $locRights['add'] || $locRights['ESS'] || $locRights['supervisor'];
    $allowDel = $locRights['delete'] || $locRights['ESS'] || $locRights['supervisor'];
    $disabled = $allowEdit ? '' : 'disabled="disabled"';



    if ($currentPane == 5) {
        include_partial('pim_form_errors', array('sf_user' => $sf_user));
    }

    if (isset($postArr['EditMode']) && $postArr['EditMode'] == '1') {
        $editMode = false;
        $disabled = '';
    } else {
        $editMode = true;
        $disabled = 'disabled="disabled"';
    }
    ?>
    <div id="personal" class="pimpanel formPIM">
        <div class="outerbox">
            <div class="mainHeading"><h2><?php echo __("Emergency Contacts"); ?></h2></div>
            <div id="errMessage">
<?php echo message(); ?>
            </div>
            <form name="frmEmpEmgContact" id="frmEmpEmgContact" method="post" action="<?php echo url_for('pim/updateEmergencyContact?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="txtECSeqNo" id="txtECSeqNo" value="" />


                <div id="addPaneEmgContact" style="display:none;">
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
                        <label for="txtECName"><?php echo __("Contact Person"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECName" id="txtECName"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECNameSI" id="txtECNameSI"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECNameTA" id="txtECNameTA"
                               value="" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtECRelationship"><?php echo __("Relationship"); ?><span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECRelationship" id="txtECRelationship"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECRelationshipSI" id="txtECRelationshipSI"
                               value="" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECRelationshipTA" id="txtECRelationshipTA"
                               value="" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtECAddress"><?php echo __("Address"); ?></label>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtECAddress" id="txtECAddress" maxlength="200"></textarea>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtECAddressSI" id="txtECAddressSI" maxlength="200"></textarea>
                    </div>
                    <div class="centerCol">
                        <textarea <?php echo $disabled; ?>  rows="5" cols="15" name="txtECAddressTA" id="txtECAddressTA" maxlength="200"></textarea>
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtECHomePhoneNo"><?php echo __("Home Phone No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECHomePhoneNo" id="txtECHomePhoneNo"
                               value="" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtECOfficePhoneNo"><?php echo __("Office Phone No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECOfficePhoneNo" id="txtECOfficePhoneNo"
                               value="" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtECMobileNo"><?php echo __("Mobile No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtECMobileNo" id="txtECMobileNo"
                               value="" maxlength="10" />
                    </div>
                    <br class="clear"/>

<?php //if (($allowEdit)) {  ?>
                    <div class="formbuttons">
                        <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditEmgContact" id="btnEditEmgContact"
                               value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" value="<?php echo __("Reset"); ?>" name="btnResetEmgContact" id="btnResetEmgContact"/>
                        <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackEmgContact" />
                    </div>
<?php //}  ?>
                </div>
            </form>
            <form name="frmEmpDelEmgContacts" id="frmEmpDelEmgContacts" method="post" action="<?php echo url_for('pim/deleteEmergencyContacts?empNumber=' . $employee->empNumber); ?>">

                <div id="summaryPaneEmgContact" >
                    <div class="subHeading"></div>
                    <div class="actionbar">
                        <div class="actionbuttons">

                            <input type="button" class="addbutton" id="btnAddContact"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>
                            <input type="button" class="delbutton" id="btnDelEmgContact"
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
<?php echo __('Home Phone No'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Office Phone No'); ?>
                                </td>
                                <td scope="col">
<?php echo __('Mobile No'); ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody>
<?php
    $row = 0;
    foreach ($emergencyContacts as $contact) {
        $cssClass = ($row % 2) ? 'even' : 'odd';
        $row = $row + 1;

        //Define data columns according culture
        $contactNameCol = ($userCulture == "en") ? "name" : "name_" . $userCulture;
        $contactName = $contact->$contactNameCol == "" ? $contact->name : $contact->$contactNameCol;

        $relationshipCol = ($userCulture == "en") ? "relationship" : "relationship_" . $userCulture;
        $relationship = $contact->$relationshipCol == "" ? $contact->relationship : $contact->$relationshipCol;

        $addressCol = ($userCulture == "en") ? "address" : "address_" . $userCulture;
        $address = $contact->$addressCol == "" ? $contact->address : $contact->$addressCol;
?>

                            <tr class="<?php echo $cssClass ?>">
                                <td >
                                    <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $contact->seqno ?>' />
                                </td>
                                <td class="">
                                    <a href="#"><?php echo $contactName ?></a>
                                </td>
                                <td class="">
<?php echo $relationship ?>
                                </td>                               
                                <td class="">
<?php echo $contact->home_phone ?>
                                </td>
                                <td class="">
<?php echo $contact->office_phone ?>
                                </td>
                                <td class="">
<?php echo $contact->mobile_phone ?>
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
<script type="text/javascript">
    //<![CDATA[

    function getEmergencyContacts(empNumber,seqNo){
        $.post("<?php echo url_for('pim/GetEmergencyContactById') ?>",
                    { empNumber: empNumber, seqNo: seqNo },
                    function(data){
                        if(data==null){
                            alert("<?php echo __("record is not found") ?>");
                            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/emeregencyContacts')) ?>";
                        }else{
                            setEmgContactData(data);
                        }

                    },
                    "json"
                );
                }

                function lockEmergencyContacts(empNumber,seqNo){
                    $.post("<?php echo url_for('pim/lockEmergencyContact') ?>",
                    { empNumber: empNumber, seqNo: seqNo },
                    function(data){
                        if (data.recordLocked==true) {
                            getEmergencyContacts(empNumber,seqNo);
                            $("#frmEmpEmgContact").data('edit', '1'); // In edit mode
                            setEmgContactAttributes();
                        }else {
                            alert("<?php echo __("Record Locked.") ?>");
                        }
                    },
                    "json"
                );
                }

                function unlockEmergencyContacts(empNumber,seqNo){
                    $.post("<?php echo url_for('pim/unlockEmergencyContact') ?>",
                    { empNumber: empNumber, seqNo: seqNo },
                    function(data){
                        getEmergencyContacts(empNumber,seqNo);
                        $("#frmEmpEmgContact").data('edit', '0'); // In view mode
                        setEmgContactAttributes();
                    },
                    "json"
                );
                }

                function setEmgContactData(data){
                    $("#txtECSeqNo").val(data.seqno);
                    $("#txtECName").val(data.name);
                    $("#txtECNameSI").val(data.name_si);
                    $("#txtECNameTA").val(data.name_ta);
                    $("#txtECRelationship").val(data.relationship);
                    $("#txtECRelationshipSI").val(data.relationship_si);
                    $("#txtECRelationshipTA").val(data.relationship_ta);
                    $("#txtECAddress").val(data.address);
                    $("#txtECAddressSI").val(data.address_si);
                    $("#txtECAddressTA").val(data.address_ta);
                    $("#txtECHomePhoneNo").val(data.home_phone);
                    $("#txtECOfficePhoneNo").val(data.office_phone);
                    $("#txtECMobileNo").val(data.mobile_phone);
                }

                function setEmgContactAttributes() {

                    var editMode = $("#frmEmpEmgContact").data('edit');
                    if (editMode == 0) {
                        $('#frmEmpEmgContact :input').attr('disabled','disabled');

                        $('#btnEditEmgContact').removeAttr('disabled');
                        $('#btnBackEmgContact').removeAttr('disabled');

                        $("#btnEditEmgContact").attr('value',"<?php echo __("Edit"); ?>");
                        $("#btnEditEmgContact").attr('title',"<?php echo __("Edit"); ?>");
                    }
                    else {
                        $('#frmEmpEmgContact :input').removeAttr('disabled');

                        $("#btnEditEmgContact").attr('value',"<?php echo __("Save"); ?>");
                        $("#btnEditEmgContact").attr('title',"<?php echo __("Save"); ?>");
                    }
                }

                $(document).ready(function() {

                    buttonSecurityCommon("btnAddContact",null,null,"btnDelEmgContact");

                    showPaneData('summaryPaneEmgContact');
                    hidePaneData('addPaneEmgContact');

                    // Edit a emergency contact in the list
                    $('#frmEmpDelEmgContacts a').click(function() {
                        buttonSecurityCommon(null,null,"btnEditEmgContact",null);
                        $("#errMessage").hide();
                        var row = $(this).closest("tr");
                        var seqNo = row.find('input.checkbox:first').val();
                        getEmergencyContacts(<?php echo $employee->empNumber; ?>,seqNo);
                        showPaneData('addPaneEmgContact');
                        hidePaneData('summaryPaneEmgContact');

                        $("#frmEmpEmgContact").data('edit', '0'); // In view mode
                        setEmgContactAttributes();

                        // hide validation error messages
                        $("label.errortd[generated='true']").css('display', 'none');
                    });

                    // Add a emergency contact
                    $('#btnAddContact').click(function() {
                        $('#btnEditEmgContact').show();
                        buttonSecurityCommon(null,"btnEditEmgContact",null,null);
                        $("#errMessage").hide();
                        $("#txtECSeqNo").val('');
                        $("#txtECName").val('');
                        $("#txtECNameSI").val('');
                        $("#txtECNameTA").val('');
                        $("#txtECRelationship").val('');
                        $("#txtECRelationshipSI").val('');
                        $("#txtECRelationshipTA").val('');
                        $("#txtECAddress").val('');
                        $("#txtECAddressSI").val('');
                        $("#txtECAddressTA").val('');
                        $("#txtECHomePhoneNo").val('');
                        $("#txtECOfficePhoneNo").val('');
                        $("#txtECMobileNo").val('');

                        showPaneData('addPaneEmgContact');
                        hidePaneData('summaryPaneEmgContact');

                        $("#frmEmpEmgContact").data('edit', '2'); // In add mode
                        setEmgContactAttributes();

                        // hide validation error messages
                        $("label.errortd[generated='true']").css('display', 'none');

                    });
                    
                     //Translatioon
                        
                        $('#txtECName').blur(function() {

                        $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                        { inputName: $('#txtECName').val(), sourceLanguage: 0,type: "N",currentLan:"E" },

                        function(data){
                        if(data!=null){

                        if($("#txtECNameSI").val()==""){
                        $("#txtECNameSI").val(data.sinhala);
                        }
                         if($("#txtECNameTA").val()==""){
                        $("#txtECNameTA").val(data.tamil);
                         }
                        }
                        },
                        "json"
                        );

                        });
                        $('#txtECNameSI').blur(function() {

                        $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                        { inputName: $('#txtECNameSI').val(), sourceLanguage: 0,type: "N",currentLan:"S" },

                        function(data){
                        if(data!=null){

                        if($("#txtECName").val()==""){
                        $("#txtECName").val(data.english);
                        }
                        if($("#txtECNameTA").val()==""){
                        $("#txtECNameTA").val(data.tamil);
                        }
                        }
                        },
                        "json"
                        );

                        });
                        $('#txtECNameTA').blur(function() {

                        $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                        { inputName: $('#txtDepNameTA').val(), sourceLanguage: 0,type: "N",currentLan:"T" },

                        function(data){
                        if(data!=null){

                        if($("#txtECName").val()==""){
                        $("#txtECName").val(data.english);
                        }
                        if($("#txtECNameSI").val()==""){
                        $("#txtECNameSI").val(data.sinhala);
                        }
                        }
                        },
                        "json"
                        );

                    });

                        
                        
                        //End Translation
                    
                    
                    

                    $("#frmEmpEmgContact").validate({
                        rules: {
                            txtECName : {required:true, noSpecialCharsOnly: true},
                            txtECNameSI : {noSpecialCharsOnly: true},
                            txtECNameTA : {noSpecialCharsOnly: true},
                            txtECRelationship : {required:true, noSpecialCharsOnly: true},
                            txtECRelationshipSI : {noSpecialCharsOnly: true},
                            txtECRelationshipTA : {noSpecialCharsOnly: true},
                            txtECAddress : {noSpecialCharsOnly: true},
                            txtECAddressSI : {noSpecialCharsOnly: true},
                            txtECAddressTA : {noSpecialCharsOnly: true},
                            txtECHomePhoneNo : {phone: true},
                            txtECOfficePhoneNo : {phone: true},
                            txtECMobileNo : {phone: true}
                        },
                        messages: {
                            txtECName: {required: "<?php echo __("This field is required.") ?>", noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                            txtECNameSI: {noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                            txtECNameTA: {noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                            txtECRelationship: {required: "<?php echo __("This field is required.") ?>", noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                            txtECRelationshipSI: {noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                            txtECRelationshipTA: {noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                            txtECAddress: {noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                            txtECAddressSI: {noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                            txtECAddressTA: {noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                            txtECHomePhoneNo: {phone: "<?php echo __("Invalid phone number") ?>" },
                            txtECOfficePhoneNo: {phone: "<?php echo __("Invalid phone number") ?>"},
                            txtECMobileNo: {phone: "<?php echo __("Invalid phone number") ?>"}
                        },
                        errorClass: "errortd",
                           submitHandler: function(form) {
                           $('#btnEditEmgContact').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
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
                    $("#btnDelEmgContact").click(function() {
                        $("#mode").attr('value', 'delete');
                        if($("input[name='chkID[]']").is(':checked')){
                            answer = confirm("<?php echo __("Do you really want to delete?") ?>");
                        } else {
                            alert("<?php echo __("Select at least one check box to delete") ?>");
                        }

                        if (answer !=0 ) {
                            $("#frmEmpDelEmgContacts").submit();
                        } else {
                            return false;
                        }
                    });

                    // Switch edit mode or submit data when edit/save button is clicked
                    $("#btnEditEmgContact").click(function() {

                        var editMode = $("#frmEmpEmgContact").data('edit');
                        if (editMode == 0) {
                            lockEmergencyContacts(<?php echo $employee->empNumber; ?>,$('#txtECSeqNo').val());
                            return false;
                        }
                        else {
                            $('#frmEmpEmgContact').submit();
                        }
                    });

                    $('#btnBackEmgContact').click(function() {
                        showPaneData('summaryPaneEmgContact');
                        hidePaneData('addPaneEmgContact');
                    });

                    $('#btnResetEmgContact').click(function() {
                        $("#errMessage").hide();
                        // hide validation error messages
                        $("label.errortd[generated='true']").css('display', 'none');

                        // 0 - view, 1 - edit, 2 - add
                        var editMode = $("#frmEmpEmgContact").data('edit');
                        if (editMode == 1) {
                            unlockEmergencyContacts(<?php echo $employee->empNumber; ?>,$('#txtECSeqNo').val());
                return false;
            }
            else {
                document.forms['frmEmpEmgContact'].reset('');
            }
        });

    });
    //]]>
</script>