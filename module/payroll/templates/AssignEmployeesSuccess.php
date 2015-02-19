<?php
//if ($mode == '1') {
//    $editMode = false;
//    $disabled = '';
//} else {
//    $editMode = true;
//    $disabled = 'disabled="disabled"';
//}
//
////die(print_r($lockMode));
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<script language="javascript">
    $(function() {
        $("#tabs").tabs();
    });
    var myArray2= new Array(); // initializing the javascript array
<?php
//In the below lines we get the values of the php array one by one and update it in the script array.

if ($assignedAllEmployees) {
    foreach ($assignedAllEmployees as $detail) {
        print "myArray2.push(\"$detail->emp_number\" );";  //This line updates the script array with new entry
    }
}
?>

</script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<!--<style type="text/css">
    .table.data-table {
        width: 100%;
        border: none;
    }
</style>-->
<div class="formpage4col">
    <div class="navigation">

        <?php
        $encryption = new EncryptionHandler();
        $sysConf = new sysConf();
        ?>
    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Employee Transaction Detail (By Transaction)") ?></h2></div>

        <?php echo message() ?>


        <form name="frmSaveAssignEmployee" id="frmSaveAssignEmployee" method="post" action="<?php echo url_for('payroll/AssignEmployees') ?>">
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Transaction Type") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbTransType" id="cmbTransType" class="formSelect" style="width: 150px;" tabindex="4" onchange="changeTransType(this.value);">


                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php
                    foreach ($transTypeList as $list) {
                        ?>
                        <option value="<?php echo $list->trn_typ_code ?>"  <?php if ($transTypeId == $list->trn_typ_code)
                        echo "selected" ?>><?php
                        $abc = "trn_typ_name_" . $userCulture;
                        if ($userCulture == "en") {
                            echo $list->trn_typ_name;
                        } else {
                            if ($list->$abc != null) {
                                echo $list->$abc;
                            } else {
                                echo $list->trn_typ_name;
                            }
                        }
                    }
                    ?>

                </select>
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Transaction Detail") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol" id="DivCmbTransDetails">
                <select name="cmbTransDetails" id="cmbTransDetails" class="formSelect" style="width: 150px;" tabindex="4" onchange="changeTransType(this.value);">


                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($transDetailsList as $list) { ?>
                        <option value="<?php echo $list->trn_dtl_code ?>"  <?php if ($transDetailId == $list->trn_dtl_code)
                        echo "selected" ?>><?php
                        $abc = "trn_dtl_name_" . $userCulture;
                        if ($userCulture == "en") {
                            echo $list->trn_dtl_name;
                        } else {
                            if ($list->$abc == "") {
                                echo $list->trn_dtl_name;
                            } else {
                                echo $list->trn_dtl_name . $userCulture;
                            }
                        }
                    }
                    ?>

                </select>

            </div>
            <br/>

            <br class="clear"/>
            <input id="basetrnyes" name="basetrnyes" type="hidden" value="<?php echo $baseTrn; ?>"/>

            <br class="clear"/>

            <div id="tabs">
                <ul>
                    <li><a href="#editEmployeeDIV"><?php echo __("View/Edit employees") ?></a></li>
                    <li><a href="#addEmployeeDIV"><?php echo __("Assign New employees") ?></a></li>



                </ul>
                <div id="editEmployeeDIV">
                    <!--
                    <?php if ($transErndedcon != 1) { ?>
                                                
                                                <div class="leftCol" style="width: 140px; background-color: wheat; height: 30px;" >
                                                    <input  type="checkbox" name="chkApplytoAll" id="chkApplytoAll" value="1"/>
                                                </div>    
                                                <div class="centerCol"  style="width: 140px;  background-color: wheat; height: 30px;">     
                                                    <label  class="controlLabel" for="" style="margin-top: 5px;"><?php echo __("Apply To All") ?></label>
                                                </div>  
                                                <div class="centerCol"  style="width: 140px;  background-color: wheat; height: 30px;" >
                                                    <label   class="controlLabel" for="" style="margin-top: 5px;"><?php echo __("Amount") ?></label>
                                                </div>    
                                                <div class="centerCol"  style="width: 200px;  background-color: wheat; height: 30px;" >    
                                                    <input style="width: 120px; margin-top: 5px;" type="text" name="txtAmountToApplyAll" id="txtAmountToApplyAll" />&nbsp;&nbsp;
                                                </div>
                                                    
                    <?php } ?>
                    
                                        <br class="clear">
                    
                    <?php if ($transTypeType == 0) { ?>
                                                
                                                <div class="centerCol" style="width: 140px; background-color: wheat; height: 30px;" >
                                                                    <label  class="controlLabel" for="" style="margin-top: 5px;"><?php echo __("From Date") ?></label>
                                                 </div>    
                                                <div class="centerCol"  style="width: 140px; background-color: wheat; height: 30px;">                   
                                                    <input type="text" name="txtFromDateApplyAll" id="txtFromDateApplyAll" style="width: 100px; margin-top: 5px;" />
                                                </div>
                                                <div class="centerCol" style="width: 140px; background-color: wheat; height: 30px;">
                                                                    <label  class="controlLabel" for="" style="margin-top: 5px;"><?php echo __("To Date") ?></label>
                                                </div>    
                                                <div class="centerCol"  style="width: 200px; background-color: wheat; height: 30px;">                    
                                                                    <input style="width: 120px; margin-top: 5px;" type="text" name="txtToDateApplyAll" id="txtToDateApplyAll"  />
                                                </div>                    
                    <?php } ?> -->

                    <br class="clear">
                    <div id="searchPrdDiv">
                        <div class="leftCol">
                            <label class="controlLabel" for=""><b><?php echo __("Search For Period") ?></b></label>
                        </div>

                        <div>

                            <label style="display: inline; width:75px;" class="controlLabel" for="lblCode"><?php echo __("From Date") ?></label>
                            <input id="txtSearchFromdate"  name="txtEmply" type="text" style="width:100px;"  style="display: inline"  class="formInputText" value="<?php echo $fromDate ?>"  maxlength="10"/>
                        </div>
                        <div>
                            <label style="display: inline; width:75px;" class="controlLabel" for="lblCode"><?php echo __("To Date") ?></label>
                            <input id="txtSearchTodate"  name="txtEmply" type="text" style="width:100px;"  style="display: inline"  class="formInputText" value="<?php echo $toDate ?>"  maxlength="10"/>

                        </div>
                        <div>
                            <input type="button" class="editbutton" name="btnSearchPerid" id="btnSearchPerid" style="margin-left:10px; margin-top: 10px;" value="<?php echo __("Search") ?>"  />

                        </div>
                    </div>
                    <div id="typeA">
                        <?php if ($transErndedcon != 1) { ?>
                            <br class="clear">
                            <div class="centerCol"  style="width: 410px;  background-color: #FAD163; height: 30px;" >
                                <label   class="controlLabel" for="" style="margin-top: 5px; margin-left: 100px;"><?php echo __("Amount") ?></label>
                            </div>    
                            <div class="centerCol"  style="width: 150px;  background-color: #FAD163; height: 30px;" >    
                                <input style="width: 75px; margin-top: 5px;" type="text" name="txtAmountToApplyAllA" id="txtAmountToApplyAllA" />&nbsp;&nbsp;
                            </div>

                            <div class="centerCol"  style="width: 100px;  background-color: #FAD163; height: 30px;" >    
                                <input style="margin-top: 5px;" type="button" class="backbutton" id="appBtn1"
                                       value="<?php echo __("Apply To All") ?>" tabindex="10" />
                            </div>
                        <?php } ?>
                    </div>
                    <div id="typeB">
                        <?php if ($transErndedcon != 1) { ?>
                            <br class="clear">
                            <div class="centerCol"  style="width: 280px;  background-color: #FAD163; height: 30px;" >
                                <label   class="controlLabel" for="" style="margin-top: 5px; margin-left: 40px;"><?php echo __("Amount") ?></label>
                            </div>    
                            <div class="centerCol"  style="width: 135px;  background-color: #FAD163; height: 30px;" >    
                                <input style="width: 75px; margin-top: 5px;" type="text" name="txtAmountToApplyAllB" id="txtAmountToApplyAllB" />&nbsp;&nbsp;
                            </div>
                            <div class="centerCol"  style="width: 110px;  background-color: #FAD163; height: 30px;" >    
                                <input id="txtVFromdate"  name="txtVFromdate" type="text" style="width:100px;"  style="display: inline"  class="formInputText" value=""  maxlength="10"/>
                            </div>
                            <div class="centerCol"  style="width: 100px;  background-color: #FAD163; height: 30px;" >    
                                <input id="txtVTodate"  name="txtVTodate" type="text" style="width:100px;"  style="display: inline"  class="formInputText" value=""  maxlength="10"/>
                            </div>

                            <div class="centerCol"  style="width: 110px;  background-color: #FAD163; height: 30px;" >    
                                <input style="margin-top: 5px;" type="button" class="backbutton" id="appBtn2"
                                       value="<?php echo __("Apply To All") ?>" tabindex="10" />
                            </div>
                        <?php } ?>
                    </div>
                    <div id="typeC">
                        <?php if ($transErndedcon != 1) { ?>
                            <br class="clear">
                            <div class="centerCol"  style="width: 205px;  background-color: #FAD163; height: 30px;" >
                                <label   class="controlLabel" for="" style="margin-top: 5px; margin-left: 40px;"><?php echo __("Amount(%)") ?></label>
                            </div>    
                            <div class="centerCol"  style="width: 230px;  background-color: #FAD163; height: 30px;" >    
                                <input style="width: 75px; margin-top: 5px;" type="text" name="txtAmountToApplyAllC" id="txtAmountToApplyAllC" />&nbsp;&nbsp;
                            </div>
                            <div class="centerCol"  style="width: 130px;  background-color: #FAD163; height: 30px;" >    
                                <input style="width: 75px; margin-top: 5px;" type="text" name="txtAmountToApplyAllC2" id="txtAmountToApplyAllC2" />&nbsp;&nbsp;
                            </div>
                            <div class="centerCol"  style="width: 100px;  background-color: #FAD163; height: 30px;" >    
                                <input style="margin-top: 5px;" type="button" class="backbutton" id="appBtn3"
                                       value="<?php echo __("Apply To All") ?>" tabindex="10" />
                            </div>
                        <?php } ?>
                    </div>
                    <br class="clear"/>
                    <div class="noresultsbar"></div>
                    <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?></div>
                    <br class="clear" />

                    <input type="hidden" name="mode" id="mode" value=""/>
                    <table cellpadding="0" cellspacing="0" class="data-table" width="100%">
                        <thead>
                            <tr>
                                <td width="75">
                                    <?php echo __('Employee ID') ?>
                                </td>

                                <td id="tdEmpName" scope="col" width="125">
                                    <?php echo __('Employee Name') ?>
                                </td>
                                <td id="tdAmount" scope="col" >
                                    <?php echo __('Amount') ?>
                                </td>
                                <td id="tdFromDate" scope="col" >
                                    <?php echo __('From date') ?>
                                </td>
                                <td id="tdToDate" scope="col" >
                                    <?php echo __('To date') ?>
                                </td>
                                <td id="tdTrnEmpcon" scope="col" >
                                    <?php echo __('Emp%') ?>
                                </td>
                                <td id="tdTrnEyrCon" scope="col" >
                                    <?php echo __('Eyr%') ?>
                                </td>
                                <td id="tdEnable" scope="col" width="75">
                                    <?php echo __('Enabled') ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody id="tbody">

                            <?php
                            $row = 0;
                            if ($assignedEmployees) {
                                foreach ($assignedEmployees as $detail) {
                                    $empNumber = $detail->Employee->empNumber;
                                    $cssClass = ($row % 2) ? 'even' : 'odd';
                                    $row = $row + 1;
                                    ?>
                                    <tr  class="<?php echo $cssClass ?>">
                                        <td width="75px;">
                                            <?php echo $detail->Employee->employeeId; ?>
                                        </td>

                                        <td class="" style='width:125px;'>
                                            <?php echo $detail->Employee->emp_display_name; ?>
                                        </td>                                       
                                        <td class="tdAmountValue" style='width:75px; '>
                                            <input type="hidden"   name="hiddenEmp_<?php echo $empNumber ?>" id="hiddenEmp_<?php echo $empNumber ?>" value="<?php echo $empNumber ?>" />
                                            <input type="text" class="clsAmount" style='width:75px;' name="txtAmount_<?php echo $empNumber ?>" id="txtAmount_<?php echo $empNumber ?>" value="<?php echo $detail->tre_amount ?>" <?php
                                    if ($transTypeId == 4) {
                                        echo "readonly";
                                    }
                                            ?> />
                                        </td>
                                        <!-- Hide when typttype 1 -->
                                        <td class="tdFromDateValue" >
                                            <input style='width:100px;' type="text" name="txtFromDate_<?php echo $empNumber ?>" id="txtFromDate_<?php echo $empNumber ?>" value="<?php echo $detail->trn_dtl_startdate ?>" />
                                        </td>
                                        <td class="tdToDateValue" >
                                            <input style='width:100px;' type="text" name="txtToDate_<?php echo $empNumber ?>" id="txtToDate_<?php echo $empNumber ?>" value="<?php echo $detail->trn_dtl_enddate ?>" />
                                        </td>

                                        <td class="tdEmpCoValue">
                                            <input type='text' style='width:75px;' class='' id='txtEmpCon_<?php echo $empNumber ?>' name='txtEmpCon_<?php echo $empNumber ?>' value="<?php echo $detail->tre_empcon ?>" />
                                        </td>
                                        <td class="tdEmyConValue">
                                            <input type='text' style='width:75px;' class='' id='txtEyrCon_<?php echo $empNumber ?>' name='txtEyrCon_<?php echo $empNumber ?>' value="<?php echo $detail->tre_eyrcon ?>" />
                                        </td>
                                        <td class="" style='width:75px;'>
                                            <input type="checkbox" name="chkEnable_<?php echo $empNumber ?>" id="chkEnable_<?php echo $empNumber ?>" value="1" <?php if ($detail->tre_stop_flag == 0)
                                               echo "checked" ?> />
                                        </td>
        <!--                                    <td class="">
                                        </td>
                                        <td class="">
                                        </td>-->

                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>


                </div>
                <div id="addEmployeeDIV">

                    <input type="hidden" name="mode" id="mode" value=""/>
                    <table cellpadding="0" cellspacing="0" class="data-table" style="width:50%" id="addemp">
                        <thead>
                            <tr style="background-color:#ffffff;">
                                <?php if ($transErndedcon != 1) { ?>
        <!--                                    <td width="100">-->
        <!--                                        <input type="checkbox" name="chkApplytoAll" id="chkApplytoAll" value="1"/>&nbsp;&nbsp;<?php echo __("Apply To All"); ?>&nbsp;&nbsp;-->
                                    <!--                                    </td>-->
                                    <!--                                    <td>-->

        <!--                                        <input type="text" name="txtAmountToApplyAll" id="txtAmountToApplyAll" style="width:100px;" />&nbsp;&nbsp;-->

                                    <!--                                    </td>-->
                                <?php } ?>
                                <?php if ($transTypeType == 0) { ?>
                                    <!--                                    <td>-->
                                    <!--                                        <span><input type="text" name="txtFromDateApplyAll" id="txtFromDateApplyAll" style="width:100px;" /></span>&nbsp;&nbsp;-->
                                    <!--                                    </td>-->
                                    <!--                                    <td>-->
                                    <!--                                        <span><input type="text" name="txtToDateApplyAll" id="txtToDateApplyAll" style="width:100px;" /></span>&nbsp;&nbsp;-->
                                    <!--                                    </td>-->

        <!--                                    <td></td>-->
        <!--                                    <td></td>-->
                                <?php } ?>
<!--                                <td></td>
<td></td>
<td></td>-->

                            </tr>
                            <tr>
                                <td width="75">
                                   <?php echo __('Employee ID') ?>


                                </td>

                                <td scope="col">
                                    <?php echo __('Employee Name') ?>
                                </td>
                                <td id="tdAmountAdd" scope="col">
                                    <?php echo __('Amount') ?>
                                </td>
                                <td id="tdFromDateAdd" scope="col">
                                    <?php echo __('From Date') ?>
                                </td>
                                <td id="tdToDateAdd" scope="col">
                                    <?php echo __('To Date') ?>
                                </td>
                                <td id="tdTrnEmpConAdd" scope="col">
                                    <?php echo __('Emp%') ?>
                                </td>
                                <td id="tdTrnEyrConAdd" scope="col">
                                    <?php echo __('Eyr%') ?>
                                </td>
                                <td scope="col">
                                    <?php echo __('Enabled') ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody id="tbodyAddEmployee">


                        </tbody>
                    </table>


                </div>
            </div>
            <input type="hidden" name="listemp" id="listemp" value=""/>
        </form>
        <div class="formbuttons">
                        <input type="button" class="backbutton" id="empRepPopBtn"
                   value="<?php echo __("Add Employees") ?>" tabindex="10" />
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />


        </div>

    </div>
</div>
<?php
$sysConf = OrangeConfig::getInstance()->getSysConf();
$sysConf = new sysConf();
$inputDate = $sysConf->dateInputHint;
$format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<style>


    div.formpage4col label.errortd{
        /*       background-color: blue;*/
        padding-left: 0px;

    }
</style>
<script type="text/javascript">
document.getElementById("listemp").value=myArray2;
    var typeType;
    var erndedcon;
    function SelectEmployee(data){

        myArr=new Array();
        lol=new Array();
                                           
        myArr = data.split('|');

        addtoGrid(myArr);
        
    }


    function loadEmployeesByTransId(id){
        var transTypeId=$("#cmbTransType").val();
        var transDetailId=$("#cmbTransDetails").val();
        var baseTrn="0";
       $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('payroll/TransdetailsIsBase') ?>",
            data: { value: id },
            dataType: "json",
            success: function(data){
                baseTrn = data;
            }
         });

        location.href="<?php echo url_for('payroll/AssignEmployees?transTypeId=') ?>"+transTypeId+"/transDetailId/"+transDetailId+"/baseTrn/"+baseTrn;
           

    }

    function changeTransType(value){

        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('payroll/getTransdetailsByAjax') ?>",
            data: { value: value },
            dataType: "json",
            success: function(data){

                typeType=data[1];
                var selectbox="<select name='cmbTransDetails' id='cmbTransDetails' class='formSelect' style='width: 150px;' tabindex='4' onchange='loadEmployeesByTransId(this.value)'>";
                selectbox=selectbox +"<option value=''><?php echo __('--Select--') ?></option>";
                $.each(data[0], function(key, value) {

                    selectbox=selectbox +"<option value="+key+">"+value+"</option>";
                });
                selectbox=selectbox +"</select>";


                $('#DivCmbTransDetails').html(selectbox);


            }
        });

 

    }

    $(document).ready(function() {
    
    var empValidation;
//Find the tranaction typetype
            $("#typeA").hide();
            $("#typeB").hide();
            $("#typeC").hide();
        //When click reset buton
$("#btnClear").click(function() {
    location.href="<?php echo url_for('payroll/AssignEmployees') ?>";
});

 $("#txtFromDateApplyAll").datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
 $("#txtToDateApplyAll").datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });

