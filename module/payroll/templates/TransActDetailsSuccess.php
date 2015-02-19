<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>

<script type="text/javascript">

<?php
if ($mode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>
    $(function() {
        $("#tabs").tabs();
    });
</script>

<div class="formpage4col">
    <div class="navigation">

        <?php
        $encryption = new EncryptionHandler();
        $sysConf = new sysConf();
        ?>
    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Transaction Detail Information") ?></h2></div>
        <?php echo message() ?>
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
                <label class="controlLabel" for="lblCode"><?php echo __("Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <?php
                if (strlen($tDType->trn_dtl_user_code)) {
                    $detailID = $tDType->trn_dtl_user_code;
                } else {
                    $detailID = $defaultTDId;
                }
                ?>
                <input id="txtTDID"  name="txtTDID" type="hidden"  class="formInputText" value="<?php echo $tDType->trn_dtl_code ?>"   />
                <input id="txtCode"  name="txtCode" type="text"  class="formInputText" value="<?php echo $detailID ?>"  maxlength="10" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Transaction type") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbTransType" id="cmbTransType" class="formSelect" style="width: 160px;" tabindex="4" onchange="changeTransType(this.value);">


                    <option value=""><?php echo __("--Select--") ?></option>
<?php foreach ($transTypeList as $list) { 
    
    if($Lockid== null){
        if($list->trn_typ_code!= "4"){
            ?>
                        <option value="<?php echo $list->trn_typ_code . "|" . $list->erndedcon . "|" . $list->trn_typ_type ?>"  <?php if ($tDType->trn_typ_code == $list->trn_typ_code)
        echo "selected" ?>><?php
    $abc = "trn_typ_name_" . $userCulture;
    if ($userCulture == "en") {
        echo $list->trn_typ_name;
    } else {
        if ($list->$abc == "") {
            echo $list->trn_typ_name;
        } else {
            echo $list->$abc;
        }
        }
   
        
        }
        
        }else{ ?>
                                <option value="<?php echo $list->trn_typ_code . "|" . $list->erndedcon . "|" . $list->trn_typ_type ?>"  <?php if ($tDType->trn_typ_code == $list->trn_typ_code)
        echo "selected" ?> readonly="readonly" ><?php
    $abc = "trn_typ_name_" . $userCulture;
    if ($userCulture == "en") {
        echo $list->trn_typ_name;
    } else {
        if ($list->$abc == "") {
            echo $list->trn_typ_name;
        } else {
            echo $list->$abc;
        }
        }
    }
    
    

}
?>

                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtName"  name="txtName" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_name; ?>"  maxlength="100"/>
            </div>
            <div class="centerCol">
                <input id="txtNameSi"  name="txtNameSi" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_name; ?>"  maxlength="100"/>
            </div>
            <div class="centerCol">
                <input id="txtNameTa"  name="txtNameTa" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_name; ?>"  maxlength="100"/>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Narration") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtNarrationName"  name="txtNarrationName" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_payslipnarration; ?>"  maxlength="100"/>
            </div>
            <div class="centerCol">
                <input id="txtNarrationNameSi"  name="txtNarrationNameSi" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_payslipnarration_si; ?>"  maxlength="100"/>
            </div>
            <div class="centerCol">
                <input id="txtNarrationNameTa"  name="txtNarrationNameTa" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_payslipnarration_ta; ?>"  maxlength="100"/>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Order on pay slip") ?> </label>
            </div>
            <div class="centerCol">
                <input id="txtOrderPaySlip"  name="txtOrderPaySlip" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_display_order; ?>"  maxlength="20"/>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Enable Proration") ?> </label>
            </div>
            <div class="centerCol">
                <input id="chkProration"  name="chkProration" type="checkbox"  class="formCheckbox" value="1" <?php if ($tDType->trn_dtl_isprorate_flg == 1)
                                    echo "checked" ?>   maxlength="100" />

            </div>

            <div class="centerCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Set as default transaction") ?> </label>
            </div>
            <div class="centerCol">
                <input id="chkDefaultTrans"  name="chkDefaultTrans" type="checkbox"  class="formCheckbox" value="1" <?php if ($tDType->trn_dtl_isdefault_flg == 1)
                                    echo "checked" ?>  maxlength="100"/>
            </div>

            <br class="clear"/>
            
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Check Print"); ?></label>
            </div>
            <div class="centerCol" style="width: 50px;">
                <input type="checkbox" name="chkappeal" id="chkappeal" class="formCheckbox" value="1" <?php
