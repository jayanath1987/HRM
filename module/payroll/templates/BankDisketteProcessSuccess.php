<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Bank Diskette Process Summary") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform();">
            <input type="hidden" name="mode" value="search">
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="bdp_payment_date" <?php if($searchMode=="bdp_payment_date"){ echo "selected=selected"; }  ?> ><?php echo __("Payment date") ?></option>
                    <option value="title" <?php if($searchMode=="title"){ echo "selected=selected"; }  ?> ><?php echo __("Division") ?></option>
                </select>

                <label for="searchValue"><?php echo __("Search For") ?></label>
                <input type="text" size="20" name="searchValue" id="searchValue" value="<?php echo $searchValue ?>" />
                <input type="submit" class="plainbtn"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn"
                       value="<?php echo __("Reset") ?>" id="resetBtn"/>
                <br class="clear"/>
            </div>
        </form>
        <div class="actionbar">
            <div class="actionbuttons">

                <input type="button" class="plainbtn" id="buttonAdd"
                       value="<?php echo __("Add") ?>" />


               <input type="button" class="plainbtn" id="buttonRemove"
                       value="<?php echo __("Delete") ?>" />

            </div>
            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?> </div>
            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('payroll/DeleteBankDisketteProcess') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">

                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />

                        </td>

                        <td scope="col">
                            <?php if ($Culture == 'en') {
                                $btname = 'c.title';
                            } else {
                                $btname = 'c.title_' . $Culture;
                            } ?>
                            <?php echo $sorter->sortLink($btname, __('Division'), '@BankDisketteProcess', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php echo $sorter->sortLink('b.bdp_start_date', __('Start Date'), '@BankDisketteProcess', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php echo $sorter->sortLink('b.bdp_end_date', __('End Date'), '@BankDisketteProcess', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php echo $sorter->sortLink('b.bdp_payment_date' , __('Payment Date'), '@BankDisketteProcess', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php if ($Culture == 'en') {
                                $btname = 'd.dsk_name';
                            } else {
                                $btname = 'd.dsk_name_' . $Culture;
                            } ?>
                            <?php echo $sorter->sortLink($btname, __('Bank'), '@BankDisketteProcess', ESC_RAW); ?>
                        </td>                        
                        <td scope="col">

                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                            $row = 0;
                            foreach ($BankDisketteProcessList as $BankDisketteProcess) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                    ?>
                                <tr class="<?php echo $cssClass ?>">
                                    <td >
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $BankDisketteProcess->bdp_id; ?>' />
                                    </td>

                                    

                                    <td class="">
                                        <a href="<?php echo url_for('payroll/UpdateBankDisketteProcess?id=' . $encrypt->encrypt($BankDisketteProcess->bdp_id)) ?>"><?php
                                if ($Culture == 'en') {
                                    echo $BankDisketteProcess->CompanyStructure->title;
                                } else {
                                    $abc = 'title_' . $Culture;
                                    echo $BankDisketteProcess->CompanyStructure->$abc;
                                    if ($BankDisketteProcess->CompanyStructure->$abc == null) {
                                        echo $BankDisketteProcess->CompanyStructure->title;
                                    }
                                }
                    ?></a>
                        </td>
                        <td class="">
                        <?php echo $BankDisketteProcess->bdp_start_date; ?>
                        </td> 
                        <td class="">
                            <?php echo $BankDisketteProcess->bdp_end_date; ?>
                        </td>
                        <td class="">
                            <?php echo $BankDisketteProcess->bdp_payment_date; ?> 
                        </td>
                        <td class="">
                            <?php echo $BankDisketteProcess->hsPrBankDiskette->dsk_name; ?>
                        </td>

                        <td class="">
                            <input type="button" class="backbutton" id="btnCreate"
                   value="<?php echo __("Create Diskette") ?>"  onclick="CreateDiskette('<?php echo $BankDisketteProcess->bdp_id; ?>');"/>
                        </td>

                    </tr>
<?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <script type="text/javascript">
                function CreateDiskette(id){
                    var Processid=id;

                    
                    var popup=window.open('<?php echo public_path('../../symfony/web/index.php/payroll/BankDisketteCreation?Processid='); ?>'+Processid,'Locations','height=450 ,width=400 ,resizable=1,scrollbars=1');
                    if(!popup.opener) popup.opener=self;


                }
            
            function validateform(){

                if($("#searchValue").val()=="")
                {

                    alert("<?php echo __('Please enter search value') ?>");
                    return false;

                }
                if($("#searchMode").val()=="all"){
                    alert("<?php echo __('Please select the search mode') ?>");
                    return false;
                }
                else{
                    $("#frmSearchBox").submit();
                }

            }
            $(document).ready(function() {
                buttonSecurityCommon("buttonAdd","null","null","buttonRemove");
                //When click add button
                $("#buttonAdd").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/UpdateBankDisketteProcess')) ?>";

                });

                // When Click Main Tick box
                $("#allCheck").click(function() {
                    if ($('#allCheck').attr('checked')){

                        $('.innercheckbox').attr('checked','checked');
                    }else{
                        $('.innercheckbox').removeAttr('checked');
                    }
                });

                $(".innercheckbox").click(function() {
                    if($(this).attr('checked'))
                    {

                    }else
                    {
                        $('#allCheck').removeAttr('checked');
                    }
                });


                //When click reset buton
                $("#resetBtn").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/BankDisketteProcess')) ?>";
                });

                $("#buttonRemove").click(function() {
                    $("#mode").attr('value', 'delete');
                    if($('input[name=chkLocID[]]').is(':checked')){
                        answer = confirm("<?php echo __("Do you really want to Delete?") ?>");
                    }


                    else{
                        alert("<?php echo __("select at least one check box to delete") ?>");

                    }

            if (answer !=0)
            {

                $("#standardView").submit();

            }
            else{
                return false;
            }

        });

        //When click Save Button
        $("#buttonAdd").click(function() {
            $("#mode").attr('value', 'save');
        });



    });


</script>
