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

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<link href="<?php echo public_path('../../images/jquerybubblepopup-theme/jquery.bubblepopup.v2.3.1.css') ?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo public_path('../../scripts/jquery/jquery.bubblepopup.v2.3.1.min.js') ?>" type="text/javascript"></script>

<?php
if (isset($postArr['EditMode']) && $postArr['EditMode'] == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
$encrypt = new EncryptionHandler();

}

$employeeId = $employee->employeeId;
$appLetterNo = $employee->emp_app_letter_no;
$personalFileNo = $employee->emp_personal_file_no;
$titleCode = $employee->title_code;

$employeeLastName = $employee->lastName;
$employeeLastNameSI = $employee->lastName_si;
$employeeLastNameTA = $employee->lastName_ta;

$employeeFirstName = $employee->firstName;
$employeeFirstNameSI = $employee->firstName_si;
$employeeFirstNameTA = $employee->firstName_ta;

$empInitials = $employee->emp_initials;
$empInitialsSI = $employee->emp_initials_si;
$empInitialsTA = $employee->emp_initials_ta;

$empNamesOfInitials = $employee->emp_names_of_initials;
$empNamesOfInitialsSI = $employee->emp_names_of_initials_si;
$empNamesOfInitialsTA = $employee->emp_names_of_initials_ta;

$genderCode = $employee->gender_code;
$birthday = LocaleUtil::getInstance()->formatDate($employee->emp_birthday);
$birthLocation = $employee->emp_birth_location;
$birthLocationSI = $employee->emp_birth_location_si;
$birthLocationTA = $employee->emp_birth_location_ta;

$maritalStatusCode = $employee->marst_code;
$marriedDate = LocaleUtil::getInstance()->formatDate($employee->emp_married_date);
$nicNo = $employee->emp_nic_no;
$nicIssueDate = LocaleUtil::getInstance()->formatDate($employee->emp_nic_date);
$passportNo = $employee->emp_passport_no;

$ethnicRaceCode = $employee->ethnic_race_code;
$rlgCode = $employee->rlg_code;
$langCode = $employee->lang_code;

$nationCode = $employee->nation_code;
$countryCode = $employee->cou_code;

$salaryNo = $employee->emp_salary_no;
$otherFileNo = $employee->emp_other_file_no;
$barCodeNo = $employee->emp_barcode_no;

$pensionNo = $employee->emp_pension_no;