if ($tDType->trn_dtl_agent_bank_flg != null) {
    echo "checked";
}
?> /></div>           
                        <div id="DivAppeal">
                            <br class="clear"/>
                <div class="centerCol" style="width:150px; margin-top: 10px;">

                    <input type="radio" name="optAgent" style="margin-top: 0px;" class="formCheckbox" value="0" <?php
                            if ($tDType->trn_dtl_agent_bank_flg == "0") {
                                echo "checked";
                            }
                    ?> />&nbsp;<?php echo __("Agent") ?>
                </div>
                <div class="centerCol" style="width:150px; margin-top: 10px;">
                    <input type="radio" name="optAgent" style="margin-top: 0px;" class="formCheckbox" value="1" <?php
                           if ($tDType->trn_dtl_agent_bank_flg == "1") {
                               echo "checked";
                           }
                    ?> />&nbsp;<?php echo __("Bank") ?>
                </div>

                <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" id="lblbank"><?php echo __("Bank Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select style="width: 160px;" name="cmbBank"  class="formSelect" tabindex="4" onchange="LoadGradeSlot(this.value);">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($BankList as $Bank) { ?>
                        <option value="<?php echo $Bank->bank_code ?>" <?php if ($Bank->bank_code == $tDType->trn_dtl_bank_code) {
                            echo " selected=selected";
                        } ?> ><?php
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
<?php } ?>
                </select>
            </div>
            <br class="clear"/>

            <div class="leftCol" id="DivBranchlbl">
                <label class="controlLabel" ><?php echo __("Branch Name") ?> 
<!--                    <span class="required">*</span>-->
                </label>
            </div>
            <div class="centerCol" id="DivBranch">
                <select style="width: 160px;" name="cmbBranch"   tabindex="4"  class="formSelect" >
                    <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($BranchList as $Branch) {
                            ?>
                        <option value="<?php echo $Branch->bbranch_code ?>" <?php if ($Branch->bbranch_code == $tDType->trn_dtl_branch_code) {
                            echo " selected=selected";
                        } ?> ><?php
                        if ($myCulture == 'en') {
                            $abcd = "bbranch_name";
                        } else {
                            $abcd = "bbranch_name_" . $myCulture;
                        }
                        if ($Branch->$abcd == "") {
                            echo $Branch->bbranch_name." --> ".$Branch->bbranch_user_code;
                        } else {
                            echo $Branch->$abcd." --> ".$Branch->bbranch_user_code;
                        }
                        ?></option>
<?php } ?>
                </select>
            </div>

                <br class="clear"/>

                <div class="leftCol">
                    <label class="controlLabel" for="txtLocationCode"><?php echo __("Reference No") ?> </label>
                </div>
                <div class="centerCol">
                    <textarea class="formTextArea" id="ReferenceNo"  name="ReferenceNo"  style="width:150px;"><?php echo $tDType->trn_dtl_account_no; ?></textarea>
                </div>

            </div>
            
             <br class="clear"/>
            
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Enable ") ?> </label>
            </div>
            <div class="centerCol">
                <input id="chkProration"  name="chkEnable" type="checkbox"  class="formCheckbox" value="0" <?php if ($tDType->trn_disable_flg == 0)
                                    echo "checked" ?>   maxlength="100" />

            </div>
            <br class="clear"/>
            <br class="clear"/>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1"><?php echo __("Amount") ?></a></li>
                    <li><a href="#tabs-2"><?php echo __("Contribution") ?></a></li>
                    <li><a href="#tabs-3"><?php echo __("Base Txn") ?></a></li>

                </ul>
                <div id="tabs-1">
                    <p align="center"><?php echo __("Specify the amount payment type and the billing rate for the transaction"); ?> </p>

                    <span>
                        <table>
                            <tr>
                                <td width="125px;">
