
<?php
if ($lockMode == '1') {
    $editMode = false;
    if($jp == '1'){
       $disabled2 = "disabled='disabled'";    
    }else{
        $disabled = '';
    }
} else {
    $editMode = true;
    $disabled = "disabled='disabled'";
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
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>

<style type="text/css">

.total{

    margin-top: 10px;
}   

.thSupervisor{
    display: none;
}
.trSupervisor{


    display: none;
}

.trModerator{


    display: none;
}

.thModerator{

    background-color: #0000FF;
    display: none;
}

/*.thTopCnt{
     display: none;
background-color: yellowgreen;
}*/

.thTopRaw{
    display: none;
background-color: yellowgreen;
}

.tdRaw{
    display: none;
background-color: yellowgreen;
}
    
</style>



<div class="formpage4col" style="width: 850px;" >
    <div class="navigation">
        <style type="text/css">
        div.formpage4col input[type="text"]{
            width: 180px;
        }
        </style>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php if($jp == '1'){ echo __("Define Job Progress"); }else{ echo __("Define Advance Program"); } ?></h2></div>
            <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
             <br class="clear"/>   
               
                     <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name")?> <span class="required">*</span></label>
                </div>
                
               <div class="centerCol" >
                   <input class="formInputText" style="padding-left: 0px;" type="text" name="txtEmployeeName" disabled="disabled"
               id="txtEmployeeName" value="<?php if($JobProgress->jph_emp_number){ echo $JobProgress->Employee->emp_display_name; }else{ echo $EmpDisplayName; }  ?>" readonly="readonly" style="color: #222222"/>
               <?php if($JobProgress->jph_emp_number != null){?>
                   <input  type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $JobProgress->jph_emp_number; ?>"/> 
               <?php }else{?>
                   <input  type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $EmployeeNumber; ?>"/> 
               <?php }?>    
               </div>
                 <div class="centerCol">
                     <input class="button"  style="margin-top: 10px;" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; //echo $disabled2;?> />
            </div>
            
           
            <input id="txtid"  name="txtid" type="hidden"  class="formInputText" maxlength="10" value="<?php echo $JobProgress->jph_id; ?>" />
            <br class="clear"/>
            
 
               
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Year") ?> <span class="required">*</span></label>
            </div>
               
            <div class="centerCol"> <?php 
                    for($i=2010; $i<=2030; $i++){
                    $YearList[$i] = $i;
                    }?> 
               
                
                <select name="cmbYear" id="cmbYear" class="formSelect"  tabindex="4" <?php echo $disabled; //echo $disabled2;?> >
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <?php                 
                    foreach ($YearList as $Year) {  ?>
                            <option value="<?php echo $Year; ?>" <?php if($JobProgress->jph_year== $Year){ echo "selected=selected"; }  ?> >
                                <?php echo $Year; ?>
                            </option>
                    <?php } ?>  
                </select>
            </div>
             <br class="clear"/>    
               
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Month") ?> <span class="required">*</span></label>
            </div>
               
            <div class="centerCol"> <?php 
                    for($i=1; $i<=12; $i++){
                    $MonthList[$i] = $i;
                    }?> 

                
                <select name="cmbMonth" id="cmbMonth" class="formSelect"  tabindex="4"  onchange="getEmplyeeEvaldetail()" <?php echo $disabled; echo $disabled2; ?>>
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <?php                 
                    foreach ($MonthList as $Month) {  ?>
                            <option value="<?php echo $Month ?>" <?php if($JobProgress->jph_month== $Month){ echo "selected=selected"; }  ?> ><?php
                        echo $Month;
                    }?></option>

                </select>
            </div>
               <br class="clear"/>    
               
                <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Approve Employee Name")?> <span class="required">*</span></label>
                </div>
                
               <div class="centerCol" >
                   <input class="formInputText" style="padding-left: 0px;" type="text" name="txtEmployee2" disabled="disabled"
               id="txtEmployee2" value="<?php if($JobProgress->jph_app_emp_number){ echo $JobProgress->ApprovalEmployee->emp_display_name; }else{ echo "Gamini Rajakaruna"; }  ?>" readonly="readonly" style="color: #222222"/>

                   <input  type="hidden" name="txtEmpId2" id="txtEmpId2" value="<?php if($JobProgress->jph_app_emp_number){ echo $JobProgress->jph_app_emp_number; }else{ echo "98"; } ?>"/> 
    
               </div>
                 <div class="centerCol">
                     <input class="button"  style="margin-top: 10px;" type="button" value="..." id="empRepPopBtn2" name="empRepPopBtn2" <?php echo $disabled; ?> />
            </div>
            
           
            <br class="clear"/>  
               
               
               
               <div id="employeeGrid1" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 780px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:120px; background-color:#FAD163;'>
                            <label class="languageBar" style="padding-left:10px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444; width: 120px;  text-align: center"><?php echo __("Date") ?></label>
                        </div>
                        <div class="centerCol" style='width:660px;  background-color:#FAD163;'>
                            <?php if($jp != 1){ ?>
                            <label class="languageBar" style="padding-left:10px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444;  width: 600px; text-align: center"><?php echo __("Description") ?></label>
                            <?php }else{ ?>
                            <label class="languageBar" style="padding-left:10px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444;  width: 600px; text-align: center"><?php echo __("Job Progress") ?></label>
                            <?php } ?>
                        </div>

                        </div>
                        <div id="datagrid" >
                    

                    </div>
                    </div>
                    
                    <br class="clear"/>
                    <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Comment")?> <span class="required">*</span></label>
                </div>
                
               <div class="" >
                   <textarea   style="width: 500px" rows="5" cols="" name="txtComment" id="txtComment"><?php echo $JobProgress->jph_comment; ?></textarea>
                  
               </div>
                    <br class="clear"/>
                                     
                


            
       <br class="clear"/>      
        <div class="formbuttons">
            <?php if($JobProgress->jph_app_flg != "1" || $jp == 1){ ?>
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <?php } ?>
            <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>" tabindex="18"  onclick="goBack();"/>
            <?php if($type!= null){ ?>
            <input type="button" class="backbutton" id="btnApprove"
                   value="<?php echo __("Approve") ?>" tabindex="18"  onclick="approve()"/>
            <?php }?>
        </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>

<script type="text/javascript">
    var comeval= null;
    var a=0;
    var b=0;
    var c=0;
    var ajaxFT = 0;
    var ajaxMS = 0;
    var ajaxTS = 0;    
    var jp = "<?php echo $jp; ?>";



    $(document).ready(function() {

     
        buttonSecurityCommon("null","null","editBtn","null");

        

        
<?php if($editMode == true){ ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>
    
    <?php if(strlen($JobProgress->jph_id)){ ?>
    getEmplyeeEvaldetail();
    
    <?php } ?>
    
    
                          $('#empRepPopBtn').click(function() {
                              
                              if($("#cmbCompEval").val() == "all"){
                                  alert("please select Company Evaluation");
                                  return false;
                              }

                                var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                                if(!popup.opener) popup.opener=self;
                                popup.focus();
                            });
                            
                            $('#empRepPopBtn2').click(function() {
                              

                                var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee2'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                                if(!popup.opener) popup.opener=self;
                                popup.focus();
                            });
    
     //$("#txtFromDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
     //$("#txtToDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });

                       //Validate the form
                       $("#frmSave").validate({

            rules: {

                txtEmployee:{required: true},
                txtEmployee2:{required: true}
                
            },
            messages: {

                txtEmployee:{required:"<?php echo __("This field is required") ?>"},
                txtEmployee2:{required:"<?php echo __("This field is required") ?>"}
        }
        });
        

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock
                             <?php  if($jp!= "1"){ ?>
            location.href="<?php echo url_for('pim/UpdateJobProgress?id=' . $encrypt->encrypt($JobProgress->jph_id) . '&lock=1&type='.$type) ?>";
            <?php }else{ ?> 
                location.href="<?php echo url_for('pim/UpdateJobProgress?id=' . $encrypt->encrypt($JobProgress->jph_id).'&jp=1' . '&lock=1&type='.$type) ?>";
                
            <?php }   ?>
                           }
                           else {
                            if($("#cmbYear").val() == "all"){
                              alert("Please Select Year");
                              $('#cmbMonth option[value="all"]').attr('selected','selected');
                              return false;
                            } 
                            if($("#cmbMonth").val() == "all"){
                             alert("Please Select Month");
                             return false;
                            }
                            if($("#txtEmpId2").val() == ""){
                             alert("Please Select Approve Employee");
                             return false;
                            }

                               $('#frmSave').submit();
                               }
                           


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           <?php if(strlen($type)){ ?> 
                           location.href="<?php echo url_for('pim/ListJobProgress?emp='.$EmployeeNumber.'&type='.$type ) ?>";
                           <?php }else{?>
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/ListJobProgress')) ?>";
                           <?php } ?>        
                           
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           <?php if($JobProgress->jph_id){ ?>
                           location.href="<?php echo url_for('pim/UpdateJobProgress?id=' . $encrypt->encrypt($JobProgress->jph_id) . '&lock=0&type='.$type ) ?>";
                           <?php }else{?>
                           location.href="<?php echo url_for('pim/UpdateJobProgress') ?>";
                           <?php } ?>
                        });

                   });
                   
                   
                        function SelectEmployee(data){

                            myArr = data.split('|');
                            $("#txtEmpId").val("");
                            $("#txtEmpId").val(myArr[0]);
                            $("#txtEmployeeName").val(myArr[1]);
                            //getEmplyeeEvaldetail(myArr[0]);
                        }
                        function SelectEmployee2(data){

                            myArr = data.split('|');
                            $("#txtEmpId2").val("");
                            $("#txtEmpId2").val(myArr[0]);
                            $("#txtEmployee2").val(myArr[1]);
                            //getEmplyeeEvaldetail(myArr[0]);
                        }
                        
                         function getEmplyeeEvaldetail(){
                             
                             var Year = $("#cmbYear").val();
                             var Month = $("#cmbMonth").val();
                             var employee = $("#txtEmpId").val();
                             if(employee == ""){
                             alert("Please Select Employee");
                              $('#cmbMonth option[value="all"]').attr('selected','selected');
                              return false;
                            }
                             if(Year == "all"){
                              alert("Please Select Year");
                              $('#cmbMonth option[value="all"]').attr('selected','selected');
                              return false;
                            } 
                            if(Month == "all"){
                             alert("Please Select Month");
                             return false;
                            }
                            var html="";
                            $.ajax({
                                type: "POST",
                                async:false,
                                url: "<?php echo url_for('pim/AjaxGetMonth') ?>",
                                data: {  Year: Year, Month: Month},
                                dataType: "json",
                                success: function(data){ 
                                    $.each(data, function(key, value) { 
                                         $.each(value, function(key1, value1) {
                                        supArray = value1.split('|');
                                        html+="<input id='date[]' style='width:120px; color: black;' name='date[]' type='hidden'  class='formInputText' value='"+supArray[0]+"' />";
                                        html+="<input id='txtdate[]' style='width:120px; color: black;' name='txtdate[]' readonly='readonly'  class='formInputText' value='"+supArray[0]+" "+supArray[1]+"' />";
                                       
                                        if( jp != '1'){ 
                                        html+="<input id='txtDesc[]' style='width:600px;' name='txtDesc[]'   class='formInputText' maxlength='200' <?php echo $disabled; ?>/>";
                                        }else{ 
                                        html+="<input id='txtJP[]' style='width:600px;' name='txtJP[]'   class='formInputText' maxlength='200' <?php echo $disabled; ?>/>";    
                                        }     
                                    });
                                        
                                    });
                                    $("#datagrid").empty();
                                    $("#datagrid").append(html);
                                }                                
                                });



                            var html="";
                            $.ajax({
                                type: "POST",
                                async:false,
                                url: "<?php echo url_for('pim/AjaxGetEmplyeeProgress') ?>",
                                data: {  Year: Year, Month: Month, employee:employee},
                                dataType: "json",
                                success: function(data){ 
                                    if(data!= ""){ 
                                   //html+="<div><br>";
                                    $.each(data, function(key, value) { 
                                        $.each(value, function(key1, value1) {
                                        
                                        html+="<input id='date[]' style='width:120px; color: black;' name='date[]' type='hidden'  class='formInputText' value='"+value1.jpd_date+"' />";
                                        html+="<input id='txtdate[]' style='width:120px; color: black;' name='txtdate[]' readonly='readonly'  class='formInputText' value='"+value1.jpd_date+" "+value1.datename+"' />";
                                        var val = "";
                                        var val2 = "";
                                        if(value1.jpd_description!= null){
                                         val = value1.jpd_description;    
                                        }
                                        if(value1.jpd_jp!= null){
                                         val2 = value1.jpd_jp;    
                                        }
                                        

                                        if( jp != '1'){ 
                                        html+="<input id='txtDesc[]' style='width:600px;' name='txtDesc[]'   class='formInputText' maxlength='200' value='"+val+"' <?php echo $disabled; ?>/>";
                                         }else{ 
                                            html+="<input id='txtJP[]' style='width:600px;' name='txtJP[]'   class='formInputText' maxlength='200' value='"+val2+"' <?php echo $disabled; ?>/>";
                                         }     
                                    });
                                    });
                                    $("#datagrid").empty();
                                    $("#datagrid").append(html);
                                    }
                                }
                                
                                });
                                    
                         }
                         
                        
    function approve(){
        var ev_id = "<?php echo $JobProgress->jph_id; ?>";
          $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('pim/AjaxApprove') ?>",
            data: { ev_id: ev_id },
            dataType: "json",
            success: function(data){
                alert(data);
            }
            });
    }


                            
</script>

