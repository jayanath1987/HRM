<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Employee Payroll Information Summary") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform();">
            <input type="hidden" name="mode" value="search">
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="employeeId" <?php if($searchMode=="employeeId"){ echo "selected=selected"; }  ?> ><?php echo __("Employee Number") ?></option>
                    <option value="emp_display_name" <?php if($searchMode=="emp_display_name"){ echo "selected=selected"; }  ?> ><?php echo __("Employee Name") ?></option>
                    <option value="AttendanceNo" <?php if($searchMode=="AttendanceNo"){ echo "selected=selected"; }  ?> ><?php echo __("Attendance Number") ?></option>
                </select>

                <label for="searchValue"><?php echo __("Search For") ?></label>
                <input type="text" size="20" name="searchValue" id="searchValue" value="<?php echo $searchValue ?>" />
                <input type="submit" class="plainbtn"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn"
                       value="<?php echo __("Reset") ?>" id="resetBtn"/>
                <div id="legend" style="float: right;width: 150px;">
                <table border="0" >
                    <tr>
                        <td style="background-color: #FF7F00; width: 20px"></td>
                        <td><?php echo __("Payroll Info Pending") ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #3c603a;"></td>
                        <td><?php echo __("Payroll Info Complete") ?></td>
                    </tr>
                </table>
            </div>
                
                <br class="clear"/>
                
                
                
                
            </div>
            
        </form>
        <div class="actionbar">

            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?> </div>
            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('payroll/DeleteEmployeePayrollInformation') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">

<!--                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />-->

                        </td>

                        <td scope="col">
                            <?php echo $sorter->sortLink('e.employeeId', __('Employee Number'), '@EmployeePayrollInformation', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php if ($Culture == 'en') {
                                $btname = 'e.emp_display_name';
                            } else {
                                $btname = 'e.emp_display_name_' . $Culture;
                            } ?>
                            <?php echo $sorter->sortLink($btname, __('Employee Name'), '@EmployeePayrollInformation', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php echo __('Designation'); ?>
                        </td> 
                          <td scope="col">
                            <?php echo __('Attendance Number'); ?>
                        </td> 
                        <td scope="col">
                            <?php echo __('Basic Salary'); ?>
                        </td> 
                        <td scope="col">
                            
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                            $row = 0;
                            foreach ($EmployeeList as $Employee) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                    ?>
                                <tr class="<?php echo $cssClass ?>">
                                    <td >
<!--                                        <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $Employee->empNumber ?>' />-->
                                    </td>

                                    <td class=""    
                                        <?php if($Employee->PayrollEmployee->emp_epf_number!=null){  ?> style="color: #3c603a; font-weight: bold;">
                                           <?php echo $Employee->employeeId; ?>
                                       <?php }else{ ?> style="color: #FF7F00; font-weight: bold;"> <?php
                                         echo $Employee->employeeId; } ?>
                                    </td>

                                    <td class="" 
                                        <?php if($Employee->PayrollEmployee->emp_epf_number!=null){  ?> >
                                           <a href="<?php echo url_for('payroll/UpdateEmployeePayrollInformation?id=' . $encrypt->encrypt($Employee->empNumber)) ?>" style="color: #3c603a; font-weight: bold;"><?php
                                if ($Culture == 'en') {
                                    echo $Employee->emp_display_name;
                                } else {
                                    $abc = 'emp_display_name_' . $Culture;
                                    echo $Employee->$abc;
                                    if ($Employee->$abc == null) {
                                        echo $Employee->emp_display_name;
                                    }
                                }
                    ?></a>
                                       <?php }else{ ?> style="font-weight: bold;" > 
                                       <a style="color: #FF7F00;" href="<?php echo url_for('payroll/UpdateEmployeePayrollInformation?id=' . $encrypt->encrypt($Employee->empNumber)) ?>"><?php
                                if ($Culture == 'en') {
                                    echo $Employee->emp_display_name;
                                } else {
                                    $abc = 'emp_display_name_' . $Culture;
                                    echo $Employee->$abc;
                                    if ($Employee->$abc == null) {
                                        echo $Employee->emp_display_name;
                                    }
                                }
                    ?></a>
                                           <?php } ?>
                                        
                                        
                                        
                                        
                                        
                        </td>
                        <td class=""
                            <?php if($Employee->PayrollEmployee->emp_epf_number!=null){  ?> style="color: #3c603a; font-weight: bold;">
                                           <?php echo $Employee->jobTitle->name; ?>
                                       <?php }else{ ?> style="color: #FF7F00; font-weight: bold;"> <?php
                                         echo $Employee->jobTitle->name; } ?>
                          <?php     ?>
                        </td>
                        <td class=""
                            <?php if($Employee->PayrollEmployee->emp_epf_number!=null){  ?> style="color: #3c603a; font-weight: bold;">
                                           <?php echo $Employee->emp_attendance_no; ?>
                                       <?php }else{ ?> style="color: #FF7F00; font-weight: bold;"> <?php
                                         echo $Employee->emp_attendance_no; } ?>
                          <?php     ?>
                        </td>
                        <td class=""
                            <?php if($Employee->PayrollEmployee->emp_epf_number!=null){  ?> style="color: #3c603a; font-weight: bold;">
                                           <?php echo $Employee->GradeSlot->emp_basic_salary; ?>
                                       <?php }else{ ?> style="color: #FF7F00; font-weight: bold;"> <?php
                                         echo $Employee->GradeSlot->emp_basic_salary; } ?>
                          
                        </td>
                        <td class="">
                        </td>

                    </tr>
<?php } echo "No Of Records : ". $row; ?>
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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/UpdateEmployeePayrollInformation')) ?>";

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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/EmployeePayrollInformation')) ?>";
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