<?php echo __("Add amount to"); ?>
                                </td>
                                <td>
                                    <?php echo __("Net pay"); ?>
                                </td>
                                <td>
                                    <input id="optAddToPay"   name="optAddToPay" type="radio" <?php if ($tDType->trn_dtl_addtonetpay == 1)
                                        echo "checked"; ?>   value="1"  />
                                </td>
                                <td>
<?php echo __("Gross pay"); ?>
                                </td>
                                <td>
                                    <input id="optAddToPay"  name="optAddToPay" type="radio"  <?php if ($tDType->trn_dtl_addtonetpay == 0)
    echo "checked"; ?>  value="0" />
                                </td>
                            </tr>
                        </table>
                    </span>




                </div>
                <div id="tabs-2">
                    <p align="center"><?php echo __("Specify the transaction base to be considered for the contribution (check all that apply)"); ?> </p>

                    <div style="float:left">
                        <table>
                            <tr>
                                <td width="75px;">
<?php echo __("Employer %"); ?>
                                </td>
                                <td>
                                    <input id="txtEmplyr"  name="txtEmplyr" type="text" style="width:75px;"  class="formInputText" value="<?php echo $tDType->trn_dtl_eyrcont; ?>"  maxlength="10"/>
                                </td>
                                <td rowspan="2">

                                </td>
                            </tr>
                            <tr>
                                <td>
<?php echo __("Employee %"); ?>
                                </td>
                                <td>
                                    <input id="txtEmply"  name="txtEmply" type="text" style="width:75px;"   class="formInputText" value="<?php echo $tDType->trn_dtl_empcont; ?>"  maxlength="10"/>
                                </td>

                            </tr>
                        </table>

                    </div>

                    <div class="ex" id="ContributionDiv">

<?php
//                         $transActionService = new TransactionService();
//                         <?php print_r($sf_data->getRaw('contributeTypeIdByFilter'));
?>


<?php
foreach ($transTypeListByfilter as $list) {

//                            $contCodeBuTypeID=$transActionService->getcontTypeForFilter($TransActionDetailId,$transactionType);
//                            echo $contCodeBuTypeID[0]->trn_dtl_base_code;
    ?>
                            <input id="chkTransType" style="vertical-align:baseline" name="chkTransType[]" type="checkbox"   value="<?php echo $list->trn_dtl_code; ?>" <?php if (in_array($list->trn_dtl_code, $sf_data->getRaw('contributeTypeIdByFilter'), true))
                            echo "checked" ?> />

                                   <?php
                                   $abc = "trn_dtl_name_" . $userCulture;
                                   if ($userCulture == "en") {
                                       echo $list->trn_dtl_name;
                                   } else {
                                       if ($list->$abc == "") {
                                           echo $list->trn_dtl_name;
                                       } else {
                                           echo $list->$abc;
                                       }
                                   }


                                   echo "<br/>";
                                   ?>

                            <?php
                        }
                        ?>

                    </div>
                    <div id="notContributionDiv" class="ex">


