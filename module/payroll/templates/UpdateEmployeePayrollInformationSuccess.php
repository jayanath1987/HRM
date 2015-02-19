<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
    $encrypt = new EncryptionHandler();

    require_once '../../lib/common/LocaleUtil.php';
    $sysConf = OrangeConfig::getInstance()->getSysConf();
    $sysConf = new sysConf();
    $inputDate = $sysConf->dateInputHint;
    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());

        
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">
        <style type="text/css">
        div.formpage4col input[type="text"]{
            width: 140px;
        }
        </style>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Employee Payroll Information") ?></h2></div>
            <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div style="float: left">
            <div class="leftCol">
                &nbsp;
            </div>

<br class="clear"/>     <input id="txtEMP"  name="txtEMP" type="hidden"  value="<?php echo $Employee->empNumber; ?>" />
                                    <div class="leftCol">
                                        <label for="txtLocationCode"><?php echo __("Grade(Segment)") ?><span class="required">*</span></label>
                                    </div>
                                <div class="centerCol"  >
                                    <select name="cmbGrade" class="formSelect" style="width: 150px;" tabindex="4" disabled="disabled">
                                        <option value=""><?php echo __("--Select--") ?></option>
                                        <?php foreach ($gradeList as $grade) {
                     ?>
                                                <option value="<?php echo $grade->grade_code ?>" <?php if($grade->grade_code== $Employee->grade_code){ echo " selected=selected"; }  ?> ><?php
                                                if ($myCulture == 'en') {
                                                    $abcd = "grade_name";
                                                } else {
                                                    $abcd = "grade_name_" . $myCulture;
                                                }
                                                if ($grade->$abcd == "") {
                                                    echo $grade->grade_name;
                                                } else {
                                                    echo $grade->$abcd;
                                                }
                                        ?></option>
                    <?php                     } ?>
                        </select>
                                    </div>
<br class="clear"/>
                                    <div class="leftCol" >
                                        <label for="txtLocationCode"><?php echo __("Grade Slot") ?><span class="required">*</span></label>
                                    </div>
                                    <div class="centerCol" id="cmbGradeSlotDiv">
                                     <select name="cmbGradeslot" class="formSelect" style="width: 150px;" tabindex="4" disabled="disabled">
                                        <option value=""><?php echo __("--Select--") ?></option>
                                        <?php foreach ($gradeSlot as $Slot) {
                     ?>
                                                <option value="<?php echo $Slot->grade_code ?>" <?php if($Slot->slt_id== $Employee->slt_scale_year){ echo " selected=selected"; }  ?> ><?php
                                                echo $Slot->slt_scale_year. " --> " .$Slot->emp_basic_salary;
                                        ?></option>
                    <?php                     } ?>
                        </select>
                                    </div>


            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Pay salaries in cash") ?> <span class="required"></span></label>
            </div>
            <div class="centerCol">
                <input type="checkbox" name="chksalcash" id="chksalcash" class="formCheckbox" value="1"  style="width: 15px;" <?php if($EmployeePayroll->sal_cash_flag=='1'){ echo "checked"; }?>/>
            </div>    
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Next Increment on") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtIncrement"  name="txtIncrement" type="text"  class="formInputText" maxlength="10" value="<?php echo $Employee->emp_salary_inc_date; ?>" />
            </div>
            
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("EPF / W&OP Number") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtEPF"  name="txtEPF" type="text"  class="formInputText" maxlength="10" value="<?php echo $EmployeePayroll->emp_epf_number; ?>" />
            </div>
            
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("ETF / W&OP Number") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtETF"  name="txtETF" type="text"  class="formInputText" maxlength="10" value="<?php echo $EmployeePayroll->emp_etf_number; ?>" />
            </div>
             
            
            <br class="clear"/>

