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
            /*div.formpage4col select{
            width: 50px;
            }*/
            .paginator{

                padding-left: 50px;

            }

        </style>


    </div>
    <div id="status"></div>
    <div class="outerbox" style="width: 815px;">
        <div class="mainHeading"><h2><?php echo __("Bank Diskette Process") ?></h2></div>
        <?php echo message() ?>
        <?php echo $form['_csrf_token']; ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Start Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtStartDate"  name="txtStartDate" type="text"  class="formInputText" maxlength="10" value="<?php echo $hsPrBankDisketteProcess->bdp_start_date; ?>" <?php echo $disabled; ?> />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("End Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtEndDate"  name="txtEndDate" type="text"  class="formInputText" maxlength="10" value="<?php echo $hsPrBankDisketteProcess->bdp_end_date; ?>" <?php echo $disabled; ?> />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Payment Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtPaymentDate"  name="txtPaymentDate" type="text"  class="formInputText" maxlength="10" value="<?php echo $hsPrBankDisketteProcess->bdp_payment_date; ?>" <?php echo $disabled; ?> />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Bank Diskette") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select id="cmbBankDisk" name="cmbBankDisk" class="formSelect"  tabindex="4" onclick="cleardata()">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($BankDiskList as $Bank) {
                        ?>
                        <option value="<?php echo $Bank->dsk_id ?>" <?php
                    if ($Bank->dsk_id == $hsPrBankDisketteProcess->dsk_id) {
                        echo " selected=selected";
                    }
                        ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "dsk_name";
                            } else {
                                $abcd = "dsk_name_" . $myCulture;
                            }
                            if ($Bank->$abcd == "") {
                                echo $Bank->dsk_name;
                            } else {
                                echo $Bank->$abcd;
                            }
                        ?></option>
                    <?php } ?>
                </select>
            </div>

            <br class="clear"/>
            <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Work Station:") ?><span class="required">*</span></label></div>
            <div class="leftCol" style="padding-top: 4px">  <input class="button" type="button"  onclick="returnLocDet1()" value="..." id="divisionPopBtn" <?php echo $disabled; ?> />
                <label for="txtLocation" style="width: 2px;">
                    <input type="hidden" value="<?php echo $hsPrBankDisketteProcess->id; ?>" class="formInputText" name="txtNWorkStaion" id="txtNWorkStaion" />    
                </label>
            </div><br class="clear">

            <div id="Display2" style="width: 100px;">
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
                <div id="employeeGrid1" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 490px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Employee ID") ?></label>
                        </div>
                        <div class="centerCol" style='width:220px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:220px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Employee Name") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Division") ?></label>
                        </div>
                        <div class="centerCol" style='width:70px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:70px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>
                        </div>

                    </div>
                    <div id="tohide">


                    </div>
                    <br class="clear"/>

                </div>
            </div>



            <input  type="hidden" name="txtId" id="txtId" value="<?php echo $hsPrBankDisketteProcess->bdp_id; ?>"/>

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
                       <?php if ($hsPrBankDisketteProcess->bdp_id) { ?>

                    <input type="button" class="backbutton" id="btnCreate"
                           value="<?php echo __("Create Diskette") ?>"  onclick="CreateDiskette();"/>
                       <?php } ?>
            </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">
    var empIDMaster
    var myArray2= new Array();
    var empstatArray= new Array();
    var k;
    var pagination = 0;
    var itemsPerPage=10;
    
    
    function cleardata(){
        $("#Display2").empty();
        $("#txtNWorkStaion").val("");
        $('#tohide').empty();
        myArray2=new Array();
    }
            
    function CreateDiskette(){
        var Processid=$("#txtId").val();

                    
        var popup=window.open('<?php echo public_path('../../symfony/web/index.php/payroll/BankDisketteCreation?Processid='); ?>'+Processid,'Locations','height=450 ,width=400 ,resizable=1,scrollbars=1');
        if(!popup.opener) popup.opener=self;


    }
                            

           
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


    );if(u==0){

        }
        //                var courseId1=$('#courseid').val();
        //                if($("#txtId").val()=='__'){
        //                   var type='save';
        //                   var id=null;
        //                }else{
        //                    var type='update';
        //                    var id=$("#txtId").val();
        //                }
                
        $.post(

        "<?php echo url_for('payroll/LoadEmployeeDiskette') ?>", //Ajax file


        { 'empid[]' : arraycp  },  // create an object will all values

        //function that is called when server returns a value.
        function(data){
            if(data){

                //var childDiv;
                $('#tohide').empty();
                var childdiv="";
                var i=0;
                    
                $.each(data, function(key, value) {
                    var word=value.split("|");
                        
                    var diable='<?php echo $disabled; ?>';
                    childdiv="<div class='pagin' id='row_"+i+"' style='padding-top:10px;'>";
                    childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                    childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'>"+word[0]+"</div>";
                    childdiv+="</div>";

                    childdiv+="<div class='centerCol' id='master' style='width:220px;'>";
                    childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'>"+word[1]+"</div>";
                    childdiv+="</div>";
                                    
                    childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                    childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'>"+word[2]+"</div>";
                    childdiv+="</div>";
                                    

                    childdiv+="<div class='centerCol' id='master' style='width:70px;' >";
                    childdiv+="<div id='employeename' style='height:25px; padding-left:3px;'><a href='#' style='width:70px;'  onclick='deleteCRow("+i+","+word[3]+")'>";
                    //if($("#txtId").val()==''){
                    childdiv+="<?php echo __('Remove') ?>";
                    //}else{
                    //childdiv+="";   
                    //}
                    childdiv+="</a>";
                    childdiv+="<input type='hidden' name='hiddenEmpNumber[]' value="+word[3]+" >";
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

            } 
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
            if($("#txtId").val()!=""){
                $.ajax({
                    type: "POST",
                    async:false,
                    url: "<?php echo url_for('payroll/AjaxDisketteEmployeeDelete') ?>",
                    data: { diskid: $("#txtId").val(), emp_number: value},
                    dataType: "json",
                    success: function(data){
                                
                    }
                });       
            }
            $(function () {
                $("#tohide").depagination();
                $("#tohide").pagination();
            });

        }
        else{
            return false;
        }
    } 
                 
    function returnLocDet1(){

        // TODO: Point to converted location popup
        var popup=window.open('<?php echo public_path('../../symfony/web/index.php/admin/listCompanyStructure?mode=select_subunit&method=mymethod'); ?>','Locations','height=450 ,width=400 ,resizable=1,scrollbars=1');
        if(!popup.opener) popup.opener=self;
    }
    function mymethod(id,name){
        //$("#txtDivisionid").val(id);
        $("#txtNWorkStaion").val(id);
        DisplayEmpHirache(id,"Display2");
    }

    function DisplayEmpHirache(wst,div){
        $('#'+div).val("");
        var wst;
        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('payroll/DisplayEmpHirache') ?>",
            data: { wst: wst },
            dataType: "json",
            success: function(data){
                              
                var row="<table style='background-color:#FAF8CC; width:350px; boder:1'>";
                var temp=0;
                if(data.name10 !=null){
                    row+="<tr ><td style='width:300px'>"+data.nameLevel10+"-"+data.name10+"</td></tr>";
                    temp=1;}
                if(data.name9 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel9+"</label>-&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name9+"</td></tr>";
                    temp=1;
                }
                if(data.name8 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel8+"</label>-&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name8+"</td></tr>";
                    temp=1;
                }
                if(data.name7 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel7+"</label>-&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name7+"</td></tr>";
                    temp=1;
                }
                if(data.name6 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel6+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name6+"</td></tr>";
                    temp=1;
                }
                if(data.name5 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel5+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name5+"</td></tr>";
                    temp=1;
                }
                if(data.name4 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel4+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name4+"</td></tr>";
                    temp=1;
                }
                if(data.name3 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel3+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name3+"</td></tr>";
                    temp=1;
                }
                if(data.name2 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel2+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name2+"</td></tr>";
                    temp=1;
                }
                if(data.name1 !=null){
                    row+="<tr><td >";
                    if(temp==1){
                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel1+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                    }
                    row+=data.name1+"</td></tr>";
                    temp=1;
                }

                row+="</table>";
                $('#'+div).html(row);
               
                loadBankEmployee(wst);
            }
        });



    }
                                  

    function loadBankEmployee(wst){
        var bank = $('#cmbBankDisk').val();
             
        if(wst != null){
            if(wst < 100){                               
                process_type = 1;                
            }else{
                process_type = 2;        
            }
                   
        }
        var dis_code
        if(wst < 1500){
        dis_code = wst;
        }else{
         dis_code = null;
        }
        if(bank != "" && wst != null){
            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('payroll/AjaxBankEmployeeLoad') ?>",
                data: { bankName: bank,process_type :process_type,dis_code: dis_code  },
                dataType: "json",
                success: function(data){
                    SelectEmployee(data);                            
                }
            });           
        }          
      
    }


    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
        $("#txtStartDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
        $("#txtEndDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
        $("#txtPaymentDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
        
        SelectEmployee("<?php echo $emlist ?>");
        
        $('#empRepPopBtn').click(function() {
            
            if($('#txtDivisionid1').val()== ""){
                alert("<?php echo __("Please Select Division"); ?>");   
                return false;   
            }else if($('#cmbBankDisk').val()==''){
                alert("<?php echo __("Please Select Bankdiskette"); ?>");    
                return false;   
            }else {
                var popup=window.open("<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee') ?>" + "?type=multiple&method=SelectEmployee&payroll=payroll",'Locations','height=450,width=800,resizable=1,scrollbars=1');
                
                if(!popup.opener) popup.opener=self;
                popup.focus();
            }        });
        
<?php if ($editMode == true) { ?>
            $('#frmSave :input').attr('disabled', true);
            $('#editBtn').removeAttr('disabled');
            $('#btnBack').removeAttr('disabled');
<?php } ?>

        jQuery.validator.addMethod("orange_date",
        function(value, element, params) {

            //var hint = params[0];
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
                txtStartDate:{required: true,orange_date:true},
                txtEndDate:{required: true,orange_date:true},
                txtPaymentDate:{required: true,orange_date:true},
                cmbBankDisk:{required: true},
                txtNWorkStaion:{required: true}
            },
            messages: {
                
                txtStartDate:{required:"<?php echo __("This field is required") ?>",orange_date: "<?php echo __("Please specify valid date") ?>"},
                txtEndDate:{required:"<?php echo __("This field is required") ?>",orange_date: "<?php echo __("Please specify valid date") ?>"},
                txtPaymentDate:{required:"<?php echo __("This field is required") ?>",orange_date: "<?php echo __("Please specify valid date") ?>"},
                cmbBankDisk:{required:"<?php echo __("This field is required") ?>"},
                txtNWorkStaion:{required:"<?php echo __("This field is required") ?>"}
                

            }
        });
        
        
        DisplayEmpHirache("<?php echo $hsPrBankDisketteProcess->id; ?>","Display2");

        // When click edit button
        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

        $("#editBtn").click(function() {

            var editMode = $("#frmSave").data('edit');
            if (editMode == 1) {
                // Set lock = 1 when requesting a table lock

                location.href="<?php echo url_for('payroll/UpdateBankDisketteProcess?id=' . $encrypt->encrypt($hsPrBankDisketteProcess->bdp_id) . '&lock=1') ?>";
            }
            else {
                var Startdate=$("#txtStartDate").val();
                var Enddate=$("#txtEndDate").val();
                var Paymentdate=$("#txtPaymentDate").val();
                               
                if(Startdate > Enddate){
                    alert("<?php echo __("Invalid Start Date or End Date") ?>");
                    return false;
                }
                if(Startdate > Paymentdate){
                    alert("<?php echo __("Invalid Start Date or Payment Date") ?>");
                    return false;
                }
                if(Paymentdate > Enddate){
                    alert("<?php echo __("Invalid Payment Date or End Date") ?>");
                    return false;
                }
                               
                if(myArray2==false){
                    alert("<?php echo __('Please select at least one employee') ?>");
                    return false;
                }

                $('#frmSave').submit();
                               
            }


        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/UpdateBankDisketteProcess')) ?>";
        });

        //When click reset buton
        $("#btnClear").click(function() {
            // Set lock = 0 when resetting table lock
            location.href="<?php echo url_for('payroll/UpdateBankDisketteProcess?id=' . $encrypt->encrypt($hsPrBankDisketteProcess->bdp_id) . '&lock=0') ?>";
        });
    });
</script>