<?php
$transActionService = new TransactionService();
foreach ($allContributionList as $list) {

    $contCodeBuTypeID = $transActionService->getcontCodeBuTypeID($TransActionDetailId, $list->trn_typ_code);
//
    ?>
                            <input id="chkTransType" style="vertical-align:baseline" name="chkTransType[]" type="checkbox"   value="<?php echo $list->trn_dtl_code; ?>" <?php if (in_array($list->trn_dtl_code, $sf_data->getRaw('contributeTypeId'), true))
                            echo "checked" ?> />

                                   <?php
                                   $abc = "trn_dtl_name_" . $userCulture;
                                   if ($userCulture == "en") {
                                       echo $list->trn_dtl_name;
                                   } else {
                                       if ($list->$abc == "") {
                                           echo $list->trn_dtl_name;
                                       } else {
                                           echo $list->$abc;
                                       }
                                   }


                                   echo "<br/>";
                                   ?>

                            <?php
                        }
                        ?>

                    </div>

                </div>
                <div id="tabs-3">


                    <div style="float:left; width: 350px;">
                        <input id="ChkIsbsTxn" style="vertical-align:baseline" name="ChkIsbsTxn" type="checkbox"   value="1" onclick="checkIsbaseTrn()" <?php if ($tDType->trn_dtl_isbasetxn_flg == 1)
                            echo "checked" ?>  /><?php echo __("Enable base transaction"); ?><br/><br/>
                        <p><?php echo __("Specify the transaction base to be considered for the contribution (check all that apply)"); ?></p>
                    </div>
                    <table>
                        <tr>
                            <td>
<?php echo __("Transaction"); ?>
                            </td>
                            <td width="60px;">

                            </td>
                            <td>
<?php echo __("Previous"); ?>
                            </td>
                        </tr>
                    </table>
                    <div class="ex" id="baseTypes">
                        <table>
                            <tr>

<?php
$transDao = new TransactionDao();

$counter = 0;
foreach ($transDetailsList as $list) {
    $isPrvisFlg = null;
    $isPrvisFlg = $transDao->getPrvflgByid($list->trn_dtl_code);

    $id = "chkTransTypeBsn_" . $counter;
    ?><tr>
                                    <td>
                                    <?php $test = $isPrvisFlg[0][trn_base_prev_flg] . "|" . $list->trn_dtl_code; ?>
                                        <input id="<?php echo $id ?>" style="vertical-align:baseline" name="chkTransTypeBsn[]" type="checkbox" class="basetsn"   value="<?php echo $test; ?>" onclick="checkPreviousFlg(this.id)" <?php if (in_array($list->trn_dtl_code, $sf_data->getRaw('baseTransListArr'), true))
                                    echo "checked" ?> />
                                    </td>
                                    <td width="100px;">
    <?php
    $abc = "trn_dtl_name_" . $userCulture;
    if ($userCulture == "en") {
        echo $list->trn_dtl_name;
    } else {
        if ($list->$abc == "") {
            echo $list->trn_dtl_name;
        } else {
            echo $list->$abc;
        }
    }
    ?>
                                    </td>
                                    <td>
    <?php
    $prviousId = "chkBsnPreivous_" . $counter;
    $hiddenId = "hidden_" . $counter;

    if ($isPrvisFlg[0][trn_base_prev_flg] == 1) {
        $val = 1;
    } else {
        $val = 0;
    }
    ?>
                                        <input id="<?php echo $prviousId; ?>" style="vertical-align:baseline" name="chkBsnPreivous[]" type="checkbox"  class="prviousChkFlg"  value="1"  <?php if ($isPrvisFlg[0][trn_base_prev_flg] == 1)
                                        echo "checked" ?> onclick="onclickPrvFlg(this.id)" />
                                        <input id="<?php echo $hiddenId; ?>" style="vertical-align:baseline" name="hidden[]" type="hidden"  class="hiddenprv"  value="<?php echo $val; ?>"   />
                                    </td>
                                </tr>
    <?php
    $counter+=1;
    ?>

                                <?php
                            }
                            ?>
                            </tr>
                        </table>

                    </div>
                    <div style="margin-left:315px;">
                        <table>
                            <tr>
                                <td>
                                    <a id="linkBase" href="#"><?php echo __("Base") ?> </a>
                                </td>
                                <td rowspan="2">
                                    <input id="txtFormula"  name="txtFormula" type="text"   value="<?php echo $tDType->trn_dtl_formula; ?>"  maxlength="100"  />
                                </td>
                                <td rowspan="2">
                                    <input type="button" style="margin:0px; padding:0px;" class="editbutton" name="btnValidate" id="btnValidate"
                                           value="<?php echo __("Validate") ?>"
                                           title="<?php echo __("Validate") ?>"/>

                                </td>
                            </tr>
                            <tr>

                            </tr>
                        </table>
                        <?php echo "eg : txnword*0.08 = (Transaction(s) * (8/100))"?>
                    </div>
                </div>

            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Maximum Amount") ?> </label>
            </div>
            <div class="centerCol">
                <input id="RuleMaxVal"  name="RuleMaxVal" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_max; ?>"  maxlength="10"/>
            </div>
            <div class="centerCol">
                <label class="controlLabel" for="lblCode"><?php echo __("Minimum Amount") ?> </label>
            </div>
            <div class="centerCol">
                <input id="RuleMinVal"  name="RuleMinVal" type="text"  class="formInputText" value="<?php echo $tDType->trn_dtl_min; ?>"  maxlength="10"/>
            </div>            
            
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
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>
</div>
<style type="text/css">
    div.ex
    {
        width:200px;
        padding:10px;
        border:1px solid gray;
        margin-left: 275px;
        height: 70px;
        overflow-y: scroll;

    }