//     alert();                                       
        if($("#cmbTransType").val()!=""){
            $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('payroll/getTransdetailsByAjax') ?>",
            data: { value: $("#cmbTransType").val() },
            dataType: "json",
            success: function(data){

                typeType=data[1];
                erndedcon=data[2];
                if(erndedcon==0){
            $("#tdAmount").hide();
            $(".tdAmountValue").hide();
            $("#tdAmountAdd").hide();
            $("#tdTrnEmpcon").show();
            $("#tdTrnEyrCon").show();
            $(".tdEmpCoValue").show();
            $(".tdEmyConValue").show();
            $("#tdTrnEmpConAdd").show();
            $("#tdTrnEyrConAdd").show();
            $("#typeA").hide();
            $("#typeB").hide();
            $("#typeC").hide();
            $("#typeA").hide();
            $("#typeC").show();

        }
        else{
            $("#tdAmount").show();
            $(".tdAmountValue").show();
            $("#tdAmountAdd").show();
            $("#tdTrnEmpcon").hide();
            $("#tdTrnEyrCon").hide();
            $(".tdEmpCoValue").hide();
            $(".tdEmyConValue").hide();
            $("#tdTrnEmpConAdd").hide();
            $("#tdTrnEyrConAdd").hide();
            $("#typeA").hide();
            $("#typeB").hide();
            $("#typeC").hide();
            $("#typeA").show();
            $("#typeB").hide();
            $("#tdEmpName").width(360);
            $("#tdAmount").width(200);
            $("#tdEnable").width(130);


        }
            }
        });

        }
                                             
                                            
        if(typeType!=0){                                                 
            $("#searchPrdDiv :input").attr('disabled', true);
                                                
        }else{
        $("#txtSearchFromdate").datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
        $("#txtSearchTodate").datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
            $("#typeA").hide();
            $("#typeB").hide();
            $("#typeA").hide();
            $("#typeC").hide();
            $("#typeB").show();
            $("#txtVFromdate").datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
            $("#txtVTodate").datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
        }
                                            
                                            

        $("#frmSaveAssignEmployee").validate({
            rules: {
                //txtFromDateApplyAll : {required: true},
                //txtToDateApplyAll : {required: true},
                //txtAmountToApplyAll:{required: true,number: true}
            },
            messages: {
                //txtFromDateApplyAll: '<?php echo __("This field is required.") ?>',
                //txtToDateApplyAll : '<?php echo __("This field is required.") ?>',
                //txtAmountToApplyAll:{required: '<?php echo __("This field is required.") ?>',number:  '<?php echo __("Please enter a number") ?>'}
            },
            errorClass: "errortd",

            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass);

            }
        });

