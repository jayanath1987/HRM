<?php
    //if ($lockMode == '1') {
    //    $editMode = false;
    //    $disabled = '';
    //} else {
    //    $editMode = true;
    //    $disabled = 'disabled="disabled"';
    //}
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery.placeholder.js') ?>"></script>
<?php
$sysConf = OrangeConfig::getInstance()->getSysConf();
$inputDate = $sysConf->getDateInputHint();
$dateDisplayHint = $sysConf->dateDisplayHint;
$format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>

<div class="formpage4col">
    <div class="navigation">
    </div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Employee Transaction Details") ?></h2></div>
        <?php echo message() ?>
        <br class="clear"/>
        <form name="frmSave" id="frmSave" method="post"  action="" >
            <div class="leftCol">
                <label class="controlLabel" ><?php echo __("Start Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input class="formInputText" id="fromdate"  type="text" name="txtfromdate" value="<?php echo LocaleUtil::getInstance()->formatDate($EmployeeBankDetails[0]->ebank_start_date); ?>" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" ><?php echo __("End Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input  class="formInputText" id="todate"  type="text" name="txttodate" value="<?php echo LocaleUtil::getInstance()->formatDate($EmployeeBankDetails[0]->ebank_end_date); ?>" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" ><?php echo __("Employee Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input class="formInputText" type="text" name="txtEmployeeName"  disabled="disabled" id="txtEmployee" value="<?php
        if ($myCulture == 'en') {
            $abcd = "emp_display_name";
        } else {
            $abcd = "emp_display_name_" . $myCulture;
        }
        if ($Employee->$abcd == "") {
            echo $Employee->emp_display_name;
        } else {
            echo $Employee->$abcd;
        }
        ?>" readonly="readonly"/>
                <input type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $etid; ?>"/>
            </div>
            <div class="centerCol" id ="emp_div">
                <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; ?> style="margin-top: 10px; " />
            </div>
            <br class="clear"/>
<div class="leftCol">
                <label class="controlLabel" ><?php echo __("Employee ID") ?></label>
            </div>
            <div class="centerCol">
                <input class="formInputText" type="text" name="lblnic"  disabled="disabled" id="lblnic" value="<?php echo $Employee->employeeId; ?>" readonly="readonly"/>
            </div>
            <br class="clear"/>
            <br class="clear"/>
            <br class="clear"/>
            

<!--            <div class="formbuttons">
                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                       value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="reset" class="clearbutton" id="btnClear" 
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />

<?php //if ($btn != "new") { ?>

                    <input type="button" class="clearbutton" id="btnadd" 
    <?php //echo $disabled;  ?>
                           value="<?php echo __("Add"); ?>" />
<?php //} ?>

            </div>-->
        </form>
   

    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>

<?php
require_once '../../lib/common/LocaleUtil.php';
$sysConf = OrangeConfig::getInstance()->getSysConf();
$sysConf = new sysConf();
$inputDate = $sysConf->dateInputHint;
$format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<script type="text/javascript">
    // <![CDATA[
    function multipledelete(row){
        for(var i=0; i<row; i++ ){
            var btn="del_"+i;
            buttonSecurityCommon("null","null","editBtn",btn);

        }
    }
    
    function LoadEmployeeTransaction(id){
        var FromDate = $("#fromdate").val();
        var ToDate = $("#todate").val();
        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('payroll/AjaxEmployeeTransaction') ?>",
            data: { id: id , fdate: FromDate, tdate: ToDate},
            dataType: "json",
             success: function(data){

//             var selectbox="<select class='formSelect' id='cmbBranch' name='cmbBranch' style='width: 160px;'";
            //selectbox=selectbox +'<?php echo $disabled; ?>';
//             selectbox=selectbox +"><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
//            $.each(data, function(key, value) {
//                var word=value.split("|");
//                var sltid="<?php echo $promotion->slt_id; ?>";
//                selectbox=selectbox +"<option value='"+word[0]+"'";
//                if(word[0]== sltid){
//                  selectbox=selectbox +"selected=selected";  
//                }
//                selectbox=selectbox +">"+word[1]+"</option>";
//            });
//            selectbox=selectbox +"</select>";
//
//           $('#DivBranch').html(selectbox);
        consloe.log(data);
              }
        });
        }


    function LoadGradeSlot(id){

        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('payroll/AjaxLoadBranch') ?>",
            data: { id: id },
            dataType: "json",
             success: function(data){

             var selectbox="<select class='formSelect' id='cmbBranch' name='cmbBranch' style='width: 160px;'";
            //selectbox=selectbox +'<?php echo $disabled; ?>';
             selectbox=selectbox +"><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
            $.each(data, function(key, value) {
                var word=value.split("|");
                var sltid="<?php echo $promotion->slt_id; ?>";
                selectbox=selectbox +"<option value='"+word[0]+"'";
                if(word[0]== sltid){
                  selectbox=selectbox +"selected=selected";  
                }
                selectbox=selectbox +">"+word[1]+"</option>";
            });
            selectbox=selectbox +"</select>";

           $('#DivBranch').html(selectbox);
              }
        });
        }

    function AjaxADateConvert(date){

        var day;
        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('retirement/AjaxADateConvert') ?>",
            data: { date: date },
            dataType: "json",
            success: function(data){day = data.date;}
        });
        return day;
    }


    function SelectEmployee(data){


        myArr = data.split('|');
        $("#txtEmpId").val(myArr[0]);
        $("#txtEmployee").val(myArr[1]);
        LoadCurrentDep1();
        sendValue($("#txtEmpId").val());
        sendValue2($("#txtEmpId").val());
        LoadEmployeeTransaction(myArr[0]);
        //var emp=$("#txtEmpId").val();
        //location.href="<?php echo url_for('payroll/EmployeeBankDetails?id=') ?>"+emp;


    }
    //function LoadCurrentDep(){
        //sendValue($("#txtEmpId").val());
        //sendValue2($("#txtEmpId").val());
    //}
    function LoadCurrentDep1(){

        EMPID($("#txtEmpId").val());
    }
    function EMPID(str){
                                $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('payroll/AjaxCall') ?>",
                                    data: { sendValue: str },
                                    dataType: "json",
                                    success: function(data){ 
                                        $("#lblnic").val(data);
                                    }
                                    
                            });

                            }
    function sendValue2(str){

        $.getJSON(

        "<?php echo url_for('payroll/AjaxCalllast') ?>",  //Ajax file

        { sendValue2: str },  // create an object will all values

        //function that is called when server returns a value.
        function(data){
            var No=Number(data);
            No+=1;
            $("#txtAccountOrder").val(No);
        },

        //How you want the data formated when it is returned from the server.
        "json"
    );

    }




    function sendValue(str){
        $.getJSON(

        "<?php echo url_for('payroll/AjaxEmployeeBankDetails') ?>", //Ajax file

        { sendValue: str },  // create an object will all values

        //function that is called when server returns a value.
        function(data){ 

            var list="<table cellpadding='0' cellspacing='0' class='data-table'>";
            list+="<tbody><thead><tr><td width='30'>";
            list+="</td>";

            list+="<td scope='col' style='width: 100px'>";
            list+="<?php echo __('Bank Name') ?>";
            list+="</td>";

            list+="<td  scope='col' style='width: 100px'>";
            list+="<?php echo __('Branch Name') ?>";
            list+="</td>"

            list+="<td scope='col' style='width: 100px'>";
            list+="<?php echo __('Account Number') ?>";
            list+="</td>";

            list+="<td scope='col' style='width: 110px'>";
            list+="<?php echo __('Account Type') ?>";
            list+="</td>";

            list+="<td scope='col' style='width: 250px'>";
            list+="<?php echo __('Amount') ?>";
            list+="</td>";
                                    
            list+="<td scope='col' style='width: 100px'>";
            list+="<?php echo __('Order') ?>";
            list+="</td>";

            list+="</tr>";
            list+="</thead><tbody>";

            var row=0;
            var css='even';
            $.each(data, function(key, value) { 
                css=(row % 2 ?'even':'odd');
                var myArr2 = value.split('|');


                var com=value.comment;
                list+="<tr class="+css+"><td  width='30'></td>";
                list += "<td ><a href= '<?php echo url_for('payroll/EmployeeBankDetails?empno=') ?>"+myArr2[0]+"?branchcode="+myArr2[7]+"&accno="+myArr2[8]+"&acctype="+myArr2[9]+"'>"+myArr2[1]+"</a></td><td>"+myArr2[2]+"</td><td>"+myArr2[3]+"</td><td>"+myArr2[4]+"</td><td>"+myArr2[5]+"</td>";
                list += "<td>"+myArr2[6]+"</td>";
                list += "<td ><a  id='del_"+row+"' onClick='deleteconf("+myArr2[0]+","+myArr2[7]+","+myArr2[8]+","+myArr2[9]+");' ><?php echo __("Delete") ?></a></td></tr>";

                row+=1;
            });
                                    
            list+="</tbody>";


            $('#fpp').html(list);
            multipledelete(row);
            "json"
        });

    }
    function deleteconf(empno,branchcode,accno,acctype){
        answer = confirm("<?php echo __("Do you really want to Delete?") ?>");
        if (answer !=0)
        {
            window.location ="<?php echo url_for('payroll/DeleteEmployeeBankDetails?empno=') ?>"+empno+"?branchcode="+branchcode+"&accno="+accno+"&acctype="+acctype;
                        
        }

    }
    $(document).ready(function() {
 //$("#emp_div").hide();
        $("#fromdate").placeholder();
        $("#todate").placeholder();
        buttonSecurityCommon("null","null","editBtn","del");
        $("#fromdate").datepicker({ dateFormat:'<?php echo $inputDate; ?>' });
        $("#todate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
                               
<?php if ($editMode == true) { ?> <?php if ($btn == "new") {
        $editMode = 0; ?>//alert("<?php echo $editMode; ?>");
                                $('#editBtn').val("<?php echo __("Save") ?>");
                                $('#frmSave :input').attr('disabled', false);
                                $("#frmSave").data('edit')== 0;
                                //$("#emp_div").show();
                                $('#btnBack').removeAttr('disabled');
    <?php } else { ?>
        //$("#emp_div").hide();
                        $('#frmSave :input').attr('disabled', true);
                        $('#editBtn').removeAttr('disabled');
                        $('#btnBack').removeAttr('disabled');
                        $('#btnadd').removeAttr('disabled');

    <?php }
} ?>



        $('#empRepPopBtn').click(function() {
            if($("#fromdate").val()== "" || $("#todate").val() == "" ){
                alert("Please Enter valid Date Range");
            }else{
            var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
            if(!popup.opener) popup.opener=self;
            popup.focus();
            
            }
        });

        jQuery.validator.addMethod("orange_date",
        function(value, element, params) {

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
                txtEmployeeName:{required: true},
                cmbBank:{required: true },
                cmbBranch:{required: true },
                cmbAccountType:{required: true },
                txtAccountNo:{required: true, digits: true },
                txtAmount:{required: true ,number: true },
                txtAccountOrder:{required: true, number: true },
                txtfromdate: { orange_date:true,required: true },
                txttodate: { orange_date:true,required: true },
                txtcomment: { noSpecialCharsOnly: true ,maxlength:200 }

            },
            messages: {
                txtEmployeeName:"<?php echo __("Please Select the Employee Name") ?>",
                cmbBank:{required:"<?php echo __("This field is required") ?>" },
                cmbBranch:{required:"<?php echo __("This field is required") ?>" },
                cmbAccountType:{required:"<?php echo __("This field is required") ?>" },
                txtAccountNo:{required:"<?php echo __("This field is required") ?>", digits:"<?php echo __("Please Enter digit") ?>" },
                txtAmount:{required:"<?php echo __("This field is required") ?>", number:"<?php echo __("Please Enter Number") ?>" },
                txtAccountOrder:{required:"<?php echo __("This field is required") ?>", number:"<?php echo __("Please Enter Number") ?>" },
                txtfromdate: {orange_date: "<?php echo __("Please specify valid date"); ?>",required:"<?php echo __("This field is required") ?>"},
                txttodate: {orange_date: "<?php echo __("Please specify valid date"); ?>",required:"<?php echo __("This field is required") ?>"},
                txtcomment:{noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>"}

            }
        });


        // When click edit button

        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

        $("#editBtn").click(function() {
           <?php // if( $etid == null){ ?>
                  //$("#emp_div").hide();
            <?php //} ?>
                                 
            var editMode = $("#frmSave").data('edit');
            if (editMode == 1) {

                //location.href="<?php echo url_for('payroll/EmployeeBankDetails?empno=' . $EmployeeBankDetails[0]->emp_number . '&branchcode=' . $EmployeeBankDetails[0]->bbranch_code . '&accno=' . $EmployeeBankDetails[0]->ebank_acc_no . '&acctype=' . $EmployeeBankDetails[0]->acctype_id . '&lock=1') ?>";
                location.href="<?php echo url_for('payroll/EmployeeTransaction') ?>";
            }
            else {
                var startDate = $('#fromdate').val();
                var endDate = $('#todate').val();
                if(startDate > endDate){
                    alert("<?php echo __("Account Start date should be less than End date") ?>");
                    return false;
                }
                                        
                                        
                $('#frmSave').submit();
            }


        });

        //When click reset buton
        $("#btnClear").click(function() {
            //document.forms[0].reset();
            var emp=$("#txtEmpId").val();
            location.href="<?php echo url_for('payroll/EmployeeBankDetails?id=') ?>"+emp;
        });
                                
                                
       //When click reset buton
        $("#btnadd").click(function() {
            //document.forms[0].reset();
            var emp=$("#txtEmpId").val();
            location.href="<?php echo url_for('payroll/EmployeeBankDetails?id=') ?>"+emp;
        });
                                
                                

                                

});
// ]]>
</script>