</style>
<script type="text/javascript">
    
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
                var sltid="<?php echo $tDType->trn_dtl_bank_code; ?>";
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
    
               function validationGrade(e,id){

            if(isNaN($('#'+id).val())){
                alert("<?php echo __('Please enter Digits') ?>");
                $('#'+id).val("");
                return false;
            }
            }
    
    function changeTransType(id){

        var contTypeCode="<?php echo $sysConf->ContributCode; ?>";
        var split=id.split("|");

        if(split[1]!=contTypeCode){
            $("#txtEmplyr").attr("disabled", true);
            $("#txtEmply").attr("disabled", true);
            $("#notContributionDiv input").attr("checked", false);
            $("#ContributionDiv input").attr("checked", false);
            $("#notContributionDiv").show();

            $("#ContributionDiv").hide();


        }else{
            //                    $("#tabs-2 input").attr("disabled", false);
            //                    $("#tabs").tabs("option","disabled",[]);
            $("#txtEmplyr").attr("disabled", false);
            $("#txtEmply").attr("disabled", false);
            $("#notContributionDiv input").attr("checked", false);
            $("#ContributionDiv input").attr("checked", false);
            $("#ContributionDiv").show();

            $("#notContributionDiv").hide();


        }

    }
    function checkIsbaseTrn(){

        var checked = $("#ChkIsbsTxn").attr("checked");
        if(checked){

            $(".basetsn").removeAttr('disabled');
        }else{
            $("#baseTypes input").attr("checked", false);
            $("#baseTypes input").attr("disabled", true);


        }

    }
    function checkPreviousFlg(id){

        var splitId=id.split("_");
        var chkId=splitId[1];

        var checked = $("#chkTransTypeBsn_"+chkId).attr("checked");
        if(checked){
            $("#chkBsnPreivous_"+chkId).removeAttr('disabled');
        }else{
            $("#chkBsnPreivous_"+chkId).attr("checked", false);
            $("#chkBsnPreivous_"+chkId).attr("disabled", true);
        }
    }

    function onclickPrvFlg(id){
        var splitId=id.split("_");
        var chkId=splitId[1];

        var s=$("#chkTransTypeBsn_"+chkId).val().split("|");

        var checked = $("#chkBsnPreivous_"+chkId).attr("checked");
        if(checked){
            $("#chkTransTypeBsn_"+chkId).val("1|"+s[1]);
        }else{
            $("#chkTransTypeBsn_"+chkId).val("0|"+s[1]);

        }
        //                alert($("#chkTransTypeBsn_"+chkId).val());
    }


    $(document).ready(function() {

       var       transType=$("#cmbTransType").val();

       var splitText=transType.split("|");
       var oriTranstype=splitText[2];
                                      
        if(oriTranstype==0){

         $("#chkDefaultTrans").attr("disabled", true);
         $("#chkDefaultTrans").attr("checked", false);

        }else{
            $("#chkDefaultTrans").removeAttr("disabled");
        }
            //$('#DivBranch').hide(); 
            //$('#DivBranchlbl').hide()
         if ($('input[name=optAgent]:checked').val()==0) {
            $('#DivBranch').hide(); 
            $('#DivBranchlbl').hide();

        }
        else{
            $('#DivBranch').show(); 
            $('#DivBranchlbl').show();
        }
        
        $("input[name='optAgent']").change(function(){
            if ($(this).val()==0) {
            $('#DivBranch').hide(); 
            $('#DivBranchlbl').hide();
            $('#lblbank').text("Agent Name ");
            $('#lblbank').append("<span class='required'>*</span>");
            }
            else{
            $('#DivBranch').show(); 
            $('#DivBranchlbl').show();
            $('#lblbank').text("Bank Name ");
            $('#lblbank').append("<span class='required'>*</span>");
            }

        });
        
                                
        $("#cmbTransType").change(function() {
       var       transType=$("#cmbTransType").val();

       var splitText=transType.split("|");
       var oriTranstype=splitText[2];
                                     
        if(oriTranstype==0){
        $("#chkDefaultTrans").attr("checked", false);
         $("#chkDefaultTrans").attr("disabled", true);
        }else{
            $("#chkDefaultTrans").removeAttr("disabled");
        }

        });
        
        $('#DivAppeal').hide();
                                           
        if ($('#chkappeal').attr("checked")) {
            $('#DivAppeal').show();
        }else{
            $('#DivAppeal').hide();
        }

        $("input[name='chkappeal']").change(function(){
            if ($(this).attr("checked")) {
                $('#DivAppeal').show();
            }else{
                $('#DivAppeal').hide();
            }
        });

        LoadGradeSlot("<?php echo $tDType->trn_dtl_bank_code; ?>");
        
        
        $("#btnValidate").click(function() {


            var formula=$("#txtFormula").val();
            $.ajax({
                type: "POST",
                async:false,
                url: "<?php echo url_for('payroll/validateFormula') ?>",
                data: { formula: formula },
                dataType: "json",
                success: function(data){

                            

                    if(data==1){
                        alert("<?php echo __('Validation successfull.') ?>");
                    }
                    else{
                        alert("<?php echo __('Validation Failed.') ?>");
                    }
//                                            $('#DivCmbTransDetails').html(selectbox);


                }
            });

        });

        var contTypeCode="<?php echo $sysConf->ContributCode; ?>";
        var split=$("#cmbTransType").val().split("|");
        $("#notContributionDiv input").attr("disabled", true);


        //                alert($("#cmbTransType").val());
        if(split[1]!=contTypeCode){

            //                   notContributionDiv
            $("#txtEmplyr").attr("disabled", true);
            $("#txtEmply").attr("disabled", true);
            $("#notContributionDiv").show();

            $("#ContributionDiv").hide();

        }else{

            //
            //                    $("#ContributionDiv input").attr("disabled", false);
            $("#ContributionDiv").show();
            //                    $("#notContributionDiv input").attr("disabled", true);
            $("#notContributionDiv").hide();

        }

        //$("#tabs").tabs({ disabled: [1, 2] });


        $('#linkBase').click(function() {

            $('#txtFormula').val($('#txtFormula').val() + "txnword");

        });

        buttonSecurityCommon(null,"editBtn",null,null);

        var checked = $("#ChkIsbsTxn").attr("checked");
        if(checked){
            $("#baseTypes input").removeAttr('disabled');
        }else{
            $("#baseTypes input").attr("checked", false);
            $("#baseTypes input").attr("disabled", true);


        }


        $(".basetsn").each( function() {

            var splitId=this.id.split("_");
            var chkId=splitId[1];

            var checked =$(this).attr("checked");
            if(checked){
                $("#chkBsnPreivous_"+chkId).removeAttr('disabled');
            }else{
                $("#chkBsnPreivous_"+chkId).attr("checked", false);
                $("#chkBsnPreivous_"+chkId).attr("disabled", true);


            }
            //                if($(this).attr("checked"))
            //                $("#chkBsnPreivous_0").attr("disabled",true);
        });


<?php if ($mode == 0) { ?>
                    $("#editBtn").show();
                    buttonSecurityCommon(null,null,"editBtn",null);
                    $('#frmSave :input').attr('disabled', true);
                    $('#editBtn').removeAttr('disabled');
                    $('#btnBack').removeAttr('disabled');
                                           
<?php } ?>

           

            $("#frmSave").validate({

                rules: {
                    txtCode:{required: true,noSpecialCharsOnly: true, maxlength:10},
                    txtName: { required: true,noSpecialCharsOnly: true, maxlength:100 },
                    txtNameSi: {noSpecialCharsOnly: true, maxlength:100 },
                    txtNameTa: {noSpecialCharsOnly: true, maxlength:100 },
                    txtNarrationName: { required: true,noSpecialCharsOnly: true, maxlength:100 },
                    txtNarrationNameSi: {noSpecialCharsOnly: true, maxlength:100 },
                    txtNarrationNameTa: {noSpecialCharsOnly: true, maxlength:100 },
                    txtOrderPaySlip: {noSpecialCharsOnly: true,number:true, maxlength:100 },
                    cmbTransType:{required: true},
                    RuleMaxVal:{number: true},
                    RuleMinVal:{number: true}
                

                },
                messages: {
                    txtCode:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                    txtName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                    txtNameSi:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                    txtNameTa:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                    txtNarrationName: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                    txtNarrationNameSi:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                    txtNarrationNameTa:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                    txtOrderPaySlip:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>",number: '<?php echo __("numeric only") ?>'},
                    cmbTransType:{required:"<?php echo __("This field is required") ?>"},
                    RuleMaxVal:{number:"<?php echo __("This field is Numeric") ?>"},
                    RuleMinVal:{number:"<?php echo __("This field is Numeric") ?>"}


                }
            });



            // When click edit button
            $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

            // When click edit button
            $("#editBtn").click(function() {
                var editMode = $("#frmSave").data('edit');
                if (editMode == 1) {
                    // Set lock = 1 when requesting a table lock

                    location.href="<?php echo url_for('payroll/TransActDetails?tDetailId=' . $encryption->encrypt($tDType->trn_dtl_code) . '&lock=1') ?>";
                }
                else {
                    var max=+$("#RuleMaxVal").val();
                    var min=+$("#RuleMinVal").val();

                    if(max != " " || min != " "){ 
                        if((max === null)|| (min === null)){
                            alert("<?php echo __('Rule should have Maxmimum and Minimum values') ?>");
                            return false;
                        }
                            
                        if(max < min){
                            alert("<?php echo __('Maxmimum Minimum Value error') ?>");
                            return false;
                        }    
                        
                    }
            
                    $('#frmSave').submit();
                }

            });

            //When click reset buton
            $("#btnClear").click(function() {
                location.href="<?php echo url_for('payroll/TransActDetails?tDetailId==' . $encryption->encrypt($tDType->trn_dtl_code) . '&lock=0') ?>";
            });

            //When Click back button
            $("#btnBack").click(function() {
                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/TransActionDetailSummary')) ?>";
            });




        });
</script>
<?php ?>
