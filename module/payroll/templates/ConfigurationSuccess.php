<?php //echo $LockID; echo "-".$UnlockID;
$encrypt = new EncryptionHandler();

require_once '../../lib/common/LocaleUtil.php';
$sysConf = OrangeConfig::getInstance()->getSysConf();
$sysConf = new sysConf();
$inputDate = $sysConf->dateInputHint;
$format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">
        <style type="text/css">
            div.formpage4col input[type="text"]{
                width: 180px;
            }
        </style>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Configuration") ?></h2></div>
<?php echo message() ?>
<?php echo $form['_csrf_token']; ?>
        <form name="frmSave" id="frmSave" method="post"  action="">

            <br class="clear"/>
            <div class="leftCol" >
                <label for="txtLocationCode"><?php echo __("Year") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol" id="cmbYear">
                <select id="cmbYear" name="cmbYear" class="formSelect" style="width: 150px;" tabindex="4" 
                        onchange="setdata(this.value);" 
                        >
                    <option value=""><?php echo __("--Select--") ?></option>
<?php for ($i = 0; $i < 50; $i++) { ?>
                        <option value="<?php echo $i + 2010; ?>" <?php if (($i + 2010) == $CmbYear) {
        echo "selected=selected";
    } ?> ><?php
                    echo $i + 2010;
                    ?></option>
                        <?php } ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol" >
                <label for="txtLocationCode"><?php echo __("System") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol" >
                <select id="cmbDistrict" name="cmbDistrict" class="formSelect" style="width: 150px;" tabindex="4"  >
                    <option value=""><?php echo __("--Select--") ?></option>
<?php foreach ($ProvinceList as $Province) {
    if ($Employee->hie_code_2 == $Province->id) { ?>
                            <option value="<?php echo $Province->id; ?>" <?php if ($Province->id == $Employee->hie_code_2) {
                        echo "selected=selected";
                    } if ($Province->id == $CmbYear) {
                        echo "selected=selected";
                    } ?> ><?php
                        echo $Province->title;
                        ?></option>
    <?php }
} ?>
                </select>
            </div>


            <br class="clear"/>
