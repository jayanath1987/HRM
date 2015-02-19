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
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Employee Information") ?></h2></div>
<?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="">
            <input type="hidden" name="mode" value="search" />
            <div class="searchbox">
                <label for="cmbSearchMode"><?php echo __("Search By") ?></label>
                <select name="cmbSearchMode" id="cmbSearchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="id" <?php if ($searchMode == 'id') {
    echo "selected";
} ?>><?php echo __("Employee ID") ?></option>
                    <option value="firstname" <?php if ($searchMode == 'firstname') {
    echo "selected";
} ?>><?php echo __("First Name") ?></option>
                    <option value="lastname" <?php if ($searchMode == 'lastname') {
    echo "selected";
} ?>><?php echo __("Last Name") ?></option>
                    <option value="designation" <?php if ($searchMode == 'designation') {
    echo "selected";
} ?>><?php echo __("Designation") ?></option>
                    <option value="service" <?php if ($searchMode == 'service') {
    echo "selected";
} ?>><?php echo __("Service") ?></option>
                    <option value="division" <?php if ($searchMode == 'division') {
    echo "selected";
} ?>><?php echo __("Division") ?></option>
                </select>

                <label for="txtSearchValue"><?php echo __("Search For:") ?></label>
                <input type="text" size="20" name="txtSearchValue" id="txtSearchValue" value="<?php echo $searchValue ?>" />
                <input type="button" class="plainbtn" id="btnSearch"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn" id="btnReset"
                       value="<?php echo __("Reset") ?>" />
                <br class="clear"/>
            </div>
        </form>
        <div class="actionbar">
            <div class="actionbuttons">
                <input type="button" class="plainbtn" id="btnAdd"
                       value="<?php echo __("Add") ?>" />
                <input type="button" class="plainbtn" id="btnRemove"
                       value="<?php echo __("Delete") ?>" />
            </div>

            <div class="noresultsbar"></div>
            <div class="pagingbar">
<?php
                if (is_object($pglay)) {
                    if ($pglay->getPager()->haveToPaginate() == 1) {
                        echo $pglay->display();
                    }
                }
?>
            </div>

            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('pim/delete') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">
                            <input type="checkbox" class="checkbox" name="chkAllCheck" value="" id="chkAllCheck" />
                        </td>
                        <td scope="col">
<?php echo $sorter->sortLink('e.emp_number', __('Employee ID'), '@employee_list', ESC_RAW); ?>
                        </td>
                        <td scope="col">
<?php echo $sorter->sortLink('e.emp_display_name', __('Employee Name'), '@employee_list', ESC_RAW); ?>
                        </td>
                        <td scope="col">
<?php echo $sorter->sortLink('j.name', __('Designation'), '@employee_list', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                    <?php echo $sorter->sortLink('s.service_name', __('Service'), '@employee_list', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                    <?php echo $sorter->sortLink('d.title', __('Division'), '@employee_list', ESC_RAW); ?>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $row = 0;
                    foreach ($listEmployee as $employee) {
                        $cssClass = ($row % 2) ? 'even' : 'odd';
                        $row = $row + 1;

                        //Define data columns according culture
                        $employeeNameCol = ($userCulture == "en") ? "emp_display_name" : "emp_display_name_" . $userCulture;
                        $employeeName = $employee->$employeeNameCol == "" ? $employee->emp_display_name : $employee->$employeeNameCol;

                        $designationCol = ($userCulture == "en") ? "name" : "name_" . $userCulture;
                        $designation = "sd";

                        $serviceCol = ($userCulture == "en") ? "service_name" : "service_name_" . $userCulture;
                        $service = $employee->ServiceDetails->$serviceCol == "" ? $employee->ServiceDetails->service_name : $employee->ServiceDetails->$serviceCol;

                        $divisionCol = ($userCulture == "en") ? "title" : "title_" . $userCulture;
                        $division = "f";

                        $onclick = "pim/viewEmployee?empNumber=" . trim($employee->empNumber, '0');
                    ?>

                        <tr class="<?php echo $cssClass ?>">
                            <td>
                                <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $employee->empNumber ?>' />
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $employee->employeeId ?></a>
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $employeeName ?></a>
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $designation ?></a>
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $service ?></a>
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $division ?></a>
                            </td>
                        </tr>
<?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function() {

        // When Click Main Tick box
        $("#chkAllCheck").click(function() {
            if ($('#chkAllCheck').attr('checked')){
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
                $('#chkAllCheck').removeAttr('checked');
            }
        });

        //When click Search Button
        $("#btnSearch").click(function() {
            $("#mode").attr('value', 'save');

            var searchMode = $('#cmbSearchMode');

            if (searchMode.val() == 'all')  {
                alert('<?php echo __("Please select a field to search") ?>');
                searchMode.focus();
                return false;
            } else {
                $('#frmSearchBox').submit();
                return true;
            }
        });

        //When click Reset Button
        $("#btnReset").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/index')) ?>";
        });

        //When click add button
        $("#btnAdd").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/addEmployee')) ?>";
        });

        //When click remove button
        $("#btnRemove").click(function() {
            $("#mode").attr('value', 'delete');
            if($('input[name=chkID[]]').is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
            }

            if (answer !=0 ) {
                $("#standardView").submit();
            } else {
                return false;
            }
        });

    });

</script>