$("#appBtn1").click(function() {
    //alert($("#txtAmountToApplyAll").val());
    var cont="";
    if($("#txtAmountToApplyAllA").val()!=""){
        cont=$("#txtAmountToApplyAllA").val();
    }
    if($("#txtAmountToApplyAllB").val()!=""){
        cont=$("#txtAmountToApplyAllB").val();
    }
    if($("#txtAmountToApplyAllC").val()!=""){
        cont=$("#txtAmountToApplyAllC").val();
    }
    if($("#txtAmountToApplyAllC2").val()!=""){
        cont=$("#txtAmountToApplyAllC2").val();
    }
    $.each(myArray2,function(key, value){
        $("#txtAmount_"+value).val(cont);
    });
});   
$("#appBtn2").click(function() {
    //alert($("#txtAmountToApplyAll").val());
    var cont="";
    var fdat = "";
    var tdat = "";
    if($("#txtAmountToApplyAllA").val()!=""){
        cont=$("#txtAmountToApplyAllA").val();
    }
    if($("#txtAmountToApplyAllB").val()!=""){
        cont=$("#txtAmountToApplyAllB").val();
    }
    if($("#txtAmountToApplyAllC").val()!=""){
        cont=$("#txtAmountToApplyAllC").val();
    }
    if($("#txtAmountToApplyAllC2").val()!=""){
        cont=$("#txtAmountToApplyAllC2").val();
    }
    if($("#txtVFromdate").val()!=""){
         fdat=$("#txtVFromdate").val();
    }
    if($("#txtVTodate").val()!=""){
         tdat=$("#txtVTodate").val();
    }
    $.each(myArray2,function(key, value){
        $("#txtAmount_"+value).val(cont);
    });
    
    $.each(myArray2,function(key, value){
        $("#txtFromDate_"+value).val(fdat);
    });
    $.each(myArray2,function(key, value){
        $("#txtToDate_"+value).val(tdat);
    });
});
$("#appBtn3").click(function() {
    //alert($("#txtAmountToApplyAll").val());
    var cont1="";
    var cont2="";
    if($("#txtAmountToApplyAllC").val()!=""){
        cont1=$("#txtAmountToApplyAllC").val();
    }
    if($("#txtAmountToApplyAllC2").val()!=""){
        cont2=$("#txtAmountToApplyAllC2").val();
    }
    $.each(myArray2,function(key, value){
        $("#txtEmpCon_"+value).val(cont1);
        $("#txtEyrCon_"+value).val(cont2);
    });
});
/* save the form after validate */
        $("#editBtn").click(function() {
            if($("#basetrnyes").val()!="1"){
                if(erndedcon!=0){
            $("input.clsAmount").each(function(){
                $(this).rules("add", {
                    required: true,
                    number:true,
                    messages: {
                        required: '<?php echo __("This field is required.") ?>',
                        number: '<?php echo __("Please  enter a number") ?>'
                    }


                });

            });
            
      }
      }
  
  
//            }


        $('#tabs > div').each(function(i){

            var $shown = $(this).find('.errortd').filter(function() {
                var dpy = $(this).css('display');
                return !dpy || dpy != 'none';
            });
            if($shown.length > 0)
                $("#tabs").tabs('select', i);


        });
 
      if($('#cmbTransType').val() == ""){
             alert("<?php echo __("Please select the Transaction type."); ?>");
      } else if($('#cmbTransDetails').val() == ""){
            alert("<?php echo __("Please select Transaction detail."); ?>");      
      } else if(myArray2.length == 0){
                  alert("<?php echo __("Please select employee."); ?>");
      }else{
        $('#frmSaveAssignEmployee').submit();
      }
    });


    for(i=0;i<myArray2.length;i++){

        var fromDate="#txtFromDate_"+myArray2[i];
        var toDate="#txtToDate_"+myArray2[i];

        $(fromDate).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
        $(toDate).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
    }

    selectedIndex=$('#tabs').tabs().tabs('option', 'selected');
    if(selectedIndex==0){
        $("#empRepPopBtn").hide();
    }else{
        $("#empRepPopBtn").show();
    }
    $( "#tabs" ).tabs({
        select: function(event, ui) {
            if(ui.index==0){
                $("#empRepPopBtn").hide();
            }else{
                $("#empRepPopBtn").show();
            }
        }
    });


    if($("#cmbTransType").val()!=" "){
        changeTransType($("#cmbTransType").val());

        $("#cmbTransDetails option").each(function(){

            if ($(this).val() == "<?php echo $transDetailId ?>"){
                $(this).attr("selected","selected");
            }
        });

    }
    //hide the TD from date Todate
    if(typeType!=0){
        $("#tdFromDate").hide();
        $("#tdToDate").hide();
        $("#tdFromDateAdd").hide();
        $("#tdToDateAdd").hide();
        $(".tdFromDateValue").hide();
        $(".tdToDateValue").hide();

    }

   $('#empRepPopBtn').click(function() {

        if($("#cmbTransType").val() && $("#cmbTransDetails").val()){
            var popup=window.open("<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee') ?>" + "?type=multiple&method=SelectEmployee&payroll=payroll",'Locations','height=450,width=800,resizable=1,scrollbars=1');

            if(!popup.opener) popup.opener=self;
            popup.focus();
        }else{
            alert("<?php echo __("Please select the Transaction type and Transaction detail."); ?>");
        }

    });

    // search period 
    $("#btnSearchPerid").click(function(){
                                       
        var searchPeriodFromdate=$("#txtSearchFromdate").val();
        var searchPeriodTodate=$("#txtSearchTodate").val();
        var transTypeId=$("#cmbTransType").val();
        var transDetailId=$("#cmbTransDetails").val();

        location.href="<?php echo url_for('payroll/AssignEmployees?transTypeId=') ?>"+transTypeId+"/transDetailId/"+transDetailId+"/fromdate/"+searchPeriodFromdate+"/toDate/"+searchPeriodTodate;


                                            


    });

