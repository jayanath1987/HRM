<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
$reportTypeSupervisor = __("Supervisor");
$reportTypeSubordinate = __("Subordinate");

$reportToMethod = array(ReportTo::DIRECT => __("Direct"), ReportTo::INDIRECT => __("Indirect"));
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
<link href="<?php echo public_path('../../themes/orange/css/style.css') ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo public_path('../../themes/orange/css/message.css') ?>" rel="stylesheet" type="text/css"/>
<!--[if lte IE 6]>
<link href="<?php echo public_path('../../themes/orange/css/IE6_style.css') ?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<!--[if IE]>
<link href="<?php echo public_path('../../themes/orange/css/IE_style.css') ?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<script type="text/javascript" src="<?php echo public_path('../../themes/orange/scripts/style.js'); ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/archive.js'); ?>"></script>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.form.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Report To"); ?></h2></div>

        <?php echo javascript_include_tag('orangehrm.validate.js'); ?>
        <script type="text/javascript" src="<?php echo public_path('../../scripts/showhidepane.js'); ?>"></script>
        <div id="parentPaneReportTo" >
            <div id="Errmsg">
                <?php echo message(); ?>
            </div>
            <?php
// Only admins allowed to edit
                $allowEdit = $locRights['admin'] && $locRights['add'];
                $allowDel = $locRights['admin'] && $locRights['delete'];
                $disabled = $allowEdit ? '' : 'disabled="disabled"';

                $repToSubordinates = $employee->ReportToSub;
                $repToSupervisors = $employee->ReportToSup;
                $haveSupervisors = count($repToSupervisors) > 0;
                $haveSubordinates = count($repToSubordinates) > 0;


            ?>

            <?php if (isset($getArr['errmsg']) && $getArr['errmsg'] != "") { ?>
                    <div class="error"><?php echo $getArr['errmsg']; ?></div>
            <?php } ?>
                <form name="frmEmpReportTo" id="frmEmpReportTo" method="post" action="<?php echo url_for('pim/updateReportTo?empNumber=' . $employee->empNumber); ?>">
                    <input type="hidden"  name="EmpID" value="<?php echo $employee->empNumber; ?>"/>

                    <div id="addPaneReportTo" class="<?php echo ($haveSupervisors && $haveSubordinates) ? "addPane" : ""; ?>" >
                        <input type="hidden" name="txtSupEmpID" id="txtSupEmpID" value=""/>
                        <input type="hidden" name="txtSubEmpID" id="txtSubEmpID" value=""/>
                        <input type="hidden" name="oldRepMethod" id="oldRepMethod" value=""/>


                        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="">
                            <tr id="toHideTr">
                                <td><?php echo __("Supervisor / Subordinate") ?></td>
                                <td><div id="recType">
                                        <select <?php echo $disabled; ?>
                                            name="cmbRepType" id="cmbRepType">
                                            <option value=""><?php echo __("--Select--") ?></option>
                                            <option value='Supervisor'><?php echo $reportTypeSupervisor; ?></option>
                                            <option value='Subordinate'><?php echo $reportTypeSubordinate; ?></option>
                                        </select>
                                    </div>
                                    <div id="mylabel"></div>

                                </td>
                                <td id="cmbRepTypeErr"></td>
                            </tr>
                            <tr><td><?php echo __("Employee Name"); ?><span class="required">*</span></td>
                                <td align="left" valign="top">
                                    <strong id="empNameDisplay" style="display:none"></strong>
                                    <input type="text" name="cmbRepEmpID" disabled="disabled"
                                           id="cmbRepEmpID" value="" readonly="readonly"/>
                                    <input type="hidden" name="txtRepEmpID" id="txtRepEmpID" value=""/>&nbsp;<input class="button"
                                                                                                                    type="button" value="..." id="empRepPopBtn" <?php echo $disabled; ?> />

                                </td>
                                <td id="txtRepEmpIDErr"></td>
                            </tr>
                            <tr>
                                <td valign="top"><?php echo __("Reporting Method") ?><span class="required">*</span></td>
                                <td align="left" valign="top">
                                    <select <?php echo $disabled; ?>
                                        name='cmbRepMethod' id='cmbRepMethod'>
                                        <option value=""><?php echo __("--Select--") ?></option>
