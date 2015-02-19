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



            <input id="txtHiddenDisID"  name="txtHiddenDisID" type="hidden"  class="formInputText" value="<?php echo $EmpEducationHead->eduh_id; ?>" maxlength="100" />
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Education Type") ?> <span class="required">*</span></label>
            </div>



            <div class="centerCol">
                <select class="formSelect" <?php echo $disabled; ?> id="cmbEduType" name="cmbEduType">
                    <option value=""><?php echo __("--Select--"); ?></option>    
                    <?php
                    $eduNameCol = ($userCulture == "en") ? "edu_type_name" : "edu_type_name_" . $userCulture;
                    if ($EducationTypeList) {
                        foreach ($EducationTypeList as $unEdu) {
                            $eduName = $unEdu->$eduNameCol == "" ? $unEdu->edu_type_name : $unEdu->$eduNameCol;
                            ?> <option 

                                <?php if ($EmpEducationHead->edu_type_id == $unEdu->edu_type_id) { ?>
                                    selected="selected"
                                <?php } ?>

                                value="<?php echo $unEdu->edu_type_id; ?>"                       

                                ><?php echo $eduName ?></option>
                            <?php
                            }
                        }
                        ?>
                </select>                
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Year") ?> </label>
            </div>



            <div class="centerCol">
                <select class="formSelect" <?php echo $disabled; ?> id="cmbYear" name="cmbYear">
                    <option value=""><?php echo __("--Select--"); ?></option>    
                    <?php for ($i = 1950; $i <= 2015; $i++) { ?>                 
                        <option <?php if ($i == $EmpEducationHead->grd_year) { ?>
                                selected="selected"
                        <?php } ?>
                            value='<?php echo $i ?>'><?php echo $i ?></option>
                    <?php }
                    ?>
                </select>  

            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Institute") ?> </label>
            </div>

            <div class="centerCol">

                <input id="txtInstitute"  name="txtInstitute" type="text"  class="formInputText" value="<?php echo $EmpEducationHead->eduh_institute; ?>" maxlength="200" />

            </div>

            <div class="centerCol">
                <label for="txtLocationCode"><?php echo __("Z-Score/ GPA") ?> </label>
            </div>

            <div class="centerCol">

                <input id="txtZScore"  name="txtZScore" type="text"  class="formInputText" value="<?php echo $EmpEducationHead->eduh_zscorgdp; ?>" maxlength="200" />

            </div>


            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Index No") ?> </label>
            </div>

            <div class="centerCol">

                <input id="txtIndexNo"  name="txtIndexNo" type="text"  class="formInputText" value="<?php echo $EmpEducationHead->eduh_indexno; ?>" maxlength="50" />

            </div>
            <div class="centerCol">
                <label for="txtLocationCode"><?php echo __("Island Rank") ?> </label>
            </div>

            <div class="centerCol">

                <input id="txtIslandRank"  name="txtIslandRank" type="text"  class="formInputText" value="<?php echo $EmpEducationHead->eduh_slrank; ?>" maxlength="200" />

            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Number of Subjects") ?> 
<!--                    <span class="required">*</span>-->
                </label>
            </div>
            <div class="centerCol">
                <input id="RatingItems"  name="RatingItems" type="text"  class="formInputText" value="" maxlength="2" />
            </div>
            <br class="clear"/>
            <div id="bulkemp" >

                <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 510px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Subject") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Grade") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Medium") ?></label>
                        </div>
                        <div class="centerCol" style='width:110px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:15px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Description") ?></label>
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
    $Rates[] = $Item['rdt_grade'];
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
                <input type="button" class="backbutton" id="Addtogridbutton"
                       value="<?php echo __("Add Subjects") ?>" onclick="addtoGrid($('#RatingItems').val())" tabindex="10" />
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
                        
                        
    function InitializeData(){
                
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
                    alert('<?php echo __("Grades are not defined, please contact the admin. ") ?>');
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

<?php foreach ($EmpEducationDetail as $Item) { ?>
                        childdiv="<div id='row_"+i+"' style='padding-top:0px; width:510px; height:25px;'>";
                        childdiv+="<div class='centerCol' id='master' style='width:100px; height:25px;'>";
                        childdiv+="<div id='employeename' style='height:25px;'>";
                                
                        childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbSubject_"+i+"' name='cmbSubject_"+i+"' ><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                        $.each(subject, function(key, value) {
                            var word=value.split("|");
                            childdiv+="<option value='"+word[0]+"'";
                            if(word[0]=="<?php echo $Item['subj_id'] ?>"){
                                childdiv+="selected='selected'";   
                            }
                            childdiv+=">"+word[1]+"</option>";
                        });
                        childdiv+="</select>";
                        childdiv+="</div></div>";
                        childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                        childdiv+="<div id='employeename' style='height:25px;'>";
                                
                        childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbGrade_"+i+"' name='cmbGrade_"+i+"'><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                        $.each(grade, function(key, value) {
                            var word=value.split("|");
                            childdiv+="<option value='"+word[0]+"'";
                            if(word[0]=="<?php echo $Item['grd_id'] ?>"){
                                childdiv+="selected='selected'";   
                            }
                            childdiv+=">"+word[1]+"</option>";
                        });
                        childdiv+="</select>";
                        childdiv+="</div></div>";
                                        
                        childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                        childdiv+="<div id='employeename' style='height:25px;'>";
                                
                        childdiv+="<select style='width:90px; padding-top:0px;' class='formSelect' id='cmbMedium_"+i+"' name='cmbMedium_"+i+"'><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
    <?php foreach ($MediumList as $Medium) { ?>
                                                
                                    childdiv+="<option value='<?php echo $Medium->lang_code ?>'";
        <?php if ($Medium->lang_code == $Item['lang_code']) { ?>
                                            childdiv+="selected='selected'";   
        <?php } ?>
                                        childdiv+="><?php echo $Medium->lang_name ?></option>";
    <?php } ?>
                                childdiv+="</select>";
                                childdiv+="</div></div>";

                                childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
                                childdiv+="<div style='height:25px; padding-left:3px; padding-top:10px;'><input type='text'  style='width:90px; color:#444444;' name='txtDesc_"+i+"' id='txtDesc_"+i+"'";

                                childdiv+="value='<?php if ($Item['edud_comment'] != null) echo $Item['edud_comment']; ?>'";
                                childdiv+=" onkeypress='return validationDesc(event,this.id)' maxlength='100' /></div></div>";

                                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                childdiv+="<div id='employeename' style='height:25px; padding-left:3px; padding-top:10px;'><a href='#' style='width:100px;' onclick='deleteCRow("+i+","+i+")'><?php echo __('Remove') ?></a><input type='hidden' name='ITEMS_["+i+"]' value='' ></div>";
                                childdiv+="</div>";
                                childdiv+="<input type='hidden' name='noofhead' value="+i+" ></div>";

                                $('#tohide').append(childdiv); 
                                //}
                                i++;
