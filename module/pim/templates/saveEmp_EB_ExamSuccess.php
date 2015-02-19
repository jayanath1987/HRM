<?php
if ($mode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>
<?php
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Education") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">



            <input id="txtHiddenDisID"  name="txtHiddenDisID" type="hidden"  class="formInputText" value="<?php echo $EmployeeEB->ebh_id; ?>" maxlength="100" />
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Grade") ?> <span class="required">*</span></label>
            </div>



            <div class="centerCol">
                <select class="formSelect" <?php echo $disabled; ?> id="cmbGrade" name="cmbGrade">
                    <option value=""><?php echo __("--Select--"); ?></option>    
                    <?php
                    $GradeNameCol = ($userCulture == "en") ? "grade_name" : "grade_name_" . $userCulture;
                    if ($GradeList) {
                        foreach ($GradeList as $Grade) {
                            $GradeName = $Grade->$GradeNameCol == "" ? $Grade->grade_name : $Grade->$GradeNameCol;
                            ?> <option 

                                <?php if ($EmployeeEB->EBMasterHead->Grade->grade_code == $Grade->grade_code) { ?>
                                    selected="selected"
                                <?php } ?>

                                value="<?php echo $Grade->grade_code; ?>"                       

                                ><?php echo $GradeName ?></option>
                            <?php
                            }
                        }
                        ?>
                </select>                
            </div>
            <br class="clear"/>
            
            
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("EB Exams") ?> <span class="required">*</span></label>
            </div>



            <div class="centerCol">
                <select class="formSelect" <?php echo $disabled; ?> id="cmbEBExam" name="cmbEBExam" onclick="LoadSubject();">
                    <option value=""><?php echo __("--Select--"); ?></option>    
                    <?php
                    $EBExamNameCol = ($userCulture == "en") ? "ebh_exam_name" : "ebh_exam_name_" . $userCulture;
                    if ($EBExamList) {
                        foreach ($EBExamList as $EBExam) {
                            $EBExamName = $EBExam->$EBExamNameCol == "" ? $EBExam->ebh_exam_name : $EBExam->$EBExamNameCol;
                            ?> <option 

                                <?php if ($EmployeeEB->ebh_id == $EBExam->ebh_id) { ?>
                                    selected="selected"
                                <?php } ?>

                                value="<?php echo $EBExam->ebh_id; ?>"                       

                                ><?php echo $EBExamName ?></option>
                            <?php
                            }
                        }
                        ?>
                </select>                
            </div>
            <br class="clear"/>
            
            

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Attempt") ?> </label>
            </div>



            <div class="centerCol">
                <select class="formSelect" <?php echo $disabled; ?> id="cmbAtmpt" name="cmbAtmpt" >
                    <option value=""><?php echo __("--Select--"); ?></option>    
                    <?php for ($i = 1; $i <= 10; $i++) { ?>                 
                        <option <?php if ($i == $EmployeeEB->ebe_attepmt) { ?>
                                selected="selected"
                        <?php } ?>
                            value='<?php echo $i ?>'><?php echo $i ?></option>
                    <?php }
                    ?>
                </select>  

            </div>

            <br class="clear"/>

            <br class="clear"/>
            <div id="bulkemp" >

                <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 710px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Subject") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Start Date") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Complete Date") ?></label>
                        </div>
                        <div class="centerCol" style='width:110px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Marks") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Status") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Comment") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>
                        </div>

                    </div>
                    <div id="tohide">
<?php
if (strlen($childDiv)) {
    echo $sf_data->getRaw('childDiv');
}
?>

                    </div>
                    <br class="clear"/>
                </div>
            </div>
