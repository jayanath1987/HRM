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
        <div class="mainHeading"><h2><?php echo __("EB Exams"); ?></h2></div>

        <div id="ErrorMSg">
            <?php echo message() ?>
        </div>
        <div id="addEBexamPane">
            <form id="frmEmpEbexamDetails" method="post" action="<?php echo url_for('pim/UpdateebExam?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="txtEmpID" value="<?php echo $employee->empNumber; ?>"/>
                <input type="hidden" name="txtExamId" id="txtExamId" value=""/>


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
                <div class="leftCol">
                    <label for="txtEmployeeId"><?php echo __("Service"); ?></label>
                </div>
                <div class="centerCol">

                    <?php
//Define data columns according culture
                    $ServiceCol = ($userCulture == "en") ? "getService_name" : "getService_name_" . $userCulture;

                    if ($serviceList) {
                        $currentEmpService = isset($postArr['cmbEmbService']) ? $postArr['cmbEmbService'] : $employee->service_code;

                        $empServiceName = $serviceList[0]->$ServiceCol() == "" ? $serviceList[0]->getService_name() : $serviceList[0]->$ServiceCol();
                        echo "<label for=''>" . $empServiceName . "</label>";
                    }
                    ?>
                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtAppLetterNo"><?php echo __("Grade"); ?></label>
                </div>
                <div class="centerCol">

                    <?php
                    //Define data columns according culture
                    $empGradeCol = ($userCulture == "en") ? "getGrade_name" : "getGrade_name_" . $userCulture;

                    if ($gradeList) {
                        $currentempGrade = isset($postArr['cmbGrade']) ? $postArr['cmbGrade'] : $employee->grade_code;


                        $empGradeName = $gradeList[0]->$empGradeCol() == "" ? $gradeList[0]->getGrade_name() : $gradeList[0]->$empGradeCol();

                        echo "<label for=''>" . $empGradeName . "</label>";
                    }
                    ?>

                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtAppLetterNo"><?php echo __("Exam Details"); ?><span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <textarea   rows="5" cols="15" name="txtEBxamdescEn" id="txtEBxamdescEn"><?php echo isset($postArr['txtEBxamdescEn']) ? $postArr['txtEBxamdescEn'] : $EBExam[0]->ebexam_description; ?></textarea>

                </div>
                <div class="centerCol">
                    <textarea   rows="5" cols="15" name="txtEBxamdescSi" id="txtEBxamdescSi"></textarea>

                </div>
                <div class="centerCol">
                    <textarea   rows="5" cols="15" name="txtEBxamdescTa" id="txtEBxamdescTa"></textarea>

                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtAppLetterNo"><?php echo __("Exam Subject/Grade/Marks"); ?></label>
                </div>
                <div class="centerCol">
                    <textarea   rows="5" cols="15" name="txtEbResultEn" id="txtEbResultEn"></textarea>

                </div>
                <div class="centerCol">
                    <textarea   rows="5" cols="15" name="txtEbResultSi" id="txtEbResultSi"></textarea>

                </div>
                <div class="centerCol">
                    <textarea   rows="5" cols="15" name="txtEbResultTa" id="txtEbResultTa"></textarea>

                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtAppLetterNo"><?php echo __("Exam Status"); ?><span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <select class="formSelect" id="cmbExamStatus" name="cmbExamStatus"><span class="required">*</span>
                        <option value=""><?php echo __("--Select--"); ?></option>
                        <option value="1"><?php echo __("Pass"); ?></option>
                        <option value="0"><?php echo __("Fail"); ?></option>
                        <option value="-1"><?php echo __("Pending Result"); ?></option>
                    </select>
                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtAppLetterNo"><?php echo __("Date"); ?><span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input type="text" class="formInputText" name="txtEbexamDate"  id="txtEbexamDate"
                           value="<?php echo (isset($postArr['txtEbexamDate'])) ? $postArr['txtEbexamDate'] : $employee->emp_public_com_date; ?>" maxlength="15" />
                </div>

                <br class="clear"/>
                <div class="formbuttons">
                    <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="btnEditebExam" id="btnEditebExam"
                           value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                           title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                           onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                           />
                    <input type="reset" class="clearbutton" id="btnResetembExam" tabindex="5"
                           onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                           value="<?php echo __("Reset"); ?>"/>
                    <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="btnBackEbExam" />
                </div>

            </form>
        </div>
        <div id="summeryEbExam">
            <form name="frmEmpDelEBEXam" id="frmEmpDelEBEXam" method="post" action="<?php echo url_for('pim/deleteEbExam?empNumber=' . $employee->empNumber); ?>">

                <div id="summaryPaneEBexam">
                    <div class="subHeading"></div>
                    <div class="actionbar">
                        <div class="actionbuttons">


                            <input type="button" class="addbutton" id="btnAddebExam"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>


                            <input type="button" class="delbutton" id="btnDelEbExam"
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
                                    <?php echo __('Exam Details'); ?>
                                </td>
                                <td scope="col">
                                    <?php echo __('Exam Marks/Results'); ?>
                                </td>
                                <td scope="col">
                                    <?php echo __('Exam Status'); ?>
                                </td>
                                <td scope="col">
                                    <?php echo __('Date'); ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                                    $row = 0;
                                    foreach ($EBExam as $ebe) {
                                        $cssClass = ($row % 2) ? 'even' : 'odd';
                                        $row = $row + 1;

                                        //Define data columns according culture
                                        $examDescripCol = ($userCulture == "en") ? "ebexam_description" : "ebexam_description_" . $userCulture;

                                        $examDescri = $ebe->$examDescripCol == "" ? $ebe->ebexam_description : $ebe->$examDescripCol;
                                        $ExamresultCol = ($userCulture == "en") ? "ebexam_results" : "ebexam_results_" . $userCulture;
                                        $Examresult = $ebe->$ExamresultCol == "" ? $ebe->ebexam_results : $ebe->$ExamresultCol;
                            ?>



                                        <tr class="<?php echo $cssClass ?>">
                                            <td >
                                                <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $ebe->ebexam_id ?>' />
                                            </td>
                                            <td class="">
                                                <a href="#"><?php echo $examDescri; ?></a>
                                            </td>
                                            <td class="">
                                    <?php echo $Examresult; ?>
                                    </td>
                                    <td class="">
                                    <?php
                                        if ($ebe->ebexam_status == 0) {
                                            echo __("Fail");
                                        } elseif ($ebe->ebexam_status == 1) {
                                            echo __("Pass");
                                        } else {
                                            echo __("Pending Result");
                                        }
                                    ?>
                                    </td>
                                    <td class="">
                                    <?php echo LocaleUtil::getInstance()->formatDate($ebe->ebexam_date); ?>
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
        <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
        <script type="text/javascript">
            //<![CDATA[

<?php
                                    $sysConf = OrangeConfig::getInstance()->getSysConf();
                                    $dateHint = $sysConf->getDateInputHint();
                                    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>

        function getEbexam(empNumber,ebExamNo){
        $.post("<?php echo url_for('pim/getEbExams') ?>",
        { empNumber: empNumber, ebExamNo: ebExamNo },

        function(data){

            if(data==null){
                alert("<?php echo __("record is not found") ?>");
                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/viewEmployee/empNumber/' . $employee->empNumber)) ?>";
            }else{
                setEbExamData(data);
            }

        },
        "json"
        );
        }

        function lockEbexam(empNumber,ebExamNo){
        $.post("<?php echo url_for('pim/lockEbexam') ?>",
        { empNumber: empNumber, ebExamNo: ebExamNo },
        function(data){
            if (data.recordLocked==true) {
                getEbexam(empNumber,ebExamNo);
                $("#frmEmpEbexamDetails").data('edit', '1'); // In edit mode
                setEbexamAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
        );
        }

        function unlockEbexam(empNumber,ebExamNo){
        $.post("<?php echo url_for('pim/unlockEbexam') ?>",
        { empNumber: empNumber, ebExamNo: ebExamNo },
        function(data){
            getEbexam(empNumber,ebExamNo);
            $("#frmEmpEbexamDetails").data('edit', '0'); // In view mode
            setEbexamAttributes();
        },
        "json"
        );
        }
        function setEbExamData(data){

        $("#txtExamId").val(data.ebexam_id);
        $("#txtEbexamDate").val(data.ebexam_date);
        $("#txtEBxamdescEn").val(data.ebexam_description);
        $("#txtEBxamdescSi").val(data.ebexam_description_si);
        $("#txtEBxamdescTa").val(data.ebexam_description_ta);
        $("#txtEbResultEn").val(data.ebexam_results);
        $("#txtEbResultSi").val(data.ebexam_results_si);
        $("#txtEbResultTa").val(data.ebexam_results_ta);
        $("#cmbExamStatus").val(data.ebexam_status);


        }
        function setEbexamAttributes(){
        var editMode = $("#frmEmpEbexamDetails").data('edit');

        if (editMode == 0) {
            $('#frmEmpEbexamDetails :input').attr('disabled','disabled');

            $('#btnEditebExam').removeAttr('disabled');
            $('#btnBackEbExam').removeAttr('disabled');

            $("#btnEditebExam").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnEditebExam").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {

            $('#frmEmpEbexamDetails :input').removeAttr('disabled');

            $("#btnEditebExam").attr('value',"<?php echo __("Save"); ?>");
            $("#btnEditebExam").attr('title',"<?php echo __("Save"); ?>");
        }
        }

        $(document).ready(function() {

        showPaneData('summeryEbExam');
        hidePaneData('addEBexamPane');
        $("#txtEbexamDate").datepicker({ dateFormat: '<?php echo $dateHint; ?>',changeYear: true,changeMonth: true });

        // Edit a work experiance data in the list
        $('#frmEmpDelEBEXam a').click(function() {
            $('#ErrorMSg').hide();
            var row = $(this).closest("tr");
            var ebExamNo = row.find('input.checkbox:first').val();
            getEbexam(<?php echo $employee->empNumber ?>,ebExamNo);
            showPaneData('addEBexamPane');
            hidePaneData('summeryEbExam');

            $("#frmEmpEbexamDetails").data('edit', '0'); // In view mode
            setEbexamAttributes();
            $("#frmEmpEbexamDetails").data('ebExamNotemp', ebExamNo); // In view mode
            $("#txtExamId").val(ebExamNo);


            $("label.errortd[generated='true']").css('display', 'none');
        });

        // Add a work experience record
        $('#btnAddebExam').click(function() {
            $('#ErrorMSg').hide();
            $("#txtExamId").val('');
            $("#txtEbexamDate").val('');
            $("#txtEBxamdescEn").val('');
            $("#txtEBxamdescSi").val('');
            $("#txtEBxamdescTa").val('');
            $("#txtEbResultEn").val('');
            $("#txtEbResultSi").val('');
            $("#txtEbResultTa").val('');
            $("#cmbExamStatus").val('');
            $("#ErrorMSg").val('');


            showPaneData('addEBexamPane');
            hidePaneData('summeryEbExam');

            $("#frmEmpEbexamDetails").data('edit', '2'); // In add mode
            setEbexamAttributes();

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
        });

        $("#btnEditebExam").click(function() {
            $('#ErrorMSg').hide();
            var editMode = $("#frmEmpEbexamDetails").data('edit');
            if (editMode == 0) {
                lockEbexam(<?php echo $employee->empNumber ?>,$("#frmEmpEbexamDetails").data('ebExamNotemp'));
                return false;
            }
            else {
                $('#frmEmpEbexamDetails').submit();
            }
        });
        $('#btnBackEbExam').click(function() {
            $('#ErrorMSg').hide();
            showPaneData('summeryEbExam');
            hidePaneData('addEBexamPane');
        });


        $('#btnResetembExam').click(function() {
            $('#ErrorMSg').hide();
            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');

            // 0 - view, 1 - edit, 2 - add
            var editMode = $("#frmEmpEbexamDetails").data('edit');
            if (editMode == 1) {
                unlockEbexam(<?php echo $employee->empNumber ?>,$("#frmEmpEbexamDetails").data('ebExamNotemp'));
                return false;
            }
            else {
                document.forms['frmEmpWorkExperience'].reset('');
            }
        });

        //When click remove button
        $("#btnDelEbExam").click(function() {
            $("#mode").attr('value', 'delete');
            var answer="";
            if($('input[name=chkID[]]').is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
            }

            if (answer !=0 ) {
                $("#frmEmpDelEBEXam").submit();
            } else {
                return false;
            }
        });

        $("#frmEmpEbexamDetails").validate({
            rules: {
                txtEBxamdescEn : {required:true,maxlength: 200,noSpecialCharsOnly:true},
                txtEBxamdescSi: { maxlength: 200, noSpecialCharsOnly: true },
                txtEBxamdescTa: { maxlength: 200, noSpecialCharsOnly: true },
                txtEbResultEn:{ maxlength: 1000, noSpecialCharsOnly: true },
                txtEbResultSi:{ maxlength: 1000, noSpecialCharsOnly: true },
                txtEbResultTa:{ maxlength: 1000, noSpecialCharsOnly: true },
                cmbExamStatus : {required:true},
                txtEbexamDate : {orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}}

            },
            messages: {
                txtEBxamdescEn: {required: "<?php echo __('This field is required.') ?>", maxlength: "<?php echo __('Maximum length should be 200 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                txtEBxamdescSi:{maxlength: "<?php echo __('Maximum length should be 200 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                txtEBxamdescTa:{maxlength: "<?php echo __('Maximum length should be 200 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                txtEbResultEn:{maxlength: "<?php echo __('Maximum length should be 1000 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                txtEbResultSi:{maxlength: "<?php echo __('Maximum length should be 1000 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                txtEbResultTa:{maxlength: "<?php echo __('Maximum length should be 1000 characters') ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>" },
                txtEbexamDate : {orange_date: '<?php echo __("Invalid date."); ?>'},
                cmbExamStatus : {required: "<?php echo __('This field is required.') ?>"}
    },
    errorClass: "errortd",
       submitHandler: function(form) {
       $('#btnEditebExam').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
       form.submit();
     }
});

});

</script>