<?php
                foreach ($reportToMethod as $key => $method) {
                    echo "<option value='" . $key . "'>" . $method . "</option>";
                }
?>						</select></td>
                            <td id="cmbRepMethodErr"></td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <input type="hidden" id="reportToFields" value="cmbRepType|cmbRepMethod" />
                                <input type="hidden" id="currentValues" value="" />
                            </td>
                            <td align="left" valign="top">
                            </td>
                        </tr>
                    </table>
                    <div class="formbuttons">
                        <input type="button" class="savebutton" name="btnSaveReportTo" id="btnSaveReportTo"
                               value="<?php echo __("Save"); ?>"
                               title="<?php echo __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" id="btnReset" value="<?php echo __("Reset"); ?>"/>
                        <input type="button" class="resetbutton" id="btnBackReportTo" value="<?php echo __("Back"); ?>"/>
                    </div>
                </div>
            </form>



            <input type="hidden" name="delSupSub"/>
            <div id="SummeryReportTo">
                <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
                    <tr style="vertical-align:top;">

                        <td class="leftList">
                            <form name="frmEmpDelSupervisors" id="frmEmpDelSupervisors" method="post" action="<?php echo url_for('pim/deleteSupervisors?empNumber=' . $employee->empNumber); ?>">
                                <input type="hidden" name="EmpID" value="<?php echo $employee->empNumber; ?>"/>

                                <div class="subHeading"><h3><?php echo __("Supervisors") ?></h3></div>
                                <div><?php echo __("i.e. Current Employee's Supervisors"); ?></div>

                                <div class="actionbar">
                                    <div class="actionbuttons">

                                        <input type="button" class="addbutton"  id="addSupervisorsBtn"
                                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                               value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>

                                        <input type="button" class="delbutton" id="delSupervisorsBtn"
                                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                               value="<?php echo __("Delete"); ?>" title="<?php echo __("Delete"); ?>"/>

                                    </div>
                                </div>

                                <table width="100%" cellspacing="0" cellpadding="0" class="data-table">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td><?php echo __("Employee ID") ?></td>
                                            <td><?php echo __("Name") ?></td>
                                            <td><?php echo __("Reporting Method") ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>

<?php
                                    $row = 0;
                                    foreach ($repToSupervisors as $supRepTo) {
                                   
                                        $cssClass = ($row % 2) ? 'even' : 'odd';
                                        echo '<tr class="' . $cssClass . '">';
                                        echo "<td><input type='checkbox' class='checkbox' name='chksupdel[]' value='" . $supRepTo->supervisorId . "|" . $supRepTo->reportingMode . "'/></td>";
?><td><a href="#"><?php echo $supRepTo->supervisor->employeeId; ?></a></td>
                                        <?php
                                        if ($userCulture == "en") {
                                            $abc = "emp_display_name";
                                        } else {
                                            $abc = "emp_display_name_" . $userCulture;
                                        }

                                        $employeeName = $supRepTo->supervisor->$abc == "" ? $supRepTo->supervisor->emp_display_name : $supRepTo->supervisor->$abc;
                                        echo '<td>' . $employeeName . '</td>';
                                        echo '<td>' . $reportToMethod[$supRepTo->reportingMode] . '</td>';


                                        echo '</tr>';
                                        $row++;
                                    }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </td>

                        <td class="rightList">
                            <form name="frmEmpDelSubordinates" id="frmEmpDelSubordinates" method="post" action="<?php echo url_for('pim/deleteSubordinates?empNumber=' . $employee->empNumber); ?>">
                                <input type="hidden" name="EmpID" value="<?php echo $employee->empNumber; ?>"/>

                                <div class="subHeading"><h3><?php echo __("Subordinates") ?></h3></div>
                                <div><?php echo __("i.e. Current Employee's Subordinates"); ?></div>

                                <div class="actionbar">
                                    <div class="actionbuttons">
                                        <input type="button" class="addbutton" id="addSubordinatesBtn"
                                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                               value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>
                                        <input type="button" class="delbutton" id="delSubordinatesBtn"
                                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                               value="<?php echo __("Delete"); ?>" title="<?php echo __("Delete"); ?>"/>

                                    </div>
                                </div>

                                <table width="100%" cellspacing="0" cellpadding="0" class="data-table">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td><?php echo __("Employee ID") ?></td>
                                            <td><?php echo __("Name") ?></td>
                                            <td><?php echo __("Reporting Method") ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>