<?php
foreach ($EmpEducationDetail as $Item) { 
    $Rates[] = $Item->ebd_id;
}
?>
            <script language="javascript">
                myArray2= new Array();
                phparray = new Array(); // initializing the javascript array
            <?php
            //In the below lines we get the values of the php array one by one and update it in the script array.

            if ($Rates) {
                foreach ($Rates as $key => $value) {
                    print "phparray.push(\"$key\");";  //This line updates the script array with new entry
                }
            }
            ?>

            </script>


            <br class="clear"/>
            <br class="clear"/>

            <div class="formbuttons">

                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                       value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="button" class="clearbutton"  id="resetBtn"
                       value="<?php echo __("Reset") ?>" tabindex="9" />
<!--                <input type="button" class="backbutton" id="Addtogridbutton"
                       value="<?php echo __("Add Subjects") ?>" onclick="addtoGrid($('#RatingItems').val())" tabindex="10" />-->
                <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>

        </form>
    </div>

</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<?php
$sysConf = OrangeConfig::getInstance()->getSysConf();
$sysConf = new sysConf();
$inputDate = $sysConf->dateInputHint;
$format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>


<script type="text/javascript">
    //var myArray2= new Array();
    var empstatArray= new Array();
    var subject= new Array();
    var grade = new Array();
    var i;
    //var id;
    //var k;
    
    function LoadHistory(id){
        var SUBID = $("#cmbSubject_"+id).val();
        var EBID = $("#cmbEBExam").val();
        var Atmpt = $("#cmbAtmpt").val();
        if(SUBID!= null && EBID!= null && Atmpt!= null){
        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('pim/LoadEMPEBSubjectHistory') ?>",
            data: { SUBID: SUBID, EBID: EBID, Atmpt:Atmpt },
            dataType: "json",
            success: function(data){
                
                if(data!= "||||"){
                 var word=data.split("|");
                    $("#txtStartdate_"+id).val(word[0]);
                    $("#txtEnddate_"+id).val(word[1]);
                    $("#txtMarks_"+id).val(word[2]);
                    $("#cmbStatus_"+id).val(word[3]);
                    $("#txtComment_"+id).val(word[4]);        
                    
                    
                }
            }
            });
            
            }
    }
    
    function LoadSubject(){
        var EBID = $("#cmbEBExam").val();
        var GradeID = null;
        $('#tohide').empty();
        childdiv="";
         $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('pim/LoadEMPEBSubjects') ?>",
            data: { GradeID: GradeID, EBID: EBID },
            dataType: "json",
            success: function(data){
                if(data != null){
                $.each(data, function(key, value) {
                                var word=value.split("|"); 

                                childdiv="<div id='row_"+key+"' style='padding-top:0px; width:710px; height:25px;'>";
                                childdiv+="<div class='centerCol' id='master' style='width:100px; height:25px;'>";
                                childdiv+="<div id='employeename' style='height:25px;'>";

                                childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbSubject_"+key+"' name='cmbSubject_"+key+"' onclick='LoadHistory("+key+");' ><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                                $.each(data, function(key, value) {
                                    var word=value.split("|");
                                    childdiv+="<option value='"+word[0]+"'>"+word[1]+"</option>";
                                });
                                childdiv+="</select>";
                                childdiv+="</div></div>";
                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px;  padding-left:3px; padding-top:10px;'>";
                                childdiv+="<input type='text'  style='width:90px; color:#444444;' name='txtStartdate_"+key+"' id='txtStartdate_"+key+"'";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' />";
                                childdiv+="</div></div>";


                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px;  padding-left:3px; padding-top:10px;'>";
                                childdiv+="<input type='text'  style='width:90px; color:#444444;' name='txtEnddate_"+key+"' id='txtEnddate_"+key+"'";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' />";                    
                                childdiv+="</div></div>";
                                
                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px;  padding-left:3px; padding-top:10px;'>";
                                childdiv+="<input type='text'  style='width:90px; color:#444444;' name='txtMarks_"+key+"' id='txtMarks_"+key+"'";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' />";                  
                                childdiv+="</div></div>";
                                
                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px;  padding-left:0px; padding-top:0px;'>";
                                
                                childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbStatus_"+key+"' name='cmbStatus_"+key+"'><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                                
                                    childdiv+="<option value='1'>Pass</option>";
                                    childdiv+="<option value='2'>Pending</option>";
                                    childdiv+="<option value='0'>Fail</option>";

                                childdiv+="</select>";
                                childdiv+="</div></div>";                                    

                                childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
                                childdiv+="<div style='height:25px; padding-left:3px; padding-top:10px;'>";
                                childdiv+="<input type='text'  style='width:90px; color:#444444;' name='txtComment_"+key+"' id='txtComment_"+key+"'";

                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' /></div></div>";

                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px; padding-left:3px; padding-top:10px;'><a href='#' style='width:100px;' onclick='deleteCRow("+key+","+key+")'><?php echo __('Remove') ?></a><input type='hidden' name='ITEMS_["+key+"]' value='' ></div>";
                                childdiv+="</div>";
                                childdiv+="<input type='hidden' name='noofhead' value="+key+" ></div>";

                                $('#tohide').append(childdiv); 
                                $("#txtStartdate_"+key).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
                                $("#txtEnddate_"+key).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
                                //}
                                i++;

                                //}

            
                });
        
            }}
        });
    }                    
    function InitializeData(){
                
        var EBID = $("#cmbEBExam").val();
        var GradeID = null;
        var i=0;
        childdiv="";
         $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('pim/LoadEMPEBSubjects') ?>",
            data: { GradeID: GradeID, EBID: EBID },
            dataType: "json",
            success: function(data){
                
                <?php foreach ($EmpEducationDetail as $Item) { ?> 
                                //var word=value.split("|"); 

                                childdiv="<div id='row_"+i+"' style='padding-top:0px; width:710px; height:25px;'>";
                                childdiv+="<div class='centerCol' id='master' style='width:100px; height:25px;'>";
                                childdiv+="<div id='employeename' style='height:25px;'>";

                                childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbSubject_"+i+"' name='cmbSubject_"+i+"'><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                                $.each(data, function(key, value) {
                                var word=value.split("|");
                                childdiv+="<option value='"+word[0]+"'";
                                    if(word[0]=="<?php echo $Item->EBMasterDetail->ebs_id ?>"){
                                       childdiv+="selected='selected'";   
                                }
                                    childdiv+=">"+word[1]+"</option>";
                                });
                                childdiv+="</select>";
                                childdiv+="</div></div>";
                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px;  padding-left:3px; padding-top:10px;'>";
                                childdiv+="<input type='text'  style='width:90px; color:#444444;' name='txtStartdate_"+i+"' id='txtStartdate_"+i+"'";
                                childdiv+="value='<?php echo $Item->ebe_start_date ?>'";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' />";
                                childdiv+="</div></div>";


                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px;  padding-left:3px; padding-top:10px;'>";
                                childdiv+="<input type='text'  style='width:90px; color:#444444;' name='txtEnddate_"+i+"' id='txtEnddate_"+i+"'";
                                childdiv+="value='<?php echo $Item->ebe_complete_date ?>'";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' />";                    
                                childdiv+="</div></div>";
                                
                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px;  padding-left:3px; padding-top:10px;'>";
                                childdiv+="<input type='text'  style='width:90px; color:#444444;' name='txtMarks_"+i+"' id='txtMarks_"+i+"'";
                                childdiv+="value='<?php echo $Item->ebe_marks ?>'";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' />";                  
                                childdiv+="</div></div>";
                                
                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px;  padding-left:0px; padding-top:0px;'>";
                                
                                childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbStatus_"+i+"' name='cmbStatus_"+i+"'><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                                
                                    childdiv+="<option value='1'";
                                    if(1=="<?php echo $Item->ebe_flg_pass ?>"){
                                       childdiv+="selected='selected'";   
                                    }
                                    childdiv+=">Pass</option>";
                                    childdiv+="<option value='2'";
                                    if(2=="<?php echo $Item->ebe_flg_pass ?>"){
                                       childdiv+="selected='selected'";   
                                    }
                                    childdiv+=">Pending</option>";
                                    childdiv+="<option value='0'";
                                        if(0=="<?php echo $Item->ebe_flg_pass ?>"){
                                       childdiv+="selected='selected'";   
                                    }
                                    childdiv+=">Fail</option>";

                                childdiv+="</select>";
                                childdiv+="</div></div>";                                    

                                childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
                                childdiv+="<div style='height:25px; padding-left:3px; padding-top:10px;'>";
                                childdiv+="<input type='text'  style='width:90px; color:#444444;' name='txtComment_"+i+"' id='txtComment_"+i+"'";
                                childdiv+="value='<?php echo $Item->ebe_comment ?>'";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' /></div></div>";

                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px; padding-left:3px; padding-top:10px;'><a href='#' style='width:100px;' onclick='deleteCRow("+i+","+i+")'><?php echo __('Remove') ?></a><input type='hidden' name='ITEMS_["+i+"]' value='' ></div>";
                                childdiv+="</div>";
                                childdiv+="<input type='hidden' name='noofhead' value="+i+" ></div>";

                                $('#tohide').append(childdiv); 
                                $("#txtStartdate_"+i).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
                                $("#txtEnddate_"+i).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
                                //}
                                i++;

                                //}

            
                <?php } ?>
        
            }
        });

            }


            function onkeyUpevent(event,id){

            }
           function validationDesc(event,id){
                 var code = event.which || event.keyCode;

            // 65 - 90 for A-Z and 97 - 122 for a-z 95 for _ 45 for - 46 for .
            if (!((code >= 48 && code <= 57) || (code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code == 95 || code == 46 || code == 45 || code == 32 || code == 9 || code == 13 || code == 20 ))
            {
                        $('#'+id).val("");
                        return false;
            }

            }


            function addtoGrid(empid){
                myArray2= new Array();
                arraycp=new Array();
                items=new Array();
                $('#tohide').empty(); 
                if($('#RatingItems').val()==""){
                    alert('<?php echo __("Number of Subjects Can not be blank.") ?>');
                    return false;
                }
                var UserItems=$('#RatingItems').val();

                if(UserItems!=parseFloat(UserItems)){
                    alert('<?php echo __("Number of Subjects Should be Digit.") ?>');
                    return false;
                }
                
                if (!$("#cmbEduType").val()) {
                    alert('<?php echo __("Please Select Education type") ?>');
                    return false;
                }


                var newBS=parseFloat($('#txtBasicsal').val());
                var currentBS=parseFloat($("#lblBS_0").val());
                if(newBS!=currentBS){
                    var bConfirmed = confirm("<?php echo __("Are you sure want to Generate Subjects ?") ?>");
                    if (bConfirmed){
                        $.each(myArray2,function(key, value1){
                            $("#row_"+value1).remove();
                        });
                        //myArray2.length = 0;
                        myArray2 = new Array();
                    }else{
                        return false;
                    }
                }

                var arraycp=new Array();

                var arraycp = $.merge([], myArray2);

                var items= new Array();

                for(var d=0; d<$('#RatingItems').val(); d++){
                    items[d]=d;
                }

                var u=1;
                $.each(items,function(key, value){

                    if(jQuery.inArray(value, arraycp)!=-1)
                    {

                        // ie of array index find bug sloved here//
                        if(!Array.indexOf){
                            Array.prototype.indexOf = function(obj){
                                for(var i=0; i<this.length; i++){
                                    if(this[i]==obj){
                                        return i;
                                    }
                                }
                                return -1;
                            }
                        }

                        var idx = arraycp.indexOf(value);
                        if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!
                        u=0;

                    }
                    else{

                        arraycp.push(value);

                    }


                }


            );

                $.each(myArray2,function(key, value){
                    if(jQuery.inArray(value, arraycp)!=-1)
                    {

                        // ie of array index find bug sloved here//
                        if(!Array.indexOf){
                            Array.prototype.indexOf = function(obj){
                                for(var i=0; i<this.length; i++){
                                    if(this[i]==obj){
                                        return i;
                                    }
                                }
                                return -1;
                            }
                        }

                        var idx = arraycp.indexOf(value); // Find the index
                        if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!
                        u=0;

                    }
                    else{


                    }


                }


            );
                $.each(arraycp,function(key, value){
                    myArray2.push(value);
                }


            );if(u==0){

                }
                var EduType=$('#cmbEduType').val();
                var EduYear=$('#cmbYear').val();
   
                $.ajax({
                    type: "POST",
                    async:false,
                    url: "<?php echo url_for('pim/LoadSubjects') ?>",
                    data: { EduType: EduType },
                    dataType: "json",
                    success: function(data){

                        if(undefined ===data[0]){
                            alert('<?php echo __("Education types are not defined, please contact the admin. ") ?>');
                            myArray2 = new Array();
                            arraycp = new Array();
                            return false;
                        }else{
                            subject = data;
                        }
                    }
                });
                
                $.ajax({
                    type: "POST",
                    async:false,
                    url: "<?php echo url_for('pim/LoadGrade') ?>",
                    data: { EduType: EduType, EduYear:EduYear },
                    dataType: "json",
                    success: function(data){
                        if(undefined ===data[0]){
                            //alert('<?php echo __("Grades are not defined, please contact the admin. ") ?>');
                            myArray2 = new Array();
                            arraycp = new Array();
                            return false;
                        }else{
                            grade = data;
                        }
                    }
                });
   
   
                    
                var childdiv="";
                i=0;
                var items=$('#RatingItems').val();

                $.each(arraycp, function(key, value) { 
                    //                        if(Max >= i && Min <= i){

                    childdiv="<div id='row_"+value+"' style='padding-top:0px; width:510px; height:25px;'>";
                    childdiv+="<div class='centerCol' id='master' style='width:100px; height:25px;'>";
                    childdiv+="<div id='employeename' style='height:25px;'>";
                            
                    childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbSubject_"+value+"' name='cmbSubject_"+value+"'><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                    $.each(subject, function(key, value) {
                        var word=value.split("|");
                        childdiv+="<option value='"+word[0]+"'>"+word[1]+"</option>";
                    });
                    childdiv+="</select>";
                    childdiv+="</div></div>";
                    childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                    childdiv+="<div id='employeename' style='height:25px;'>";
                            
                    childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbGrade_"+value+"' name='cmbGrade_"+value+"'><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                    $.each(grade, function(key, value) {
                        var word=value.split("|");
                        childdiv+="<option value='"+word[0]+"'>"+word[1]+"</option>";
                    });
                    childdiv+="</select>";
                    childdiv+="</div></div>";
                                    
                                    
                    childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                    childdiv+="<div id='employeename' style='height:25px;'>";
                            
                    childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbMedium_"+value+"' name='cmbMedium_"+value+"'><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
