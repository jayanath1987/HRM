<?php
if (isset($getArr['capturemode']) && $getArr['capturemode'] == 'updatemode') {

    if (isset($postArr['EditMode']) && $postArr['EditMode'] == '1') {
        $editMode = false;
        $disabled = '';
    } else {
        $editMode = true;
        $disabled = 'disabled="disabled"';
    }
}
if ($currentPane == 2) {
    include_partial('pim_form_errors', array('sf_user' => $sf_user));
}
?>
<?php 

require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
<link href="<?php echo public_path('../../themes/orange/css/style.css')?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo public_path('../../themes/orange/css/message.css')?>" rel="stylesheet" type="text/css"/>
<!--[if lte IE 6]>
<link href="<?php echo public_path('../../themes/orange/css/IE6_style.css')?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<!--[if IE]>
<link href="<?php echo public_path('../../themes/orange/css/IE_style.css')?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<script type="text/javascript" src="<?php echo public_path('../../themes/orange/scripts/style.js');?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/archive.js');?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.form.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css')?>" rel="stylesheet" type="text/css"/>

<?php echo javascript_include_tag('orangehrm.validate.js'); ?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/showhidepane.js');?>"></script>

<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
	   <div class="mainHeading"><h2><?php echo __("Service Record");?></h2></div>
<div id="ErrorMSgSerRec">
    <?php echo message(); ?>
</div>

<div id="addServiceRecPane">
    <form id="frmServiceRec" method="post" action="<?php echo url_for('pim/UpdatServiceRec?empNumber=' . $employee->empNumber); ?>">
        <input type="hidden" name="txtEmpID" value="<?php echo $employee->empNumber; ?>"/>
        <input type="hidden" name="txtSerRecId" id="txtSerRecId" value=""/>


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
        <div class="leftCol"  align="top">
            <label  style="margin-top:5px;" for="txtEmployeeId"><?php echo __("Ministry/Department"); ?><br/><?php echo __("Institute/Sub Office"); ?><span class="required">*</span></label>

        </div>
        <div class="centerCol">
            <input type="text" class="formInputText"  name="txtOffice"  id="txtOffice"
                   value="" maxlength="100" />
        </div>
        <div class="centerCol">
            <input type="text" class="formInputText"  name="txtOfficeSi"  id="txtOfficeSi"
                   value="" maxlength="100" />
        </div>
        <div class="centerCol">
            <input type="text" class="formInputText"  name="txtOfficeTa"  id="txtOfficeTa"
                   value="" maxlength="100" />
        </div>
        <br class="clear"/>
        <div class="leftCol">
            <label for="txtAppLetterNo"><?php echo __("Designation"); ?><span class="required">*</span></label>
        </div>
        <div class="centerCol">
            <input type="text" class="formInputText"  name="txtSDest"  id="txtSDest"
                   value="" maxlength="50" />
        </div>
        <div class="centerCol">
            <input type="text" class="formInputText"  name="txtSDestSi"  id="txtSDestSi"
                   value="" maxlength="50" />
        </div>
        <div class="centerCol">
            <input type="text" class="formInputText"  name="txtSDestTa"  id="txtSDestTa"
                   value="" maxlength="50" />
        </div>
        <br class="clear"/>
        <div class="leftCol">
            <label for="txtAppLetterNo"><?php echo __("District"); ?></label>
        </div>
         <div class="centerCol">         
                <select class="formSelect" id="cmbDistrictName" name="cmbDistrictName"><span class="required">*</span>
                    <option value=""><?php echo __("--Select--"); ?></option>
                    <?php
                    //Define data columns according culture

                    $moduleNameCol = ($userCulture == "en") ? "district_name" : "district_name_" . $userCulture;

                    if ($districtList) {
                        //$current =$employee->emp_status;
                       
                        foreach ($districtList as $modules) {
                           
                            $moduleName = $modules->$moduleNameCol == "" ? $modules->district_name : $modules->$moduleNameCol;
                            echo "<option  value='{$modules->district_id}'>{$moduleName}</option>";
                        }
                    }
                    ?>

                </select>
           </div>
        <br class="clear"/>
        <div class="leftCol">
            <label for="txtAppLetterNo"><?php echo __("From Date"); ?></label>
        </div>
        <div class="centerCol">
            <input type="text" class="formInputText"  name="txtSFromDate"  id="txtSFromDate"
                   value="" maxlength="15" />
        </div>

        <br class="clear"/>
        <div class="leftCol">
            <label for="txtAppLetterNo"><?php echo __("To Date"); ?></label>
        </div>
        <div class="centerCol">
            <input type="text" class="formInputText"  name="txtsTodate"  id="txtsTodate"
                   value="" maxlength="15" />
        </div>        
        <br class="clear"/>

        <div class="formbuttons">
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditSerRec" id="btnEditSerRec"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                   />
            <input type="reset" class="clearbutton" id="btnResetSerRec" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                   value="<?php echo __("Reset"); ?>"/>
            <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackSerRec" />
        </div>
    </form>
