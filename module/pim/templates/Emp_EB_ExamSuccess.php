<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("EB Exam Summary") ?></h2></div>
        <?php echo message(); ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="">
            <input type="hidden" name="mode" value="search" />

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
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('pim/deleteEmp_EB_Exam') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">
                            <input type="checkbox" class="checkbox" name="chkAllCheck" value="" id="chkAllCheck" />
                        </td>

                        <td scope="col">
                          <?php echo __('EB Exam'); ?>  
                        </td>
                        <td scope="col">

                          <?php echo __('Grade'); ?> 
                        </td>
                        <td scope="col">
                          <?php echo __('Subject'); ?> 
                        </td>
                        <td scope="col">
                          <?php echo __('Start Date'); ?> 
                        </td>
                        <td scope="col">
                          <?php echo __('Complete Date'); ?> 
                        </td>
                        <td scope="col">
                          <?php echo __('Status'); ?> 
                        </td>
                        <td scope="col">
                          <?php echo __('Attempt'); ?>   
                        </td>
                        <td scope="col">
                        </td>
                            </tr>
                        </thead>

                        <tbody>
                    <?php
                            $row = 0;
                            foreach ($listEBExam as $EBExam ) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;

                                                                
                                $id = $EBExam->ebe_id;
                    ?>

                                <tr class="<?php echo $cssClass ?>">
                                    <td >
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $EBExam->ebe_id; ?>' />
                            </td>

                            <td class="">
                                <a href="<?php echo url_for('pim/saveEmp_EB_Exam?disId=' . $EBExam->ebh_id .'&atmpt='. $EBExam->ebe_attepmt) ?>"><?php echo $EBExam->EBMasterHead->ebh_exam_name ?></a>
                            </td>
                            <td>
                            <?php
                                echo $EBExam->EBMasterHead->Grade->grade_name;
                            ?>
                            </td>
                            <td>
                            <?php
                                echo $EBExam->EBMasterDetail->EBSubject->ebs_name;
                            ?>
                            </td>
                            <td>
                            <?php
                                echo $EBExam->ebe_start_date;
                            ?>
                            </td>
                            <td>
                            <?php
                                echo $EBExam->ebe_complete_date;
                            ?>
                            </td>
                             <td>
                            <?php if($EBExam->ebe_flg_pass == 1){
                                    echo "Pass";
                                }elseif ($EBExam->ebe_flg_pass == 0) {
                                    echo "Fail";
                                }else {
                                    echo "Pending";
                                }
                                
                                
                            ?>
                            </td>
                            <td>
<?php
                               echo $EBExam->ebe_attepmt; 
?>
                            </td>
                            <td>
<?php
                                
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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/saveEmp_EB_Exam')) ?>";

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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/saveEmp_EB_Exam')) ?>";
        });

    });

</script>