<?php foreach ($MediumList as $Medium) { ?>
                                            
                                    childdiv+="<option value='<?php echo $Medium->lang_code ?>'";
                                           
                                    childdiv+="><?php echo $Medium->lang_name ?></option>";
<?php } ?>
                                childdiv+="</select>";
                                childdiv+="</div></div>";
                                    
                                    

                                childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
                                childdiv+="<div style='height:25px; padding-left:3px; padding-top:10px;'><input type='text'  style='width:90px; color:#444444;' name='txtDesc_"+value+"' id='txtDesc_"+value+"'";

                                childdiv+="";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' /></div></div>";

                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px; padding-left:3px; padding-top:10px;'><a href='#' style='width:100px;' onclick='deleteCRow("+value+","+value+")'><?php echo __('Remove') ?></a><input type='hidden' name='ITEMS_["+value+"]' value='' ></div>";
                                childdiv+="</div>";
                                childdiv+="<input type='hidden' name='noofhead' value="+value+" ></div>";

                                $('#tohide').append(childdiv); 
                                //}
                                i++;

                                //}
                            });
                            k=i;


                            //     },

                            //How you want the data formated when it is returned from the server.
                            "json"

                            //   );

                        }
                        function removeByValue(arr, val) {
                            for(var i=0; i<arr.length; i++) {
                                if(arr[i] == val) {

                                    arr.splice(i, 1);

                                    break;

                                }
                            }
                        }
                        function deleteCRow(id,value){
                
<?php if ($disabled == '') { ?>
        var max=Math.max.apply(null, myArray2);
        if(max==id){
            answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

            if (answer !=0)
            {

                $("#row_"+id).remove();
                removeByValue(myArray2, value);

                $('#hiddeni').val(Number($('#hiddeni').val())-1);

            }
            else{
                return false;
            }
        }else{
            alert("<?php echo __("Please remove Last Subject first.") ?>");
            return false;
        }
<?php } ?>
    }
    $(document).ready(function() {

        buttonSecurityCommon("null","editBtn","null","null");
        $(':input').live("cut copy paste",function(e) {
            e.preventDefault();
        });
        myArray2=phparray;
        arraycp=phparray;
        items=phparray;
<?php if ($EmpEducationDetail[0]['ebd_id'] != null) { ?>   
                    InitializeData();
<?php } ?>
                        
                jQuery.validator.addMethod("dateValidate",
                function(value, element) {

                    var hint = '<?php echo $dateHint; ?>';
                    var format = '<?php echo $format; ?>';
                    var txtEfftFrom = strToDate($('#txtEfftFrom').val(), format)
                    var txtEfftTo = strToDate($('#txtEfftTo').val(), format);

                    if (txtEfftTo && txtEfftFrom && (txtEfftTo < txtEfftFrom)) {
                        return false;
                    }
                    return true;
                }, ""
            );


                $("#txtEfftFrom").datepicker({ dateFormat: '<?php echo $inputDate; ?>',changeYear: true,changeMonth: true });
                $("#txtEfftTo").datepicker({ dateFormat: '<?php echo $inputDate; ?>',changeYear: true,changeMonth: true });

<?php if ($mode == 0) { ?>
    $("#editBtn").show();
    buttonSecurityCommon(null,null,"editBtn",null);
    $('#frmSave :input').attr('disabled', true);
    $('#editBtn').removeAttr('disabled');
    $('#btnBack').removeAttr('disabled');
<?php } ?>


//Validate the form
$("#frmSave").validate({

rules: {
cmbGrade:{required : true},
cmbEBExam:{required : true}
},
messages: {
cmbGrade:{required : "<?php echo __("Please Select Education Type") ?>" },
cmbEduType:{required : "<?php echo __("Please Select Education Type") ?>" }
},
submitHandler: function(form) {
$('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
form.submit();
}
});



// When click edit button
$("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

// When click edit button
$("#editBtn").click(function() {
var editMode = $("#frmSave").data('edit');
if (editMode == 1) {
// Set lock = 1 when requesting a table lock

location.href="<?php echo url_for('pim/saveEmp_EB_Exam?disId=' . $EmployeeEB->ebh_id .'&atmpt=' . $EmployeeEB->ebe_attepmt . '&lock=1') ?>";
}
else {

$('#frmSave').submit();
}
//            if(myArray2=='' || myArray2=='0' ){
//                alert("<?php echo __("Subjects can not be Blank.") ?>");
//                return false;
//             } 
});

//When click reset buton
$("#resetBtn").click(function() {
<?php if ($EmployeeEB->ebe_id == null) { ?>
                           location.href="<?php echo url_for('pim/saveEmp_EB_Exam') ?>";
<?php } else { ?>
                           location.href="<?php echo url_for('pim/saveEmp_EB_Exam?disId=' . $EmployeeEB->ebh_id . '&lock=0') ?>";
<?php } ?>
                    });

                    //When Click back button
                    $("#btnBack").click(function() {
                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/Emp_EB_Exam')) ?>";
                    });

                });
</script>


