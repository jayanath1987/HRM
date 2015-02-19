<?php
if ($lockMode == '0') {
    $editMode = true;
    $disabled = '';
} else {
    $editMode = false;
    $disabled = 'disabled="disabled"';
}
$encrypt = new EncryptionHandler();
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>


<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("EB Exams") ?></h2></div>
        <div id="errorClass">
            <?php echo message() ?>
        </div>
        <form name="frmSave" id="frmSave" method="post"  action="">


            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Service") ?> <span class="required">*</span></label>
            </div>

            <div class="centerCol">

                <select class="formSelect" id="cmbService" name="cmbService"><span class="required">*</span>
                    <option value=""><?php echo __("--Select--"); ?></option>
                    <?php
//Define data columns according culture
                    $ServiceCol = ($userCulture == "en") ? "getService_name" : "getService_name_" . $userCulture;

                    if ($serviceList) {

                        foreach ($serviceList as $service) {

                            $selected = $serviceId;

                            if ($selected == $service->getService_code()) {
                                $selectedValue = "selected";
                            } else {
                                $selectedValue = "";
                            }
                            $empServiceName = $service->$ServiceCol() == "" ? $service->getService_name() : $service->$ServiceCol();
                            echo "<option {$selectedValue}  value='{$service->getService_code()}'>{$empServiceName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Grade") ?> <span class="required">*</span></label>
            </div>



            <div class="centerCol">

                <select class="formSelect" id="cmbGrade" name="cmbGrade"><span class="required">*</span>
                    <option value=""><?php echo __("--Select--"); ?></option>
                    <?php
                    //Define data columns according culture
                    $empGradeCol = ($userCulture == "en") ? "getGrade_name" : "getGrade_name_" . $userCulture;

                    if ($gradeList) {

                        foreach ($gradeList as $empgradeList) {
                            $selected = $gradeId;


                            if ($selected == $empgradeList->getGrade_code()) {
                                $selectedValue = "selected";
                            } else {
                                $selectedValue = "";
                            }
                            $empGradeName = $empgradeList->$empGradeCol() == "" ? $empgradeList->getGrade_name() : $empgradeList->$empGradeCol();
                            echo "<option {$selectedValue}  value='{$empgradeList->getGrade_code()}'>{$empGradeName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <br class="clear"/>



            <div class="leftCol">
                <label class="controlLabel"  for="txtLocationCode"  style='padding-top:5px;'><?php echo __("EB Requirments") ?></label>
            </div>


            <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 610px; border-style:  solid; border-color: #FAD163">
                <div style="background-color:#FAD163; vertical-align: top;">

                    <label class="languageBar" style="width:610px;padding-left:2px; margin-bottom: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;">
                        <div style="width:20px; display:inline-block; vertical-align: top;"><input type="checkbox" style="margin-top: -1px;" name="chkAll" id="chkAll" value=""/></div>
                        <div style="width:175px; display:inline-block"><?php echo __("EBExam Name") ?></div>


                        <div style="width:80px; display:inline-block; vertical-align: top;"><?php echo __("Due Date") ?></div>


                        <div style="width:140px; display:inline-block; vertical-align: top; text-align: center"><?php echo __("Completed Date") ?></div>


                        <div style="width:60px; display:inline-block; vertical-align: top;"><?php echo __("Status") ?></div>


                        <div style="width:95px; display:inline-block; vertical-align: top;"><?php echo __("Remarks") ?></div>


                    </label>


                </div>
                <br class="clear"/>
                <div id="master" style="width:100%">


                </div>
                <br class="clear"/>
            </div>

            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Comment") ?></label>
            </div>

            <div class="centerCol">
                <textarea id="txtEbexamComment" class="formTextArea" style="width: 400px; height: 75px;" tabindex="1" name="txtEbexamComment"><?php echo $EBExamList[0]->EMPEBExam->emp_ebexam_genaralcomment; ?></textarea>


            </div>

            <br class="clear"/>
            <input type="hidden" name="hiddeni" id="hiddeni" value="<?php if (strlen($i)
                    )
                        echo $i; ?>"/>
            <div class="formbuttons">
                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                       value="<?php echo __("Save"); ?>"
                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />
                <input type="button" class="clearbutton" id="btnDelete" tabindex="5" <?php echo $disabled; ?>
                       value="<?php echo __("Delete"); ?>" />
            </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>

<script language="javascript">

    var scriptAr = new Array(); // initializing the javascript array
<?php
//In the below lines we get the values of the php array one by one and update it in the script array.
if($sf_data->getRaw('ebExamIDArr')!= null){
foreach ($sf_data->getRaw('ebExamIDArr') as $key => $value) {
    print "scriptAr.push(\"$value\" );"; // This line updates the script array with new entry
}}
?>

</script>
<?php
$sysConf = OrangeConfig::getInstance()->getSysConf();
$sysConf = new sysConf();
$inputDate = $sysConf->dateInputHint;
$format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>

<script type="text/javascript">
    var  editMode=0;

    function onkeyUpevent(e){


        var keynum;
        var keychar;
        var numcheck;


        if(window.event) // IE
        {
            keynum = e.keyCode;
        }
        else if(e.which) // Netscape/Firefox/Opera
        {
            keynum = e.which;
        }
        keychar = String.fromCharCode(keynum);
        numcheck = /^[^@\*\!#\$%\^&()~`\+=]+$/i;

        if(!numcheck.test(keychar)){
            alert("<?php echo __('No invalid characters are allowed') ?>");
            return false;
        }
    }

    function validationComment(e,id){


        if($('#'+id).val().length==10){
            alert("<?php echo __('Maximum length should be 200 characters') ?>");
            return false;
        }else {
            return true;
        }

    }



    $(document).ready(function() {



        buttonSecurityCommon(null,"editBtn",null,"btnDelete");
        $("#chkAll").click(function() {
            if ($('#chkAll').attr('checked')){

                $('.innerchkBox').attr('checked','checked');
            }else{
                $('.innerchkBox').removeAttr('checked');
            }
        });

        //Validate the form
        $("#frmSave").validate({

            rules: {
                cmbService: { required: true },
                cmbGrade: { required: true },
                txtEbexamComment:{ maxlength: 200, noSpecialCharsOnly: true }
            },
            messages: {
                cmbService: "<?php echo __("This field is required") ?>",
                cmbGrade: "<?php echo __("This field is required") ?>",
                txtEbexamComment:{ maxlength: "<?php echo __('Maximum length should be 200 characters') ?>",noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>" }

            },
            submitHandler: function(form) {
                $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                form.submit();
            }
        });

        var gradeId=$("#cmbGrade").val();
        var serviceId=$("#cmbService").val();

        if(gradeId!=""){
            $.post(

            "<?php echo url_for('pim/loadEbExamGrid') ?>", //Ajax file

            { gradeId : gradeId, serviceId : serviceId },  // create an object will all values

            //function that is called when server returns a value.
            function(data){


                 
                $('#master').html(data.List);
                $("#txtEbexamComment").html(data.generalComment);
                if(data.ebExamIDArr!=null){
                for(i=0;i<data.ebExamIDArr.length;i++){
                    var dueDatePicker="#dueDate_"+data.ebExamIDArr[i];

                    $(dueDatePicker).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });

                    var completedDatePicker="#completedDate_"+data.ebExamIDArr[i];

                    $(completedDatePicker).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });



                }

               }



                $('#frmSave :input').attr('disabled', true);

                $('#editBtn').removeAttr('disabled');
                $('#cmbService').removeAttr('disabled');
                $('#cmbGrade').removeAttr('disabled');
                $('#editBtn').attr('value','<?php echo __("Edit") ?>');
                $('#editBtn').show();
                buttonSecurityCommon(null,null,"editBtn",null);
                editMode=1;




            },
            "json"

        );
        }



<?php if ($lock == 1) { ?>
            $('#frmSave :input').attr('disabled', true);
            $('#editBtn').removeAttr('disabled');
<?php } ?>

        $("#cmbGrade").change(function() {
            var gradeId=$("#cmbGrade").val();
            var serviceId=$("#cmbService").val();

            var test="<?php echo $lol ?>";

            if(gradeId!=""){
                $.post(

                "<?php echo url_for('pim/loadEbExamGrid') ?>", //Ajax file

                { gradeId : gradeId, serviceId : serviceId },  // create an object will all values

                //function that is called when server returns a value.
                function(data){


               
                    $('#master').html(data.List);
                    $("#txtEbexamComment").html(data.generalComment);
                         if(data.ebExamIDArr!=null){
                    for(i=0;i<data.ebExamIDArr.length;i++){
                        var dueDatePicker="#dueDate_"+data.ebExamIDArr[i];

                        $(dueDatePicker).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });

                        var completedDatePicker="#completedDate_"+data.ebExamIDArr[i];

                        $(completedDatePicker).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });



                    }
                  }




                    $('#frmSave :input').attr('disabled', true);

                    $('#editBtn').removeAttr('disabled');
                    $('#cmbService').removeAttr('disabled');
                    $('#cmbGrade').removeAttr('disabled');
                    $('#editBtn').attr('value','<?php echo __("Edit") ?>');
                    $('#editBtn').show();
                    buttonSecurityCommon(null,null,"editBtn",null);
                    editMode=1;




                },
                "json"

            );
            }
        });

        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);
        $("#editBtn").click(function() {

            if (editMode == 1) {                
                // Set lock = 1 when requesting a table lock
                $.post(

                "<?php echo url_for('pim/lockEbExams') ?>", //Ajax file

                { serviceId : $('#cmbService').val(), gradeId : $('#cmbGrade').val() },  // create an object will all values
                
                //function that is called when server returns a value.
                function(data){

                    $('#frmSave :input').attr('disabled', false);


                    $('#editBtn').attr('value','<?php echo __("Save") ?>');
                    editMode=0;
                    if(data==1){

                    }else{
                        alert("Record Lock By Another user");
                        $('#frmSave :input').attr('disabled', true);

                        $('#editBtn').removeAttr('disabled');
                        $('#cmbService').removeAttr('disabled');
                        $('#cmbGrade').removeAttr('disabled');
                        $('#editBtn').attr('value','<?php echo __("Edit") ?>');
                        $('#editBtn').show();
                        buttonSecurityCommon(null,null,"editBtn",null);
                        editMode=1;

                    }

                },
                "json"

            );

            }
            else {
                $("input.dateGrid").each(function(){
                    $(this).rules("add", {
                        orange_date: function(){ return ['<?php echo $inputDate; ?>','<?php echo $format; ?>']},
                        messages: {
                            orange_date: '<?php echo __("Invalid date."); ?>'
                        }


                    });
                });


                $('#frmSave').submit();
            }

        });

        $("#btnClear").click(function() {
            var gradeId=$("#cmbGrade").val();
            var serviceId=$("#cmbService").val();
            $.post(

            "<?php echo url_for('pim/resetEbExamLocks') ?>", //Ajax file

            { gradeId : gradeId, serviceId : serviceId },  // create an object will all values

            //function that is called when server returns a value.
            function(data){

                $('#frmSave :input').attr('disabled', true);


                $('#editBtn').removeAttr('disabled');
                $('#cmbService').removeAttr('disabled');
                $('#cmbGrade').removeAttr('disabled');

                $('#cmbService').val(serviceId);
                $('#cmbGrade').val(gradeId);
                $('#editBtn').attr('value','<?php echo __("Edit") ?>');
                $('#editBtn').show();
                buttonSecurityCommon(null,null,"editBtn",null);
                editMode=1;
            },
            "json"

        );


        });
        var answer=0;

        $("#btnDelete").click(function() {

            if($('input[name="chkEmbId[]"]').is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
            }

            if (answer !=0 ) {
                var ids   = new Array()
                jQuery("input:checkbox:checked").each(function(){
                    ids.push(this.value)
                })

                $.post(

                "<?php echo url_for('pim/deleteEmpEbExams') ?>", //Ajax file

                { 'chkEmbId[]' : ids },  // create an object will all values

                //function that is called when server returns a value.
                function(data){
                    if(data>0){
                        alert("Succesfully Deleted");
                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/empEbexam')) ?>";


                    }
                },
                "json"

            );
            } else {
                return false;
            }
            
            
            

        });


    });

</script>
