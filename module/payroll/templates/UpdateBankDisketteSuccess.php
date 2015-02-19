<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
        $encrypt = new EncryptionHandler();
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery.placeholder.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.simplemodal.js') ?>"></script>
<script type="text/javascript">

var Header=0;
var Detail=0;
var Footer=0;
var JArray1= new Array();
var JArray2= new Array();
var JArray3= new Array();

</script>
    <?php

                    $sysConf = OrangeConfig::getInstance()->getSysConf();
                    $inputDate = $sysConf->getDateInputHint();
                    $dateDisplayHint = $sysConf->dateDisplayHint;
                    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<div id="dialog" title="<?php echo __("Add Field"); ?>">
    <div id="test">


    </div>
</div>

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
        <div class="mainHeading"><h2><?php echo __("Bank Diskette") ?></h2></div>
            <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("English") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Sinhala") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Tamil") ?></label>
            </div>
            <br class="clear"/>

             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Bank Diskette Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtBankDisketteName"  name="txtBankDisketteName" type="text"  class="formInputText" value="<?php echo $BankDiskette->dsk_name; ?>" maxlength="200" />
            </div>


            <div class="centerCol">
                <input id="txtBankDisketteNameSi"  name="txtBankDisketteNameSi" type="text"  class="formInputText" value="<?php echo $BankDiskette->dsk_name_si; ?>" maxlength="200" />

            </div>
            <div class="centerCol">
                <input id="txtBankDisketteNameTa"  name="txtBankDisketteNameTa" type="text"  class="formInputText" value="<?php echo $BankDiskette->dsk_name_ta; ?>" maxlength="200" />

            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Bank Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                 <select name="cmbBank" class="formSelect"  tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($BankList as $Bank) {
 ?>
                            <option value="<?php echo $Bank->bank_code ?>" <?php if($Bank->bank_code== $BankDiskette->bank_code){ echo " selected=selected"; }  ?> ><?php
                            if ($myCulture == 'en') {
                                $abcd = "bank_name";
                            } else {
                                $abcd = "bank_name_" . $myCulture;
                            }
                            if ($Bank->$abcd == "") {
                                echo $Bank->bank_name." --> ".$Bank->bank_user_code;
                            } else {
                                echo $Bank->$abcd." --> ".$Bank->bank_user_code;
                            }                            
                    ?></option>
<?php                     } ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Data Source") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol" >
                 <select name="cmbView" class="formSelect"  tabindex="4" onchange="Loadcolumns(this.value);">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php if($ViewList){ foreach ($ViewList as $View) {
 ?>
                            <option value="<?php echo $View['table_name'] ?>" <?php if($View['table_name'] == $BankDiskette->dsk_view){ echo " selected=selected"; }  ?> ><?php
                            echo $View['table_name'];
                    ?></option>
<?php                     } }?>
                </select>
            </div>
            <br class="clear">

            <div class="leftCol">
                <label class="controlLabel" ><?php echo __("Start Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input class="formInputText" id="txtfromdate"  type="text" name="txtfromdate" value="<?php echo LocaleUtil::getInstance()->formatDate($BankDiskette->dsk_start_date); ?>" />
            </div>

            <div class="centerCol">
                <label class="controlLabel" ><?php echo __("End Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input  class="formInputText" id="txttodate"  type="text" name="txttodate" value="<?php echo LocaleUtil::getInstance()->formatDate($BankDiskette->dsk_end_date); ?>" />
            </div>
            <br class="clear"/>
            <br class="clear"/>
            <hr>
            <div><input type="checkbox" name="chkActveHeader" id="chkActveHeader"  value="1" <?php if($EmployeeBankDetails[0]->ebank_active_flag=="1"){ echo "checked";  }  ?> style="margin-left: 0px; margin-top: 0px; " /></div>
            
            <div style="float: left; margin-top: 0px;"><h4 style="width: 650px; "><?php echo __("Header") ?></h4></div><div class="centerCol" style="float:right; width: 100px; padding-top: 20px;" ><input type="button" class="backbutton" id="btnAddHeader"  
                                                                                                                                    value="<?php echo __("Add") ?>" tabindex="18"  onclick="addField(1);"/><input type="button" class="backbutton" id="btndelHeader" style="margin-top: 5px;"  
                                                                                                                                    value="<?php echo __("Remove") ?>" tabindex="18"  onclick="deleteCRow(1);"/> </div>
                

            

                <div id="Header" >
                    <?php 
                    foreach ($ListBankDetail as $Header) {
                        if ($Header->dskd_column == "1") {

                            if ($Header->dskd_type == "1") {
                                ?>

                                <input class='formInputText' type='text' maxlength="<?php echo $Header->dskd_length; ?>" id="txtCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" name="txtCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" value="<?php echo $Header->dskd_value; ?>" />
                            <?php }
                            if ($Header->dskd_type == "2") {
                                ?>
                                     
                                <select class='formSelect' id="cmbCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" name="cmbCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" 
                                    <?php echo $disabled; ?> >
                                                                    
                                    <option value=''><?php echo __('--Select--'); ?></option>
                                    <?php  foreach ($ColumnList as $Column) { ?>
                                        <option value='<?php echo $Header->dskd_value; ?>'
                                        <?php
                                        if ($Header->dskd_value == $Column['Field']) {
                                            echo "selected=selected";
                                        }
                                        ?>
                                        ><?php echo $Column['Field']; ?></option>
                                    
                                    
                                    
                                    
                                <?php } } ?>
                                </select>
                            <?php 
                         ?>
<script type="text/javascript">
Header="<?php echo $Header->dskd_order; ?>";
JArray1["1",Header]= "1"+"_"+Header+"_"+"<?php echo $Header->dskd_type; ?>"+"_"+"<?php echo $Header->dsk_detail_type; ?>"+"_"+"<?php echo $Header->dskd_length; ?>"+"_"+"<?php echo $Header->dskd_alignment; ?>"+"_"+"<?php echo $Header->dskd_fillwith; ?>";
Header++;
</script>                        
                 <?php    }}
                    ?>
            
            </div>
            <br class="clear"/>
            <hr>
            <div><input type="checkbox" name="chkActveDetail" id="chkActveDetail"  value="1" <?php if($EmployeeBankDetails[0]->ebank_active_flag=="1"){ echo "checked";  }  ?> style="margin-left: 0px; margin-top: 0px; " /></div>
            
            <div style="float: left; margin-top: 0px;"><h4 style="width: 650px; "><?php echo __("Detail") ?></h4></div><div class="centerCol" style="float:right; width: 100px; padding-top: 20px;" ><input type="button" class="backbutton" id="btnAddDetail"  
                                                                                                                                    value="<?php echo __("Add") ?>" tabindex="18"  onclick="addField(2);"/><input type="button" class="backbutton" id="btndelDetail" style="margin-top: 5px;"  
                                                                                                                                    value="<?php echo __("Remove") ?>" tabindex="18"  onclick="deleteCRow(2);"/> </div>

            <div id="Detail">
            
                                    <?php 
                    foreach ($ListBankDetail as $Header) {
                        if ($Header->dskd_column == "2") {

                            if ($Header->dskd_type == "1") {
                                ?>

                                <input class='formInputText' type='text' maxlength="<?php echo $Header->dskd_length; ?>" id="txtCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" name="txtCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" value="<?php echo $Header->dskd_value; ?>" />
                            <?php }
                            if ($Header->dskd_type == "2") {
                                ?>
                                     
                                <select class='formSelect' id="cmbCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" name="cmbCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" 
                                    <?php echo $disabled; ?> >
                                                                    
                                    <option value=''><?php echo __('--Select--'); ?></option>
                                    <?php  foreach ($ColumnList as $Column) { ?>
                                        <option value='<?php echo $Header->dskd_value; ?>'
                                        <?php
                                        if ($Header->dskd_value == $Column['Field']) {
                                            echo "selected=selected";
                                        }
                                        ?>
                                        ><?php echo $Column['Field']; ?></option>
                                    
                                    
                                    
                                    
                                <?php }  ?>
                                </select>
                            <?php }
                        
                        ?>
<script type="text/javascript">
Detail="<?php echo $Header->dskd_order; ?>";
JArray2["2",Detail]= "2"+"_"+Detail+"_"+"<?php echo $Header->dskd_type; ?>"+"_"+"<?php echo $Header->dsk_detail_type; ?>"+"_"+"<?php echo $Header->dskd_length; ?>"+"_"+"<?php echo $Header->dskd_alignment; ?>"+"_"+"<?php echo $Header->dskd_fillwith; ?>";
Detail++;
</script>                        
                 <?php
                    } }
                    ?>
                
            </div>
            <br class="clear"/>
            <hr>
<div><input type="checkbox" name="chkActveFooter" id="chkActveFooter"  value="1" <?php if($EmployeeBankDetails[0]->ebank_active_flag=="1"){ echo "checked";  }  ?> style="margin-left: 0px; margin-top: 0px; " /></div>
            
            <div style="float: left; margin-top: 0px;"><h4 style="width: 650px; "><?php echo __("Footer") ?></h4></div><div class="centerCol" style="float:right; width: 100px; padding-top: 20px;" ><input type="button" class="backbutton" id="btnAddFooter"  
                                                                                                                                                                                                        value="<?php echo __("Add") ?>" tabindex="18"  onclick="addField(3);"/><input type="button" class="backbutton" id="btndelFooter" style="margin-top: 5px;"  
                                                                                                                                    value="<?php echo __("Remove") ?>" tabindex="18"  onclick="deleteCRow(3);"/> </div>

            
            <div id="Footer">
            
                                    <?php 
                    foreach ($ListBankDetail as $Header) {
                        if ($Header->dskd_column == "3") {

                            if ($Header->dskd_type == "1") {
                                ?>

                                <input class='formInputText' type='text' maxlength="<?php echo $Header->dskd_length; ?>" id="txtCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" name="txtCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" value="<?php echo $Header->dskd_value; ?>" />
                            <?php }
                            if ($Header->dskd_type == "2") {
                                ?>
                                     
                                <select class='formSelect' id="cmbCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" name="cmbCol_<?php echo $Header->dskd_column; ?>_<?php echo $Header->dskd_order; ?>" 
                                    <?php echo $disabled; ?> >
                                                                    
                                    <option value=''><?php echo __('--Select--'); ?></option>
                                    <?php  foreach ($ColumnList as $Column) { ?>
                                        <option value='<?php echo $Header->dskd_value; ?>'
                                        <?php
                                        if ($Header->dskd_value == $Column['Field']) {
                                            echo "selected=selected";
                                        }
                                        ?>
                                        ><?php echo $Column['Field']; ?></option>
                                    
                                    
                                    
                                    
                                <?php }  ?>
                                </select>
                            <?php }
                         
                        ?>
<script type="text/javascript">
Footer="<?php echo $Header->dskd_order; ?>";
JArray3["3",Footer]= "3"+"_"+Footer+"_"+"<?php echo $Header->dskd_type; ?>"+"_"+"<?php echo $Header->dsk_detail_type; ?>"+"_"+"<?php echo $Header->dskd_length; ?>"+"_"+"<?php echo $Header->dskd_alignment; ?>"+"_"+"<?php echo $Header->dskd_fillwith; ?>";
Footer++;
</script>                        
                 <?php
                    }}
                    ?>
            </div>
            <br class="clear"/>
            <hr>

            <br class="clear"/>
            <br class="clear"/>
            <input type='hidden' name='txtJArray1' id='txtJArray1' value=""/>
            <input type='hidden' name='txtJArray2' id='txtJArray2' value=""/>
            <input type='hidden' name='txtJArray3' id='txtJArray3' value=""/>
            <input type='hidden' name='txtDisketteID' id='txtDisketteID' value="<?php echo $BankDiskette->dsk_id;?>"/>
            
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
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">
var position;
if("<?php echo $ViewList[0]['table_name']; ?>"){
var Viewname="<?php echo $ViewList[0]['table_name']; ?>";
}else{
var Viewname;    
}
//var Header=0;
//var Detail=0;
//var Footer=0;
//var JArray1= new Array();
//var JArray2= new Array();
//var JArray3= new Array();




jQuery("#dialog").dialog({

                bgiframe: true, autoOpen: false, position: 'center', minWidth:300, maxWidth:300, modal: true
            });

                            function calclick(){
                               var pos;
                              
                               if(position==1){
                                       pos="Header"; 
                                       var stingcol=$("#cmbTxtDB_"+position+"_"+Header).val();                               
                                       var DataType=$("#cmbDataType_"+position+"_"+Header).val();
                                       var Length=$("#txtLength_"+position+"_"+Header).val();
                                       var Alignment=$("#cmbAlignment_"+position+"_"+Header).val();
                                       var RMN=$("#cmbRMN_"+position+"_"+Header).val();
                                       JArray1[position,Header]= position+"_"+Header+"_"+stingcol+"_"+DataType+"_"+Length+"_"+Alignment+"_"+RMN;
                                       if(Length==''){
                                           alert("<?php echo __("Please Enter Field Length"); ?>");
                                           return false;
                                       }if(isNaN(Length)){
                                           alert("<?php echo __("Invalid Field Length"); ?>");
                                           return false;
                                       }
                                       
                                       
                               }else if(position==2){
                                       pos="Detail";  
                                       var stingcol=$("#cmbTxtDB_"+position+"_"+Detail).val();                               
                                       var DataType=$("#cmbDataType_"+position+"_"+Detail).val();
                                       var Length=$("#txtLength_"+position+"_"+Detail).val();
                                       var Alignment=$("#cmbAlignment_"+position+"_"+Detail).val();
                                       var RMN=$("#cmbRMN_"+position+"_"+Detail).val();
                                       
                                       JArray2[position,Detail]=position+"_"+Detail+"_"+stingcol+"_"+DataType+"_"+Length+"_"+Alignment+"_"+RMN;
                                       if(Length==''){
                                           alert("<?php echo __("Please Enter Field Length"); ?>");
                                           return false;
                                       }if(isNaN(Length)){
                                           alert("<?php echo __("Invalid Field Length"); ?>");
                                           return false;
                                       }
                                        
                                       
                               }else if(position==3){
                                       pos="Footer";   
                                       var stingcol=$("#cmbTxtDB_"+position+"_"+Footer).val();                               
                                       var DataType=$("#cmbDataType_"+position+"_"+Footer).val();
                                       var Length=$("#txtLength_"+position+"_"+Footer).val();
                                       var Alignment=$("#cmbAlignment_"+position+"_"+Footer).val();
                                       var RMN=$("#cmbRMN_"+position+"_"+Footer).val();
                                       JArray3[position,Footer]= position+"_"+Footer+"_"+stingcol+"_"+DataType+"_"+Length+"_"+Alignment+"_"+RMN;
                                       
                                       if(Length==''){
                                           alert("<?php echo __("Please Enter Field Length"); ?>");
                                           return false;
                                       }if(isNaN(Length)){
                                           alert("<?php echo __("Invalid Field Length"); ?>");
                                           return false;
                                       }
                                       
                                       
                               }
                    
                               if(stingcol=='2'){
                               $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('payroll/AjaxLoadColumn') ?>",
                                    data: { id: Viewname },
                                    dataType: "json",
                                     success: function(data){
                                         //alert(data);
                                     var selectbox="<select class='formSelect'";
                                     if(position==1){
                                     selectbox=selectbox +" id='cmbCol_"+position+"_"+Header+"' name='cmbCol_"+position+"_"+Header+"' ";
                                     Header++;
                                 }else if(position==2){
                                         selectbox=selectbox +" id='cmbCol_"+position+"_"+Detail+"' name='cmbCol_"+position+"_"+Detail+"' ";
                                         Detail++;
                                 }else if(position==3){
                                         selectbox=selectbox +" id='cmbCol_"+position+"_"+Footer+"' name='cmbCol_"+position+"_"+Footer+"' ";
                                         Footer++;
                                 }    
                                    selectbox=selectbox +'<?php echo $disabled; ?>';
                                     selectbox=selectbox +"><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                                    $.each(data, function(key, value) {
                                        
                                        //var word=value.split("|");
                                        var sltid="<?php //echo $promotion->slt_id; ?>";
                                        selectbox=selectbox +"<option value='"+value['Field']+"'";
                                        if(value['Field']== sltid){
                                          selectbox=selectbox +"selected=selected";  
                                        }
                                        selectbox=selectbox +">"+value['Field']+"</option>";
                                    });
                                    selectbox=selectbox +"</select>";
                                    
                                   $('#'+pos).append(selectbox);
                                      }
                                });
                               }else if(stingcol=='1'){
                                    var selectbox="<input class='formInputText' type='text' maxlength="+Length+"";
                                    if(position==1){
                                     selectbox=selectbox +" id='txtCol_"+position+"_"+Header+"' name='txtCol_"+position+"_"+Header+"' ";
                                        Header++;
                                    }else if(position==2){
                                         selectbox=selectbox +" id='txtCol_"+position+"_"+Detail+"' name='txtCol_"+position+"_"+Detail+"' ";
                                         Detail++;
                                 }else if(position==3){
                                         selectbox=selectbox +" id='txtCol_"+position+"_"+Footer+"' name='txtCol_"+position+"_"+Footer+"' ";
                                         Footer++;
                                 }                                     
                                     selectbox=selectbox +" />";
                                    $('#'+pos).append(selectbox);
                               }
                               
                               $('#dialog').dialog('close');
                               if(Header > 0){
                                    $('#btndelHeader').show();
                                }
                               if(Detail > 0){
                                    $('#btndelDetail').show();
                                }
                               if(Footer > 0){
                                    $('#btndelFooter').show();
                                }
                            }
                            
                        function deleteCRow(id){

                        var answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                        if (answer !=0)
                        {
                            var search;
                            switch(id){
                                   case 1:
                                        Header--;
                                        search=id+"_"+Header;
                                        $("#cmbCol_"+id+"_"+Header).remove();
                                        $("#txtCol_"+id+"_"+Header).remove();
                                        removeByValuePart(JArray1, search);
                                    break;
                                    case 2:
                                        Detail--;
                                        search=id+"_"+Detail;
                                        $("#cmbCol_"+id+"_"+Detail).remove();
                                        $("#txtCol_"+id+"_"+Detail).remove();
                                        removeByValuePart(JArray2, search);
                                    break;
                                    case 3:
                                        Footer--;
                                        search=id+"_"+Footer;
                                        $("#cmbCol_"+id+"_"+Footer).remove();
                                        $("#txtCol_"+id+"_"+Footer).remove();
                                        removeByValuePart(JArray3, search);
                                    break;    
                            }          



                            if($("#txtDisketteID").val()!=""){
                                $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('payroll/AjaxDisketteColumnDelete') ?>",
                                    data: { diskid: $("#txtDisketteID").val(), search: search},
                                    dataType: "json",
                                    success: function(data){

                                    }
                                });       
                            }
                            
                            if(Header == 0){
                                    $('#btndelHeader').hide();
                                }
                               if(Detail == 0){
                                    $('#btndelDetail').hide();
                                }
                               if(Footer == 0){
                                    $('#btndelFooter').hide();
                                }
                            
                            
                        }
                        else{
                            return false;
                        }
                        } 
                               
                         function removeByValuePart(arr, val) {
                                for(var i=0; i<arr.length; i++) {
                                    var array=arr[i];

                                    if(array.search(val)==0){                                        
                                        arr.splice(i, 1);
                                        break;
                                    }

                                }
                            }      
           
                            
                            
                            function addField(id){
                                position=id;
                                var title;
                                var dhtmlday="";
                                var DataType="<?php echo "Column Data Type" ?>";
                                switch(id){
                                    case 1:
                                      title = "Header"; 
                                dhtmlday+="<table class='data-table'>";
                                
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Text/DB Column"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbTxtDB_"+position+"_"+Header+"' name='cmbTxtDB_"+position+"_"+Header+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Text"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("DB Column"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Data Type"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbDataType_"+position+"_"+Header+"' name='cmbDataType_"+position+"_"+Header+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Text"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Numeric"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td  class='' width='200px;' hight='10px;'><?php echo __("Length"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"   /></td><td class='' width='100px;'>";
                                dhtmlday+="<input id='txtLength_"+position+"_"+Header+"' name='txtLength_"+position+"_"+Header+"' class='formInputText' type='text' maxlength='2' /></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Data Alignment"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbAlignment_"+position+"_"+Header+"' name='cmbAlignment_"+position+"_"+Header+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Right"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Left"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Fill Value"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbRMN_"+position+"_"+Header+"' name=='cmbRMN_"+position+"_"+Header+"' >";
                                dhtmlday+="<option value='1'><?php echo __("Space"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Zero"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="</table> <br> <input type='button' class='backbutton' id='btncal'value='<?php echo __("OK") ?>' onclick='calclick();'>";
                                
                                $("#test").empty();
                                $("#test").append(title+dhtmlday);
                                      break;
                                    case 2:
                                      title = "Detail";
                                 dhtmlday+="<table class='data-table'>";
                                
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Text/DB Column"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbTxtDB_"+position+"_"+Detail+"' name='cmbTxtDB_"+position+"_"+Detail+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Text"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("DB Column"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Data Type"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbDataType_"+position+"_"+Detail+"' name='cmbDataType_"+position+"_"+Detail+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Text"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Numeric"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td  class='' width='200px;' hight='10px;'><?php echo __("Length"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+" /></td><td class='' width='100px;'>";
                                dhtmlday+="<input id='txtLength_"+position+"_"+Detail+"' name='txtLength_"+position+"_"+Detail+"' class='formInputText' type='text' maxlength='2' /></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Data Alignment"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbAlignment_"+position+"_"+Detail+"' name='cmbAlignment_"+position+"_"+Detail+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Left"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Right"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Fill Value"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbRMN_"+position+"_"+Detail+"' name=='cmbRMN_"+position+"_"+Detail+"' >";
                                dhtmlday+="<option value='1'><?php echo __("Zero"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Space"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="</table> <br> <input type='button' class='backbutton' id='btncal'value='<?php echo __("OK") ?>' onclick='calclick();'>";
                                
                                $("#test").empty();
                                $("#test").append(title+dhtmlday);
                                      break;
                                    case 3:
                                      title = "Footer";
                                dhtmlday+="<table class='data-table'>";
                                
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Text/DB Column"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbTxtDB_"+position+"_"+Footer+"' name='cmbTxtDB_"+position+"_"+Footer+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Text"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("DB Column"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Data Type"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbDataType_"+position+"_"+Footer+"' name='cmbDataType_"+position+"_"+Footer+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Text"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Numeric"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td  class='' width='200px;' hight='10px;'><?php echo __("Length"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"  /></td><td class='' width='100px;'>";
                                dhtmlday+="<input id='txtLength_"+position+"_"+Footer+"' name='txtLength_"+position+"_"+Footer+"' class='formInputText' type='text' maxlength='2' /></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Data Alignment"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbAlignment_"+position+"_"+Footer+"' name='cmbAlignment_"+position+"_"+Footer+"'>";
                                dhtmlday+="<option value='1'><?php echo __("Left"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Right"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="<tr ><td class='' width='200px;' hight='10px;'><?php echo __("Fill Value"); ?><input type='hidden' name='lbl' id='lbl' value="+DataType+"/></td><td class='' width='100px;'><select  id='cmbRMN_"+position+"_"+Footer+"' name=='cmbRMN_"+position+"_"+Footer+"' >";
                                dhtmlday+="<option value='1'><?php echo __("Zero"); ?></option>";
                                dhtmlday+="<option value='2'><?php echo __("Space"); ?></option>";
                                dhtmlday+="</select></td></tr>";
                                dhtmlday+="</table> <br> <input type='button' class='backbutton' id='btncal'value='<?php echo __("OK") ?>' onclick='calclick();'>";
                                
                                $("#test").empty();
                                $("#test").append(title+dhtmlday);
                                      break;
                                }
                                

                                jQuery('#dialog').dialog('open');
                            }

                            function Loadcolumns(id){
                                Viewname=id;
                                
                                }

    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
