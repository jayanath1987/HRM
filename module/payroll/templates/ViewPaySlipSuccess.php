<div class="formpage4col">
    <div class="outerbox" style="">
        <div class="mainHeading"><h2><?php echo __("View Processed Employees") ?></h2>
        
        </div>
        <div style="text-align: right; height: 2px;">
        <a href="" onclick="printSelection(document.getElementById('prntable'));return false">print</a>
        </div>


        <br>
        <div id="prntable">
        <table cellpadding="1" style="background: window;">
            <tr> 
                <td style="text-align: left; width: 100px; font-size: 12px;" ><?php echo __("Employee Name"); ?></td> <td style="text-align: right; width: 200px; font-size: 12px;" ><?php echo $empName; ?></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 100px; font-size: 12px;"><?php echo __("Employee ID"); ?></td> <td style="text-align: right; width: 200px; font-size: 12px;" ><?php echo $Employee->employeeId; ?></td>
            </tr> 
            <tr>
                <td style="text-align: left; width: 100px; font-size: 12px;"><?php echo __("Attendance No"); ?></td> <td style="text-align: right; width: 200px; font-size: 12px;" ><?php echo $Employee->emp_attendance_no; ?></td>
            </tr> 
             <tr>
                <td style="text-align: left; width: 100px; font-size: 12px;"><?php echo __("Designation"); ?></td> <td style="text-align: right; width: 200px; font-size: 12px;" ><?php  if($culture=="en"){ $field="name"; }else{ $field="name_".$culture; }  if($Employee->jobTitle->$field != null){ echo $Employee->jobTitle->$field; }else{ echo $Employee->jobTitle->name; }  ?></td>
            </tr> 
        </table>    
        <table cellpadding="1" style="background: window;">    
            <?php foreach($getPaySlipDetailsTXN as $list){ 
            if($list->PRTransDetails->PRTransActiontype->erndedcon=="1"){ ?>
            <tr>
                <td style="text-align: left; width: 200px; font-size: 12px;"><?php echo __("Pay schdule"); ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo substr($list->trn_startdate,0,10)." ".substr($list->trn_enddate,0,10); ?></td>
            </tr>
             
            <tr style="background: #ffffff">
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px; "><?php echo __("Earnings"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ></td>
            </tr> 
            <tr style="background: tomato">
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php //echo $list->PRTransDetails->PRTransActiontype->trn_typ_name; ?> <?php if($culture=="en"){ $field="trn_typ_name"; }else{ $field="trn_typ_name_".$culture; }  if($list->PRTransDetails->PRTransActiontype->$field != null){ echo $list->PRTransDetails->PRTransActiontype->$field; }else{ echo $list->PRTransDetails->PRTransActiontype->trn_typ_name; } ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ><?php echo $list->trn_proc_emp_amt; ?></td>
            </tr>
            <?php }} ?>

            <?php
             foreach($getPaySlipDetailsTXN as $list){ 
            if($list->PRTransDetails->PRTransActiontype->erndedcon=="2"){ ?>
<!--            <tr style="background: wheat">
                <td style="text-align: left; width: 200px;"><?php //echo $list->PRTransDetails->PRTransActiontype->trn_typ_name; ?></td> <td style="text-align: right; width: 100px;" ><?php //echo $list->trn_proc_emp_amt; ?></td>
            </tr>-->
            <?php
            
            if($list->PRTransDetails->PRTransActiontype->trn_typ_type=="1"){ ?>
            <tr style="background: wheat">
                <td style="text-align: left; width: 200px; font-size: 12px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration; } ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo $list->trn_proc_emp_amt; ?></td>
            </tr>
            <?php }
            
            
            if($list->PRTransDetails->PRTransActiontype->trn_typ_type=="0"){ ?>
            <tr style="background: wheat">
                <td style="text-align: left; width: 200px; font-size: 12px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration; } ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo $list->trn_proc_emp_amt; ?></td>
            </tr>

            <?php   }
 
                 } } ?>
       </table>
        <table cellpadding="1" style="background: window;"> 
        <?php foreach($getPaySlipDetailsTXN as $list){ 
            if($list->PRTransDetails->PRTransActiontype->erndedcon=="-1"){ ?>
            <tr style="background: thistle">
                
                <?php if($list->trn_proc_emp_amt!= "0.00" & $list->PRTransDetails->trn_dtl_addtonetpay == "0" ){ ?>
                <td style="text-align: left; width: 200px; font-size: 12px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration; } ?> <?php //echo __("Employee Contribution"); ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo $list->trn_proc_emp_amt; ?></td>
                <?php } ?>
            </tr>

            <?php } } ?>
            </table>  
         <table cellpadding="1" style="background: window;"> 
                 <tr style="background: #17A70A">
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php echo __("EPF Total"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ><?php echo $getPaySlipDetails[0]->pay_gross_salary; ?></td>
            </tr>
             </table>  
           <table cellpadding="1" style="background: window;"> 
                 <tr style="background: sienna">
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php echo __("Gross Salary"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ><?php echo $getPaySlipDetails[0]->pay_gross_salary; ?></td>
            </tr>
             </table>  
        <table cellpadding="1" style="background: window;" >
            <tr>
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php echo __("Deductions"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ></td>
            </tr>
            
            <?php foreach($getPaySlipDetailsTXN as $list){ 
            if($list->PRTransDetails->PRTransActiontype->erndedcon=="0"){ ?>
            <tr style="background: thistle">
                
                <?php if($list->trn_proc_emp_amt!= "0.00"){ ?>
                <td style="text-align: left; width: 200px; font-size: 12px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration; } ?> -><?php echo __("Employee Contribution"); ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo $list->trn_proc_emp_amt; ?></td>
                <?php } ?>
            </tr>
<!--            <tr style="background: thistle">
                <td style="text-align: left; width: 200px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php //if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration; } ?> -><?php //echo __("Employer Contribution"); ?></td> <td style="text-align: right; width: 100px;" ><?php //echo $list->trn_proc_eyr_amt; ?></td>
            </tr>-->

            <?php } } ?>
            
            <?php foreach($getPaySlipDetailsTXN as $list){ 
            if($list->PRTransDetails->PRTransActiontype->erndedcon=="-1" & $list->PRTransDetails->trn_dtl_addtonetpay != "0" ){ ?>
<!--            <tr style="background: tan">
                <td style="text-align: left; width: 200px; "><?php //echo $list->PRTransDetails->PRTransActiontype->trn_typ_name; ?></td> <td style="text-align: right; width: 100px;" ><?php //echo $list->trn_proc_emp_amt; ?></td>
            </tr>-->
             <?php
            
            if($list->PRTransDetails->PRTransActiontype->trn_typ_type=="1"){ ?>
            <tr style="background: tan">
                <td style="text-align: left; width: 200px; font-size: 12px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration; } ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo $list->trn_proc_emp_amt; ?></td>
            </tr>
            <?php }
            
            
            if($list->PRTransDetails->PRTransActiontype->trn_typ_type=="0"){ ?>
            <tr style="background: tan">
                <td style="text-align: left; width: 200px; font-size: 12px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration; } ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo $list->trn_proc_emp_amt; ?></td>
            </tr>

            <?php   }

            } } ?>
            <?php if($getPaySlipDetailsLoan){ foreach($getPaySlipDetailsLoan as $list){ if($list->ln_sch_inst_amount != null){ ?>

            <tr style="background: thistle">

                <td style="text-align: left; width: 200px; font-size: 12px;"><?php echo __("Loan :"); ?><?php //echo $list->LoanType->ln_ty_name; ?><?php if($culture=="en"){ $field="ln_ty_name"; }else{ $field="ln_ty_name_".$culture; }  if($list->LoanType->$field != null){ echo $list->LoanType->$field; }else{ echo $list->LoanType->ln_ty_name; } ?> -> <?php echo __(" AppLication Id : "); ?><?php echo $list->ln_app_number; ?><?php //echo "( Bal : ".$getPaySlipDetailsLoanRemain->ln_bal_amount.")"; ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo $list->ln_sch_inst_amount; ?></td>
            </tr>

            <?php  }}} ?>
       </table> 
            <table cellpadding="1" style="background: window;"> 
            <tr style="background: violet">
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php echo __("Total Deduction"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ><?php echo ($getPaySlipDetails[0]->pay_gross_salary-$getPaySlipDetails[0]->pay_netpay); ?></td>
            </tr>
            </table> 
            <table cellpadding="1" style="background: window;"> 
            <tr style="background: turquoise">
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php echo __("Net Salary"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ><?php echo $getPaySlipDetails[0]->pay_netpay; ?></td>
            </tr>
            <tr style="background: sandybrown">
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php echo __("Pay in Bank"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ><?php echo $getPaySlipDetails[0]->pay_bank_paid_amt; ?></td>
            </tr>
            <tr style="background: limegreen">
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php echo __("Cash Paid Amount"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px;" ><?php echo $getPaySlipDetails[0]->pay_cash_paid_amt; ?></td>
            </tr>
            
            
            </table> 
                <table cellpadding="1">
            <tr>
                <td style="text-align: left; width: 200px; font-weight: bold; font-size: 12px;"><?php echo __("Employer Contribution"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold; font-size: 12px; font-size: 12px;" ></td>
            </tr>
            <?php foreach($getPaySlipDetailsTXN as $list){ 
            if($list->PRTransDetails->PRTransActiontype->erndedcon=="0"){ ?>
            <tr style="background: thistle">
                

<!--                <td style="text-align: left; width: 200px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration; } ?> -><?php //echo __("Employee Contribution"); ?></td> <td style="text-align: right; width: 100px;" ><?php echo $list->trn_proc_emp_amt; ?></td>-->

            </tr>
            <tr style="background: thistle">
                <td style="text-align: left; width: 200px; font-size: 12px;"><?php //echo $list->PRTransDetails->trn_dtl_payslipnarration; ?><?php if($culture=="en"){ $field="trn_dtl_payslipnarration"; }else{ $field="trn_dtl_payslipnarration_".$culture; }  if($list->PRTransDetails->$field != null){ echo $list->PRTransDetails->$field." - ". $list->PRTransDetails->trn_dtl_eyrcont."%"; }else{ echo $list->PRTransDetails->trn_dtl_payslipnarration." - ". $list->PRTransDetails->trn_dtl_eyrcont ."%"; } ?><?php //echo __("Employer Contribution"); ?></td> <td style="text-align: right; width: 100px; font-size: 12px;" ><?php echo $list->trn_proc_eyr_amt; ?></td>
            </tr>

            <?php } } ?>
<!--            <tr>
                <td style="text-align: left; width: 200px;"><?php echo __("Pay Shedule"); ?></td> <td style="text-align: right; width: 100px;" ><?php //echo $list->pay_gross_salary; ?></td>
            </tr>-->
<!--            <tr style="background: peachpuff">
                <td style="text-align: left; width: 200px; font-weight: bold"><?php echo __("Gross Salary"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold" ><?php echo $getPaySlipDetails[0]->pay_gross_salary; ?></td>
            </tr>-->
<!--            <tr style="background: limegreen">
                <td style="text-align: left; width: 200px; font-weight: bold"><?php echo __("Cash Paid Amount"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold" ><?php echo $getPaySlipDetails[0]->pay_cash_paid_amt; ?></td>
            </tr>
            <tr style="background: sandybrown">
                <td style="text-align: left; width: 200px; font-weight: bold"><?php echo __("Pay in Bank"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold" ><?php echo $getPaySlipDetails[0]->pay_bank_paid_amt; ?></td>
            </tr>-->
              
<!--            <tr style="background: turquoise">
                <td style="text-align: left; width: 200px; font-weight: bold"><?php echo __("Net Salary"); ?></td> <td style="text-align: right; width: 100px; font-weight: bold" ><?php echo $getPaySlipDetails[0]->pay_netpay; ?></td>
            </tr>-->
            
       </table>   
        <table cellpadding="1" >
            <?php if($getPaySlipDetailsLoan){ foreach($getPaySlipDetailsLoan as $list){ if($list->ln_sch_inst_amount != null){ ?>
            <?php //$loans= array("1","2","3","4"); ?>
            
            <?php //if(in_array($list->ln_ty_number,$loans)){ ?>
            <tr style="background: thistle">
                
                <?php $count = 0; ?>
                    <?php foreach($getPaySlipDetailsLoanRemain as $list1) {  if($list->ln_ty_number == $list1->ln_ty_number ){ ?>
                <?php //die(print_r($list1->ln_ty_number));?>
                    <?php if($count==0){ $count = 1; ?>
                    <td style="text-align: left; width: 305px; font-size: 12px;">
                    
                    <?php echo __("Loan :"); ?>
                    <?php if($culture=="en"){ $field="ln_ty_name"; }else{ $field="ln_ty_name_".$culture; }  if($list->LoanType->$field != null){ echo $list->LoanType->$field; }else{ echo $list->LoanType->ln_ty_name; } ?> -> <?php echo __(" AppLication Id : "); ?><?php echo $list->ln_app_number; ?>
                                        
                    <?php echo "( Bal : ".$list1->ln_bal_amount.")"; ?><?php echo "( Instalment : ".$list1->ln_processed_capital.")"; ?><?php if(($list1->ln_processed_interest- $list1->ln_processed_capital )<= 0){ echo "( Interest : 0)"; }else{ echo "( Interest : ".($list1->ln_processed_interest- $list1->ln_processed_capital ).")"; } ?> 
                    </td>
                        
                    <?php  } }} ?>
                    
            </tr>

            <?php  //}
            
                    }}} ?>
        </table>     
        </div>
      
        
               </div>
       
</div>
<script type="text/javascript">

function printSelection(node){

  var content=node.innerHTML
  var pwin=window.open('','print_content','width=100,height=100');

  
  //window.open('<html><font size=6 ><body onload="window.print()">'+content+'</body></html>');
  //alert('<html><font size=6 ><body onload="window.print()">'+content+'</body></html>');

  pwin.document.open();
  pwin.document.write('<html><body onload="window.print()">'+content+'</body></html>');
  pwin.document.close();

//  pwin.document.open();
//  pwin.document.write('<html><body onload="window.print()">'+content+'</body></html>');
//  pwin.document.close();
 
  setTimeout(function(){pwin.close();},1000);

}
</script>