if($("#basetrnyes").val()=="1"){ 
            $("#typeA").hide();
            $("#typeB").hide();
            $("#typeA").hide();
           // $("#tbody").attr("disabled", true);
    //        $("#tbody").find("input[type='text']").attr("disabled", "disabled");
              $("#tbody").find("input[type='text']").attr('readonly', true);        
//             $("#addemp").find("input,button,textarea").attr("disabled", "disabled");    

}
});



function addtoGrid(empid){

    var transferDetailType=$("#cmbTransDetails").val();

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


);if(u==0){

    }

    $.post(

    "<?php echo url_for('payroll/LoadAssignEmployees') ?>", //Ajax file

                                        

    { 'empid[]' : arraycp, 'erndedcon':erndedcon,transferDetailType:transferDetailType},  // create an object will all values

    //function that is called when server returns a value.
    function(data){


        //var childDiv;
        var childdiv="";
        var i=0;
        if(data == ""){
                alert("<?php echo __("Some Employees are already assigned to this transaction."); ?>");
            }

        $.each(data, function(key, value) {
//            if(data == ""){
//                alert("sd");
//            }
        
            var word=value.split("|");
            var diable='<?php echo $disabled; ?>';

            childdiv="<tr id='' class='even'>";
            childdiv+="<td>";
            childdiv+=word[0];
            childdiv+="</td>";

            childdiv+="<td style='width:150px;'>";
            childdiv+="<input type='hidden'   name='hiddenEmp_"+word[3]+"' id='hiddenEmp_"+word[3]+"' value="+word[3]+" />";
            childdiv+=word[1];
            childdiv+="</td>";

            childdiv+="</td>";
           if(erndedcon!=0){
            childdiv+="<td style='width:75px;'>";
            if(erndedcon!=1){
            childdiv+="<input type='text' style='width:75px;' class='clsAmount' id='txtAmount_"+word[3]+"' name='txtAmount_"+word[3]+"'";
            }else{
            childdiv+="<input type='text' style='width:75px;' class='clsAmount' id='txtAmount_"+word[3]+"' name='txtAmount_"+word[3]+"' value='"+word[4]+"' ";

            }
            childdiv+="</td>";
            }

            if(typeType==0){
                // from date
                childdiv+="<td>";
                childdiv+="<input type='text' style='width:100px;' id='txtFromDate_"+word[3]+"' name='txtFromDate_"+word[3]+"'";
                childdiv+="</td>";

                // to date
                childdiv+="<td>";
                childdiv+="<input type='text' style='width:100px;' id='txtToDate_"+word[3]+"' name='txtToDate_"+word[3]+"'";
                childdiv+="</td>";
            }

            if(erndedcon==0){
            
            childdiv+="<td style='width:75px;'>";
            childdiv+="<input type='text' style='width:75px;' class='' id='txtEmpCon_"+word[3]+"' name='txtEmpCon_"+word[3]+"' value='"+word[5]+"'";
            childdiv+="</td>";

            childdiv+="<td style='width:75px;'>";
            childdiv+="<input type='text' style='width:75px;' class='' id='txtEyrCon_"+word[3]+"' name='txtEyrCon_"+word[3]+"' value='"+word[6]+"'";
            childdiv+="</td>";
            }
            childdiv+="<td style='width:75px;'>";
            childdiv+="<input type='checkbox' name='chkEnable_"+word[3]+"' id='chkEnable_"+word[3]+"' value='1' checked='checked' />";
            childdiv+="</td>";


            childdiv+="</tr>";
            //

            $('#tbodyAddEmployee').append(childdiv);


            k=i;
            i++;
            var fromDate="#txtFromDate_"+word[3];
            var toDate="#txtToDate_"+word[3];

            $(fromDate).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
            $(toDate).datepicker({ dateFormat: '<?php echo $inputDate ?>',changeYear: true,changeMonth: true });
           
        });
        
},

//How you want the data formated when it is returned from the server.
"json"

);
setTimeout("disableevt()", 1000);


}

function disableevt(){ 

if($("#basetrnyes").val()=="1"){
//$("#addemp").find("input,button,textarea").attr("disabled", "disabled");
//$("#addemp").find("input,button,textarea").attr('readonly', true);
$("#addemp").find("input[type='text']").attr('readonly', true);

//$("#addemp").find("input").text("0.00");
}
}
</script>

<!--<div id="something">
    <label class="errortd" style="display: none; ">This field is required 1.</label>
    <label class="errortd" >This field is required 2.</label>
    <label class="errortd" style="display: none; ">This field is required 3.</label>
</div>-->