</div>
<div id="summeryServiceRec">
    <form name="frmEmpDelSerRec" id="frmEmpDelSerRec" method="post" action="<?php echo url_for('pim/DeleteServiceRecord?empNumber=' . $employee->empNumber); ?>">

        <div id="summaryPaneServiceRec">
            <div class="subHeading"></div>
            <div class="actionbar">
                <div class="actionbuttons">


                    <input type="button" class="addbutton" id="btnAddSummeryRec"
                           onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                           value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>


                    <input type="button" class="delbutton" id="btnDelSummeryRec"
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
                            <?php echo __('Ministry/Department/Institute/Sub Office'); ?>
                        </td>
                        <td scope="col">
                            <?php echo __('Designation'); ?>
                        </td>
                        <td scope="col">
                            <?php echo __('District'); ?>
                        </td>
                        <td scope="col">
                            <?php echo __('From Date'); ?>
                        </td>
                        <td scope="col">
                            <?php echo __('To Date'); ?>
                        </td>
                    </tr>
                </thead>

                <tbody>

                    <?php
                            $row = 0;
                            foreach ($serviceRec as $sRec) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                                
                                //Define data columns according culture
                                $serNameCol = ($userCulture == "en") ? "esh_name" : "esh_name_" . $userCulture;

                                $serName = $sRec->$serNameCol == "" ? $sRec->esh_name : $sRec->$serNameCol;
                                $serDestCol = ($userCulture == "en") ? "esh_designation" : "esh_designation_" . $userCulture;
                                $serDest = $sRec->$serDestCol == "" ? $sRec->esh_designation : $sRec->$serDestCol;

                                $serDistrictCol = ($userCulture == "en") ? "district_name" : "district_name_" . $userCulture;
                                $serDistrict = $sRec->District->$serDistrictCol == "" ? $sRec->District->district_name : $sRec->District->$serDistrictCol;
                                
                    ?>



                                <tr class="<?php echo $cssClass ?>">
                                    <td >
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $sRec->esh_code ?>' />
                                    </td>
                                    <td class="">
                                        <a href="#"><?php echo $serName; ?></a>
                                    </td>
                                    <td class="">
                            <?php echo $serDest; ?>
                            </td>
                            <td class="">
                            <?php echo $serDistrict; ?>
                            </td>
                            <td class="">
                            <?php echo LocaleUtil::getInstance()->formatDate($sRec->esh_from_date); ?>
                            </td>
                            <td class="">
                            <?php echo LocaleUtil::getInstance()->formatDate($sRec->esh_to_date); ?>
                            </td>

                        </tr>
                    <?php } ?>
                        </tbody>

                    </table>
                </div>
            </form>
        </div>
           </div></div>


        <script type="text/javascript">
            //<![CDATA[