<?php if ($editMode == true) { ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>
    
    $("#txtfromdate").datepicker({ dateFormat:'<?php echo $inputDate; ?>' });
    $("#txttodate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
                              
$('#Header').hide();
$('#btnAddHeader').hide();
$('#btndelHeader').hide();
$('#Detail').hide();
$('#btnAddDetail').hide();
$('#btndelDetail').hide();
$('#Footer').hide();
$('#btnAddFooter').hide();
$('#btndelFooter').hide();

  <?php   if($BankDiskette->dsk_detail_type=="9"){ ?>
            
            $('#chkActveHeader').attr('checked', true);
            $('#chkActveDetail').attr('checked', true);
            $('#chkActveFooter').attr('checked', true);
            $('#Header').show();
            $('#btnAddHeader').show();
            if(Header > 0){
            $('#btndelHeader').show();
            }
            $('#Detail').show();
            $('#btnAddDetail').show();
            if(Detail > 0){
            $('#btndelDetail').show();
            }
            $('#Footer').show();
            $('#btnAddFooter').show();
            if(Footer > 0){
            $('#btndelFooter').show();
            }
  <?php   } else if($BankDiskette->dsk_detail_type=="7"){ ?>
            $('#chkActveDetail').attr('checked', true);
            $('#chkActveFooter').attr('checked', true);
            $('#Detail').show();
            $('#btnAddDetail').show();
            if(Detail > 0){
            $('#btndelDetail').show();
            }
            $('#Footer').show();
            $('#btnAddFooter').show();
            if(Footer > 0){
            $('#btndelFooter').show();
            }
  <?php   } else if($BankDiskette->dsk_detail_type=="6"){ ?>
            $('#chkActveHeader').attr('checked', true);
            $('#chkActveFooter').attr('checked', true);
            $('#Header').show();
            $('#btnAddHeader').show();
            if(Header > 0){
            $('#btndelHeader').show();
            }
            $('#Footer').show();
            $('#btnAddFooter').show();
            if(Footer > 0){
            $('#btndelFooter').show();
            }
  <?php   } else if($BankDiskette->dsk_detail_type=="5"){ ?>
            $('#chkActveHeader').attr('checked', true);
            $('#chkActveDetail').attr('checked', true);
            $('#Header').show();
            $('#btnAddHeader').show();
            if(Header > 0){
            $('#btndelHeader').show();
            }
            $('#Detail').show();
            $('#btnAddDetail').show();
            if(Detail > 0){
            $('#btndelDetail').show();
            }
  <?php   } else if($BankDiskette->dsk_detail_type=="2"){ ?>
            $('#chkActveHeader').attr('checked', true);
            $('#Header').show();
            $('#btnAddHeader').show();
            if(Header > 0){
            $('#btndelHeader').show();
            }
  <?php   } else if($BankDiskette->dsk_detail_type=="3"){ ?>
            $('#chkActveDetail').attr('checked', true);
            $('#Detail').show();
            $('#btnAddDetail').show();
            if(Detail > 0){
            $('#btndelDetail').show();
            }
  <?php   } else if($BankDiskette->dsk_detail_type=="4"){ ?>
            $('#chkActveFooter').attr('checked', true);
            $('#Footer').show();
            $('#btnAddFooter').show();
            if(Footer > 0){
            $('#btndelFooter').show();
            }
  <?php   } ?>      
     
     $("input[name='chkActveHeader']").change(function(){
         
            if ($(this).attr("checked")) {
                $('#Header').show();
                $('#btnAddHeader').show();
                if(Header > 0){
                $('#btndelHeader').show();
                }

            }
            else{
                $('#Header').hide();
                $('#btnAddHeader').hide();
                $('#btndelHeader').hide();

            }

        });
        
        $("input[name='chkActveDetail']").change(function(){
         
            if ($(this).attr("checked")) {
                $('#Detail').show();
                $('#btnAddDetail').show();
                if(Detail > 0){
                $('#btndelDetail').show();
                }

            }
            else{
                $('#Detail').hide();
                $('#btnAddDetail').hide();
                $('#btndelDetail').hide();

            }

        });
        
        $("input[name='chkActveFooter']").change(function(){
         
            if ($(this).attr("checked")) {
                $('#Footer').show();
                $('#btnAddFooter').show();
                if(Footer > 0){
                $('#btndelFooter').show();
                }

            }
            else{
                $('#Footer').hide();
                $('#btnAddFooter').hide();
                $('#btndelFooter').hide();

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
                         
                         $('#dialog').hide();

                       //Validate the form
                       $("#frmSave").validate({

            rules: {
                
                txtBankDisketteName: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtBankDisketteNameSi: {noSpecialCharsOnly: true, maxlength:200 },
                txtBankDisketteNameTa: {noSpecialCharsOnly: true, maxlength:200 },
                cmbBank:{required: true},
                cmbView:{required: true},
                txttodate:{required: true, orange_date: true},
                txtfromdate:{required: true, orange_date: true}
                
                
            },
            messages: {
                
                txtBankDisketteName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBankDisketteNameSi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtBankDisketteNameTa:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                cmbBank:{required:"<?php echo __("This field is required") ?>"},
                cmbView:{required:"<?php echo __("This field is required") ?>"},
                txttodate:{required:"<?php echo __("This field is required") ?>",orange_date: "<?php echo __("Please specify valid date"); ?>"},
                txtfromdate:{required:"<?php echo __("This field is required") ?>",orange_date: "<?php echo __("Please specify valid date"); ?>"}

            }
        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('payroll/UpdateBankDiskette?id=' . $encrypt->encrypt($BankDiskette->dsk_id) . '&lock=1') ?>";
                           }
                           else {
                               $('#txtJArray1').val(JArray1);
                               $('#txtJArray2').val(JArray2);
                               $('#txtJArray3').val(JArray3);
                               var Startdate=$("#txtfromdate").val();
                               var Enddate=$("#txttodate").val();
                               if(Startdate > Enddate){
                                   alert("<?php echo __("Invalid Start Date or End Date") ?>");
                                   return false;
                               }
                               $('#frmSave').submit();
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/BankDiskette')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           <?php if($BankDiskette->dsk_id!= null){ ?>
                               location.href="<?php echo url_for('payroll/UpdateBankDiskette?id=' . $encrypt->encrypt($BankDiskette->dsk_id) . '&lock=0') ?>";
                           <?php }else{ ?>
                               location.href="<?php echo url_for('payroll/UpdateBankDiskette') ?>";
                           <?php } ?>
                           
                       });
                   });
</script>
