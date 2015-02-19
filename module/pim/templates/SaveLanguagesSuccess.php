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
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
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
<div id="personal" class="pimpanel formPIM">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Language Skills"); ?></h2></div>
        <div id="ErrorMSgSerRec">
            <?php echo message(); ?>
        </div>

            <form name="frmSave" id="frmSave" method="post" action="<?php echo url_for('pim/SaveLanguages?empNumber=' . $employee); ?>">
                <br class="clear">
                <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 600px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:150px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Language") ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:center"><?php echo __("Writing") ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:center"><?php echo __("Speaking") ?></label>
                        </div>
                        <div class="centerCol" style='width:150px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:150px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:center"><?php echo __("Reading") ?></label>
                        </div>

                    </div>
                    
                    <br class="clear"/>
                    <?php foreach($LanguagesList as $Language){ ?>
                    
                    
                    <div style="">
                        <div class="centerCol" style='width:150px;'>
                            <label class="languageBar" style="width:150px; padding-left:2px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px;  color:#444444;"><?php if($userCulture=="en"){ echo $Language->lang_name; }else{ $field="lang_name_".$userCulture; if($Language->$field==null){ echo $Language->lang_name; }else{ echo $Language->$field; }  } ?></label>
                        </div>
                        <div class="centerCol" style='width:150px; '>

                        <select style="width:125px; padding-left:2px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px;"  class="formSelect" <?php echo $disabled; ?> id="<?php echo $Language->lang_code."_cmbLanCompetency1" ?>" name="<?php echo $Language->lang_code."_cmbLanCompetency1" ?>">
                            <option value=""><?php echo __("--Select--"); ?></option>
                            <option value="1"><?php echo __("Poor"); ?></option> 
                            <option value="2"><?php echo __("Basic"); ?></option>
                            <option value="3"><?php echo __("Good"); ?></option>
                            <option value="4"><?php echo __("Mother Tongue"); ?></option>
                        </select>


                        </div>
                        <div class="centerCol" style='width:150px; '>

                        <select style="width:125px; padding-left:2px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px;"  class="formSelect" <?php echo $disabled; ?> id="<?php echo $Language->lang_code."_cmbLanCompetency2" ?>" name="<?php echo $Language->lang_code."_cmbLanCompetency2" ?>">
                            <option value=""><?php echo __("--Select--"); ?></option>
                            <option value="1"><?php echo __("Poor"); ?></option> 
                            <option value="2"><?php echo __("Basic"); ?></option>
                            <option value="3"><?php echo __("Good"); ?></option>
                            <option value="4"><?php echo __("Mother Tongue"); ?></option>
                        </select>
                        </div>
                        <div class="centerCol" style='width:150px; '>
                            <select style="width:125px; padding-left:2px; padding-top:2px;padding-bottom: 1px;  margin-top: 0px;"  class="formSelect" <?php echo $disabled; ?> id="<?php echo $Language->lang_code."_cmbLanCompetency3" ?>" name="<?php echo $Language->lang_code."_cmbLanCompetency3" ?>">
                            <option value=""><?php echo __("--Select--"); ?></option>
                            <option value="1"><?php echo __("Poor"); ?></option> 
                            <option value="2"><?php echo __("Basic"); ?></option>
                            <option value="3"><?php echo __("Good"); ?></option>
                            <option value="4"><?php echo __("Mother Tongue"); ?></option>
                        </select>
                        </div>

                    </div>
                    <?php  } ?>
                </div>
                
                <br class="clear">
            <div class="formbuttons">
                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                       value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />

            </div>
            </form>
            <br class="clear">
        </div>
    </div>

<script type="text/javascript">
    //<![CDATA[

                            function getdata(){
                                    $.ajax({
                                        type: "POST",
                                        async:false,
                                        url: "<?php echo url_for('pim/AjaxLanguageData') ?>",
                                        data: { empNumber:"<?php echo $employee ?>" },
                                        dataType: "json",
                                        success: function(data){
                                            $.each(data, function(key, value) {
                                                
                                                $("#"+value['lang_code']+"_cmbLanCompetency"+value['emplang_type']).val(value['emplang_competency']);

                                            });
                                        }
                                    });
                            }
                            
                            
                            $(document).ready(function() {
                                     


                                     $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                                        // When click edit button
                                        $("#editBtn").click(function() { 
                                            var editMode = $("#frmSave").data('edit');
                                            if (editMode == 1) { 
                                                // Set lock = 1 when requesting a table lock

                                                location.href="<?php echo url_for('pim/SaveLanguages?empNumber=' . $encrypt->encrypt($employee) . '&lock='. $encrypt->encrypt(1)) ?>";
                                            }
                                            else {
                                                

                                                $('#frmSave').submit();
                                                
                                            }

                                        });
                                        
                                        getdata();
                                         
                                     });
                                                        


    //]]>
</script>