if ($currentPane == 1) {
    include_partial('pim_form_errors', array('sf_user' => $sf_user));
}
?>
<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Personal Details"); ?></h2></div>
<?php echo message(); ?>
        <form id="frmEmpPersonalDetails" method="post" action="<?php if($employee->empNumber){ echo url_for('pim/personalDetail?empNumber=' . $encrypt->encrypt($employee->empNumber)); }else{ echo url_for('pim/personalDetail'); } ?>">
            <input type="hidden" name="txtEmpID" id="txtEmpID" value="<?php echo $employee->empNumber; ?>"/>


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
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEmployeeId"  id="txtEmployeeId"
                       value="<?php echo (!strlen($employeeId)) ? $empID : $employeeId; ?>" maxlength="10" readonly="readonly" />
            </div>
            <div class="centerCol">
                <label for="txtAppLetterNo"><?php echo __("Appointment Letter No"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtAppLetterNo"  id="txtAppLetterNo"
                       value="<?php echo (isset($postArr['txtAppLetterNo'])) ? $postArr['txtAppLetterNo'] : $appLetterNo; ?>" maxlength="15" />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtPersonalFileNo"><?php echo __("Personal File No"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtPersonalFileNo"  id="txtPersonalFileNo"
                       value="<?php echo (isset($postArr['txtPersonalFileNo'])) ? $postArr['txtPersonalFileNo'] : $personalFileNo; ?>" maxlength="25" />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="cmbTitle"><?php echo __("Title"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect" <?php echo $disabled; ?> id="cmbTitle" name="cmbTitle">
                    <option value="0"><?php echo __("--Select--"); ?></option>
<?php
        //Define data columns according culture
        $titleNameCol = ($userCulture == "en") ? "title_name" : "title_name_" . $userCulture;
        if ($empTitles) {
            $currentTitleCode = isset($postArr['cmbTitle']) ? $postArr['cmbTitle'] : $titleCode;
            foreach ($empTitles as $title) {
                $selected = ($currentTitleCode == $title->title_code) ? 'selected="selected"' : '';
                $titleName = $title->$titleNameCol == "" ? $title->title_name : $title->$titleNameCol;
                echo "<option {$selected} value='{$title->title_code}'>{$titleName}</option>";
            }
        }
?>
                </select>
            </div>
            <div class="centerCol">
                <label for="cmbGender"><?php echo __("Gender"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"  <?php echo $disabled; ?> id="cmbGender" name="cmbGender">
                    <option value="0"><?php echo __("--Select--"); ?></option>
<?php
                    //Define data columns according culture
                    $genderNameCol = ($userCulture == "en") ? "gender_name" : "gender_name_" . $userCulture;
                    if ($genders) {
                        $currentGenderCode = isset($postArr['cmbGender']) ? $postArr['cmbGender'] : $genderCode;
                        foreach ($genders as $gender) {
                            $selected = ($currentGenderCode == $gender->gender_code) ? 'selected="selected"' : '';
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
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtInitials" id="txtInitials"
                       value="<?php echo (isset($postArr['txtInitials'])) ? $postArr['txtInitials'] : $empInitials; ?>" maxlength="30"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtInitialsSI" id="txtInitialsSI"
                       value="<?php echo (isset($postArr['txtInitialsSI'])) ? $postArr['txtInitialsSI'] : $empInitialsSI; ?>" maxlength="30"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtInitialsTA" id="txtInitialsTA"
                       value="<?php echo (isset($postArr['txtInitialsTA'])) ? $postArr['txtInitialsTA'] : $empInitialsTA; ?>" maxlength="30"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtNamesOfInitials"><?php echo __("Names Of Initials"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtNamesOfInitials" id="txtNamesOfInitials"
                       value="<?php echo (isset($postArr['txtNamesOfInitials'])) ? $postArr['txtNamesOfInitials'] : $empNamesOfInitials; ?>" maxlength="120"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtNamesOfInitialsSI" id="txtNamesOfInitialsSI"
                       value="<?php echo (isset($postArr['txtNamesOfInitialsSI'])) ? $postArr['txtNamesOfInitialsSI'] : $empNamesOfInitialsSI; ?>" maxlength="120"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtNamesOfInitialsTA" id="txtNamesOfInitialsTA"
                       value="<?php echo (isset($postArr['txtNamesOfInitialsTA'])) ? $postArr['txtNamesOfInitialsTA'] : $empNamesOfInitialsTA; ?>" maxlength="120"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtEmpFirstName"><?php echo __("First Name"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEmpFirstName" id="txtEmpFirstName"
                       value="<?php echo (isset($postArr['txtEmpFirstName'])) ? $postArr['txtEmpFirstName'] : $employeeFirstName; ?>" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEmpFirstNameSI" id="txtEmpFirstNameSI"
                       value="<?php echo (isset($postArr['txtEmpFirstNameSI'])) ? $postArr['txtEmpFirstNameSI'] : $employeeFirstNameSI; ?>" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEmpFirstNameTA" id="txtEmpFirstNameTA"
                       value="<?php echo (isset($postArr['txtEmpFirstNameTA'])) ? $postArr['txtEmpFirstNameTA'] : $employeeFirstNameTA; ?>" maxlength="50"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtEmpLastName"><?php echo __("Last Name"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEmpLastName" id="txtEmpLastName"
                       value="<?php echo (isset($postArr['txtEmpLastName'])) ? $postArr['txtEmpLastName'] : $employeeLastName; ?>" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEmpLastNameSI" id="txtEmpLastNameSI"
                       value="<?php echo (isset($postArr['txtEmpLastNameSI'])) ? $postArr['txtEmpLastNameSI'] : $employeeLastNameSI; ?>" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtEmpLastNameTA" id="txtEmpLastNameTA"
                       value="<?php echo (isset($postArr['txtEmpLastNameTA'])) ? $postArr['txtEmpLastNameTA'] : $employeeLastNameTA; ?>" maxlength="50"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtDOB"><?php echo __("Date Of Birth"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtDOB" id="txtDOB"
                       value="<?php echo (isset($postArr['txtDOB'])) ? $postArr['txtDOB'] : $birthday; ?>" />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtPlaceOfBirth"><?php echo __("Place Of Birth"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtPlaceOfBirth" id="txtPlaceOfBirth"
                       value="<?php echo (isset($postArr['txtPlaceOfBirth'])) ? $postArr['txtPlaceOfBirth'] : $birthLocation; ?>" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtPlaceOfBirthSI" id="txtPlaceOfBirthSI"
                       value="<?php echo (isset($postArr['txtPlaceOfBirthSI'])) ? $postArr['txtPlaceOfBirthSI'] : $birthLocationSI; ?>" maxlength="50"/>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtPlaceOfBirthTA" id="txtPlaceOfBirthTA"
                       value="<?php echo (isset($postArr['txtPlaceOfBirthTA'])) ? $postArr['txtPlaceOfBirthTA'] : $birthLocationTA; ?>" maxlength="50"/>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="cmbMaritalStatus"><?php echo __("Civil Status"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"  <?php echo $disabled; ?> id="cmbMaritalStatus" name="cmbMaritalStatus">
                    <option value="0"><?php echo __("--Select--"); ?></option>
<?php
                    //Define data columns according culture
                    $maritalStatusNameCol = ($userCulture == "en") ? "marst_name" : "marst_name_" . $userCulture;
                    if ($maritalStatusList) {
                        $currentMaritalStatusCode = isset($postArr['cmbMaritalStatus']) ? $postArr['cmbMaritalStatus'] : $maritalStatusCode;
                        foreach ($maritalStatusList as $maritalStatus) {
                            $selected = ($currentMaritalStatusCode == $maritalStatus->marst_code) ? 'selected="selected"' : '';
                            $maritalStatusName = $maritalStatus->$maritalStatusNameCol == "" ? $maritalStatus->marst_name : $maritalStatus->$maritalStatusNameCol;
                            echo "<option {$selected} value='{$maritalStatus->marst_code}'>{$maritalStatusName}</option>";
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
                       value="<?php echo (isset($postArr['txtMarriedDate'])) ? $postArr['txtMarriedDate'] : $marriedDate; ?>">
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtNICNo"><?php echo __("NIC No"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtNICNo" id="txtNICNo" readonly="readonly"
                       value="<?php echo (isset($postArr['txtNICNo'])) ? $postArr['txtNICNo'] : $nicNo; ?>" maxlength="10"/>
            </div>
            <div class="centerCol">
                <label for="txtNICIssueDate"><?php echo __("NIC Issue Date"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtNICIssueDate" id="txtNICIssueDate"
                       value="<?php echo (isset($postArr['txtNICIssueDate'])) ? $postArr['txtNICIssueDate'] : $nicIssueDate; ?>" />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtPassportNo"><?php echo __("Passport No"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtPassportNo" id="txtPassportNo"
                       value="<?php echo (isset($postArr['txtPassportNo'])) ? $postArr['txtPassportNo'] : $passportNo; ?>" maxlength="10"/>
            </div>
            <div class="centerCol">
                <label  id="lblPensionNumber" for="cmbReligion"><?php echo __("Pension No"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtPensionNo" id="txtPensionNo"
                       value="<?php echo (isset($postArr['txtPensionNo'])) ? $postArr['txtPensionNo'] : $pensionNo; ?>" maxlength="15"/>
            </div>

            <br class="clear"/>

            <div class="leftCol">
                <label for="cmbEthnicity"><?php echo __("Ethnicity"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"  <?php echo $disabled; ?> id="cmbEthnicity" name="cmbEthnicity">
                    <option value="0"><?php echo __("--Select--"); ?></option>
<?php
                    //Define data columns according culture
                    $ethnicRaceNameCol = ($userCulture == "en") ? "ethnic_race_desc" : "ethnic_race_desc_" . $userCulture;
                    if ($ethnicRaceList) {
                        $currentEthnicRaceCode = isset($postArr['cmbEthnicity']) ? $postArr['cmbEthnicity'] : $ethnicRaceCode;
                        foreach ($ethnicRaceList as $ethnicRace) {
                            $selected = ($currentEthnicRaceCode == $ethnicRace->ethnic_race_code) ? 'selected="selected"' : '';
                            $ethnicRaceName = $ethnicRace->$ethnicRaceNameCol == "" ? $ethnicRace->ethnic_race_desc : $ethnicRace->$ethnicRaceNameCol;
                            echo "<option {$selected} value='{$ethnicRace->ethnic_race_code}'>{$ethnicRaceName}</option>";
                        }
                    }
?>
                </select>
            </div>
            <div class="centerCol">
                <label for="cmbReligion"><?php echo __("Religion"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"  <?php echo $disabled; ?> id="cmbReligion" name="cmbReligion">
                    <option value="0"><?php echo __("--Select--"); ?></option>
<?php
                    //Define data columns according culture
                    $religionNameCol = ($userCulture == "en") ? "rlg_name" : "rlg_name_" . $userCulture;
                    if ($religionList) {
                        $currentReligionCode = isset($postArr['cmbReligion']) ? $postArr['cmbReligion'] : $rlgCode;
                        foreach ($religionList as $religion) {
                            $selected = ($currentReligionCode == $religion->rlg_code) ? 'selected="selected"' : '';
                            $religionName = $religion->$religionNameCol == "" ? $religion->rlg_name : $religion->$religionNameCol;
                            echo "<option {$selected} value='{$religion->rlg_code}'>{$religionName}</option>";
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
                <select class="formSelect"  <?php echo $disabled; ?> id="cmbLanguage" name="cmbLanguage">
                    <option value="0"><?php echo __("--Select--"); ?></option>
<?php
                    //Define data columns according culture
                    $languageNameCol = ($userCulture == "en") ? "lang_name" : "lang_name_" . $userCulture;
                    if ($languageList) {
                        $currentLanguageCode = isset($postArr['cmbLanguage']) ? $postArr['cmbLanguage'] : $langCode;
                        foreach ($languageList as $language) {
                            $selected = ($currentLanguageCode == $language->lang_code) ? 'selected="selected"' : '';
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
                <select class="formSelect"  <?php echo $disabled; ?> id="cmbNationality" name="cmbNationality">
                    <option value="0"><?php echo __("--Select--"); ?></option>
<?php
                    //Define data columns according culture
                    $nationalityNameCol = ($userCulture == "en") ? "nat_name" : "nat_name_" . $userCulture;
                    if ($nationalityList) {
                        $currentNationalityCode = isset($postArr['cmbNationality']) ? $postArr['cmbNationality'] : $nationCode;
                        foreach ($nationalityList as $nationality) {
                            $selected = ($currentNationalityCode == $nationality->nat_code) ? 'selected="selected"' : '';
                            $nationalityName = $nationality->$nationalityNameCol == "" ? $nationality->nat_name : $nationality->$nationalityNameCol;
                            echo "<option {$selected} value='{$nationality->nat_code}'>{$nationalityName}</option>";
                        }
                    }
?>
                </select>
            </div>
            <div class="centerCol">
                <label for="cmbCountry"><?php echo __("Country"); ?></label>
            </div>
            <div class="centerCol">
                <select class="formSelect"  <?php echo $disabled; ?> id="cmbCountry" name="cmbCountry">
                    <option value="0"><?php echo __("--Select--"); ?></option>
<?php
                    //Define data columns according culture
                    $countryNameCol = ($userCulture == "en") ? "cou_name" : "cou_name_" . $userCulture;
                    if ($countryList) {
                        $currentCountryCode = isset($postArr['cmbCountry']) ? $postArr['cmbCountry'] : $countryCode;
                        foreach ($countryList as $country) {
                            $selected = ($currentCountryCode == $country->cou_code) ? 'selected="selected"' : '';
                            $countryName = $country->$countryNameCol == "" ? $country->cou_name : $country->$countryNameCol;
                            echo "<option {$selected} value='{$country->cou_code}'>{$countryName}</option>";
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
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtSalaryNo" id="txtSalaryNo"
                       value="<?php echo (isset($postArr['txtSalaryNo'])) ? $postArr['txtSalaryNo'] : $salaryNo; ?>" maxlength="15"/>
            </div>
            <br class="clear"/>
            <div id="runningDiv">
                <div class="leftCol">
                    <label for="txtRunningFileNo"><?php echo __("Running File No"); ?></label>
                </div>
                <div class="centerCol">
                    <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtRunningFileNo" id="txtRunningFileNo"
                           value="<?php echo (isset($postArr['txtRunningFileNo'])) ? $postArr['txtRunningFileNo'] : $otherFileNo; ?>" maxlength="15"/>
                </div>
            </div>
            <div class="leftCol">
                <label for="txtBarCodeNo"><?php echo __("Bar Code No"); ?></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtBarCodeNo" id="txtBarCodeNo"
                       value="<?php echo (isset($postArr['txtBarCodeNo'])) ? $postArr['txtBarCodeNo'] : $barCodeNo; ?>" maxlength="15"/>
            </div>
            <br class="clear"/>
<?php if ($DisplayMode != "Ess") {
?>
                        <div class="formbuttons">
                            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="btnEditPersonalDetails"
                                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   />
                            <input type="reset" class="clearbutton" id="btnResetPersonalDetails" tabindex="5"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Reset"); ?>"/>
                            <input type="reset" class="clearbutton" id="btnBack" tabindex="5"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Back"); ?>"/>
                        </div>
<?php } ?>
                </form>
            </div>
        </div>
        <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<?php //}    ?>
        <script type="text/javascript">
            //<![CDATA[

<?php
                    $sysConf = OrangeConfig::getInstance()->getSysConf();
                    $dateHint = $sysConf->getDateInputHint();
                    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<?php $e = getdate();
$today = date("Y-m-d", $e[0]); 
?>
                    var EmpNIC;
                    function getPersonalDetails(empNumber){
                    $.post("<?php echo url_for('pim/GetPersonalDetailsById') ?>",
                    { empNumber: empNumber },
                    function(data){
                    setPersonalDetailsData(data);
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
                                            var text="Your NIC No Like : "+data+"####V";
                                        }else{
                                            var text="Your NIC No Like : "+data+"#######V"; 
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
                        

                    function lockPersonalDetails(empNumber){

                    $.post("<?php echo url_for('pim/lockPersonalDetails') ?>",
                    { empNumber: empNumber },
                    function(data){
                    if (data.recordLocked==true) {
                    getPersonalDetails(empNumber);
                    $("#frmEmpPersonalDetails").data('edit', '1'); // In edit mode
                    setPersonalDetailsAttributes();
                    }else {
                    alert("<?php echo __("Record Locked.") ?>");
                    }
                    },
                    "json"
                    );
                    }

                    function unlockPersonalDetails(empNumber){
                    $.post("<?php echo url_for('pim/unlockPersonalDetails') ?>",
                    { empNumber: empNumber },
                    function(data){
                    getPersonalDetails(empNumber);
                    $("#frmEmpPersonalDetails").data('edit', '0'); // In view mode
                    setPersonalDetailsAttributes();
                    },
                    "json"
                    );
                    }

                    function setPersonalDetailsData(data){
                    $("#txtEmployeeId").val(data.employeeId);
                    $("#txtAppLetterNo").val((data.emp_app_letter_no==null) ? '' : data.emp_app_letter_no);
                    $("#txtPersonalFileNo").val((data.emp_personal_file_no==null) ? '' : data.emp_personal_file_no);
                    $("#cmbTitle").val((data.title_code==null) ? 0 : data.title_code);
                    $("#txtEmpLastName").val((data.lastName==null)?  '' : data.lastName);
                    $("#txtEmpLastNameSI").val((data.lastName_si==null)?  '' : data.lastName_si);
                    $("#txtEmpLastNameTA").val((data.lastName_ta==null)?  '' : data.lastName_ta);
                    $("#txtEmpFirstName").val((data.firstName==null)?  '' : data.firstName);
                    $("#txtEmpFirstNameSI").val(data.firstName_si);
                    $("#txtEmpFirstNameTA").val(data.firstName_ta);
                    $("#txtInitials").val(data.emp_initials);
                    $("#txtInitialsSI").val(data.emp_initials_si);
                    $("#txtInitialsTA").val(data.emp_initials_ta);
                    $("#txtNamesOfInitials").val(data.emp_names_of_initials);
                    $("#txtNamesOfInitialsSI").val(data.emp_names_of_initials_si);
                    $("#txtNamesOfInitialsTA").val(data.emp_names_of_initials_ta);
                    $("#cmbGender").val((data.gender_code==null) ? 0 : data.gender_code);
                    $("#txtDOB").val(data.emp_birthday);
                    $("#txtPlaceOfBirth").val(data.emp_birth_location);
                    $("#txtPlaceOfBirthSI").val(data.emp_birth_location_si);
                    $("#txtPlaceOfBirthTA").val(data.emp_birth_location_ta);
                    $("#cmbMaritalStatus").val(data.marst_code);
                    $("#txtMarriedDate").val(data.emp_married_date);
                    $("#txtNICNo").val(data.emp_nic_no);
                    $("#txtNICIssueDate").val(data.emp_nic_date);
                    $("#txtPassportNo").val(data.emp_passport_no);
                    $("#cmbEthnicity").val((data.ethnic_race_code==null) ? 0 : data.ethnic_race_code);
                    $("#cmbReligion").val((data.rlg_code==null) ? 0 : data.rlg_code);
                    $("#cmbLanguage").val((data.lang_code==null) ? 0 : data.lang_code);
                    $("#cmbNationality").val((data.nation_code==null) ? 0 : data.nation_code);
                    $("#cmbCountry").val((data.cou_code==null) ? 0 : data.cou_code);
                    $("#txtSalaryNo").val(data.emp_salary_no);
                    $("#txtRunningFileNo").val(data.emp_other_file_no);
                    $("#txtBarCodeNo").val(data.emp_barcode_no);
                    $("#txtPensionNo").val((data.emp_pension_no==null) ? '' :data.emp_pension_no);
                    }

                    function setPersonalDetailsAttributes() {



                    var editMode = $("#frmEmpPersonalDetails").data('edit');
                    if (editMode == 0) {
                    $('#frmEmpPersonalDetails :input').attr('disabled','disabled');
                    $('#btnEditPersonalDetails').removeAttr('disabled');

                    $("#btnEditPersonalDetails").attr('value',"<?php echo __("Edit"); ?>");
                    $("#btnEditPersonalDetails").attr('title',"<?php echo __("Edit"); ?>");
                    }
                    else {
                    $('#frmEmpPersonalDetails :input').removeAttr('disabled');

                    $("#btnEditPersonalDetails").attr('value',"<?php echo __("Save"); ?>");
                    $("#btnEditPersonalDetails").attr('title',"<?php echo __("Save"); ?>");
                    }
                    $('#btnBack').removeAttr('disabled');
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
                    salNo: salNo
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
                    pensionNo: pensionNo
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
                    ApplettNo: ApplettNo
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
                                        EmployeeId: EmployeeId
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
                         
                    $("#btnBack").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/list')) ?>";

                    });

                    buttonSecurityCommon(null,null,"btnEditPersonalDetails",null);

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
                    $("#frmEmpPersonalDetails").data('edit', '0'); // In view mode
                    setPersonalDetailsAttributes();
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
                    // hide validation error messages
                    $("label.errortd[generated='true']").css('display', 'none');

                    $("#frmEmpPersonalDetails").validate({
                    rules: {
                    txtEmployeeId: { required: true, noSpecialCharsOnly: true },
                    txtAppLetterNo: { required: true, noSpecialCharsOnly: true },
                    txtPersonalFileNo: { required: true, noSpecialCharsOnly: true },
                    cmbTitle: { comboSelected: true },
                    txtEmpLastName: { required: true,required: true, noSpecialChars: true },
                    txtEmpLastNameSI: { required: true,noSpecialChars: true },
                    txtEmpLastNameTA: { required: true,noSpecialChars: true },
                    txtEmpFirstName: { required: true, noSpecialChars: true },
                    txtEmpFirstNameSI: { required: true,noSpecialChars: true },
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
                    txtEmpLastNameSI: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtEmpLastNameTA: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtEmpFirstName: { required: "<?php echo __('This field is required.') ?>", noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtEmpFirstNameSI: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtEmpFirstNameTA: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtInitials: { required: "<?php echo __('This field is required.') ?>", noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtInitialsSI: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtInitialsTA: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtNamesOfInitials: { required: "<?php echo __('This field is required.') ?>", noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtNamesOfInitialsSI: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtNamesOfInitialsTA: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    cmbGender: { comboSelected: "<?php echo __('This field is required.') ?>" },
                    txtDOB: { required: "<?php echo __('This field is required.') ?>", orange_date: '<?php echo __("Invalid date."); ?>' },
                    txtPlaceOfBirth: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtPlaceOfBirthSI: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    txtPlaceOfBirthTA: { noSpecialChars: "<?php echo __('This field contains invalid characters.') ?>" },
                    cmbMaritalStatus: { comboSelected: "<?php echo __('This field is required.') ?>" },
                    txtMarriedDate: { orange_date: '<?php echo __("Invalid date."); ?>' ,marriedDatevalidation:'<?php echo __('Married date should be less than to the date of birth') ?>' },
                    txtNICNo: { required: "<?php echo __('This field is required.') ?>", alphaNumeric: "<?php echo __('This field contains invalid characters.') ?>", minlength :"<?php echo __("Minimum 10 Characters") ?>" },
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
                   $('#btnEditPersonalDetails').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                   form.submit();
             }
});

// Switch edit mode or submit data when edit/save button is clicked
$("#btnEditPersonalDetails").click(function() {
  if($('#txtDOB').val()>'<?php echo $today; ?>'){
      alert("<?php echo __("Date of Birth can not be future Date.") ?>");
      return false;
  }  
  if($('#txtNICIssueDate').val()>'<?php echo $today; ?>'){
      alert("<?php echo __("NIC Issue Date can not be future Date.") ?>");
      return false;
  }

  
  

var editMode = $("#frmEmpPersonalDetails").data('edit');
if (editMode == 0) {
    

lockPersonalDetails($('#txtEmpID').val());
return false;
}
else {

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
                                        alert("<?php echo __("Your NIC No Like : ") ?>"+EmpNIC+"####V");
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
                                        alert("<?php echo __("Your NIC No Like : ") ?>"+EmpNIC+"#######V");
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
    
}else{

}
                    
}
});

$('#btnResetPersonalDetails').click(function() {
// hide validation error messages
$("label.errortd[generated='true']").css('display', 'none');

// 0 - view, 1 - edit, 2 - add
var editMode = $("#frmEmpPersonalDetails").data('edit');
if (editMode == 1) {
unlockPersonalDetails($('#txtEmpID').val());
return false;
}
else {
document.forms['frmEmpPersonalDetails'].reset('');
}
});

 $("#txtNICNo").focus(function(){
     NICValidation();
  });

});
//]]>
</script>
