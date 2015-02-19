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
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<!--<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>-->
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>

<style type="text/css">   

    #tabs{
        border:0px;
    }

    #tabs-1{
        width:800px;
        padding:0;
    }

    #tabs-2{
        width:800px;
        padding:0;
    }

    #tabs-3{
        width:800px;
        padding:0;
    }

    #tabs-4{
        width:800px;
        padding:0;
    }

</style>

<script type="text/javascript">
    $(function() {
        $("#tabs").tabs();
    });
</script>

<?php
if (isset($postArr['EditMode']) && $postArr['EditMode'] == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}

if (is_object($empContact)) {
    $offAddline1 = $empContact->con_off_addLine1;
    $offAddlineSI = $empContact->con_off_addLine1_si;
    $offAddlineTA = $empContact->con_off_addLine1_ta;
    $offAddline2 = $empContact->con_off_addLine2;
    $offAddline2SI = $empContact->con_off_addLine2_si;
    $offAddline2TA = $empContact->con_off_addLine2_ta;
    $offPostoffice = $empContact->con_off_del_postoffice;
    $offPostofficeSI = $empContact->con_off_del_postoffice_si;
    $offPostofficeTA = $empContact->con_off_del_postoffice_ta;
    $offPostalcode = $empContact->con_off_postal_code;
    $offCountry = $empContact->con_off_country;
    $offIntercom = $empContact->con_off_intercom;
    $offVIP = $empContact->con_off_vip;
    $offDirect = $empContact->con_off_direct;
    $offExt = $empContact->con_off_ext;
    $offFax = $empContact->con_off_fax;
    $offEmail = $empContact->con_off_email;
    $offURL = $empContact->con_off_url;

    $resAddline1 = $empContact->con_res_addLine1;
    $resAddline1SI = $empContact->con_res_addLine1_si;
    $resAddline1TA = $empContact->con_res_addLine1_ta;
    $resAddline2 = $empContact->con_res_addLine2;
    $resAddline2SI = $empContact->con_res_addLine2_si;
    $resAddline2TA = $empContact->con_res_addLine2_ta;
    $resPostoffice = $empContact->con_res_del_postoffice;
    $resPostofficeSI = $empContact->con_res_del_postoffice_si;
    $resPostofficeTA = $empContact->con_res_del_postoffice_ta;
    $resPostalcode = $empContact->con_res_postal_code;
    $resSectretariat = $empContact->con_res_div_sectretariat;
    $resSectretariatSI = $empContact->con_res_div_sectretariat_si;
    $resSectretariatTA = $empContact->con_res_div_sectretariat_ta;
    $resPoliceStation = $empContact->con_res_policesation;
    $resPoliceStationSI = $empContact->con_res_policesation_si;
    $resPoliceStationTA = $empContact->con_res_policesation_ta;
    $resDistrict = $empContact->con_res_district;
    $resDistrictSI = $empContact->con_res_district_si;
    $resDistrictTA = $empContact->con_res_district_ta;
    $resPhone = $empContact->con_res_phone;
    $resFax = $empContact->con_res_fax;
    $resMobile = $empContact->con_res_mobile;
    $resEmail = $empContact->con_res_email;

    $perAddline1 = $empContact->con_per_addLine1;
    $perAddline1SI = $empContact->con_per_addLine1_si;
    $perAddline1TA = $empContact->con_per_addLine1_ta;
    $perAddline2 = $empContact->con_per_addLine2;
    $perAddline2SI = $empContact->con_per_addLine2_si;
    $perAddline2TA = $empContact->con_per_addLine2_ta;
    $perPostoffice = $empContact->con_per_del_postoffice;
    $perPostofficeSI = $empContact->con_per_del_postoffice_si;
    $perPostofficeTA = $empContact->con_per_del_postoffice_ta;
    $perPostalcode = $empContact->con_per_postal_code;
    $perSectretariat = $empContact->con_per_div_sectretariat;
    $perSectretariatSI = $empContact->con_per_div_sectretariat_si;
    $perSectretariatTA = $empContact->con_per_div_sectretariat_ta;
    $perPoliceStation = $empContact->con_per_policesation;
    $perPoliceStationSI = $empContact->con_per_policesation_si;
    $perPoliceStationTA = $empContact->con_per_policesation_ta;
    $perDistrict = $empContact->con_per_district;
    $perDistrictSI = $empContact->con_per_district_si;
    $perDistrictTA = $empContact->con_per_district_ta;
    $perPhone = $empContact->con_per_phone;
    $perFax = $empContact->con_per_fax;
    $perMobile = $empContact->con_per_mobile;
    $perEmail = $empContact->con_per_email;


    $othAddline1 = $empContact->con_oth_addLine1;
    $othAddline1SI = $empContact->con_oth_addLine1_si;
    $othAddline1TA = $empContact->con_oth_addLine1_ta;
    $othAddline2 = $empContact->con_oth_addLine2;
    $othAddline2SI = $empContact->con_oth_addLine2_si;
    $othAddline2TA = $empContact->con_oth_addLine2_ta;
    $othPostoffice = $empContact->con_oth_del_postoffice;
    $othPostofficeSI = $empContact->con_oth_del_postoffice_si;
    $othPostofficeTA = $empContact->con_oth_del_postoffice_ta;
    $othPostalcode = $empContact->con_oth_postal_code;
    $othSectretariat = $empContact->con_oth_div_sectretariat;
    $othSectretariatSI = $empContact->con_oth_div_sectretariat_si;
    $othSectretariatTA = $empContact->con_oth_div_sectretariat_ta;
    $othPoliceStation = $empContact->con_oth_policesation;
    $othPoliceStationSI = $empContact->con_oth_policesation_si;
    $othPoliceStationTA = $empContact->con_oth_policesation_ta;
    $othDistrict = $empContact->con_oth_district;
    $othDistrictSI = $empContact->con_oth_district_si;
    $othDistrictTA = $empContact->con_oth_district_ta;
    $othPhone = $empContact->con_oth_phone;
    $othFax = $empContact->con_oth_fax;
    $othMobile = $empContact->con_oth_mobile;
    $othEmail = $empContact->con_oth_email;
} else {
    $offAddline1 = "";
    $offAddlineSI = "";
    $offAddlineTA = "";
    $offAddline2 = "";
    $offAddline2SI = "";
    $offAddline2TA = "";
    $offPostoffice = "";
    $offPostofficeSI = "";
    $offPostofficeTA = "";
    $offPostalcode = "";
    $offCountry = "";
    $offIntercom = "";
    $offVIP = "";
    $offDirect = "";
    $offExt = "";
    $offFax = "";
    $offEmail = "";
    $offURL = "";

    $resAddline1 = "";
    $resAddline1SI = "";
    $resAddline1TA = "";
    $resAddline2 = "";
    $resAddline2SI = "";
    $resAddline2TA = "";
    $resPostoffice = "";
    $resPostofficeSI = "";
    $resPostofficeTA = "";
    $resPostalcode = "";
    $resSectretariat = "";
    $resSectretariatSI = "";
    $resSectretariatTA = "";
    $resPoliceStation = "";
    $resPoliceStationSI = "";
    $resPoliceStationTA = "";
    $resDistrict = "";
    $resDistrictSI = "";
    $resDistrictTA = "";
    $resPhone = "";
    $resFax = "";
    $resMobile = "";
    $resEmail = "";

    $perAddline1 = "";
    $perAddline1SI = "";
    $perAddline1TA = "";
    $perAddline2 = "";
    $perAddline2SI = "";
    $perAddline2TA = "";
    $perPostoffice = "";
    $perPostofficeSI = "";
    $perPostofficeTA = "";
    $perPostalcode = "";
    $perSectretariat = "";
    $perSectretariatSI = "";
    $perSectretariatTA = "";
    $perPoliceStation = "";
    $perPoliceStationSI = "";
    $perPoliceStationTA = "";
    $perDistrict = "";
    $perDistrictSI = "";
    $perDistrictTA = "";
    $perPhone = "";
    $perFax = "";
    $perMobile = "";
    $perEmail = "";

    $othAddline1 = "";
    $othAddline1SI = "";
    $othAddline1TA = "";
    $othAddline2 = "";
    $othAddline2SI = "";
    $othAddline2TA = "";
    $othPostoffice = "";
    $othPostofficeSI = "";
    $othPostofficeTA = "";
    $othPostalcode = "";
    $othSectretariat = "";
    $othSectretariatSI = "";
    $othSectretariatTA = "";
    $othPoliceStation = "";
    $othPoliceStationSI = "";
    $othPoliceStationTA = "";
    $othDistrict = "";
    $othDistrictSI = "";
    $othDistrictTA = "";
    $othPhone = "";
    $othFax = "";
    $othMobile = "";
    $othEmail = "";
}

