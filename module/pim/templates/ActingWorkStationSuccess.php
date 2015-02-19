<link href="<?php echo public_path('../../themes/orange/css/style.css') ?>" rel="stylesheet" type="text/css"/>
<!--<link href="<?php //echo public_path('../../themes/orange/css/message.css') ?>" rel="stylesheet" type="text/css"/>-->
<!--[if lte IE 6]>
<link href="<?php //echo public_path('../../themes/orange/css/IE6_style.css') ?>" rel="stylesheet" type="text/css"/>
<![endif]-->
<!--[if IE]>
<link href="<?php //echo public_path('../../themes/orange/css/IE_style.css') ?>" rel="stylesheet" type="text/css"/>
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
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.simplemodal.js') ?>"></script>
        <style type="text/css">
        .DJMODAL{
            display: none;
        }
        </style>
<div id="dialog" name="dialog" title="<?php echo __("Workstations"); ?>">
    <div id="test">

<!--        <a href="#" id="abs" >Fu</a>-->
    </div>

</div>

<div class="formpage4col" >
    <div class="navigation">
        <style type="text/css">
        div.formpage4col input[type="text"]{
            width: 180px;
        }
        </style>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Acting Workstations") ?></h2></div>
        <div id="errMessage">
            <?php echo message(); ?>
        </div>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <?php //echo $EmpNumber; ?>
            <div id="ActdivisionMainDiv" >
            </div> 
            <div class="formbuttons">
                <input type="button" class="clearbutton" id="btnAddtogrid"  onclick="Addtogrid();"  value="<?php echo __("Add"); ?>"/>
                <input type="button" class="clearbutton" id="btnRemovegrid"  onclick="Removetogrid();"  value="<?php echo __("Remove"); ?>"/>
                <input type="submit" id="editBtn" class = "plainbtn" value="<?php echo __("Save") ?>" />
            </div>
            <br class="clear"/>
   <input type="hidden" name="Actworkstaions" id="Actworkstaions" value="" />
        </form>
    </div>
</div>

<script type="text/javascript">
                                                    var workstation=0;
                                                    var display=0;
                                                    //$("#dialog").dialog('distroy');
