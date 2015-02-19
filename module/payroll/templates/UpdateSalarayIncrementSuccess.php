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
$e = getdate();
$today = date("Y-m-d", $e[0]);
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/paginator.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">
        <style type="text/css">
            div.formpage4col input[type="text"]{
                width: 180px;
            }
        </style>
        <style type="text/css">
            .active
            {
                color:#FFF8C6;
                background-color:#FFE87C;
                border: solid 1px #AF7817;
                padding:1px 1px;
                margin:1px;
                text-decoration:none;
            }
            .inactive
            {
                color:#000000;
                cursor:default;
                text-decoration:none;
                border: solid 1px #FFF8C6;
                padding:1px 1px;
                margin:1px;

            }
            div.formpage4col select{
                width: 50px;
            }
            .paginator{

                padding-left: 50px;

            }

        </style>


    </div>
    <div id="status"></div>
    <div class="outerbox" style="width: 815px;">
        <div class="mainHeading">
            <?php if ($type == "cancel") { ?>
                <h2><?php echo __("Salary Increment Cancel") ?></h2>
            <?php } else { ?>
                <h2><?php echo __("Salary Increment Process") ?></h2>  

            <?php } ?>
        </div>

        <?php echo message() ?>
        <?php echo $form['_csrf_token']; ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Effective Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <?php if ($SalarayIncrement->emp_number != "") { ?>
                    <input id="txtEffectiveDate"  name="txtEffectiveDate" type="text" readonly class="formInputText" maxlength="10" value="<?php echo $SalarayIncrement->inc_effective_date; ?>" <?php echo $disabled; ?> />

                <?php } else { ?>
                    <input id="txtEffectiveDate"  name="txtEffectiveDate" type="text"  class="formInputText" maxlength="10" value="<?php echo $SalarayIncrement->inc_effective_date; ?>" <?php echo $disabled; ?> />

                <?php } ?>
            </div>

            <br class="clear"/>
            <div id="bulkemp" >


                <div class="leftCol">
                    <label id="lblemp" class="controlLabel" for="txtLocationCode"><?php echo __("Add Employee") ?> <span class="required">*</span></label>
                </div>
                <?php if ($SalarayIncrement->emp_number == '') { ?>            
                    <div class="centerCol" style="padding-top: 8px; padding-left: 10px;">
                        <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; ?> /><br>
                        <input  type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $etid; ?>"/>
                    </div>
                <?php } ?>
                <br class="clear"/>
                <div id="employeeGrid1" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 790px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:100px; height:45px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Employee ID") ?></label>
                        </div>
                        <div class="centerCol" style='width:150px; height:45px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Employee Name") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px; height:45px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Salary Before Increment") ?></label>
                        </div>
                        <div class="centerCol" style='width:75px; height:45px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:75px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Salary After Increment") ?></label>
                        </div>
                        <div class="centerCol" style='width:75px; height:45px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:75px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Increment") ?></label>
                        </div>
                        <div class="centerCol" style='width:70px; height:45px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:70px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Next Increment Date") ?></label>
                        </div>
                        <div class="centerCol" style='width:50px; height:45px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:50px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Confirm") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px; height:45px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Comment") ?></label>
                        </div>
                        <div class="centerCol" style='width:70px; height:45px;  background-color:#FAD163;'>
                            <?php if ($SalarayIncrement->emp_number == null) { ?>
                                <label class="languageBar" style="width:70px; height:35px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>
                            <?php } else { ?>
                                <label class="languageBar" style="width:70px; height:35px; height:14px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("") ?></label>
                            <?php } ?>
                        </div>

                    </div>
                    <div id="tohide">


                    </div>
                    <br class="clear"/>

                </div>
            </div>

            <?php
            $e = getdate();
            $today = date("Y-m-d", $e[0]);
            if ($type == "cancel") {
                //if($SalarayIncrement->inc_effective_date > $today){ 
                ?>
                <div class="leftCol">
                    <label for="txtLocationCode"><?php echo __("Increment Cancel") ?> </label>
                </div>
                <div class="centerCol">
                    <input id="chkCancel"  name="chkCancel" type="checkbox"  class="formInputText" value="1" <?php
            if ($SalarayIncrement->inc_cancel_flag == "1") {
                echo "checked";
            }
                ?> <?php echo $disabled; ?> />
                </div>

                <br class="clear"/>

                <div class="leftCol">
                    <label for="txtLocationCode"><?php echo __("Increment Cancel Comment") ?> </label>
                </div>
                <div class="centerCol">
                    <input id="txtCancelComment"  name="txtCancelComment" type="text"  class="formInputText" maxlength="200" value="<?php echo $SalarayIncrement->inc_cancel_comment; ?>" <?php echo $disabled; ?> />
                </div>
                <?php
            }
            //}
            ?>

            <input  type="hidden" name="txtId" id="txtId" value="<?php echo $SalarayIncrement->emp_number . "_" . $SalarayIncrement->inc_new_grade_code . "_" . $SalarayIncrement->inc_new_slt_scale_year; ?>"/>

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
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk"); ?><span class="required"> * </span> <?php echo __("are required"); ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">
    var empIDMaster
    var myArray2= new Array();
    var empstatArray= new Array();
    var k;
    var pagination = 0;
    var itemsPerPage=10;
            
    function SelectEmployee(data){

        myArr=new Array();
        lol=new Array();
        myArr = data.split('|');

        addtoGrid(myArr);
        if(myArr != null){
        }
    }

    function addtoGrid(empid){

        var arraycp=new Array();

        var arraycp = $.merge([], myArray2);

        var items= new Array();
        for(i=0;i<empid.length;i++){

            items[i]=empid[i];
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


    ); if(u==0){

        }
        var courseId1=$('#courseid').val();
        if($("#txtId").val()=='__'){
            var type='save';
            var id=null;
        }else{
            var type='update';
            var id=$("#txtId").val();
        }
        if(arraycp==null){
            alert("please select employee");
        }
                
        $.post(

        "<?php echo url_for('payroll/LoadGrid') ?>", //Ajax file


        { 'empid[]' : arraycp , type : type , id : id },  // create an object will all values

        //function that is called when server returns a value.
        function(data){
                    

            //var childDiv;
            var childdiv="";
            var i=0;

            $.each(data[0], function(key, value) {
                var word=value.split("|");
                var diable='<?php echo $disabled; ?>';
                childdiv="<div class='pagin' id='row_"+i+"' style='padding-top:10px;'>";
                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'>"+word[0]+"</div>";
                childdiv+="</div>";

                childdiv+="<div class='centerCol' id='master' style='width:150px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'>"+word[1]+"</div>";
                childdiv+="</div>";
                                    
                childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'>"+word[2]+"</div>";
                childdiv+="</div>";
                                    
                childdiv+="<div class='centerCol' id='master' style='width:75px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'>"+word[3]+"</div>";
                childdiv+="</div>";
                                    
                childdiv+="<div class='centerCol' id='master' style='width:75px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'>"+word[4]+"</div>";
                childdiv+="</div>";
                
                childdiv+="<div class='centerCol' id='master' style='width:70px;'>";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'>"+word[9]+"</div>";
                childdiv+="</div>";
<?php if ($type == "cancel") { ?>
                    var checked='<?php
    if ($SalarayIncrement->inc_confirm_flag == "1") {
        echo 'checked=checked';
    }
    ?>';
                        childdiv+="<div class='centerCol' id='master'style='width:50px;'>";
                        childdiv+="<input style='width:40px; height:13px; padding-left:0px; ' id='chkconfirm'   DISABLED   name='chkconfirm[]' type='checkbox'  value='1' "+diable+"   "+checked+"/>";
                        childdiv+="</div>";
                                                                    
                        childdiv+="<div class='centerCol' readonly='readonly' id='master' style='width:100px;'>";
                        childdiv+="<input style='width:90px; height:13px; padding-left:0px; ' id='txtcomment' readonly='readonly' name='txtcomment[]' type='text'  maxlength='200' "+diable+"  value='<?php echo $SalarayIncrement->inc_comment; ?>' />";
                        childdiv+="</div>";

<?php } else { ?>
                    var checked='<?php
    if ($SalarayIncrement->inc_confirm_flag == "1") {
        echo 'checked=checked';
    }
    ?>';
                        childdiv+="<div class='centerCol' id='master' style='width:50px;'>";
                        childdiv+="<input style='width:40px; height:13px; padding-left:0px; ' id='chkconfirm'  name='chkconfirm[]' type='checkbox'  value='1' "+diable+"   "+checked+"/>";
                        childdiv+="</div>";
                                                                    
                        childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                        childdiv+="<input style='width:90px; height:13px; padding-left:0px; ' id='txtcomment'  name='txtcomment[]' type='text'  maxlength='200' "+diable+"  value='<?php echo $SalarayIncrement->inc_comment; ?>' />";
                        childdiv+="</div>";

<?php } ?>



                childdiv+="<div class='centerCol' id='master' style='width:70px;' >";
                childdiv+="<div id='employeename' style='height:35px; padding-left:3px;'><a href='#' style='width:70px;'  onclick='deleteCRow("+i+","+word[8]+")'>";
                if($("#txtId").val()=='__'){
                    childdiv+="<?php echo __('Remove'); ?>";
                }else{
                    childdiv+="";   
                }
                childdiv+="</a>";
                childdiv+="<input type='hidden' name='hiddenPreviousSalary[]' value="+word[2]+" >";
                childdiv+="<input type='hidden' name='hiddenNewSalary[]' value="+word[3]+" >";
                childdiv+="<input type='hidden' name='hiddenIncrement[]' value="+word[4]+" >";
                childdiv+="<input type='hidden' name='hiddenEmpNumber[]' value="+word[8]+" >";
                childdiv+="<input type='hidden' name='hiddenPreviousSal[]' value="+word[5]+" >";
                childdiv+="<input type='hidden' name='hiddenNewSal[]' value="+word[6]+" >";
                childdiv+="<input type='hidden' name='hiddenGrade[]' value="+word[7]+" >";
                childdiv+="</div>";
                childdiv+="</div>";
                childdiv+="</div>";
                //

                $('#tohide').append(childdiv);


                k=i;
                i++;
            });
            pagination++;

            $(function () {

                if(pagination > 1){
                    $("#tohide").depagination();
                }
                $("#tohide").pagination();
            });
            $.each(data[1], function(key, value) {
                var Employee=value.split("|");
                var message = "Cannot give the increment due to the " + Employee[0]+" - "+Employee[1] + " is in the last slot of the current grade. Please update the employee to next grade in PIM.";                               
                alert(message);
                
            });
        },

        //How you want the data formated when it is returned from the server.
        "json"

    );


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
            
        answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

        if (answer !=0)
        {

            $("#row_"+id).remove();
            removeByValue(myArray2, value);

            $('#hiddeni').val(Number($('#hiddeni').val())-1);

            $(function () {
                $("#tohide").depagination();
                $("#tohide").pagination();
            });

        }
        else{
            return false;
        }
    } 
            




    $(document).ready(function() {
    
        buttonSecurityCommon("null","null","editBtn","null");
        
<?php if ($SalarayIncrement->emp_number == "") { ?>
            $("#txtEffectiveDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
<?php } ?>
        SelectEmployee("<?php echo $SalarayIncrement->emp_number ?>");
        $('#empRepPopBtn').click(function() {

            var popup=window.open("<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee') ?>" + "?type=multiple&method=SelectEmployee&payroll=payroll",'Locations','height=450,width=800,resizable=1,scrollbars=1');
                
            if(!popup.opener) popup.opener=self;
            popup.focus();
        });
        
<?php if ($editMode == true) { ?>
            $('#frmSave :input').attr('disabled', true);
            $('#editBtn').removeAttr('disabled');
            $('#btnBack').removeAttr('disabled');
<?php } ?>

        //Validate the form
        $("#frmSave").validate({

            rules: {
                txtEffectiveDate:{required: true},
                txtCancelComment:{noSpecialCharsOnly: true}
            },
            messages: {
                
                txtEffectiveDate:{required:"<?php echo __("This field is required") ?>"},
                txtCancelComment:{noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}

            }
        });

        // When click edit button
        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

        $("#editBtn").click(function() {

            var editMode = $("#frmSave").data('edit');
            if (editMode == 1) {
                // Set lock = 1 when requesting a table lock
<?php if ($type == "cancel") { ?>
                            
                    location.href="<?php echo url_for('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($SalarayIncrement->emp_number . "_" . $SalarayIncrement->inc_new_grade_code . "_" . $SalarayIncrement->inc_new_slt_scale_year) . '&lock=1&type=cancel') ?>";
<?php } else { ?>
               
                    location.href="<?php echo url_for('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($SalarayIncrement->emp_number . "_" . $SalarayIncrement->inc_new_grade_code . "_" . $SalarayIncrement->inc_new_slt_scale_year) . '&lock=1') ?>";  
<?php } ?>   
            }
            else {
                               
                if($("#txtEffectiveDate").val()==''){
                    alert("<?php echo __("Please Select Effective Date."); ?>");
                    return false;
                }

                if(myArray2==""){
                    alert("<?php echo __("Please Select an Employee."); ?>");
                    return false;
                }
                               

                $('#frmSave').submit();
            }


        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/SalarayIncrement')) ?>";
        });

        //When click reset buton
        $("#btnClear").click(function() {
<?php if ($SalarayIncrement->emp_number == "") { ?>
                location.href="<?php echo url_for('payroll/UpdateSalarayIncrement') ?>";                                           
<?php } else if ($type == "cancel") { ?>
                location.href="<?php echo url_for('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($SalarayIncrement->emp_number . "_" . $SalarayIncrement->inc_new_grade_code . "_" . $SalarayIncrement->inc_new_slt_scale_year) . '&lock=1&type=cancel') ?>";
<?php } else { ?>
                location.href="<?php echo url_for('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($SalarayIncrement->emp_number . "_" . $SalarayIncrement->inc_new_grade_code . "_" . $SalarayIncrement->inc_new_slt_scale_year) . '&lock=1') ?>";  
<?php } ?>   
        });
    });
</script>