<?php
                                        $row = 0;
                                        foreach ($repToSubordinates as $subRepTo) {

                                            $cssClass = ($row % 2) ? 'even' : 'odd';
                                            echo '<tr class="' . $cssClass . '">';

                                            echo "<td><input type='checkbox'  class='checkbox' name='chksubdel[]' value='" . $subRepTo->subordinateId . "|" . $subRepTo->reportingMode . "'/></td>";
?>
                                        <?php echo "<td><a href='#'>" ?>
                                        <?php echo $subRepTo->subordinate->employeeId; ?>
                                        <?php echo "</a></td>" ?>
                                        <?php
                                            if ($userCulture == "en") {
                                                $abc = "emp_display_name";
                                            } else {
                                                $abc = "emp_display_name_" . $userCulture;
                                            }
                                            $employeeName = $subRepTo->subordinate->$abc == "" ? $subRepTo->subordinate->emp_display_name : $subRepTo->subordinate->$abc;
                                            echo '<td>';
                                            echo $employeeName;
                                            echo '</td>';
                                            echo '<td>' . __($reportToMethod[$subRepTo->reportingMode]) . '</td>';
                                            echo '</tr>';
                                            $row++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[
var reportingMode;
var otherEmpNum ;
    function SelectEmployee(data){

        myArr = data.split('|');
        $("#txtRepEmpID").val(myArr[0]);
        $("#cmbRepEmpID").val(myArr[1]);

    }
    function getReportdetails(Sup_empNumber,Sub_empNumber){
        $.post("<?php echo url_for('pim/reportDetailsbyEmpId') ?>",
        { Sup_empNumber: Sup_empNumber,Sub_empNumber:Sub_empNumber },
        function(data){
                                
            setReportToData(data);
                                

        },
        "json"
    );
    }
    function setReportToData(data){
                               
                                                                
    }
    function LockreportTo(Sup_empNumber,Sub_empNumber){
        $.post("<?php echo url_for('pim/lockreportTo') ?>",
        { Sup_empNumber: Sup_empNumber,Sub_empNumber:Sub_empNumber },
        function(data){
            if (data.recordLocked==true) {
                getReportdetails(Sup_empNumber,Sub_empNumber);
                $("#frmEmpReportTo").data('edit', '1'); // In edit mode
                setJobReportAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");

            }
        },
        "json"
    );
    }
    function unlockReportTo(Sup_empNumber,Sub_empNumber){
        $.post("<?php echo url_for('pim/unlockReportTo') ?>",
        { Sup_empNumber: Sup_empNumber,Sub_empNumber:Sub_empNumber },
        function(data){
            if(data!=null){
                getReportdetails(Sup_empNumber,Sub_empNumber);
                $("#frmEmpReportTo").data('edit', '0'); // In view mode
                setJobReportAttributes();
            }
        },
        "json"
    );
    }
    function setJobReportAttributes(){

        var editMode = $("#frmEmpReportTo").data('edit');
        if (editMode == 0) {
            $('#frmEmpReportTo :input').attr('disabled','disabled');
            $('#btnSaveReportTo').removeAttr('disabled');
            $('#btnBackReportTo').removeAttr('disabled');

            $("#btnSaveReportTo").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnSaveReportTo").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {
            $('#frmEmpReportTo :input').removeAttr('disabled');
                                    
                                   
            $("#btnSaveReportTo").attr('value',"<?php echo __("Save"); ?>");
            $("#btnSaveReportTo").attr('title',"<?php echo __("Save"); ?>");
        }

    }
    function ReportTomethod(method){

        var returnVlaue;
        if(method=="Supervisor"){

            $.post("<?php echo url_for('pim/reportTomethodSup') ?>",
            { empNumber: <?php echo $employee->empNumber ?>,SupempNumber:$("#txtRepEmpID").val() },
            function(data){

                if(data.isValidSup==0){
                    $('#frmEmpReportTo').submit();
                }
                else{
                    if($('#cmbRepType').val()=='0'){
                        alert("<?php echo __('Please select the Supervisor / Subordinate') ?>");
                    }
                    else{
                        alert("<?php echo __('The same employee cannot be assigned as the supervisor and the subordinate') ?>");
                    }
                }
            },
            "json"
        );

        }
        else{

            $.post("<?php echo url_for('pim/reportTomethodSub') ?>",
            { empNumber: <?php echo $employee->empNumber ?>,SubempNumber:$("#txtRepEmpID").val() },
            function(data){

                if(data.isValidSub==0){
                    $('#frmEmpReportTo').submit();

                }
                else{
                    if($('#cmbRepType').val()=='0'){
                        alert("<?php echo __('Please select the Supervisor / Subordinate') ?>");
                    }
                    else{
                        alert("<?php echo __('The same employee cannot be assigned as the supervisor and the subordinate') ?>");
                    }
                }
            },
            "json"
        );
        }

    }


    $(document).ready(function() {
                            
        buttonSecurityCommon("addSupervisorsBtn",null,null,"delSupervisorsBtn");
        buttonSecurityCommon("addSubordinatesBtn",null,null,"delSubordinatesBtn");
        $("#toHideTr").hide();
        $("#addPaneReportTo").hide();
        $("#frmEmpReportTo").data('edit', '0'); // In view mode

        setJobReportAttributes();



        $('#empRepPopBtn').click(function() {

            var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');


            if(!popup.opener) popup.opener=self;
            popup.focus();
        });



        // Edit a subordinate
        $('#frmEmpDelSubordinates a').click(function() {
                                
            buttonSecurityCommon(null,null,"btnSaveReportTo",null);
            $("#frmEmpReportTo").data('edit', '0'); // In view mode

            setJobReportAttributes();
            var row = $(this).closest("tr");

            var checkboxValue = row.find('input.checkbox:first').val();
            var parts = checkboxValue.split("|");

            var otherEmpNum = parts[0];
            var reportingMode = parts[1];

            var otherEmpName = row.find("td:nth-child(3)").text();

            $('#txtSupEmpID').val('<?php echo $employee->empNumber; ?>');
            $('#txtSubEmpID').val(otherEmpNum);
            $('#oldRepMethod').val(reportingMode);
            $('#cmbRepType').val('Subordinate');
            $('#cmbRepType').hide();
            $('#mylabel').html('Subordinate');

            $('#cmbRepEmpID').val(otherEmpName).css('display', 'none');
            $('#empNameDisplay').text(otherEmpName).css('display', '');
            $('#empRepPopBtn').css('display', 'none');
            $('#txtRepEmpID').val(otherEmpNum);
            $('#cmbRepMethod').val(reportingMode);

            $("#currentValues").val($('#cmbRepType').val() + "|" +  reportingMode);

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
            $("#frmEmpReportTo").data('add_mode', false);

            showAddPane('ReportTo');
            $('#SummeryReportTo').hide();
            $('.error').hide();
            $('#Errmsg').html('');
        });

        // Edit a supervisor
        $('#frmEmpDelSupervisors a').click(function() {
            $("#frmEmpReportTo").data('edit', '0'); // In view mode

            buttonSecurityCommon(null,null,"btnSaveReportTo",null);
            setJobReportAttributes();

            var row = $(this).closest("tr");

            var checkboxValue = row.find('input.checkbox:first').val();
            var parts = checkboxValue.split("|");

            otherEmpNum = parts[0];
            reportingMode = parts[1];

            var otherEmpName = row.find("td:nth-child(3)").text();

            $('#txtSupEmpID').val(otherEmpNum);
            $('#txtSubEmpID').val('<?php echo $employee->empNumber; ?>');
            $('#oldRepMethod').val(reportingMode);
            $('#cmbRepType').val('Supervisor');
                               
            $('#cmbRepType').hide();
            $('#mylabel').html('Supervisor');

            $('#cmbRepEmpID').val(otherEmpName).css('display', 'none');
            $('#empNameDisplay').text(otherEmpName).css('display', '');
            $('#empRepPopBtn').css('display', 'none');
            $('#txtRepEmpID').val(otherEmpNum);
            $('#cmbRepMethod').val(reportingMode);

            $("#currentValues").val($('#cmbRepType').val() + "|" + reportingMode);

            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
            $("#frmEmpReportTo").data('add_mode', false);

            showAddPane('ReportTo');
            $('#SummeryReportTo').hide();
            $('.error').hide();
            $('#Errmsg').html('');


        });

        // Add a subordinate
        $('#addSubordinatesBtn').click(function() {
                               
            $('#Errmsg').html('');
            $('#txtSupEmpID').val('');
            $('#txtSubEmpID').val('');
            $('#oldRepMethod').val('');
            $('#cmbRepType').val('Subordinate');
            $('#cmbRepEmpID').val('').css('display', '');
            $('#empNameDisplay').css('display', 'none');
            $('#empRepPopBtn').css('display', '');
            $('#txtRepEmpID').val('');
            $('#cmbRepMethod').val('0');

            $("#reportToFields").val($("#reportToFields").val() + "|cmbRepEmpID|txtRepEmpID");
            $("#currentValues").val($('#cmbRepType').val() + "|" +  $('#oldRepMethod').val() + "|" + $('#cmbRepEmpID').val() + "|" + $('#txtRepEmpID').val());
            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
            $("#frmEmpReportTo").data('add_mode', true);
            showAddPane('ReportTo');
            $("#btnSaveReportTo").show();
            buttonSecurityCommon(null,"btnSaveReportTo",null,null);
            $('#SummeryReportTo').hide();
            $('.error').hide();
            $('#frmEmpReportTo :input').removeAttr('disabled');
            $("#btnSaveReportTo").attr('value',"<?php echo __("Save"); ?>");
            $("#btnSaveReportTo").attr('title',"<?php echo __("Save"); ?>");
            $("#frmEmpReportTo").data('edit', '1');
        });

        // Add a supervisor
        $('#addSupervisorsBtn').click(function() {
                                   
            $('#Errmsg').html('');
            $('#txtSupEmpID').val('');
            $('#txtSubEmpID').val('');
            $('#oldRepMethod').val('');
            $('#cmbRepType').val('Supervisor');
            $('#cmbRepEmpID').val('').css('display', '');
            $('#empNameDisplay').css('display', 'none');
            $('#empRepPopBtn').css('display', '');
            $('#txtRepEmpID').val('');
            $('#cmbRepMethod').val('0');

            $("#reportToFields").val($("#reportToFields").val() + "|cmbRepEmpID|txtRepEmpID");
            $("#currentValues").val($('#cmbRepType').val() + "|" +  $('#oldRepMethod').val() + "|" + $('#cmbRepEmpID').val() + "|" + $('#txtRepEmpID').val());
            // hide validation error messages
            $("label.errortd[generated='true']").css('display', 'none');
            $("#frmEmpReportTo").data('add_mode', true);

            showAddPane('ReportTo');
            $("#btnSaveReportTo").show();
            buttonSecurityCommon(null,"btnSaveReportTo",null,null);
            $('#SummeryReportTo').hide();
            $('.error').hide();
            $('#frmEmpReportTo :input').removeAttr('disabled');
            $("#btnSaveReportTo").attr('value',"<?php echo __("Save"); ?>");
            $("#btnSaveReportTo").attr('title',"<?php echo __("Save"); ?>");
            $("#frmEmpReportTo").data('edit', '1');
        });
        //back button

        $('#btnBackReportTo').click(function() {

            $('#SummeryReportTo').show();
            $('#addPaneReportTo').hide();

        });

        jQuery.validator.addMethod("comboSelected",
        function(value, element) {

            return value != "0";
        }, ""
    );

        $("#frmEmpReportTo").validate({

            rules: {
                cmbRepType : {comboSelected:true},
                txtRepEmpID : {required:true},
                cmbRepMethod : {required:true}
            },
            messages: {
                cmbRepType: '<?php echo __("This field is required"); ?>',
                txtRepEmpID: '<?php echo __("This field is required"); ?>',
                cmbRepMethod: '<?php echo __("This field is required"); ?>'
            },
            errorClass: "errortd",

            errorPlacement: function(error, element) {
                var id = element.attr('id');
                var errId = id + "Err";
                $('#' + errId).append(error);
            },

            onfocusout: false,
            onkeyup: false,
            onclick: false,
            submitHandler: function(form) {
                $('#btnSaveReportTo').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                form.submit();
            }
        });


        $('#delSubordinatesBtn').click(function() {
            var checked = $('#frmEmpDelSubordinates input:checked').length;

            if ( checked == 0 )
            {
                alert('<?php echo __("Select at least one record to delete"); ?>');
            }
            else
            {
                answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                if (answer !=0)
                {
                    $('#frmEmpDelSubordinates').submit();

                }
                else{
                    return false;
                }

            }
        });

        $('#delSupervisorsBtn').click(function() {
            var checked = $('#frmEmpDelSupervisors input:checked').length;

            if ( checked == 0 )
            {
                alert('<?php echo __("Select at least one record to delete"); ?>');
            }
            else
            {
                answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                if (answer !=0)
                {
                    $('#frmEmpDelSupervisors').submit();
                                        

                }
                else{
                    return false;
                }
                
            }
        });

        $('#btnSaveReportTo').click(function() {
            var editMode = $("#frmEmpReportTo").data('edit');
            
            if (editMode == 0) {
                $('#Errmsg').html('');
                if($('#txtSupEmpID').val()=="" && $('#txtSubEmpID').val()==""){
                    $("#frmEmpReportTo").data('edit', '1');
                    setJobReportAttributes();
                }else{
                    $('#Errmsg').html('');
                    LockreportTo($('#txtSupEmpID').val(),$('#txtSubEmpID').val());
                    return false;
                }
           
            }
            else {
                //when add supervicer check as subordinates if true false the condition
                ReportTomethod($("#cmbRepType").val());

         
            }
        });

        $('#btnReset').click(function() {
            // hide validation error messages
                
            var editMode = $("#frmEmpReportTo").data('edit');
            if (editMode == 1) {
                   
                $('#Errmsg').html('');
               
                unlockReportTo($('#txtSupEmpID').val(),$('#txtSubEmpID').val());

                
                $('#cmbRepMethod').val(reportingMode);
               
                $('#empNameDisplay').val();
                $('#cmbRepEmpID').val("");
                $('#txtRepEmpID').val("");
                $('#txtRepEmpID').val(otherEmpNum);
                return false;
            }
            else {
       
                document.forms['frmEmpReportTo'].reset('');
            }
        });

    });

    //]]>
</script>