//                                                    jQuery("#dialog").dialog({
//
//                                                        bgiframe: true, autoOpen: false, position: 'top', minWidth:500, maxWidth:500, modal: true
//                                                    });
//                                                    jQuery('#dialog').dialog({ 
//                                                            focus: function(event, ui) { 
//                                                                //$('#sumbit').hide();
//                                                          }
//                                                             ,close: function(event, ui){
//                                                                
////                                                                 var name;
////                                                                 var id;
////                                                                    $("select option:selected").each(function (key,value) {
////                                                                      if($(this).val()){
////                                                                      name = $(this).text();
////                                                                      id = $(this).val();
////                                                                      }
////                                                                     });
////                                                              Actmymethod(id,name);
////
//                                                                      
//                                                             }                                                            
//
//                                                          
//                                                             
//                                                            
//                                                            
//                                                        });
                                                    function DisplayEmpHirache(wst,div){
                                                        $('#'+div).val("");
                                                        var wst;
                                                        $.ajax({
                                                            type: "POST",
                                                            async:false,
                                                            url: "<?php echo url_for('pim/DisplayEmpHirache') ?>",
                                                            data: { wst: wst },
                                                            dataType: "json",
                                                            success: function(data){
                                                                var row="<table style='background-color:#FAF8CC; width:375px; boder:1'>";
                                                                var temp=0;
                                                                if(data.name10 !=null){
                                                                    row+="<tr ><td style='width:300px'>"+data.nameLevel10+"-"+data.name10+"</td></tr>";
                                                                    temp=1;}
                                                                if(data.name9 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel9+"</label>-&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name9+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name8 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel8+"</label>-&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name8+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name7 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel7+"</label>-&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name7+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name6 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel6+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name6+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name5 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel5+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name5+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name4 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel4+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name4+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name3 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel3+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name3+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name2 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel2+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name2+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name1 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel1+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name1+"</td></tr>";
                                                                    temp=1;
                                                                }

                                                                row+="</table>";
                                                                $('#'+div).html(row);
                                                            }
                                                        });



                                                    }

                                                    
                                                    
                                                    function Addtogrid(){
                                                    
                                                    var id=workstation+1;    
                                                    
                                                    var Divhtml="";
                                                        
                                                    Divhtml+="<div id='Actdivision"+id+"' style='border-style: solid; border-color: #FAD163'>";   
                                                    Divhtml+="<div class='leftCol'>";
                                                    Divhtml+="<label class='controlLabel' for='txtLocationCode' style='width: 125px; padding-top: 2px;'><?php echo __("Acting Work Station ") ?>"+id+"</label></div>";                                                      
                                                    Divhtml+="<div class='centerCol' style='width: 160px;'>";

                                                    Divhtml+="<input style='margin-left: 0px; width: 150px;' type='text' name='txtActDivision"+id+"' id='txtActDivision"+id+"' class='formInputText' value='<?php echo $Actfeild; ?>' readonly='readonly' />";
                                                    Divhtml+="<input type='hidden' name='txtActDivisionid"+id+"' id='txtActDivisionid"+id+"' value='<?php echo $employee->actsubDivision->getId(); ?>'/>&nbsp;</div>";
                                                    Divhtml+="<label for='txtLocation' style='width: 25px;'><input class='button' type='button' onclick='returnActLocDet("+id+")' value='...' id='ActdivisionPopBtn"+id+"'  /></label>";
                                                    Divhtml+="<div class='leftCol' style='padding-left: 25px;'><label for='txtLocationCode'><?php echo __("Acting Designation ") ?>"+id+"</label></div>";
                                                    Divhtml+="<div class='centerCol'><select class='formSelect'  id='cmbActDesignstion"+id+"' name='cmbActDesignstion"+id+"'><span class='required'>*</span>";
                                                    Divhtml+="<option value=''><?php echo __("--Select--"); ?></option>";
                                                    Divhtml+="<?php   
                                                                    $ActjobTitCol = ($userCulture == "en") ? "getJobtit_name" : "getJobtit_name_" . $userCulture;
                                                                    if ($ActjobTitleList) {
                                                                        $ActcurrentJobtit = isset($postArr['cmbActDesignstion']) ? $postArr['cmbActDesignstion'] : $employee->act_job_title_code;
                                                                    foreach ($ActjobTitleList as $Actjobtit) {
                                                                         $ActempjobtitName = $Actjobtit->$ActjobTitCol() == "" ? $Actjobtit->getJobtit_name() : $Actjobtit->$ActjobTitCol();
                                                                  echo "<option {$selected1} value='{$Actjobtit->getJobtit_code()}'>{$ActempjobtitName}</option>";
                                                                      }
                                                                       }
                                                                     ?>";
                                                    Divhtml+="</select></div>";
                                                    Divhtml+="<br class='clear'/>";
                                                    Divhtml+="<div id='ActDisplay"+id+"'></div></div><br class='clear'/>";
                                                        $("#ActdivisionMainDiv").append(Divhtml);
                                                        
                                                     workstation++;   
                                                    }
                                                    function Removetogrid(){
                                                        var id=workstation;
                                                        $("#Actdivision"+id).remove();
                                                        
                                                        empno="<?php echo $EmpNumber; ?>";
                                                        $.ajax({
                                                            type: "POST",
                                                            async:false,
                                                            url: "<?php echo url_for('pim/AjaxActinWorkstationDelete') ?>",
                                                            data: { 'empno' : empno , worksation : workstation },
                                                            dataType: "json",
                                                            
                                                            success: function(data){
                                                                    }
                                                                    
                                                           });
                                                           workstation--;
                                                    }
                                                    function returnActLocDet(id){
                                                        display=id;
                                                        //jQuery('#dialog').dialog('open');
                                                        $('#test').load('<?php echo public_path('../../symfony/web/index.php/admin/listCompanyStructure?mode=select_subunit&button=no'); ?>');
                                                        
                                                           //jQuery('#dialog').dialog('open');
                                                            $( "#dialog" ).dialog({ buttons: { "<?php echo __("Submit"); ?>" : function() { 
                                                            if($("#cmbProvince").val()==""){
                                                                alert("<?php echo __('Province is required.') ?>");
                                                                return false;

                                                            }else if($("#cmbDistrict").val()==""){
                                                                alert("<?php echo __('District is required.') ?>");
                                                                return false;

                                                            }else{
                                                                 var name;
                                                                 var id;
                                                                    $("select option:selected").each(function (key,value) {
                                                                      if($(this).val()){
                                                                      name = $(this).text();
                                                                      id = $(this).val();
                                                                      }
                                                                     });

                                                              Actmymethod(id,name);
//                                                              jQuery('#dialog').hide();
                                                              //console.log($("#dialog"));
                                                              //$("#dialog").hide();
                                                                  //$('#ui-dialog').remove();
  
                                                                  //$(this).addClass('DJMODAL');
                                                                  //$(this).parent().addClass('DJMODAL');


                                                                  //$('#dialog').hide();
                                                                  $('.ui-dialog').hide();
                                                                  //$("#dialog").dialog("close"); 
                                                                  //$("#dialog").remove();
                                                                 //$("#test").html("");
                                                                  //$("#dialog").dialog("close"); 
                                                                  //console.log(this);
                                                                  //$('#dialog').dialog('close');


                                                            }
                                                           
                                                           //$('#dialog').remove();
                                                            //$('#dialog').removeClass('ui-dialog').addClass('DJMODAL');
                                                            
                                                             } } });
                                                        
                                                   
                                                      
                                                    }
                                                    function Actmymethod(Actid,Actname){
                                                        
                                                        $("#txtActDivisionid"+display).val(Actid);
                                                        $("#txtActDivision"+display).val(Actname);
                                                        DisplayEmpHirache(Actid,"ActDisplay"+display);
                                                        
                                                    }
                                                    $(document).ready(function() {
                                                        
                                                      $("#editBtn").click(function() {
                                                            $("#Actworkstaions").val(workstation);
                                                            $('#frmSave').submit();
                                                            

                                                    });
                                                    
                                                    <?php   if($ActingCompanyStructureLoad){                                                   
                                                        foreach($ActingCompanyStructureLoad as $ACT){  ?>
                                                                
                                                             var id='<?php echo $ACT->act_workstation_no ?>';    
                                                             display='<?php echo $ACT->act_workstation_no ?>';
                                                    var Divhtml="";
                                                        
                                                    Divhtml+="<div id='Actdivision"+id+"' style='border-style: solid; border-color: #FAD163'>";   
                                                    Divhtml+="<div class='leftCol'>";
                                                    Divhtml+="<label class='controlLabel' for='txtLocationCode' style='width: 125px; padding-top: 2px;'><?php echo __("Acting Work Station ") ?>"+id+"</label></div>";                                                      
                                                    Divhtml+="<div class='centerCol' style='width: 160px;'>";
                                                    Divhtml+="<?php  
                                                    if ($userCulture == "en") {
                                                                                    $ActcompanyCol = 'title';
                                                                               } else {
                                                                                    $ActcompanyCol = 'title_' . $userCulture;
                                                                               }
                                                                               if ($ACT->act_work_satation->$ActcompanyCol == "") {
                                                                                    $Actfeild = $ACT->act_work_satation->title;
                                                                               } else {
                                                                                    $Actfeild = $ACT->act_work_satation->$ActcompanyCol;
                                                                              }
                                                                        ?>";
                                                    Divhtml+="<input style='margin-left: 0px; width: 150px;' type='text' name='txtActDivision"+id+"' id='txtActDivision"+id+"' class='formInputText' value='<?php echo $Actfeild; ?>' readonly='readonly' />";
                                                    Divhtml+="<input type='hidden' name='txtActDivisionid"+id+"' id='txtActDivisionid"+id+"' value='<?php echo $ACT->act_work_satation; ?>'/>&nbsp;</div>";
                                                    Divhtml+="<label for='txtLocation' style='width: 25px;'><input class='button' type='button' onclick='returnActLocDet("+id+")' value='...' id='ActdivisionPopBtn"+id+"'  /></label>";
                                                    Divhtml+="<div class='leftCol' style='padding-left: 25px;'><label for='txtLocationCode'><?php echo __("Acting Designation ") ?>"+id+"</label></div>";
                                                    Divhtml+="<div class='centerCol'><select class='formSelect'  id='cmbActDesignstion"+id+"' name='cmbActDesignstion"+id+"'><span class='required'>*</span>";
                                                    Divhtml+="<option value=''><?php echo __("--Select--"); ?></option>";
                                                    Divhtml+="<?php   
                                                                    $ActjobTitCol = ($userCulture == "en") ? "getJobtit_name" : "getJobtit_name_" . $userCulture;
                                                                    if ($ActjobTitleList) {
                                                                        $ActcurrentJobtit = isset($postArr['cmbActDesignstion']) ? $postArr['cmbActDesignstion'] : $ACT->act_job_title_code;
                                                                    foreach ($ActjobTitleList as $Actjobtit) {
                                                                        $selected = ($ActcurrentJobtit == $Actjobtit->getJobtit_code()) ? "selected='selected'" : '';
                                                                         $ActempjobtitName = $Actjobtit->$ActjobTitCol() == "" ? $Actjobtit->getJobtit_name() : $Actjobtit->$ActjobTitCol();
                                                                  echo "<option {$selected} value='{$Actjobtit->getJobtit_code()}'>{$ActempjobtitName}</option>";
                                                                      }
                                                                       }
                                                                     ?>";
                                                    Divhtml+="</select></div>";
                                                    Divhtml+="<br class='clear'/>";
                                                    Divhtml+="<div id='ActDisplay"+id+"'></div></div><br class='clear'/>";
                                                        $("#ActdivisionMainDiv").append(Divhtml);
                                                     Actmymethod("<?php echo $ACT->act_work_satation ?>","<?php echo $ACT->CompanyStructure->title ?>");
                                                     
                                                     
                                                      workstation++;   
                                                                                                                        
                                                        <?php } } ?>    
                                                    
                                                                                                       
                                                        
                                                    });
</script>    