<!--<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
 <script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/> 

<div class="formpage4col">
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("View Processed Employees") ?></h2></div>

        <table cellpadding="5">
            <tr>
                <th><?php echo __("Employee Id") ?></th>
                <th><?php echo __("Employee Name") ?></th>
                <th><?php echo __("Date & Time") ?></th>
                <th><?php echo __("Status") ?></th>
                <th><?php echo __("Pay Slip") ?></th>
            </tr>

            <?php $count=0;
//            if ($processedEmpList) {
                foreach ($processedEmpList as $list) {
            ?>
                    <tr>
                        <td>
                    <?php
                    echo $list['employee_id'];
                    ?>
                       </td>
                <td>
<?php
                    if($myCulture == "en"){
                        $empName=$list['emp_display_name'];
                    }
                    else{
                        if($list["emp_display_name_{$myCulture}"]==""){
                            $empName=$list['emp_display_name'];
                        }else{
                            $empName=$list["emp_display_name_{$myCulture}"];
                        }
                    }
                 
                    echo $empName;
                    ?>
                </td>
                <td>
                    <?php
                    echo $list['pro_inserttime'];
                    ?>
                </td>
                <td>
                    <?php

                   if($myCulture == "en"){
                        $excp=$list['exception_name'];
                    }
                    else{
                        if($list["exception_name_{$myCulture}"]==""){
                            $excp=$list['exception_name'];
                        }else{
                            $excp=$list["exception_name_{$myCulture}"];
                        }
                    }
                    echo $excp;
                    ?>
               </td>
               <td>
                   <a href='<?php echo url_for("payroll/ViewPaySlip?empName={$empName}");?>/startDate/<?php echo $startDate?>/endDate/<?php echo $endDate ?>/empNumber/<?php echo $list['emp_number']?>'><?php echo __("Pay Slip") ?></a>
               </td>
            </tr>
<?php $count++;
                }
//            }
?>
        </table>
        
        <h5><?php  echo __("Total no of Processed Employee/s : ").$count; ?></h5>
         <br class="clear"/>
   <div class="formbuttons">
                <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
                
                <input type="button" class="backbutton" id="btnCHKPrint"
                       value="<?php echo __("Check Print") ?>" tabindex="10" />

            </div>
            <br class="clear"/>
    </div>
 
</div>
<style>
	.ui-progressbar .ui-progressbar-value { background-image: url(<?php echo public_path('../../images/jblpbar/pbar-ani-g.gif') ?>); 
        
        
        }
	</style>

  <br>
  <div style="width: 400; background-color: #ffffff; padding-left: 25px;">
      <br>
      <div style="width: 300px;" class="">
          <div id="progressbar" ></div>
    <br>
    <?php echo $pgbar."%"; ?>
    <?php if($cancel=="1"){ ?>
        <a href='<?php echo url_for("payroll/ProgressBarReset");?>/startDate/<?php echo $startDate?>/endDate/<?php echo $endDate ?>/payrollType/<?php echo $mypt; ?>'><?php echo __("Reset") ?></a>
   <?php } ?>
      </div>
  </div>
<script>

    setTimeout(function(){
   window.location.reload(1);
}, 40000);
 $(document).ready(function() {
      $("#progressbar").progressbar({ value: <?php echo $pgbar; ?> });

      $("#btnBack").click(function() {
           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/payroll/StartProcess1')) ?>";
      });
      
       $("#btnCHKPrint").click(function() {
           //location.href = "<?php //echo url_for(public_path('../../symfony/web/index.php/payroll/StartProcess1')) ?>";
           location.href='<?php echo url_for(public_path('../../symfony/web/index.php/payroll/DBFCHKPrint')) ?>';
      });

  });


</script>