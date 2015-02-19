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
if (isset($getArr['capturemode']) && $getArr['capturemode'] == 'updatemode') {

    if (isset($postArr['EditMode']) && $postArr['EditMode'] == '1') {
        $editMode = false;
        $disabled = '';
    } else {
        $editMode = true;
        $disabled = 'disabled="disabled"';
    }
}
//if ($currentPane == 2) {
//    include_partial('pim_form_errors', array('sf_user' => $sf_user));
//}
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
<link href="<?php echo public_path('../../themes/orange/css/style.css') ?>" rel="stylesheet" type="text/css"/>
<!--<link href="<?php echo public_path('../../themes/orange/css/message.css') ?>" rel="stylesheet" type="text/css"/>-->
<!--[if lte IE 6]>
<link href="<?php echo public_path('../../themes/orange/css/IE6_style.css') ?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<!--[if IE]>
<link href="<?php echo public_path('../../themes/orange/css/IE_style.css') ?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<script type="text/javascript" src="<?php echo public_path('../../themes/orange/scripts/style.js'); ?>"></script>
<!--<script type="text/javascript" src="<?php echo public_path('../../scripts/archive.js'); ?>"></script>-->

<!--<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.js') ?>"></script>-->
<!--<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.form.js') ?>"></script>-->
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<style>
    label.lbllevel {
        width:50px;
    }
</style>
<?php echo javascript_include_tag('orangehrm.validate.js'); ?>
<!--<script type="text/javascript" src="<?php echo public_path('../../scripts/showhidepane.js'); ?>"></script>-->
<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Job"); ?></h2></div>
        <div id="errMessage">
            <?php echo message(); ?>
        </div>
        <form id="frmEmpJobDetails" method="post" action="<?php echo url_for('pim/jobandSal?empNumber=' . $employee->empNumber); ?>">
            <input type="hidden" name="txtEmpID" value="<?php echo $employee->empNumber; ?>"/>

            <div class="formbuttons">
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
            </div>


            <div class="">

                <div class="leftCol">
                    <label for=""><b><?php echo __("Current Service"); ?></b></label>
                </div>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtAppcuse"><?php echo __("Appointment date to current service"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtAppDateCs" id="txtAppDateCs"
                       value="<?php echo (isset($postArr['txtAppDateCs'])) ? $postArr['txtAppDateCs'] : LocaleUtil::getInstance()->formatDate($employee->emp_app_date); ?>">
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtdad"><?php echo __("Date assumed duty (current)"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtAssumedutyDate"  id="txtAssumedutyDate"
                       value="<?php echo (isset($postArr['txtAssumedutyDate'])) ? $postArr['txtAssumedutyDate'] : LocaleUtil::getInstance()->formatDate($employee->emp_com_date); ?>" maxlength="15" />
            </div>
            <br class="clear"/>
                            <div class="leftCol">
                    <label for="txtEmployeeId" style="width: 130px;"><?php echo __("Appointment Date"); ?><span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input type="text" class="formInputText" name="txtAPS" id="txtAPS" 
                           value="<?php echo (isset($postArr['txtAPS'])) ? $postArr['txtAPS'] : LocaleUtil::getInstance()->formatDate($employee->emp_public_app_date); ?>">
                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtAppLetterNo"><?php echo __("Assumed Date"); ?></label>
                </div>
                <div class="centerCol">
                    <input type="text" class="formInputText" name="txtAssumeDate"  id="txtAssumeDate" 
                           value="<?php echo (isset($postArr['txtAssumeDate'])) ? $postArr['txtAssumeDate'] : LocaleUtil::getInstance()->formatDate($employee->emp_public_com_date); ?>" maxlength="15" />
                </div>
                <br class="clear"/>
            <div class="leftCol">
                <label for="cmbrecMethod"><?php echo __("Method of recruitment to current service"); ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select class="formSelect" id="cmbrecMethod" name="cmbrecMethod">
                    <?php
                    $currentRCU = isset($postArr['cmbrecMethod']) ? $postArr['cmbrecMethod'] : $employee->emp_rec_method;
                    ?>
                    <option value=""><?php echo __("--Select--"); ?></option>
                    <option value="1" <?php if ($currentRCU == 1)
                        echo "selected" ?>><?php echo __("Absorption"); ?></option>
                    <option value="2" <?php if ($currentRCU == 2)
                                echo "selected" ?>><?php echo __("Merit"); ?></option>
                        <option value="3" <?php if ($currentRCU == 3)
                                    echo "selected" ?>><?php echo __("Open"); ?></option>
                            <option value="4" <?php if ($currentRCU == 4)
                                        echo "selected" ?>><?php echo __("Limited"); ?></option>
                             <option value="5" <?php if ($currentRCU == 5)
                                        echo "selected" ?>><?php echo __("Promotion"); ?></option>
                                <option value="6" <?php if ($currentRCU == 6)
                                            echo "selected" ?>><?php echo __("Other"); ?></option>
                                </select>
                            </div>
                            <br class="clear"/>
                            <div class="leftCol">
                                <label for="txtIfother"><?php echo __("If other please specify"); ?></label>
                            </div>
                            <div class="centerCol">
                                <textarea   rows="5" cols="15" name="txtreqResonEn" id="txtreqResonEn"><?php echo isset($postArr['txtreqResonEn']) ? $postArr['txtreqResonEn'] : $employee->emp_rec_method_desc; ?></textarea>

                            </div>
                            <div class="centerCol">
                                <textarea   rows="5" cols="15" name="txtreqSinhala" id="txtreqSinhala"><?php echo isset($postArr['txtreqSinhala']) ? $postArr['txtreqSinhala'] : $employee->emp_rec_method_desc_si; ?></textarea>
                            </div>
                            <div class="centerCol">

                                <textarea    rows="5" cols="15" name="txtreqTamil" id="txtreqTamil"><?php echo isset($postArr['txtreqTamil']) ? $postArr['txtreqTamil'] : $employee->emp_rec_method_desc_ta; ?></textarea>
                            </div>


                            <br class="clear"/>
                            <div class="leftCol">
                                <label for="cmbMedium"><?php echo __("Medium"); ?><span class="required">*</span></label>
                            </div>
                            <div class="centerCol">
                                <select class="formSelect" id="cmbMedium" name="cmbMedium"><span class="required">*</span>
                    <?php
                                            $currentMedium = isset($postArr['cmbMedium']) ? $postArr['cmbMedium'] : $employee->emp_rec_medium;
                    ?>
                                            <option value=""><?php echo __("--Select--"); ?></option>
                                            <option value="1" <?php if ($currentMedium == 1)
                                                echo "selected" ?>><?php echo __("English"); ?></option>
                                        <option value="2" <?php if ($currentMedium == 2)
                                                    echo "selected" ?>><?php echo __("Sinhala"); ?></option>
                                            <option value="3" <?php if ($currentMedium == 3)
                                                        echo "selected" ?>><?php echo __("Tamil"); ?></option>
                                            </select>
                                        </div>
                                        <br class="clear"/>
                                        <div class="leftCol">
                                            <label for="cmbMedium"><?php echo __("Employement Type"); ?><span class="required">*</span></label>
                                        </div>
                                        <div class="centerCol">
                                            <select class="formSelect"  id="cmbEmptype" name="cmbEmptype"><span class="required">*</span>
                                                <option value=""><?php echo __("--Select--"); ?></option>
                    <?php
                                                        //Define data columns according culture

                                                        $empStatusCol = ($userCulture == "en") ? "getName" : "getEstat_name_" . $userCulture;

                                                        if ($empStateList) {
                                                            $currentEmpStatus = isset($postArr['cmbEmptype']) ? $postArr['cmbEmptype'] : $employee->emp_status;
                                                            foreach ($empStateList as $empState) {
                                                                $selected = ($currentEmpStatus == $empState->getEstat_code()) ? 'selected="selected"' : '';
                                                                $empStateName = $empState->$empStatusCol() == "" ? $empState->getName() : $empState->$empStatusCol();
                                                                echo "<option {$selected} value='{$empState->getId()}'>{$empStateName}</option>";
                                                            }
                                                        }
                    ?>

                                                    </select>
                                                </div>
                                                <br class="clear"/>
                                                <div id="wrldiv" >
                                                    <div class="leftCol">
                                                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Work Station")?> <span class="required">*</span></label>
                                                    </div>
                                                    <div class="centerCol" >
                    <?php
                                                        if ($userCulture == "en") {
                                                            $companyCol = 'getTitle';
                                                        } else {
                                                            $companyCol = 'getTitle_' . $userCulture;
                                                        }
                                                        if ($employee->subDivision->$companyCol() == "") {
                                                            $feild = $employee->subDivision->getTitle();
                                                        } else {
                                                            $feild = $employee->subDivision->$companyCol();
                                                        }
                    ?>
                                                        <input type="text" name="txtDivision" id="txtDivision" class="formInputText" value="<?php echo $feild; ?>" readonly="readonly" />
                                                        <input type="hidden" name="txtDivisionid" id="txtDivisionid" value="<?php echo $employee->subDivision->getId(); ?>" />&nbsp;

                                                    </div>
                                                    <label for="txtLocation" style="width: 25px;">
                                                        <input class="button" type="button"  onclick="returnLocDet()" value="..." id="divisionPopBtn"  />
                                                    </label>
                                                    <br class="clear"/>
                                                    <div id="Display1">
                                                    </div>
                                                </div>

                                            <br class="clear"/>
                                                <div id="actwrldiv" >
                                                    <div class="leftCol" style="width: 170px;">
                    <?php
