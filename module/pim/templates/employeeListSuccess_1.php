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

 <style type="text/css">    
            .pg-normal {
                color: black;
                font-weight: normal;
                text-decoration: none;    
                cursor: pointer;    
            }
            .pg-selected {
                color: black;
                font-weight: bold;        
                text-decoration: underline;
                cursor: pointer;
            }
        </style>
 <?php
$encrypt = new EncryptionHandler();
?>
<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Employee Information") ?></h2></div>
        <?php echo message(); ?>

        
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="">
            <input type="hidden" name="mode" value="search" />
            <div class="searchbox">
                <label for="cmbSearchMode"><?php echo __("Search By") ?></label>
                <select name="cmbSearchMode" id="cmbSearchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="id" <?php
        if ($searchMode == 'id') {
            echo "selected";
        }
        ?>><?php echo __("Employee ID") ?></option>
                    <option value="firstname" <?php
                    if ($searchMode == 'firstname') {
                        echo "selected";
                    }
        ?>><?php echo __("First Name") ?></option>
                    <option value="lastname" <?php
                            if ($searchMode == 'lastname') {
                                echo "selected";
                            }
        ?>><?php echo __("Last Name") ?></option>
                    <option value="designation" <?php
                            if ($searchMode == 'designation') {
                                echo "selected";
                            }
        ?>><?php echo __("Designation") ?></option>
                    <option value="service" <?php
                            if ($searchMode == 'service') {
                                echo "selected";
                            }
        ?>><?php echo __("Service") ?></option>
                    <option value="division" <?php
                            if ($searchMode == 'division') {
                                echo "selected";
                            }
        ?>><?php echo __("Division") ?></option>
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
//if (is_object($pglay)) {
//    if ($pglay->getPager()->haveToPaginate() == 1) {
//        echo $pglay->display();
//    }
//}
?>
                        <!--Pagination By JBL -->
        
<!--                <table id="results" style="display: none;">
          <tr>
                <th>#</th>
                <th>field</th>
            </tr>
          <?php  //foreach ($listEmployee as $employee) { 
          
            //for($i=1; $i<=$listEmployeeCount; $i++){
          ?>          
            <tr>
                <td><?php //echo $employee->employeeId; ?></td>
                <td><input type="text" name="field-name" value="rec10"></td>
            </tr>
         <?php  //} ?>
        </table>-->
        <input type="hidden" name="mode" id="PageRows" value="<?php if($listEmployeeCount==null){ echo "0"; }else{ echo $listEmployeeCount; } ?>"/>                
        <div id="pageNavPosition"></div>
        
        
        
        <!--Pagination By JBL -->
            </div>

            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView1" id="standardView1" method="post" action="<?php echo url_for('pim/deleteEmployee') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">
                            <input type="checkbox" class="checkbox" name="chkAllCheck" value="" id="chkAllCheck" value='<?php //echo $employee->empNumber ?>' />
                        </td>
                        <td scope="col" width="100">
                            <?php //echo $sorter->sortLink('e.employeeId', __('Employee ID'), '@employee_list', ESC_RAW); ?>
                            <?php echo __('Employee ID') ;?>
                        </td>
                        <td scope="col" width="200">