<!--            <div class="leftCol" >
                <label for="txtLocationCode"><?php echo __("Division") ?></label>
            </div>
            <div class="centerCol" >
                <select id="cmbDivision" name="cmbDivision" class="formSelect" style="width: 150px;" tabindex="4"  >
                    <option value=""><?php echo __("--Select--") ?></option>
                        <?php
                        foreach ($DivisionList as $Division) {
                            if ($Employee->hie_code_3 == $Division->parnt) {
                                if ($Employee->Users->def_level <= 3 && $Division->id == $Employee->hie_code_4) {
                                    ?>
                                <option value="<?php echo $Division->id; ?>" <?php if ($Division->id == $Employee->hie_code_4) {
                        echo "selected=selected";
                    } if ($Division->id == $CmbYear) {
                        echo "selected=selected";
                    } ?> ><?php
                    echo $Division->title;
                    ?></option>
        <?php }
    }
} ?>
                </select>
            </div>-->

            <br class="clear"/>
            <div id="bulkemp" >

                <!--                <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 250px; border-style:  solid; border-color: #FAD163; ">
                                    <div style="">
                                        <div class="centerCol" style='width:150px; background-color:#FAD163;'>
                                            <label class="languageBar" style="margin-left:10px; width:150px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Period") ?></label>
                                        </div>
                                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                                            <label class="languageBar" style="margin-left:10px; width:90px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Lock / Unlock") ?></label>
                                        </div>
                                        
                                    </div>
                                    <br class="clear"/>
                                
                <?php for ($i = 1; $i < 13; $i++) { ?>
                                         <div style="margin-left:10px; margin-top: 8px; width: 240px;">
                                            <div class="centerCol" style='width:150px; '>
                                                <label  style="width:150px; padding-left:2px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px;  color:#444444;"><?php echo __("Period") ?></label>
                                            </div>
                                            <div class="centerCol" style='width:90px;'>
                                                <label  style="width:90px; padding-left: 0px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>
                                            </div>
                                             
                                        </div>
                                        <br class="clear"/>
<?php } ?>
                -->

            </div>
            <div id="legend" style="float: right;width: 150px;">
                <table border="0" >
                    <tr>
                        <td style="background-color: #FFA500; width: 20px"></td>
                        <td><?php echo __("Processed") ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #000000;"></td>
                        <td><?php echo __("Not Processed") ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #FF0000;"></td>
                        <td><?php echo __("Locked") ?></td>
                    </tr>
                </table>
            </div>  	
            <br class="clear"/>

            <div class="formbuttons">
  <!--            <input type="submit" class="clearbutton" id="btnCreate" tabindex="5"
                     value="<?php echo __("Create"); ?>" onclick="loaddata();" />-->
                <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />

            </div>
            <br class="clear"/>
            <br class="clear"/>
            <!--        <div class="formbuttons">
                        <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                               value="<?php echo __("Reset"); ?>" />
                        
                    </div>-->
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">
    var CmbYear;
    function setdata(data){
        CmbYear=data;
        loaddata();
    }
    
    function lockunlockPeriod(id,Type){
        var LockID="<?php echo $LockID; ?>";
        var UnlockID="<?php echo $UnlockID; ?>";
        if(Type=='Lock'){
            if(id==LockID){
                answer = confirm("<?php echo __("Do you really want to Lock?") ?>"); 
            }else{
                alert("<?php echo __("Please Lock the previous pay peroid(s).") ?>");
                return false;
            }
        }else{
        
            if(id==UnlockID){
                answer = confirm("<?php echo __("Do you really want to Unlock?") ?>"); 
            }else{
                alert("<?php echo __("Please Unlock the last locked pay peroid.") ?>");
                return false;
            }

        }
        
        if (answer !=0)
        { 
            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('payroll/AjaxConfiguarationLockUnlockPeriod') ?>",
                data: { id: id , Type: Type},
                dataType: "json",
                success: function(data){
                    alert("<?php echo __('Successfully Updated') ?>");  
                    location.href="<?php echo url_for('payroll/Configuration?CmbYear=') ?>"+CmbYear;  
                }
            });
        }
        else{
            return false;
        }

    }
    
    
    function loaddata(){
        var compcode;
        if(CmbYear!= ''){

            if($('#cmbDistrict').val()!=''){
                compcode=$('#cmbDistrict').val();
            }else{
//                "<?php if ($Employee->Users->def_level <= 2) { ?>"
//                    compcode="<?php echo $Employee->hie_code_3 ?>";
//                
//                    "<?php } else { ?>";
//                    compcode="<?php echo $Employee->hie_code_4 ?>";
//                    "<?php } ?>"
                alert("Please Select System");
            }
               

            $('#bulkemp').empty();
            var html="";
            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('payroll/AjaxConfiguarationLoadPeriod') ?>",
                data: { Year: CmbYear , compcode : compcode  },
                dataType: "json",
                success: function(data){                
                    html+="<div id='employeeGrid' class='centerCol' style='margin-left:10px; margin-top: 8px; width: 300px; border-style:  solid; border-color: #FAD163; '>";
                    html+="<div style=''>";
                    html+="<div class='centerCol' style='width:200px; background-color:#FAD163;'>";
                    html+="<label class='languageBar' style='margin-left:10px; width:200px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;'><?php echo __("Period") ?></label>";
                    html+="</div><div class='centerCol' style='width:100px;   background-color:#FAD163;'>";
                    html+="<label class='languageBar' style='margin-left:10px; width:90px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Lock / Unlock") ?></label>";
                    html+="</div></div><br class='clear'/>";
                    $.each(data, function(key, value) {

                        html+="<div style='margin-left:10px; margin-top: 8px; width: 300px;'>";
                        html+="<div class='centerCol' style='width:200px; '>";

                        if(value.pay_sch_disabled_flg!=0){
                            html+="<label style='width:200px; padding-left:2px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px;  '>";
                            html+="<strike style='";
                            if(value.pay_sch_processed_flg!=null){
                                html+="color:#FF0000";
                            }else{
                                html+="color:#FF0000";    
                            }
                            html+="'><span style='";
                            if(value.pay_sch_processed_flg!=null){
                                html+="color:#FFA500";
                            }else{
                                html+="color:#444444";    
                            }
                            html+="'>"+value.pay_sch_st_date+" - "+value.pay_sch_end_date+"</span></strike>";
                        }else{
                            html+="<label style='width:200px; padding-left:2px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px;  color:#444444;'>"; 
                            html+="<span style='";
                            if(value.pay_sch_processed_flg!=null){
                                html+="color:#FFA500";
                            }else{
                                html+="color:#444444";    
                            }
                            html+="'>"                      
                            html+=value.pay_sch_st_date+" - "+value.pay_sch_end_date;
                        }
                        html+="</span></label></div><div class='centerCol' style='width:90px;'>";

                        //html+="<label  style='width:90px; padding-left: 0px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px; color:#444444; text-align:inherit'>";
                        if(value.pay_sch_disabled_flg!=0){
                            html+="<a href='#' style='width:50px;' onclick='lockunlockPeriod(";
                            html+=value.pay_sch_id;
                            html+=",\"Unlock\")'><?php echo __('Unlock') ?></a>";
                        }else{
                            html+="<a href='#' style='width:50px;' onclick='lockunlockPeriod(";
                            html+=value.pay_sch_id;
                            html+=",\"Lock\")'><?php echo __('Lock') ?></a>"; 
                        }
                        html+="</div></div><br class='clear'/>";

                        //alert(value.pay_sch_end_date);
                    });
                    $('#bulkemp').append(html);
                }
            
            });
        }else{
            alert("<?php echo __('Please Select Year') ?>"); 
            return false;
        }
        
    }
    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
        if("<?php echo $CmbYear ?>"){
            CmbYear="<?php echo $CmbYear ?>";
            loaddata();
        }
        //When click reset buton
        $("#btnClear").click(function() {
            // Set lock = 0 when resetting table lock
            location.href="<?php echo url_for('payroll/Configuration?id=' . $encrypt->encrypt($EmployeePayroll->emp_number) . '&lock=0') ?>";
        });
    });
                   
</script>
