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
 *
 */
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

<?php echo javascript_include_tag('orangehrm.validate.js'); ?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/showhidepane.js'); ?>"></script>

<script type="text/javaScript"><!--//--><![CDATA[//><!--

<?php
$hasAttachments = count($attachmentList) > 0;
if (isset($_GET['ATT_UPLOAD']) && $_GET['ATT_UPLOAD'] == 'FAILED') {
    echo "alert('" . __("Upload Failed") . "');";
}
?>
    //--><!]]></script>


<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Attachments"); ?></h2></div>
        <div id="ErrorMSg">
            <?php echo message() ?>
            <?php
            include_partial('pim_form_errors', array('sf_user' => $sf_user));
            ?>
        </div>
        <div id="parentPaneAttachments" >

            <form name="frmEmpAttachment" id="frmEmpAttachment" method="post" enctype="multipart/form-data"
                  action="<?php echo url_for('pim/updateAttachment?empNumber=' . $employee->empNumber); ?>">
                <input type="hidden" name="EmpID" value="<?php echo $employee->empNumber; ?>"/>

                <input type="hidden" name="seqNO" id="seqNO" value=""/>

                <div id="addPaneAttachments" class="<?php echo ($hasAttachments) ? "addPane" : ""; ?>" >
                    <table width="575" style="height:120px;padding:5px 5px 0 5px;" border="0" cellpadding="0" cellspacing="0" >
                        <tr id="fileTypeRow">
                            <td> <label for=""><?php echo __("Attachment Type") ?><span class="required">*</span></label></td>
                            <td>
                                <select  id="cmbAttachtype" name="cmbAttachtype" style="float:left; width: 225px; margin-top: 5px;">
                                    <option value=""><?php echo __("--Select--"); ?></option>
                                    <?php
                                    //Define data columns according culture
                                    $typenameCol = ($userCulture == "en") ? "eattach_type_name" : "eattach_type_name_" . $userCulture;
                                    if ($attachmentTypeList) {

                                        foreach ($attachmentTypeList as $typeList) {
                                            $typeName = $typeList->$typenameCol == "" ? $typeList->eattach_type_name : $typeList->$typenameCol;
                                            echo "<option  value='{$typeList->eattach_type_id}'>{$typeName}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="fileUploadRow">
                            <td><label for=""><?php echo __("Path") ?><span class="required">*</span></label></td>
                            <td>

                                <input style="float:left; margin: 0px; width: 225px; margin-top: 5px;" type="file"  name="ufile" id="ufile"/><br/><br/>[<?php echo __("Maximum File Size is 2 MB") ?>]
                                <input style="float:left;"  type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                            </td>
                        </tr>
                        <tr id="fileNameRow" style="display:none">
                            <td><label for=""><?php echo __("File Name") ?></label></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><label for=""><?php echo __("Description") ?></label></td>
                            <td><textarea name="txtAttDesc" class="formTextArea" id="txtAttDesc" rows="4" cols="30" style="float:left; margin-left: 0px;"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="hidden" id="attachFields" value="ufile|txtAttDesc" />
                                <input type="hidden" id="attachValues" value="|" />
                            </td>
                        </tr>
                    </table>
                    <div class="formbuttons">
                        <input type="button" class="plainbtn" value="<?php echo __("Show File"); ?>" id="showFileBtn" style="display:none"/>
                        <input type="button" class="savebutton" name="btnSaveAttachment" id="btnSaveAttachment" value="<?php echo __("Save"); ?>" title="<?php echo __("Save"); ?>"
                               onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                        <input type="button" class="resetbutton" name="btnResetAttachment" id="btnResetAttachment" value="<?php echo __("Reset"); ?>"  />
                        <input type="button" class="resetbutton" id="btnBackAttachmentEmp" value="<?php echo __("Back"); ?>"/>
                    </div>
                </div>
            </form>

            <div id="attachmentSummery">
                <form name="frmEmpDelAttachments" id="frmEmpDelAttachments" method="post" action="<?php echo url_for('pim/deleteAttachments?empNumber=' . $employee->empNumber); ?>">
                    <input type="hidden" name="EmpID" value="<?php echo $employee->empNumber; ?>"/>

<!--                    <div class="subHeading"></div>-->
                    <div class="actionbar">
                        <div class="actionbuttons">

                            <input type="button" class="addbutton" id="btnAddAttachment"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Add"); ?>" title="<?php echo __("Add"); ?>"/>



                            <input type="button" class="delbutton" id="btnDeleteAttachment"
                                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                                   value="<?php echo __("Delete"); ?>" title="<?php echo __("Delete"); ?>"/>


                        </div>
                    </div>

                    <table width="100%" cellspacing="0" cellpadding="0" class="data-table">
                        <thead>
                            <tr>
                                <td></td>
                                <td><?php echo __("File Name") ?></td>
                                <td><?php echo __("Description") ?></td>
                                <td><?php echo __("Size") ?></td>
                                <td><?php echo __("Type") ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $disabled = ($locRights['delete']) ? "" : 'disabled="disabled"';
                            $row = 0;
                            foreach ($attachmentList as $attachment) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                ?>
                                <tr class="<?php echo $cssClass; ?>">
                                    <td><input type='checkbox' class='checkbox' name='chkattdel[]'
                                               value="<?php echo $attachment->attach_id; ?>"/></td>
                                    <td><a href="#" title="<?php echo $attachment->description; ?>" ><?php echo $attachment->filename; ?></a></td>
                                    <td><?php echo $attachment->description; ?></td>
                                    <td><?php echo add_si_unit($attachment->size); ?>B</td>
                                    <?php
                                    if ($userCulture == "en") {
                                        $empAtthnameCol = "getEattach_type_name";
                                    } else {
                                        $empAtthnameCol = "getEattach_type_name_" . $userCulture;
                                    }
                                    ?>
                                    <td><?php echo $attachment->EmpAttahmentType->$empAtthnameCol(); ?></td>
                                </tr>
                                <?php
                                $row++;
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[

    function getAttachmentdetails(attachId,empNumber){
        $.post("<?php echo url_for('pim/attachmentDetails') ?>",
        { attachId: attachId,empNumber:empNumber },
        function(data){
            if(data==null){
                alert("<?php echo __("record is not found") ?>");
                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/viewEmployee/empNumber/' . $employee->empNumber)) ?>";
            }else{
                setAttachmentData(data);
            }

        },
        "json"
    );
    }
    function LockAttachment(attachId,empNumber){
        $.post("<?php echo url_for('pim/LockAttahment') ?>",
        { attachId: attachId,empNumber:empNumber },
        function(data){
            if (data.recordLocked==true) {
                getAttachmentdetails(attachId,empNumber);
                $("#frmEmpAttachment").data('edit', '1'); // In edit mode
                setAttachmentAttributes();
            }else {
                alert("<?php echo __("Record Locked.") ?>");
            }
        },
        "json"
    );
    }
    function unlockAttachment(attachId,empNumber){
        $.post("<?php echo url_for('pim/unlockAttachment') ?>",
        { attachId: attachId,empNumber:empNumber},
        function(data){


            getAttachmentdetails(attachId,empNumber);

            $("#frmEmpAttachment").data('edit', '0'); // In view mode
            setAttachmentAttributes();
        },
        "json"
    );
    }
    function setAttachmentData(data){
        $("#cmbAttachtype option[value='"+data.attach_type_id+"']").attr("selected", "selected");
        $("#txtAttDesc").val(data.description);
    }
    function setAttachmentAttributes() {

        var editMode = $("#frmEmpAttachment").data('edit');

        if (editMode == 0) {
            $('#frmEmpAttachment :input').attr('disabled','disabled');

            $('#btnSaveAttachment').removeAttr('disabled');
            $('#btnBackAttachmentEmp').removeAttr('disabled');

            $("#btnSaveAttachment").attr('value',"<?php echo __("Edit"); ?>");
            $("#btnSaveAttachment").attr('title',"<?php echo __("Edit"); ?>");
        }
        else {

            $('#frmEmpAttachment :input').removeAttr('disabled');

            $("#btnSaveAttachment").attr('value',"<?php echo __("Save"); ?>");
            $("#btnSaveAttachment").attr('title',"<?php echo __("Save"); ?>");
        }
    }
    $(document).ready(function() {

        buttonSecurityCommon("btnAddAttachment",null,null,"btnDeleteAttachment");
        $("#addPaneAttachments").hide();
        $("#frmEmpAttachment").data('add_mode', true);
        $("#frmEmpAttachment").data('edit', '0');

        // In view mode
        setAttachmentAttributes();
        $('#showFileBtn').click(function() {
            var url = '<?php echo url_for('pim/viewAttachment?empNumber=' . $employee->empNumber . '&attachId='); ?>' + $('#seqNO').val();
            var popup=window.open(url, 'Downloads');
            if(!popup.opener) popup.opener=self;
        });

        // Edit a emergency contact in the list
        $('#frmEmpDelAttachments a').click(function() {

            buttonSecurityCommon(null,null,"btnSaveAttachment",null);
            $("#ErrorMSg").hide();
            $('#attachmentSummery').hide();

            $("#frmEmpAttachment").data('edit', '0');
            setAttachmentAttributes();
            var row = $(this).closest("tr");
            var seqNo = row.find('input.checkbox:first').val();
            var fileName = $(this).text();
            var description = row.find("td:nth-child(3)").text();

            $.post("<?php echo url_for('pim/getAttachmentDetails') ?>",
            { attachId: seqNo,empNumber:"<?php echo $employee->empNumber; ?>" },
            function(data){
                $('#txtAttDesc').val(description);
                $('#attachValues').val(data.attachDetails.description);
                var comboVlaue=data.attachDetails.attach_type_id;

                $("#cmbAttachtype option[value='"+comboVlaue+"']").attr("selected", "selected");


            },
            "json"
        );


            $('#seqNO').val(seqNo);
            $('#fileNameRow td:nth-child(2)').text(fileName);
            $('#fileNameRow').css('display', '');
            $('#fileUploadRow').css('display', 'none');
            $('#showFileBtn').css('display', '');

            $("#frmEmpAttachment").data('add_mode', false);

            $('#attachFields').val("txtAttDesc");

            // hide validation error messages
            $("label.error1col[generated='true']").css('display', 'none');
            showAddPane('Attachments');
        });

        // add a attachment
        $('#btnAddAttachment').click(function() {

            $("#btnSaveAttachment").show();
            buttonSecurityCommon(null,"btnSaveAttachment",null,null);
            $("#ErrorMSg").hide();
            $("#frmEmpAttachment").data('edit', '1');
            setAttachmentAttributes();
            $('#seqNO').val('');
            $('#fileNameRow td:nth-child(2)').text('');
            $('#fileNameRow').css('display', 'none');
            $('#fileUploadRow').css('display', '');
            $('#txtAttDesc').val('');
            $('#showFileBtn').css('display', 'none');

            $("#frmEmpAttachment").data('add_mode', true);

            $('#attachFields').val("ufile|txtAttDesc");
            $('#attachValues').val("|");

            // hide validation error messages
            $("label.error1col[generated='true']").css('display', 'none');

            showAddPane('Attachments');
            $('#attachmentSummery').hide();
        });

        jQuery.validator.addMethod("attachment",
        function() {

            var addMode = $("#frmEmpAttachment").data('add_mode');
            if (!addMode) {
                return true;
            } else {
                var file = $('#ufile').val();
                return file != "";
            }
        }, ""
    );

        $("#frmEmpAttachment").validate({

            rules: {
                cmbAttachtype:{required:true},
                ufile : {attachment:true},
                txtAttDesc: {maxlength: 100,noSpecialCharsOnly:true}
            },
            messages: {
                cmbAttachtype:'<?php echo __("This field is required"); ?>',
                ufile: '<?php echo __("Please select a file.") ?>',
                txtAttDesc: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"}
            },
            errorClass: "errortd",
            submitHandler: function(form) {
                $('#btnSaveAttachment').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                form.submit();
            }
        });


        $('#btnDeleteAttachment').click(function() {
            var checked = $('#frmEmpDelAttachments input:checked').length;

            if ( checked == 0 )
            {
                alert('<?php echo __("Select at least one record to delete"); ?>');
            }
            else
            {
                answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                if (answer !=0)
                {
                    $('#frmEmpDelAttachments').submit();

                }
                else{
                    return false;
                }

            }
        });


        $('#btnSaveAttachment').click(function() {

            var editMode = $("#frmEmpAttachment").data('edit');
            if (editMode == 0) {

                LockAttachment($('#seqNO').val(),"<?php echo $employee->empNumber; ?>");
                return false;
            }
            else {
                $('#frmEmpAttachment').submit();
            }


        });

        $('#btnResetAttachment').click(function() {
            // hide validation error messages
            $("#ErrorMSg").hide();
            $("label.errortd[generated='true']").css('display', 'none');
            var editMode = $("#frmEmpAttachment").data('edit');
            var addmode=$("#frmEmpAttachment").data('add_mode');

            if (editMode == 1) {
                if(addmode==true){
                    document.forms['frmEmpAttachment'].reset('');
                }else{
                    unlockAttachment($('#seqNO').val(),"<?php echo $employee->empNumber; ?>");
                }
                 
                
                return false;
            }
            else {
                document.forms['frmEmpAttachment'].reset('');
            }
        });

        $('#btnBackAttachmentEmp').click(function() {
            $('#addPaneAttachments').hide();
            $('#attachmentSummery').show();
        });
    });
    //]]>
</script>