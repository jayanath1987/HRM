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
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<!--<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>-->
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<!--<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>-->
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<link href="<?php echo public_path('../../images/jquerybubblepopup-theme/jquery.bubblepopup.v2.3.1.css') ?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo public_path('../../scripts/jquery/jquery.bubblepopup.v2.3.1.min.js') ?>" type="text/javascript"></script>
<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Add New Employee"); ?></h2></div>
        <?php echo message(); ?>
        <?php include_partial('global/form_errors', array('form' => $form)); ?>
        <form id="frmEmpPersonalDetails" method="post" action="<?php echo url_for('pim/addEmployee'); ?>">

            <?php echo $form['_csrf_token']; ?>
            <input type="hidden" name="txtEmpID" id="txtEmpID" value="<?php echo $empID ?>"/>


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
                <label for="txtEmployeeId"><?php echo __("Employee ID"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtEmployeeId"  id="txtEmployeeId"
                       value="<?php echo $empID ?>" maxlength="10" />
            </div>
            <div class="centerCol">
                <label for="txtAppLetterNo"><?php echo __("Appointment Letter No"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtAppLetterNo"  id="txtAppLetterNo"
                       value="" maxlength="15" />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtPersonalFileNo"><?php echo __("Personal File No"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtPersonalFileNo"  id="txtPersonalFileNo"
                       value="" maxlength="25" />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="cmbTitle"><?php echo __("Title"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"  id="cmbTitle" name="cmbTitle">
                    <option value="0"><?php echo __("--Select--"); ?></option>
                    <?php
                    //Define data columns according culture
                    $titleNameCol = ($userCulture == "en") ? "title_name" : "title_name_" . $userCulture;
                    if ($empTitles) {

                        foreach ($empTitles as $title) {

                            $titleName = $title->$titleNameCol == "" ? $title->title_name : $title->$titleNameCol;
                            echo "<option  value='{$title->title_code}'>{$titleName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="centerCol">
                <label for="cmbGender"><?php echo __("Gender"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"   id="cmbGender" name="cmbGender">
                    
                    <option value="0"><?php echo __("--Select--"); ?></option>
                   
 <?php
 $genderNameCol = ($userCulture == "en") ? "gender_name" : "gender_name_" . $userCulture;
                    if ($genders) {
                        $currentGenderCode = isset($postArr['cmbGender']) ? $postArr['cmbGender'] : $genderCode;
                        foreach ($genders as $gender) {
                            $selected = ($candidate->gender_code == $gender->gender_code) ? 'selected="selected"' : '';
                            if($InterviewData->gender_code!= null){  
                            $selected = ($InterviewData->gender_code == $gender->gender_code) ? 'selected="selected"' : '';                    
                            } 
                            $genderName = $gender->$genderNameCol == "" ? $gender->gender_name : $gender->$genderNameCol;
                            echo "<option {$selected} value='{$gender->gender_code}'>{$genderName}</option>";
                        }
                    }

                   ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtInitials"><?php echo __("Initials"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtInitials" id="txtInitials"
                       value="" maxlength="30"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtInitialsSI" id="txtInitialsSI"
                       value="" maxlength="30"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtInitialsTA" id="txtInitialsTA"
                       value="" maxlength="30"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtNamesOfInitials"><?php echo __("Names Of Initials"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtNamesOfInitials" id="txtNamesOfInitials"
                       value="" maxlength="120"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtNamesOfInitialsSI" id="txtNamesOfInitialsSI"
                       value="" maxlength="120"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtNamesOfInitialsTA" id="txtNamesOfInitialsTA"
                       value="" maxlength="120"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtEmpFirstName"><?php echo __("First Name"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtEmpFirstName" id="txtEmpFirstName"
                       value="<?php if($InterviewData->rec_can_candidate_name!= null){  echo $InterviewData->rec_can_candidate_name; } ?>" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtEmpFirstNameSI" id="txtEmpFirstNameSI"
                       value="" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtEmpFirstNameTA" id="txtEmpFirstNameTA"
                       value="" maxlength="50"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtEmpLastName"><?php echo __("Last Name"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtEmpLastName" id="txtEmpLastName"
                       value="" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtEmpLastNameSI" id="txtEmpLastNameSI"
                       value="" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtEmpLastNameTA" id="txtEmpLastNameTA"
                       value="" maxlength="50"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtDOB"><?php echo __("Date Of Birth"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtDOB" id="txtDOB"
                       value="<?php echo LocaleUtil::getInstance()->formatDate($candidate->rec_can_birthday);?> <?php if($InterviewData->rec_can_birthday!= null){  echo LocaleUtil::getInstance()->formatDate($InterviewData->rec_can_birthday); } ?>">
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtPlaceOfBirth"><?php echo __("Place Of Birth"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtPlaceOfBirth" id="txtPlaceOfBirth"
                       value="" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtPlaceOfBirthSI" id="txtPlaceOfBirthSI"
                       value="" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtPlaceOfBirthTA" id="txtPlaceOfBirthTA"
                       value="" maxlength="50"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="cmbMaritalStatus"><?php echo __("Civil Status"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"   id="cmbMaritalStatus" name="cmbMaritalStatus">
                    <option value="0"><?php echo __("--Select--"); ?></option>
                    <?php
                    //Define data columns according culture
                    $maritalStatusNameCol = ($userCulture == "en") ? "marst_name" : "marst_name_" . $userCulture;
                    if ($maritalStatusList) {

                        foreach ($maritalStatusList as $maritalStatus) {

                            $maritalStatusName = $maritalStatus->$maritalStatusNameCol == "" ? $maritalStatus->marst_name : $maritalStatus->$maritalStatusNameCol;
                            echo "<option  value='{$maritalStatus->marst_code}'>{$maritalStatusName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="centerCol">
                <label for="txtMarriedDate"><?php echo __("Married Date"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtMarriedDate" id="txtMarriedDate"
                       value="">
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtNICNo"><?php echo __("NIC No"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtNICNo" id="txtNICNo"
                       value="<?php if($InterviewData->rec_can_nic_number!= null){  echo $InterviewData->rec_can_nic_number; } ?>" maxlength="10"/>
            </div>
            <div class="centerCol">
                <label for="txtNICIssueDate"><?php echo __("NIC Issue Date"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtNICIssueDate" id="txtNICIssueDate"
                       value="">
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtPassportNo"><?php echo __("Passport No"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtPassportNo" id="txtPassportNo"
                       value="" maxlength="10"/>
            </div>
            
            <div class="centerCol">
                <label id="lblPensionNumber" for="cmbReligion"><?php echo __("Pension No"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtPensionNo" id="txtPensionNo"
                       value="" maxlength="15"/>
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="cmbEthnicity"><?php echo __("Ethnicity"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"   id="cmbEthnicity" name="cmbEthnicity">
                    <option value="0"><?php echo __("--Select--"); ?></option>
                    <?php
                    //Define data columns according culture
                    $ethnicRaceNameCol = ($userCulture == "en") ? "ethnic_race_desc" : "ethnic_race_desc_" . $userCulture;
                    if ($ethnicRaceList) {

                        foreach ($ethnicRaceList as $ethnicRace) {

                            $ethnicRaceName = $ethnicRace->$ethnicRaceNameCol == "" ? $ethnicRace->ethnic_race_desc : $ethnicRace->$ethnicRaceNameCol;
                            echo "<option  value='{$ethnicRace->ethnic_race_code}'>{$ethnicRaceName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="centerCol">
                <label for="cmbReligion"><?php echo __("Religion"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"   id="cmbReligion" name="cmbReligion">
                    <option value="0"><?php echo __("--Select--"); ?></option>
                    <?php
                    //Define data columns according culture
                    $religionNameCol = ($userCulture == "en") ? "rlg_name" : "rlg_name_" . $userCulture;
                    if ($religionList) {

                        foreach ($religionList as $religion) {

                            $religionName = $religion->$religionNameCol == "" ? $religion->rlg_name : $religion->$religionNameCol;
                            echo "<option  value='{$religion->rlg_code}'>{$religionName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="cmbLanguage"><?php echo __("Preferred Language"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"   id="cmbLanguage" name="cmbLanguage">
                    <option value="0"><?php echo __("--Select--"); ?></option>
                    <?php
                                    $languageNameCol = ($userCulture == "en") ? "lang_name" : "lang_name_" . $userCulture;
                    if ($languageList) {
                        $currentLanguageCode = isset($postArr['cmbLanguage']) ? $postArr['cmbLanguage'] : $langCode;
                        foreach ($languageList as $language) {
                            $selected = ($candidate->lang_code == $language->lang_code) ? 'selected="selected"' : '';
                            if($InterviewData->lang_code!= null){  
                            $selected = ($InterviewData->lang_code == $language->lang_code) ? 'selected="selected"' : '';                    
                            }
                            $languageName = $language->$languageNameCol == "" ? $language->lang_name : $language->$languageNameCol;
                            echo "<option {$selected} value='{$language->lang_code}'>{$languageName}</option>";
                        }
                    }
                   

                    ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="cmbNationality"><?php echo __("Citizenship"); ?></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"   id="cmbNationality" name="cmbNationality">
                    <option value="0"><?php echo __("--Select--"); ?></option>
                    <?php
                    //Define data columns according culture
                    $nationalityNameCol = ($userCulture == "en") ? "nat_name" : "nat_name_" . $userCulture;
                    if ($nationalityList) {

                        foreach ($nationalityList as $nationality) {

                            $nationalityName = $nationality->$nationalityNameCol == "" ? $nationality->nat_name : $nationality->$nationalityNameCol;
                            if($nationality->nat_code=="NAT1"){
                                $selected="selected";
                            }else{
                                $selected="";
                            }
                            echo "<option  value='{$nationality->nat_code}' {$selected}>{$nationalityName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="centerCol">
                <label for="cmbCountry"><?php echo __("Country"); ?></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"   id="cmbCountry" name="cmbCountry">
                    <option value="0"><?php echo __("--Select--"); ?></option>
                    <?php
                    //Define data columns according culture
                    $countryNameCol = ($userCulture == "en") ? "cou_name" : "cou_name_" . $userCulture;
                    if ($countryList) {

                        foreach ($countryList as $country) {
                            if ($country->cou_code== "LK") {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            $countryName = $country->$countryNameCol == "" ? $country->cou_name : $country->$countryNameCol;
                            echo "<option  value='{$country->cou_code}' {$selected}>{$countryName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtSalaryNo"><?php echo __("Salary No"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtSalaryNo" id="txtSalaryNo"
                       value="" maxlength="15"/>
            </div>
            <br class="clear"/>
            <div id="runningDiv">
                <div class="leftCol">
                    <label for="txtRunningFileNo"><?php echo __("Running File No"); ?></label>
                </div>

                <div class="centerCol">
                    <input type="text" class="formInputText"  name="txtRunningFileNo" id="txtRunningFileNo"
                           value="" maxlength="15"/>
                </div>
            </div>

            <div class="leftCol">
                <label for="txtBarCodeNo"><?php echo __("Bar Code No"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText"  name="txtBarCodeNo" id="txtBarCodeNo"
                       value="" maxlength="15"/>
            </div>
            <br class="clear"/>

            <div class="formbuttons">
                <input type="button" class="savebutton" name="EditMain" id="btnEditPersonalDetails"
                       value="<?php echo __("Save"); ?>"
                       title="<?php echo __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                       />
                <input type="reset" class="clearbutton" id="btnResetPersonalDetails" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                       value="<?php echo __("Reset"); ?>"/>
                <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBack" />
            </div>
        </form>
    </div>
</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<?php //} ?>
                    <script type="text/javascript">
                        //<![CDATA[

<?php
                    $sysConf = OrangeConfig::getInstance()->getSysConf();
                    $dateHint = $sysConf->getDateInputHint();
                    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<?php         $e = getdate();
$today = date("Y-m-d", $e[0]); 
?>    


                        var EmpNIC;
                        var isOktoSubmit;
                        function validateEmployeeId(empId){
                            $.post("<?php echo url_for('pim/validateEmployeeId') ?>",
                            { empId: empId },
                            function(data){
                                if (data.recordExist==true) {
                                    alert("<?php echo __('Employee Id  already exists.') ?>");
                                }else {

                                    $('#frmEmpPersonalDetails').submit();

                                }
                            },
                            "json"
                        );
                        }
                        
                        function NICValidation(){
                                var Birthday=$("#txtDOB").val();
                                var Gender=$("#cmbGender").val();
                                $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('pim/AjaxNIC') ?>",
                                    data: {
                                        Birthday: Birthday ,Gender: Gender
                                    },
                                    dataType: "json",
                                    success: function(data){
                                        if(data!=null){
                                        EmpNIC=data;
                                        var lenth=data.length;  
                                        if(lenth==5){
                                            var text="Your NIC No Like : "+data+"####v";
                                        }else{
                                            var text="Your NIC No Like : "+data+"#######v"; 
                                        }
                                         if( $('#txtNICNo').HasBubblePopup() ){   
                                             $('#txtNICNo').RemoveBubblePopup();
                                         }
                                         $('#txtNICNo').CreateBubblePopup({
                                         innerHtml: text,
                                         innerHtmlStyle: {
                                                    color:'#333333', 
                                                    'text-align':'center'
                                                    },

                                        themeName: 	'orange',
                                        themePath: 	'<?php echo public_path('../../images/jquerybubblepopup-theme') ?>'								
                                        });  
                                        }
                                    }
                                    });
                                    
                        }
                        
                        function submitValidation(){
                            var errorCount=0;

                            var salNo=$("#txtSalaryNo").val();
                            var pensionNo=$("#txtPensionNo").val();
                            var ApplettNo=$("#txtAppLetterNo").val();
                            var EmployeeId=$("#txtEmployeeId").val();
                            
                            if(salNo!=""){
                                $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('pim/isSalNoExist') ?>",
                                    data: {
                                        salNo: salNo,mode: "add"
                                    },
                                    dataType: "json",
                                    success: function(data){
                                        if(data.count>0){
                                            alert("<?php echo __('Salary No can not be duplicated'); ?>");
                                            errorCount=errorCount+1;
                                        }else{

                                        }
                                    }
                                });
                            }

                            if(pensionNo!=""){

                                $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('pim/isPensionNoExists') ?>",
                                    data: {
                                        pensionNo: pensionNo,mode: "add"
                                    },
                                    dataType: "json",
                                    success: function(data){
                                        if(data.count>0){
                                            alert("<?php echo __('Pension No can not duplicated'); ?>");
                                            errorCount=errorCount+1;
                                        }else{
                                            saveFlag=1;
                                        }
                                    }
                                });
                            }
                            if(ApplettNo!=""){
                                $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('pim/isAppLetterExists') ?>",
                                    data: {
                                        ApplettNo: ApplettNo,mode: "add"
                                    },
                                    dataType: "json",
                                    success: function(data){
                                        if(data.count>0){
                                            alert("<?php echo __('Appointment Letter No can not duplicated'); ?>");
                                            errorCount=errorCount+1;
                                        }else{
                                            saveFlag=1;
                                        }
                                    }
                                });
                            }
                            if(EmployeeId!=""){                                
                                $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('pim/isEmpIdExists') ?>",
                                    data: {
                                        EmployeeId: EmployeeId,mode: "add"
                                    },
                                    dataType: "json",
                                    success: function(data){
                                        if(data.count>0){
                                            alert("<?php echo __('Employee ID can not duplicated'); ?>");
                                            errorCount=errorCount+1;
                                        }else{
                                            saveFlag=1;
                                        }
                                    }
                                });
                            }
                            return  errorCount;

                        }

                        $(document).ready(function() {
                            
                            $("#txtPensionNo").hide();
                            $("#lblPensionNumber").hide();
                            
                            $('#runningDiv').hide();

                            buttonSecurityCommon(null,"btnEditPersonalDetails",null,null);

                            $('#txtEmpFirstName').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtEmpFirstName').val(), sourceLanguage: 0,type: "N",currentLan:"E" },

                    function(data){
                    if(data!=null){

                    if($("#txtEmpFirstNameSI").val()==""){
                    $("#txtEmpFirstNameSI").val(data.sinhala);
                    }
                     if($("#txtEmpFirstNameTA").val()==""){
                    $("#txtEmpFirstNameTA").val(data.tamil);
                     }
                    }
                    },
                    "json"
                    );

                    });
                    $('#txtEmpFirstNameSI').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtEmpFirstNameSI').val(), sourceLanguage: 0,type: "N",currentLan:"S" },

                    function(data){
                    if(data!=null){

                    if($("#txtEmpFirstName").val()==""){
                    $("#txtEmpFirstName").val(data.english);
                    }
                    if($("#txtEmpFirstNameTA").val()==""){
                    $("#txtEmpFirstNameTA").val(data.tamil);
                    }
                    }
                    },
                    "json"
                    );

                    });
                    $('#txtEmpFirstNameTA').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtEmpFirstNameTA').val(), sourceLanguage: 0,type: "N",currentLan:"T" },

                    function(data){
                    if(data!=null){

                    if($("#txtEmpFirstName").val()==""){
                    $("#txtEmpFirstName").val(data.english);
                    }
                    if($("#txtEmpFirstNameSI").val()==""){
                    $("#txtEmpFirstNameSI").val(data.sinhala);
                    }
                    }
                    },
                    "json"
                    );

                    });

                    $('#txtNamesOfInitials').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtNamesOfInitials').val(), sourceLanguage: 0,type: "N",currentLan:"E" },

                    function(data){
                    if(data!=null){

                   if($("#txtNamesOfInitialsSI").val()==""){
                    $("#txtNamesOfInitialsSI").val(data.sinhala);
                   }
                   if($("#txtNamesOfInitialsTA").val()==""){
                    $("#txtNamesOfInitialsTA").val(data.tamil);
                   }
                    }
                    },
                    "json"
                    );
                    });

                    $('#txtNamesOfInitialsSI').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtNamesOfInitialsSI').val(), sourceLanguage: 0,type: "N",currentLan:"S" },

                    function(data){
                    if(data!=null){

                    if($("#txtNamesOfInitials").val()==""){
                    $("#txtNamesOfInitials").val(data.english);
                    }
                    if($("#txtNamesOfInitialsTA").val()==""){
                    $("#txtNamesOfInitialsTA").val(data.tamil);
                    }
                    }
                    },
                    "json"
                    );

                    });

                    $('#txtNamesOfInitialsTA').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtNamesOfInitialsTA').val(), sourceLanguage: 0,type: "N",currentLan:"T" },

                    function(data){
                    if(data!=null){

                    if($("#txtNamesOfInitials").val()==""){
                    $("#txtNamesOfInitials").val(data.english);
                    }
                    if($("#txtNamesOfInitialsSI").val()==""){
                    $("#txtNamesOfInitialsSI").val(data.sinhala);
                    }
                    }
                    },
                    "json"
                    );

                    });

                    $('#txtEmpLastName').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtEmpLastName').val(), sourceLanguage: 0,type: "N",currentLan:"E" },

                    function(data){
                    if(data!=null){

                    if($("#txtEmpLastNameSI").val()==""){
                    $("#txtEmpLastNameSI").val(data.sinhala);
                    }
                    if($("#txtEmpLastNameTA").val()==""){
                    $("#txtEmpLastNameTA").val(data.tamil);
                    }
                    }
                    },
                    "json"
                    );

                    });

                    $('#txtEmpLastNameSI').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtEmpLastNameSI').val(), sourceLanguage: 0,type: "N",currentLan:"S" },

                    function(data){
                    if(data!=null){

                    if($("#txtEmpLastName").val()==""){
                    $("#txtEmpLastName").val(data.english);
                    }
                    if($("#txtEmpLastNameTA").val()==""){
                    $("#txtEmpLastNameTA").val(data.tamil);
                    }
                    }
                    },
                    "json"
                    );

                    });

                    $('#txtEmpLastNameTA').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtEmpLastNameTA').val(), sourceLanguage: 0,type: "N",currentLan:"T" },

                    function(data){
                    if(data!=null){

                    if($("#txtEmpLastNameSI").val()==""){
                    $("#txtEmpLastNameSI").val(data.sinhala);
                    }
                    if($("#txtEmpLastName").val()==""){
                    $("#txtEmpLastName").val(data.english);
                    }
                    }
                    },
                    "json"
                    );

                    });

                    $('#txtInitials').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtInitials').val(), sourceLanguage: 0,type: "N",currentLan:"E" },

                    function(data){
                    if(data!=null){

                    if($("#txtInitialsSI").val()==""){
                    $("#txtInitialsSI").val(data.sinhala);
                    }
                    if($("#txtInitialsTA").val()==""){
                    $("#txtInitialsTA").val(data.tamil);
                    }
                    }
                    },
                    "json"
                    );

                    });

                    $('#txtInitialsSI').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtInitialsSI').val(), sourceLanguage: 0,type: "N",currentLan:"S" },

                    function(data){
                    if(data!=null){

                    if($("#txtInitials").val()==""){
                    $("#txtInitials").val(data.english);
                    }
                    if($("#txtInitialsTA").val()==""){
                    $("#txtInitialsTA").val(data.tamil);
                    }
                    }
                    },
                    "json"
                    );

                    });




                   
                    $('#txtInitialsTA').blur(function() {

                    $.post("<?php echo url_for('default/lanugaeTranslator') ?>",
                    { inputName: $('#txtInitialsTA').val(), sourceLanguage: 0,type: "N",currentLan:"T" },

                    function(data){
                    if(data!=null){

                    if($("#txtInitials").val()==""){
                    $("#txtInitials").val(data.english);
                    }
                    if($("#txtInitialsSI").val()==""){
                    $("#txtInitialsSI").val(data.sinhala);
                    }
                    }
                    },
                    "json"
                    );

                    });


                            $("#txtDOB").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                            $("#txtMarriedDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                            $("#txtNICIssueDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });

                       jQuery.validator.addMethod("nicissuedateValidaiton",
                            function(value, element) {
                                var hint = '<?php echo $dateHint; ?>';
                                var format = '<?php echo $format; ?>';
                                var fromdate = strToDate($('#txtDOB').val(), format)
                                var todate = strToDate($('#txtNICIssueDate').val(), format);

                                if (fromdate && todate && (fromdate > todate)) {
                                    return false;
                                }
                                return true;
                            }, ""
                        );
                        jQuery.validator.addMethod("marriedDatevalidation",
                            function(value, element) {
                                var hint = '<?php echo $dateHint; ?>';
                                var format = '<?php echo $format; ?>';
                                var fromdate = strToDate($('#txtDOB').val(), format)
                                var todate = strToDate($('#txtMarriedDate').val(), format);

                                if (fromdate && todate && (fromdate > todate)) {
                                    return false;
                                }
                                return true;
                            }, ""
                        );
                        $('#cmbTitle').change(function() {
                            if($('#cmbTitle').val()==1){
                                $('#cmbGender').val(1);
                            }
                            else if($('#cmbTitle').val()==2){
                                $('#cmbGender').val(2);
                            }
                            else if($('#cmbTitle').val()==3){
                                $('#cmbGender').val(2);
                            }
                            else if($('#cmbTitle').val()==4){
                               $('#cmbGender').val(2);
                            }
    
                         });
                            // hide validation error messages
                            $("label.errortd[generated='true']").css('display', 'none');

                            $("#frmEmpPersonalDetails").validate({
                                rules: {
                                    txtEmployeeId: { required: true, noSpecialCharsOnly: true },
                                    txtAppLetterNo: { required: true, noSpecialCharsOnly: true },
                                    txtPersonalFileNo: { required: true, noSpecialCharsOnly: true },
                                    cmbTitle: { comboSelected: true },
                                    txtEmpLastName: { required: true, noSpecialChars: true },
                                    txtEmpLastNameSI: { required: true,noSpecialChars: true },
                                    txtEmpLastNameTA: { required: true,noSpecialChars: true },
                                    txtEmpFirstName: { required: true, noSpecialChars: true },
                                    txtEmpFirstNameSI: { required: true,required: true,noSpecialChars: true },
                                    txtEmpFirstNameTA: { required: true,noSpecialChars: true },
                                    txtInitials: { required: true, noSpecialChars: true },
                                    txtInitialsSI: { required: true,noSpecialChars: true },
                                    txtInitialsTA: { required: true,noSpecialChars: true },
                                    txtNamesOfInitials: { required: true, noSpecialChars: true },
                                    txtNamesOfInitialsSI: { required: true,noSpecialChars: true },
                                    txtNamesOfInitialsTA: { required: true,noSpecialChars: true },
                                    cmbGender: { comboSelected: true },
                                    txtDOB: { required: true, orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']} },
                                    txtPlaceOfBirth: { noSpecialChars: true },
                                    txtPlaceOfBirthSI: { noSpecialChars: true },
                                    txtPlaceOfBirthTA: { noSpecialChars: true },
                                    cmbMaritalStatus: { comboSelected: true },
                                    txtMarriedDate: { orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']},marriedDatevalidation: true },
                                    txtNICNo: { required: true, alphaNumeric: true , minlength:10},
                                    txtNICIssueDate: { required: true, orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']},nicissuedateValidaiton: true },
                                    txtPassportNo: { alphaNumeric: true },
                                    cmbEthnicity: { comboSelected: true },
                                    cmbReligion: { comboSelected: true },
                                    cmbLanguage: { comboSelected: true },
                                    cmbNationality: {  },
                                    cmbCountry: {  },
                                    txtSalaryNo: { noSpecialCharsOnly: true },
                                    txtRunningFileNo: { noSpecialCharsOnly: true },
                                    txtBarCodeNo: { noSpecialCharsOnly: true },
                                    txtPensionNo: { noSpecialCharsOnly: true }
                                },
                                messages: {
                                    txtEmployeeId: {required: "<?php echo __('This field is required.') ?>", noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtAppLetterNo: { required: "<?php echo __('This field is required.') ?>", noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtPersonalFileNo: { required: "<?php echo __('This field is required.') ?>", noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                                    cmbTitle: { comboSelected: "<?php echo __('This field is required.') ?>" },
                                    txtEmpLastName: { required: "<?php echo __('This field is required.') ?>", noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtEmpLastNameSI: { required: "<?php echo __('This field is required.') ?>",noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtEmpLastNameTA: { required: "<?php echo __('This field is required.') ?>",noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtEmpFirstName: { required: "<?php echo __('This field is required.') ?>", noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtEmpFirstNameSI: { required: "<?php echo __('This field is required.') ?>",noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtEmpFirstNameTA: { required: "<?php echo __('This field is required.') ?>",noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtInitials: { required: "<?php echo __('This field is required.') ?>", noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtInitialsSI: { required: "<?php echo __('This field is required.') ?>",noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtInitialsTA: { required: "<?php echo __('This field is required.') ?>",noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtNamesOfInitials: { required: "<?php echo __('This field is required.') ?>", noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtNamesOfInitialsSI: { required: "<?php echo __('This field is required.') ?>",noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtNamesOfInitialsTA: { required: "<?php echo __('This field is required.') ?>",noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    cmbGender: { comboSelected: "<?php echo __('This field is required.') ?>" },
                                    txtDOB: { required: "<?php echo __('This field is required.') ?>", orange_date: '<?php echo __("Invalid date."); ?>' },
                                    txtPlaceOfBirth: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtPlaceOfBirthSI: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtPlaceOfBirthTA: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                                    cmbMaritalStatus: { comboSelected: "<?php echo __('This field is required.') ?>" },
                                    txtMarriedDate: { orange_date: '<?php echo __("Invalid date."); ?>',marriedDatevalidation:'<?php echo __('Married date should be less than to the date of birth') ?>' },
                                    txtNICNo: { required: "<?php echo __('This field is required.') ?>", alphaNumeric: "<?php echo __('This field contains invalid characters.') ?>" , minlength :"<?php echo __("Minimum 10 Characters") ?>" },
                                    txtNICIssueDate: { required: "<?php echo __('This field is required.') ?>", orange_date: '<?php echo __("Invalid date."); ?>',nicissuedateValidaiton: '<?php echo __('NIC Issue date should be greater than to the date of birth') ?>' },
                                    txtPassportNo: { alphaNumeric: "<?php echo __('This field contains invalid characters.') ?>" },
                                    cmbEthnicity: { comboSelected: "<?php echo __('This field is required.') ?>" },
                                    cmbReligion: { comboSelected: "<?php echo __('This field is required.') ?>" },
                                    cmbLanguage: { comboSelected: "<?php echo __('This field is required.') ?>" },
                                    cmbNationality: {  },
                                    cmbCountry: {  },
                                    txtSalaryNo: { noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtRunningFileNo: { noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtBarCodeNo: { noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                                    txtPensionNo: { noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" }

                                },
                                errorClass: "errortd",
                                      submitHandler: function(form) {
                                          
                                      if(isOktoSubmit!=0){
                                      $('#btnEditPersonalDetails').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                                      form.submit();
                                      }
                                     }



                            });

                            // Save button
                            $("#btnEditPersonalDetails").click(function() {
                              if($('#txtDOB').val()>'<?php echo $today; ?>'){
                                  alert("<?php echo __("Date of Birth can not be future Date.") ?>");
                                  return false;
                              }  
                              if($('#txtNICIssueDate').val()>'<?php echo $today; ?>'){
                                  alert("<?php echo __("NIC Issue Date can not be future Date.") ?>");
                                  return false;
                              }
                              if($('#txtEmployeeId').val()!=$('#txtNICNo').val()){
                                  alert("<?php echo __("Employee Id  should be equal to the NIC Number.") ?>");
                                  return false;
                              }
                              NICValidation();
                              if($('#txtNICNo').val()){
                                  var error=0;
                                  var NIC=$('#txtNICNo').val();
                                  var datalength=NIC.length;
                                  var user=new Array();
                                   for(var i=0; i<datalength; i++){
                                       user[i]=NIC[i]; 
                                   }
                                   var datalength2= EmpNIC.length;
                                  var real=new Array();
                                   for(var j=0; j<datalength2; j++){
                                       real[j]=EmpNIC[j]; 
                                   }  

                                  
                                  if(datalength2 > 2){
                                      
                                     if(user[0]!=real[0]){
                                        error++; 
                                     }
                                     if(user[1]!=real[1]){
                                        error++; 
                                     }
                                     if(user[2]!=real[2]){
                                        error++; 
                                     }
                                     if(user[3]!=real[3]){
                                        error++; 
                                     }
                                     if(user[4]!=real[4]){
                                        error++; 
                                     }
                                     
                                     if(error > 0){
                                        alert("<?php echo __("Your NIC No Like : ") ?>"+EmpNIC+"####v");
                                        return false; 
                                     }
                                  }else{
                                      if(user[0]!=real[0]){
                                        error++; 
                                     }
                                     if(user[1]!=real[1]){
                                        error++; 
                                     }
                                     if(error > 0){
                                        alert("<?php echo __("Your NIC No Like : ") ?>"+EmpNIC+"#######v");
                                        return false; 
                                     }
                                  }
                                  var error2=0;
                                     for(var k=0; k<9; k++){
                                         if(isNaN(user[k])){
                                             error2++;
                                         }
                                     }
                                     if(error2 > 0){
                                        alert("<?php echo __("Invalid NIC") ?>");
                                        return false; 
                                     }
                                     if(user[9]!="X" && user[9]!="V" ){
                                        alert("<?php echo __("Invalid NIC") ?>");
                                        return false; 
                                     }
                              }
                                if(submitValidation()==0){
                                    $("#frmEmpPersonalDetails").submit();
                                     isOktoSubmit=1; 
                                }else{
                                    isOktoSubmit=0;
                                }

                            });

                            //When click reset buton
                            $("#btnResetPersonalDetails").click(function() {
                                document.forms[0].reset('');
                            });
                            //When click reset buton
                            $("#btnBack").click(function() {
                                <?php if($type=="CN"){?>
                                location.href="<?php echo url_for('recruitment/CandidatePIMRegistation') ?>";
                              <?php  }else{ ?>
                                  location.href="<?php echo url_for('pim/list') ?>";  
                              <?php  } ?>
                            });
                            
                            
                            $("#txtNICNo").focus(function(){
                                    NICValidation();
                                });

    
    });
    //]]>
</script>
