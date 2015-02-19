<?php

/**
 * payroll actions.
 *
 * @package    orangehrm
 * @subpackage payroll
 * @author     Jayanath Liyanage, Roshan Wiesena 
 * @version    2011-08-19 
 */
include ('../../lib/common/LocaleUtil.php');

class payrollActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->forward('default', 'module');
    }

    public function executeStartProcess1(sfWebRequest $request) {

        //no post back
        $this->mode = 0;
        $payProcessService = new payProcessService();
        $this->myCulture = $this->getUser()->getCulture();
        $AdministrationService = new AdministrationService();
        $loggedEmp = $_SESSION['empNumber'];
        $this->PayrollTypeList = $AdministrationService->getPayrollType($loggedEmp);
        $payProcessDao = new payProcessDao();
        $Employee = $payProcessDao->getEmployee($loggedEmp);
        $lastPay = $AdministrationService->getLastUnlockPayShedule($Employee->hie_code_2);
        $this->processUnlockStartDate = $lastPay[0]['fromDate'];
        $this->processUnlockEndDate = $lastPay[0]['endDate'];
        $ProcessDisc = $AdministrationService->getPayrollDisc($loggedEmp);
        $capableDisc = $ProcessDisc[0]->prl_disc_code;
        $processType = $ProcessDisc[0]->prl_process_type;
        $this->processType = $processType;
        $this->system = $ProcessDisc[0]->prl_disc_code;

        if (!strlen($capableDisc)) {
            $this->setMessage('NOTICE', array('You Dont have permission to process the payroll'));
            $this->redirect('default/error');
        }
        $batchId = $capableDisc;
        $this->batchId = $batchId;
        $this->payrollType = $payrolltype;
        if ($request->isMethod('post')) {
            $this->mode = 1; // with post back
            $this->pt = $request->getParameter('cmbPayrollType');
            $payrolltype = $request->getParameter('cmbPayrollType');
            $startDate = $request->getParameter('hiddenStartDate');
            $endDate = $request->getParameter('hiddenEndDate');



            $empArr = array();

            $exploed = array();
            $count_rows = array();
            foreach ($_POST as $key => $value) {


                $exploed = explode("_", $key);

                if (strlen($exploed[1])) {
                    $count_rows[] = $exploed[1];

                    $arrname = "a_" . $exploed[1];

                    if (!is_array($$arrname)) {
                        $$arrname = Array();
                    }

                    ${$arrname}[$exploed[0]] = $value;
                }
            }



            $uniqueRowIds = array_unique($count_rows);
            $uniqueRowIds = array_values($uniqueRowIds);



            for ($i = 0; $i < count($uniqueRowIds); $i++) {

                $v = "a_" . $uniqueRowIds[$i];



                if (${$v}[chkEnable]) {
                    $empArr[] = ${$v}[hiddenEmp];
                }
            }
            $comma_separated = implode(",", $empArr);
            $this->comma_separated = $comma_separated;
            // echo "<script>window.open('http://localhost/esm/process.php?comma={$comma_separated}&startDate={$startDate}&endDate={$endDate}&batchId={$batchId}&empId={$_SESSION['empNumber']}'); window.href='http://www.google.lk';</script>";
            //shell_exec("php /var/www/esm/symfony/symfony payProcess:employee {$comma_separated} $startDate $endDate $batchId {$_SESSION['empNumber']}");
            // $this->redirect('payroll/StartProcess');

        }
        
    }

    public function executeGetProcEmpByDate(sfWebRequest $request) {

        $this->startDate = $request->getParameter('startDate');
        $this->endDate = $request->getParameter('endDate');
        $this->batchId = $request->getParameter('batchId');
        $this->payrollType = $request->getParameter('payrollType');


        $payProcessDao = new payProcessDao();
        $this->myCulture = $this->getUser()->getCulture();
        $empList = $payProcessDao->getProcEmpByDate($this->startDate, $this->endDate, $this->batchId, $this->payrollType);


        $this->empList = $empList;

        echo json_encode($this->empList);
        die;
    }

    public function executeViewPaySlip(sfWebRequest $request) {
        $this->culture=$this->getUser()->getCulture();
        $this->empName = $request->getParameter('empName');


//die($this->empName);
        $this->startDate = $request->getParameter('startDate');

        $this->endDate = $request->getParameter('endDate');
        $this->empNumber = $request->getParameter('empNumber');


        $payProcessService = new payProcessService();
        $this->myCulture = $this->getUser()->getCulture();
        $payProcessDao = new payProcessDao();
        $this->Employee = $payProcessDao->getEmployee($this->empNumber);

        $this->getPaySlipDetails = $payProcessService->getPaySlipDetails($this->startDate, $this->endDate, $this->empNumber);
        $this->getPaySlipDetailsTXN = $payProcessService->getPaySlipDetailsTXN($this->startDate, $this->endDate, $this->empNumber);
        $this->getPaySlipDetailsLoan = $payProcessService->getPaySlipDetailsLoan($this->startDate, $this->endDate, $this->empNumber);
        //die(print_r($this->getPaySlipDetailsLoan));
        $this->getPaySlipDetailsLoanRemain = $payProcessService->getPaySlipDetailsLoanRemain($this->startDate, $this->endDate, $this->empNumber);
    //die(print_r($this->getPaySlipDetailsLoanRemain));
        
    }

    public function executeViewProcessedEmp(sfWebRequest $request) {

        $payProcessService = new payProcessService();
        $payprocesdao=new payProcessDao();
        $this->myCulture = $this->getUser()->getCulture();
        $payrolltype = $request->getParameter('payrollType');
        $startDate = $request->getParameter('startDate');
        $endDate = $request->getParameter('endDate');
        $batchId = $request->getParameter('batchId');

        $this->payrollType = $payrolltype;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->batchId = $batchId;
        $encrypt=new EncryptionHandler();
        $mypt=$encrypt->decrypt($payrolltype);
        $this->mypt=$mypt;

        $this->processedEmpList = $payProcessService->listProcessedEmpList($payrolltype, $startDate, $endDate, $batchId);
        
        $this->progresbar = $payprocesdao->readProcessbar($mypt, $startDate, $endDate, $_SESSION['user']);

        $this->pgbar=round((($this->progresbar['pb_emp_total_count']-$this->progresbar['pb_emp_remain_count'])/$this->progresbar['pb_emp_total_count'])*100,2);
        if($this->progresbar['pb_emp_remain_count']=="0"){
            $this->pgbar="100";
        }
        if($this->progresbar['pb_status']=="1"){
            $this->pgbar="100";
        }
        
        if($this->pgbar < "100"){
            $this->cancel="1";
        }else{
             $this->cancel="0";
        }
        
        }

    public function executeProcessPayRoll(sfWebRequest $request) {
        shell_exec("php /var/www/esm/symfony/symfony updatereinstatement:employee");
        die("sed");
        //shell_exec("php http://localhost/esm/symfony/web/index.php/payroll/StartProcess");
    }

    public function executeLoadGrid1(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $adminiSPayrollDao = new AdministartionDao();
        $empId = $request->getParameter('empid');

        $this->emplist = $adminiSPayrollDao->getEmployee($empId);

        foreach ($this->emplist as $row) {


            if ($this->culture == "en") {
                $abc = "emp_display_name";
            } else {
                $abc = "emp_display_name_" . $this->culture;
            }


            $arr[$row['empNumber']] = $row['employeeId'] . "|" . $row[$abc] . "|" . $row['empNumber'];
        }


        echo json_encode($arr);
        die;
    }

    /**
     * Employee Payroll Information
     *  Plug employee from HR to Payroll
     *
     */
    public function executeEmployeePayrollInformation(sfWebRequest $request) {


        try {
            $this->Culture = $this->getUser()->getCulture();
            $EmployeePayrollService = new EmployeePayrollService();

            $this->sorter = new ListSorter('EmployeePayrollInformation', 'payroll', $this->getUser(), array('e.employeeId', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('payroll/EmployeePayrollInformation');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.employeeId' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $EmployeePayrollService->searchEmployeePayrollDetails($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));

            $this->EmployeeList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeAjaxLoadBranch(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $bankDao = new BankDao();

        $id = $request->getParameter('id');
        $Branch = $bankDao->getBranchByID($id);
        $arr = Array();
        foreach ($Branch as $row) {
            if ($this->Culture = "en") {
                $column = "bbranch_address";
            } else {
                $column = "bbranch_address_" . $this->Culture;
                if ($row == null) {
                    $column = "bbranch_address";
                }
            }


            $arr[] = $row->bbranch_code . "|" . $row->$column." --> ".$row->bbranch_user_code;
        }

        echo json_encode($arr);
        die;
    }

    public function executeUpdateEmployeePayrollInformation(sfWebRequest $request) {
        $EmployeePayrollService = new EmployeePayrollService();
        $AdministrationService = new AdministrationService();
        $this->myCulture = $this->getUser()->getCulture();
        $encrypt = new EncryptionHandler();
        $EmployeePayroll = $EmployeePayrollService->readEmployeePayrollDetails($encrypt->decrypt($request->getParameter('id')));
        $this->EmployeePayroll = $EmployeePayroll;
        $EmpID = $encrypt->decrypt($request->getParameter('id'));
        $Employee = $EmployeePayrollService->readEmployeeMaster($EmpID);
        //die(print_r($EmployeePayroll));
        $this->Employee = $Employee;

        $AssignEmpService = new AssignEmployeeService();
        $empBasicSalary = $AssignEmpService->getEmpbasicSalary($EmpID);

        $empBasicSalary = $empBasicSalary[0]->emp_basic_salary;
        //Table Lock code is Open
        if ($request->getParameter('id') && ($EmployeePayroll)) {


            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }

            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_pr_employee', array($EmpID), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_pr_employee', array($EmpID), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed


            $EmployeePayroll = $EmployeePayrollService->readEmployeePayrollDetails($encrypt->decrypt($request->getParameter('id')));
            if (!$EmployeePayroll) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('payroll/EmployeePayrollInformation');
            }
        } else {
            $EmployeePayroll = new PayrollEmployee();
            $this->lockMode = 1;
        }

        $this->gradeList = $EmployeePayrollService->getJobGradeList();
        $this->gradeSlot = $EmployeePayrollService->getGradeSlotByID($Employee->grade_code);

        $this->EmployeePayroll = $EmployeePayroll;
        $this->PayrollTypeList = $AdministrationService->getPayrollType1();
        $this->PayrollVoteTypeSalaryList = $AdministrationService->getPayrollTypeID("1");
        $this->PayrollVoteTypeEPFList = $AdministrationService->getPayrollTypeID("2");
        $this->PayrollVoteTypeETFList = $AdministrationService->getPayrollTypeID("3");

        if ($request->isMethod('post')) {
            $EmployeePayroll = $EmployeePayrollService->readEmployeePayrollDetails(($request->getParameter('txtEMP')));
            if ($EmployeePayroll->emp_number) {
                $EmployeePayroll = $EmployeePayroll;
            } else {
                $EmployeePayroll = new PayrollEmployee();
            }
            if (strlen($EmpID)) {
                $EmployeePayroll->setEmp_number(trim($Employee->empNumber));
            } else {
                $EmployeePayroll->setEmp_number(null);
            }

            if (strlen($request->getParameter('chksalcash'))) {
                $EmployeePayroll->setSal_cash_flag(trim($request->getParameter('chksalcash')));
            } else {
                $EmployeePayroll->setSal_cash_flag("0");
            }
            if (strlen($request->getParameter('chkAssignTodefTrans'))) {
                $EmployeePayroll->setApplied_default_txn(trim($request->getParameter('chkAssignTodefTrans')));
            } else {
                $EmployeePayroll->setApplied_default_txn("0");
            }


            if (strlen($request->getParameter('txtEPF'))) {
                $EmployeePayroll->setEmp_epf_number(trim($request->getParameter('txtEPF')));
            } else {
                $EmployeePayroll->setEmp_epf_number(null);
            }
            if (strlen($request->getParameter('txtETF'))) {
                $EmployeePayroll->setEmp_etf_number(trim($request->getParameter('txtETF')));
            } else {
                $EmployeePayroll->setEmp_etf_number(null);
            }
            if (strlen($request->getParameter('cmbPayrollType'))) {
                $EmployeePayroll->setPrl_type_code(trim($request->getParameter('cmbPayrollType')));
            } else {
                $EmployeePayroll->setPrl_type_code(null);
            }
            if (strlen($request->getParameter('cmbPayrollVoteTypeSalary'))) {
                $EmployeePayroll->setVt_sal_code(trim($request->getParameter('cmbPayrollVoteTypeSalary')));
            } else {
                $EmployeePayroll->setVt_sal_code(null);
            }
            if (strlen($request->getParameter('cmbPayrollVoteTypeEPF'))) {
                $EmployeePayroll->setVt_epf_code(trim($request->getParameter('cmbPayrollVoteTypeEPF')));
            } else {
                $EmployeePayroll->setVt_epf_code(null);
            }
            if (strlen($request->getParameter('cmbPayrollVoteTypeETF'))) {
                $EmployeePayroll->setVt_etf_code(trim($request->getParameter('cmbPayrollVoteTypeETF')));
            } else {
                $EmployeePayroll->setVt_etf_code(null);
            }
            if (strlen($request->getParameter('txtIncrement'))) {
                $Employee->setEmp_salary_inc_date(trim(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtIncrement'))));
            } else {
                $Employee->setEmp_salary_inc_date(null);
            }
            $Employee->setEmp_ispaydownload("1");


            try {

                $EmployeePayrollService->saveEmployeePayrollInformation($EmployeePayroll);
                $EmployeePayrollService->saveEmployeeMaster($Employee);

                $payProcessDao = new payProcessDao();
                if (strlen($request->getParameter('chkAssignTodefTrans'))) {
                    $payProcessDao->defaultTransactionAssign($EmpID, $empBasicSalary);
                }
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/UpdateEmployeePayrollInformation?id=' . $encrypt->encrypt($Employee->empNumber) . '&lock=0');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/UpdateEmployeePayrollInformation?id=' . $encrypt->encrypt($Employee->empNumber) . '&lock=0');
            }
            if ($Employee->empNumber) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                $this->redirect('payroll/UpdateEmployeePayrollInformation?id=' . $encrypt->encrypt($Employee->empNumber) . '&lock=0');
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('payroll/EmployeePayrollInformation');
            }
        }
    }

    public function executeConfiguration(sfWebRequest $request) {

        $AdministrationService = new AdministrationService;
        if ($_SESSION['user'] == "USR001") {

            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Admin Not Allow to Perform Configuration', $args, 'messages')));
            $this->redirect('pim/list');
        } else if (strlen($_SESSION['empNumber'])) {
            $this->Employee = $AdministrationService->readEmployee($_SESSION['empNumber']);
        }

        $Employee = $this->Employee;

        //die(print_r($Employee->Users->def_level));
        $this->CmbYear = $request->getParameter('CmbYear');

        $this->ProvinceList = $AdministrationService->getProvince();
        $this->DistrictList = $AdministrationService->getDistrictByProvince($Employee->hie_code_2);

        //if ($Employee->Users->def_level <= '2' || $Employee->Users->def_level == '4') {
//        if ($Employee->Users->def_level == '2'){
            
            $MaxLockID = $AdministrationService->getMaxLockID($Employee->hie_code_2);
            $MaxUnlockID = $AdministrationService->getMaxUnlockID($Employee->hie_code_2);
//        } else if ($Employee->Users->def_level == '3'){
//            $MaxLockID = $AdministrationService->getMaxLockID($Employee->hie_code_4);
//            $MaxUnlockID = $AdministrationService->getMaxUnlockID($Employee->hie_code_4);
//        }
        //die(print_r($MaxLockID['pay_sch_id']));

        $this->LockID = $MaxLockID['pay_sch_id'];
        $this->UnlockID = $MaxUnlockID['pay_sch_id'];
//        print_r($Employee->hie_code_4."|".$this->LockID."|".$this->UnlockID."|".$MaxLockID);
    }

    public function executeSalarayIncrement(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $SalarayIncrementService = new SalarayIncrementService;

            $this->sorter = new ListSorter('SalarayIncrement', 'payroll', $this->getUser(), array('s.inc_effective_date', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('payroll/SalarayIncrement');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 's.inc_effective_date' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $SalarayIncrementService->searchSalarayIncrementDetails($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->SalarayIncrementList = $res['data'];
            $this->SalarayCancelList = $SalarayIncrementService->getEmpProcessedDate();

            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeUpdateSalarayIncrement(sfWebRequest $request) {
        $SalarayIncrementService = new SalarayIncrementService;
        $this->myCulture = $this->getUser()->getCulture();
        //Table Lock code is Open
        if ($request->getParameter('id')) {
            $encrypt = new EncryptionHandler();
            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }
            $INCID = $encrypt->decrypt($request->getParameter('id'));
            $ID = explode("_", $INCID);
            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_pr_increment', array($ID[0], $ID[1], $ID[2]), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_pr_increment', array($ID[0], $ID[1], $ID[2]), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed


            $this->SalarayIncrement = $SalarayIncrementService->readSalarayIncrement($encrypt->decrypt($request->getParameter('id')));
            $SalarayIncrement = $this->SalarayIncrement;
            if (!$SalarayIncrement) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('payroll/SalarayIncrement');
            }
//die(print_r($SalarayIncrement));
        } else {
            //$SalarayIncrement = new PayrollIncrement();
            $this->lockMode = 1;
        }
        $this->type = $request->getParameter('type');
        if ($request->isMethod('post')) {

            try {

                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                //die(print_r($_POST));
                foreach ($_POST['hiddenEmpNumber'] as $key => $value) {
                    if (strlen($key)) {
                        if ($_POST['txtId'] != "__") {
                            $SalarayIncrement = $SalarayIncrementService->readSalarayIncrement($_POST['txtId']);
                        } else {
                            $SalarayIncrement = new PayrollIncrement();
                        }
                        if (strlen($_POST['hiddenEmpNumber'][$key])) {
                            $SalarayIncrement->setEmp_number($_POST['hiddenEmpNumber'][$key]);
                        }
                        if (strlen($_POST['hiddenIncrement'][$key])) {
                            $SalarayIncrement->setInc_amount($_POST['hiddenIncrement'][$key]);
                        } else {
                            $SalarayIncrement->setInc_amount(null);
                        }
                        if (strlen($_POST['hiddenPreviousSalary'][$key])) {
                            $SalarayIncrement->setInc_previous_salary($_POST['hiddenPreviousSalary'][$key]);
                        } else {
                            $SalarayIncrement->setInc_previous_salary(null);
                        }
                        if (strlen($_POST['hiddenNewSalary'][$key])) {
                            $SalarayIncrement->setInc_new_salary($_POST['hiddenNewSalary'][$key]);
                        } else {
                            $SalarayIncrement->setInc_new_salary(null);
                        }
                        if (strlen($_POST['hiddenGrade'][$key])) {
                            $SalarayIncrement->setInc_previous_grade_code($_POST['hiddenGrade'][$key]);
                        } else {
                            $SalarayIncrement->setInc_previous_grade_code(null);
                        }
                        if (strlen($_POST['hiddenPreviousSal'][$key])) {
                            $SalarayIncrement->setInc_previous_slt_scale_year($_POST['hiddenPreviousSal'][$key]);
                        } else {
                            $SalarayIncrement->setInc_previous_slt_scale_year(null);
                        }
                        if (strlen($_POST['hiddenGrade'][$key])) {
                            $SalarayIncrement->setInc_new_grade_code($_POST['hiddenGrade'][$key]);
                        } else {
                            $SalarayIncrement->setInc_new_grade_code(null);
                        }
                        if (strlen($_POST['hiddenNewSal'][$key])) {
                            $SalarayIncrement->setInc_new_slt_scale_year($_POST['hiddenNewSal'][$key]);
                        } else {
                            $SalarayIncrement->setInc_new_slt_scale_year(null);
                        }
                        if (strlen($_POST['txtcomment'][$key])) {
                            $SalarayIncrement->setInc_comment($_POST['txtcomment'][$key]);
                        } else {
                            $SalarayIncrement->setInc_comment(null);
                        }
                        if (strlen($_POST['chkconfirm'][$key] == "1")) {

                            $SalarayIncrement->setInc_confirm_flag("1");
                        } else {

                            $SalarayIncrement->setInc_confirm_flag(null);
                        }

                        if (strlen($_POST['txtEffectiveDate'] != null)) {
                            $SalarayIncrement->setInc_effective_date($_POST['txtEffectiveDate']);
                            $e = getdate();
                            $today = date("Y-m-d", $e[0]);
                            if (($today >= LocaleUtil::getInstance()->convertToStandardDateFormat($_POST['txtEffectiveDate'])) && ($_POST['chkconfirm'][$key] == "1")) {

                                $NewSalary = $SalarayIncrementService->getNewSalary($_POST['hiddenNewSal'][$key], $_POST['hiddenGrade'][$key]);
                                $NewSalary = $NewSalary[0]->emp_basic_salary;
                                //die(print_r($_POST['hiddenEmpNumber'][$key]));
                                $SalarayIncrementService->updateEmployeeSalary($_POST['hiddenEmpNumber'][$key], $_POST['hiddenGrade'][$key], $_POST['hiddenNewSal'][$key]);
                                $SalarayIncrementService->updateEmployeeEligibility($_POST['hiddenEmpNumber'][$key], $NewSalary);
                            }
                        }

                        if (strlen($_POST['chkCancel'] == "1")) {
                            $SalarayIncrement->setInc_cancel_flag("1");
                            $PayrollIncrementCancel = new PayrollIncrementCancel();
                            //----
                            if (strlen($_POST['hiddenEmpNumber'][$key])) {
                                $PayrollIncrementCancel->setEmp_number($_POST['hiddenEmpNumber'][$key]);
                            }
                            if (strlen($_POST['hiddenIncrement'][$key])) {
                                $PayrollIncrementCancel->setInc_amount($_POST['hiddenIncrement'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_amount(null);
                            }
                            if (strlen($_POST['hiddenPreviousSalary'][$key])) {
                                $PayrollIncrementCancel->setInc_previous_salary($_POST['hiddenPreviousSalary'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_previous_salary(null);
                            }
                            if (strlen($_POST['hiddenNewSalary'][$key])) {
                                $PayrollIncrementCancel->setInc_new_salary($_POST['hiddenNewSalary'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_new_salary(null);
                            }
                            if (strlen($_POST['hiddenGrade'][$key])) {
                                $PayrollIncrementCancel->setInc_previous_grade_code($_POST['hiddenGrade'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_previous_grade_code(null);
                            }
                            if (strlen($_POST['hiddenPreviousSal'][$key])) {
                                $PayrollIncrementCancel->setInc_previous_slt_scale_year($_POST['hiddenPreviousSal'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_previous_slt_scale_year(null);
                            }
                            if (strlen($_POST['hiddenGrade'][$key])) {
                                $PayrollIncrementCancel->setInc_new_grade_code($_POST['hiddenGrade'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_new_grade_code(null);
                            }
                            if (strlen($_POST['hiddenNewSal'][$key])) {
                                $PayrollIncrementCancel->setInc_new_slt_scale_year($_POST['hiddenNewSal'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_new_slt_scale_year(null);
                            }
                            if (strlen($_POST['txtcomment'][$key])) {
                                $PayrollIncrementCancel->setInc_comment($_POST['txtcomment'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_comment(null);
                            }
                            if (strlen($_POST['chkconfirm'][$key] == "1")) {
                                $PayrollIncrementCancel->setInc_confirm_flag($_POST['chkconfirm'][$key]);
                            } else {
                                $PayrollIncrementCancel->setInc_confirm_flag(null);
                            }
                            if (strlen($_POST['txtEffectiveDate'] != null)) {
                                $PayrollIncrementCancel->setInc_effective_date($_POST['txtEffectiveDate']);
                            } else {
                                $PayrollIncrementCancel->setInc_effective_date(null);
                            }

                            if (strlen($_POST['chkCancel'] != null)) {
                                $PayrollIncrementCancel->setInc_cancel_flag("1");
                            }

                            if (strlen($_POST['txtCancelComment'] != null)) {
                                $PayrollIncrementCancel->setInc_cancel_comment($_POST['txtCancelComment']);
                            }
                            $SalarayIncrementService->saveSalarayIncrementCancel($PayrollIncrementCancel);
                            $SalarayIncrementService->updateEmployeeSalary($_POST['hiddenEmpNumber'][$key], $_POST['hiddenGrade'][$key], $_POST['hiddenPreviousSal'][$key]);
                            //----
                        }

                        if (strlen($_POST['txtCancelComment'] != null)) {
                            $SalarayIncrement->setInc_cancel_comment($_POST['txtCancelComment']);
                        }

                        $SalarayIncrementService->saveSalarayIncrement($SalarayIncrement);
                        if (strlen($_POST['chkCancel'] == "1")) {
                            $SalarayIncrementService->deleteIncrement($_POST['hiddenEmpNumber'][$key], $_POST['hiddenNewSal'][$key], $_POST['hiddenGrade'][$key], "1980-01-01");
                        }
                    }
                }
                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                if ($_POST['txtId'] != "__") {
                    $this->redirect('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($_POST['txtId']) . '&lock=0');
                } else {
                    $this->redirect('payroll/SalarayIncrement');
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                if ($_POST['txtId'] != "__") {
                    $this->redirect('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($_POST['txtId']) . '&lock=0');
                } else {
                    $this->redirect('payroll/SalarayIncrement');
                }
            }
            if ($_POST['txtId'] != "__") {
                if ($_POST['chkCancel'] == null) {
                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                    $this->redirect('payroll/UpdateSalarayIncrement?id=' . $encrypt->encrypt($_POST['txtId']) . '&lock=0');
                } else {
                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Canceled", $args, 'messages')));
                    $this->redirect('payroll/SalarayIncrementCancel');
                }
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('payroll/SalarayIncrement');
            }
        }
    }

    public function executeLoadGrid(sfWebRequest $request) {
        $culture = $this->getUser()->getCulture();
        $SalarayIncrementService = new SalarayIncrementService;

        $empId = $request->getParameter('empid');
        $type = $request->getParameter('type');
        $id = $request->getParameter('id');
        if ($type == "save") {
            $emplist = $SalarayIncrementService->getEmployee($empId);

            $arr = Array();
            $Employee = Array();


            foreach ($emplist as $row) {

                if ($culture == "en") {
                    $abc = "emp_display_name";
                } else {
                    $abc = "emp_display_name_" . $culture;
                }

                $Slot = $SalarayIncrementService->getGradeSlotByIDIncrement($row->grade_code, $row->slt_scale_year);
                $newSlot = $SalarayIncrementService->getGradeSlotByID($row->grade_code, ($Slot->slt_scale_year + 1));
//                
                $previousSal = $Slot->emp_basic_salary;
                $newSal = $newSlot->emp_basic_salary;

                $previousSalID = $row->slt_scale_year;
                $newSalID = $newSlot->slt_id;
                $gradeID = $row->grade_code;

                $increment = $newSlot->emp_basic_salary - $Slot->emp_basic_salary;

                if ($previousSal != null && $newSal != null && $increment != null) {
                    $arr[$row['empNumber']] = $row->employeeId . "|" . $row->$abc . "|" . $previousSal . "|" . $newSal . "|" . $increment . "|" . $previousSalID . "|" . $newSalID . "|" . $gradeID . "|" . $row->empNumber. "|" . $row->emp_salary_inc_date;
                } else {
                    $Employee[$row['empNumber']] = $row->employeeId . "|" . $row->$abc;
                }
            }


            echo json_encode(Array($arr, $Employee));
            die;
        } else {
            $arr = Array();
            $Employee = Array();

            if ($culture == "en") {
                $abc = "emp_display_name";
            } else {
                $abc = "emp_display_name_" . $culture;
            }

            $Employee = $SalarayIncrementService->readSalarayIncrement($id);
            $arr[$Employee->emp_number] = $Employee->Employee->employeeId . "|" . $Employee->Employee->$abc . "|" . $Employee->inc_previous_salary . "|" . $Employee->inc_new_salary . "|" . $Employee->inc_amount . "|" . $Employee->inc_previous_slt_scale_year . "|" . $Employee->inc_new_slt_scale_year . "|" . $Employee->inc_new_grade_code . "|" . $Employee->emp_number. "|" . $Employee->Employee->emp_salary_inc_date;
            echo json_encode(Array($arr, $Employee));
            die;
        }
    }

    public function executePayrollProcess(sfWebRequest $request) {
        die("Payroll Process");
    }

    /**
     *  Payroll Bank Inforamtion
     *  
     */
    public function executeBankDetails(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();
            $BankService = new BankService;

            $this->sorter = new ListSorter('BankDetails', 'payroll', $this->getUser(), array('b.bank_code', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('payroll/BankDetails');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'b.bank_code' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $BankService->searchBankDetails($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->BankList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeUpdateBankDetails(sfWebRequest $request) {
        $BankService = new BankService();
        $this->myCulture = $this->getUser()->getCulture();
        //Table Lock code is Open
        if ($request->getParameter('id')) {
            $encrypt = new EncryptionHandler();
            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }
            $VTID = $encrypt->decrypt($request->getParameter('id'));
            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_hr_bank', array($VTID), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_hr_bank', array($VTID), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed


            $BankDetail = $BankService->readBankDetails($encrypt->decrypt($request->getParameter('id')));
            if (!$BankDetail) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('payroll/BankDetails');
            }
        } else {
            $BankDetail = new PayRollBank();
            $this->lockMode = 1;
        }
        $this->BankDetail = $BankDetail;
        $this->ParentBankList = $BankService->getParentBankList();
        if ($request->isMethod('post')) {
            if (strlen($request->getParameter('txtBankCode'))) {
                $BankDetail->setBank_user_code(trim($request->getParameter('txtBankCode')));
            } else {
                $BankDetail->setBank_user_code(null);
            }
            if (strlen($request->getParameter('txtBankName'))) {
                $BankDetail->setBank_name(trim($request->getParameter('txtBankName')));
            } else {
                $BankDetail->setBank_name(null);
            }
            if (strlen($request->getParameter('txtBankNameSi'))) {
                $BankDetail->setBank_name_si(trim($request->getParameter('txtBankNameSi')));
            } else {
                $BankDetail->setBank_name_si(null);
            }
            if (strlen($request->getParameter('txtBankNameTa'))) {
                $BankDetail->setBank_name_ta(trim($request->getParameter('txtBankNameTa')));
            } else {
                $BankDetail->setBank_name_ta(null);
            }
            if (strlen($request->getParameter('txtBankAddress'))) {
                $BankDetail->setBank_address(trim($request->getParameter('txtBankAddress')));
            } else {
                $BankDetail->setBank_address(null);
            }
            if (strlen($request->getParameter('txtBankAddressSi'))) {
                $BankDetail->setBank_address_si(trim($request->getParameter('txtBankAddressSi')));
            } else {
                $BankDetail->setBank_address_si(null);
            }
            if (strlen($request->getParameter('txtBankAddressTa'))) {
                $BankDetail->setBank_address_ta(trim($request->getParameter('txtBankAddressTa')));
            } else {
                $BankDetail->setBank_address_ta(null);
            }
            if (strlen($request->getParameter('cmbParentBank'))) {
                $BankDetail->setBnk_mainbank(trim($request->getParameter('cmbParentBank')));
            } else {
                $BankDetail->setBnk_mainbank(null);
            }
            if (strlen($request->getParameter('chkmainbank'))) {
                $BankDetail->setBnk_main(trim($request->getParameter('chkmainbank')));
            } else {
                $BankDetail->setBnk_main(null);
            }
            if ($request->getParameter('BankCode') == null) {
                $Max = $BankService->getMaxBank();
                $BankDetail->setBank_code($Max[0]['max'] + 1);
            }

            try {
                $BankService->saveBankDetails($BankDetail);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('BankCode') != null) {
                    $this->redirect('payroll/UpdateBankDetails?id=' . $encrypt->encrypt($request->getParameter('BankCode')) . '&lock=0');
                } else {
                    $this->redirect('payroll/BankDetails');
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('BankCode') != null) {
                    $this->redirect('payroll/UpdateBankDetails?id=' . $encrypt->encrypt($request->getParameter('BankCode')) . '&lock=0');
                } else {
                    $this->redirect('payroll/BankDetails');
                }
            }
            if ($request->getParameter('BankCode') != null) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                $this->redirect('payroll/UpdateBankDetails?id=' . $encrypt->encrypt($request->getParameter('BankCode')) . '&lock=0');
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('payroll/BankDetails');
            }
        }
    }

    public function executeDeleteBankDetails(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $BankService = new BankService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_bank', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $BankService->deleteBankDetails($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_bank', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/BankDetails');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/BankDetails');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("The record can not be deleted, the details have been used elsware in the system.", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('payroll/BankDetails');
    }

    /**
     *  Payroll Branch Inforamtion
     *  
     */
    public function executeBranchDetails(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();
            $BankService = new BankService;

            $this->sorter = new ListSorter('BranchDetails', 'payroll', $this->getUser(), array('b.bbranch_code', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('payroll/BranchDetails');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'b.bbranch_code' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $BankService->searchBranchDetails($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->BranchList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeUpdateBranchDetails(sfWebRequest $request) {
        $BankService = new BankService();
        $this->myCulture = $this->getUser()->getCulture();
        //Table Lock code is Open
        if ($request->getParameter('id')) {
            $encrypt = new EncryptionHandler();
            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }
            $VTID = $encrypt->decrypt($request->getParameter('id'));
            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_hr_branch', array($VTID), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_hr_branch', array($VTID), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed


            $BranchDetail = $BankService->readBranchDetails($encrypt->decrypt($request->getParameter('id')));
            if (!$BranchDetail) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('payroll/BranchDetails');
            }
        } else {
            $BranchDetail = new PayRollBranch();
            $this->lockMode = 1;
        }
        $this->BranchDetail = $BranchDetail;
        $this->BankList = $BankService->getBankList();
        if ($request->isMethod('post')) {
            if (strlen($request->getParameter('txtBranchCode'))) {
                $BranchDetail->setBbranch_user_code(trim($request->getParameter('txtBranchCode')));
            } else {
                $BranchDetail->setBbranch_user_code(null);
            }
            if (strlen($request->getParameter('txtBranchName'))) {
                $BranchDetail->setBbranch_name(trim($request->getParameter('txtBranchName')));
            } else {
                $BranchDetail->setBbranch_name(null);
            }
            if (strlen($request->getParameter('txtBranchNameSi'))) {
                $BranchDetail->setBbranch_name_si(trim($request->getParameter('txtBranchNameSi')));
            } else {
                $BranchDetail->setBbranch_name_si(null);
            }
            if (strlen($request->getParameter('txtBranchNameTa'))) {
                $BranchDetail->setBbranch_name_ta(trim($request->getParameter('txtBranchNameTa')));
            } else {
                $BranchDetail->setBbranch_name_ta(null);
            }
            if (strlen($request->getParameter('txtBranchAddress'))) {
                $BranchDetail->setBbranch_address(trim($request->getParameter('txtBranchAddress')));
            } else {
                $BranchDetail->setBbranch_address(null);
            }
            if (strlen($request->getParameter('txtBranchAddressSi'))) {
                $BranchDetail->setBbranch_address_si(trim($request->getParameter('txtBranchAddressSi')));
            } else {
                $BranchDetail->setBbranch_address_si(null);
            }
            if (strlen($request->getParameter('txtBranchAddressTa'))) {
                $BranchDetail->setBbranch_address_ta(trim($request->getParameter('txtBranchAddressTa')));
            } else {
                $BranchDetail->setBbranch_address_ta(null);
            }
            if (strlen($request->getParameter('cmbBank'))) {
                $BranchDetail->setBank_code(trim($request->getParameter('cmbBank')));
            } else {
                $BranchDetail->setBank_code(null);
            }
            if (strlen($request->getParameter('chkslip'))) {
                $BranchDetail->setBbranch_sliptransfers_flg(trim($request->getParameter('chkslip')));
            } else {
                $BranchDetail->setBbranch_sliptransfers_flg(null);
            }
            if ($request->getParameter('BranchCode') == null) {
                $Max = $BankService->getMaxBranch();
                $BranchDetail->setBbranch_code($Max[0]['max'] + 1);
            }

            try {
                $BankService->saveBranchDetails($BranchDetail);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('BranchCode') != null) {
                    $this->redirect('payroll/UpdateBranchDetails?id=' . $encrypt->encrypt($request->getParameter('BranchCode')) . '&lock=0');
                } else {
                    $this->redirect('payroll/BranchDetails');
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('BranchCode') != null) {
                    $this->redirect('payroll/UpdateBranchDetails?id=' . $encrypt->encrypt($request->getParameter('BranchCode')) . '&lock=0');
                } else {
                    $this->redirect('payroll/BranchDetails');
                }
            }
            if ($request->getParameter('BranchCode') != null) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                $this->redirect('payroll/UpdateBranchDetails?id=' . $encrypt->encrypt($request->getParameter('BranchCode')) . '&lock=0');
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('payroll/BranchDetails');
            }
        }
    }

    public function executeDeleteBranchDetails(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $BankService = new BankService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_branch', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $BankService->deleteBranchDetails($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_branch', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/BranchDetails');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/BranchDetails');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('payroll/BranchDetails');
    }

    /**
     *  Payroll Vote Inforamtion
     *  
     */
    public function executeVoteDetails(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $AdministrationService = new AdministrationService;

            $this->sorter = new ListSorter('VoteDetails', 'payroll', $this->getUser(), array('v.vt_typ_code', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('payroll/VoteDetails');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'v.vt_typ_code' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $AdministrationService->searchVoteDetails($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->VoteList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeTransActionTypeInfo(sfWebRequest $request) {
        try {

            if (!strlen($request->getParameter('lock'))) {

                $this->mode = 0;
            } else {
                $this->mode = $request->getParameter('lock');
            }
            $encryption = new EncryptionHandler();
            $Lockid = $encryption->decrypt($request->getParameter('tId'));
            if (isset($this->mode)) {
                if ($this->mode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_pr_transaction_type', array($Lockid), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_pr_transaction_type', array($Lockid), 1);
                    $this->mode = 0;
                }
            }



            $this->userCulture = $this->getUser()->getCulture();
            $transActionService = new TransactionService();



            if (strlen($request->getParameter('tId'))) {
                $tTypeId = $encryption->decrypt($request->getParameter('tId'));
            }


            if (strlen($tTypeId)) {
                if (!strlen($this->mode)) {

                    $this->mode = 0;
                }
                $this->tType = $transActionService->readTtype($tTypeId);

                if ((!$this->tType)) {
                    //die($this->tType->trn_typ_code);
                    $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                    $this->redirect('payroll/TransActionTypeInfo');
                }
            } else {
                $this->defaultTId = $transActionService->getDefaultTransactionTypeId();
                $this->mode = 1;
            }


            if ($request->isMethod('post')) {

                $transActionService->saveObj($request);
                if($this->tType == null){
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                $this->redirect('payroll/TransActiontypeSummary');
                }else{
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                $this->redirect('payroll/TransActiontypeSummary');
                }
                
            }
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('payroll/TransActiontypeSummary');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('payroll/TransActiontypeSummary');
        }
    }

    public function executeDeleteTransactionType(sfWebRequest $request) {


        if (count($request->getParameter('chkLocID')) > 0) {

            $TransService = new TransactionService();

            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_pr_transaction_type', array($ids[$i]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];

                        $TransService->deleteTranaActionType($ids[$i]);
                        $conHandler->resetTableLock('hs_pr_transaction_type', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/TransActiontypeSummary');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/TransActiontypeSummary');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('payroll/TransActiontypeSummary');
    }

    public function executeTransActiontypeSummary(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();



            $transActionService = new TransactionService();

            $this->sorter = new ListSorter('payroll.sort', 'payroll', $this->getUser(), array('trn_typ_code', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('default/error');
                }
            }
            //die($request->getParameter('searchMode'));
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.trn_typ_code' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $transActionService->searchTransactiontypes($this->searchMode, $this->searchValue, $this->Culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->listTtypes = $res['data'];

            //die($this->listreasons);
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeUpdateVoteDetails(sfWebRequest $request) {
        $AdministrationService = new AdministrationService;
        $this->myCulture = $this->getUser()->getCulture();
        //Table Lock code is Open
        if ($request->getParameter('id')) {
            $encrypt = new EncryptionHandler();
            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }
            $VTID = $encrypt->decrypt($request->getParameter('id'));
            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_pr_vote_info', array($VTID), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_pr_vote_info', array($VTID), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed


            $PayrollVote = $AdministrationService->readVoteDetails($encrypt->decrypt($request->getParameter('id')));
            if (!$PayrollVote) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('payroll/VoteDetails');
            }
        } else {
            $PayrollVote = new PayrollVote();
            $this->lockMode = 1;
        }
        $this->PayrollVote = $PayrollVote;
        $this->PayrollVoteTypeList = $AdministrationService->getVoteType();
        if ($request->isMethod('post')) {
            if (strlen($request->getParameter('txtVoteCode'))) {
                $PayrollVote->setVt_typ_user_code(trim($request->getParameter('txtVoteCode')));
            } else {
                $PayrollVote->setVt_typ_user_code(null);
            }
            if (strlen($request->getParameter('txtVoteName'))) {
                $PayrollVote->setVt_typ_name(trim($request->getParameter('txtVoteName')));
            } else {
                $PayrollVote->setVt_typ_name(null);
            }
            if (strlen($request->getParameter('txtVoteNameSi'))) {
                $PayrollVote->setVt_typ_name_si(trim($request->getParameter('txtVoteNameSi')));
            } else {
                $PayrollVote->setVt_typ_name_si(null);
            }
            if (strlen($request->getParameter('txtVoteNameTa'))) {
                $PayrollVote->setVt_typ_name_ta(trim($request->getParameter('txtVoteNameTa')));
            } else {
                $PayrollVote->setVt_typ_name_ta(null);
            }
            if (strlen($request->getParameter('cmbVoteType'))) {
                $PayrollVote->setVt_inf_type_code(trim($request->getParameter('cmbVoteType')));
            } else {
                $PayrollVote->setVt_inf_type_code(null);
            }


            try {
                $AdministrationService->saveVoteDetails($PayrollVote);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('VoteCode') != null) {
                    $this->redirect('payroll/UpdateVoteDetails?id=' . $encrypt->encrypt($request->getParameter('VoteCode')) . '&lock=0');
                } else {
                    $this->redirect('payroll/VoteDetails');
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('VoteCode') != null) {
                    $this->redirect('payroll/UpdateVoteDetails?id=' . $encrypt->encrypt($request->getParameter('VoteCode')) . '&lock=0');
                } else {
                    $this->redirect('payroll/VoteDetails');
                }
            }
            if ($request->getParameter('VoteCode') != null) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                $this->redirect('payroll/UpdateVoteDetails?id=' . $encrypt->encrypt($request->getParameter('VoteCode')) . '&lock=0');
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('payroll/VoteDetails');
            }
        }
    }

    public function executeDeleteVoteDetails(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $AdministrationService = new AdministrationService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_pr_vote_info', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $AdministrationService->deleteVoteDetails($ids[$i]);
                        $conHandler->resetTableLock('hs_pr_vote_info', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/VoteDetails');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/VoteDetails');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('payroll/VoteDetails');
    }

    public function executeTransActDetails(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
        $BankService = new BankService();
        $this->BankList = $BankService->getBankList();
        $this->BranchList = $BankService->getBranchfromBank($bankno);
        try {

            if (!strlen($request->getParameter('lock'))) {

                $this->mode = 0;
            } else {
                $this->mode = $request->getParameter('lock');
            }
            $encryption = new EncryptionHandler();
            $Lockid = $encryption->decrypt($request->getParameter('tDetailId'));
            $this->Lockid = $encryption->decrypt($request->getParameter('tDetailId'));
            $this->userCulture = $this->getUser()->getCulture();

            if (isset($this->mode)) {
                if ($this->mode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_pr_transaction_details', array($Lockid), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {

                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_pr_transaction_details', array($Lockid), 1);
                    $this->mode = 0;
                }
            }


            $transActionService = new TransactionService();
            $this->transTypeList = $transActionService->getAllTransType();

            if (strlen($request->getParameter('tDetailId'))) {
                $tDetailId = $encryption->decrypt($request->getParameter('tDetailId'));
            }

//               die(print_r($tDetailId));
            if (strlen($tDetailId)) {
                if (!strlen($this->mode)) {
                    $this->mode = 0;
                }
                $this->tDType = $transActionService->readTDetailtype($tDetailId);
                $this->transactionType = $this->tDType->trn_typ_code;
                if ((!strlen($tDetailId))) {

                    $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                    $this->redirect('payroll/TransActionDetailSummary');
                }
          } else { 

                $this->defaultTDId = $transActionService->getDefaultTransactionDetailId();
//                die($this->defaultTDId );
                $this->mode = 1;
            }
            $this->TransActionDetailId = $encryption->decrypt($request->getParameter('tDetailId'));
            // Get Transaction types
            $this->transTypeList = $transActionService->getAllTransType();

            $this->transDetailsList = $transActionService->getAllTransactionDetailsForBase($this->TransActionDetailId);

            $this->transTypeListByfilter = $transActionService->getAllTransTypeByFilter();

            //Get contribution list
            $this->allContributionList = $transActionService->getAllContList();
            //$this->transActionListByConID=$transActionService->transActionListByConID($tDetailId);


            $this->contList = $transActionService->getContListByID($tDetailId);
            $this->contributeTypeId = array();
            foreach ($this->contList as $key => $value) {
                $this->contributeTypeId[] = $value->trn_dtl_code;
            }



            $this->contListByfilter = $transActionService->getcontTypeForFilter($tDetailId);
            $this->contributeTypeIdByFilter = array();
            foreach ($this->contListByfilter as $key => $value) {
                $this->contributeTypeIdByFilter[] = $value->trn_dtl_base_code;
            }
            $this->baseTransListArr = array();
            $this->baseTransList = $transActionService->getBaseTransListByID($tDetailId);
            foreach ($this->baseTransList as $key => $value) {
                $this->baseTransListArr[] = $value->trn_dtl_base_code;
            }


            if ($request->isMethod('post')) { //die(print_r($_POST));

                $transActionService->saveDetailObj($request);


                $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                $this->redirect('payroll/TransActionDetailSummary');
            }
        }
        catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('payroll/TransActionDetailSummary');
        }
        catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('payroll/TransActionDetailSummary');
        }
    }

    public function executeTransActionDetailSummary(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();



            $transActionService = new TransactionService();

            $this->sorter = new ListSorter('payroll.sort', 'payroll', $this->getUser(), array('trn_typ_code', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('default/error');
                }
            }
            //die($request->getParameter('searchMode'));
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.trn_dtl_code' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $transActionService->searchTransactionDetails($this->searchMode, $this->searchValue, $this->Culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->listTtypes = $res['data'];

            //die($this->listreasons);
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeAjaxConfiguarationLoadPeriod(sfWebRequest $request) {

        $Year = $request->getParameter('Year');
        $ComCode = $request->getParameter('compcode');
        $AdministrationService = new AdministrationService();
        $Shedule = $AdministrationService->readConfigurationShedulePerYear($Year, $ComCode);
        
        if ($Shedule[0] == null) {

            for ($i = 1; $i < 13; $i++) {
                $StartDate[$i] = "{$Year}-{$i}-01";
                $EndDate[$i] = date('Y-m-t', strtotime("{$Year}-{$i}-01"));

                $MaxID = $AdministrationService->getMax();
                $Max = $MaxID['Max'] + 1;

                $PayrollSchedule = new PayrollScheduleMaster();
                $PayrollSchedule->setPay_sch_id($Max);
                $PayrollSchedule->setPay_sch_st_date($StartDate[$i]);
                $PayrollSchedule->setPay_sch_end_date($EndDate[$i]);
                $PayrollSchedule->setPay_sch_processed_flg(null);
                $PayrollSchedule->setPay_sch_disabled_flg(0);
                $PayrollSchedule->setPay_sch_year($Year);
                $PayrollSchedule->setPay_sch_month($i);
                $PayrollSchedule->setPay_hie_code($ComCode);
                //$AdministrationService->saveShedule($PayrollSchedule);
                $PayrollSchedule->save();
            }
        }

        $Shedule = $AdministrationService->readConfigurationShedulePerYear($Year, $ComCode);
        //die(print_r($Shedule));
        if ($_SESSION['user'] == "USR001") {
            $this->redirect('pim/list');
        } else if (strlen($_SESSION['empNumber'])) {
            $this->Employee = $AdministrationService->readEmployee($_SESSION['empNumber']);
        }

        $Employee = $this->Employee;

//        if ($Employee->Users->def_level == 2) {

            $MaxLockID = $AdministrationService->getMaxLockID($Employee->hie_code_2);
            $MaxUnlockID = $AdministrationService->getMaxUnlockID($Employee->hie_code_2);
//        } else {
//            $MaxLockID = $AdministrationService->getMaxLockID($Employee->hie_code_4);
//            $MaxUnlockID = $AdministrationService->getMaxUnlockID($Employee->hie_code_4);
//        }


        $this->LockID = $MaxLockID['pay_sch_id'];
        $this->UnlockID = $MaxUnlockID['pay_sch_id'];


        echo json_encode($Shedule);
        die;
    }

    public function executeAjaxConfiguarationLockUnlockPeriod(sfWebRequest $request) {

        $id = $request->getParameter('id');
        $Type = $request->getParameter('Type');
        $AdministrationService = new AdministrationService();
        $PayrollSchedule = $AdministrationService->readConfigurationShedule($id);

        if ($PayrollSchedule->pay_sch_id != null) {
            if ($Type == 'Lock') {
                $PayrollSchedule->setPay_sch_disabled_flg(1);
            } else {
                $PayrollSchedule->setPay_sch_disabled_flg(0);
            }
                $PayrollSchedule->save();
            //$AdministrationService->saveShedule($PayrollSchedule);
        }


        echo json_encode("true");
        die;
    }

    public function executeDeleteTransactionDetails(sfWebRequest $request) {

        if (count($request->getParameter('chkLocID')) > 0) {

            $TransService = new TransactionService();

            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_pr_transaction_details', array($ids[$i]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];

                        $TransService->deleteTranaActionBase($ids[$i]);
                        $TransService->deleteTranaActionContibution($ids[$i]);
                        $TransService->deleteTranaActionDetails($ids[$i]);


                        $conHandler->resetTableLock('hs_pr_transaction_details', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/TransActionDetailSummary');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/TransActionDetailSummary');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('payroll/TransActionDetailSummary');
    }

    public function executePayProcess(sfWebRequest $request) {

        //die(shell_exec('css ls -lart'));
        $currentDir = getcwd();

        chdir(sfConfig::get('sf_root_dir'));



// Instantiate the task and run it

        $task = new doNothingTask($this->dispatcher, new sfFormatter());

        $task->run();
        chdir($currentDir);

        sfContext::switchTo('orangehrm');
    }

    public function executeAssignEmployees(sfWebRequest $request) {
        try {

            if (!strlen($request->getParameter('lock'))) {

                $this->mode = 0;
            } else {
                $this->mode = $request->getParameter('lock');
            }
            $encryption = new EncryptionHandler();
            $Lockid = $encryption->decrypt($request->getParameter('tDetailId'));
            if (isset($this->mode)) {
                if ($this->mode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    //$recordLocked = $conHandler->setTableLock('hs_pr_txn_eligibility', array($Lockid), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    //$recordLocked = $conHandler->resetTableLock('hs_pr_txn_eligibility', array($Lockid), 1);
                    $this->mode = 0;
                }
            }

            $AdministrationService = new AdministrationService();
            $loggedEmp = $_SESSION['empNumber'];

            $this->shedule = $AdministrationService->readConfigurationShedule($loggedEmp);
            //print_r($this->shedule);

            // start the summary view
            $this->transTypeId = $request->getParameter('transTypeId');
            $this->transDetailId = $request->getParameter('transDetailId');
            $this->baseTrn = $request->getParameter('baseTrn');

            $this->userCulture = $this->getUser()->getCulture();
            $transActionService = new TransactionService();
            $AssignEmpService = new AssignEmployeeService();
            if (strlen($this->transDetailId)) {
                $TransTypeType1 = $AssignEmpService->getTypeTypeByDetailId($this->transDetailId);
                $TransTypeType = $TransTypeType1[0]->PRTransActiontype->trn_typ_type;
                $this->transTypeType = $TransTypeType;
                $this->transErndedcon = $TransTypeType1[0]->PRTransActiontype->erndedcon;
            }

            $this->transTypeList = $transActionService->getAllTransType();
            $this->transDetailsList = $transActionService->getAllTransactionDetails();

            $this->Culture = $this->getUser()->getCulture();

            if ($this->transTypeId && $this->transDetailId) {

                $this->sorter = new ListSorter('payroll.sort', 'payroll', $this->getUser(), array('emp_number', ListSorter::ASCENDING));

                $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));


                //die($request->getParameter('searchMode'));
                $this->fromDate = ($request->getParameter('fromdate') == '') ? '' : $request->getParameter('fromdate');
                $this->toDate = ($request->getParameter('toDate') == '') ? '' : $request->getParameter('toDate');

                $this->sort = "";
                $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
//            die($this->fromDate);
                $res = $AssignEmpService->getAssignedEmployees($this->fromDate, $this->toDate, $this->Culture, $request->getParameter('page'), $this->sort, $this->order, $this->transDetailId);
                $this->assignedEmployees = $res['data'];
                $this->assignedAllEmployees = $AssignEmpService->getAssignedAllEmployees($this->transDetailId);


                //die($this->listreasons);
                $this->pglay = $res['pglay'];
                $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
                $this->pglay->setSelectedTemplate('{%page}');
            }
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            if ($request->isMethod('post')) {
//                    die(print_r($_POST));

                $transDetailID = $request->getParameter('cmbTransDetails');
                $transID = $request->getParameter('cmbTransType');
                $chkApplytoAll = $request->getParameter('chkApplytoAll');
                $baseTrn = $request->getParameter('basetrnyes');
                if($request->getParameter('txtAmountToApplyAllA')!= null){ 
                $txtAppAllAmount = $request->getParameter('txtAmountToApplyAllA');
                }  elseif ($request->getParameter('txtAmountToApplyAllB')!= null) {
                $txtAppAllAmount = $request->getParameter('txtAmountToApplyAllB');    
                }
                
                if($request->getParameter('txtAmountToApplyAllC')!= null){ 
                $txtEmpyee = $request->getParameter('txtAmountToApplyAllC');
                } 
                if($request->getParameter('txtAmountToApplyAllC2')!= null){ 
                $txtEmloyeer = $request->getParameter('txtAmountToApplyAllC2');
                }   
                    $txtFromDateApplyAll = $request->getParameter('txtFromDateApplyAll');
                    $txtToDateApplyAll = $request->getParameter('txtToDateApplyAll');
                  $EMPL  = $request->getParameter('listemp');
                  $LEMP = explode(",", $EMPL);  
                if ($txtAppAllAmount != null || $txtEmpyee != null || $txtEmloyeer != null) {
//                    $txtAppAllAmount = $request->getParameter('txtAmountToApplyAll');
//                    $txtFromDateApplyAll = $request->getParameter('txtFromDateApplyAll');
//                    $txtToDateApplyAll = $request->getParameter('txtToDateApplyAll');
                    $AssignEmpService->saveElgToAll($transID, $transDetailID, $txtAppAllAmount, $txtFromDateApplyAll, $txtToDateApplyAll,$LEMP,$txtEmpyee,$txtEmloyeer);
                } else {
                    $exploed = array();
                    $count_rows = array();
                    foreach ($_POST as $key => $value) {


                        $exploed = explode("_", $key);

                        if (strlen($exploed[1])) {
                            $count_rows[] = $exploed[1];

                            $arrname = "a_" . $exploed[1];

                            if (!is_array($$arrname)) {
                                $$arrname = Array();
                            }

                            ${$arrname}[$exploed[0]] = $value;
                        }
                    }



                    $uniqueRowIds = array_unique($count_rows);
                    $uniqueRowIds = array_values($uniqueRowIds);

//                       print_r($uniqueRowIds);die;

                    for ($i = 0; $i < count($uniqueRowIds); $i++) {

                        $v = "a_" . $uniqueRowIds[$i];

                        if (strlen(${$v}[hiddenEmp])) {
                            $empEligibility = $AssignEmpService->readEligibility(${$v}[hiddenEmp], $transDetailID);
                        }
                        if ($empEligibility) {

                            $empEligibility = $AssignEmpService->readEligibility(${$v}[hiddenEmp], $transDetailID);
                        } else {
                            $empEligibility = new PayRollEligibility();
                        }

                        $empEligibility->setEmp_number(${$v}[hiddenEmp]);

                        $empEligibility->setTrn_dtl_code($transDetailID);

                        if (!strlen(${$v}[txtAmount])) {
                            $empEligibility->setTre_amount(null);
                        } else {
                            $empEligibility->setTre_amount(${$v}[txtAmount]);
                        }
                        if (!strlen(${$v}[txtFromDate])) {
                            $empEligibility->setTrn_dtl_startdate(date("Y-m-d"));
                        } else {
                            $empEligibility->setTrn_dtl_startdate(${$v}[txtFromDate]);
                        }
                        if (!strlen(${$v}[txtToDate])) {
                            $empEligibility->setTrn_dtl_enddate(date("Y-m-d"));
                        } else {
                            $empEligibility->setTrn_dtl_enddate(${$v}[txtToDate]);
                        }
                        if (strlen(${$v}[chkEnable])) {
                            $empEligibility->setTre_stop_flag(0);
                        } else {
                            $empEligibility->setTre_stop_flag(1);
                        }
                        if (!strlen(${$v}[txtEmpCon])) {
                            $empEligibility->setTre_empcon(null);
                        } else {
                            $empEligibility->setTre_empcon(${$v}[txtEmpCon]);
                        }
                        if (!strlen(${$v}[txtEmpCon])) {
                            $empEligibility->setTre_eyrcon(null);
                        } else {
                            $empEligibility->setTre_eyrcon(${$v}[txtEyrCon]);
                        }


                        $empEligibility->setDbgroup_user_id("1");
                        $AssignEmpService->saveElg($empEligibility);
                    }
                }
                $conn->commit();
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));

                $this->redirect('payroll/AssignEmployees?transTypeId=' . $transID . '&transDetailId=' . $transDetailID . '&baseTrn=' . $baseTrn);
            }
        }

        catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
        catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeGetTransdetailsByAjax(sfWebRequest $request) {

        $this->culture = $this->getUser()->getCulture();
        $value = $request->getParameter('value');

        $assignDao = new AssignEmployeeDao();
        $transDetails = $assignDao->getTransDetailByID($value);
        $isVaribleType = $assignDao->getTransTypeTypeByID($value);
        $typeType = $isVaribleType[0]->trn_typ_type;
        $ernDen = $isVaribleType[0]->erndedcon;

        $arr = Array();


        foreach ($transDetails as $row) {

            if ($this->culture == "en") {
                $n = "trn_dtl_name";
            } else {
                $n = "trn_dtl_name_" . $this->culture;
                if ($row[$n] == null) {
                    $n = "trn_dtl_name";
                } else {
                    $n = "trn_dtl_name_" . $this->culture;
                }
            }
            $arr[$row['trn_dtl_code']] = $row[$n];
        }

        echo json_encode(array($arr, $typeType, $ernDen));
        die;
    }

    public function executeLoadAssignEmployees(sfWebRequest $request) {


        $culture = $this->getUser()->getCulture();

        $empId = $request->getParameter('empid');
        $erndedcon = $request->getParameter('erndedcon');
        $transDetailType = $request->getParameter('transferDetailType');

        $AssignEmpService = new AssignEmployeeService();
        $emplist = $AssignEmpService->getEmpDetailsToGrid($empId);

        $empBasicSalary = $AssignEmpService->getEmpbasicSalary($empId);


        $arr = Array();

        if ($erndedcon == 0) {

            $getContriPersn = $AssignEmpService->getContriPersn($transDetailType);

            $empCont = $getContriPersn[0]->trn_dtl_empcont;
            $eyrCont = $getContriPersn[0]->trn_dtl_eyrcont;
        }

        foreach ($emplist as $row) {

            if ($erndedcon == 1) {

                $empBasicSalary = $AssignEmpService->getEmpbasicSalary($row['emp_number']);

                $empBasicSalary = $empBasicSalary[0]->emp_basic_salary;
            } else {
                $empBasicSalary = "";
            }


            if ($culture == "en") {
                $abc = "emp_display_name";
            } else {
                $abc = "emp_display_name_" . $culture;

                if ($row[Employee][$abc] == "") {

                    $abc = 'emp_display_name';
                } else {
                    $abc = "emp_display_name_" . $culture;
                }
            }
            if ($culture == "en") {
                $title = "title";
            } else {

                $title = "title_" . $culture;
            }
            $comStruture = $AssignEmpService->getCompnayStructure($row[Employee]['work_station']);
            if ($culture == "en") {
                $title = "getTitle";
            } else {
                $title = "getTitle_" . $culture;
            }
            if ($comStruture) {
                $comTitle = $comStruture->$title();
            }
            $arr[$row['emp_number']] = $row[Employee]['employeeId'] . "|" . $row[Employee][$abc] . "|" . $comTitle . "|" . $row[Employee]['empNumber'] . "|" . $empBasicSalary . "|" . $empCont . "|" . $eyrCont;
        }

        echo json_encode($arr);
        die;
    }

    public function executeEmployeeBankDetails(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
        $BankService = new BankService();
        $encrypt = new EncryptionHandler();
//        if ($request->getParameter('empno') != null) {
        $this->BankList = $BankService->getBankList();
        $this->AccountTypeList = $BankService->getAccountTypeList();
        $this->symplodret = $BankService->EmployeeBankDetails($request->getParameter('id'));
        if ((($request->getParameter('empno') != null) && ($request->getParameter('branchcode') != null)) && (($request->getParameter('accno') != null) && ($request->getParameter('acctype') != null))) {
            //Table Lock code is Open


            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }
            $empno = $request->getParameter('empno');
            $branchcode = $request->getParameter('branchcode');
            $accno = $request->getParameter('accno');
            $acctype = $request->getParameter('acctype');

            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_hr_emp_bank', array($empno, $branchcode, $accno, $acctype), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_hr_emp_bank', array($empno, $branchcode, $accno, $acctype), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed

            $EmployeeBankDetails = $BankService->readEmployeeBankDetails($empno, $branchcode, $accno, $acctype);
            $this->EmployeeBankDetails = $EmployeeBankDetails;
            $bankno = $EmployeeBankDetails[0]->PayRollBranch->PayRollBank->bank_code;
            $this->BranchList = $BankService->getBranchfromBank($bankno);
            $this->symplodret = $BankService->EmployeeBankDetails($request->getParameter('empno'));
            $this->Employee = $BankService->readEmployee($request->getParameter('empno'));
//$this->lockMode = 0;
        } else {
            $this->btn = "new";
            //$this->lockMode = 1;
        }
        //}

        if ($request->isMethod('post')) {
            $PayRollEmployeeBank = $BankService->getBankDetailsbydata($_POST['txtEmpId'], $_POST['cmbBranch'], $_POST['cmbAccountType'], $_POST['txtAccountNo']);
            $this->PayRollEmployeeBank = $PayRollEmployeeBank[0];
            try {
                if ($PayRollEmployeeBank[0]->ebank_acc_no == null) {

                    $PayRollEmployeeBank = new PayRollEmployeeBank();
                    $PayRollEmployeeBank->setBbranch_code($_POST['cmbBranch']);
                    $PayRollEmployeeBank->setEmp_number($_POST['txtEmpId']);
                    $PayRollEmployeeBank->setEbank_acc_no($_POST['txtAccountNo']);
                    $PayRollEmployeeBank->setAcctype_id($_POST['cmbAccountType']);
                    $PayRollEmployeeBank->setEbank_amount($_POST['txtAmount']);
                    $PayRollEmployeeBank->setEbank_order($_POST['txtAccountOrder']);
                    $PayRollEmployeeBank->setEbank_active_flag($_POST['chkActve']);
                    if ($_POST['txtfromdate'] != null) {
                        $PayRollEmployeeBank->setEbank_start_date($_POST['txtfromdate']);
                    } else {
                        $PayRollEmployeeBank->setEbank_start_date(null);
                    }
                    if ($_POST['txttodate'] != null) {
                        $PayRollEmployeeBank->setEbank_end_date($_POST['txttodate']);
                    } else {
                        $PayRollEmployeeBank->setEbank_end_date(null);
                    }


                    $PayRollEmployeeBank->setEbank_comment($_POST['txtcomment']);

                    $BankService->savePayRollEmployeeBank($PayRollEmployeeBank);

                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));

                    $this->redirect('payroll/EmployeeBankDetails?empno=' . $PayRollEmployeeBank->emp_number . '&branchcode=' . $PayRollEmployeeBank->bbranch_code . '&accno=' . $PayRollEmployeeBank->ebank_acc_no . '&acctype=' . $PayRollEmployeeBank->acctype_id . '&lock=0');
                } else {


                    $PayRollEmployeeBank[0]->setEbank_amount($_POST['txtAmount']);
                    $PayRollEmployeeBank[0]->setEbank_order($_POST['txtAccountOrder']);
                    $PayRollEmployeeBank[0]->setEbank_active_flag($_POST['chkActve']);

                    $PayRollEmployeeBank[0]->setEbank_comment($_POST['txtcomment']);
                    if ($_POST['txtfromdate'] != null) {
                        $PayRollEmployeeBank[0]->setEbank_start_date($_POST['txtfromdate']);
                    } else {
                        $PayRollEmployeeBank[0]->setEbank_start_date(null);
                    }
                    if ($_POST['txttodate'] != null) {
                        $PayRollEmployeeBank[0]->setEbank_end_date($_POST['txttodate']);
                    } else {
                        $PayRollEmployeeBank[0]->setEbank_end_date(null);
                    }

                    $BankService->savePayRollEmployeeBank($PayRollEmployeeBank[0]);

                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));

                    $this->redirect('payroll/EmployeeBankDetails?empno=' . $PayRollEmployeeBank[0]->emp_number . '&branchcode=' . $PayRollEmployeeBank[0]->bbranch_code . '&accno=' . $PayRollEmployeeBank[0]->ebank_acc_no . '&acctype=' . $PayRollEmployeeBank[0]->acctype_id . '&lock=0');
                }
                //$this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                //$this->redirect('payroll/EmployeeBankDetails?empno=' . $PayRollEmployeeBank[0]->emp_number . '&branchcode=' . $PayRollEmployeeBank[0]->bbranch_code. '&accno=' . $PayRollEmployeeBank[0]->ebank_acc_no. '&acctype=' . $PayRollEmployeeBank[0]->acctype_id . '&lock=0');
            } catch (sfStopException $e) {
                
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/EmployeeBankDetails?id=' . $encrypt->encrypt($PayRollEmployeeBank->emp_number) . '&lock=0');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/EmployeeBankDetails?id=' . $encrypt->encrypt($PayRollEmployeeBank->emp_number) . '&lock=0');
            }
        }
    }

    public function executeAjaxEmployeeBankDetails(sfWebRequest $request) {
        $culture = $this->getUser()->getCulture();
        $EmpNo = $request->getParameter('sendValue');
        $BankService = new BankService();
        $BankDetails = $BankService->readEmployeeBankDetailsByEmployee($EmpNo);

        $arr = Array();
        foreach ($BankDetails as $row) {

            if ($culture == "en") {
                $Bank = "bank_name";
            } else {
                $Bank = "bank_name_" . $culture;

                if ($row->PayRollBranch->PayRollBank->$Bank == "") {

                    $Bank = 'bank_name';
                } else {
                    $Bank = "bank_name_" . $culture;
                }
            }

            if ($culture == "en") {
                $Branch = "bbranch_name";
            } else {
                $Branch = "bbranch_name_" . $culture;

                if ($row->PayRollBranch->$Branch == "") {

                    $Branch = 'bbranch_name';
                } else {
                    $Branch = "bbranch_name_" . $culture;
                }
            }
            if ($culture == "en") {
                $Act = "acctype_name";
            } else {
                $Act = "acctype_name_" . $culture;

                if ($row->PayRollBankAccountType->$Act == "") {

                    $Act = 'acctype_name';
                } else {
                    $Act = "acctype_name_" . $culture;
                }
            }

            $arr[$row->ebank_acc_no] = $row->emp_number . "|" . $row->PayRollBranch->PayRollBank->$Bank . "|" . $row->PayRollBranch->$Branch . "|" . $row->ebank_acc_no . "|" . $row->PayRollBankAccountType->$Act . "|" . $row->ebank_amount . "|" . $row->ebank_order . "|" . $row->bbranch_code . "|" . $row->ebank_acc_no . "|" . $row->acctype_id;
        }

        echo json_encode($arr);
        die;
    }

    public function executeValidateFormula(sfWebRequest $request) {


//        $formula = $request->getParameter('formula');
//        $replaceWord = str_replace("txnword", 100, $formula);
//
//        $arr = eval('return ' . $replaceWord . ';');
//            //die(print_r($arr));
//        if ($arr >= 1) {
//            $result = 1;
//        } else {
//            $result = 0;
//        }
//        echo json_encode($result);
//        die;
        $err=0;
        $formula = $request->getParameter('formula');
        $replaceWord = str_replace("txnword", 100, $formula);
        $replaceWorddefault=$replaceWord;

        //$arr = eval($replaceWord);
        $replaceWord = str_replace("*", 1, $replaceWord);
        $replaceWord = str_replace("+", 1, $replaceWord);
        $replaceWord = str_replace("/", 1, $replaceWord);
        $replaceWord = str_replace("-", 1, $replaceWord);
        $replaceWord = str_replace(".", 1, $replaceWord);
        $replaceWord = str_replace("(", 1, $replaceWord);
        $replaceWord = str_replace(")", 1, $replaceWord);
        $replaceWord = str_replace("%", 1, $replaceWord);
        
        $pieces = str_split($replaceWord);
        //$pieces = str_split($replaceWord);
        foreach ($pieces as $row){
            if(!is_numeric($row)){
              $err++;  
            }             
            
        }
        if($err==0){
        $arr = eval('return ' . $replaceWorddefault . ';');
        if ($arr >= 1) {
            $result = 1;
        } else {
            $result = 0;
        }
        }else{
            $result = 0;
        }
        echo json_encode($result);
        die;
        
    }

    public function executeIsBatchIdExsit(sfWebRequest $request) {

        $batchId = $request->getParameter('txtBatchId');
        $startDate = $request->getParameter('startDate');
        $endDate = $request->getParameter('endDate');


        $payProcessDao = new payProcessDao();

        $result = $payProcessDao->IsBatchIdExsit(trim($batchId), $startDate, $endDate);

        if ($result[0] == null) {
            echo json_encode("f");
        } else {
            echo json_encode($result[0]);
        }

        die;
    }

    public function executeAjaxCalllast(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $this->value = $request->getParameter('sendValue2');
        $bankDao = new BankDao();
        $this->value1 = $bankDao->readmaxBankAccOrder($this->value);
        echo json_encode($this->value1[0]['MAX']);
        die;
    }

    public function executeDeleteEmployeeBankDetails(sfWebRequest $request) {
        $BankService = new BankService();
        try {
            $empno = $request->getParameter('empno');
            $branchcode = $request->getParameter('branchcode');
            $accno = $request->getParameter('accno');
            $acctype = $request->getParameter('acctype');

            $conHandler = new ConcurrencyHandler();
            $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_bank', array($empno, $branchcode, $accno, $acctype), 1);
            if ($isRecordLocked) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            } else {
                $BankService->DeleteEmployeeBankDetails($empno, $branchcode, $accno, $acctype);
                $conHandler->resetTableLock('hs_hr_emp_bank', array($empno, $branchcode, $accno, $acctype), 1);
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            }
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }



        $abc = $request->getParameter('id');
        $this->redirect('payroll/EmployeeBankDetails?id=' . $empno);
    }

    public function executeBankDiskette(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $BankDisketteService = new BankDisketteService();

            $this->sorter = new ListSorter('BankDiskette', 'payroll', $this->getUser(), array('b.dsk_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('payroll/BankDiskette');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'b.dsk_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $BankDisketteService->searchBankDiskette($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->BankDisketteList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeUpdateBankDiskette(sfWebRequest $request) {

        $BankDisketteService = new BankDisketteService();
        $BankService = new BankService();
        $this->myCulture = $this->getUser()->getCulture();
        //Table Lock code is Open
        if ($request->getParameter('id')) {
            $encrypt = new EncryptionHandler();
            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }
            $VTID = $encrypt->decrypt($request->getParameter('id'));
            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_pr_bank_diskette', array($VTID), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_pr_bank_diskette', array($VTID), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed


            $BankDiskette = $BankDisketteService->readBankDiskette($encrypt->decrypt($request->getParameter('id')));
            if (!$BankDiskette) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('payroll/BankDiskette');
            }
        } else {
            $PayrollVote = new PayrollVote();
            $this->lockMode = 1;
        }


        $this->BankDiskette = $BankDiskette;
        $this->BankList = $BankService->getBankList();
        $this->ViewList = $BankDisketteService->getView();
        $this->ListBankDetail = $BankDisketteService->getListBankDetail($VTID);
        if ($BankDiskette->dsk_view) {
            $this->ColumnList = $BankDisketteService->getColumnsByViewID($BankDiskette->dsk_view);
        }
//die(print_r($this->ColumnList));

        if ($request->isMethod('post')) { //die(print_r($_POST));
            if ($request->getParameter('txtDisketteID') == null) {
                $hsPrBankDiskette = new hsPrBankDiskette();
            } else {
                $hsPrBankDiskette = $BankDisketteService->readBankDiskette($request->getParameter('txtDisketteID'));
            }

            if (strlen($request->getParameter('txtBankDisketteName'))) {
                $hsPrBankDiskette->setDsk_name(trim($request->getParameter('txtBankDisketteName')));
            } else {
                $hsPrBankDiskette->setDsk_name(null);
            }
            if (strlen($request->getParameter('txtBankDisketteNameSi'))) {
                $hsPrBankDiskette->setDsk_name_si(trim($request->getParameter('txtBankDisketteNameSi')));
            } else {
                $hsPrBankDiskette->setDsk_name_si(null);
            }
            if (strlen($request->getParameter('txtBankDisketteNameTa'))) {
                $hsPrBankDiskette->setDsk_name_ta(trim($request->getParameter('txtBankDisketteNameTa')));
            } else {
                $hsPrBankDiskette->setDsk_name_ta(null);
            }
            if (strlen($request->getParameter('txtfromdate'))) {
                $hsPrBankDiskette->setDsk_start_date(trim($request->getParameter('txtfromdate')));
            } else {
                $hsPrBankDiskette->setDsk_start_date(null);
            }
            if (strlen($request->getParameter('txttodate'))) {
                $hsPrBankDiskette->setDsk_end_date(trim($request->getParameter('txttodate')));
            } else {
                $hsPrBankDiskette->setDsk_end_date(null);
            }
            if (strlen($request->getParameter('cmbView'))) {
                $hsPrBankDiskette->setDsk_view(trim($request->getParameter('cmbView')));
            } else {
                $hsPrBankDiskette->setDsk_view(null);
            }

            if (strlen($request->getParameter('cmbBank'))) {
                $hsPrBankDiskette->setBank_code(trim($request->getParameter('cmbBank')));
            } else {
                $hsPrBankDiskette->setBank_code(null);
            }

            $chk = null;
            if ($request->getParameter("chkActveHeader")) {
                $chk = $chk + 2;
            }
            if ($request->getParameter("chkActveDetail")) {
                $chk = $chk + 3;
            }
            if ($request->getParameter("chkActveFooter")) {
                $chk = $chk + 4;
            }

            if ($chk) {
                $hsPrBankDiskette->setDsk_detail_type($chk);
            } else {
                $hsPrBankDiskette->setDsk_detail_type($chk);
            }




            try {
                $BankDisketteService->saveBankDiskette($hsPrBankDiskette);

                if ($request->getParameter('txtDisketteID') == null) {
                    $hsPrBankDiskette = new hsPrBankDiskette();
                    $Max = $BankDisketteService->readBankDisketteMax();
                    //die(print_r($Max[0]['MAX']));

                    for ($i = 1; $i <= 3; $i++) {

                        if ($request->getParameter('chkActveHeader')) {
                            if ($request->getParameter('txtJArray' . $i) != null) {
                                $Field = explode(",", $request->getParameter('txtJArray' . $i));

                                foreach ($Field as $property) {
                                    $row = explode("_", $property);

                                    $hsPrBankDisketteDetail = new hsPrBankDisketteDetail();
                                    //$row[0]; // Position            1.Header 2.Detail 3.Footer
                                    //$row[1]; // Field Order
                                    //$row[2]; // Column Type         1.Text 2.DBColumn 
                                    //$row[3]; // Column Data Type    1.Text 2.Numeric
                                    //$row[4]; // Field Length
                                    //$row[5]; // Allignment          1.Right 2.Left
                                    //$row[6]; // Fill Value          1.Space 2.Zero


                                    $hsPrBankDisketteDetail->setDsk_id($Max[0]['MAX']);
                                    if ($row[2] == "2") {
                                        $col = 'cmbCol_' . $i . '_' . $row[1];
                                    } else {
                                        $col = 'txtCol_' . $i . '_' . $row[1];
                                    }
                                    //die(print_r($col));
                                    //die(print_r($request->getParameter($col)));
                                    $hsPrBankDisketteDetail->setDskd_column($row[0]);
                                    $hsPrBankDisketteDetail->setDskd_length($row[4]);
                                    $hsPrBankDisketteDetail->setDskd_type($row[2]);
                                    $hsPrBankDisketteDetail->setDskd_alignment($row[5]);
                                    $hsPrBankDisketteDetail->setDskd_fillwith($row[6]);
                                    $hsPrBankDisketteDetail->setDskd_value($request->getParameter($col));
                                    $hsPrBankDisketteDetail->setDskd_order($row[1]);
                                    $hsPrBankDisketteDetail->setDskd_active(null);
                                    $hsPrBankDisketteDetail->setDsk_detail_type($row[3]);

                                    $BankDisketteService->savehsPrBankDisketteDetail($hsPrBankDisketteDetail);
                                }
                            }
                        }
                    }
                } else {

                    for ($i = 1; $i <= 3; $i++) {

                        if ($i == 1) {
                            $chkActve = "chkActveHeader";
                        } else if ($i == 2) {
                            $chkActve = "chkActveDetail";
                        } else if ($i == 3) {
                            $chkActve = "chkActveFooter";
                        }

                        if ($request->getParameter($chkActve)) {
                            if ($request->getParameter('txtJArray' . $i) != null) {
                                $Field = explode(",", $request->getParameter('txtJArray' . $i));

                                foreach ($Field as $property) {
                                    $row = explode("_", $property);
                                    $hsPrBankDisketteDetail = $BankDisketteService->readBankDisketteDetailByData($request->getParameter('txtDisketteID'), $i, $row[1]);


                                    if ($hsPrBankDisketteDetail->dsk_id == null) {
                                        $hsPrBankDisketteDetail = new hsPrBankDisketteDetail();
                                        $hsPrBankDisketteDetail->setDskd_column($row[0]);
                                        $hsPrBankDisketteDetail->setDskd_order($row[1]);
                                        $hsPrBankDisketteDetail->setDsk_id($request->getParameter('txtDisketteID'));
                                        if ($row[2] == "2") {
                                            $col = 'cmbCol_' . $i . '_' . $row[1];
                                        } else {
                                            $col = 'txtCol_' . $i . '_' . $row[1];
                                        }


                                        $hsPrBankDisketteDetail->setDskd_length($row[4]);
                                        $hsPrBankDisketteDetail->setDskd_type($row[2]);
                                        $hsPrBankDisketteDetail->setDskd_alignment($row[5]);
                                        $hsPrBankDisketteDetail->setDskd_fillwith($row[6]);

                                        $hsPrBankDisketteDetail->setDskd_value($request->getParameter($col));

                                        $hsPrBankDisketteDetail->setDskd_active(null);
                                        $hsPrBankDisketteDetail->setDsk_detail_type($row[3]);

                                        $BankDisketteService->savehsPrBankDisketteDetail($hsPrBankDisketteDetail);
                                    } else {


                                        if ($row[2] == "2") {
                                            $col = 'cmbCol_' . $i . '_' . $row[1];
                                        } else {
                                            $col = 'txtCol_' . $i . '_' . $row[1];
                                        }


                                        $hsPrBankDisketteDetail->setDskd_length($row[4]);
                                        $hsPrBankDisketteDetail->setDskd_type($row[2]);
                                        $hsPrBankDisketteDetail->setDskd_alignment($row[5]);
                                        $hsPrBankDisketteDetail->setDskd_fillwith($row[6]);
                                        //die(print_r($request->getParameter('txtCol_1_0')));
                                        $hsPrBankDisketteDetail->setDskd_value($request->getParameter($col));

                                        $hsPrBankDisketteDetail->setDskd_active(null);
                                        $hsPrBankDisketteDetail->setDsk_detail_type($row[3]);

                                        $BankDisketteService->savehsPrBankDisketteDetail($hsPrBankDisketteDetail);
                                    }
                                }
                            }
                        }
                    }
                }
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('txtDisketteID') != null) {
                    $this->redirect('payroll/UpdateBankDiskette?id=' . $encrypt->encrypt($request->getParameter('txtDisketteID')) . '&lock=0');
                } else {
                    $this->redirect('payroll/BankDiskette');
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('txtDisketteID') != null) {
                    $this->redirect('payroll/UpdateBankDiskette?id=' . $encrypt->encrypt($request->getParameter('txtDisketteID')) . '&lock=0');
                } else {
                    $this->redirect('payroll/BankDiskette');
                }
            }
            if ($request->getParameter('txtDisketteID') != null) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                $this->redirect('payroll/UpdateBankDiskette?id=' . $encrypt->encrypt($request->getParameter('txtDisketteID')) . '&lock=0');
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('payroll/BankDiskette');
            }
        }
    }

    public function executeAjaxLoadColumn(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $BankDisketteService = new BankDisketteService();

        $id = $request->getParameter('id');
        $Columns = $BankDisketteService->getColumnsByViewID($id);

        $arr = Array();
        foreach ($Columns as $row) {
            $arr[] = $row['Field'];
        }

        echo json_encode($Columns);
        die;
    }

    public function executeBankDisketteProcess(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $BankDisketteService = new BankDisketteService();

            $this->sorter = new ListSorter('BankDisketteProcess', 'payroll', $this->getUser(), array('b.bdp_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('payroll/BankDisketteProcess');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'b.bdp_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $BankDisketteService->searchBankDisketteProcessList($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->BankDisketteProcessList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeUpdateBankDisketteProcess(sfWebRequest $request) {
        $BankDisketteService = new BankDisketteService();
        $this->myCulture = $this->getUser()->getCulture();
        //Table Lock code is Open
        if ($request->getParameter('id')) {
            $encrypt = new EncryptionHandler();
            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }
            $ID = $encrypt->decrypt($request->getParameter('id'));

            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_pr_bank_diskette_process', array($ID), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_pr_bank_diskette_process', array($ID), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed

            $this->hsPrBankDisketteProcess = $BankDisketteService->readhsPrBankDisketteProcess($ID);
            $Employees = $BankDisketteService->readhsPrBankDisketteProcessEmployeeID($ID);
            if ($Employees) {
                foreach ($Employees as $emp) {
                    $emlist.= $emp['emp_number'] . "|";
                }
                $this->emlist = $emlist;
            }

            $hsPrBankDisketteProcess = $this->hsPrBankDisketteProcess;
            if (!$hsPrBankDisketteProcess) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('payroll/BankDisketteProcess');
            }
        } else {
            //$SalarayIncrement = new PayrollIncrement();
            $this->lockMode = 1;
        }
        $this->BankDiskList = $BankDisketteService->getBankDiskList();

        if ($request->isMethod('post')) {

            try {

                $conn = Doctrine_Manager::getInstance()->connection();
                //$conn->beginTransaction();
                //die(print_r($_POST));

                if ($_POST['txtId'] != "") {
                    $hsPrBankDisketteProcess = $BankDisketteService->readhsPrBankDisketteProcess($_POST['txtId']);
                } else {
                    $hsPrBankDisketteProcess = new hsPrBankDisketteProcess();
                }
//                        if (strlen($_POST['hiddenEmpNumber'][$key])) {
//                            $hsPrBankDisketteProcess->setEmp_number($_POST['hiddenEmpNumber'][$key]);
//                        }

                if (strlen($_POST['txtStartDate'] != null)) {
                    $hsPrBankDisketteProcess->setBdp_start_date($_POST['txtStartDate']);
                } else {
                    $hsPrBankDisketteProcess->setBdp_start_date(null);
                }

                if (strlen($_POST['txtEndDate'] != null)) {
                    $hsPrBankDisketteProcess->setBdp_end_date($_POST['txtEndDate']);
                } else {
                    $hsPrBankDisketteProcess->setBdp_end_date(null);
                }

                if (strlen($_POST['txtPaymentDate'] != null)) {
                    $hsPrBankDisketteProcess->setBdp_payment_date($_POST['txtPaymentDate']);
                } else {
                    $hsPrBankDisketteProcess->setBdp_payment_date(null);
                }
                if (strlen($_POST['cmbBankDisk'] != null)) {
                    $hsPrBankDisketteProcess->setDsk_id($_POST['cmbBankDisk']);
                } else {
                    $hsPrBankDisketteProcess->setDsk_id(null);
                }

                if (strlen($_POST['txtNWorkStaion'] != null)) {
                    $hsPrBankDisketteProcess->setId($_POST['txtNWorkStaion']);
                } else {
                    $hsPrBankDisketteProcess->setId(null);
                }

                if (strlen($_POST['txtTotalAmount'] != null)) {
                    $hsPrBankDisketteProcess->setBdp_payment_total($_POST['txtTotalAmount']);
                } else {
                    $hsPrBankDisketteProcess->setBdp_payment_total(null);
                }

                $hsPrBankDisketteProcess->setBdp_processed(null);
                $hsPrBankDisketteProcess->setBdp_flg(null);



                $BankDisketteService->savehsPrBankDiskette($hsPrBankDisketteProcess);
                $Max = $BankDisketteService->readBankDisketteProcessMax();

                foreach ($_POST['hiddenEmpNumber'] as $key => $value) {


                    if ($_POST['txtId'] != null) {
                        $hsPrBankDisketteProcessEmployee = $BankDisketteService->readhsPrBankDisketteProcessEmployee($_POST['txtId'], $value);

                        if ($hsPrBankDisketteProcessEmployee[0]->emp_number == null) {
                            $hsPrBankDisketteProcessEmployee = new hsPrBankDisketteProcessEmployee();
                            $hsPrBankDisketteProcessEmployee->setBdp_id($_POST['txtId']);
                            $hsPrBankDisketteProcessEmployee->setEmp_number($value);
                            $BankDisketteService->savehsPrBankDisketteProcessEmployee($hsPrBankDisketteProcessEmployee);
                        }
                    } else {

                        $hsPrBankDisketteProcessEmployee = new hsPrBankDisketteProcessEmployee();
                        $hsPrBankDisketteProcessEmployee->setBdp_id($Max[0]['MAX']);
                        $hsPrBankDisketteProcessEmployee->setEmp_number($value);
                        $BankDisketteService->savehsPrBankDisketteProcessEmployee($hsPrBankDisketteProcessEmployee);
                    }


                    //$conn->commit();
                }
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                if ($_POST['txtId'] != "") {
                    $this->redirect('payroll/UpdateBankDisketteProcess?id=' . $encrypt->encrypt($_POST['txtId']) . '&lock=0');
                } else {
                    $this->redirect('payroll/BankDisketteProcess');
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                if ($_POST['txtId'] != "") {
                    $this->redirect('payroll/UpdateBankDisketteProcess?id=' . $encrypt->encrypt($_POST['txtId']) . '&lock=0');
                } else {
                    $this->redirect('payroll/BankDisketteProcess');
                }
            }
            if ($_POST['txtId'] != "") {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                $this->redirect('payroll/UpdateBankDisketteProcess?id=' . $encrypt->encrypt($_POST['txtId']) . '&lock=0');
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('payroll/BankDisketteProcess');
            }
        }
    }

    public function executeBankDisketteCreation(sfWebRequest $request) {
        $BankDisketteService = new BankDisketteService();

        $Processid = $request->getParameter('Processid');

        $BankDisketteProcess = $BankDisketteService->readBankDisketteProcess($Processid);
        $BankDisketteProcessEmployee = $BankDisketteService->readBankDisketteProcessEmployee($Processid);
        $BankDisketteData = $BankDisketteService->readBankDiskette($BankDisketteProcess[0]->dsk_id);
        $BankDisketteDetail = $BankDisketteService->readBankDisketteDetail($BankDisketteData->dsk_id);
//        die(print_r($BankDisketteDetail));
        try {
            $stringData;
            //die(print_r($BankDisketteData->dsk_name));
            foreach ($BankDisketteDetail as $BankDiskette) {
                if ($BankDiskette->dskd_column == "1") {
                    if ($BankDiskette->dskd_type == "1") {
                        if ($BankDiskette->dskd_value != null) {
                            $datalength = strlen($BankDiskette->dskd_value);
                            $realleangth = $BankDiskette->dskd_length;
                            $replace = null;
                            if ($datalength < $realleangth) {

                                $space = $realleangth - $datalength;

                                for ($i = 1; $i <= $space; $i++) {
                                    if ($BankDiskette->dskd_fillwith == "1") {
                                        $replace = $replace . " ";
                                    } else {
                                        $replace = $replace . "0";
                                    }
                                }
                                if ($BankDiskette->dskd_alignment == '1') {
                                    $val = substr_replace($BankDiskette->dskd_value, $replace, 0, 0);
                                } else {
                                    $val = $BankDiskette->dskd_value . $replace;
                                }

                                $temp1 = $temp1 . $val;
                            } else {

                                $temp1 = $temp1 . $BankDiskette->dskd_value;
                            }
                        }


                        //$temp1=$temp1.$BankDiskette->dskd_value;
                    } else {

                        $data = $BankDisketteService->DetailViewColumn($BankDisketteData->dsk_view, $BankDiskette->dskd_value, "", "", "", "", "", "");
                        //$temp1=$temp1.$data[0][0];
                        if ($data[0][0] != null) {
                            $datalength = strlen($data[0][0]);
                            $realleangth = $BankDiskette->dskd_length;
                            $replace = null;
                            if ($datalength >= $realleangth) {
                                $val = substr($data[0][0], 0, $BankDiskette->dskd_length);
                                $temp1 = $temp1 . $val;
                            } else {
                                $space = $realleangth - $datalength;
                                //$space1=$space*-1;

                                for ($i = 1; $i <= $space; $i++) {
                                    if ($BankDiskette->dskd_fillwith == "1") {
                                        $replace = $replace . " ";
                                    } else {
                                        $replace = $replace . "0";
                                    }
                                }
                                if ($BankDiskette->dskd_alignment == '1') {
                                    $val = substr_replace($data[0][0], $replace, 0, 0);
                                } else {
                                    $val = $data[0][0] . $replace;
                                }

                                $temp1 = $temp1 . $val;
                            }
                        }
                    }
                }
            }

            foreach ($BankDisketteProcessEmployee as $Emp) {
                if ($Emp != null) {
                    foreach ($BankDisketteDetail as $BankDiskette) {
                        if ($BankDiskette->dskd_column == "2") {

                            if ($BankDiskette->dskd_type == "1") {
                                if ($BankDiskette->dskd_value != null) {
                                    $datalength = strlen($BankDiskette->dskd_value);
                                    $realleangth = $BankDiskette->dskd_length;
                                    $replace = null;
                                    if ($datalength < $realleangth) {

                                        $space = $realleangth - $datalength;
                                        //$space1=$space*-1;

                                        for ($i = 1; $i <= $space; $i++) {
                                            if ($BankDiskette->dskd_fillwith == "1") {
                                                $replace = $replace . "0";
                                            } else {
                                                $replace = $replace . " ";
                                            }
                                        }
                                        if ($BankDiskette->dskd_alignment == '1') {
                                            $val = $BankDiskette->dskd_value . $replace;                                            
                                        } else {
                                            $val = substr_replace($BankDiskette->dskd_value, $replace, 0, 0);
                                        }

                                        $temp2 = $temp2 . $val;
                                    } else {

                                        $temp2 = $temp2 . $BankDiskette->dskd_value;
                                    }
                                }
                            } else {
                                // die(print_r($BankDisketteData->dsk_view."|".$BankDiskette->dskd_value."|". $Emp['emp_number']."|". $BankDisketteProcess[0]->bdp_start_date."|". $BankDisketteProcess[0]->bdp_end_date."|". $BankDisketteProcess[0]->id."|". $BankDisketteData->bank_code));
                                $data = $BankDisketteService->DetailViewColumn($BankDisketteData->dsk_view, $BankDiskette->dskd_value, $Emp['emp_number'], $BankDisketteProcess[0]->bdp_start_date, $BankDisketteProcess[0]->bdp_end_date, $BankDisketteProcess[0]->id, $BankDisketteData->bank_code, "");
                                if ($data[0][0] != null) {

                                    $datalength = strlen($data[0][0]);
                                    $realleangth = $BankDiskette->dskd_length;
                                    $replace = null;
                                    if ($datalength >= $realleangth) {
                                        $val = substr($data[0][0], 0, $BankDiskette->dskd_length);
                                        $temp2 = $temp2 . $val;
                                    } else {
                                        $space = $realleangth - $datalength;
                                        //$space1=$space*-1;

                                        for ($i = 1; $i <= $space; $i++) {
                                            if ($BankDiskette->dskd_fillwith == "1") {
                                                $replace = $replace . "0";
                                            } else {
                                                $replace = $replace . " ";
                                            }
                                        }
                                        if ($BankDiskette->dskd_alignment == '1') {
                                            $val = $data[0][0] . $replace;
                                        } else {
                                            $val = substr_replace($data[0][0], $replace, 0, 0);                                            
                                        }

                                        $temp2 = $temp2 . $val;
                                    }
                                }
                            }
                        }
                    }

                    $temp2 = $temp2 . "\n\r";
                    //die(print_r($temp2));
                }
            }
            foreach ($BankDisketteDetail as $BankDiskette) {
                if ($BankDiskette->dskd_column == "3") {
                    if ($BankDiskette->dskd_type == "1") {
                        if ($BankDiskette->dskd_value != null) {
                            $datalength = strlen($BankDiskette->dskd_value);
                            $realleangth = $BankDiskette->dskd_length;
                            $replace = null;
                            if ($datalength < $realleangth) {

                                $space = $realleangth - $datalength;
                                //$space1=$space*-1;

                                for ($i = 1; $i <= $space; $i++) {
                                    if ($BankDiskette->dskd_fillwith == "1") {
                                        $replace = $replace . "0";
                                    } else {
                                        $replace = $replace . " ";
                                    }
                                }
                                if ($BankDiskette->dskd_alignment == '1') {
                                    $val = $BankDiskette->dskd_value . $replace;
                                } else {                                    
                                    $val = substr_replace($BankDiskette->dskd_value, $replace, 0, 0);
                                }

                                $temp3 = $temp3 . $val;
                            } else {

                                $temp3 = $temp3 . $BankDiskette->dskd_value;
                            }
                        }
                    } else {
                        foreach ($BankDisketteProcessEmployee as $Emp => $value) {
                            if ($Emp == 0) {
                                $EmployeeList = $value['emp_number'];
                            } else {
                                $EmployeeList.="," . $value['emp_number'];
                            }
                        }
                        if ($BankDiskette->dskd_value == "TotalAmount") {
                            $data = $BankDisketteService->DetailViewColumn($BankDisketteData->dsk_view, $BankDiskette->dskd_value, "", $BankDisketteProcess[0]->bdp_start_date, $BankDisketteProcess[0]->bdp_end_date, $BankDisketteProcess[0]->id, $BankDisketteData->bank_code, $EmployeeList);
                        } else {
                            $data = $BankDisketteService->DetailViewColumn($BankDisketteData->dsk_view, $BankDiskette->dskd_value, "", $BankDisketteProcess[0]->bdp_start_date, $BankDisketteProcess[0]->bdp_end_date, $BankDisketteProcess[0]->id, $BankDisketteData->bank_code, "");
                        }
                        //$temp3=$temp3.$data[0][0];
                        if ($data[0][0] != null) {
                            $datalength = strlen($data[0][0]);
                            $realleangth = $BankDiskette->dskd_length;
                            $replace = null;
                            if ($datalength >= $realleangth) {
                                $val = substr($data[0][0], 0, $BankDiskette->dskd_length);
                                $temp3 = $temp3 . $val;
                            } else {
                                $space = $realleangth - $datalength;
                                //$space1=$space*-1;

                                for ($i = 1; $i <= $space; $i++) {
                                    if ($BankDiskette->dskd_fillwith == "1") {
                                        $replace = $replace . "0";
                                    } else {
                                        $replace = $replace . " ";
                                    }
                                }
                                if ($BankDiskette->dskd_alignment == '1') {
                                    $val = $data[0][0] . $replace;                                    
                                } else {
                                    $val = substr_replace($data[0][0], $replace, 0, 0);
                                }

                                $temp3 = $temp3 . $val;
                            }
                        }
                    }
                }
            }
        } catch (sfStopException $e) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Bank Diskette Format Error", $args, 'messages')));
            $this->redirect('default/error');
        }

        $stringData = $temp1 . "\n\r" . $temp2 . $temp3;


        $stringData = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $stringData);

        //Export to Text File
        $type = "text";
        $myFile = $BankDisketteData->dsk_name . "_" . $BankDisketteProcess[0]->CompanyStructure->title . "_" . $BankDisketteProcess[0]->bdp_start_date . ".txt";
        $fh = fopen($myFile, "w+") or die("can't open file");

        fwrite($fh, $stringData);
        //die(print_r($stringData));
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header('Content-Description: File Transfer');
        header("Content-type:" . $type);
        header('Content-disposition: attachment; filename=' . $myFile);
        echo($stringData);
        //die(print_r($stringData));
        fclose($fh);


        die;
    }

    public function executeLoadEmployeeDiskette(sfWebRequest $request) {
        $culture = $this->getUser()->getCulture();
        $BankDisketteDao = new BankDisketteDao();
        $empId = $request->getParameter('empid');

        $emplist = $BankDisketteDao->getEmployee($empId);



        foreach ($emplist as $row) {


            if ($culture == "en") {
                $abc = "emp_display_name";
            } else {
                $abc = "emp_display_name_" . $culture;

                if ($row[$abc] == "") {

                    $abc = 'emp_display_name';
                } else {
                    $abc = "emp_display_name_" . $culture;
                }
            }
            if ($culture == "en") {
                $title = "title";
            } else {

                $title = "title_" . $culture;
            }
            $comStruture = $BankDisketteDao->getCompnayStructure($row['work_station']);
            if ($culture == "en") {
                $title = "title";
            } else {
                $title = "title_" . $culture;
            }
            if ($comStruture) {
                $comTitle = $comStruture->$title;
            }
            $arr[$row['employeeId']] = $row['employeeId'] . "|" . $row[$abc] . "|" . $comTitle . "|" . $row['empNumber'];
        }



        echo json_encode($arr);
        die;
    }

    public function executeDisplayEmpHirache(sfWebRequest $request) {


        $companyService = new CompanyService();
        $CompanyDao = new CompanyDao();
        $userCulture = $this->getUser()->getCulture();

        $ActhieCode = $request->getParameter('wst');
        $name = array();
        $levelname = array();
        $Actdivision = $companyService->readCompanyStructure($ActhieCode);
        $ActdefLevel = $Actdivision->getDefLevel();
        while ($ActdefLevel > 0 && $ActhieCode > 0) {

            $ActhieCode = $Actdivision->getParnt();
            if ($userCulture == "en") {
                $name[] = $Actdivision['title'];
            } else {
                $Title = 'title_' . $userCulture;
                if ($Actdivision[$Title] == "") {
                    $name[] = $Actdivision['title'];
                } else {
                    $name[] = $Actdivision[$Title];
                }
            }
            $Levelofdivition = $CompanyDao->getDefLevelDetals($Actdivision['def_level']);
            if ($userCulture == "en") {
                $levelname[] = $Levelofdivition[0]->getDef_name();
            } else {
                $deflevel = 'getDef_name_' . $userCulture;
                if ($Levelofdivition[0]->$deflevel() == "") {
                    $levelname[] = $Levelofdivition[0]->getDef_name();
                } else {
                    $levelname[] = $Levelofdivition[0]->$deflevel();
                }
            }


            $Actdivision = $companyService->readCompanyStructure($ActhieCode);

            $ActdefLevel = $ActdefLevel - 1;
        }
        echo json_encode(array("name1" => $name[0], "name2" => $name[1], "name3" => $name[2], "name4" => $name[3], "name5" => $name[4], "name6" => $name[5], "name7" => $name[6], "name8" => $name[7], "name9" => $name[8], "name10" => $name[9], "nameLevel1" => $levelname[0], "nameLevel2" => $levelname[1], "nameLevel3" => $levelname[2], "nameLevel4" => $levelname[3], "nameLevel5" => $levelname[4], "nameLevel6" => $levelname[5], "nameLevel7" => $levelname[6], "nameLevel8" => $levelname[7], "nameLevel9" => $levelname[8], "nameLevel10" => $levelname[9]));
        die;
    }

    public function executeAjaxDisketteEmployeeDelete(sfWebRequest $request) {

        $diskid = $request->getParameter('diskid');
        $empno = $request->getParameter('empno');
        $BankDisketteDao = new BankDisketteDao();
        $BankDisketteDao->DisketteEmployeeDelete($diskid, $empno);
        echo json_encode("true");
        die;
    }

    public function executeAjaxDisketteColumnDelete(sfWebRequest $request) {

        $diskid = $request->getParameter('diskid');
        $data = $request->getParameter('search');
        $data = explode("_", $data);
        $BankDisketteDao = new BankDisketteDao();
        $BankDisketteDao->DisketteColumnDelete($diskid, $data[0], $data[1]);
        echo json_encode("true");
        die;
    }

    public function executeDeleteBankDiskette(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $BankDisketteService = new BankDisketteService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hsPrBankDiskette', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $BankDisketteService->deleteBankDisketteDetail($ids[$i]);
                        $BankDisketteService->deleteBankDiskette($ids[$i]);
                        $conHandler->resetTableLock('hsPrBankDiskette', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/BankDiskette');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/BankDiskette');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('payroll/BankDiskette');
    }

    public function executeDeleteBankDisketteProcess(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $BankDisketteService = new BankDisketteService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hsPrBankDisketteProcess', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $BankDisketteService->BankDisketteProcessEmployee($ids[$i]);
                        $BankDisketteService->BankDisketteProcess($ids[$i]);
                        $conHandler->resetTableLock('hsPrBankDisketteProcess', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/BankDisketteProcess');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/BankDisketteProcess');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('payroll/BankDisketteProcess');
    }

    public function executeDeleteSalarayIncrement(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $SalarayIncrementService = new SalarayIncrementService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                $today = date("Y-m-d");
                for ($i = 0; $i < count($ids); $i++) {


                    $ID = explode("_", $ids[$i]);

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_pr_increment', array($ID[0], $ID[1], $ID[2]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $abc = $SalarayIncrementService->deleteIncrement($ID[0], $ID[2], $ID[1], $today);
                        if ($abc == '0') {
                            $countArr = $ids[$i];
                        }
                        $conHandler->resetTableLock('hs_pr_increment', array($ID[0], $ID[1], $ID[2]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/SalarayIncrement');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('payroll/SalarayIncrement');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("The record can not be deleted, the details have been used else where in the system.", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('payroll/SalarayIncrement');
    }

    public function executeSalarayIncrementCancel(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $SalarayIncrementService = new SalarayIncrementService;

            $this->sorter = new ListSorter('SalarayIncrementCancel', 'payroll', $this->getUser(), array('s.inc_effective_date', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('payroll/SalarayIncrementCancel');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 's.inc_effective_date' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $SalarayIncrementService->searchSalarayIncrementDetailsCancel($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->SalarayIncrementList = $res['data'];
            $this->SalarayCancelList = $SalarayIncrementService->getEmpProcessedDate();

            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executePayrollEmployeeList(sfWebRequest $request) {

        $userCulture = "en";
        $orderBy = 'ASC';
        $orderField = 'e.emp_number';
        $type = 'single';
        $reason = '';
        $payroll = 'payroll';
        $payrolltype = $request->getParameter('payrollType');
        $locationWise = $request->getParameter('locationWise');
        $empId = $request->getParameter('empId');
        $startDate = $request->getParameter('startDate');
        $endDate = $request->getParameter('endDate');

        $payProcessDao = new payProcessDao();
        $Employee = $payProcessDao->getEmployee($empId);
        $System = $Employee->hie_code_2;

        $result = $payProcessDao->PayrollEmployeeList($userCulture, $orderField, $orderBy, $reason, $type, $payroll, $payrolltype, $locationWise, $startDate, $endDate, $System);

        foreach ($result as $row) {

            if ($this->culture == "en") {
                $abc = "emp_display_name";
            } else {
                $abc = "emp_display_name_" . $userCulture;
            }


            $arr[$row['empNumber']] = $row['empNumber'];
        }

        $comma_separated = implode("|", $arr);
        // die(print_r($comma_separated[0]));
        echo json_encode(array('empList' => $comma_separated));

        die;
    }

    public function executeSalaryCancelTrue(sfWebRequest $request) {

        $emp = $request->getParameter('emp');
        $newsal = $request->getParameter('newsal');
        $salincDao = new SalarayIncrementDao();
        $Emp = $salincDao->findEmployee($emp);
        $Basicsal = $salincDao->getGradeSlotByID($Emp->grade_code, $Emp->slt_scale_year);
        if ($newsal == $Basicsal['emp_basic_salary']) {
            $val = "0";
        } else {
            $val = "1";
        }
        echo json_encode($val);
        die;
    }

    public function executeTransdetailsIsBase(sfWebRequest $request) {

        $value = $request->getParameter('value');

        $assignDao = new AssignEmployeeDao();
        $transDetails = $assignDao->getTransDetailForBase($value);
        $val = $transDetails[0]->trn_dtl_isbasetxn_flg;
        if ($val == "1") {
            $val = "1";
        } else {
            $val = "0";
        }

        echo json_encode($val);
        die;
    }

    public function executeAjaxEPFETF(sfWebRequest $request) {

        $EPF = $request->getParameter('EPF');
        $ETF = $request->getParameter('ETF');
        $eno = $request->getParameter('eno');

        $assignDao = new AssignEmployeeDao();
        $rEPF = $assignDao->readEPF($EPF);
        $rETF = $assignDao->readETF($ETF);
        $EPF = $rEPF[0]['count'];
        $ETF = $rETF[0]['count'];

        //die(print_r($EPF));
        echo json_encode(Array($EPF, $ETF));
        die;
    }

    public function setMessage($messageType, $message = array(), $persist = true) {
        $this->getUser()->setFlash('messageType', $messageType, $persist);
        $this->getUser()->setFlash('message', $message, $persist);
    }

    public function executeAjaxBankEmployeeLoad(sfWebRequest $request) {

        $bankName = $request->getParameter('bankName');
        $process_type = $request->getParameter('process_type');
        $dis_code = $request->getParameter('dis_code');

        $BankDisketteDao = new BankDisketteDao();

        $result = $BankDisketteDao->defaultBankEmployeeLoad($bankName, $process_type, $dis_code);
        foreach ($result as $row) {
//            if ($result[0] == $row) {
           
                    $Employee.=$row['empNumber']."|"  ;
//                }
        }

        echo json_encode($Employee);
        die;
    }

    public function executeCompanyStructurebyTitle(sfWebRequest $request) {

        $title = $request->getParameter('title');

        $CompanyService = new CompanyService();

        $result = $CompanyService->readCompanyStructurebyTitle($title);
        foreach ($result as $row) {
            
             if ($emplist[0] == $row) {
           
                    $Employee.="|" . $row['id'];
                }
        }

        echo json_encode($Employee);
        die;
    }
    
        public function executeAjaxCall(sfWebRequest $request) {
            $this->value = $request->getParameter('sendValue');
            $bankDao= new BankDao();
            $Empployee=$bankDao->readEmployee($this->value);

            echo json_encode($Empployee->employeeId);
        die;
            
        }
        
        
        
        public function executeProgressBarValidation(sfWebRequest $request) {

        $encryption=new EncryptionHandler();    
        $this->startDate = $request->getParameter('startDate');
        $this->endDate = $request->getParameter('endDate');
        $this->payrollType = $request->getParameter('payrollType');
        $this->User = $request->getParameter('User');


        $payProcessDao = new payProcessDao();

        $empList = $payProcessDao->readProcessbarIsRecord($this->startDate, $this->endDate, $this->User, $this->payrollType);
        if($empList[0]['count']==1){
            $count=1;
        }else{
            $count=0;
        }
        echo json_encode($count);
        die;
    }
    
    
    public function executeProgressBarReset(sfWebRequest $request) {
        $this->startDate = $request->getParameter('startDate');
        $this->endDate = $request->getParameter('endDate');
        $this->payrollType = $request->getParameter('payrollType');
        $this->User = $_SESSION['user'];
        
        $payProcessDao = new payProcessDao();
        $payProcessDao->resetProgressbar($this->startDate,$this->endDate,$this->payrollType,$this->User);
        $this->redirect('payroll/StartProcess1');
        
    }
    
        public function executeDBFCHKPrint(sfWebRequest $request) {
            
            $Month = "201207";
            $EmpNumber = "1";
            $Transactioncode = "1";
            $AccontNo="2154785";
            $Initals="A.B.C";
            $Surname="Perera";
            $Amount="2500";
            $f20_stat="0";
            
            $EmployeePayrollDao = new EmployeePayrollDao();
            $remittance=$EmployeePayrollDao->getckeckremitencedao($Month);
            
            die(print_r($remittance));
            
            $file_handle = fopen('remfile.dbf', 'w') or die('Error opening file.');

            // The data we want in the file, then write it
            //$data1 = "This is the first line.\n";
            $data1 = $Month." ".$EmpNumber." ".$Transactioncode." ".$AccontNo." ".$Initals." ".$Surname." ".$Amount." ".$f20_stat;
            fwrite($file_handle, $data1);

            fclose($file_handle);
            print $data1;





        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Description: File Transfer');
        header("Content-Type: $type");       
        header('Content-disposition: attachment; filename=example.xls');
        //echo($fh);
        exit;
    }
    
    public function executeViewPaySheet(sfWebRequest $request) {
        $this->culture=$this->getUser()->getCulture();
        $this->empName = $request->getParameter('empName');


//die($this->empName);
        $this->startDate = $request->getParameter('startDate');

        $this->endDate = $request->getParameter('endDate');
        $this->empNumber = $request->getParameter('empNumber');
        $encrypt=new EncryptionHandler();
        $payrollType=$encrypt->decrypt($request->getParameter('payrollType'));

        $payProcessService = new payProcessService();
        $this->myCulture = $this->getUser()->getCulture();
        $payProcessDao = new payProcessDao();
        $this->Employee = $payProcessDao->getEmployee($this->empNumber);

        //$this->getPaySlipDetails = $payProcessService->getPaySlipDetails($this->startDate, $this->endDate, $this->empNumber);
        //$this->getPaySlipDetailsTXN = $payProcessService->getPaySlipDetailsTXN($this->startDate, $this->endDate, $this->empNumber);
        $this->getPaysheetColumn = $payProcessService->getPaysheetColumn($this->startDate, $this->endDate, $this->empNumber);
        $this->getPaysheetLoanColumn = $payProcessService->getPaysheetLoanColumn();
        $this->getPaysheetData = $payProcessService->getPaysheetData($this->startDate, $this->endDate, $payrollType);
        $this->getPaysheetLoanData = $payProcessService->getPaysheetLoanData($this->startDate, $this->endDate, $payrollType);
        //die(print_r($this->getPaySlipDetailsLoan[0][ln_ty_number]));
        //$this->getPaySlipDetailsLoanRemain = $payProcessService->getPaySlipDetailsLoanRemain($this->startDate, $this->endDate, $this->empNumber);
    //print_r($this->getPaySlipDetailsLoanRemain[0]);
        
    }
    
    
    public function executeEmployeeTransaction(sfWebRequest $request) {
        //die("EmployeeTransaction");
    }
        
    public function executeAjaxEmployeeTransaction(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $EmployeePayDao = new EmployeePayrollDao();

        $id = $request->getParameter('id');
        $fdate = $request->getParameter('fdate');
        $tdate = $request->getParameter('tdate');
        
        $EmpEligibile = $EmployeePayDao->readEmployeePayRollEligibility($id,$fdate,$tdate);
        //die(print_r($EmpEligibile));
        


        echo json_encode($EmpEligibile);
        die;
    }

}