if ($currentPane == 4) {
    include_partial('pim_form_errors', array('sf_user' => $sf_user));
}
?>
<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Contact Details"); ?></h2></div>

        <form id="frmEmpContactDetails" method="post" action="<?php echo url_for('pim/contactDetail?empNumber=' . $employee->empNumber); ?>">
            <input type="hidden" name="txtEmpID"  id="txtEmpID" value="<?php echo $employee->empNumber; ?>"/>
<?php echo message() ?>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1"><?php echo __("Official") ?></a></li>                    
                    <li><a href="#tabs-3"><?php echo __("Permanent") ?></a></li>
                    <li><a href="#tabs-2"><?php echo __("Temporary") ?></a></li>
                    <li><a href="#tabs-4"><?php echo __("Other") ?></a></li>
                </ul>
                <div id="tabs-1">
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
                        <label for="txtOffBuildingNo"><?php echo __("Address Line 1"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffAddline1" id="txtOffAddline1"
                               value="<?php echo (isset($postArr['txtOffAddline1'])) ? $postArr['txtOffAddline1'] : $offAddline1; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffAddline1SI" id="txtOffAddline1SI"
                               value="<?php echo (isset($postArr['txtOffAddline1SI'])) ? $postArr['txtOffAddline1SI'] : $offAddlineSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffAddline1TA" id="txtOffAddline1TA"
                               value="<?php echo (isset($postArr['txtOffAddline1TA'])) ? $postArr['txtOffAddline1TA'] : $offAddlineTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffBuildingNo"><?php echo __("Address Line 2"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffAddline2" id="txtOffAddline2"
                               value="<?php echo (isset($postArr['txtOffAddline2'])) ? $postArr['txtOffAddline2'] : $offAddline2; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffAddline2SI" id="txtOffAddline2SI"
                               value="<?php echo (isset($postArr['txtOffAddline2SI'])) ? $postArr['txtOffAddline2SI'] : $offAddline2SI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffAddline2TA" id="txtOffAddline2TA"
                               value="<?php echo (isset($postArr['txtOffAddline2TA'])) ? $postArr['txtOffAddline2TA'] : $offAddline2TA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>


                    <div class="leftCol">
                        <label for="txtOffBuildingNo"><?php echo __("Delivery Post Office"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffPostOffice" id="txtOffPostOffice"
                               value="<?php echo (isset($postArr['txtOffPostOffice'])) ? $postArr['txtOffPostOffice'] : $offPostoffice; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffPostOfficeSI" id="txtOffPostOfficeSI"
                               value="<?php echo (isset($postArr['txtOffPostOfficeSI'])) ? $postArr['txtOffPostOfficeSI'] : $offPostofficeSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffPostOfficeTA" id="txtOffPostOfficeTA"
                               value="<?php echo (isset($postArr['txtOffPostOfficeTA'])) ? $postArr['txtOffPostOfficeTA'] : $offPostofficeTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffBuildingName"><?php echo __("Address Postal Code"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffPostalCode"  id="txtOffPostalCode"
                               value="<?php echo (isset($postArr['txtOffPostalCode'])) ? $postArr['txtOffPostalCode'] : $offPostalcode; ?>" maxlength="50" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("Address Country"); ?></label>
                    </div>
                    <div class="centerCol">
                        <select class="formSelect" id="cmbCountry" name="cmbCountry"><span class="required">*</span>
                            <option value=""><?php echo __("--Select--"); ?></option>
<?php
//Define data columns according culture
$CountryCol = ($userCulture == "en") ? "getName" : "getCou_name_" . $userCulture;
if ($countries!= null) {
    $currenCountry = !strlen($offCountry) ? "LK" : $offCountry;
    foreach ($countries as $offCountryList) {
        $selected = ($currenCountry == $offCountryList->getCou_code()) ? 'selected="selected"' : '';
        $countryName = $offCountryList->$CountryCol() == "" ? $offCountryList->getName() : $offCountryList->$CountryCol();
        echo "<option {$selected} value='{$offCountryList->getCou_code()}'>{$countryName}</option>";
    }
}
?>
                        </select>
                    </div>
                    <br class="clear"/>



                    <div class="leftCol">
                        <label for="txtOffIntercom"><?php echo __("Phone No (Intercom)"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffIntercom"  id="txtOffIntercom"
                               value="<?php echo (isset($postArr['txtOffIntercom'])) ? $postArr['txtOffIntercom'] : $offIntercom; ?>" maxlength="10" />
                    </div>
                    <div class="centerCol">
                        <label for="txtOffVIP"><?php echo __("Phone No (VIP)"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffVIP"  id="txtOffVIP"
                               value="<?php echo (isset($postArr['txtOffVIP'])) ? $postArr['txtOffVIP'] : $offVIP; ?>" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffDirect"><?php echo __("Phone No (Direct Line)"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffDirect"  id="txtOffDirect"
                               value="<?php echo (isset($postArr['txtOffDirect'])) ? $postArr['txtOffDirect'] : $offDirect; ?>" maxlength="10" />
                    </div>
                    <div class="centerCol">
                        <label for="txtOffExt"><?php echo __("Phone Extension"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffExt"  id="txtOffExt"
                               value="<?php echo (isset($postArr['txtOffExt'])) ? $postArr['txtOffExt'] : $offExt; ?>" maxlength="4" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffFax"><?php echo __("Fax No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffFax"  id="txtOffFax"
                               value="<?php echo (isset($postArr['txtOffFax'])) ? $postArr['txtOffFax'] : $offFax; ?>" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffEmail"><?php echo __("Email"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffEmail"  id="txtOffEmail"
                               value="<?php echo (isset($postArr['txtOffEmail'])) ? $postArr['txtOffEmail'] : $offEmail; ?>" maxlength="60" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffURL"><?php echo __("URL"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtOffURL"  id="txtOffURL"
                               value="<?php echo (isset($postArr['txtOffURL'])) ? $postArr['txtOffURL'] : $offURL; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>

                </div>
                <div id="tabs-2">
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
                        <label for="txtOffBuildingNo"><?php echo __("Address Line 1"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresAddline1" id="txtresAddline1"
                               value="<?php echo (isset($postArr['txtresAddline1'])) ? $postArr['txtresAddline1'] : $resAddline1; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresAddline1SI" id="txtresAddline1SI"
                               value="<?php echo (isset($postArr['txtresAddline1SI'])) ? $postArr['txtresAddline1SI'] : $resAddline1SI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresAddline1TA" id="txtresAddline1TA"
                               value="<?php echo (isset($postArr['txtresAddline1TA'])) ? $postArr['txtresAddline1TA'] : $resAddline1TA; ?>" maxlength="100" />
                    </div>

                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffBuildingNo"><?php echo __("Address Line 2"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresAddline2" id="txtresAddline2"
                               value="<?php echo (isset($postArr['txtresAddline2'])) ? $postArr['txtresAddline2'] : $resAddline2; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresAddline2SI" id="txtresAddline2SI"
                               value="<?php echo (isset($postArr['txtresAddline2SI'])) ? $postArr['txtresAddline2SI'] : $resAddline2SI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresAddline2TA" id="txtresAddline2TA"
                               value="<?php echo (isset($postArr['txtresAddline2TA'])) ? $postArr['txtresAddline2TA'] : $resAddline2TA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>


                    <div class="leftCol">
                        <label for="txtOffBuildingNo"><?php echo __("Delivery Post Office"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresPostOffice" id="txtresPostOffice"
                               value="<?php echo (isset($postArr['txtresPostOffice'])) ? $postArr['txtresPostOffice'] : $resPostoffice; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresPostOfficeSI" id="txtresPostOfficeSI"
                               value="<?php echo (isset($postArr['txtresPostOfficeSI'])) ? $postArr['txtresPostOfficeSI'] : $resPostofficeSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresPostOfficeTA" id="txtresPostOfficeTA"
                               value="<?php echo (isset($postArr['txtresPostOfficeTA'])) ? $postArr['txtresPostOfficeTA'] : $resPostofficeTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffBuildingName"><?php echo __("Address Postal Code"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresPostalCode"  id="txtresPostalCode"
                               value="<?php echo (isset($postArr['txtresPostalCode'])) ? $postArr['txtresPostalCode'] : $resPostalcode; ?>" maxlength="50" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("Divisional Secretariat"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresDivisiSec" id="txtresDivisiSec"
                               value="<?php echo (isset($postArr['txtresDivisiSec'])) ? $postArr['txtresDivisiSec'] : $resSectretariat; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresDivisiSecSI" id="txtresDivisiSecSI"
                               value="<?php echo (isset($postArr['txtresDivisiSecSI'])) ? $postArr['txtresDivisiSecSI'] : $resSectretariatSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresDivisiSecTA" id="txtresDivisiSecTA"
                               value="<?php echo (isset($postArr['txtresDivisiSecTA'])) ? $postArr['txtresDivisiSecTA'] : $resSectretariatTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("Nearest Police Station"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresPoliceStaion" id="txtresPoliceStaion"
                               value="<?php echo (isset($postArr['txtresPoliceStaion'])) ? $postArr['txtresPoliceStaion'] : $resPoliceStation; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresPoliceStaionSI" id="txtresPoliceStaionSI"
                               value="<?php echo (isset($postArr['txtresPoliceStaionSI'])) ? $postArr['txtresPoliceStaionSI'] : $resPoliceStationSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresPoliceStaionTA" id="txtresPoliceStaionTA"
                               value="<?php echo (isset($postArr['txtresPoliceStaionTA'])) ? $postArr['txtresPoliceStaionTA'] : $resPoliceStationTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("District"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresDistric" id="txtresDistric"
                               value="<?php echo (isset($postArr['txtresDistric'])) ? $postArr['txtresDistric'] : $resDistrict; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresDistricSI" id="txtresDistricSI"
                               value="<?php echo (isset($postArr['txtresDistricSI'])) ? $postArr['txtresDistricSI'] : $resDistrictSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresDistricTA" id="txtresDistricTA"
                               value="<?php echo (isset($postArr['txtresDistricTA'])) ? $postArr['txtresDistricTA'] : $resDistrictTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthPhone"><?php echo __("Phone No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresPhone"  id="txtresPhone"
                               value="<?php echo (isset($postArr['txtresPhone'])) ? $postArr['txtresPhone'] : $resPhone; ?>" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthFax"><?php echo __("Fax No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresFax"  id="txtresFax"
                               value="<?php echo (isset($postArr['txtresFax'])) ? $postArr['txtresFax'] : $resFax; ?>" maxlength="10" />
                    </div>
                    <div class="centerCol">
                        <label for="txtOthMobile"><?php echo __("Mobile No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresMobile"  id="txtresMobile"
                               value="<?php echo (isset($postArr['txtresMobile'])) ? $postArr['txtresMobile'] : $resMobile; ?>" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthEmail"><?php echo __("Email"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtresEmail"  id="txtresEmail"
                               value="<?php echo (isset($postArr['txtresEmail'])) ? $postArr['txtresEmail'] : $resEmail; ?>" maxlength="60" />
                    </div>

                    <br class="clear"/>
                </div>
                <div id="tabs-3">
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
                        <label for="txtOffBuildingNo"><?php echo __("Address Line 1"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperAddline1" id="txtperAddline1"
                               value="<?php echo (isset($postArr['txtperAddline1'])) ? $postArr['txtperAddline1'] : $perAddline1; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperAddline1SI" id="txtperAddline1SI"
                               value="<?php echo (isset($postArr['txtperAddline1SI'])) ? $postArr['txtperAddline1SI'] : $perAddline1SI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperAddline1TA" id="txtperAddline1TA"
                               value="<?php echo (isset($postArr['txtperAddline1TA'])) ? $postArr['txtperAddline1TA'] : $perAddline1TA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffBuildingNo"><?php echo __("Address Line 2"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperAddline2" id="txtperAddline2"
                               value="<?php echo (isset($postArr['txtperAddline2'])) ? $postArr['txtperAddline2'] : $perAddline2; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperAddline2SI" id="txtperAddline2SI"
                               value="<?php echo (isset($postArr['txtperAddline2SI'])) ? $postArr['txtperAddline2SI'] : $perAddline2SI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperAddline2TA" id="txtperAddline2TA"
                               value="<?php echo (isset($postArr['txtperAddline2TA'])) ? $postArr['txtperAddline2TA'] : $perAddline2TA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>


                    <div class="leftCol">
                        <label for="txtOffBuildingNo"><?php echo __("Delivery Post Office"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperPostOffice" id="txtperPostOffice"
                               value="<?php echo (isset($postArr['txtperPostOffice'])) ? $postArr['txtperPostOffice'] : $perPostoffice; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperPostOfficeSI" id="txtperPostOfficeSI"
                               value="<?php echo (isset($postArr['txtperPostOfficeSI'])) ? $postArr['txtperPostOfficeSI'] : $perPostofficeSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperPostOfficeTA" id="txtperPostOfficeTA"
                               value="<?php echo (isset($postArr['txtperPostOfficeTA'])) ? $postArr['txtperPostOfficeTA'] : $perPostofficeTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffBuildingName"><?php echo __("Address Postal Code"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperPostalCode"  id="txtperPostalCode"
                               value="<?php echo (isset($postArr['txtresPostalCode'])) ? $postArr['txtperPostalCode'] : $perPostalcode; ?>" maxlength="50" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("Divisional Secretariat"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperDivisiSec" id="txtperDivisiSec"
                               value="<?php echo (isset($postArr['txtperDivisiSec'])) ? $postArr['txtperDivisiSec'] : $perSectretariat; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperDivisiSecSI" id="txtperDivisiSecSI"
                               value="<?php echo (isset($postArr['txtperDivisiSecSI'])) ? $postArr['txtperDivisiSecSI'] : $perSectretariatSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperDivisiSecTA" id="txtperDivisiSecTA"
                               value="<?php echo (isset($postArr['txtperDivisiSecTA'])) ? $postArr['txtperDivisiSecTA'] : $perSectretariatTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("Nearest Police Station"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperPoliceStaion" id="txtperPoliceStaion"
                               value="<?php echo (isset($postArr['txtperPoliceStaion'])) ? $postArr['txtperPoliceStaion'] : $perPoliceStation; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperPoliceStaionSI" id="txtperPoliceStaionSI"
                               value="<?php echo (isset($postArr['txtperPoliceStaionSI'])) ? $postArr['txtperPoliceStaionSI'] : $perPoliceStationSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperPoliceStaionTA" id="txtperPoliceStaionTA"
                               value="<?php echo (isset($postArr['txtperPoliceStaionTA'])) ? $postArr['txtperPoliceStaionTA'] : $perPoliceStationTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("District"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperDistric" id="txtperDistric"
                               value="<?php echo (isset($postArr['txtperDistric'])) ? $postArr['txtperDistric'] : $perDistrict; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperDistricSI" id="txtperDistricSI"
                               value="<?php echo (isset($postArr['txtperDistricSI'])) ? $postArr['txtperDistricSI'] : $perDistrictSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperDistricTA" id="txtperDistricTA"
                               value="<?php echo (isset($postArr['txtperDistricTA'])) ? $postArr['txtperDistricTA'] : $perDistrictTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthPhone"><?php echo __("Phone No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperPhone"  id="txtperPhone"
                               value="<?php echo (isset($postArr['txtperPhone'])) ? $postArr['txtperPhone'] : $perPhone; ?>" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthFax"><?php echo __("Fax No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperFax"  id="txtperFax"
                               value="<?php echo (isset($postArr['txtperFax'])) ? $postArr['txtperFax'] : $perFax; ?>" maxlength="10" />
                    </div>
                    <div class="centerCol">
                        <label for="txtOthMobile"><?php echo __("Mobile No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperMobile"  id="txtperMobile"
                               value="<?php echo (isset($postArr['txtperMobile'])) ? $postArr['txtperMobile'] : $perMobile; ?>" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthEmail"><?php echo __("Email"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtperEmail"  id="txtperEmail"
                               value="<?php echo (isset($postArr['txtperEmail'])) ? $postArr['txtperEmail'] : $perEmail; ?>" maxlength="60" />
                    </div>

                    <br class="clear"/>

                </div>
                <div id="tabs-4">

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
                        <label for="txtOffBuildingNo"><?php echo __("Address Line 1"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothAddline1" id="txtothAddline1"
                               value="<?php echo (isset($postArr['txtothAddline1'])) ? $postArr['txtothAddline1'] : $othAddline1; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothAddline1SI" id="txtothAddline1SI"
                               value="<?php echo (isset($postArr['txtothAddline1SI'])) ? $postArr['txtothAddline1SI'] : $othAddline1SI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothAddline1TA" id="txtothAddline1TA"
                               value="<?php echo (isset($postArr['txtothAddline1TA'])) ? $postArr['txtothAddline1TA'] : $othAddline1TA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffBuildingNo"><?php echo __("Address Line 2"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothAddline2" id="txtothAddline2"
                               value="<?php echo (isset($postArr['txtothAddline2'])) ? $postArr['txtothAddline2'] : $othAddline2; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothAddline2SI" id="txtothAddline2SI"
                               value="<?php echo (isset($postArr['txtothAddline2SI'])) ? $postArr['txtothAddline2SI'] : $othAddline2SI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothAddline2TA" id="txtothAddline2TA"
                               value="<?php echo (isset($postArr['txtothAddline2TA'])) ? $postArr['txtothAddline2TA'] : $othAddline2TA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>


                    <div class="leftCol">
                        <label for="txtOffBuildingNo"><?php echo __("Delivery Post Office"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothPostOffice" id="txtothPostOffice"
                               value="<?php echo (isset($postArr['txtothPostOffice'])) ? $postArr['txtothPostOffice'] : $othPostoffice; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothPostOfficeSI" id="txtothPostOfficeSI"
                               value="<?php echo (isset($postArr['txtothPostOfficeSI'])) ? $postArr['txtothPostOfficeSI'] : $othPostofficeSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothPostOfficeTA" id="txtothPostOfficeTA"
                               value="<?php echo (isset($postArr['txtothPostOfficeTA'])) ? $postArr['txtothPostOfficeTA'] : $othPostofficeTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffBuildingName"><?php echo __("Address Postal Code"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothPostalCode"  id="txtothPostalCode"
                               value="<?php echo (isset($postArr['txtothPostalCode'])) ? $postArr['txtothPostalCode'] : $othPostalcode; ?>" maxlength="50" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("Divisional Secretariat"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothDivisiSec" id="txtothDivisiSec"
                               value="<?php echo (isset($postArr['txtothDivisiSec'])) ? $postArr['txtothDivisiSec'] : $othSectretariat; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothDivisiSecSI" id="txtothDivisiSecSI"
                               value="<?php echo (isset($postArr['txtothDivisiSecSI'])) ? $postArr['txtothDivisiSecSI'] : $othSectretariatSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothDivisiSecTA" id="txtothDivisiSecTA"
                               value="<?php echo (isset($postArr['txtothDivisiSecTA'])) ? $postArr['txtothDivisiSecTA'] : $othSectretariatTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("Nearest Police Station"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothPoliceStaion" id="txtothPoliceStaion"
                               value="<?php echo (isset($postArr['txtothPoliceStaion'])) ? $postArr['txtothPoliceStaion'] : $othPoliceStation; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothPoliceStaionSI" id="txtothPoliceStaionSI"
                               value="<?php echo (isset($postArr['txtothPoliceStaionSI'])) ? $postArr['txtothPoliceStaionSI'] : $othPoliceStationSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothPoliceStaionTA" id="txtothPoliceStaionTA"
                               value="<?php echo (isset($postArr['txtothPoliceStaionTA'])) ? $postArr['txtothPoliceStaionTA'] : $othPoliceStationTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label for="txtOffStreet"><?php echo __("District"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothDistric" id="txtothDistric"
                               value="<?php echo (isset($postArr['txtothDistric'])) ? $postArr['txtothDistric'] : $othDistrict; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothDistricSI" id="txtothDistricSI"
                               value="<?php echo (isset($postArr['txtothDistricSI'])) ? $postArr['txtothDistricSI'] : $othDistrictSI; ?>" maxlength="100" />
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothDistricTA" id="txtothDistricTA"
                               value="<?php echo (isset($postArr['txtothDistricTA'])) ? $postArr['txtothDistricTA'] : $othDistrictTA; ?>" maxlength="100" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthPhone"><?php echo __("Phone No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothPhone"  id="txtothPhone"
                               value="<?php echo (isset($postArr['txtothPhone'])) ? $postArr['txtothPhone'] : $othPhone; ?>" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthFax"><?php echo __("Fax No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothFax"  id="txtothFax"
                               value="<?php echo (isset($postArr['txtothFax'])) ? $postArr['txtothFax'] : $othFax; ?>" maxlength="10" />
                    </div>
                    <div class="centerCol">
                        <label for="txtOthMobile"><?php echo __("Mobile No"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothMobile"  id="txtothMobile"
                               value="<?php echo (isset($postArr['txtothMobile'])) ? $postArr['txtothMobile'] : $othMobile; ?>" maxlength="10" />
                    </div>
                    <br class="clear"/>

                    <div class="leftCol">
                        <label for="txtOthEmail"><?php echo __("Email"); ?></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" <?php echo $disabled; ?> name="txtothEmail"  id="txtothEmail"
                               value="<?php echo (isset($postArr['txtothEmail'])) ? $postArr['txtothEmail'] : $othEmail; ?>" maxlength="60" />
                    </div>

                    <br class="clear"/>

                </div>
            </div>


            <div class="formbuttons">
                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="btnEditContactDetails"
                       value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="reset" class="clearbutton" id="btnResetContactDetails" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />
            </div>
        </form>
    </div>
</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<script type="text/javascript">
    //<![CDATA[

    function getContactDetails(empNumber){
        $.post("<?php echo url_for('pim/GetContactDetailsById') ?>",
        { empNumber: empNumber },
        function(data){
            if(data!=null){
                setContactDetailsData(data);
            }

        },
        "json"
    );
    }

    function lockContactDetails(empNumber){
        $.post("<?php echo url_for('pim/lockContactDetails') ?>",
        { empNumber: empNumber },
        function(data){
            if (data.recordLocked==true) {
                getContactDetails(empNumber);
                $("#frmEmpContactDetails").data('edit', '1'); // In edit mode
                setContactDetailsAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
    );
    }

    function unlockContactDetails(empNumber){
        $.post("<?php echo url_for('pim/unlockContactDetails') ?>",
        { empNumber: empNumber },
        function(data){
            getContactDetails(empNumber);
            $("#frmEmpContactDetails").data('edit', '0'); // In view mode
            setContactDetailsAttributes();
        },
        "json"
    );
    }

    function setContactDetailsData(data){
        $("#txtOffAddline1").val(data.con_off_addLine1);
        $("#txtOffAddline1SI").val(data.con_off_addLine1_si);
        $("#txtOffAddline1TA").val(data.con_off_addLine1_ta);
        $("#txtOffAddline2").val(data.con_off_addLine2);
        $("#txtOffAddline2SI").val(data.con_off_addLine2_si);
        $("#txtOffAddline2TA").val(data.con_off_addLine2_ta);
        $("#txtOffPostOffice").val(data.con_off_del_postoffice);
        $("#txtOffPostOfficeSI").val(data.con_off_del_postoffice_si);
        $("#txtOffPostOfficeTA").val(data.con_off_del_postoffice_ta);
        $("#txtOffPostalCode").val(data.con_off_postal_code);
        $("#txtOffIntercom").val(data.con_off_intercom);
        $("#txtOffVIP").val(data.con_off_vip);
        $("#txtOffDirect").val(data.con_off_direct);
        $("#txtOffExt").val(data.con_off_ext);
        $("#txtOffFax").val(data.con_off_fax);
        $("#txtOffEmail").val(data.con_off_email);
        $("#txtOffURL").val(data.con_off_url);

        $("#txtresAddline1").val(data.con_res_addLine1);
        $("#txtresAddline1SI").val(data.con_res_addLine1_si);
        $("#txtresAddline1TA").val(data.con_res_addLine1_ta);
        $("#txtresAddline2").val(data.con_res_addLine2);
        $("#txtresAddline2SI").val(data.con_res_addLine2_si);
        $("#txtresAddline2TA").val(data.con_res_addLine2_ta);
        $("#txtresPostOffice").val(data.con_res_del_postoffice);
        $("#txtresPostOfficeSI").val(data.res_off_del_postoffice_si);
        $("#txtresPostOfficeTA").val(data.res_off_del_postoffice_ta);
        $("#txtresDivisiSec").val(data.con_res_div_sectretariat);
        $("#txtresDivisiSecSI").val(data.con_res_div_sectretariat_si);
        $("#txtresDivisiSecTA").val(data.con_res_div_sectretariat_ta);
        $("#txtresPoliceStaion").val(data.con_res_policesation);
        $("#txtresPoliceStaionSI").val(data.con_res_policesation_si);
        $("#txtresPoliceStaionTA").val(data.con_res_policesation_ta);
        $("#txtresDistric").val(data.con_res_district);
        $("#txtresDistricSI").val(data.con_res_district_si);
        $("#txtresDistricTA").val(data.con_res_district_ta);
        $("#txtresPostalCode").val(data.con_res_postal_code);
        $("#txtresPhone").val(data.con_res_phone);
        $("#txtresFax").val(data.con_res_fax);
        $("#txtresEmail").val(data.con_res_email);
        $("#txtresMobile").val(data.con_res_mobile);

        $("#txtpreAddline1").val(data.con_pre_addLine1);
        $("#txtpreAddline1SI").val(data.con_pre_addLine1_si);
        $("#txtpreAddline1TA").val(data.con_pre_addLine1_ta);
        $("#txtpreAddline2").val(data.con_pre_addLine2);
        $("#txtpreAddline2SI").val(data.con_pre_addLine2_si);
        $("#txtpreAddline2TA").val(data.con_pre_addLine2_ta);
        $("#txtprePostOffice").val(data.con_pre_del_postoffice);
        $("#txtprePostOfficeSI").val(data.con_pre_del_postoffice_si);
        $("#txtprePostOfficeTA").val(data.con_pre_del_postoffice_ta);
        $("#txtpreDivisiSec").val(data.con_res_pre_sectretariat);
        $("#txtpreDivisiSecSI").val(data.con_res_pre_sectretariat_si);
        $("#txtpreDivisiSecTA").val(data.con_res_pre_sectretariat_ta);
        $("#txtprePoliceStaion").val(data.con_pre_policesation);
        $("#txtprePoliceStaionSI").val(data.con_pre_policesation_si);
        $("#txtprePoliceStaionTA").val(data.con_pre_policesation_ta);
        $("#txtpreDistric").val(data.con_pre_district);
        $("#txtpreDistricSI").val(data.con_pre_district_si);
        $("#txtpreDistricTA").val(data.con_pre_district_ta);
        $("#txtprePostalCode").val(data.con_pre_postal_code);
        $("#txtprePhone").val(data.con_pre_phone);
        $("#txtpreFax").val(data.con_pre_fax);
        $("#txtpreEmail").val(data.con_pre_email);
        $("#txtpreMobile").val(data.con_pre_mobile);

        $("#txtothAddline1").val(data.con_oth_addLine1);
        $("#txtothAddline1SI").val(data.con_oth_addLine1_si);
        $("#txtothAddline1TA").val(data.con_oth_addLine1_ta);
        $("#txtothAddline2").val(data.con_oth_addLine2);
        $("#txtothAddline2SI").val(data.con_oth_addLine2_si);
        $("#txtothAddline2TA").val(data.con_oth_addLine2_ta);
        $("#txtothPostOffice").val(data.con_oth_del_postoffice);
        $("#txtothPostOfficeSI").val(data.con_oth_del_postoffice_si);
        $("#txtothPostOfficeTA").val(data.con_oth_del_postoffice_ta);
        $("#txtothDivisiSec").val(data.con_oth_div_sectretariat);
        $("#txtothDivisiSecSI").val(data.con_oth_div_sectretariat_si);
        $("#txtothDivisiSecTA").val(data.con_oth_div_sectretariat_ta);
        $("#txtothPoliceStaion").val(data.con_oth_policesation);
        $("#txtothPoliceStaionSI").val(data.con_oth_policesation_si);
        $("#txtothPoliceStaionTA").val(data.con_oth_policesation_ta);
        $("#txtothDistric").val(data.con_oth_district);
        $("#txtothDistricSI").val(data.con_oth_district_si);
        $("#txtothDistricTA").val(data.con_oth_district_ta);
        $("#txtothPostalCode").val(data.con_oth_postal_code);
        $("#txtothPhone").val(data.con_oth_phone);
        $("#txtothFax").val(data.con_oth_fax);
        $("#txtothEmail").val(data.con_oth_email);
        $("#txtothMobile").val(data.con_oth_mobile);
    }

    function setContactDetailsAttributes() {

        var editMode = $("#frmEmpContactDetails").data('edit');
        if (editMode == 0) {
            $('#frmEmpContactDetails :input').attr('disabled','disabled');
            $('#btnEditContactDetails').removeAttr('disabled');

            $("#btnEditContactDetails").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnEditContactDetails").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {
            $('#frmEmpContactDetails :input').removeAttr('disabled');

            $("#btnEditContactDetails").attr('value',"<?php echo __("Save"); ?>");
            $("#btnEditContactDetails").attr('title',"<?php echo __("Save"); ?>");
        }
    }

    $(document).ready(function() {
        buttonSecurityCommon(null,null,"btnEditContactDetails",null);
        $("#frmEmpContactDetails").data('edit', '0'); // In view mode
        setContactDetailsAttributes();

        // hide validation error messages
        $("label.errortd[generated='true']").css('display', 'none');

        $("#frmEmpContactDetails").validate({
        
            rules: {
                               
                txtOffAddline1 : {maxlength: 100,noSpecialCharsOnly: true},
                txtOffAddline1SI : {maxlength: 100,noSpecialCharsOnly: true},
                txtOffAddline1TA : {maxlength: 100,noSpecialCharsOnly: true},
                txtOffAddline2: {maxlength: 100,noSpecialCharsOnly: true},
                txtOffAddline2SI: {maxlength: 100,noSpecialCharsOnly: true},
                txtOffAddline2TA: {maxlength: 100,noSpecialCharsOnly: true},
                txtOffPostOffice: {maxlength: 100,noSpecialCharsOnly: true},
                txtOffPostOfficeSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtOffPostOfficeTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtOffPostalCode: {maxlength: 50,noSpecialCharsOnly: true},
                txtOffIntercom: {maxlength: 10,phone:true},
                txtOffVIP: {maxlength: 10, phone: true},
                txtOffDirect: {maxlength: 10, phone: true},
                txtOffExt: {maxlength: 4, phone: true},
                txtOffFax: {maxlength: 10, phone: true},
                txtOffEmail: {maxlength: 60, email: true},
                txtOffURL: {maxlength: 100, url: true},
                        
        
                txtresAddline1 : {maxlength: 100,noSpecialCharsOnly: true},
                txtresAddline1SI : {maxlength: 100,noSpecialCharsOnly: true},
                txtresAddline1TA : {maxlength: 100,noSpecialCharsOnly: true},
                txtresAddline2: {maxlength: 100,noSpecialCharsOnly: true},
                txtresAddline2SI: {maxlength: 100,noSpecialCharsOnly: true},
                txtresAddline2TA: {maxlength: 100,noSpecialCharsOnly: true},
                txtresPostOffice: {maxlength: 100,noSpecialCharsOnly: true},
                txtresPostOfficeSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtresPostOfficeTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtresPostalCode: {maxlength: 50,noSpecialCharsOnly: true},
                txtresDivisiSec: {maxlength: 100,noSpecialCharsOnly: true},
                txtresDivisiSecSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtresDivisiSecTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtresPoliceStaion: {maxlength: 100,noSpecialCharsOnly: true},
                txtresPoliceStaionSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtresPoliceStaionTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtresDistric: {maxlength: 100,noSpecialCharsOnly: true},
                txtresDistricSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtresDistricTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtresPhone: {maxlength: 10, phone: true},
                txtresFax: {maxlength: 10, phone: true},
                txtresMobile: {maxlength: 10, phone: true},
                txtresEmail: {maxlength: 60, email: true},

                txtperAddline1 : {maxlength: 100,noSpecialCharsOnly: true},
                txtperAddline1SI : {maxlength: 100,noSpecialCharsOnly: true},
                txtperAddline1TA : {maxlength: 100,noSpecialCharsOnly: true},
                txtperAddline2: {maxlength: 100,noSpecialCharsOnly: true},
                txtperAddline2SI: {maxlength: 100,noSpecialCharsOnly: true},
                txtperAddline2TA: {maxlength: 100,noSpecialCharsOnly: true},
                txtperPostOffice: {maxlength: 100,noSpecialCharsOnly: true},
                txtperPostOfficeSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtperPostOfficeTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtperPostalCode: {maxlength: 50,noSpecialCharsOnly: true},
                txtperDivisiSec: {maxlength: 100,noSpecialCharsOnly: true},
                txtperDivisiSecSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtperDivisiSecTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtperPoliceStaion: {maxlength: 100,noSpecialCharsOnly: true},
                txtperPoliceStaionSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtperPoliceStaionTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtperDistric: {maxlength: 100,noSpecialCharsOnly: true},
                txtperDistricSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtperDistricTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtperPhone: {maxlength: 10, phone: true},
                txtperFax: {maxlength: 10, phone: true},
                txtperMobile: {maxlength: 10, phone: true},
                txtperEmail: {maxlength: 60, email: true},

                txtothAddline1 : {maxlength: 100,noSpecialCharsOnly: true},
                txtothAddline1SI : {maxlength: 100,noSpecialCharsOnly: true},
                txtothAddline1TA : {maxlength: 100,noSpecialCharsOnly: true},
                txtothAddline2: {maxlength: 100,noSpecialCharsOnly: true},
                txtothAddline2SI: {maxlength: 100,noSpecialCharsOnly: true},
                txtothAddline2TA: {maxlength: 100,noSpecialCharsOnly: true},
                txtothPostOffice: {maxlength: 100,noSpecialCharsOnly: true},
                txtothPostOfficeSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtothPostOfficeTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtothPostalCode: {maxlength: 50,noSpecialCharsOnly: true},
                txtothDivisiSec: {maxlength: 100,noSpecialCharsOnly: true},
                txtothDivisiSecSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtothDivisiSecTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtothPoliceStaion: {maxlength: 100,noSpecialCharsOnly: true},
                txtothPoliceStaionSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtothPoliceStaionTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtothDistric: {maxlength: 100,noSpecialCharsOnly: true},
                txtothDistricSI: {maxlength: 100,noSpecialCharsOnly: true},
                txtothDistricTA: {maxlength: 100,noSpecialCharsOnly: true},
                txtothPhone: {maxlength: 10, phone: true},
                txtothFax: {maxlength: 10, phone: true},
                txtothMobile: {maxlength: 10, phone: true},
                txtothEmail: {maxlength: 60, email: true}
            },
            messages: {
                txtOffAddline1 : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffAddline1SI : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffAddline1TA : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffAddline2: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffAddline2SI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffAddline2TA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffPostOffice: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffPostOfficeSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffPostOfficeTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffPostalCode: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtOffIntercom: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid phone number") ?>"},
                txtOffVIP: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid phone number") ?>" },
                txtOffDirect: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid phone number") ?>"},
                txtOffExt: {maxlength: "<?php echo __("Maximum length should be 4 characters") ?>", phone: "<?php echo __("Invalid Phone Extension") ?>"},
                txtOffFax: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid fax number") ?>"},
                txtOffEmail: {maxlength: "<?php echo __("Maximum length should be 60 characters") ?>", email: "<?php echo __("Invalid E-Mail") ?>"},
                txtOffURL: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>", url: "<?php echo __("Invalid URL") ?>"},

                txtresAddline1 : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresAddline1SI : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresAddline1TA : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresAddline2: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresAddline2SI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresAddline2TA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresPostOffice: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresPostOfficeSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresPostOfficeTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresPostalCode: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresDivisiSec: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresDivisiSecSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresDivisiSecTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresPoliceStaion: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresPoliceStaionSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresPoliceStaionTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresDistric: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresDistricSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresDistricTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtresPhone: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid phone number") ?>"},
                txtresFax: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid fax number") ?>"},
                txtresMobile: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid Mobile No") ?>"},
                txtresEmail: {maxlength: "<?php echo __("Maximum length should be 60 characters") ?>", email: "<?php echo __("Invalid E-Mail") ?>"},
                        
                        
                txtperAddline1 : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperAddline1SI : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperAddline1TA : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperAddline2: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperAddline2SI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperAddline2TA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperPostOffice: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperPostOfficeSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperPostOfficeTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperPostalCode: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperDivisiSec: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperDivisiSecSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperDivisiSecTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperPoliceStaion: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperPoliceStaionSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperPoliceStaionTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperDistric: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperDistricSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperDistricTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtperPhone: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid phone number") ?>"},
                txtperFax: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid fax number") ?>"},
                txtperMobile: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid Mobile No") ?>"},
                txtperEmail: {maxlength: "<?php echo __("Maximum length should be 60 characters") ?>", email: "<?php echo __("Invalid E-Mail") ?>"},


                txtothAddline1 : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothAddline1SI : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothAddline1TA : {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothAddline2: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothAddline2SI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothAddline2TA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothPostOffice: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothPostOfficeSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothPostOfficeTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothPostalCode: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothDivisiSec: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothDivisiSecSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothDivisiSecTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothPoliceStaion: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothPoliceStaionSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothPoliceStaionTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothDistric: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothDistricSI: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothDistricTA: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtothPhone: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid phone number") ?>"},
                txtothFax: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid fax number") ?>"},
                txtothMobile: {maxlength: "<?php echo __("Maximum length should be 10 characters") ?>", phone: "<?php echo __("Invalid Mobile No") ?>"},
                txtothEmail: {maxlength: "<?php echo __("Maximum length should be 60 characters") ?>", email: "<?php echo __("Invalid E-Mail") ?>"}
            },
            errorClass: "errortd",
                   submitHandler: function(form) {
                   $('#btnEditContactDetails').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                   form.submit();
             }
        });

        // Switch edit mode or submit data when edit/save button is clicked
        $("#btnEditContactDetails").click(function() {

            var editMode = $("#frmEmpContactDetails").data('edit');
            if (editMode == 0) {
                lockContactDetails($('#txtEmpID').val());
                return false;
            }
            else {
                $('#frmEmpContactDetails').submit();
            }
        });

        $('#btnResetContactDetails').click(function() {
            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            // 0 - view, 1 - edit, 2 - add
            var editMode = $("#frmEmpContactDetails").data('edit');
            if (editMode == 1) {
                unlockContactDetails($('#txtEmpID').val());
                return false;
            }
            else {
                document.forms['frmEmpContactDetails'].reset('');
            }
        });

    });
    //]]>
</script>

