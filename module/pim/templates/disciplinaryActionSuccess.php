<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Disciplinary Summary") ?></h2></div>
        <?php echo message(); ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="">
            <input type="hidden" name="mode" value="search" />
            <div class="searchbox">
                <label for="cmbSearchMode"><?php echo __("Search By") ?></label>
                <select name="cmbSearchMode" id="cmbSearchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="emp" <?php if ($searchMode == 'emp') {
            echo "selected";
        } ?>><?php echo __("Employee Name") ?></option>
                    <option value="eftfrom" <?php if ($searchMode == 'eftfrom') {
            echo "selected";
        } ?>><?php echo __("Effective From") ?></option>
                    <option value="eftto" <?php if ($searchMode == 'eftto') {
            echo "selected";
        } ?>><?php echo __("Effective To") ?></option>
                    <option value="action" <?php if ($searchMode == 'action') {
            echo "selected";
        } ?>><?php echo __("Action") ?></option>
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
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('pim/deleteDisAction') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">
                            <input type="checkbox" class="checkbox" name="chkAllCheck" value="" id="chkAllCheck" />
                        </td>

                        <td scope="col">
                            <?php
                            if ($userCulture == "en") {
                                $feild = "e.emp_display_name";
                            } else {
                                $feild = "e.emp_display_name_" . $userCulture;
                            }
                            ?>
<?php echo $sorter->sortLink($feild, __('Employee Name'), '@empdisAct_list', ESC_RAW); ?>
                        </td>
                        <td scope="col">

<?php echo $sorter->sortLink('i.emp_dis_effectfrom', __('Effective From'), '@empdisAct_list', ESC_RAW); ?>
                        </td>
                        <td scope="col">

<?php echo $sorter->sortLink("i.emp_dis_effectto", __('Effective To'), '@empdisAct_list', ESC_RAW); ?>
                        </td>
                        <td scope="col">

<?php echo $sorter->sortLink("i.emp_dis_action", __('Action'), '@empdisAct_list', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                    <?php echo __('Comment'); ?>
                                </td>
                            </tr>
                        </thead>

                        <tbody>
                    <?php
                            $row = 0;
                            foreach ($listDisActions as $disActions) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;

                                //Define data columns according culture
                                $EDNameCol = ($userCulture == "en") ? "emp_display_name" : "emp_display_name_" . $userCulture;
                                $EDName = $disActions->Employee->$EDNameCol == "" ? $disActions->Employee->emp_display_name : $disActions->Employee->$EDNameCol;

                                $id = $disActions->emp_dis_id;
                    ?>

                                <tr class="<?php echo $cssClass ?>">
                                    <td >
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $disActions->emp_dis_id; ?>' />
                            </td>

                            <td class="">
                                <a href="<?php echo url_for('pim/saveDisPlinaryaction?disId=' . $disActions->emp_dis_id) ?>"><?php echo $EDName ?></a>
                            </td>
                            <td>
                            <?php
                                echo LocaleUtil::getInstance()->formatDate($disActions->emp_dis_effectfrom);
                            ?>
                            </td>
                            <td>
                            <?php
                                echo LocaleUtil::getInstance()->formatDate($disActions->emp_dis_effectto);
                            ?>
                            </td>
                            <td>
<?php
                                echo $disActions->emp_dis_action;
?>
                            </td>
                            <td>
<?php
                                echo $disActions->emp_dis_comment;
?>
                                    </td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
        <script type="text/javascript">

            $(document).ready(function() {


                buttonSecurityCommon("btnAdd",null,null,"btnRemove");
                //When click add button
                $("#btnAdd").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/saveDisPlinaryaction')) ?>";

                });

                // When Click Main Tick box
                $("#chkAllCheck").click(function() {
                    if ($('#chkAllCheck').attr('checked')){
                        $('.innercheckbox').attr('checked','checked');
                    }else{
                        $('.innercheckbox').removeAttr('checked');
                    }
                });

                $(".innercheckbox").click(function() {
                    if($(this).attr('checked')) {

                    }else {
                        $('#chkAllCheck').removeAttr('checked');
                    }
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
             $("#frmEmpAttachment").validate({
                   submitHandler: function(form) {
                   $('#btnSaveAttachment').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                   form.submit();
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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/disciplinaryAction')) ?>";
        });

    });

</script>