<?php //echo $sorter->sortLink('e.emp_display_name', __('Employee Name'), '@employee_list', ESC_RAW); ?>
                            <?php echo __('Employee Name') ;?>
                        </td>
                        <td scope="col" width="150">
                    <?php //echo $sorter->sortLink('j.name', __('Designation'), '@employee_list', ESC_RAW); ?>
                            <?php echo __('Designation') ;?>
                        </td>
                        <td scope="col" width="100">
                    <?php //echo $sorter->sortLink('s.service_name', __('Service'), '@employee_list', ESC_RAW); ?>
                            <?php echo __('Service') ;?>
                        </td>
                        <td scope="col" width="100">
                    <?php //echo $sorter->sortLink('d.title', __('Division'), '@employee_list', ESC_RAW); ?>
                            <?php echo __('Division') ;?>
                        </td>
                    </tr>
                </thead>

                <tbody id="content">
                    <?php /*
                    if($listEmployee!= null){
                    $row = 0;
                    foreach ($listEmployee as $employee) {
                        $cssClass = ($row % 2) ? 'even' : 'odd';
                        $row = $row + 1;

                        //Define data columns according culture
                        $employeeNameCol = ($userCulture == "en") ? "emp_display_name" : "emp_display_name_" . $userCulture;
                        $employeeName = $employee->$employeeNameCol == "" ? $employee->emp_display_name : $employee->$employeeNameCol;

                        $designationCol = ($userCulture == "en") ? "name" : "name_" . $userCulture;
                        $designation = $employee->jobTitle->$designationCol == "" ? $employee->jobTitle->name : $employee->jobTitle->$designationCol;

                        $serviceCol = ($userCulture == "en") ? "service_name" : "service_name_" . $userCulture;
                        $service = $employee->ServiceDetails->$serviceCol == "" ? $employee->ServiceDetails->service_name : $employee->ServiceDetails->$serviceCol;

                        $divisionCol = ($userCulture == "en") ? "title" : "title_" . $userCulture;
                        $division = $employee->subDivision->$divisionCol == "" ? $employee->subDivision->title : $employee->subDivision->$divisionCol;


                        $onclick = "pim/personalDetail?empNumber=" . $encrypt->encrypt($employee->empNumber);
                        ?>

                        <tr class="<?php echo $cssClass ?>">
                            <td>
                                <input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id="chkID" value='<?php echo $employee->empNumber ?>' />
                            </td>
                            <td class="">
                                <a href="<?php echo url_for($onclick); ?>"><?php echo $employee->employeeId ?></a>
                            </td>
                            <td class="">
                                <a href="<?php echo url_for($onclick); ?>"><?php echo $employeeName ?></a>
                            </td>
                            <td class="">
    <?php echo $designation ?>
                            </td>
                            <td class="">
    <?php echo $service ?>
                            </td>
                            <td class="">
    <?php echo $division ?>
                            </td>
                        </tr>
<?php } } */ ?>
                </tbody>
            </table>
        </form>
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('pim/delete') ?>">
            
        </form>
    </div>