<?php
                            $sysConf = OrangeConfig::getInstance()->getSysConf();
                            $dateHint = $sysConf->getDateInputHint();
                            $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
        function getServiceRecordbyID(empNumber,SerRecNo){
        $.post("<?php echo url_for('pim/getServiceRecordbyID') ?>",
        { empNumber: empNumber, SerRecNo: SerRecNo },

        function(data){

            if(data==null){
                alert("<?php echo __("record is not found") ?>");
                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/serviceRecord')) ?>";
            }else{
                setServiceRecData(data);
            }

        },
        "json"
        );
        }
        function lockServiceRecord(empNumber,ebExamNo){
        $.post("<?php echo url_for('pim/lockServiceRecord') ?>",
        { empNumber: empNumber, ebExamNo: ebExamNo },
        function(data){
            if (data.recordLocked==true) {
                getServiceRecordbyID(empNumber,ebExamNo);

                $("#frmServiceRec").data('edit', '1'); // In edit mode
                setServiceRecordAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
        );
        }
        function unlockServiceRec(empNumber,ebExamNo){
        $.post("<?php echo url_for('pim/unlockServiceRecord') ?>",
        { empNumber: empNumber, ebExamNo: ebExamNo },
        function(data){
             
            getServiceRecordbyID(empNumber,ebExamNo);
            $("#frmServiceRec").data('edit', '0'); // In view mode
            setServiceRecordAttributes();
            
        },
        "json"
        );
        }
        function setServiceRecData(data){
        
        $("#txtSerRecId").val((data.esh_code==null)?'':data.esh_code);
        $("#txtOffice").val((data.esh_name==null)? '':data.esh_name);
        $("#txtOfficeSi").val((data.esh_name_si==null)? '':data.esh_name_si);
        $("#txtOfficeTa").val((data.esh_name_ta==null)?'':data.esh_name_ta);
        $("#txtSDest").val((data.esh_designation==null)?'':data.esh_designation);
        $("#txtSDestSi").val((data.esh_designation_si==null)?'':data.esh_designation_si);
        $("#txtSDestTa").val((data.esh_designation_ta==null)?'':data.esh_designation_ta);
        $("#cmbDistrictName").val((data.esh_district==null)?'':data.esh_district);
        $("#txtSFromDate").val((data.esh_from_date==null)?'':data.esh_from_date);
        $("#txtsTodate").val((data.esh_to_date==null)?'':data.esh_to_date);

        }
        function setServiceRecordAttributes(){
        var editMode = $("#frmServiceRec").data('edit');

        if (editMode == 0) {
            $('#frmServiceRec :input').attr('disabled','disabled');

            $('#btnEditSerRec').removeAttr('disabled');
            $('#btnBackSerRec').removeAttr('disabled');

            $("#btnEditSerRec").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnEditSerRec").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {

            $('#frmServiceRec :input').removeAttr('disabled');

            $("#btnEditSerRec").attr('value',"<?php echo __("Save"); ?>");
            $("#btnEditSerRec").attr('title',"<?php echo __("Save"); ?>");
        }
        }


         $(document).ready(function() {

        buttonSecurityCommon("btnAddSummeryRec",null,null,"btnDelSummeryRec");
        showPaneData('summeryServiceRec');
        hidePaneData('addServiceRecPane');
        $("#txtSFromDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });
        $("#txtsTodate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });


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

        // Edit a work experiance data in the list
        $('#frmEmpDelSerRec a').click(function() {
            
            buttonSecurityCommon(null,null,"btnEditSerRec",null);
            var row = $(this).closest("tr");
            var serRecNo = row.find('input.checkbox:first').val();
            getServiceRecordbyID(<?php echo $employee->empNumber ?>,serRecNo);
            showPaneData('addServiceRecPane');
            hidePaneData('summeryServiceRec');

            $("#frmServiceRec").data('edit', '0'); // In view mode
            setServiceRecordAttributes();
            $("#frmServiceRec").data('serRecTemp', serRecNo); // In view mode
            $("#txtSerRecId").val(serRecNo);
            $("#ErrorMSgSerRec").val('');

            $("label.errortd[generated='true']").css('display', 'none');
        });
        // Add a ServiceRec record
        $('#btnAddSummeryRec').click(function() {
            
            $("#ErrorMSgSerRec").hide();
            $("#txtSerRecId").val('');
            $("#txtOffice").val('');
            $("#txtOfficeSi").val('');
            $("#txtOfficeTa").val('');
            $("#txtSDest").val('');
            $("#txtSDestSi").val('');
            $("#txtSDestTa").val('');
            $("#cmbDistrictName").val('');
            $("#txtsTodate").val('');
            $("#txtSFromDate").val('');
            $("#ErrorMSgSerRec").val('');
            showPaneData('addServiceRecPane');
            hidePaneData('summeryServiceRec');
            $("#btnEditSerRec").show();
             buttonSecurityCommon(null,"btnEditSerRec",null,null);
            $("#frmServiceRec").data('edit', '2'); // In add mode
            setServiceRecordAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
        });
        jQuery.validator.addMethod("maxdate",
        function(value, element) {

            var hint = '<?php echo $dateHint; ?>';
            var format = '<?php echo $format; ?>';
            var txtSFromDate = strToDate($('#txtSFromDate').val(), format)
            var txtsTodate = strToDate($('#txtsTodate').val(), format);

            if (txtSFromDate && txtsTodate && (txtSFromDate > txtsTodate)) {
                return false;
            }
            return true;
        }, ""
        );   

        $("#btnEditSerRec").click(function() {
            $("#ErrorMSgSerRec").hide();
            var editMode = $("#frmServiceRec").data('edit');
            if (editMode == 0) {

                lockServiceRecord(<?php echo $employee->empNumber ?>,$("#txtSerRecId").val());
                return false;
            }
            else {
                $('#frmServiceRec').submit();
            }
        });

        $("#frmServiceRec").validate({
                    rules: {
                        txtOffice : {required:true,maxlength: 200,noSpecialCharsOnly:true},
                        txtOfficeSi: { maxlength: 200, noSpecialCharsOnly: true },
                        txtOfficeTa: { maxlength: 200, noSpecialCharsOnly: true },
                        txtSDest:{required:true,maxlength: 1000, noSpecialCharsOnly: true },
                        txtSDestSi:{ maxlength: 1000, noSpecialCharsOnly: true },
                        txtSDestTa:{ maxlength: 1000, noSpecialCharsOnly: true },
                        cmbDistrictName:{required:true },
                        txtsTodate:{orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']} },
                        txtSFromDate:{orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}, maxdate: true }
                              
                    },
                    messages: {
                        txtOffice: {required: "<?php echo __('This field is required.') ?>", maxlength: "<?php echo __('Maximum length should be 200 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                        txtOfficeSi:{maxlength: "<?php echo __('Maximum length should be 200 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                        txtOfficeTa:{maxlength: "<?php echo __('Maximum length should be 200 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                        txtSDest:{required: "<?php echo __('This field is required.') ?>",maxlength: "<?php echo __('Maximum length should be 1000 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                        txtSDestSi:{maxlength: "<?php echo __('Maximum length should be 1000 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                        txtSDestTa:{maxlength: "<?php echo __('Maximum length should be 1000 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                        cmbDistrictName:{required: "<?php echo __('This field is required.') ?>" },
                        txtsTodate:{orange_date: '<?php echo __("Invalid date."); ?>'},
                        txtSFromDate:{orange_date: '<?php echo __("Invalid date."); ?>',maxdate:"<?php echo __('To Date Should be greater than to the From Date')?>"}

                         },
                        errorClass: "errortd",
                   submitHandler: function(form) {
                   $('#btnEditSerRec').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                   form.submit();
             }
        });

        $('#btnBackSerRec').click(function() {
        $("#ErrorMSgSerRec").hide();
            showPaneData('summeryServiceRec');
            hidePaneData('addServiceRecPane');
        });


        $('#btnResetSerRec').click(function() {
            // hide validation error messages
         
            $("#ErrorMSgSerRec").hide();
            $("label.errortd[generated='true']").css('display', 'none');

            // 0 - view, 1 - edit, 2 - add
            var editMode = $("#frmServiceRec").data('edit');
            if (editMode == 1) {
               
                unlockServiceRec(<?php echo $employee->empNumber ?>,$("#txtSerRecId").val());
                return false;
            }
            else {
                
                document.forms['frmServiceRec'].reset('');
            }
        });
var answer=0;
        //When click remove button
        $("#btnDelSummeryRec").click(function() {
            $("#mode").attr('value', 'delete');
            if($("input[name='chkID[]']").is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
    }

    if (answer !=0 ) {
        $("#frmEmpDelSerRec").submit();
    } else {
        return false;
    }
});

});
</script>