//                                                        $currentAttActive = isset($postArr['chkactivews']) ? $postArr['chkactivews'] : $ActingCompanyStructureLoad;
                    ?>

                                                        <input type="checkbox" name="chkactivews" id="chkactivews" class="formCheckbox" value="1"  style="width: 15px;"/>
                                                        
                                                        <label class="controlLabel" for="txtLocationCode" style="width: 125px; padding-top: 2px;"><?php echo __("Acting Work Station") ?> </label>
                                                    </div>
                                                    <div class="formbuttons">
<!--                                                        <input type="button" class="clearbutton" id="btnAddtogrid"  onclick="Addtogrid();"  value="<?php echo __("Add"); ?>"/>
                                                        <input type="button" class="clearbutton" id="btnRemovegrid"  onclick="Removetogrid();"  value="<?php echo __("Remove"); ?>"/>-->
                                                        <input type="button" class="clearbutton" id="btnViewgrid"  onclick="Viewtogrid();"  value="<?php echo __("View"); ?>"/>
                                                    </div>
                                                        

                                                </div>


                                                <br class="clear"/>
                                                <div class="leftCol">
                                                    <label class="controlLabel" for="txtLocationCode"><?php echo __("HR active employee") ?> </label>
                                                </div>
                                                <div class="centerCol">
                <?php
                                                        $currentHrActive = isset($postArr['chkHractive']) ? $postArr['chkHractive'] : $employee->emp_active_hrm_flg;
                ?>

                                                        <input type="checkbox" name="chkHractive" id="chkHractive" class="formCheckbox" value="1"  />

                                                    </div>
                                                    <br class="clear"/>
                                                    <div class="leftCol">
                                                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Attendance active employee") ?> </label>
                                                    </div>
                                                    <div class="centerCol">
                <?php
                                                        $currentAttActive = isset($postArr['chkAttactive']) ? $postArr['chkAttactive'] : $employee->emp_active_att_flg;
                ?>

                                                        <input type="checkbox" name="chkAttactive" id="chkAttactive" class="formCheckbox" value="1" checked="checked" />

                                                    </div>

                                                    <div id="AttNoDiv">
                                                        <div class="leftCol">
                                                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Attendance No") ?> <span class="required">*</span></label>
                                                        </div>
                                                        <div class="centerCol">

                                                            <input type="text" name="txtAttendNo" id="txtAttendNo" class="formInputText" value="<?php echo (isset($postArr['txtAttendNo'])) ? $postArr['txtAttendNo'] : $employee->emp_attendance_no; ?>" maxlength="15"/>

                                                        </div>
                                                        <br class="clear"/>
                                                    </div>


                                                    <br class="clear"/>
                                                    <div class="leftCol">
                                                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Payroll active employee") ?> </label>
                                                    </div>
                                                    <div class="centerCol">
                <?php
                                                        $currentHrActive = isset($postArr['chkPractive']) ? $postArr['chkPractive'] : $employee->emp_active_pr_flg;
                ?>

                                                        <input type="checkbox" name="chkPractive" id="chkPractive" class="formCheckbox" value="1"  />

                                                    </div>
                                                    <br class="clear"/>
                                                    <div id="WandOP">
                                                        <div class="leftCol">
                                                            <label class="controlLabel" for="txtLocationCode"><?php echo __("If yes W & OP Number") ?></label>
                                                        </div>
                                                        <div class="centerCol">
                                                            <input type="text" name="txtWopnum"id="txtWopnum" class="formInputText" maxlength="20" value="<?php echo (isset($postArr['txtWopnum'])) ? $postArr['txtWopnum'] : $employee->emp_wop_no ?>"  />
                                                        </div>
                                                        <br class="clear"/>
                                                    </div>


                                     <div class="formbuttons">
                                         <div class="leftCol">
                                             <label style="width: 500px;" for="txtLocationCode"><?php echo __("Probation period extension information") ?></label>
                                         </div>
                                         <br class="clear"/>
                                         <div class="leftCol">
                                             <label  for="txtLocationCode"><?php echo __("If Extended? (If relevent)") ?></label>
                                         </div>
                                         <div class="centerCol">

                                             <table style="padding-top:5px;">
                                                 <tr>
                            <?php
                                                                $currentporba = isset($postArr['optExtend']) ? $postArr['optExtend'] : $employee->emp_prob_ext_flg;
                            ?>
                                                                <td>
                                                                    <input type="radio" name="optExtend" id="optExtend1"  value="1" <?php if ($currentporba == 1

                                                                    )echo "checked" ?>/> <?php echo __("Yes") ?>
                                                         </td>
                                                         <td>
                                                             <input type="radio" name="optExtend" id="optExtend2"   value="0" <?php if ($currentporba == 0

                                                                        )echo "checked" ?>/><?php echo __("No") ?>
                                                             </td>
                                                         </tr>
                                                     </table>



                                                 </div>
                                                 <br class="clear"/>
                                                 <div id="probex">
                                                     <div class="leftCol">
                                                         <label  style="width: 500px;"  for="txtLocationCode"><?php echo __("The period the probation was extended") ?></label>
                                                     </div>
                                                     <br class="clear"/>
                                                     <div class="leftCol">
                                                         <label for="txtLocationCode"><?php echo __("From date") ?></label>
                                                     </div>
                                                     <div class="centerCol">
                                                         <input type="text" name="txtPrbextFromdate" id="txtPrbextFromdate" class="formInputText" value="<?php echo isset($postArr['txtPrbextFromdate']) ? $postArr['txtPrbextFromdate'] : LocaleUtil::getInstance()->formatDate($employee->emp_prob_from_date); ?>" />
                                                     </div>
                                                     <div class="centerCol">
                                                         <label for="txtLocationCode"><?php echo __("To date") ?></label>
                                                     </div>
                                                     <div class="centerCol">
                                                         <input type="text" name="txtPrbextTodate"id="txtPrbextTodate" class="formInputText" value="<?php echo isset($postArr['txtPrbextTodate']) ? $postArr['txtPrbextTodate'] : LocaleUtil::getInstance()->formatDate($employee->emp_prob_to_date); ?>" />
                                                     </div>
                                                     <br class="clear"/>
                                                 </div>
                                             </div>
                                                                <div class="formbuttons">
                                                        <div class="leftCol">
                                                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Confirmed") ?></label>
                                                        </div>
                                                        <div class="centerCol">
                                                            <table style="padding-top:5px;">
                                                                <tr>
                            <?php
                                                        $currentConfirm = isset($postArr['optConfirm']) ? $postArr['optConfirm'] : $employee->emp_confirm_flg;
                            ?>
                                                        <td>
                                                            <input type="radio" name="optConfirm" id="optConfirm1"  value="1" <?php if ($currentConfirm == 1

                                                            )echo "checked" ?>/> <?php echo __("Yes") ?>
                                                 </td>
                                                 <td>
                                                     <input type="radio" name="optConfirm" id="optConfirm2"   value="0" <?php if ($currentConfirm == 0

                                                                )echo "checked" ?>/><?php echo __("No") ?>
                                                     </td>
                                                 </tr>
                                             </table>


                                         </div>
                                         <br class="clear"/>
                                         <div id="confirmDIV">
                                             <div class="leftCol">
                                                 <label class="controlLabel" for="txtLocationCode"><?php echo __("Confirmed Date") ?></label>
                                             </div>
                                             <div class="centerCol">
                                                 <input type="text" name="txtConfirmdate"id="txtConfirmdate" class="formInputText" value="<?php echo (isset($postArr['txtConfirmdate'])) ? $postArr['txtConfirmdate'] : LocaleUtil::getInstance()->formatDate($employee->emp_confirm_date) ?>" />
                                             </div>
                                             <br class="clear"/>
                                         </div>

                                         <div class="leftCol">
                                             <label class="controlLabel" for="txtLocationCode"><?php echo __("Suspended date") ?></label>
                                         </div>
                                         <div class="centerCol">
                                             <input type="text" name="txtSuspenddate"id="txtSuspenddate" class="formInputText" value="<?php echo (isset($postArr['txtSuspenddate'])) ? $postArr['txtSuspenddate'] : LocaleUtil::getInstance()->formatDate($employee->terminated_date) ?>" />
                                         </div>
                                         <br class="clear"/>

                                         <div class="leftCol">
                                             <label class="controlLabel" for="txtLocationCode"><?php echo __("Please specify the reason") ?></label>
                                         </div>
                                         <div class="centerCol">
                                             <textarea  rows="5" cols="20" name="txtReasonsuspend" id="txtReasonsuspend"  style="width:325px;"><?php echo (isset($postArr['txtReasonsuspend'])) ? $postArr['txtReasonsuspend'] : $employee->termination_reason ?></textarea>
                                         </div>
                                     </div>
                                     <br class="clear"/>
                                             <div class="formbuttons">
                                                 <label for="txtLocationCode"><b><?php echo __("Salary") ?></b></label>
                                                 <br class="clear"/>
                                                 <div class="leftCol">
                                                     <label for="txtLocationCode"><?php echo __("Service") ?></label>
                                                 </div>
                                                 <div class="centerCol">
                                                     <select class="formSelect"  id="cmbService" name="cmbService">
                                                         <option value=""><?php echo __("--Select--"); ?></option>
                        <?php
                                                                        //Define data columns according culture
                                                                        $ServiceCol = ($userCulture == "en") ? "getService_name" : "getService_name_" . $userCulture;

                                                                        if ($serviceList) {
                                                                            $currentEmpService = isset($postArr['cmbService']) ? $postArr['cmbService'] : $employee->service_code;
                                                                            foreach ($serviceList as $service) {
                                                                                $selected = ($currentEmpService == $service->getService_code()) ? 'selected="selected"' : '';
                                                                                $empServiceName = $service->$ServiceCol() == "" ? $service->getService_name() : $service->$ServiceCol();
                                                                                echo "<option {$selected} value='{$service->getService_code()}'>{$empServiceName}</option>";
                                                                            }
                                                                        }
                        ?>
                                                                    </select>
                                                                </div>
                                                                <br class="clear"/>
                                                                <div class="leftCol">
                                                                    <label for="txtLocationCode"><?php echo __("Designation") ?><span class="required">*</span></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <select class="formSelect"  id="cmbDesignstion" name="cmbDesignstion"><span class="required">*</span>
                                                                        <option value=""><?php echo __("--Select--"); ?></option>
                        <?php
                                                                        //Define data columns according culture
                                                                        $jobTitCol = ($userCulture == "en") ? "getJobtit_name" : "getJobtit_name_" . $userCulture;

                                                                        if ($jobTitleList) {
                                                                            $currentJobtit = isset($postArr['cmbDesignstion']) ? $postArr['cmbDesignstion'] : $employee->job_title_code;

                                                                            foreach ($jobTitleList as $jobtit) {

                                                                                $empjobtitName = $jobtit->$jobTitCol() == "" ? $jobtit->getJobtit_name() : $jobtit->$jobTitCol();
                                                                                echo "<option {$selected1} value='{$jobtit->getJobtit_code()}'>{$empjobtitName}</option>";
                                                                            }
                                                                        }
                        ?>
                                                                    </select>
                                                                </div>
                                                                <br class="clear"/>
                                                                <div class="leftCol">
                                                                    <label for="txtLocationCode"><?php echo __("Class") ?></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <select class="formSelect" id="cmbClass" name="cmbClass">
                                                                        <option value=""><?php echo __("--Select--"); ?></option>
                        <?php
                                                                        //Define data columns according culture
                                                                        $empclassCol = ($userCulture == "en") ? "getClass_name" : "getClass_name_" . $userCulture;

                                                                        if ($empClassList) {
                                                                            $currentempClass = isset($postArr['cmbClass']) ? $postArr['cmbClass'] : $employee->class_code;
                                                                            foreach ($empClassList as $empClass) {
                                                                                $selected = ($currentempClass == $empClass->getClass_code()) ? 'selected="selected"' : '';
                                                                                $empjobtitName = $empClass->$empclassCol() == "" ? $empClass->getClass_name() : $empClass->$empclassCol();
                                                                                echo "<option {$selected} value='{$empClass->getClass_code()}'>{$empjobtitName}</option>";
                                                                            }
                                                                        }
                        ?>
                                                                    </select>
                                                                </div>
                                                                <br class="clear"/>
                                                                <div class="leftCol">
                                                                    <label for="txtLocationCode"><?php echo __("Grade(Segment)") ?><span class="required">*</span></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <select class="formSelect" id="cmbGrade" name="cmbGrade" onchange="LoadGradeSlot(this.value);"><span class="required" >*</span>
                                                                        <option value=""><?php echo __("--Select--"); ?></option>
                        <?php
                                                                        //Define data columns according culture
                                                                        $empGradeCol = ($userCulture == "en") ? "getGrade_name" : "getGrade_name_" . $userCulture;

                                                                        if ($gradeList) {
                                                                            $currentempGrade = isset($postArr['cmbGrade']) ? $postArr['cmbGrade'] : $employee->grade_code;
                                                                            foreach ($gradeList as $empgradeList) {
                                                                                $selected = ($currentempGrade == $empgradeList->getGrade_code()) ? 'selected="selected"' : '';
                                                                                $empGradeName = $empgradeList->$empGradeCol() == "" ? $empgradeList->getGrade_name() : $empgradeList->$empGradeCol();
                                                                                echo "<option {$selected} value='{$empgradeList->getGrade_code()}'>{$empGradeName}</option>";
                                                                            }
                                                                        }
                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="leftCol" style="padding-left: 25px;">
                                                                    <label for="txtLocationCode"><?php echo __("Grade Slot") ?><span class="required">*</span></label>
                                                                </div>
                                                                <div class="centerCol" id="cmbGradeSlotDiv">
                                                                    <select class="formSelect" id="cmbGradeSlot" name="cmbGradeSlot"><span class="required">*</span>
                                                                        <option value=""><?php echo __("--Select--"); ?></option>
                        <?php
                                                                        //Define data columns according culture

                                                                        if ($gradeSlot) {
                                                                            $currentempGrade = isset($postArr['cmbGradeSlot']) ? $postArr['cmbGradeSlot'] : $employee->slt_scale_year;
                                                                            foreach ($gradeSlot as $empgradeSlotList) {
                                                                                $selected = ($currentempGrade == $empgradeSlotList->slt_id) ? 'selected="selected"' : '';
                                                                                echo "<option {$selected} value={$empgradeSlotList->slt_id}>{$empgradeSlotList->slt_scale_year}" . " --> " . "{$empgradeSlotList->emp_basic_salary }</option>";
                                                                            }
                                                                        }
                        ?>
                                                                    </select>
                                                                </div>


                                                                <br class="clear"/>
                                                                <div class="leftCol">
                                                                    <label for="txtLocationCode"><?php echo __("Level") ?><span class="required">*</span></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <select class="formSelect" id="cmbLevel" name="cmbLevel"><span class="required">*</span>
                                                                        <option value=""><?php echo __("--Select--"); ?></option>
                        <?php
                                                                        //Define data columns according culture
                                                                        $empLevelCol = ($userCulture == "en") ? "getLevel_name" : "getLevel_name_" . $userCulture;

                                                                        if ($levelList) {
                                                                            $currentempLevel = isset($postArr['cmbLevel']) ? $postArr['cmbLevel'] : $employee->level_code;
                                                                            foreach ($levelList as $emplevelList) {
                                                                                $selected = ($currentempLevel == $emplevelList->getLevel_code()) ? 'selected="selected"' : '';
                                                                                $empLevelName = $emplevelList->$empLevelCol() == "" ? $emplevelList->getLevel_name() : $emplevelList->$empLevelCol();
                                                                                echo "<option {$selected} value='{$emplevelList->getLevel_code()}'>{$empLevelName}</option>";
                                                                            }
                                                                        }
                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="leftCol" style="padding-left: 25px;">
                                                                    <label for="txtLocationCode"><?php echo __("Retirement Date") ?></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <input type="text" name="txtRetDate" id="txtRetDate" class="formInputText" value="<?php echo isset($postArr['txtRetDate']) ? $postArr['txtRetDate'] : LocaleUtil::getInstance()->formatDate($employee->emp_retirement_date); ?>" />
                                                                </div>
                                                                
                                                                <br class="clear"/>
                                                                <div class="leftCol">
                                                                    <label for="txtLocationCode"><?php echo __("Salary scale") ?></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <input type=text   name="txtsalScale" id="txtsalScale" class="formInputText" maxlength="50" value="<?php echo isset($postArr['txtsalScale']) ? $postArr['txtsalScale'] : $employee->emp_salary_scale; ?>"/>

                                                                </div>
                                                                <div class="leftCol" style="padding-left: 25px;">
                                                                    <label for="txtLocationCode"><?php echo __("Resign Date") ?></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <input type="text" name="txtResDate" id="txtResDate" class="formInputText" value="<?php echo isset($postArr['txtResDate']) ? $postArr['txtResDate'] : LocaleUtil::getInstance()->formatDate($employee->emp_resign_date); ?>" />
                                                                    
                                                                </div>
                                                                <br class="clear"/>
                                                                <div class="leftCol">
                                                                    <label for="txtLocationCode"><?php echo __("Basic salary(Annual)") ?></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <input type="text" name="txtBasicsal"id="txtBasicsal" class="formInputText" maxlength="10" value="<?php echo isset($postArr['txtBasicsal']) ? $postArr['txtBasicsal'] : $employee->emp_basic_salary; ?>" />
                                                                </div>
                                                                
                                                                <div class="leftCol" style="padding-left: 25px;">
                                                                    <label for="txtLocationCode"><?php echo __("Increment Date") ?></label>
                                                                </div>
                                                                <div class="centerCol">
                                                                    <input type="text" name="txtIncrment" id="txtIncrment" class="formInputText" value="<?php echo isset($postArr['txtIncrment']) ? $postArr['txtIncrment'] : LocaleUtil::getInstance()->formatDate($employee->emp_salary_inc_date); ?>" />
                                                                    <input type="hidden" name="txtDOB" id="txtDOB" value="<?php echo $employee->emp_birthday; ?>" />
                                                                    <input type="hidden" name="Actworkstaions" id="Actworkstaions" value="" />
                                                                </div>
                                                                <br class="clear"/>
                                                                
                                                            </div>       <br class="clear"/>
                                                            <div class="formbuttons">
                                                                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="btnEditJobDetails"
                                                                       value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                                                                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                                                                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                                                       />
                                                                <input type="reset" class="clearbutton" id="btnResetJobSalDetails" tabindex="5"
                                                                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                                                       value="<?php echo __("Reset"); ?>"/>
                                                            </div>


                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
                                                <script type="text/javascript">
                                                    var workstation=0;
                                                    var display=0;
                                                    var myflag=0;
                                                    //<![CDATA[