</div>
<script type="text/javascript">
 var sort;
 //JBL Pagin
 function Pager(tableName, itemsPerPage) {
    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;
    
    this.showRecords = function(from, to) {        
        //var rows = document.getElementById(tableName).rows;
        var rows = $("#PageRows").val();
        // i starts from 1 to skip table header row
//        for (var i = 1; i < rows.length; i++) {
//            if (i < from || i > to)  
//                rows[i].style.display = 'none';
//            else
//                rows[i].style.display = '';
//        }
    }
    
    this.showPage = function(pageNumber) { 
        var rows = $("#PageRows").val();
        if(rows!=0){
        var records = (rows - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        }
    	if (! this.inited) {
    		//alert("not inited");
    		return;
    	}

        var oldPageAnchor = document.getElementById('pg'+this.currentPage);
        oldPageAnchor.className = 'pg-normal';
        
        this.currentPage = pageNumber;
        var newPageAnchor = document.getElementById('pg'+this.currentPage);
        newPageAnchor.className = 'pg-selected';
        
        var from = (pageNumber - 1) * itemsPerPage + 1;
        var to = from + itemsPerPage - 1;
        //from = (pageNumber - 2);
        to = (pageNumber + 2);

        this.showRecords(from, to);

        childdiv="";
            $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('pim/Jpagination') ?>",
            data: { datapage: (this.currentPage-1) , searchmode: $('#cmbSearchMode').val() , searchvalue: $('#txtSearchValue').val(), sort:sort},
            dataType: "json",
            success: function(data){
                    var row = 0; 
                    $.each(data, function(key, value) {
                                          
                       var cssClass = (row % 2) ? 'even' : 'odd';
                         row = row + 1; 
                       var word=value.split("|");
                      
                                    childdiv+="<tr class="+cssClass+"><td class=''><input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id='chkID' value="+word[0]+" style='height:50px;'/></td>";
                                    childdiv+="<td class=''><a href=";
                                    childdiv+="<?php echo url_for('pim/personalDetail?empNumber='); ?>"+word[6]+">"+word[1]+"</td>";

                                    childdiv+="<td class=''><a href=";
                                    childdiv+="<?php echo url_for('pim/personalDetail?empNumber='); ?>"+word[6]+">"+word[2]+"</td>";
                                    
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[3]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[4]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[5]+"</td></tr>";

                        $("#PageRows").val(word[7]);            
                  });
                  $("#content").html(childdiv);
                }
        });
        
        
    }   
    
    this.prev = function() {//alert(this.currentPage);
        if (this.currentPage > 1){
            this.showPage(this.currentPage - 1);
         childdiv="";
            $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('pim/Jpagination') ?>",
            data: { datapage: (this.currentPage-1) , searchmode: $('#cmbSearchMode').val() , searchvalue: $('#txtSearchValue').val(), sort:sort},
            dataType: "json",
            success: function(data){
                    var row = 0; 
                    $.each(data, function(key, value) {
                                          
                       var cssClass = (row % 2) ? 'even' : 'odd';
                         row = row + 1; 
                       var word=value.split("|");
                      
                                    childdiv+="<tr class="+cssClass+"><td class=''><input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id='chkID' value="+word[0]+" style='height:50px;'/></td>";
                                    childdiv+="<td class=''><a href=";
                                    childdiv+="<?php echo url_for('pim/personalDetail?empNumber='); ?>"+word[6]+">"+word[1]+"</td>";

                                    childdiv+="<td class=''><a href=";
                                    childdiv+="<?php echo url_for('pim/personalDetail?empNumber='); ?>"+word[6]+">"+word[2]+"</td>";
                                    
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[3]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[4]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[5]+"</td></tr>";
                                    
                                     $("#PageRows").val(word[7]); 
                                    
                  });
                  $("#content").html(childdiv);
                }
        });
            pager.showPageNav('pager', 'pageNavPosition');
       } 
    }
    
    this.next = function() { 
        var rows = $("#PageRows").val();
        if(rows!=0){
        var records = (rows - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        //this.inited = true;
        }
        
        if (this.currentPage <= this.pages) {
            if(this.pages < this.currentPage + 1){
                this.showPage(this.currentPage);
            }else{
            this.showPage(this.currentPage + 1);
            }
            childdiv="";
            $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('pim/Jpagination') ?>",
            data: { datapage: (this.currentPage-1) , searchmode: $('#cmbSearchMode').val() , searchvalue: $('#txtSearchValue').val(), sort:sort},
            dataType: "json",
            success: function(data){
                    var row = 0; 
                    $.each(data, function(key, value) {
                                          
                       var cssClass = (row % 2) ? 'even' : 'odd';
                         row = row + 1; 
                       var word=value.split("|");
                      
                                    childdiv+="<tr class="+cssClass+"><td class=''><input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id='chkID' value="+word[0]+" style='height:50px;'/></td>";
                                    childdiv+="<td class=''><a href=";
                                    childdiv+="<?php echo url_for('pim/personalDetail?empNumber='); ?>"+word[6]+">"+word[1]+"</td>";

                                    childdiv+="<td class=''><a href=";
                                    childdiv+="<?php echo url_for('pim/personalDetail?empNumber='); ?>"+word[6]+">"+word[2]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[3]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[4]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[5]+"</td></tr>";
                                     $("#PageRows").val(word[7]); 
                                    
                  });
                  $("#content").html(childdiv);
                }
        });
            pager.showPageNav('pager', 'pageNavPosition');
        }
    }                        
    
    this.init = function() {
        //var rows = document.getElementById(tableName).rows;
        var rows = $("#PageRows").val();
        if(rows!=0){
        var records = (rows - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
        }
    }

    this.showPageNav = function(pagerName, positionId) {
    	if (! this.inited) {
    		//alert("not inited");
    		return;
    	}
    	var element = document.getElementById(positionId);
        var rows = $("#PageRows").val();
        if(rows!=0){
        var records = (rows - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
        }
        
        if($("#PageRows").val()!=null){
    	//alert(this.currentPage);
    	var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal"> &#171 <?php echo __("Prev") ?> </span> | ';
        var pos=1;
        var end=5;
        if((this.currentPage-2)<=0){
            pos=1;
            end=5;
            
            //this.currentPage=1;

        }else{
            pos=(this.currentPage-2);
            //end=(this.currentPage+2);  
            if(this.currentPage < this.pages){
                end=(this.currentPage+2);
            }else{
                end=this.currentPage;
            }
            //alert(this.pages);
        }
        for (var page = pos; page <= end; page++){ 
            //for (var page = 1; page <= this.pages; page++){ 
            pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span> | ';
            }
        pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal"> <?php echo __("Next")?> &#187;</span>';            
        
        element.innerHTML = pagerHtml;
        }else{
            $("#pageNavPosition").html("");
        }
    
        
    }
}

        var pager = new Pager('results', 15); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
        //JBL Pagin
        
        
        
    $(document).ready(function() {    
                var pager = new Pager('results', 15); 
                pager.init(); 
                pager.showPageNav('pager', 'pageNavPosition'); 
                pager.showPage(1);
        buttonSecurityCommon("btnAdd",null,null,"btnRemove");

        
        
        
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
                //$('#frmSearchBox').submit();
                childdiv="";
            $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('pim/Jpagination') ?>",
            data: { datapage: (this.currentPage-1) , searchmode: $('#cmbSearchMode').val() , searchvalue: $('#txtSearchValue').val(), sort:sort},
            dataType: "json",
            success: function(data){
                if(data==null){
                    alert("<?php echo __("No records were found."); ?>");
                    $("#content").html(childdiv);
                    $("#PageRows").val("0");
                    var pager = new Pager('results', 15); 
                    pager.init(); 
                    pager.showPageNav('pager', 'pageNavPosition'); 
                    pager.showPage(1);
                    
                }else{
                    var row = 0; 
                    $.each(data, function(key, value) {
                                          
                       var cssClass = (row % 2) ? 'even' : 'odd';
                         row = row + 1; 
                       var word=value.split("|");
                      
                                    childdiv+="<tr class="+cssClass+"><td class=''><input type='checkbox' class='checkbox innercheckbox' name='chkID[]' id='chkID' value="+word[0]+" style='height:50px;'/></td>";
                                    childdiv+="<td class=''><a href=";
                                    childdiv+="<?php echo url_for('pim/personalDetail?empNumber='); ?>"+word[6]+">"+word[1]+"</td>";

                                    childdiv+="<td class=''><a href=";
                                    childdiv+="<?php echo url_for('pim/personalDetail?empNumber='); ?>"+word[6]+">"+word[2]+"</td>";
                                    
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[3]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[4]+"</td>";
                                    
                                    childdiv+="<td class=''>";
                                    childdiv+=word[5]+"</td></tr>";

                        $("#PageRows").val(word[7]);            
                  });
                  $("#content").html(childdiv);
                    var pager = new Pager('results', 15); 
                    pager.init(); 
                    pager.showPageNav('pager', 'pageNavPosition'); 
                    pager.showPage(1);
                
             }   }
        });
                //return true;
            }
        });

        //When click Reset Button
        $("#btnReset").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/employeeList')) ?>";
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
               
                $("#standardView1").submit();

            } else {
                return false;
            }
        });

    });

</script>