<?php } ?>
 
            }            
            function validationComment(event,id){
                var code = event.which || event.keyCode;

                // 65 - 90 for A-Z and 97 - 122 for a-z 95 for _ 45 for - 46 for .
                if (!((code >= 48 && code <= 57) || (code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code == 95 || code == 46 || code == 45 || code == 32 || code == 43 || code == 107 || code == 9 || code == 13 || code == 20))
                {
                    $('#'+id).val("");
                    return false;
                }
                if($('#'+id).val().length>10){
                    alert("<?php echo __('Maximum length should be 10 characters') ?>");
                    $('#'+id).val("");
                    return false;
                }
            }

            function validationDesc(event,id){
                var code = event.which || event.keyCode;

                // 65 - 90 for A-Z and 97 - 122 for a-z 95 for _ 45 for - 46 for .
                if (!((code >= 48 && code <= 57) || (code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code == 95 || code == 46 || code == 45 || code == 32 || code == 9 || code == 13 || code == 20 ))
                {
                    $('#'+id).val("");
                    return false;
                }
                if($('#'+id).val().length>100){
                    alert("<?php echo __('Maximum length should be 100 characters') ?>");
                    $('#'+id).val("");
                    return false;
                }
            }
            function validationGradeMinMax(e,id){
                if($('#'+id).val()>100){
                    $('#'+id).val("");
                    $('#'+id).val("100.00");
                }
                if($('#'+id).val()< 0){
                    $('#'+id).val("");
                    $('#'+id).val("0.00");
                }
            }
            function validationGrade(e,id){

                if(isNaN($('#'+id).val())){
                    alert("<?php echo __('Please enter Digits') ?>");
                    $('#'+id).val("");
                    return false;
                }

                if($('#'+id).val().length>6){
                    alert("<?php echo __('Maximum length Exceded') ?>");
                    $('#'+id).val("");
                    return false;
                }else {
                    return true;
                }

            }


            function onkeyUpevent(event,id){

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
                            alert('<?php echo __("Grades are not defined, please contact the admin. ") ?>');
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
<?php if ($EmpEducationDetail[0]['subj_id'] != null) { ?>   
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
txtEfftFrom:{dateValidate: true,orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}},
txtEfftTo:{dateValidate: true,orange_date: function(){ return ['<?php echo $dateHint; ?>','<?php echo $format; ?>']}},
txtAction: {noSpecialCharsOnly: true, maxlength:100 },
txtComment: {noSpecialCharsOnly: true, maxlength:200 },
cmbEduType:{required : true }
},
messages: {
txtEfftFrom:{dateValidate: "<?php echo __("Effective From date should be less than to Effective to Date"); ?>",orange_date: '<?php echo __("Invalid date."); ?>'},
txtEfftTo:{dateValidate: "<?php echo __("Effective To date should be greater than to Effective to Date"); ?>", orange_date: '<?php echo __("Invalid date."); ?>' },
txtAction:{maxlength:"<?php echo __("Maximum 50 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
txtComment:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
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

location.href="<?php echo url_for('pim/saveEmpEducation?disId=' . $EmpEducationHead->eduh_id . '&lock=1') ?>";
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
<?php if ($EmpEducationHead->eduh_id == null) { ?>
                           location.href="<?php echo url_for('pim/saveEmpEducation') ?>";
<?php } else { ?>
                           location.href="<?php echo url_for('pim/saveEmpEducation?disId=' . $EmpEducationHead->eduh_id . '&lock=0') ?>";
<?php } ?>
                    });

                    //When Click back button
                    $("#btnBack").click(function() {
                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/EmpEducation')) ?>";
                    });

                });
</script>


