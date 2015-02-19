<?php
$encrypt = new EncryptionHandler();
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">

        <?php
        $encryption = new EncryptionHandler();
        $sysConf = new sysConf();
        ?>
    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Employee Payroll Process") ?></h2></div>
        <form name="frmProcessEmployee" id="frmProcessEmployee" method="post" action="<?php echo url_for('payroll/StartProcess1') ?>">
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Payroll Type") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbPayrollType" id="cmbPayrollType" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($PayrollTypeList as $PayrollType) { ?>
                        <option value="<?php echo $PayrollType->prl_type_code ?>" <?php
                    if ($PayrollType->prl_type_code == $payrollType) {
                        echo " selected=selected";
                    }
                        ?> ><?php
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
                    <?php } ?>
                </select>
            </div>
            <div class="centerCol">
                 <label class="controlLabel" for="lblCode"><?php echo __("Select All") ?></label>
            </div> 
            <div class="centerCol">
                <input type='checkbox' value='1' id='chkAll' name='chkAll' checked onclick="toggleChecked(this.checked)"/>
            </div>    
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Current Process Period") ?></label>
            </div>
            <div class="centerCol" style="width:400px;">
                <label class="controlLabel" for="lblCode"><?php echo __("Start Date"); ?> : <?php echo $processUnlockStartDate; ?></label><label class="controlLabel" for="lblCode"><?php echo __("End Date"); ?> : <?php echo $processUnlockEndDate; ?></label>

                <input type="hidden" id="hiddenStartDate" name="hiddenStartDate" value="<?php echo $processUnlockStartDate; ?>"/>
                <input type="hidden" id="hiddenEndDate" name="hiddenEndDate" value="<?php echo $processUnlockEndDate; ?>"/>
            </div>
            <br class="clear"/>
            <div class="leftCol">
<!--                    <label class="controlLabel" for="lblCode"><?php echo __("Batch Id") ?></label>-->
            </div>
            <div class="centerCol">


                <input type="hidden" id="txtBatchId" name="txtBatchId" class="formInputText" value="<?php echo $batchId ?>"/>
            </div>
            <br class="clear"/>
            <div id="employeeGrid">
<!--                    <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>

                </thead>

                <tbody id="tbodyAddEmployee">


                </tbody>
            </table>-->
            </div>
        </form>
        <br class="clear"/>
        <div class="formbuttons">
            <input type="button" class="backbutton" id="empRepPopBtn"
                   value="<?php echo __("Add Employees") ?>" tabindex="10" />
            <input type="button" class="backbutton" id="processBtn"
                   value="<?php echo __("Process") ?>" tabindex="10" />
            <input type="button" class="backbutton" id="processEmpList"
                   value="<?php echo __("Processed Employees") ?>" tabindex="10" />
            <input type="button" class="backbutton" id="viewPEmpBtn"
                   value="<?php echo __("View Processed Details") ?>" tabindex="10" />
        </div>
        <br class="clear"/>
    </div>
</div>
<style>
    #employeeGrid{text-align:left}
    #employeeGrid div{display:inline-block;margin-top:10px;}
    #employeeGrid div{display:inline}
    #employeeGrid>div{display:inline-block}

</style>
<?php
$encrypt = new EncryptionHandler();
?>
<script type="text/javascript">

    var typeType;
    var erndedcon;
    var myArray2= new Array();
    var type;
    
    function SelectEmployee(data){

        myArr=new Array();
        lol=new Array();
        myArr = data.split('|');
        type=1;
        addtoGrid(myArr,type);
    }