<?php
                                                                        $sysConf = OrangeConfig::getInstance()->getSysConf();
                                                                        $dateHint = $sysConf->getDateInputHint();
                                                                        $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
                                                    function Viewtogrid(){
                                                       var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/ActingWorkStation?emp='.$employee->empNumber);?>','Locations','height=450,resizable=1,scrollbars=1');
                                                        if(!popup.opener) popup.opener=self; 
                                                    }
                                                    
                                                    function Addtogrid(){
                                                    
                                                    var id=workstation+1;    
                                                    
                                                    var Divhtml="";
                                                        
                                                    Divhtml+="<div id='Actdivision"+id+"' style='border-style: solid'>";   
                                                    Divhtml+="<div class='leftCol'>";
                                                    Divhtml+="<label class='controlLabel' for='txtLocationCode' style='width: 125px; padding-top: 2px;'><?php echo __("Acting Work Station ") ?>"+id+"</label></div>";                                                      
                                                    Divhtml+="<div class='centerCol' style='width: 160px;'>";
                                                    Divhtml+="<?php  
                                                    if ($userCulture == "en") {
                                                                                    $ActcompanyCol = 'getTitle';
                                                                               } else {
                                                                                    $ActcompanyCol = 'getTitle_' . $userCulture;
                                                                               }
                                                                               if ($employee->actsubDivision->$ActcompanyCol() == "") {
                                                                                    $Actfeild = $employee->actsubDivision->getTitle();
                                                                               } else {
                                                                                    $Actfeild = $employee->actsubDivision->$ActcompanyCol();
                                                                              }
                                                                        ?>";
                                                    Divhtml+="<input style='margin-left: 0px; width: 150px;' type='text' name='txtActDivision"+id+"' id='txtActDivision"+id+"' class='formInputText' value='<?php echo $Actfeild; ?>' readonly='readonly' />";
                                                    Divhtml+="<input type='hidden' name='txtActDivisionid"+id+"' id='txtActDivisionid"+id+"' value='<?php echo $employee->actsubDivision->getId(); ?>'/>&nbsp;</div>";
                                                    Divhtml+="<label for='txtLocation' style='width: 25px;'><input class='button' type='button' onclick='returnActLocDet("+id+")' value='...' id='ActdivisionPopBtn"+id+"'  /></label>";
                                                    Divhtml+="<div class='leftCol' style='padding-left: 25px;'><label for='txtLocationCode'><?php echo __("Acting Designation ") ?>"+id+"</label></div>";
                                                    Divhtml+="<div class='centerCol'><select class='formSelect'  id='cmbActDesignstion"+id+"' name='cmbActDesignstion"+id+"'><span class='required'>*</span>";
                                                    Divhtml+="<option value=''><?php echo __("--Select--"); ?></option>";
                                                    Divhtml+="<?php   
                                                                    $ActjobTitCol = ($userCulture == "en") ? "getJobtit_name" : "getJobtit_name_" . $userCulture;
                                                                    if ($ActjobTitleList) {
                                                                        $ActcurrentJobtit = isset($postArr['cmbActDesignstion']) ? $postArr['cmbActDesignstion'] : $employee->act_job_title_code;
                                                                    foreach ($ActjobTitleList as $Actjobtit) {
                                                                         $ActempjobtitName = $Actjobtit->$ActjobTitCol() == "" ? $Actjobtit->getJobtit_name() : $Actjobtit->$ActjobTitCol();
                                                                  echo "<option {$selected1} value='{$Actjobtit->getJobtit_code()}'>{$ActempjobtitName}</option>";
                                                                      }
                                                                       }
                                                                     ?>";
                                                    Divhtml+="</select></div>";
                                                    Divhtml+="<br class='clear'/>";
                                                    Divhtml+="<div id='ActDisplay"+id+"'></div></div>";
                                                        $("#ActdivisionMainDiv").append(Divhtml);
                                                        
                                                     workstation++;   
                                                    }
                                                    function Removetogrid(){
                                                        var id=workstation;
                                                        $("#Actdivision"+id).remove();
                                                        workstation--;
                                                    }
                                                    
                                                    function LoadGradeSlot(id){

                                                        $.ajax({
                                                            type: "POST",
                                                            async:false,
                                                            url: "<?php echo url_for('pim/LoadGradeSlot') ?>",
                                                            data: { id: id },
                                                            dataType: "json",
                                                             success: function(data){

                                                                     var selectbox="<select class='formSelect' id='cmbGradeSlot' name='cmbGradeSlot'><option value='-1'>"+"<?php echo __('--Select--'); ?>"+"</option>";
                                                            $.each(data, function(key, value) {
                                                                var word=value.split("|");
                                                                selectbox=selectbox +"<option value='"+word[4]+"'>"+word[1]+" -- "+word[3]+"</option>";
                                                            });
                                                            selectbox=selectbox +"</select>";//alert(selectbox);

                                                           $('#cmbGradeSlotDiv').html(selectbox);
                                                              }
                                                        });
                                                        }



                                                    function DisplayEmpHirache(wst,div){
                                                        $('#'+div).val("");
                                                        var wst;
                                                        $.ajax({
                                                            type: "POST",
                                                            async:false,
                                                            url: "<?php echo url_for('pim/DisplayEmpHirache') ?>",
                                                            data: { wst: wst },
                                                            dataType: "json",
                                                            success: function(data){
                                                                var row="<table style='background-color:#FAF8CC; width:375px; boder:1'>";
                                                                var temp=0;
                                                                if(data.name10 !=null){
                                                                    row+="<tr ><td style='width:300px'>"+data.nameLevel10+"-"+data.name10+"</td></tr>";
                                                                    temp=1;}
                                                                if(data.name9 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel9+"</label>-&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name9+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name8 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel8+"</label>-&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name8+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name7 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel7+"</label>-&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name7+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name6 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel6+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name6+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name5 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel5+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name5+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name4 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel4+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name4+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name3 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel3+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name3+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name2 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel2+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name2+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name1 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel1+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name1+"</td></tr>";
                                                                    temp=1;
                                                                }

                                                                row+="</table>";
                                                                $('#'+div).html(row);
                                                            }
                                                        });



                                                    }

                                                    function getJobSalarydetails(empNumber){

                                                        $.post("<?php echo url_for('pim/GetJobSalDetailsById') ?>",
                                                        { empNumber: empNumber },
                                                        function(data){
                                                            if(data==null){
                                                            }else{
                                                                setJobSalData(data);
                                                            }

                                                        },
                                                        "json"
                                                    );
                                                    }

                                                    function isAttNoExist(){

                                                        var attendNo=$("#txtAttendNo").val();
                                                        if(attendNo!=""){
                                                            $.post("<?php echo url_for('pim/IsAttNoExist') ?>",
                                                            { attendNo: attendNo,empNum:"<?php echo $employee->empNumber ?>" },
                                                            function(data){
                                                                if(data!=null){
                                                                    if(data.count>0){
                                                                        alert("<?php echo __("Attendence No can not be duplicated") ?>");
                                                                    }
                                                                    else{
                                                                        $("#frmEmpJobDetails").submit();
                                                                    }

                                                                }

                                                            },
                                                            "json"
                                                        );
                                                        }
                                                        else{
                                                            $("#frmEmpJobDetails").submit();
                                                        }
                                                    }


                                                    function onSubmitValidaiton(){






                                                        var message="";

                                                        if ($("input[name='optConfirm']:checked").val() == '1')   {

                                                            if($('#txtConfirmdate').val()==""){
                                                                return "1";
                                                            }


                                                        }
                                                        if($("input[name='optExtend']:checked").val() == '1'){
                                                            if($('#txtPrbextFromdate').val()==""){

                                                                return "2";
                                                            }else if($('#txtPrbextTodate').val()==""){

                                                                return "3";
                                                            }


                                                        }

                                                        if ($("input[name='optWOP']:checked").val() == '1')   {

                                                            if($('#txtWopnum').val()==""){
                                                                //return "Please Enter W & OP Number";
                                                                return "4";
                                                            }

                                                        }
                                                        if ($('#chkAttactive').attr("checked")) {
                                                            if($('#txtAttendNo').val()==""){

                                                                return "5";
                                                            }

                                                        }



                                                        return "6";



                                                    }
                                                    function lockJobSalDetails(empNumber){
                                                        $.post("<?php echo url_for('pim/LockJobSalDetails') ?>",
                                                        { empNumber: empNumber },
                                                        function(data){
                                                            if (data.recordLocked==true) {
                                                                getJobSalarydetails(empNumber);
                                                                $("#frmEmpJobDetails").data('edit', '1'); // In edit mode
                                                                setJobSalAttributes();
                                                            }else {
                                                                alert("<?php echo __("Record Locked.") ?>");
                                                            }
                                                        },
                                                        "json"
                                                    );
                                                    }
                                                    function unlockJobSalDetails(empNumber){
                                                        $.post("<?php echo url_for('pim/UnLockJobSalDetails') ?>",
                                                        { empNumber: empNumber },
                                                        function(data){
                                                            getJobSalarydetails(empNumber);
                                                            $("#frmEmpJobDetails").data('edit', '0'); // In view mode
                                                            setJobSalAttributes();
                                                        },
                                                        "json"
                                                    );
                                                    }


                                                    function setJobSalData(data){


                                                        $("#txtEmpID").val(data.empNumber);
                                                        $("#txtAPS").val(data.emp_public_app_date);
                                                        $("#txtAssumeDate").val(data.emp_public_com_date);
                                                        $("#txtAppDateCs").val(data.emp_app_date);
                                                        $("#txtAssumedutyDate").val(data.emp_com_date);
                                                        $("#cmbrecMethod").val((data.emp_rec_method==null) ? '' : data.emp_rec_method);
                                                        $("#txtreqResonEn").val((data.emp_rec_method_desc==null) ? '' : data.emp_rec_method_desc);
                                                        $("#txtreqSinhala").val((data.emp_rec_method_desc_si==null)? '' :data.emp_rec_method_desc_si);
                                                        $("#txtreqTamil").val((data.emp_rec_method_desc_ta==null)? '' :data.emp_rec_method_desc_ta) ;
                                                        $("#cmbMedium").val((data.emp_rec_medium==null) ? '' : data.emp_rec_medium);
                                                        $("#cmbEmptype").val((data.emp_status==null) ? '' : data.emp_status);
                                                        $("#txtDivisionid").val((data.work_station==null) ? '' :data.work_station);
                                                        $("#txtDivision").val((data.workstaion_name==null)?'':data.workstaion_name);
                                                        $("#txtWopnum").val((data.emp_wop_no==null)?'':data.emp_wop_no);
                                                        $("#txtConfirmdate").val(data.emp_confirm_date);
                                                        $("#txtSuspenddate").val(data.terminated_date);
                                                        $("#txtConfirmdate").val(data.emp_confirm_date);
                                                        $("#txtReasonsuspend").val((data.termination_reason==null)? '':data.termination_reason);
                                                        $("#txtPrbextFromdate").val(data.emp_prob_from_date);
                                                        $("#txtPrbextTodate").val(data.emp_prob_to_date);
                                                        $("#cmbService option[value='"+data.service_code+"']").attr("selected", "selected");
                                                        $("#cmbDesignstion option[value='"+data.job_title_code+"']").attr("selected", "selected");
                                                        $("#cmbActDesignstion option[value='"+data.act_job_title_code+"']").attr("selected", "selected");
                                                        $("#cmbClass option[value='"+data.class_code+"']").attr("selected", "selected");
                                                        $("#cmbGrade option[value='"+data.grade_code+"']").attr("selected", "selected");
                                                        $("#cmbGradeSlot option[value='"+data.slt_scale_year+"']").attr("selected", "selected");
                                                        $("#cmbLevel option[value='"+data.level_code+"']").attr("selected", "selected");
                                                        $("#txtsalScale").val((data.emp_salary_scale==null)? '':data.emp_salary_scale);
                                                        $("#txtBasicsal").val((data.emp_basic_salary==null)? '' :data.emp_basic_salary);
                                                        $("#txtIncrment").val(data.emp_salary_inc_date);
                                                        $("#txtRetDate").val((data.emp_retirement_date==null)? '<?php echo $Retdate; ?>' :data.emp_retirement_date);
                                                        $("#txtResDate").val((data.emp_resign_date==null)? '' :data.emp_resign_date);
                                                        
                                                        if (data.emp_active_hrm_flg==1) {

                                                            $('#chkHractive').attr('checked', 'checked');

                                                        } else {
                                                            $('#chkHractive').removeAttr('checked');

                                                        }
                                                        if (data.emp_active_pr_flg==1) {

                                                            $('#chkPractive').attr('checked', 'checked');

                                                        } else {
                                                            $('#chkPractive').removeAttr('checked');

                                                        }
                                                       
                                                        if (data.emp_active_att_flg==1 || data.emp_active_att_flg==null) {

                                                            $('#chkAttactive').attr('checked', 'checked');
                                                            $('#AttNoDiv').show();

                                                        } else {
                                                            $('#chkAttactive').removeAttr('checked');

                                                            $('#AttNoDiv').hide();

                                                        }
                                                        if (data.act_work_station!=null) {
                                                            workstation=1;
                                                            $('#chkactivews').attr('checked', 'checked');
                                                            $('#ActdivisionMainDiv').show();


                                                        } else {
                                                            workstation=0;
                                                            $('#chkactivews').removeAttr('checked');

                                                            $('#ActdivisionMainDiv').hide();


                                                        }
                                                        if (data.emp_wop_flg==1) {
                                                            $('#optWOP1').attr('checked', 'checked');

                                                            $('#WandOP').show();
                                                        } else {
                                                            $('#optWOP2').attr('checked', 'checked');
                                                            $('#WandOP').hide();
                                                        }
                                                        if (data.emp_confirm_flg==1) {
                                                            $('#optConfirm1').attr('checked', 'checked');
                                                            $('#confirmDIV').show();
                                                        } else {
                                                            $('#optConfirm2').attr('checked', 'checked');
                                                            $('#confirmDIV').hide();
                                                        }
                                                        if (data.emp_prob_ext_flg==1) {
                                                            $('#optExtend1').attr('checked', 'checked');

                                                            $('#probex').show();
                                                        } else {

                                                            $('#optExtend2').attr('checked', 'checked');
                                                            $('#probex').hide();
                                                        }
                                                        $("#txtAttendNo").val(data.emp_attendance_no);


                                                    }
                                                    function setJobSalAttributes() {

                                                        var editMode = $("#frmEmpJobDetails").data('edit');

                                                        if (editMode == 0) {
                                                            $('#frmEmpJobDetails :input').attr('disabled','disabled');

                                                            $('#btnEditJobDetails').removeAttr('disabled');


                                                            $("#btnEditJobDetails").attr('value',"<?php echo __("Edit"); ?>");
                                                            $("#btnEditJobDetails").attr('title',"<?php echo __("Edit"); ?>");

                                                        }
                                                        else {

                                                            $('#frmEmpJobDetails :input').removeAttr('disabled');

                                                            $("#btnEditJobDetails").attr('value',"<?php echo __("Save"); ?>");
                                                            $("#btnEditJobDetails").attr('title',"<?php echo __("Save"); ?>");

                                                        }
                                                    }

                                                    function returnLocDet(){

                                                        // TODO: Point to converted location popup
                                                        var popup=window.open('<?php echo public_path('../../symfony/web/index.php/admin/listCompanyStructure?mode=select_subunit&method=mymethod'); ?>','Locations','height=300,width=400,resizable=1,scrollbars=1');
                                                        if(!popup.opener) popup.opener=self;
                                                    }
                                                    function mymethod(id,name){

                                                        $("#txtDivisionid").val(id);
                                                        $("#txtDivision").val(name);
                                                        DisplayEmpHirache(id,"Display1");
                                                    }

                                                    function returnActLocDet(id){
                                                        display=id;
                                                        // TODO: Point to converted location popup
                                                        var Actpopup=window.open('<?php echo public_path('../../symfony/web/index.php/admin/listCompanyStructure?mode=select_subunit&method=Actmymethod'); ?>','Locations','height=450,resizable=1,scrollbars=1');
                                                        if(!Actpopup.opener) Actpopup.opener=self;
                                                    }

                                                    $(document).ready(function() {

                                                        $("#chkactivews").hide();

                                                        buttonSecurityCommon(null,null,"btnEditJobDetails",null);
                                                        if($("#txtDivisionid").val()!=""){
                                                            DisplayEmpHirache($("#txtDivisionid").val(),"Display1");
                                                        }
                                                        <?php if($ActingCompanyStructureLoad!=null){ ?>
                                                               
                                                            $("#chkactivews").attr('checked', true);

                                                        <?php } ?>
                                                        $("#txtAPS").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtAssumeDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtAppDateCs").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtAssumedutyDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtConfirmdate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtSuspenddate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtPrbextFromdate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtPrbextTodate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtIncrment").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtResDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#txtRetDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
                                                        $("#frmEmpJobDetails").data('edit', '0'); // In view mode
                                                        setJobSalAttributes();

                                                        // hide validation error messages
                                                        $("label.errortd[generated='true']").css('display', 'none');


                                                        getJobSalarydetails("<?php echo $employee->empNumber ?>");

                                                        $('#btnResetJobSalDetails').click(function() {
                                                            // hide validation error messages
                                                            $("label.errortd[generated='true']").css('display', 'none');

                                                            // 0 - view, 1 - edit, 2 - add
                                                            var editMode = $("#frmEmpJobDetails").data('edit');
                                                            if (editMode == 1) {
                                                                unlockJobSalDetails("<?php echo $employee->empNumber ?>");
                                                                return false;
                                                            }
                                                            else {
                                                                document.forms['frmEmpJobDetails'].reset('');
                                                            }
                                                        });
                                                        var myFlag=0;


                                                        // Switch edit mode or submit data when edit/save button is clicked
                                                        $("#btnEditJobDetails").click(function() {
                                                            var editMode = $("#frmEmpJobDetails").data('edit');

                                                            if (editMode == 0) {
                                                                lockJobSalDetails("<?php echo $employee->empNumber ?>");
                                                                return false;
                                                            }
                                                            else {
                                                                    $("#Actworkstaions").val(workstation);
                                                                switch(onSubmitValidaiton()){
                                                                    case "1":
                                                                        alert("<?php echo __("Please Enter Confirmed Date") ?>");
                                                                        break;
                                                                    case "2":
                                                                        alert("<?php echo __("Please Enter Probation Extend From Date") ?>");
                                                                        break;
                                                                    case "3":
                                                                        alert("<?php echo __("Please Enter Probation Extend To date") ?>");
                                                                        break;
                                                                    case "4":
                                                                        alert("<?php echo __("Please Enter W & OP Number") ?>");
                                                                        break;
                                                                    case "5":
                                                                        alert("<?php echo __("Attendance No Can not be Blank") ?>");
                                                                        break;
                                                                    case "6":
                                                                        isAttNoExist();

                                                                        break;

                                                                    default:
                                                                        isAttNoExist();

                                                                    }

                                                                }
                                                            });

                                                            $("input[name='optExtend']").change(function(){
                                                                if ($("input[name='optExtend']:checked").val() == '1')   {
                                                                    $('#probex').show();
                                                                }
                                                                else{
                                                                    $('#probex').hide();
                                                                    $('#txtPrbextFromdate').val("");
                                                                    $('#txtPrbextTodate').val("");

                                                                }

                                                            });
                                                            $("input[name='optConfirm']").change(function(){
                                                                if ($("input[name='optConfirm']:checked").val() == '1')   {
                                                                    $('#confirmDIV').show();

                                                                }
                                                                else{

                                                                    $('#txtConfirmdate').val("");
                                                                    $('#confirmDIV').hide();
                                                                }

                                                            });

                                                            $("input[name='optWOP']").change(function(){
                                                                if ($("input[name='optWOP']:checked").val() == '1')   {
                                                                    $('input#txtWopnum').removeAttr('readonly');
                                                                    $('#WandOP').show();
                                                                }
                                                                else{
                                                                    $('#WandOP').hide();
                                                                    $('#txtWopnum').val("");

                                                                }

                                                            });

                                                            $("input[name='chkAttactive']").change(function(){
                                                                if ($(this).attr("checked")) {
                                                                    $('#AttNoDiv').show();

                                                                }
                                                                else{
                                                                    $('#AttNoDiv').hide();
                                                                    $('input#txtAttendNo').val("");

                                                                }

                                                            });


                                                            $("input[name='chkactivews']").change(function(){
                                                                if ($(this).attr("checked")) {
                                                                    $('#ActdivisionMainDiv').show();
                                                                    $('#txtActDivision').show();
                                                                    $('#Display2').show();

                                                                }
                                                                else{
                                                                    $('#ActdivisionMainDiv').hide();
                                                                    $('#txtActDivision').hide();
                                                                    $('#Display2').hide();
                                                                    


                                                                }

                                                            });

                                                        jQuery.validator.addMethod("DOB",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var pubService = strToDate($('#txtAPS').val(), format)
                                                                var DOB = strToDate($('#txtDOB').val(), format);
                                                                if (pubService && DOB && (pubService < DOB)) {
                                                                    return false;
                                                                }

                                                                return true;
                                                            }, ""
                                                        );

                                                            jQuery.validator.addMethod("workPublicserviceDate",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var pubService = strToDate($('#txtAPS').val(), format)
                                                                var dateAssume = strToDate($('#txtAssumeDate').val(), format);
                    
                                                                if (pubService && dateAssume && (pubService > dateAssume)) {                                                                   
                                                                    return false;
                                                                }
                                                                return true;
                                                            }, ""
                                                        );
                                                            jQuery.validator.addMethod("workAppointmentDate",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var txtAppDateCs = strToDate($('#txtAppDateCs').val(), format)
                                                                var dateAssume = strToDate($('#txtAPS').val(), format);

                                                                if (txtAppDateCs && dateAssume && (dateAssume > txtAppDateCs)) {
                                                                    return false;
                                                                }
                                                                return true;
                                                            }, ""
                                                        );
                                                            jQuery.validator.addMethod("dateassumeDuty",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var txtAppDateCs = strToDate($('#txtAppDateCs').val(), format)
                                                                var txtAssumedutyDate = strToDate($('#txtAssumedutyDate').val(), format);

                                                                if (txtAppDateCs && txtAssumedutyDate && (txtAppDateCs >  txtAssumedutyDate)) {
                                                                    return false;
                                                                }
                                                                return true;
                                                            }, ""
                                                        );                          
                                                            jQuery.validator.addMethod("confirmdate",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var txtConfirmdate = strToDate($('#txtConfirmdate').val(), format)
                                                                var txtAssumedutyDate = strToDate($('#txtAssumedutyDate').val(), format);

                                                                if (txtConfirmdate && txtAssumedutyDate && (txtAssumedutyDate > txtConfirmdate )) {
                                                                    return false;
                                                                }
                                                                return true;
                                                            }, ""
                                                        );
                                                            jQuery.validator.addMethod("suspenddate",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var txtConfirmdate = strToDate($('#txtConfirmdate').val(), format)
                                                                var txtSuspenddate = strToDate($('#txtSuspenddate').val(), format);

                                                                if (txtConfirmdate && txtSuspenddate && (txtConfirmdate > txtSuspenddate)) {
                                                                    return false;
                                                                }
                                                                return true;
                                                            }, ""
                                                        );
                                                            jQuery.validator.addMethod("probationfromdate",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var txtAssumedutyDate = strToDate($('#txtAssumedutyDate').val(), format)
                                                                var txtPrbextFromdate = strToDate($('#txtPrbextFromdate').val(), format);

                                                                if (txtAssumedutyDate && txtPrbextFromdate && (txtAssumedutyDate > txtPrbextFromdate)) {
                                                                    return false;
                                                                }
                                                                return true;
                                                            }, ""
                                                        );
                                                            jQuery.validator.addMethod("probationtodate",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var txtPrbextTodate = strToDate($('#txtPrbextTodate').val(), format)
                                                                var txtPrbextFromdate = strToDate($('#txtPrbextFromdate').val(), format);
                                                                if (txtPrbextTodate && txtPrbextFromdate && ( txtPrbextFromdate >= txtPrbextTodate)) {
                                                                    return false;
                                                                }
                                                                return true;
                                                            }, ""
                                                        );
                                                            jQuery.validator.addMethod("increment",
                                                            function(value, element) {

                                                                var hint = '<?php echo $dateHint; ?>';
                                                                var format = '<?php echo $format; ?>';
                                                                var txtIncrment = strToDate($('#txtIncrment').val(), format)
                                                                var txtAssumedutyDate = strToDate($('#txtAssumedutyDate').val(), format);
                                                                if (txtIncrment && txtAssumedutyDate && ( txtAssumedutyDate >= txtIncrment)) {
                                                                    return false;
                                                                }
                                                                return true;
                                                            }, ""
                                                        );


                                                            $("#frmEmpJobDetails").validate({
                                                                rules: {
                                                                    txtEmpID: { required: true, noSpecialCharsOnly: true },
                                                                    txtAPS: { required: true, orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']} , DOB:true },
                                                                    txtAssumeDate: { orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']},workPublicserviceDate:true },
                                                                    txtAppDateCs: { orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, required:true},
                                                                    txtAssumedutyDate: { orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, required:true ,dateassumeDuty:true  },
                                                                    cmbrecMethod: { required: true },
                                                                    txtreqResonEn: { maxlength: 100, noSpecialCharsOnly: true },
                                                                    txtreqSinhala: { maxlength: 100, noSpecialCharsOnly: true },
                                                                    txtreqTamil:{maxlength: 100, noSpecialCharsOnly: true},
                                                                    cmbMedium:{ required: true },
                                                                    cmbEmptype:{ required: true },
                                                                    txtDivisionid:{ required: true },
                                                                    txtConfirmdate: { orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']},confirmdate:true },
                                                                    txtSuspenddate: { orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']},suspenddate:true },
                                                                    txtPrbextFromdate: { orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']},probationfromdate:true },
                                                                    txtPrbextTodate: { orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']},probationtodate:true },
                                                                    cmbDesignstion:{ required: true },
                                                                    cmbGrade:{ required: true },
                                                                    cmbGradeSlot:{ required: true },
                                                                    cmbLevel:{ required: true },
                                                                    txtReasonsuspend:{ maxlength: 200, noSpecialCharsOnly: true },
                                                                    txtsalScale:{ maxlength: 50 },
                                                                    txtBasicsal:{number: true,maxlength:10,noSpecialCharsOnly:true },
                                                                    txtIncrment:{ orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']},increment:true },
                                                                    txtRetDate:{ orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']} },
                                                                    txtResDate:{ orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']} },
                                                                    txtWopnum:{ maxlength: 10, noSpecialCharsOnly: true }
                                                                },
                                                                messages: {
                                                                    txtEmpID: {required: "<?php echo __('This field is required.') ?>", noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                                                                    txtAPS : { required: "<?php echo __('This field is required.') ?>", orange_date: '<?php echo __("Invalid date."); ?>',                                                                        
                                                                    DOB : '<?php echo __("Appointment date to public service should be greater than to date of birth.") ?>'},
                                                                    txtAssumeDate : {orange_date: '<?php echo __("Invalid date."); ?>',
                                                                        workPublicserviceDate: '<?php echo __("Date assumed Duty  date should be greater than or Equal to the Appointment date to public service"); ?>'},                                                                  
                                                                    txtAppDateCs : {orange_date: '<?php echo __("Invalid date."); ?>',
                                                                        required: '<?php echo __("This field is required.") ?>'},                                                                        
                                                                    txtAssumedutyDate : {orange_date: '<?php echo __("Invalid date."); ?>',
                                                                        required: '<?php echo __("This field is required.") ?>',                                                                        
                                                                        dateassumeDuty: '<?php echo __("Date assumed duty (current) date should be greater than to the Appointment date to current service date.") ?>'},
                                                                    cmbrecMethod: { required: "<?php echo __('This field is required.') ?>" },
                                                                    txtreqResonEn: { maxlength: "<?php echo __('Maximum length should be 100 characters') ?>",noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>" },
                                                                    txtreqSinhala: { maxlength: "<?php echo __('Maximum length should be 100 characters') ?>", noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>" },
                                                                    txtreqTamil: { maxlength: "<?php echo __('Maximum length should be 100 characters') ?>", noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>" },
                                                                    cmbMedium:{ required: "<?php echo __('This field is required.') ?>" },
                                                                    cmbEmptype:{ required: "<?php echo __('This field is required.') ?>" },
                                                                    txtDivisionid:{ required: "<?php echo __('This field is required.') ?>" },
                                                                    txtConfirmdate : {orange_date: '<?php echo __("Invalid date."); ?>',
                                                                        confirmdate: '<?php echo __("Confirmed Date should be greater than or equal to the Date assumed duty(current).") ?>'},
                                                                    txtSuspenddate : {orange_date: '<?php echo __("Invalid date."); ?>',
                                                                        suspenddate: '<?php echo __("Suspended Date should be greater than or equal to the Confirmed Date.") ?>'},
                                                                    txtPrbextFromdate: {orange_date: '<?php echo __("Invalid date."); ?>',
                                                                        probationfromdate: '<?php echo __("Probation from date  should be greater than or equal to the Date assumed duty(current).") ?>'},
                                                                    txtPrbextTodate: {orange_date: '<?php echo __("Invalid date."); ?>',
                                                                        probationtodate: '<?php echo __("Probation To date  should be greater than  to the Probation From Date.") ?>'},
                                                                    cmbDesignstion: { required: "<?php echo __('This field is required.') ?>" },
                                                                    cmbGrade:{ required: "<?php echo __('This field is required.') ?>" },
                                                                    cmbGradeSlot:{ required: "<?php echo __('This field is required.') ?>" },
                                                                    cmbLevel:{ required: "<?php echo __('This field is required.') ?>" },
                                                                    txtReasonsuspend:{ maxlength: "<?php echo __('Maximum length should be 200 characters') ?>",noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>" },
                                                                    txtsalScale:{ maxlength: "<?php echo __('Maximum length should be 50 characters') ?>" },
                                                                    txtBasicsal:{number:"<?php echo __("Invalid Value") ?>",maxlength: "<?php echo __("Maximum length should be 10 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                                                    txtIncrment : { orange_date: '<?php echo __("Invalid date."); ?>',increment:"<?php echo __("Increment Date should be greater than to the Date assumed duty(current) Date"); ?>"},
                                                                    txtRetDate : { orange_date: '<?php echo __("Invalid date."); ?>'},
                                                                    txtResDate : { orange_date: '<?php echo __("Invalid date."); ?>'},
                                                                    txtWopnum:{ maxlength: "<?php echo __('Maximum length should be 10 characters') ?>",noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>" }
                                                                },
                                                                errorClass: "errortd",
                                                                     submitHandler: function(form) {
                                                                     $('#btnEditJobDetails').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                                                                     form.submit();
                     }
                                                            });




        });
        //    });
</script>