<!--
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Payroll Type") ?> </label>
            </div>
            
            <div class="centerCol">
                 <select name="cmbPayrollType" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($PayrollTypeList as $PayrollType) {
 ?>
                            <option value="<?php echo $PayrollType->prl_type_code ?>" <?php if($PayrollType->prl_type_code== $EmployeePayroll->prl_type_code){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "prl_type_name";
                            } else {
                                $abcd = "prl_type_name_" . $myCulture;
                            }
                            if ($PayrollType->$abcd == "") {
                                echo $PayrollType->prl_type_name;
                            } else {
                                echo $PayrollType->$abcd;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>
            
            
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Salary Vote") ?> </label>
            </div>
            <div class="centerCol">
                 <select name="cmbPayrollVoteTypeSalary" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($PayrollVoteTypeSalaryList as $PayrollVoteTypeSalary) {
 ?>
                            <option value="<?php echo $PayrollVoteTypeSalary->vt_typ_code ?>" <?php if($PayrollVoteTypeSalary->vt_typ_code== $EmployeePayroll->vt_sal_code){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "vt_typ_name";
                            } else {
                                $abcd = "vt_typ_name_" . $myCulture;
                            }
                            if ($PayrollVoteTypeSalary->$abcd == "") {
                                echo $PayrollVoteTypeSalary->vt_typ_name;
                            } else {
                                echo $PayrollVoteTypeSalary->$abcd;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>
            
            
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("EPF Vote") ?> </label>
            </div>
            <div class="centerCol">
                 <select name="cmbPayrollVoteTypeEPF" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($PayrollVoteTypeEPFList as $PayrollVoteTypeEPF) {
 ?>
                            <option value="<?php echo $PayrollVoteTypeEPF->vt_typ_code ?>" <?php if($PayrollVoteTypeEPF->vt_typ_code== $EmployeePayroll->vt_epf_code){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "vt_typ_name";
                            } else {
                                $abcd = "vt_typ_name_" . $myCulture;
                            }
                            if ($PayrollVoteTypeEPF->$abcd == "") {
                                echo $PayrollVoteTypeEPF->vt_typ_name;
                            } else {
                                echo $PayrollVoteTypeEPF->$abcd;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>
            
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("ETF Vote") ?> </label>
            </div>
            <div class="centerCol">
                 <select name="cmbPayrollVoteTypeETF" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($PayrollVoteTypeETFList as $PayrollVoteTypeETF) {
 ?>
                            <option value="<?php echo $PayrollVoteTypeETF->vt_typ_code ?>" <?php if($PayrollVoteTypeETF->vt_typ_code== $EmployeePayroll->vt_etf_code){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "vt_typ_name";
                            } else {
                                $abcd = "vt_typ_name_" . $myCulture;
                            }
                            if ($PayrollVoteTypeETF->$abcd == "") {
                                echo $PayrollVoteTypeETF->vt_typ_name;
                            } else {
                                echo $PayrollVoteTypeETF->$abcd;
                            }
                    ?></option>
<?php                     } ?>
                </select>
            </div>            
            <br class="clear"/>
-->
            <div class="leftCol">
                <label for="chkAssignTodefTrans"><?php echo __("Assign to default transactions") ?> </label>
            </div>
            <div class="centerCol">
                <input type="checkbox" name="chkAssignTodefTrans" id="chkAssignTodefTrans" class="formCheckbox" value="1"  style="width: 15px;" <?php if($EmployeePayroll->applied_default_txn!='0'){ echo "checked"; }?>/>
            </div>
            </div>
            
           
            <div style="float: right; padding-right: 100px; ">
                <div>
                   <label for="txtLocationCode" style="padding-left:30px;"><?php echo $Employee->employeeId; ?> </label>
                </div> 
                <br class="clear"/>
                <div> 
                    <span id="Currentimage">
                        <img id="currentImage" style="width:90px; height:100px; padding: 25px;" alt="Employee Photo"
                             src="<?php echo url_for("pim/viewPhoto?id=" . $encrypt->encrypt($Employee->empNumber)); ?>" /><br />
                        <span id="imageHint" style="padding-left:10px;">
                        </span>
                    </span>
                </div>
                <div>
                    <label for="txtLocationCode" style="padding-left: 0px; text-align: center" >
          <?php          if ($myCulture == "en") {
                $EName = "emp_display_name";
            } else {
                $EName = "emp_display_name_" . $myCulture;
            }
            if ($Employee->$EName == null) {
                echo $Employee->emp_display_name;
            } else {
                echo $Employee->$EName;
            } ?>
                    </label>            
                </div>    
            </div>    

            <br class="clear"/>
            <br class="clear"/>
        <div class="formbuttons">
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>" tabindex="18"  onclick="goBack();"/>
        </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">

    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
        $("#txtIncrement").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
<?php if ($editMode == true) { ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>
jQuery.validator.addMethod("orange_date",
                                function(value, element, params) {

                                    //var hint = params[0];
                                    var format = params[0];

                                    // date is not required
                                    if (value == '') {

                                        return true;
                                    }
                                    var d = strToDate(value, "<?php echo $format ?>");


                                    return (d != false);

                                }, ""
                            );
                       //Validate the form
                       $("#frmSave").validate({

            rules: {
                txtIncrement:{noSpecialCharsOnly: true},
                txtEPF: { required: true,noSpecialCharsOnly: true, maxlength:20 },
                txtETF: { required: true,noSpecialCharsOnly: true, maxlength:20 },
                txtIncrement: { orange_date: true }
            },
            messages: {
                txtIncrement:{noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtEPF: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 20 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtETF:{ required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 20 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtIncrement: {orange_date: "<?php echo __("Please specify valid date") ?>"}

            }
        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('payroll/UpdateEmployeePayrollInformation?id=' . $encrypt->encrypt($EmployeePayroll->emp_number) . '&lock=1') ?>";
                           }
                           else {
                               
                                var EPF=$("#txtEPF").val();
                                var ETF=$("#txtETF").val();
                                var eno="<?php echo $EmployeePayroll->emp_number; ?>";
                                var EEPF="<?php echo $EmployeePayroll->emp_epf_number; ?>";
                                var EETF="<?php echo $EmployeePayroll->emp_etf_number; ?>";
                                var error=0;
                                if( EEPF!= EPF || EETF!= ETF){
                                if(EEPF == EPF){
                                    EPF="0";
                                }
                                if(EETF == ETF){
                                    ETF="0";
                                }
                                
                               $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('payroll/AjaxEPFETF') ?>",
                                    data: { EPF: EPF, ETF: ETF , eno : eno },
                                    dataType: "json",
                                    success: function(data){
                                        if(data[0]=="1"){
                                            alert("<?php echo __("EPF number alredy exist.") ?>");
                                            error++;
                                        }
                                        if(data[1]=="1"){
                                            alert("<?php echo __("ETF number alredy exist.") ?>");
                                            error++;
                                        }
                                        
                                    }
                                 });
                               }  
                               if(error == 0){  
                               $('#frmSave').submit();
                               }
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/EmployeePayrollInformation')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           location.href="<?php echo url_for('payroll/UpdateEmployeePayrollInformation?id=' . $encrypt->encrypt($EmployeePayroll->emp_number) . '&lock=0') ?>";
                       });
                   });
</script>
