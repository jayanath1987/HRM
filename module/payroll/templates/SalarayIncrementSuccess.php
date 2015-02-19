<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Employee Salary Increment Summary") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform();">
            <input type="hidden" name="mode" value="search">
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="emp_number" <?php if ($searchMode == "emp_number") {
            echo "selected=selected";
        } ?> ><?php echo __("Employee ID") ?></option>
                    <option value="emp_name" <?php if ($searchMode == "emp_name") {
            echo "selected=selected";
        } ?> ><?php echo __("Employee Name") ?></option>
                    <option value="inc_previous_salary" <?php if ($searchMode == "inc_previous_salary") {
            echo "selected=selected";
        } ?> ><?php echo __("Previous Salary") ?></option>
                    <option value="inc_new_salary" <?php if ($searchMode == "inc_new_salary") {
            echo "selected=selected";
        } ?> ><?php echo __("New Salary") ?></option>
                    <option value="inc_amount" <?php if ($searchMode == "inc_amount") {
            echo "selected=selected";
        } ?> ><?php echo __("Increment") ?></option>
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
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('payroll/DeleteSalarayIncrement') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table" id="mytab" >
                <thead>
                    <tr>
                        <td width="50">

                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />

                        </td>

                        <td scope="col">
                            <?php echo $sorter->sortLink('e.employeeId', __('Employee ID'), '@SalarayIncrement', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php
                            if ($Culture == 'en') {
                                $btname = 'e.emp_display_name';
                            } else {
                                $btname = 'e.emp_display_name_' . $Culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($btname, __('Employee Name'), '@SalarayIncrement', ESC_RAW); ?>
                        </td>
                        <td scope="col">
<?php echo $sorter->sortLink('s.inc_previous_salary', __('Salary Before Increment'), '@SalarayIncrement', ESC_RAW); ?>
                        </td>
                        <td scope="col">
<?php echo $sorter->sortLink('s.inc_new_salary', __('Salary After Increment'), '@SalarayIncrement', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                    <?php echo $sorter->sortLink('s.inc_amount', __('Increment'), '@SalarayIncrement', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                    <?php echo __('Comment'); ?>
                        </td>                        
                        <td scope="col">

                        </td>
                    </tr>
                </thead>

                <tbody>
                            <?php
                            $row = 0;
                            foreach ($SalarayIncrementList as $SalarayIncrement) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                                ?>
                        <tr class="<?php echo $cssClass ?>">
                            <td >
                                <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $SalarayIncrement->emp_number . "_" . $SalarayIncrement->inc_new_grade_code . "_" . $SalarayIncrement->inc_new_slt_scale_year; ?>' />
                            </td>

                            <td class="">
                                    <?php echo $SalarayIncrement->Employee->employeeId; ?>
                            </td>

                            <td class="">
                                <a href="<?php echo url_for('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($SalarayIncrement->emp_number . "_" . $SalarayIncrement->inc_new_grade_code . "_" . $SalarayIncrement->inc_new_slt_scale_year)) ?>"><?php
                                if ($Culture == 'en') {
                                    echo $SalarayIncrement->Employee->emp_display_name;
                                } else {
                                    $abc = 'emp_display_name_' . $Culture;
                                    echo $SalarayIncrement->Employee->$abc;
                                    if ($SalarayIncrement->Employee->$abc == null) {
                                        echo $SalarayIncrement->Employee->emp_display_name;
                                    }
                                }
                                    ?></a>
                            </td>
                            <td class="">
                                <?php echo $SalarayIncrement->inc_previous_salary; ?>
                            </td> 
                            <td class="">
                                <?php echo $SalarayIncrement->inc_new_salary; ?>
                            </td>
                            <td class="">
                                <?php echo $SalarayIncrement->inc_amount; ?>
                            </td>
                            <td class="">
                                <?php echo $SalarayIncrement->inc_comment; ?>
                            </td>

                            <td class="" id="td_<?php echo $row; ?>">
                                <?php $i = 1; ?>

                                <?php
                                //if($SalarayIncrement->inc_new_salary==$SalarayIncrement->Employee->GradeSlot->emp_basic_salary){


                                foreach ($SalarayCancelList as $cancel) {
                                    if ($cancel->emp_number == $SalarayIncrement->emp_number) {
                                        if ($SalarayIncrement->inc_effective_date > $cancel->pay_startdate) {
                                            $i++;
                                        } else {
                                            $i = 0;
                                        }
                                    }
                                }

                                //}
                                ?>
                                <script type="text/javascript">                                    
                                    var content="";
                                    var row="<?php echo $row; ?>"
                                    $.ajax({
                                        type: "POST",
                                        async:false,
                                        url: "<?php echo url_for('payroll/SalaryCancelTrue') ?>",
                                        data: { emp: <?php echo $SalarayIncrement->emp_number; ?>, newsal: <?php echo $SalarayIncrement->inc_new_salary; ?>},
                                        dataType: "json",
                                        success: function(data){
                                            if(data=="1"){ 
                                               
                                            }else{
                                                content+="<a href='<?php echo url_for('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($SalarayIncrement->emp_number . '_' . $SalarayIncrement->inc_new_grade_code . '_' . $SalarayIncrement->inc_new_slt_scale_year) . '&type=cancel') ?>'>";
                                                content+="<?php echo __("Cancel"); ?>";
                                                content+="</a>";
                                            }
                                            $("#td_"+row).empty();
                                            $("#td_"+row).append(content);
                                        }
                                        
                                         
                                    });                                    
                                </script>    
    <?php //if($i!= '0'){  ?>
        <!--                            <a href="<?php //echo url_for('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($SalarayIncrement->emp_number . "_" . $SalarayIncrement->inc_new_grade_code . "_" . $SalarayIncrement->inc_new_slt_scale_year) . "&type=cancel") ?>">
    <?php //echo __("Cancel"); ?>
                                    </a>-->
    <?php //}  ?>
                            </td>

                        </tr>
<?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
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
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/UpdateSalarayIncrement')) ?>";

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
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/SalarayIncrement')) ?>";
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