function toggleChecked(status) { 
    $("#frmProcessEmployee input").each( function() {
    $(this).attr("checked",status);
    })
}

    $(document).ready(function() {

        var payrollType=$('#cmbPayrollType').val();
          var processType="<?php echo $system ;?>";
        // encrypt the payrolltype
        $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('disciplinary/AjaxEncryption') ?>",
                data: { empId: payrollType },
                dataType: "json",
                success: function(data){

                    payrollType=data;

                }
            });


        var startDate=$('#hiddenStartDate').val();
        var endDate=$('#hiddenEndDate').val();
        var comma="<?php echo $comma_separated ?>";
        if(comma==""){
           comma=myArray2;
        }
        var User="<?php echo $_SESSION['user'] ?>";
        var batchId="<?php echo $batchId ?>";
        var empNumber="<?php echo $_SESSION['empNumber'] ?>";
        var mode="<?php echo $mode; ?>";
        var pt= "<?php echo $pt; ?>";                       
        if(mode=='1'){
            
            var pb;
            //JBL ProgressBar
            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('payroll/ProgressBarValidation') ?>",
                data: { startDate:startDate,endDate:endDate,payrollType:pt,User:User },
                dataType: "json",
                success: function(data){
                         if(data==1){
                             pb=1;
                         }else{
                             pb=0;
                         }                                   
                 }
            });
            
            if(pb==0){
            //End ProgressBar
//                                    alert('hi');
            //location.href ="<?php echo url_for('payroll/TransActDetails?tDetailId==' . $encryption->encrypt($tDType->trn_dtl_code) . '&lock=0') ?>";
            var path="<?php echo url_for(''); ?>";
//            window.open("http://122.248.242.3/hrmintegration/process.php?comma="+comma+"&startDate="+startDate+"&endDate="+endDate+"&batchId="+batchId+"&empId="+User+"&prltype="+pt);
            window.open("http://localhost/MahaweliHRM/process.php?comma="+comma+"&startDate="+startDate+"&endDate="+endDate+"&batchId="+processType+"&empId="+User+"&prltype=1");
///            window.open("http://192.168.0.108/eSamudhiHRM/demo.php?comma="+comma,'name','height=50,width=500');
        }else{
            //alert("Pogress bar");
             $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('disciplinary/AjaxEncryption') ?>",
                data: { empId: pt },
                dataType: "json",
                success: function(data){

                    payrollType=data;

                }
            });
            var batchId=$('#txtBatchId').val();
            location.href="<?php echo url_for('payroll/ViewProcessedEmp?payrollType=') ?>"+payrollType+"/startDate/"+startDate+"/endDate/"+endDate+"/batchId/"+batchId;

        }
        }
                                
                                
         $("#processEmpList").click(function() {
            if($("#cmbPayrollType").val() != ""){
           $("#employeeGrid").html("");
            myArray2= new Array();
             var txtBatchId1=$("#txtBatchId").val();
              $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('payroll/getProcEmpByDate') ?>",
                data: { batchId: txtBatchId1,startDate:startDate,endDate:endDate,payrollType:payrollType },
                dataType: "json",
                success: function(data){
                  var tempArr= new Array();                                           
                 if(data.length > 0){
                    
                      $.each(data, function(index, value) {                                            
                    tempArr.push(value['emp_number']);
                    });
                   addtoGrid(tempArr,0); //0 means saved mode;
  
                 }
                                   }
            });

             }else{
              alert("Please select Payroll Type.");
                 }
           
          });

        $("#frmProcessEmployee").validate({

            rules: {
                cmbPayrollType:{required: true},
                txtBatchId: { required: true,noSpecialCharsOnly: true, maxlength:20 }

            },
            messages: {
                cmbPayrollType:{required:"<?php echo __("This field is required") ?>"},
                txtBatchId: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 20 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}

            }
        });

        $('#cmbPayrollType').change(function() {
          
            $("#employeeGrid").html("");
            myArray2= new Array();
           
            payrollType=$('#cmbPayrollType').val();

            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('disciplinary/AjaxEncryption') ?>",
                data: { empId: payrollType },
                dataType: "json",
                success: function(data){

                    payrollType=data;

                }
            });
             getEmployeeDefaultLoad(empNumber,payrollType,startDate,endDate);  
        });
                                
                               
        $("#processBtn").click(function() {
            var txtBatchId=$("#txtBatchId").val();
            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('payroll/IsBatchIdExsit') ?>",
                data: {
                    txtBatchId: txtBatchId,startDate:startDate,endDate:endDate
                },
                dataType: "json",
                success: function(data){
                    if(data.count>0){
                        alert("<?php echo __('Batch Id can not be duplicated'); ?>");

                    }else{
                        if(myArray2.length>0){
                            $("#frmProcessEmployee").submit();
                        }else{
                            alert("Please select an employee to process.");
                        }

                    }
                }
            });


        });

        $('#viewPEmpBtn').click(function() {
            var batchId=$('#txtBatchId').val();
            location.href="<?php echo url_for('payroll/ViewProcessedEmp?payrollType=') ?>"+payrollType+"/startDate/"+startDate+"/endDate/"+endDate+"/batchId/"+batchId;
//                                    window.open("http://www.google.com");
        });                        
        $('#empRepPopBtn').click(function() {

            if($("#cmbPayrollType").val()){
    
                var popup=window.open("<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee') ?>" + "?type=multiple&method=SelectEmployee&payroll=payroll&payrollType="+payrollType+"&locationWise="+processType+"&startDate="+startDate+"&endDate="+endDate,'Locations','height=450,width=800,resizable=1,scrollbars=1');
                //var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=multiple&method=SelectEmployee&reason=companyHead'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                if(!popup.opener) popup.opener=self;
                popup.focus();
            }else{
                alert("<?php echo __("Please select the Transaction type and Transaction detail."); ?>");
            }

        });

    });

    function getEmployeeDefaultLoad(empNumber,payrollType,startDate,endDate){
    $.ajax({
    type: "POST",
    async:false,
    url: "<?php echo url_for('payroll/PayrollEmployeeList') ?>",
    data: { empId:empNumber, payrollType:payrollType, locationWise:'locationWise', startDate:startDate,endDate:endDate },
    dataType: "json",
success: function(data){
       SelectEmployee(data.empList);
}
});
    }

    //alert(courseId);
    function addtoGrid(empid,type){
        //alert(myArray2);

        var arraycp=new Array();

        var arraycp = $.merge([], myArray2);

        var items= new Array();
        for(i=0;i<empid.length;i++){

            items[i]=empid[i];
        }

        var u=1;
        //myArray2[2] = 4;
        $.each(items,function(key, value){
            //alert(jQuery.inArray(value, myArray2));

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
                //// Find the index
                //alert(arraycp);
                if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!
                //alert("user already there");

                u=0;
                //alert(myArray2);
                //myArray2.push(value);
                //return false;
            }
            else{

                arraycp.push(value);

                //myArray2.push(value);


            }


        }


    );

        $.each(myArray2,function(key, value){
            //alert(jQuery.inArray(value, myArray2));

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
                //alert("user already there");
                u=0;
                //alert(myArray2);
                //myArray2.push(value);
                //return false;

            }
            else{

                //arraycp.push(value);




            }


        }


    );
        $.each(arraycp,function(key, value){
            myArray2.push(value);
        }


    );
        //alert("cp"+arraycp);
        //alert("my2"+myArray2);
        //alert(myArray2);
        if(u==0){
            // alert("user already exsits");
            //return false;
        }

        $.post(

        "<?php echo url_for('payroll/LoadGrid1') ?>", //Ajax file



{ 'empid[]' : arraycp },  // create an object will all values

//function that is c    alled when server returns a value.
function(data){
//alert(data);

//var childDiv;
var childDiv="";
var testDiv="";
var participated="";
var testDiv="";
var approved="";
var comment="";
var delete1="";
var rowstart="";
var rowend="";
var childdiv="";


$.each(data, function(key, value) {
i=Number($('#hiddeni').val())+1;

var word=value.split("|");


childdiv="<div  style='width:125px;' >";

              
childdiv+="<input type='hidden'  name='hiddenEmp_"+word[2]+"' id='hiddenEmp_"+word[2]+"' value="+word[2]+" />";
childdiv+=word[1];
childdiv+="</div>";

childdiv+="<div style='width:100px;'>";
childdiv+=word[0];
childdiv+="</div>";
if(type==0){
childdiv+="<div style='width:25px;'>";
childdiv+="<input type='checkbox' value='1' id='chkEnable_"+word[2]+"' name='chkEnable_"+word[2]+"' checked />";
childdiv+="</div>";
}else{
childdiv+="<div style='width:25px;'>";
childdiv+="<input type='checkbox' value='1' id='chkEnable_"+word[2]+"' name='chkEnable_"+word[2]+"' checked />";
childdiv+="</div>";
}

//
$('#employeeGrid').append(childdiv);
//
               

});


//$("#datehiddne1").val(data.message);
},

//How you want the data formated when it is returned from the server.
"json"

);


}

</script>
