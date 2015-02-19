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
/**
 * Actions class for Pim module
 *
 * -------------------------------------------------------------------------------------------------------
 *  Author    - Jayanath Liyanage
 *  On (Date) - 01 December 2012 
 *  Comments  - Employee Personal Information Functions 
 *  Version   - Version 1.0
 * -------------------------------------------------------------------------------------------------------
 * */
include ('../../lib/common/LocaleUtil.php');
include ('../../lib/common/signature-to-image.php');

class pimActions extends sfActions {
    const PERSONAL_PANE = 1;

    const JOB_PANE = 2;

    const DEPENDENTS_PANE = 3;

    const CONTACTS_PANE = 4;

    const EMG_CONTACTS_PANE = 5;

    const ATTACHMENTS_PANE = 6;

    const EDUCATION_PANE = 9;

    const IMMIGRATION_PANE = 10;

    const LANGUAGES_PANE = 11;

    const LICENSES_PANE = 12;

    const MEMBERSHIPS_PANE = 13;

    const PAYMENTS_PANE = 14;

    const REPORTTO_PANE = 15;

    const SKILLS_PANE = 16;

    const WORK_EXPERIENCE_PANE = 17;

    const TAX_PANE = 18;

    const DIRECT_DEBIT_PANE = 19;

    const CUSTOM_PANE = 20;

    const PHOTO_PANE = 21;

    const EB_PANE=22;

    const SERVICE_PANE=23;

    const VIEW_MODE = 'view';
    const EDIT_MODE = 'edit';
    const ADD_MODE = 'add';

    protected $countryService;

    /**
     * Get Country Service
     */
    public function getCountryService() {
        $countryService = new CountryService();
        $countryDao = new CountryDao();
        $countryService->setCountryDao($countryDao);

        return $countryService;
    }

    /**
     * Set message
     */
    public function setMessage($messageType, $message = array()) {
        $this->getUser()->setFlash('messageType', $messageType);
        $this->getUser()->setFlash('message', $message);
    }

    /**
     * Index action. Displays employee list
     *      `
     * @param sfWebRequest $request
     */
    public function executeEmployeeList(sfWebRequest $request) {
        try {
            $this->getUser()->setCulture($_SESSION['language']);
            $this->userCulture = $this->getUser()->getCulture();
            $employeeService = new EmployeeService();
            $jobDao = new JobDao();
            
            $this->DesignationList = $jobDao->getJobtitleCombo();
            $this->WorkstationList = $jobDao->getWorkstaionCombo();

            $this->sorter = new ListSorter('propoerty.sort', 'pim_module', $this->getUser(), array('emp_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            $this->searchMode = ($request->getParameter('cmbSearchMode') == '') ? 'all' : $request->getParameter('cmbSearchMode');
            $this->searchValue = ($request->getParameter('txtSearchValue') == '') ? '' : $request->getParameter('txtSearchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $result = $employeeService->getEmployeeList($this->searchMode, $this->searchValue, $this->userCulture, $request->getParameter('page'), $this->sort, $this->order);

            //$this->listEmployee = $result['data'];
            $listEmployeeCount = $employeeService->countEmployeesList();
            $this->listEmployeeCount=$listEmployeeCount[0]['count'];

            //$this->pglay = $result['pglay'];
            //$this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            //$this->pglay->setSelectedTemplate('{%page}');
            if (count($result['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        } catch (sfStopException $sf) {
            $this->redirect('default/error');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeDeleteEmployee(sfWebRequest $request) {

        if (count($request->getParameter('chkID')) > 0) {
            $PIMDao = new EmployeeDao();
            try {

                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_employee', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        if ($_SESSION['empNumber'] != $ids[$i]) {
                            $saveArr = $ids[$i];
                            $PIMDao->deleteEmployee($ids[$i]);
                            $conHandler->resetTableLock('hs_hr_employee', array($ids[$i]), 1);
                        } else {
                            $this->setMessage('WARNING', array('Not allowed to delete currently logged, employee data .'));
                        }
                    }
                }
                if (count($saveArr) > 0 && count($countArr) == 0) {
                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
                } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
                } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('This record may uses another place')));
                $this->redirect('pim/list');
            } catch (Exception $e) {
                $conn->rollBack();
                $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('This record may uses another place')));
                $this->redirect('pim/list');
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }

        $_SESSION['PIM_EMPID'] = $_SESSION['empNumber'];

        $this->redirect('pim/list');
    }

    /**
     * Delete action. Deletes the employees with the given ids
     */
    public function executeDelete(sfWebRequest $request) {
        die("hello");
    }

    /**
     * Add a new employee
     */
    public function executeAddEmployee(sfWebRequest $request) {

        try {


            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();

            $encrypt = new EncryptionHandler();

            //----Recruitment Employee Add
            $RecId = $encrypt->decrypt($request->getParameter('id'));
            $type = $request->getParameter('type');

            if ($type == 'CN' && $RecId != null) {
                $InterviewDao = new InterviewDao();
                $this->InterviewData = $InterviewDao->getInterviewInfoById($RecId);
            }


            //----Recruitment Employee End
            $this->userCulture = $this->getUser()->getCulture();
            $service = new EmployeeService();

            $this->empID = $service->getDefaultEmployeeId();



            $genderService = new GenderService();
            $this->genders = $genderService->getGenderList();

            $maritalService = new MaritalStatusService();
            $this->maritalStatusList = $maritalService->getMaritalStatusList();

            $religionService = new ReligionService();
            $this->religionList = $religionService->getReligionList();
            $titleService = new TitleService();
            $this->empTitles = $titleService->getTitleList();

            $nationalityService = new NationalityService();
            $this->nationalityList = $nationalityService->getNationalityList('nat_name', 'ASC');

            $this->ethnicRaceList = $nationalityService->getEthnicRaceList();

            $languageService = new LanguageService();
            $this->languageList = $languageService->getLanguageList();

            $countryService = $this->getCountryService();
            $this->countryList = $countryService->getCountryList();

            $this->form = new EmployeeAddForm();
//            die(print_r($_SESSION));


            $this->type = $request->getParameter('type');
            if ($this->getRequest()->isMethod('post')) {


                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {

                    $employee = $this->form->getEmployee();

                    // save data
                    $EMPDao = new EmployeeDao();


                    if (strlen($_SESSION['empNumber'])) {
                        $empDefLevel=$EMPDao->readEmployeeLevelExist($employee->empNumber);
//                        die(print_r($empDefLevel));
                        if($empDefLevel== null){
                        $empDefLevel = new EmployeeDefLevel();
                        }
                        $parentEmpObj = $EMPDao->readEmployee($_SESSION['empNumber']);

                        for ($i = 1; $i <= 10; $i++) {
                            $col = "hie_code_" . $i;
                            $empDefLevel->$col = $parentEmpObj->$col;
                            $employee->$col = $parentEmpObj->$col;
                        }
                        $service->addEmployee($employee);
                        
                        $empLastID = $EMPDao->getEmpMaxId();
                        $empDefLevel->emp_number = $empLastID[0]['Max'];
                        //$empDefLevel->emp_number = $employee->empNumber;
                        //die(print_r($employee->empNumber."|". $empLastID[0]['Max']));
                        
                        $empDefLevel->save();
                    } else {
                        $service->addEmployee($employee);
                    }


                    $empLastID = $empLastID[0]['Max'];

                    $userService = new UserService();
                    //add default user account

                    $user = new Users();
                    $user->setIsAdmin("No");
                    //$user->setEmp_number($empLastID);
                    $user->setEmp_number($employee->empNumber);
                    $user->setCreated_by($_SESSION['user']);
                    $user->setUserName($employee->employeeId);
                    $user->setUserPassword(md5($employee->emp_nic_no));
                    $user->setUsergId(null);
                    $user->setSm_capability_id(1);
                    $user->setStatus("Enabled");
                    $user->setDef_level(4);
                    $user->setUser_prefered_language("en");
                    $user->setDate_entered(date("Y-m-d", time()));
                    $userService->saveUser($user);

                    $_SESSION['PIM_EMPID'] = $empLastID;
                    $conn->commit();
                    // change to full pim edit view

                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Added", $args = "", 'messages')));
                    $this->redirect('pim/personalDetail?empNumber=' . $encrypt->encrypt($empLastID));
                } else {

                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }
        } catch (sfStopException $sf) {
            
        } catch (Doctrine_Connection_Exception $e) {
            $conn->rollBack();
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/addEmployee'); 
        } catch (Exception $e) {
            $conn->rollBack();
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/addEmployee');
        }
    }

    /**
     * Check if employee id already exists
     */
    public function executeValidateEmployeeId(sfWebRequest $request) {

        try {
            $empId = $request->getParameter('empId', false);
            $service = new EmployeeService();

            // check if id already exist
            if ($service->getEmployee($empId) instanceof EmployeeMaster) {
                $recordExist = true;
            } else {
                $recordExist = false;
            }

            echo json_encode(array('recordExist' => $recordExist));
            die;
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/employeeList');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Personal details New Action
     */
    public function executePersonalDetail(sfWebRequest $request) {
        $encrypt = new EncryptionHandler();


        $this->getUser()->setCulture($_SESSION['language']);
        if ($request->getParameter('empNumber')) {
            if (strlen($request->getParameter('empNumber'))) {

                $empNumber = $encrypt->decrypt($request->getParameter('empNumber'));

                $_SESSION['PIM_EMPID'] = $empNumber;
            }
        } elseif (strlen($_SESSION['PIM_EMPID'])) {
            
        } else {
            if (strlen($_SESSION['empNumber'])) {
                $_SESSION['PIM_EMPID'] = $_SESSION['empNumber'];
            }
        }

        if (strlen($_SESSION['PIM_EMPID'])) {
            try {

                $this->DisplayMode = $request->getParameter('Displaymode');
                $this->userCulture = $this->getUser()->getCulture();


                $empNumber = $_SESSION['PIM_EMPID'];
                $service = new EmployeeService();

                $this->employee = $service->getEmployee($empNumber);
                $empObj = $this->employee;

                $_SESSION['LDAP_USERID'] = $empObj->empNumber;

                $titleService = new TitleService();
                $this->empTitles = $titleService->getTitleList();
                $genderService = new GenderService();
                $this->genders = $genderService->getGenderList();

                $maritalService = new MaritalStatusService();
                $this->maritalStatusList = $maritalService->getMaritalStatusList();

                $religionService = new ReligionService();
                $this->religionList = $religionService->getReligionList();

                $nationalityService = new NationalityService();
                $this->nationalityList = $nationalityService->getNationalityList('nat_name', 'ASC');

                $this->ethnicRaceList = $nationalityService->getEthnicRaceList();

                $languageService = new LanguageService();
                $this->languageList = $languageService->getLanguageList();

                $countryService = $this->getCountryService();
                $this->countryList = $countryService->getCountryList();

                $this->postArr['EditMode'] = 0;


                if ($this->getRequest()->isMethod('post')) {

                    $empNumber = $encrypt->decrypt($request->getParameter('empNumber'));
                    $service = new EmployeeService();





                    // TODO: Set ESS mode, enable csrf protection
                    $this->form = new EmployeePersonalDetailsForm(array(), array(), false);

                    // Handle the form submission
                    $this->form->bind($request->getPostParameters());

                    if ($this->form->isValid()) {
                        // validate either ADMIN, supervisor for employee or employee himself
                        // save data

                        $service->savePersonalDetails($this->form->getEmployee());

                        $empDao = new EmployeeDao();
                        $empJob = $empDao->readEmployee($empNumber);

                        /* LDAP integrations will be added in future */
                        $sysConf = new sysConf();
                        if ($sysConf->isuseLdap == "YES") {

                            if ($empJob->emp_active_hrm_flg == 1) {
                                $ldapDao = new ldapDao();

                                $ldapDao->callToLdap($empJob);
                            } else {
                                
                            }
                        }

                        /* end of ldap */



                        /* End of LDAP */
                    } else {
                        $this->getUser()->setFlash('errorForm', $this->form);
                    }

                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                    if ($request->getParameter('empNumber')) {
                        $this->redirect('pim/personalDetail?empNumber=' . $encrypt->encrypt($empNumber));
                    } else {
                        $this->redirect('pim/list');
                    }
                }
            } catch (sfStopException $sf) {
                
            } catch (Doctrine_Connection_Exception $e) {

                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());

                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/personalDetail');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/personalDetail');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Check Whether Employee attendence number exist 
     */

    public function executeIsAttNoExist(sfWebRequest $request) {

        try {
            $attendNo = $request->getParameter('attendNo', false);
            $empNumber = $request->getParameter('empNum', false);

            $service = new EmployeeService();
            $result = $service->IsAttExist($attendNo, $empNumber, $mode);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /*
     * Employee Contact Details Controller
     */

    public function executeContactDetail(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {

            try {
                $sysConf = new sysConf();
                $this->userCulture = $this->getUser()->getCulture();
                $empNumber = $_SESSION['PIM_EMPID'];
                $service = new EmployeeService();

                $this->employee = $service->getEmployee($empNumber);

                $countryService = $this->getCountryService();
                $this->countries = $countryService->getCountryList();
                $this->empContact = $service->getEmployeeContact($empNumber);
                $this->postArr['EditMode'] = 0;

                $this->form = new EmployeeContactDetailsForm(array(), array('ESS' => false), false);

                if ($this->getRequest()->isMethod('post')) {
                    // Handle the form submission
                    $this->form->bind($request->getPostParameters());

                    if ($this->form->isValid()) {
                        // validate either ADMIN, supervisor for employee or employee himself
                        $service = new EmployeeService();
                        $service->saveContactDetails($this->form->getEmployeeContact());



                        /* LDAP integration */
                        $empDao = new EmployeeDao();
                        $empJob = $empDao->readEmployee($empNumber);

                        if($empJob!=null){
                        $sysConf = new sysConf();
                        if ($sysConf->isuseLdap == "YES") {

                            if ($empJob->emp_active_hrm_flg == 1) {
                                $ldapDao = new ldapDao();

                                $ldapDao->callToLdap($empJob);
                            } else {
                                
                            }
                        }
                        }
                        /*  End of LDAP integration  */
                        $conHandler = new ConcurrencyHandler();
                        $conHandler->resetTableLock('hs_hr_emp_contact', array($empNumber), 1);
                        $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                        $this->redirect('pim/contactDetail');
                    } else {
                        $this->getUser()->setFlash('errorForm', $this->form);
                    }
                }
            } catch (Doctrine_Connection_Exception $e) {

                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/contactDetail');
            } catch (sfStopException $sf) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/contactDetail');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /**
     * Update employee contact details
     */
    public function executeContactDetails(sfWebRequest $request) {
        try {
            
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/contactDetail');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/contactDetail');
        }
    }

    public function executeUpdateJob(sfWebRequest $request) {
        
    }

    /*
     * Update the Employee Eb exams
     *
     */

    public function executeUpdateebExam(sfWebRequest $request) {
        try {
            // TODO: Set ESS mode, enable csrf protection
            $empNumber = $request->getParameter('empNumber');
            $examId = $request->getParameter('txtExamId');

            $this->form = new EmployeeEBExamForm(array(), array('ESS' => false), false);

            if ($this->getRequest()->isMethod('post')) {


                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    // save data

                    $service = new EmployeeService();

                    $service->saveEMBexam($this->form->getEBexam($empNumber, $examId));
                    $conHandler = new ConcurrencyHandler();
                    $conHandler->resetTableLock('hs_hr_ebexam', array($empNumber, $examId), 1);
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }
            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $empNumber = $request->getParameter('empNumber');
            $this->redirect('pim/ebexam');
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/ebexam');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/ebexam');
        }
    }

    /*
     * Update Employee service record 
     */

    public function executeUpdatServiceRec(sfWebRequest $request) {


        try {
            $empNumber = $request->getParameter('empNumber');
            $SerNo = $request->getParameter('txtSerRecId');

            $this->form = new EmployeeServiceRecordFrom(array(), array('ESS' => false), false);

            if ($this->getRequest()->isMethod('post')) {


                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    // save data

                    $service = new EmployeeService();

                    $service->saveServiceRecord($this->form->getServiceRecord($empNumber, $SerNo));
                    $conHandler = new ConcurrencyHandler();
                    $conHandler->resetTableLock('hs_hr_emp_service_history', array($empNumber, $SerNo), 1);
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }
            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $empNumber = $request->getParameter('empNumber');
            $this->redirect('pim/serviceRecord');
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/serviceRecord');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/serviceRecord');
        }die;
    }

    public function executeOldView(sfWebRequest $request) {
        $empNumber = $request->getParameter('empNumber');
        $service = new EmployeeService();
        $this->employee = $service->getEmployee($empNumber);
        $countryService = $this->getCountryService();
        $this->countries = $countryService->getCountryList();
        $this->provinces = $countryService->getProvinceList();

        $nationalityService = new NationalityService();

        $this->nationalities = $nationalityService->getNationalityList();
        $this->races = $nationalityService->getEthnicRaceList();
    }

    /**
     * Add job history item to employeee
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeDeleteJobHistory(sfWebRequest $request) {

        $this->setLayout(false);
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);





        $service = new EmployeeService();

        // Job title history
        $empId = $request->getParameter('EmpID', false);
        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }
        $jobTitlesToDelete = $request->getParameter('chkjobtitHistory', false);
        $subDivisionsToDelete = $request->getParameter('chksubdivisionHistory', false);
        $locationsToDelete = $request->getParameter('chklocationHistory', false);

        if ($jobTitlesToDelete) {
            $service->deleteJobTitleHistory($empId, $jobTitlesToDelete);
        }
        if ($subDivisionsToDelete) {
            $service->deleteSubDivisionHistory($empId, $subDivisionsToDelete);
        }
        if ($locationsToDelete) {
            $service->deleteLocationHistory($empId, $locationsToDelete);
        }
        //}
        $this->redirect('pim/viewEmployee?empNumber=' . $empId . '&pane=' . self::JOB_PANE);
    }

    /**
     * Delete employee attachments
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteAttachments(sfWebRequest $request) {




        $empId = $request->getParameter('EmpID', false);

        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $attachmentsToDelete = $request->getParameter('chkattdel', array());
        if ($attachmentsToDelete) {

            $service = new EmployeeService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();




                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($attachmentsToDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_attachment', array($attachmentsToDelete[$i], $empId), 1);


                    if ($isRecordLocked) {
                        $countArr = $attachmentsToDelete[$i];
                    } else {
                        $saveArr = $attachmentsToDelete[$i];

                        $service->deleteAttachments($empId, $attachmentsToDelete[$i]);
                        $conHandler->resetTableLock('hs_hr_emp_attachment', array($attachmentsToDelete[$i], $empId), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/Attachment');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/Attachment');
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
        $this->redirect('pim/Attachment');
    }

    /**
     * Delete EMBExam
     */
    public function executeDeleteEbExam(sfWebRequest $request) {



        $empId = $request->getParameter('empNumber', false);

        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $examsToDelete = $request->getParameter('chkID', array());
        if ($examsToDelete) {

            $service = new EmployeeService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($examsToDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_ebexam', array($empId, $examsToDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $examsToDelete[$i];
                    } else {
                        $saveArr = $examsToDelete[$i];

                        $service->deleteEbExam($empId, $examsToDelete[$i]);
                        $conHandler->resetTableLock('hs_hr_ebexam', array($empId, $examsToDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/ebexam');
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
        $this->redirect('pim/ebexam');
    }

    /**
     * Delete Service Record
     */
    public function executeDeleteServiceRecord(sfWebRequest $request) {



        $empId = $request->getParameter('empNumber', false);

        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $ServiceToDelete = $request->getParameter('chkID', array());
        if ($ServiceToDelete) {

            $service = new EmployeeService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ServiceToDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_service_history', array($empId, $ServiceToDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $ServiceToDelete[$i];
                    } else {
                        $saveArr = $ServiceToDelete[$i];

                        $service->deleteServiceRecord($empId, $ServiceToDelete[$i]);
                        $conHandler->resetTableLock('hs_hr_emp_service_history', array($empId, $ServiceToDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/serviceRecord');
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
        $this->redirect('pim/serviceRecord');
    }

    /**
     * Add / update employee attachment
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateAttachment(sfWebRequest $request) {
        // TODO: Set ESS mode, enable csrf protection
        $this->form = new EmployeeAttachmentForm(array(), array(), false);

        if ($this->getRequest()->isMethod('post')) {

            try {
                // Handle the form submission
                $this->form->bind($request->getPostParameters(), $request->getFiles());
                $sysConfinst = OrangeConfig::getInstance()->getSysConf();
                $sysConfs = new sysConf();

                if (array_key_exists('ufile', $_FILES)) {

                    foreach ($_FILES as $file) {



                        if ($file['tmp_name'] > '') {


                            if (!in_array(end(explode(".", strtolower($file['name']))), $sysConfs->getAllowExtensionsForEmpAttch())) {
                                throw new Exception("Invalid File Type", 8);
                            }
                        }
                    }
                } else {
                    throw new Exception("Invalid File Type", 6);
                }

                $maxsize = $sysConfs->getMaxFilesize();

                $sysConfinst = OrangeConfig::getInstance()->getSysConf();
                if ($file['size'] > $maxsize) {
                    throw new Exception("Maxfile size  Should be less than 2MB", 1);
                }
                if ($this->form->isValid()) {

                    // validate either ADMIN, supervisor for employee or employee himself
                    // save data

                    $this->form->save();
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/Attachment');
            }
        }



        $this->redirect('pim/Attachment');
    }

    /*
     * View the Employee saved attachments
     */

    public function executeViewAttachment(sfWebRequest $request) {
        $empNumber = $request->getParameter('empNumber');
        $attachId = $request->getParameter('attachId');

        $employeeService = new EmployeeService();
        $attachment = $employeeService->getAttachment($empNumber, $attachId);

        if (!empty($attachment)) {
            $contents = $attachment->attachment;
            $contentType = $attachment->file_type;
            $fileName = $attachment->filename;
            $fileLength = $attachment->size;

            $response = $this->getResponse();
            $response->setHttpHeader('Pragma', 'public');

            $response->setHttpHeader('Expires', '0');
            $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
            $response->setHttpHeader("Cache-Control", "private", false);
            $response->setHttpHeader("Content-Type", $contentType);
            $response->setHttpHeader("Content-Disposition", 'attachment; filename="' . $fileName . '";');
            $response->setHttpHeader("Content-Transfer-Encoding", "binary");
            $response->setHttpHeader("Content-Length", $fileLength);

            $response->setContent($contents);
            $response->send();
        } else {
            $response->setStatusCode(404, 'This attachment does not exist');
        }

        return sfView::NONE;
    }

    /**
     * Delete employee supervisors
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteSupervisors(sfWebRequest $request) {



        $empId = $request->getParameter('EmpID', false);

        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $deleteList = $request->getParameter('chksupdel', array());

        if ($deleteList) {

            $service = new EmployeeService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                // $deleteList contains supervisorId|reporting method
                $supervisorsToDelete = array();

                foreach ($deleteList as $sup) {
                    $parts = explode('|', $sup);
                    if (count($parts) == 2) {
                        $supervisorsToDelete[] = array('emp' => $parts[0], 'method' => $parts[1]);
                    }
                }

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($supervisorsToDelete); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_reportto', array($supervisorsToDelete[$i]['emp'], $empId), 1);


                    if ($isRecordLocked) {
                        $countArr = $supervisorsToDelete[$i];
                    } else {
                        $saveArr = $supervisorsToDelete[$i];
                        $service->deleteSupervisors($empId, $supervisorsToDelete[$i]);

                        $conHandler->resetTableLock('hs_hr_emp_reportto', array($supervisorsToDelete[$i]['emp'], $empId), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/viewEmployee?empNumber=' . $empId . '&pane=' . self::REPORTTO_PANE);
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
        $this->redirect('pim/reportTo');
    }

    /**
     * Delete employee subordinates
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteSubordinates(sfWebRequest $request) {



        $empId = $request->getParameter('EmpID', false);

        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $deleteList = $request->getParameter('chksubdel', array());

        if ($deleteList) {

            $service = new EmployeeService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $subordinatesToDelete = array();

                foreach ($deleteList as $sup) {
                    $parts = explode('|', $sup);
                    if (count($parts) == 2) {
                        $subordinatesToDelete[] = array('emp' => $parts[0], 'method' => $parts[1]);
                    }
                }

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($subordinatesToDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_reportto', array($empId, $subordinatesToDelete[$i]['emp']), 1);


                    if ($isRecordLocked) {
                        $countArr = $subordinatesToDelete[$i];
                    } else {
                        $saveArr = $subordinatesToDelete[$i];

                        $service->deleteSubordinates($empId, $subordinatesToDelete[$i]);
                        $conHandler->resetTableLock('hs_hr_emp_reportto', array($empId, $subordinatesToDelete[$i]['emp']), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/viewEmployee?empNumber=' . $empId . '&pane=' . self::REPORTTO_PANE);
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
        $this->redirect('pim/reportTo');
    }

    /**
     * Add / update employee reportTo
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateReportTo(sfWebRequest $request) {
        // TODO: Set ESS mode, enable csrf protection

        $this->form = new EmployeeReportToForm(array(), array(), false);

        if ($this->getRequest()->isMethod('post')) {//die(print_r($_POST));
            // Handle the form submission
            $this->form->bind($request->getPostParameters());

            $Sup_empNumber = $request->getParameter('txtSupEmpID');
            $Sub_empNumber = $request->getParameter('txtSubEmpID');




            // validate either ADMIN, supervisor for employee or employee himself
            // save data
            try {
                // Verify EmpID matches one of old supervisor/subordinate
                $empNumber = $request->getParameter('EmpID');
                $oldSupervisorId = $request->getParameter('txtSupEmpID');

                $oldSubordinateId = $request->getParameter('txtSubEmpID');


                // NOTE: This is not a user error
                if (!empty($oldSupervisorId) && !empty($oldSubordinateId)) {
                    if (($empNumber != $oldSupervisorId) && ($empNumber != $oldSubordinateId)) {
                        $message = sfContext::getInstance()->getI18N()->__('Invalid input');
                        $error = new sfValidatorError($validator, $message);
                        throw new sfValidatorErrorSchema($validator, array('' => $error));
                    }
                }

                // Verify EmpID does not match new supervisor/subordinate
                $otherEmpId = $request->getParameter('txtRepEmpID');

                //Single Direct supervior
                if ($request->getParameter('cmbRepMethod') == "1") {
                    $reportingType = $request->getParameter('cmbRepType');
                    if ($reportingType == "Supervisor") {
                        $supervisor = $request->getParameter('txtRepEmpID');
                        $subordinate = $request->getParameter('EmpID');
                    } else {
                        $supervisor = $request->getParameter('EmpID');
                        $subordinate = $request->getParameter('txtRepEmpID');
                    }
                    $query = Doctrine_Query::create()
                            ->select('Count(supervisorId)')
                            ->from('ReportTo r')
                            ->where('r.subordinateId =?', $subordinate)
                            ->Andwhere('r.reportingMode =1');
                    $Count = $query->fetchArray();
                    if ($Count[0]['Count'] == "1") {
                        throw new Exception("Alredy Assigned Direct Supervisor.", 503);
                    }
                }


                if ($otherEmpId == $empNumber) {

                    throw new Exception("duplicate", 10);
                }
                $this->form->save();
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Added', $args, 'messages')));
                $conHandler = new ConcurrencyHandler();
                $conHandler->resetTableLock('hs_hr_emp_reportto', array($Sup_empNumber, $Sub_empNumber), 1);
            } catch (sfStopException $sf) {
                
            } catch (DataDuplicationException $e) {
                $_SESSION['errorMsg'] = $this->getContext()->getI18N()->__('Supervisor / Subordinate already added to the employee with the same method', $args, 'messages');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/reportTo');
            }
        }





        $this->redirect('pim/reportTo');
    }

    /**
     * Delete employee children
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteChildren(sfWebRequest $request) {



        /* TODO: Only allow admins and supervisors of the given employee to assign locations */
        // Job title history
        $empId = $request->getParameter('EmpID', false);
        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }
        $childrenToDelete = $request->getParameter('chkchidel', array());
        if ($childrenToDelete) {
            $service = new EmployeeService();
            $service->deleteChildren($empId, $childrenToDelete);
        }

        $this->redirect('pim/viewEmployee?empNumber=' . $empId . '&pane=' . self::DEPENDENTS_PANE);
    }

    /**
     * Add / update employee child
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateChild(sfWebRequest $request) {
        // TODO: Set ESS mode, enable csrf protection
        $this->form = new EmployeeChildForm(array(), array(), false);

        if ($this->getRequest()->isMethod('post')) {


            // Handle the form submission
            $this->form->bind($request->getPostParameters());

            if ($this->form->isValid()) {

                // validate either ADMIN, supervisor for employee or employee himself
                // save data

                $this->form->save();
            } else {
                $this->getUser()->setFlash('errorForm', $this->form);
            }
        }

        $empNumber = $request->getParameter('empNumber');

        $this->redirect('pim/viewEmployee?empNumber=' . $empNumber . '&pane=' . self::DEPENDENTS_PANE);
    }

    /**
     * Add job history item to employeee
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeAddJobHistory(sfWebRequest $request) {




        /* TODO: Only allow admins and supervisors of the given employee to assign locations */
        $this->form = new JobHistoryForm(array(), array(), false);
        $empId = $request->getParameter('EmpID', false);

        if ($this->getRequest()->isMethod('post')) {

            // Handle the form submission
            $this->form->bind($request->getPostParameters());

            if ($this->form->isValid()) {

                // validate either ADMIN, supervisor for employee or employee himself
                // save data
                $this->form->save();
            } else {
                $this->getUser()->setFlash('errorForm', $this->form);
            }
        }

        $this->redirect('pim/viewEmployee?empNumber=' . $empId . '&pane=' . self::JOB_PANE);
    }

    /**
     * Add job history item to employeee
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateJobHistory(sfWebRequest $request) {


        $result = false;


        /* TODO: Only allow admins and supervisors of the given employee to assign locations */
        $empId = $request->getParameter('EmpID', false);
        if ($this->getRequest()->isMethod('post')) {
            $service = new EmployeeService();
            $service->updateJobHistory($empId, $request->getPostParameters());
        }

        $this->redirect('pim/viewEmployee?empNumber=' . $empId . '&pane=' . self::JOB_PANE);
    }

    /**
     * emrgancy contacts action
     */
    public function executeEmeregencyContacts(sfWebRequest $request) {
        try {
            if (strlen($_SESSION['PIM_EMPID'])) {
                $this->userCulture = $this->getUser()->getCulture();
                $this->mode = $request->getParameter('mode', self::VIEW_MODE);
                $empNumber = $_SESSION['PIM_EMPID'];
                $service = new EmployeeService();

                $this->employee = $service->getEmployee($empNumber);
                $this->postArr['EditMode'] = 0;
            } else {
                $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
                $this->redirect('pim/list');
            }
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    /**
     * Dependent Acation
     */
    public function executeDependents(sfWebRequest $request) {

        try {
            if (strlen($_SESSION['PIM_EMPID'])) {
                $this->userCulture = $this->getUser()->getCulture();

                $empNumber = $_SESSION['PIM_EMPID'];
                $service = new EmployeeService();

                $this->employee = $service->getEmployee($empNumber);

                $relationshipService = new RelationshipService();
                $this->empRelationships = $relationshipService->getRelationshipList();
                $this->postArr['EditMode'] = 0;
            } else {
                $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
                $this->redirect('pim/list');
            }
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    /*
     * Employee Phtograph add controller
     */

    public function executePhotoGraph(sfWebRequest $request) {

        try {
            if (strlen($_SESSION['PIM_EMPID'])) {


                $this->userCulture = $this->getUser()->getCulture();

                $empNumber = $_SESSION['PIM_EMPID'];
                $service = new EmployeeService();

                $this->employee = $service->getEmployee($empNumber);
                $this->st = $request->getParameter("st");

                $this->postArr['EditMode'] = 0;
                $this->getArr = array();
                $this->getArr['reqcode'] = "ESS";
                $this->getArr['capturemode'] = 'updatemode';
                $this->getArr['id'] = $empNumber;
                $this->getArr['errmsg'] = "";
                if (isset($_SESSION['errorMsg'])) {
                    $this->getArr['errmsg'] = $_SESSION['errorMsg'];
                    unset($_SESSION['errorMsg']);
                }
                $this->postArr['EditMode'] = 0;

                $this->form = new EmployeePictureForm(array(), array(), false);
                $empNumber = $request->getParameter('empNumber');
                if ($request->isMethod('post')) {

                    // Handle the form submission
                    $this->form->bind($request->getPostParameters(), $request->getFiles());
                    try {
                        $sysConfinst = OrangeConfig::getInstance()->getSysConf();
                        $sysConfs = new sysConf();

                        if (array_key_exists('photofile', $_FILES)) {

                            foreach ($_FILES as $file) {

                                if ($file['tmp_name'] > '') {
                                    if (!in_array(end(explode(".", strtolower($file['name']))), $sysConfs->allowedImageExtensions)) {
                                        throw new Exception("Invalid File Type", 8);

                                        $maxsize = $sysConfs->getMaxFilesizeEmpAttach();
                                        $sysConfinst = OrangeConfig::getInstance()->getSysConf();
                                        $sysConfs = new sysConf();
                                        if ($file['size'] > $maxsize) {
                                            throw new Exception("Maxfile size  Should be less than 1MB", 9);
                                        }
                                    }
                                } else {
                                    throw new Exception("Invalid File Type", 6);
                                }
                            }
                        } else {
                            throw new Exception("Invalid File Type", 6);
                        }
                        // validate either ADMIN, supervisor for employee or employee himself
                        // save data
                        $conHandler = new ConcurrencyHandler();
                        $conHandler->resetTableLock('hs_hr_emp_picture', array($empNumber), 1);

                        $this->form->save();
                        //$this->forward("pim", "photoGraph");
                        $this->flag = 1;
                        //$this->redirect('default/index?ln='.$this->userCulture);
                    } catch (sfStopException $er) {
                        
                    } catch (Exception $e) {
                        $errMsg = new CommonException($e->getMessage(), $e->getCode());
                        $this->setMessage('WARNING', $errMsg->display());
                        $this->redirect('pim/photoGraph');
                    }
                }
            } else {
                $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
                $this->redirect('pim/list');
            }
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    /*
     * Save/Update Employee Job details controller 
     */

    public function executeJobandSal(sfWebRequest $request) {

//sfContext::switchTo('orangehrm'); //switch to the environment you wish to clear
//sfContext::getInstance()->getViewCacheManager()->getCache()->clean(sfCache::ALL);

///        $cache_dir = sfConfig::get('sf_cache_dir') . '/orangehrm/prod/config/';
//die($cache_dir);
///        $cache = new sfFileCache(array('cache_dir' => $cache_dir));
///        $cache->clean();


        if (strlen($_SESSION['PIM_EMPID'])) {
            try {
                $this->userCulture = $this->getUser()->getCulture();

                $service = new EmployeeService();
                $empNumber = $_SESSION['PIM_EMPID'];
//            die($empNumber);
                $this->employee = $service->getEmployee($empNumber);
                $DOB=$this->employee->emp_birthday;
                
                $Rdate = new DateTime($DOB);
                $Rdate->add(new DateInterval('P60Y'));
                $this->Retdate = $Rdate->format("Y-m-d");
                
                
                if (!$this->employee) {
                    $this->redirect('default/PermissionDenind');
                }
                $jobService = new JobService();
                $jobDao = new JobDao();

                $this->jobTitleList = $jobService->getJobTitleList();
                $this->ActjobTitleList = $jobService->getJobTitleList();



                $this->jobCategories = $jobService->getJobCategoryList();

                if (!empty($this->employee->jobTitle->id)) {
                    $this->employeeStatusList = $jobService->getEmployeeStatusForJob($this->employee->jobTitle->id);
                } else {
                    $this->employeeStatusList = array();
                }

                //get employee status List
                $this->empStateList = $jobService->getEmployeeStatusList();

                //get Service List
                $this->serviceList = $jobService->getEmpServiceList();

                //get the grade list
                $this->gradeList = $jobService->getJobGradeList();

                $this->gradeSlot = $jobDao->getGradeSlotByID($this->employee->grade_code);

                $this->levelList = $jobService->getJobLevelList();
                // contracts

                $clasD = new classDao();
                $this->empClassList = $clasD->getClassDetails();

                $companyService = new CompanyService();
                $this->ActingCompanyStructureLoad = $companyService->readActingCompanyStructureLoad($this->employee);

                $this->postArr['EditMode'] = 0;



                $empNumber = $request->getParameter('empNumber');
                $this->form = new EmployeeJobDetailsForm(array(), array('ESS' => false), false);

                if ($this->getRequest()->isMethod('post')) {//die(print_r($_POST));
                    // Handle the form submission
                    $conn = Doctrine_Manager::getInstance()->connection();
                    $conn->beginTransaction();
                    $this->form->bind($request->getPostParameters());

                    if ($this->form->isValid()) {


                        $service = new EmployeeService();
                        $empJob = $this->form->getEmployee();


                        if (!$empJob) {
                            throw new Exception("Security Level is not allowed to select this division/department", 501);
                        }

                        $service->saveJobDetails($this->form->getEmployee());

                        $empJob = $this->form->getEmployee();
                        /* save the def_level */
                        $companyService = new CompanyService();
                        $empDeflevelById = $companyService->readDeflevelById($empJob->empNumber);

                        if (!$empDeflevelById) {


                            $empDeflevel = new EmployeeDefLevel();
                        } else {
                            $empDeflevel = $empDeflevelById;
                        }

                        for ($i = 1; $i <= 10; $i++) {

                            $emp_def_col = "hie_code_" . $i;
                            $empDeflevel->$emp_def_col = null;
                        }


                        $hieCode = $empJob->work_station;

                        $division = $companyService->readCompanyStructure($hieCode);
                        $defLevel = $division->getDefLevel();
                        while ($defLevel > 0 && $hieCode > 0) {

                            $hieCodeCol = "hie_code_" . $defLevel;

                            $empDeflevel->$hieCodeCol = $hieCode;

                            $hieCode = $division->getParnt();
                            $division = $companyService->readCompanyStructure($hieCode);

                            $defLevel = $defLevel - 1;
                        }
                        $empDeflevel->emp_number = $empJob->empNumber;
                        $empDeflevel->save();









                        $sysConf = new sysConf();
                        if ($sysConf->isuseLdap == "YES") {
                            $ldapDao = new ldapDao();
                            $ldapDao->callToLdap($empJob);
                        }



                        /*  End of LDAP integration  */



                        $conHandler = new ConcurrencyHandler();
                        $conHandler->resetTableLock('hs_hr_employee', array($empNumber), 5);
                        
                        
                        /* update grade update to payroll */
                        if($_POST['chkPractive'] == '1'){                        
                        $payProcessDao = new payProcessDao();
                        $EmployeePayrollService = new EmployeePayrollService();
                        $AssignEmpService = new AssignEmployeeService();
                        $empBasicSalary = $AssignEmpService->getEmpbasicSalary($empNumber);
                        $empBasicSalary = $empBasicSalary[0]->emp_basic_salary;
                        
                        $EmployeePayroll = $EmployeePayrollService->readEmployeePayrollDetails(($request->getParameter('txtEMP')));
                        if ($EmployeePayroll->emp_number) {
                            $EmployeePayroll = $EmployeePayroll;
                        }
                        $payProcessDao->defaultTransactionAssign($empNumber, $empBasicSalary);
                        }
                        /* end payroll update */

                        $conn->commit();
                    } else {
                        $this->getUser()->setFlash('errorForm', $this->form);
                    }
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                    $empNumber = $request->getParameter('empNumber');
                    $this->redirect('pim/jobandSal');
                }
            } catch (Doctrine_Connection_Exception $e) {

                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            } catch (sfStopException $sf) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee report to action
     */

    public function executeReportTo(sfWebRequest $request) {
        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getReportToEmp($empNumber);

            $this->postArr['EditMode'] = 0;
            $this->getArr = array();
            $this->getArr['reqcode'] = "ESS";
            $this->getArr['capturemode'] = 'updatemode';
            $this->getArr['id'] = $empNumber;
            $this->getArr['errmsg'] = "";
            if (isset($_SESSION['errorMsg'])) {
                $this->getArr['errmsg'] = $_SESSION['errorMsg'];
                unset($_SESSION['errorMsg']);
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee Service record Controller
     */

    public function executeServiceRecord(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getEmployee($empNumber);
            $this->districtList = $service->getDistrictList();

            $this->postArr['EditMode'] = 0;
            $this->serviceRec = $service->getServiceRecListbyEmployee($empNumber);
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee WorkExperince Controller
     */

    public function executeWorkexperience(sfWebRequest $request) {
        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getEmployee($empNumber);

            $this->postArr['EditMode'] = 0;
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee Education Controller
     */

    public function executeEducation(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getEmployee($empNumber);

// Get list of unassigned education
            $this->unassignedEducationList = $service->getAvailableEducationList($empNumber);
            $this->unassignedSkills = $service->getAvailableSkills($empNumber);

            $this->postArr['EditMode'] = 0;
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee Skill Controller
     */

    public function executeSkills(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getEmployee($empNumber);

            $this->postArr['EditMode'] = 0;
            $this->unassignedSkills = $service->getAvailableSkills($empNumber);
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee Language Controller
     */

    public function executeLanguage(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getEmployee($empNumber);

            $this->postArr['EditMode'] = 0;
            $languageService = new LanguageService();
            $this->languages = $languageService->getLanguageList();
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee License Controller
     */

    public function executeLicense(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getEmployee($empNumber);

            $this->postArr['EditMode'] = 0;
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee Ebexam Controller
     */

    public function executeEbexam(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getEmployee($empNumber);
            $jobService = new JobService();

            //get Service List
            $this->serviceList = $jobService->getEmpServiceList();

            //get the grade list
            $this->gradeList = $jobService->getJobGradeList();

            $this->EBExam = $service->getEBExam($empNumber);

            $this->postArr['EditMode'] = 0;
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee EmpEbexam Controller
     */

    public function executeEmpEbexam(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {

            $employeeId = $_SESSION['PIM_EMPID'];
            $serviceId = $request->getParameter('cmbService');
            $gradeId = $request->getParameter('cmbGrade');


            if (!strlen($request->getParameter('lock'))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }


            $ebExamDao = new EbExamDao();
            $this->userCulture = $this->getUser()->getCulture();

            $jobService = new JobService();
            $this->gradeList = $jobService->getJobGradeList();
            $this->serviceList = $jobService->getEmpServiceList();


            //get Service List
            $this->serviceList = $jobService->getEmpServiceList();

            //get the grade list
            $this->gradeList = $jobService->getJobGradeList();






            $this->serviceId = $serviceId;
            $this->gradeId = $gradeId;

            $this->EBExamList = $ebExamDao->getEBExamByIds($serviceId, $gradeId);


            if ($request->isMethod('post')) {
                try {

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


                    $conn = Doctrine_Manager::getInstance()->connection();
                    $conn->beginTransaction();
                    for ($i = 0; $i < count($uniqueRowIds); $i++) {

                        $empEbEXamExit = $ebExamDao->readEmpEbexam($uniqueRowIds[$i], $employeeId);
                        if ($empEbEXamExit) {
                            $empEbexam = $empEbEXamExit;
                        } else {
                            $empEbexam = new EMPEBExam();
                        }

                        $v = "a_" . $uniqueRowIds[$i];


                        $empEbexam->setEbexam_id($uniqueRowIds[$i]);
                        $empEbexam->setEmployee_id($employeeId);
                        if (${$v}[dueDate] != "") {
                            $empEbexam->setEmp_ebexam_duedate(LocaleUtil::getInstance()->convertToStandardDateFormat(${$v}[dueDate]));
                        } else {
                            $empEbexam->setEmp_ebexam_duedate(null);
                        }
                        if (${$v}[completedDate] != "") {
                            $empEbexam->setEmp_ebexam_completedate(LocaleUtil::getInstance()->convertToStandardDateFormat(${$v}[completedDate]));
                        } else {
                            $empEbexam->setEmp_ebexam_completedate(null);
                        }

                        $empEbexam->setEmp_ebexam_status(${$v}[cmbStatus]);
                        $empEbexam->setEmp_ebexam_remarks(${$v}[remarks]);
                        $empEbexam->setEmp_ebexam_genaralcomment($_POST['txtEbexamComment']);




                        $issaved = $ebExamDao->saveEmpEbexams($empEbexam);
                    }
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_hr_emp_ebexam', array($serviceId, $gradeId), 1);
                    $conn->commit();
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                    $this->redirect('pim/empEbexam?gradeId=' . $_POST['cmbGrade'] . '&serviceId=' . $_POST['cmbService']);
                } catch (sfException $sf) {
                    
                } catch (Doctrine_Connection_Exception $e) {
                    $conn->rollBack();
                    $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                    $this->setMessage('WARNING', $errMsg->display());
                    $this->redirect('pim/empEbexam');
                } catch (Exception $e) {
                    $conn->rollBack();
                    $errMsg = new CommonException($e->getMessage(), $e->getCode());
                    $this->setMessage('WARNING', $errMsg->display());
                    $this->redirect('pim/empEbexam');
                }
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee Loads to the EbExam Grid
     */

    public function executeLoadEbExamGrid(sfWebRequest $request) {

        $ebExamDao = new EbExamDao();

        $serviceId = $request->getParameter('serviceId');
        $gradeId = $request->getParameter('gradeId');



        $ebExamsByServiceGrade = $ebExamDao->getAllEbExam($serviceId, $gradeId);
        foreach ($ebExamsByServiceGrade as $list) {
            $flag = 1;
            $this->i = $this->i + 1;
            $ebExamId = $list->ebexam_id;

            $ebExamIDArr[] = $ebExamId;
            $empEbExam = $ebExamDao->getEMPEbexamsByEmployee($ebExamId);
            //die($empEbExam[0]->emp_ebexam_status);
            if ($empEbExam[0]->emp_ebexam_status == 1) {
                $pass = "selected";
                $fail = "";
                $pending = "";
                $notIm = "";
            } elseif ($empEbExam[0]->emp_ebexam_status == 2) {
                $fail = "selected";
                $pass = "";
                $pending = "";
                $notIm = "";
            } elseif ($empEbExam[0]->emp_ebexam_status == 3) {
                $pending = "selected";
                $pass = "";
                $fail = "";
                $notIm = "";
            } elseif ($empEbExam[0]->emp_ebexam_status == 0) {
                $pending = "";
                $pass = "";
                $fail = "";
                $notIm = "selected";
            }

            if ($flag == 1) {
                $statusCmb = "";
                $statusCmb.="<select style='width:50px;' name='cmbStatus_" . $list->ebexam_id . "' value=" . $list->ebexam_name . ">";
                $statusCmb.="<option value='0' {$notIm}>" . $this->getContext()->getI18N()->__('---', $args, 'messages') . "</option>";
                $statusCmb.="<option value='1' {$pass}>" . $this->getContext()->getI18N()->__('Pass', $args, 'messages') . "</option>";
                $statusCmb.="<option value='2' {$fail}>" . $this->getContext()->getI18N()->__('Fail', $args, 'messages') . "</option>";
                $statusCmb.="<option value='3' {$pending}>" . $this->getContext()->getI18N()->__('Pending', $args, 'messages') . "</option>";
                $statusCmb.="</select>";
            } else {
                $statusCmb = "";
                $statusCmb.="<select style='width:50px;' name='cmbStatus_" . $list->ebexam_id . "' value=" . $list->ebexam_name . ">";
                $statusCmb.="<option value='0'>{$this->getContext()->getI18N()->__('---', $args, 'messages')}</option>";
                $statusCmb.="<option value='1'>{$this->getContext()->getI18N()->__('Pass', $args, 'messages')}</option>";
                $statusCmb.="<option value='2'>{$this->getContext()->getI18N()->__('Fail', $args, 'messages')}</option>";
                $statusCmb.="<option value='3'>{$this->getContext()->getI18N()->__('Pending', $args, 'messages')}</option>";
                $statusCmb.="</select>";
            }
            $this->childDiv.="<div id='row_" . $this->i . "' style='padding-top:5px; width:100%; display:inline-block;'>";

            $this->childDiv.="<div class='centerCol' id='master' style='width:20px; padding-left:3px;'>";
            $this->childDiv.="<input type='checkbox' class='innerchkBox' style='height:16px; margin: 0px;' name='chkEmbId[]' id='chkEmbId' value='" . $list->ebexam_id . "'/>";
            $this->childDiv.="</div>";
            $this->childDiv.="<div class='centerCol' id='master' style='width:150px;'>";
            $this->childDiv.="<div id='child'  padding-left:3px;'>" . $list->ebexam_name . " </div>";
            $this->childDiv.="</div>";
            if ($flag == 1) {
                $dueDate = LocaleUtil::getInstance()->formatDate($empEbExam[0]->emp_ebexam_duedate);
            } else {
                $dueDate = "";
            }
            $this->childDiv.="<div class='centerCol' id='master' style='width:125px;'>";
            $this->childDiv.="<div id='child'  padding-left:3px;'><input type='text' class='dateGrid' style='width:100px;' value='" . $dueDate . "' id='dueDate_" . $list->ebexam_id . "' name='dueDate_" . $list->ebexam_id . "'/></div>";
            $this->childDiv.="</div>";
            if ($flag == 1) {
                $completeDate = LocaleUtil::getInstance()->formatDate($empEbExam[0]->emp_ebexam_completedate);
            } else {
                $completeDate = "";
            }
            $this->childDiv.="<div class='centerCol' id='master' style='width:125px;'>";
            $this->childDiv.="<div id='child'   padding-left:10px;'><input type='text' class='dateGrid' style='width:100px;' value='" . $completeDate . "' id='completedDate_" . $list->ebexam_id . "' name='completedDate_" . $list->ebexam_id . "'  /></div>";
            $this->childDiv.="</div>";

            $this->childDiv.="<div class='centerCol' id='master' style='width:60px;'>";
            $this->childDiv.="<div id='child'>" . $statusCmb . " </div>";
            $this->childDiv.="</div>";

            if ($flag == 1) {
                $reMarks = $empEbExam[0]->emp_ebexam_remarks;
            } else {
                $reMarks = "";
            }
            $this->childDiv.="<div class='centerCol' id='master' style='width:100px;'>";
            $this->childDiv.="<div id='child'  padding-left:1px;'><input type='text' style='width:100px;' id='remarks_" . $list->ebexam_id . "' onkeypress='return onkeyUpevent(event)' onblur='return validationComment(event,this.id)' value='" . $reMarks . "' name='remarks_" . $list->ebexam_id . "' maxlength='200' /> </div>";
            $this->childDiv.="</div>";

            $this->childDiv.="</div>";
            $this->generalComment = $empEbExam[0]->emp_ebexam_genaralcomment;
        }




        $this->ebExamIDArr = $ebExamIDArr;
    }

    /*
     * Delete Employee from Ebexam controller
     */

    public function executeDeleteEmpEbExams(sfWebRequest $request) {

        if (count($request->getParameter('chkEmbId')) > 0) {
            $ebExamDao = new EbExamDao();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkEmbId');
                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_ebexam', array($ids[$i]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $ebExamDao->deleteEbExams($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_emp_ebexam', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {

                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/empEbexam');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/empEbexam');
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        echo json_encode($saveArr);
        die;
    }

    /*
     * Ebexam concurrency Handler lock table
     */

    public function executeLockEbExams(sfWebRequest $request) {


        $conHandler = new ConcurrencyHandler();

        $serviceId = $request->getParameter('serviceId');
        $gradeId = $request->getParameter('gradeId');
        $recordLocked = $conHandler->setTableLock('hs_hr_emp_ebexam', array($serviceId, $gradeId), 1);

        if ($recordLocked) {

            $tableLock = "1";
        } else {
            $tableLock = "0";
        }

        echo json_encode($tableLock);
        die;
    }

    /*
     * Ebexam concurrency Handler un lock table
     */

    public function executeResetEbExamLocks(sfWebRequest $request) {
        $serviceId = $request->getParameter('serviceId');
        $gradeId = $request->getParameter('gradeId');

        $conHandler = new ConcurrencyHandler();
        $recordLocked = $conHandler->resetTableLock('hs_hr_emp_ebexam', array($serviceId, $gradeId), 1);
        die($recordLocked);
    }

    /*
     * employee Attachments handling Controller
     */

    public function executeAttachment(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();

            $service = new EmployeeService();
            $empNumber = $_SESSION['PIM_EMPID'];
            $this->employee = $service->getEmployee($empNumber);
            // attachments
            $this->attachmentList = $service->getAttachmentList($empNumber);

            //attachment type
            $this->attachmentTypeList = $service->getAttachmentTypeList();

            $this->postArr['EditMode'] = 0;
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * employee Photo display Controller
     */

    public function executeViewPhoto(sfWebRequest $request) {
        $encrypt = new EncryptionHandler();


        $empNumber = $encrypt->decrypt($request->getParameter('id'));

        $employeeService = new EmployeeService();
        $empPicture = $employeeService->getPicture($empNumber);

        if (!empty($empPicture)) {
            $contents = $empPicture->picture;
            $contentType = $empPicture->file_type;
            $fileSize = $empPicture->size;
            $fileName = $empPicture->filename;
        } else {
            $fileName = 'default_employee_image.gif';
            $tmpName = ROOT_PATH . '/themes/beyondT/pictures/' . $fileName;
            $fp = fopen($tmpName, 'r');
            $fileSize = filesize($tmpName);
            $contents = fread($fp, $fileSize);
            $contentType = "image/gif";
            fclose($fp);
        }

        $response = $this->getResponse();

        $response->addCacheControlHttpHeader('no-cache');
        $response->setContentType($contentType);
        $response->setContent($contents);
        $response->send();



        die;
    }

    /**
     * Delete employee skills
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeletePhoto(sfWebRequest $request) {



        $empId = $_SESSION['PIM_EMPID'];
        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }
        if ($request->isMethod('post')) {

            $service = new EmployeeService();
            $service->deletePhoto($empId);
            $conHandler = new ConcurrencyHandler();
            $conHandler->resetTableLock('hs_hr_emp_picture', array($empId), 1);

            $this->redirect('pim/photoGraph');
        }
    }

    /**
     * Set's the current page number in the user session.
     * @param $page int Page Number
     * @return None
     */
    protected function setPage($page) {
        $this->getUser()->setAttribute('emplist.page', $page, 'pim_module');
    }

    /**
     * Get the current page number from the user session.
     * @return int Page number
     */
    protected function getPage() {
        return $this->getUser()->getAttribute('emplist.page', 1, 'pim_module');
    }

    /**
     *
     * @param array $filters
     * @return unknown_type
     */
    protected function setFilters(array $filters) {
        return $this->getUser()->setAttribute('emplist.filters', $filters, 'pim_module');
    }

    /**
     *
     * @return unknown_type
     */
    protected function getFilters() {
        return $this->getUser()->getAttribute('emplist.filters', null, 'pim_module');
    }

    /**
     * List Language
     * @param sfWebRequest $request
     * @return unknown_type
     */
    public function executeSearchEmployee(sfWebRequest $request) {
        try {

            $this->userCulture = $this->getUser()->getCulture();
            $employeeService = new EmployeeService();

            $this->type = $request->getParameter('type', isset($_SESSION["type"]) ? $_SESSION["type"] : 'single');
            $this->method = $request->getParameter('method', isset($_SESSION["method"]) ? $_SESSION["method"] : '');

            $reason = $request->getParameter('reason');
            $empdef = $request->getParameter('empdef');
            $samediv = $request->getParameter('samediv');
            if (strlen($empdef)) {
                $this->empdef = $empdef;
            } else {
                $this->empdef = '';
            }

            if (strlen($reason)) {
                $this->reason = $reason;
            } else {
                $this->reason = '';
            }
            if (strlen($samediv)) {
                $this->samediv = $samediv;
            } else {
                $this->samediv = '';
            }

            $att = $request->getParameter('att');
            if (strlen($att)) {
                $this->att = $att;
            } else {
                $this->att = '';
            }
            $selectall= $employeeService->getSelectAll();
            $i=0;
            foreach($selectall as $row){
                if($i==0){
                 $this->SelectAllEmp.=$row['empNumber'];
                }else{
                 $this->SelectAllEmp.="|".$row['empNumber'];   
                }
                $i++;
            }
            //die(print_r($this->SelectAllEmp));
            //payroll
            $payroll = $request->getParameter('payroll');
            if (strlen($payroll)) {
                $this->payroll = $payroll;
            } else {
                $this->payroll = '';
            }
//            $this->today =  $today = date("Y-m-d");
//            die(print_r($this->today));
            $this->startDate = ($request->getParameter('startDate') == '') ? '' : $request->getParameter('startDate');
            $this->endDate = ($request->getParameter('endDate') == '') ? '' :  $request->getParameter('endDate');;
            $this->processType = ($request->getParameter('processType') == '') ? '' : $request->getParameter('processType');

            //Store in session to support sorting
            $_SESSION["type"] = $this->type;
            $_SESSION["method"] = $this->method;
            //$_SESSION["payroll"] = $this->payroll;

            $this->payroll = ($request->getParameter('payroll') == '') ? $_SESSION["payroll"] : $request->getParameter('payroll');
            $this->payRolltype = ($request->getParameter('payrollType') == '') ? '' : $request->getParameter('payrollType');
            $this->locationWise = ($request->getParameter('locationWise') == '') ? '' : $request->getParameter('locationWise');
            $this->sorter = new ListSorter('propoerty.sort', 'pim_module', $this->getUser(), array('emp_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));
            $this->empdef = ($request->getParameter('empdef') == '') ? $_SESSION["empdef"] : $request->getParameter('empdef');
            $this->samediv = ($request->getParameter('samediv') == '') ? $_SESSION["samediv"] : $request->getParameter('samediv');

            $this->searchMode = ($request->getParameter('cmbSearchMode') == '') ? 'all' : $request->getParameter('cmbSearchMode');
            $this->searchValue = ($request->getParameter('txtSearchValue') == '') ? '' : $request->getParameter('txtSearchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $result = $employeeService->searchEmployee($this->searchMode, $this->searchValue, $this->userCulture, $request->getParameter('page'), $this->sort, $this->order, $this->type, $this->method, $this->reason, $this->att, $this->payroll, $this->payRolltype, $this->locationWise, $this->startDate, $this->endDate, $this->empdef,$this->samediv);

            $this->listEmployee = $result['data'];
            $this->pglay = $result['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (sfStopException $sf) {
            $this->redirect('pim/searchEmployee');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/searchEmployee');
        }
    }

    /**
     * Get employee personal data by ID
     */
    public function executeGetPersonalDetailsById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber');

            $service = new EmployeeService();
            $result = $service->getPersonalDetailsById($empNumber);

            $result[0]['emp_birthday'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_birthday']);
            $result[0]['emp_married_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_married_date']);
            $result[0]['emp_nic_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_nic_date']);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    //Get employee Attachment details

    public function executeAttachmentDetails(sfWebRequest $request) {

        try {
            $attachId = $request->getParameter('attachId', false);
            $empNumber = $request->getParameter('empNumber', false);

            $service = new EmployeeService();
            $result = $service->getAttachmentDetails($attachId, $empNumber);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Get employee Job and salary data by ID
     */
    public function executeGetJobSalDetailsById(sfWebRequest $request) {

        try {
            $culture = $this->getUser()->getCulture();
            $empNumber = $request->getParameter('empNumber', false);

            $service = new EmployeeService();
            $empDao = new EmployeeDao();
            $result = $service->getJobSalDetailsById($empNumber);
            $workStation = $empDao->getworkStationName($empNumber);
            if ($culture == "en") {
                $name = "getTitle";
            } else {
                $name = "getTitle_" . $culture;
            }
            if ($workStation[0]->subDivision->$name() == "") {
                $workStationName = $workStation[0]->subDivision->getTitle();
            } else {
                $workStationName = $workStation[0]->subDivision->$name();
            }
            $result[0]['emp_public_app_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_public_app_date']);
            $result[0]['emp_public_com_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_public_com_date']);
            $result[0]['emp_app_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_app_date']);
            $result[0]['emp_com_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_com_date']);
            $result[0]['emp_confirm_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_confirm_date']);
            $result[0]['emp_prob_from_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_prob_from_date']);
            $result[0]['emp_prob_to_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_prob_to_date']);
            $result[0]['emp_salary_inc_date'] = LocaleUtil::getInstance()->formatDate($result[0]['emp_salary_inc_date']);
            $result[0]['terminated_date'] = LocaleUtil::getInstance()->formatDate($result[0]['terminated_date']);
            $result[0]['workstaion_name'] = $workStationName;

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee personal data record
     */
    public function executeLockPersonalDetails(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_employee', array($empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock lockreportTo data record
     */
    public function executeLockreportTo(sfWebRequest $request) {

        try {
            $Sup_empNumber = $request->getParameter('Sup_empNumber', false);
            $Sub_empNumber = $request->getParameter('Sub_empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_reportto', array($Sup_empNumber, $Sub_empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    public function executeLockAttahment(sfWebRequest $request) {

        try {
            $attachId = $request->getParameter('attachId', false);
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_attachment', array($attachId, $empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    public function executeLockEbexam(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $ebExamNo = $request->getParameter('ebExamNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_ebexam', array($empNumber, $ebExamNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    public function executeUnlockEbexam(sfWebRequest $request) {


        try {
            $empNumber = $request->getParameter('empNumber', false);
            $ebExamNo = $request->getParameter('ebExamNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_ebexam', array($empNumber, $ebExamNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    public function executeUnlockAttachment(sfWebRequest $request) {


        try {
            $attachId = $request->getParameter('attachId', false);
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_attachment', array($attachId, $empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee JobSal data record
     */
    public function executeLockJobSalDetails(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_employee', array($empNumber), 5);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee Photo  record
     */
    public function executeLockPhoto(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_picture', array($empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * unLock employee Photo  record
     */
    public function executeUnlockPhoto(sfWebRequest $request) {


        try {
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_picture', array($empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee personal data record
     */
    public function executeUnLockJobSalDetails(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_employee', array($empNumber), 5);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee personal data record
     */
    public function executeUnlockPersonalDetails(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_employee', array($empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    public function executeUnlockReportTo(sfWebRequest $request) {
        try {
            $Sup_empNumber = $request->getParameter('Sup_empNumber', false);
            $Sub_empNumber = $request->getParameter('Sub_empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_reportto', array($Sup_empNumber, $Sub_empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Get employee contact data by ID
     */
    public function executeIsSalNoExist(sfWebRequest $request) {

        $salNo = $request->getParameter('salNo', false);
        $mode = $request->getParameter('mode');
        $empNumber = $_SESSION['PIM_EMPID'];
        $service = new EmployeeService();
        $result = $service->IsSalExist(trim($salNo), trim($empNumber), $mode);

        echo json_encode($result[0]);
        die;
    }

    /*
     * Pension number validation controller
     */

    public function executeIsPensionNoExists(sfWebRequest $request) {


        $pensionNo = $request->getParameter('pensionNo', false);
        $mode = $request->getParameter('mode');
        $empNumber = $_SESSION['PIM_EMPID'];

        $service = new EmployeeService();
        $result = $service->IsPensionExist(trim($pensionNo), trim($empNumber), $mode);

        echo json_encode($result[0]);
        die;
    }

    /*
     * Appointment letter validation controller
     */

    public function executeIsAppLetterExists(sfWebRequest $request) {


        $appLetNo = $request->getParameter('ApplettNo', false);
        $mode = $request->getParameter('mode');
        $empNumber = $_SESSION['PIM_EMPID'];

        $service = new EmployeeService();
        $result = $service->IsAppLetterExists(trim($appLetNo), trim($empNumber), $mode);

        echo json_encode($result[0]);
        die;
    }

    /*
     * Employee Id duplicaiton validation controller
     */

    public function executeIsEmpIdExists(sfWebRequest $request) {


        $empId = $request->getParameter('EmployeeId');
        $mode = $request->getParameter('mode');
        $empNumber = $_SESSION['PIM_EMPID'];

        $service = new EmployeeService();
        $result = $service->IsEmpIdExists(trim($empId), trim($empNumber), $mode);

        echo json_encode($result[0]);
        die;
    }

    /*
     * Fectch the employee Contact details by ID
     */

    public function executeGetContactDetailsById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $service = new EmployeeService();
            $result = $service->getContactDetailsById($empNumber);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    public function executeReportDetailsbyEmpId(sfWebRequest $request) {

        try {
            $Sup_empNumber = $request->getParameter('Sup_empNumber', false);
            $Sub_empNumber = $request->getParameter('Sub_empNumber', false);

            $service = new EmployeeService();
            $result = $service->getReportDetailsbyEmpId($Sup_empNumber, $Sub_empNumber);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /*
     * Fectch the employee Photo Details
     */

    public function executePhotoDetails(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $service = new EmployeeService();
            $result = $service->getPhotoDetails($empNumber);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee contact data record
     */
    public function executeLockContactDetails(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_contact', array($empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee contact data record
     */
    public function executeUnlockContactDetails(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_contact', array($empNumber), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /* getAttachment Details */

    public function executeGetAttachmentDetails(sfWebRequest $request) {

        try {
            $attachId = $request->getParameter('attachId', false);
            $empNumber = $request->getParameter('empNumber', false);

            $service = new EmployeeService();
            $attachDetails = $service->getAttachmentDetails($attachId, $empNumber);


            echo json_encode(array('attachDetails' => $attachDetails[0]));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Get employee emergency contacts by ID
     */
    public function executeGetEmergencyContactById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $service = new EmployeeService();
            $result = $service->getEmergencyContactById($empNumber, $seqNo);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee emergency contact record
     */
    public function executeLockEmergencyContact(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_emergency_contacts', array($empNumber, $seqNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee emergency contact record
     */
    public function executeUnlockEmergencyContact(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_emergency_contacts', array($empNumber, $seqNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Delete employee emergencyContacts
     * @param int $empNumber Employee number
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteEmergencyContacts(sfWebRequest $request) {




        $empId = $request->getParameter('empNumber');


        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $contactstoDelete = $request->getParameter('chkID', array());
        if ($contactstoDelete) {
            $service = new EmployeeService();

            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($contactstoDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_emergency_contacts', array($empId, $contactstoDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $contactstoDelete[$i];
                    } else {
                        $saveArr = $contactstoDelete[$i];
                        $service->deleteEmergencyContacts($empId, $contactstoDelete[$i]);

                        $conHandler->resetTableLock('hs_hr_emp_emergency_contacts', array($empId, $contactstoDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/emeregencyContacts');
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
        $this->redirect('pim/emeregencyContacts');
    }

    /**
     * Add / update employee emergencyContact
     * @param int $empNumber Employee number
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateEmergencyContact(sfWebRequest $request) {

        try {
            // TODO: Set ESS mode, enable csrf protection
            $this->form = new EmployeeEmergencyContactForm(array(), array(), false);
            $empNumber = $request->getParameter('empNumber');
            $seqNo = $request->getParameter('txtECSeqNo');

            if ($this->getRequest()->isMethod('post')) {
                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    $service = new EmployeeService();
                    $service->saveEmergencyContact($this->form->getEmergencyContact($empNumber, $seqNo));
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }

            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $this->redirect('pim/emeregencyContacts');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/viewEmployee?empNumber=' . $empNumber . '&pane=' . self::EMG_CONTACTS_PANE);
        }die;
    }

    /**
     * Get employee dependent contacts by ID
     */
    public function executeGetDependentContactById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $service = new EmployeeService();
            $result = $service->getDependentContactById($empNumber, $seqNo);

            if (count($result) > 0) {
                $result[0]['birthday'] = LocaleUtil::getInstance()->formatDate($result[0]['birthday']);
            }


            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee dependent contact record
     */
    public function executeLockDependentContact(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_dependents', array($empNumber, $seqNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee dependent contact record
     */
    public function executeUnlockDependentContact(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_dependents', array($empNumber, $seqNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Delete employee dependents
     * @param int $empNumber Employee number
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteDependents(sfWebRequest $request) {




        $empId = $request->getParameter('empNumber');


        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $DependentstoDelete = $request->getParameter('chkID', array());
        if ($DependentstoDelete) {
            $service = new EmployeeService();

            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($DependentstoDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_dependents', array($empId, $DependentstoDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $DependentstoDelete[$i];
                    } else {
                        $saveArr = $DependentstoDelete[$i];

                        $service->deleteDependentContacts($empId, $DependentstoDelete[$i]);
                        $conHandler->resetTableLock('hs_hr_emp_dependents', array($empId, $DependentstoDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/dependents');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/dependents');
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
        $this->redirect('pim/dependents');
    }

    /**
     * Add / update employee dependent
     * @param int $empNumber Employee number
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateDependent(sfWebRequest $request) {
        try {
            // TODO: Set ESS mode, enable csrf protection
            $this->form = new EmployeeDependentForm(array(), array(), false);
            $empNumber = $request->getParameter('empNumber');
            $seqNo = $request->getParameter('txtDepSeqNo');

            if ($this->getRequest()->isMethod('post')) {
                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    $service = new EmployeeService();
                    $service->saveDependentContact($this->form->getDependentContact($empNumber, $seqNo));
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }

            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $this->redirect('pim/dependents');
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/dependents');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/dependents');
        }die;
    }

    /**
     * Get employee languages by ID
     */
    public function executeGetEmpLanguageById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $langCode = $request->getParameter('langCode', false);
            $langType = $request->getParameter('langType', false);

            $service = new EmployeeService();
            $result = $service->getEmpLanguageById($empNumber, $langCode, $langType);
            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee language record
     */
    public function executeLockEmpLanguage(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $langCode = $request->getParameter('langCode', false);
            $langType = $request->getParameter('langType', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_language', array($empNumber, $langCode."|".$langType), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee language record
     */
    public function executeUnlockEmpLanguage(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $langCode = $request->getParameter('langCode', false);
            $langType = $request->getParameter('langType', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_language', array($empNumber, $langCode."|".$langType), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Delete employee language
     * @param int $empNumber Employee number
     */
    public function executeDeleteLanguages(sfWebRequest $request) {





        $empId = $request->getParameter('empNumber');


        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $deleteElements = $request->getParameter('chkID', array());
        $languagesToDelete = array();

        foreach ($deleteElements as $lang) {
            $parts = explode('|', $lang);
            if (count($parts) == 2) {
                $languagesToDelete[] = array('code' => $parts[0], 'type' => $parts[1]);
            }
        }




        try {
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();


            $countArr = array();
            $saveArr = array();



            foreach ($languagesToDelete as $lang) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->isTableLocked('hs_hr_emp_language', array($empId, $lang['code'], $lang['type']), 1);

                if ($recordLocked) {
                    $countArr = $lang['code'];
                } else {
                    $saveArr = $lang['code'];

                    $empDao = new EmployeeDao();
                    $empDao->deleteEmpLanguages($empId, $lang['code'], $lang['type']);
                    $conHandler->resetTableLock('hs_hr_emp_language', array($empId, $lang['code'], $lang['type']), 1);
                }
            }
            $conn->commit();
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/language');
        } catch (Exception $e) {
            $conn->rollBack();
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/language');
        }
        if (count($saveArr) > 0 && count($countArr) == 0) {
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
        } elseif (count($saveArr) > 0 && count($countArr) > 0) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
        } elseif (count($saveArr) == 0 && count($countArr) > 0) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
        }

        $this->redirect('pim/language');
    }

    /**
     * Add / update employee language
     * @param int $empNumber Employee number
     */
    public function executeUpdateLanguage(sfWebRequest $request) {
        try {
            // TODO: Set ESS mode, enable csrf protection
            $this->form = new EmployeeLanguageForm(array(), array(), false);
            $empNumber = $request->getParameter('empNumber');

            $langCode = $request->getParameter('cmbLanName');
            $langType = $request->getParameter('cmbLanFluency');


            if ($this->getRequest()->isMethod('post')) {
                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    $service = new EmployeeService();
                    $service->saveEmpLanguage($this->form->getEmpLanguage($empNumber, $langCode, $langType));
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }

            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $this->redirect('pim/language');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/language');
        }die;
    }

    public function executeAjaxLanguageData(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->empNumber = $_SESSION['PIM_EMPID'];
        }

        $EmployeeDao = new EmployeeDao();
        $this->LanguagesData = $EmployeeDao->getEmpLanguage($this->empNumber);

        echo json_encode($this->LanguagesData);
        die;
    }

    public function executeSaveLanguages(sfWebRequest $request) {
        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->userCulture = $this->getUser()->getCulture();
            $EmployeeDao = new EmployeeDao();
            $this->empNumber = $_SESSION['PIM_EMPID'];
            $this->LanguagesList = $EmployeeDao->getLanguages();
            //$this->LanguagesData=$EmployeeDao->getEmpLanguage($this->empNumber);
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }

        $encrypt = new EncryptionHandler();
        if (!strlen($encrypt->decrypt($request->getParameter('lock')))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $encrypt->decrypt($request->getParameter('lock'));
        }
        //$transPid = $encrypt->decrypt($request->getParameter('empNumber'));
        $transPid = $this->empNumber;
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_emp_language', array($transPid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {

                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $conHandler->resetTableLock('hs_hr_emp_language', array($transPid), 1);
                $this->lockMode = 0;
            }
        }



        if ($this->getRequest()->isMethod('post')) { //die(print_r($_POST));
            foreach ($this->LanguagesList as $row) {
                for ($i = 1; $i <= 3; $i++) {
                    if ($_POST[$row->lang_code . '_cmbLanCompetency' . $i] != null) {
                        $EmployeeLanguage = $EmployeeDao->getEmpLanguageType($this->empNumber, $row->lang_code, $i);

                        if ($EmployeeLanguage->emplang_competency != null) {
                            $EmployeeLanguage->setEmplang_competency($_POST[$row->lang_code . '_cmbLanCompetency' . $i]);
                            try {
                                $EmployeeDao->saveEmpLanguage($EmployeeLanguage);
                            } catch (Doctrine_Connection_Exception $e) {
                                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                                $this->setMessage('WARNING', $errMsg->display());
                                $this->redirect('pim/SaveLanguages?empNumber=' . $encrypt->encrypt($this->empNumber) . '&lock=' . 0);
                            } catch (Exception $e) {
                                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                                $this->setMessage('WARNING', $errMsg->display());
                                $this->redirect('pim/SaveLanguages?empNumber=' . $encrypt->encrypt($this->empNumber) . '&lock=' . 0);
                            }
                        } else {
                            $EmployeeLanguage = new EmployeeLanguage();
                            $EmployeeLanguage->setEmp_number($this->empNumber);
                            $EmployeeLanguage->setLang_code($row->lang_code);
                            $EmployeeLanguage->setEmplang_type($i);
                            $EmployeeLanguage->setEmplang_competency($_POST[$row->lang_code . '_cmbLanCompetency' . $i]);

                            try {
                                $EmployeeDao->saveEmpLanguage($EmployeeLanguage);
                            } catch (Doctrine_Connection_Exception $e) {
                                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                                $this->setMessage('WARNING', $errMsg->display());
                                $this->redirect('pim/SaveLanguages?empNumber=' . $encrypt->encrypt($this->empNumber) . '&lock=' . $encrypt->encrypt(0));
                            } catch (Exception $e) {
                                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                                $this->setMessage('WARNING', $errMsg->display());
                                $this->redirect('pim/SaveLanguages?empNumber=' . $encrypt->encrypt($this->empNumber) . '&lock=' . $encrypt->encrypt(0));
                            }
                        }
                    }
                }
            }

            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('pim/SaveLanguages?empNumber=' . $encrypt->encrypt($this->empNumber) . '&lock=' . $encrypt->encrypt(0));
        }
    }

    /**
     * Get employee work experience by ID
     */
    public function executeGetWorkExperienceById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $service = new EmployeeService();
            $result = $service->getWorkExperienceById($empNumber, $seqNo);

            $result[0]['eexp_from_date'] = LocaleUtil::getInstance()->formatDate($result[0]['eexp_from_date']);
            $result[0]['eexp_to_date'] = LocaleUtil::getInstance()->formatDate($result[0]['eexp_to_date']);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Get EBexam Details by Id
     */
    public function executeGetEbExams(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $ebExamNo = $request->getParameter('ebExamNo', false);

            $service = new EmployeeService();
            $result = $service->getEBexamById($empNumber, $ebExamNo);
            if ($result) {
                $result[0]['ebexam_date'] = LocaleUtil::getInstance()->formatDate($result[0]['ebexam_date']);
            }

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee work experience record
     */
    public function executeLockWorkExperience(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_work_experience', array($empNumber, $seqNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee work experience record
     */
    public function executeUnlockWorkExperience(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_work_experience', array($empNumber, $seqNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Delete employee work experience
     * @param int $empNumber Employee number
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteWorkExperience(sfWebRequest $request) {
        try {
            $empNumber = $request->getParameter('empNumber', false);

            if (count($request->getParameter('chkID')) > 0) {
                $service = new EmployeeService();
                $service->deleteWorkExperience($empNumber, $request->getParameter('chkID'));
                $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Deleted')));
            } else {
                $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Select at least one record to delete')));
            }
            $this->redirect('pim/workexperience');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/viewEmployee?empNumber=' . $empNumber . '&pane=' . self::WORK_EXPERIENCE_PANE);
        }
    }

    /**
     * Add / update employee work experience
     * @param int $empNumber Employee number
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateWorkExperience(sfWebRequest $request) {
        try {
            // TODO: Set ESS mode, enable csrf protection
            $this->form = new EmployeeWorkExperienceForm(array(), array(), false);
            $empNumber = $request->getParameter('empNumber');
            $seqNo = $request->getParameter('txtExpSeqNo');

            if ($this->getRequest()->isMethod('post')) {
                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    $service = new EmployeeService();

                    $service->saveWorkExperience($this->form->getWorkExperience($empNumber, $seqNo));
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }

            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $this->redirect('pim/workexperience');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/workexperience');
        }
    }

    /**
     * Get employee skill by ID
     */
    public function executeGetSkillById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $skillCode = $request->getParameter('skillCode', false);

            $service = new EmployeeService();
            $result = $service->getSkillById($empNumber, $skillCode);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee skill record
     */
    public function executeLockSkill(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $skillCode = $request->getParameter('skillCode', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_skill', array($empNumber, $skillCode), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee skill record
     */
    public function executeUnlockSkill(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $skillCode = $request->getParameter('skillCode', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_skill', array($empNumber, $skillCode), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    public function executeReportTomethodSup(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $SupempNumber = $request->getParameter('SupempNumber', false);

            $empDao = new EmployeeDao();
            $isValidSup = $empDao->checkValidSupervicer($empNumber, $SupempNumber);
            echo json_encode(array('isValidSup' => $isValidSup[0]['count']));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    public function executeReportTomethodSub(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $SubempNumber = $request->getParameter('SubempNumber', false);

            $empDao = new EmployeeDao();
            $isValidSup = $empDao->checkValidSubordinater($empNumber, $SubempNumber);
            echo json_encode(array('isValidSub' => $isValidSup[0]['count']));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Delete employee skill
     * @param int $empNumber Employee number
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteSkill(sfWebRequest $request) {




        $empId = $request->getParameter('empNumber', false);

        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $skillsToDelete = $request->getParameter('chkID', array());

        if ($skillsToDelete) {


            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($skillsToDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_skill', array($empId, $skillsToDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $skillsToDelete[$i];
                    } else {
                        $saveArr = $skillsToDelete[$i];
                        $empDao = new EmployeeDao();
                        $empDao->deleteSkill($empId, $skillsToDelete[$i]);
                        $conHandler->resetTableLock('hs_hr_emp_skill', array($empId, $examsToDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/skills');
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
        $this->redirect('pim/skills');
    }

    /**
     * Add / update employee skill
     * @param int $empNumber Employee number
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateSkill(sfWebRequest $request) {
        try {
            // TODO: Set ESS mode, enable csrf protection
            $this->form = new EmployeeSkillForm(array(), array(), false);
            $empNumber = $request->getParameter('empNumber');
            $skillCode = $request->getParameter('txtSkillCode');

            if ($this->getRequest()->isMethod('post')) {
                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    $service = new EmployeeService();
                    $service->saveSkill($this->form->getSkill($empNumber, $skillCode));
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }

            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $this->redirect('pim/skills');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/skills');
        }
    }

    /**
     * Get employee education by ID
     */
    public function executeGetEducationById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $eduCode = $request->getParameter('eduCode', false);

            $service = new EmployeeService();
            $result = $service->getEducationById($empNumber, $eduCode);

            $result[0]['edu_start_date'] = LocaleUtil::getInstance()->formatDate($result[0]['edu_start_date']);
            $result[0]['edu_end_date'] = LocaleUtil::getInstance()->formatDate($result[0]['edu_end_date']);

            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Get Service Record By ID
     */
    public function executeGetServiceRecordbyID(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $SerRecNo = $request->getParameter('SerRecNo', false);

            $service = new EmployeeService();
            $result = $service->getServiceRecordByID($empNumber, $SerRecNo);
            if ($result) {
                $result[0]['esh_from_date'] = LocaleUtil::getInstance()->formatDate($result[0]['esh_from_date']);
                $result[0]['esh_to_date'] = LocaleUtil::getInstance()->formatDate($result[0]['esh_to_date']);
            }
            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock Service record
     */
    public function executeLockServiceRecord(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $ebExamNo = $request->getParameter('ebExamNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_service_history', array($empNumber, $ebExamNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * UnLock Service record
     */
    public function executeUnlockServiceRecord(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $ebExamNo = $request->getParameter('ebExamNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_service_history', array($empNumber, $ebExamNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee education record
     */
    public function executeLockEducation(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $eduCode = $request->getParameter('eduCode', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_education', array($empNumber, $eduCode), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee education record
     */
    public function executeUnlockEducation(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $eduCode = $request->getParameter('eduCode', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_education', array($empNumber, $eduCode), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Delete employee education
     * @param int $empNumber Employee number
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteEducation(sfWebRequest $request) {




        $empId = $request->getParameter('empNumber', false);

        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $EducationsToDelete = $request->getParameter('chkID', array());
        if ($EducationsToDelete) {

            $service = new EmployeeService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($EducationsToDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_education', array($empId, $EducationsToDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $EducationsToDelete[$i];
                    } else {
                        $saveArr = $EducationsToDelete[$i];
                        $service->deleteEducation($empId, $EducationsToDelete[$i]);

                        $conHandler->resetTableLock('hs_hr_emp_education', array($empId, $EducationsToDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/education');
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
        $this->redirect('pim/education');
    }

    /**
     * Add / update employee education
     * @param int $empNumber Employee number
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateEducation(sfWebRequest $request) {
        try {
            // TODO: Set ESS mode, enable csrf protection
            $this->form = new EmployeeEducationForm(array(), array(), false);
            $empNumber = $request->getParameter('empNumber');
            $eduCode = $request->getParameter('txtEduCode');

            if ($this->getRequest()->isMethod('post')) {
                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    $service = new EmployeeService();
                    $service->saveEducation($this->form->getEducation($empNumber, $eduCode));
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }

            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $this->redirect('pim/education');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/viewEmployee?empNumber=' . $empNumber . '&pane=' . self::EDUCATION_PANE);
        } die;
    }

    /**
     * Get employee license by ID
     */
    public function executeGetLicenseById(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $service = new EmployeeService();
            $result = $service->getLicenseById($empNumber, $seqNo);
            if ($result) {
                $result[0]['lic_issue_date'] = LocaleUtil::getInstance()->formatDate($result[0]['lic_issue_date']);
                $result[0]['lic_expiry_date'] = LocaleUtil::getInstance()->formatDate($result[0]['lic_expiry_date']);
            }
            echo json_encode($result[0]);
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Lock employee license record
     */
    public function executeLockLicense(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->setTableLock('hs_hr_emp_licenses', array($empNumber, $seqNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Unlock employee license record
     */
    public function executeUnlockLicense(sfWebRequest $request) {

        try {
            $empNumber = $request->getParameter('empNumber', false);
            $seqNo = $request->getParameter('seqNo', false);

            $conHandler = new ConcurrencyHandler();
            $recordLocked = $conHandler->resetTableLock('hs_hr_emp_licenses', array($empNumber, $seqNo), 1);

            echo json_encode(array('recordLocked' => $recordLocked));
            die;
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
        }
    }

    /**
     * Delete employee license
     * @param int $empNumber Employee number
     * @return boolean true if successfully deleted, false otherwise
     */
    public function executeDeleteLicense(sfWebRequest $request) {



        $empId = $request->getParameter('empNumber', false);

        if (!$empId) {
            throw new PIMServiceException("No Employee ID given");
        }

        $LicenseToDelete = $request->getParameter('chkID', array());
        if ($LicenseToDelete) {


            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($LicenseToDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_licenses', array($empId, $LicenseToDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $LicenseToDelete[$i];
                    } else {
                        $saveArr = $LicenseToDelete[$i];
                        $empDao = new EmployeeDao();

                        $empDao->deleteLicense($empId, $LicenseToDelete[$i]);
                        $conHandler->resetTableLock('hs_hr_emp_licenses', array($empId, $LicenseToDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/license');
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
        $this->redirect('pim/license');
    }

    /**
     * Add / update employee license
     * @param int $empNumber Employee number
     * @return boolean true if successfully assigned, false otherwise
     */
    public function executeUpdateLicense(sfWebRequest $request) {
        try {
            // TODO: Set ESS mode, enable csrf protection
            $this->form = new EmployeeLicenseForm(array(), array(), false);
            $empNumber = $request->getParameter('empNumber');
            $seqNo = $request->getParameter('txtLicSeqNo');

            if ($this->getRequest()->isMethod('post')) {
                // Handle the form submission
                $this->form->bind($request->getPostParameters());

                if ($this->form->isValid()) {
                    // validate either ADMIN, supervisor for employee or employee himself
                    $service = new EmployeeService();
                    $service->saveLicense($this->form->getLicense($empNumber, $seqNo));
                } else {
                    $this->getUser()->setFlash('errorForm', $this->form);
                }
            }

            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $this->redirect('pim/license');
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('pim/license');
        }
    }

    /*
     * Employee Discipinary Actions controller
     */

    public function executeDisciplinaryAction(sfWebRequest $request) {
        if (strlen($_SESSION['PIM_EMPID'])) {

            try {
                $this->userCulture = $this->getUser()->getCulture();


                $this->sorter = new ListSorter('propoerty.sort', 'pim_module', $this->getUser(), array('', ListSorter::ASCENDING));
                $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

                $this->searchMode = ($request->getParameter('cmbSearchMode') == '') ? 'all' : $request->getParameter('cmbSearchMode');
                $this->searchValue = ($request->getParameter('txtSearchValue') == '') ? '' : $request->getParameter('txtSearchValue');

                $this->sort = ($request->getParameter('sort') == '') ? 'emp_dis_id' : $request->getParameter('sort');
                $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

                $empDao = new EmployeeDao();
                $result = $empDao->searchEmpDisActions($this->searchMode, $this->searchValue, $this->userCulture, $request->getParameter('page'), $this->sort, $this->order);

                $this->listDisActions = $result['data'];
                $this->pglay = $result['pglay'];
                $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
                $this->pglay->setSelectedTemplate('{%page}');
                if (count($result['data']) <= 0) {
                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
                }
            } catch (sfStopException $sf) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee Discipinary Action save
     */

    public function executeSaveDisPlinaryaction(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {


            try {


                if (!strlen($request->getParameter('lock'))) {
                    $this->mode = 0;
                } else {
                    $this->mode = $request->getParameter('lock');
                }
                $ebLockid = $request->getParameter('disId');
                if (isset($this->mode)) {
                    if ($this->mode == 1) {

                        $conHandler = new ConcurrencyHandler();

                        $recordLocked = $conHandler->setTableLock('hs_hr_emp_disciaction', array($ebLockid), 1);

                        if ($recordLocked) {
                            // Display page in edit mode
                            $this->mode = 1;
                        } else {
                            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                            $this->mode = 0;
                        }
                    } else if ($this->mode == 0) {
                        $conHandler = new ConcurrencyHandler();
                        $recordLocked = $conHandler->resetTableLock('hs_hr_emp_disciaction', array($ebLockid), 1);
                        $this->mode = 0;
                    }
                }



                $this->userCulture = $this->getUser()->getCulture();
                $empDao = new EmployeeDao();


                $employee = $empDao->read($_SESSION['PIM_EMPID']);

                if ($this->userCulture == "en") {


                    $empName = 'emp_display_name';
                } else {
                    $feildName = 'emp_display_name_' . $this->userCulture;
                    if ($employee[0]->$feildName == "") {
                        $empName = 'emp_display_name';
                    } else {
                        $empName = 'emp_display_name_' . $this->userCulture;
                    }
                }
                $this->defaultEmpName = $employee[0]->$empName;



                $disId = $request->getParameter('disId');
                if (strlen($disId)) {
                    if (!strlen($this->mode)) {
                        $this->mode = 0;
                    }
                    $this->disAct = $empDao->readDisActions($disId);
                    if (!$this->disAct) {
                        $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                        $this->redirect('pim/disciplinaryAction');
                    }
                } else {
                    $this->mode = 1;
                }


                if ($request->isMethod('post')) {

                    $empId = $_SESSION['PIM_EMPID'];
                    if (strlen($request->getParameter('txtHiddenDisID'))) {

                        $disAction = $empDao->readDisActions($request->getParameter('txtHiddenDisID'));
                    } else {
                        $disAction = new EmpDisAction();
                    }

                    if (strlen($empId)) {
                        $disAction->setEmp_number(trim($empId));
                    } else {
                        $disAction->setEmp_number(null);
                    }
                    if (($request->getParameter('txtEfftFrom')) != null) {
                        $disAction->setEmp_dis_effectfrom(trim(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtEfftFrom'))));
                    } else {
                        $disAction->setEmp_dis_effectfrom(null);
                    }
                    if (($request->getParameter('txtEfftTo')) != null) {
                        $disAction->setEmp_dis_effectto(trim(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtEfftTo'))));
                    } else {
                        $disAction->setEmp_dis_effectto(null);
                    }
                    if (($request->getParameter('txtAction')) != null) {
                        $disAction->setEmp_dis_action(trim($request->getParameter('txtAction')));
                    } else {
                        $disAction->setEmp_dis_action(null);
                    }
                    if (($request->getParameter('txtComment')) != null) {
                        $disAction->setEmp_dis_comment(trim($request->getParameter('txtComment')));
                    } else {
                        $disAction->setEmp_dis_comment(null);
                    }



                    $disAction->save();
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                    $this->redirect('pim/disciplinaryAction');
                }
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/disciplinaryAction');
            } catch (sfStopException $sf) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/disciplinaryAction');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    public function executeDeleteDisAction(sfWebRequest $request) {





        $disActToDelete = $request->getParameter('chkID', array());
        if ($disActToDelete) {

            $empDao = new EmployeeDao();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($disActToDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_emp_disciaction', array($disActToDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $disActToDelete[$i];
                    } else {
                        $saveArr = $disActToDelete[$i];

                        $empDao->deleteEmpDisAction($disActToDelete[$i]);
                        $conHandler->resetTableLock(' hs_hr_emp_disciaction', array($disActToDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/disciplinaryAction');
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
        $this->redirect('pim/disciplinaryAction');
    }

    /*
     * Display employee hirache controller
     */

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

    /*
     * Load Grade slot controller
     */

    public function executeLoadGradeSlot(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();

        $jobDao = new JobDao();

        $id = $request->getParameter('id');
        $Slot = $jobDao->getGradeSlotByID($id);
        $arr = Array();
        foreach ($Slot as $row) {

            $arr[] = $row->grade_code . "|" . $row->slt_scale_year . "|" . $row->slt_amount . "|" . $row->emp_basic_salary . "|" . $row->slt_id;
        }

        echo json_encode($arr);
        die;
    }

    public function executeAjaxNIC(sfWebRequest $request) {

        $Birthday = $request->getParameter('Birthday');
        $Gender = $request->getParameter('Gender');

        if ($Birthday) {
            $Birthday = LocaleUtil::getInstance()->convertToStandardDateFormat($Birthday);
            $day = new DateTime($Birthday);
            $timeStamp = strtotime($day->format("Y-m-d")); //find Day
            $date = getdate($timeStamp);
            $date['year'];
            $date['yday'];
            $Leap = $this->isleapyear($date['year']);

            if ($Leap) {
                if ($date['month'] == 'January' || $date['month'] == 'February') {
                    $date['yday'] = $date['yday'] + 1;
                } else {
                    $date['yday'] = $date['yday'] + 1;
                }
            } else {
                if ($date['month'] == 'January' || $date['month'] == 'February') {
                    $date['yday'] = $date['yday'] + 1;
                } else {
                    $date['yday'] = $date['yday'] + 2;
                }
            }



            $Year = str_split($date['year']);
            $NIC = $Year[2] . $Year[3];
        }
        if ($Gender) {
            if ($Gender == "1") {
                $noofday = strlen($date['yday']);
                if ($noofday == 1) {
                    $Day = "00" . $date['yday'];
                } else if ($noofday == 2) {
                    $Day = "0" . $date['yday'];
                } else if ($noofday == 3) {
                    $Day = $date['yday'];
                }
                $NIC = $Year[2] . $Year[3] . $Day;
            } else if ($Gender == "2") {
                $Day = $date['yday'] + 500;
                $NIC = $Year[2] . $Year[3] . $Day;
            }
        }

        echo json_encode($NIC);
        die;
    }

    public function executeError(sfWebRequest $request) {

        $this->redirect('default/error');
    }

    public function isleapyear($year = '') {
        if (empty($year)) {
            $year = date('Y');
        }
        $year = (int) $year;
        if ($year % 4 == 0) {
            if ($year % 100 == 0) {
                return ($year % 400 == 0);
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function executeActingWorkStation(sfWebRequest $request) {
        $this->userCulture = $this->getUser()->getCulture();
        $this->EmpNumber = $request->getParameter('emp');
        $jobService = new JobService();
        $service = new EmployeeService();
        $companyService = new CompanyService();
        $this->employee = $service->getEmployee($this->EmpNumber);
        $empJob = $this->employee;
        $this->ActingCompanyStructureLoad = $companyService->readActingCompanyStructureLoad($empJob->empNumber);
        $this->ActjobTitleList = $jobService->getJobTitleList();


        if ($request->isMethod('post')) {
            //die(print_r($_POST));
            $ActWorkstaions = $request->getParameter('Actworkstaions');


            for ($j = 1; $j <= $ActWorkstaions; $j++) {

                $ActingWorkstaion = $companyService->readActingCompanyStructure($empJob->empNumber, $j);

                if (!$ActingWorkstaion) {
                    $ActingWorkstaion = new EmpActiveWorkstation();
                }

                for ($i = 1; $i <= 10; $i++) {
                    $Actcol = "act_hie_code_" . $i;
                    $ActingWorkstaion->$Actcol = null;
                }
                $ActingWorkstaion->setEmp_number($empJob->empNumber);
                $ActingWorkstaion->setAct_workstation_no($j);
                if ($_POST['cmbActDesignstion' . $j] != null) {
                    $ActingWorkstaion->setAct_job_title_code($_POST['cmbActDesignstion' . $j]);
                }
                if ($_POST['txtActDivisionid' . $j] != null) {
                    $ActingWorkstaion->setAct_work_satation($_POST['txtActDivisionid' . $j]);
                }

                if ($_POST['txtActDivisionid' . $j] != null) {
                    $ActhieCode = $_POST['txtActDivisionid' . $j];

                    $Actdivision = $companyService->readCompanyStructure($ActhieCode);
                    $ActdefLevel = $Actdivision->getDefLevel();
                    while ($ActdefLevel > 0 && $ActhieCode > 0) {
                        $ActhieCodeCol = "act_hie_code_" . $ActdefLevel;
                        $ActingWorkstaion->$ActhieCodeCol = $ActhieCode;

                        $ActhieCode = $Actdivision->getParnt();
                        $Actdivision = $companyService->readCompanyStructure($ActhieCode);

                        $ActdefLevel = $ActdefLevel - 1;
                    }
                }
                $companyService->saveActingWorkstation($ActingWorkstaion);
            }

            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
            $this->redirect('pim/ActingWorkStation?emp=' . $empJob->empNumber);
        }
    }

    public function executeAjaxActinWorkstationDelete(sfWebRequest $request) {

        $empno = $request->getParameter('empno');
        $compId = $request->getParameter('worksation');
        $companyService = new CompanyService();

        $companyService->deleteActingWorkstation($empno, $compId);

        echo json_encode(true);
        die;
    }

    public function executeLDAPManual(sfWebRequest $request) {
        
        $databaseManager = new sfDatabaseManager(sfProjectConfiguration::getApplicationConfiguration('orangehrm', 'prod', true));
        $connection = $databaseManager->getDatabase("doctrine")->getConnection();
        $connection = Doctrine_Manager::getInstance()->connection();
for($i=1; $i<7687; $i+=500){
    $j=$i;
    $j=$j+500;

                $sql = "SELECT e.emp_number
                  FROM hs_hr_employee e where emp_active_hrm_flg = 1"; 
//        $sql.= " LIMIT {$datastartlimit}, {$dataperpage}";
          $sql.= " LIMIT {$i}, {$j}";
         $stmt = $connection->prepare("$sql");
            $stmt->execute();
        
            while ($row = $stmt->fetch()) {
                 $emplist[] = $row['emp_number'];
                
            }
            

       //$emplist = array('52');

        foreach ($emplist as $row) {
            $service = new EmployeeService();
            $employee = $service->getEmployee($row);
            $sysConf = new sysConf();
            if ($sysConf->isuseLdap == "YES") {


                $ldapDao = new ldapDao();

                $ldapDao->callToLdap($employee);
            }
        }
}
        die;
    }
    
    public function executeJpagination(sfWebRequest $request) {
        $encrypt=new EncryptionHandler();
        $Culture = $this->getUser()->getCulture();
        $sysconfig = new sysConf(); 
        $datapage = $request->getParameter('datapage');
        $searchmode = $request->getParameter('searchmode');
        $searchvalue = $request->getParameter('searchvalue');
        $sort = $request->getParameter('sort');
        $cmbDesignation = $request->getParameter('cmbDesignation');
        $cmbDivision = $request->getParameter('cmbDivision');
        
        
        $dataperpage=$sysconfig->rowLimit;
        $datastartlimit=$dataperpage*$datapage;
        //die(print_r($datapage."|".$searchmode."|".$searchvalue));
        $databaseManager = new sfDatabaseManager(sfProjectConfiguration::getApplicationConfiguration('orangehrm', 'prod', true));
        $connection = $databaseManager->getDatabase("doctrine")->getConnection();
        $connection = Doctrine_Manager::getInstance()->connection();
        
        $employeeDao = new EmployeeDao();
        $user=$employeeDao->getUserByID($_SESSION['user']);  

                switch ($searchmode) {
            case 'id':
                $searchColumn = 'e.employee_id';
                break;
            case 'firstname':
                if($Culture=="en"){
                $searchColumn = "e.emp_firstname";                    
                }else{
                $searchColumn = "e.emp_firstname_".$Culture;                     
                }
                break;
            case 'lastname':
                if($Culture=="en"){
                $searchColumn = "e.emp_lastname";               
                }else{
                $searchColumn = "e.emp_firstname_".$Culture;                     
                }
                break;
            case 'designation':
                if($Culture=="en"){
                $searchColumn = "j.jobtit_name";                  
                }else{
                $searchColumn = "j.jobtit_name_".$Culture;                     
                }
                break;
            case 'service':
                if($Culture=="en"){
                $searchColumn = "s.service_name";              
                }else{
                $searchColumn = "s.service_name_".$Culture;                     
                }
                break;
            case 'division':
                if($Culture=="en"){
                $searchColumn = "d.title";                
                }else{
                $searchColumn = "d.title_".$Culture;                     
                }
                break;
        }
        
        $sqlrow = "SELECT e.*, j.*, s.*, d.*
                  FROM vw_hs_hr_employee e 
                  left join hs_hr_job_title j on e.job_title_code=j.jobtit_code
                  left join hs_hr_service s on e.service_code=s.service_code
                  left join hs_hr_compstructtree d on e.work_station=d.id";
        if ($searchmode != 'all' && $searchvalue != '') {
            //$sql.= " where {$searchColumn}  LIKE "."'%".trim($searchvalue)."%' ";
            $sqlrow.= " where {$searchColumn}  LIKE '%".trim($searchvalue)."%' ";
        }
        if($cmbDesignation!= "all"){
            $sqlrow.= " and e.job_title_code = '{$cmbDesignation}'";            
        }
        if($cmbDivision!= "all"){
            $sqlrow.= " and e.work_station = '{$cmbDivision}'";            
        }
        //die(print_r($sqlrow));
        if($user->def_level!= 1){
                   // $sqlrow.= " where e.emp_number = {$user->emp_number}";
        } 
        //die(print_r($sqlrow));
        
        $stmt1 = $connection->prepare("$sqlrow");
            $result=$stmt1->execute();
            $count=$stmt1->rowCount();
            
            
        $sql = "SELECT e.*, j.*, s.*, d.*
                  FROM vw_hs_hr_employee e 
                  left join hs_hr_job_title j on e.job_title_code=j.jobtit_code
                  left join hs_hr_service s on e.service_code=s.service_code
                  left join hs_hr_compstructtree d on e.work_station=d.id";
        if ($searchmode != 'all' && $searchvalue != '') {
            //$sql.= " where {$searchColumn}  LIKE "."'%".trim($searchvalue)."%' ";
            $sql.= " where {$searchColumn}  LIKE '%".trim($searchvalue)."%' ";
        }
                if($cmbDesignation!= "all"){
            $sql.= " and e.job_title_code = '{$cmbDesignation}'";            
        }
        if($cmbDivision!= "all"){
            $sql.= " and e.work_station = '{$cmbDivision}'";            
        }
             $sql.= " LIMIT {$datastartlimit}, {$dataperpage}";
               //die(print_r($sql));                
            $stmt = $connection->prepare("$sql");
            $stmt->execute();
            
            
                while ($row = $stmt->fetch()) {
                    if ($Culture == "en") {
                        $EmpName =$row['emp_display_name'];
                        $Designation =$row['jobtit_name'];
                        $Service =$row['service_name'];
                        $Division =$row['title'];
                        
                    } else {
                        $EmpName =$row['emp_display_name_'.$Culture];
                        $Designation =$row['jobtit_name_'.$Culture];
                        $Service =$row['service_name_'.$Culture];
                        $Division =$row['title_'.$Culture];
                        if($EmpName==null){
                            $EmpName =$row['emp_display_name'];
                        }
                        if($Designation==null){
                           $Designation =$row['jobtit_name'];
                        }
                        if($Service==null){
                            $Service =$row['service_name'];
                        }
                        if($Division==null){
                            $Division =$row['title'];
                        }
                    }
                    $encryptEmpno=$encrypt->encrypt($row[0]);
                    
                $empno[] = $row[0]."|".$row['employee_id']."|".$EmpName."|".$Designation."|".$Service."|".$Division."|".$encryptEmpno."|".$count;
                }
                //die(print_r($empno));
                
                echo json_encode($empno);
                $connection->close();
        die;
    }
    
    
    
    
    public function executeEmpEducation(sfWebRequest $request) {
        if (strlen($_SESSION['PIM_EMPID'])) {

            try {
                
                $EMPID = $_SESSION['PIM_EMPID'];
                $this->userCulture = $this->getUser()->getCulture();


                $this->sorter = new ListSorter('propoerty.sort', 'pim_module', $this->getUser(), array('', ListSorter::ASCENDING));
                $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

                $this->searchMode = ($request->getParameter('cmbSearchMode') == '') ? 'all' : $request->getParameter('cmbSearchMode');
                $this->searchValue = ($request->getParameter('txtSearchValue') == '') ? '' : $request->getParameter('txtSearchValue');

                $this->sort = ($request->getParameter('sort') == '') ? 'eduh_id' : $request->getParameter('sort');
                $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

                $empDao = new EmployeeDao();
                $result = $empDao->searchEmpEducation($this->searchMode, $this->searchValue, $this->userCulture, $request->getParameter('page'), $this->sort, $this->order,$EMPID);

                $this->listEmpEducation = $result['data'];
                $this->pglay = $result['pglay'];
                $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
                $this->pglay->setSelectedTemplate('{%page}');
                if (count($result['data']) <= 0) {
                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
                }
            } catch (sfStopException $sf) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    /*
     * Employee Education save
     */

    public function executeSaveEmpEducation(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {


            try {


                if (!strlen($request->getParameter('lock'))) {
                    $this->mode = 0;
                } else {
                    $this->mode = $request->getParameter('lock');
                }
                $ebLockid = $request->getParameter('disId');
                if (isset($this->mode)) {
                    if ($this->mode == 1) {

                        $conHandler = new ConcurrencyHandler();

                        $recordLocked = $conHandler->setTableLock('hs_hr_edu_emp_head', array($ebLockid), 1);

                        if ($recordLocked) {
                            // Display page in edit mode
                            $this->mode = 1;
                        } else {
                            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                            $this->mode = 0;
                        }
                    } else if ($this->mode == 0) {
                        $conHandler = new ConcurrencyHandler();
                        $recordLocked = $conHandler->resetTableLock('hs_hr_edu_emp_head', array($ebLockid), 1);
                        $this->mode = 0;
                    }
                }



                $this->userCulture = $this->getUser()->getCulture();
                $empDao = new EmployeeDao();


                $employee = $empDao->read($_SESSION['PIM_EMPID']);

                if ($this->userCulture == "en") {


                    $empName = 'emp_display_name';
                } else {
                    $feildName = 'emp_display_name_' . $this->userCulture;
                    if ($employee[0]->$feildName == "") {
                        $empName = 'emp_display_name';
                    } else {
                        $empName = 'emp_display_name_' . $this->userCulture;
                    }
                }
                $this->defaultEmpName = $employee[0]->$empName;



                $disId = $request->getParameter('disId');
                if (strlen($disId)) {
                    if (!strlen($this->mode)) {
                        $this->mode = 0;
                    }
                    $this->EmpEducationHead = $empDao->readEmpEducation($disId);
                    if (!$this->EmpEducationHead) {
                        $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                        $this->redirect('pim/EmpEducation');
                    }
                } else {
                    $this->mode = 1;
                }
                
                $this->EducationTypeList = $empDao->readEducationTypeList();
                $this->EmpEducationDetail = $empDao->readEmpEducationDetail($disId);
                $this->MediumList = $empDao->getLanguages();
                
                
                if ($request->isMethod('post')) { 
                    
                    //die(print_r($_POST));
                    $conn = Doctrine_Manager::getInstance()->connection();
                    $conn->beginTransaction();

                    $empId = $_SESSION['PIM_EMPID'];
                    if (strlen($request->getParameter('txtHiddenDisID'))) {

                        $EMPHead = $empDao->readEmpEducation($request->getParameter('txtHiddenDisID'));
                    } else {
                        $EMPHead = new EducationEMPHead();
                    }
                    
                    if (strlen($request->getParameter('cmbEduType'))) {
                        $EMPHead->setEdu_type_id(trim($request->getParameter('cmbEduType')));
                    } else {
                        $EMPHead->setEdu_type_id(null);
                    }
                    if (strlen($empId)) {
                        $EMPHead->setEmp_number(trim($empId));
                    } else {
                        $EMPHead->setEmp_number(null);
                    }
                    if (strlen($request->getParameter('cmbYear'))) {
                        $EMPHead->setGrd_year(trim($request->getParameter('cmbYear')));
                    } else {
                        $EMPHead->setGrd_year(null);
                    }
                    if (strlen($request->getParameter('txtInstitute'))) {
                        $EMPHead->setEduh_institute(trim($request->getParameter('txtInstitute')));
                    } else {
                        $EMPHead->setEduh_institute(null);
                    }
                    if (strlen($request->getParameter('txtIndexNo'))) {
                        $EMPHead->setEduh_indexno(trim($request->getParameter('txtIndexNo')));
                    } else {
                        $EMPHead->setEduh_indexno(null);
                    }
                    if (strlen($request->getParameter('txtIslandRank'))) {
                        $EMPHead->setEduh_slrank(trim($request->getParameter('txtIslandRank')));
                    } else {
                        $EMPHead->setEduh_slrank(null);
                    }
                    if (strlen($request->getParameter('txtZScore'))) {
                        $EMPHead->setEduh_zscorgdp(trim($request->getParameter('txtZScore')));
                    } else {
                        $EMPHead->setEduh_zscorgdp(null);
                    }

                    $EMPHead->save();
                    if($disId!= null){
                    $empDao->deleteEmpEducationDetail($disId);
                    }
                    
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
                    $EmpEduDetail = new EducationEMPDetail();
                    if($disId!= null){
                    $EmpEduDetail->setEduh_id($disId);
                    }else{
                    $MaxEmpEduHead = $empDao->getLastEmpEducationHeadID(); 
                    $EmpEduDetail->setEduh_id($MaxEmpEduHead[0]['MAX']);
                    }



                    $v = "a_" . $uniqueRowIds[$i];



                    if (!strlen(${$v}[cmbSubject])) {
                        $EmpEduDetail->setSubj_id(null);
                    } else {
                        $EmpEduDetail->setSubj_id(${$v}[cmbSubject]);
                    }
                    if (!strlen(${$v}[cmbGrade])) {

                        $EmpEduDetail->setGrd_id(null);
                    } else {
                        $EmpEduDetail->setGrd_id(${$v}[cmbGrade]);
                    }
                    if (!strlen(${$v}[cmbMedium])) {

                        $EmpEduDetail->setLang_code(null);
                    } else {
                        $EmpEduDetail->setLang_code(${$v}[cmbMedium]);
                    }
                    if (!strlen(${$v}[txtDesc])) {

                        $EmpEduDetail->setEdud_comment(null);
                    } else {
                        $EmpEduDetail->setEdud_comment(${$v}[txtDesc]);
                    }
                    //$empDao->saveRateDetail($EmpEduDetail);
                    $EmpEduDetail->save();
                }

                    
                    $conn->commit();
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                    $this->redirect('pim/EmpEducation');
                }
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/EmpEducation');
            } catch (sfStopException $sf) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/EmpEducation');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    public function executeDeleteEmpEducation(sfWebRequest $request) {

        $EmpHeadDelete = $request->getParameter('chkID', array());
        if ($EmpHeadDelete) {

            $empDao = new EmployeeDao();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($EmpHeadDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_edu_emp_head', array($EmpHeadDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $EmpHeadDelete[$i];
                    } else {
                        $saveArr = $EmpHeadDelete[$i];

                        $empDao->deleteEmpEducationDetail($EmpHeadDelete[$i]);
                        $empDao->deleteEmpEducationHead($EmpHeadDelete[$i]);
                        $conHandler->resetTableLock(' hs_hr_edu_emp_head', array($EmpHeadDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/EmpEducation');
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
        $this->redirect('pim/EmpEducation');
    }

    public function executeLoadSubjects(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();

        $empDao = new EmployeeDao();

        $id = $request->getParameter('EduType');
        $Slot = $empDao->getSubjectsID($id);
        $arr = Array();
        foreach ($Slot as $row) {

            $arr[] = $row->subj_id . "|" . $row->subj_name . "|" . $row->subj_name_si . "|" . $row->subj_name_ta . "|" . $row->edu_type_id;
        }

        echo json_encode($arr);
        die;
    }
    
        public function executeLoadGrade(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();

        $empDao = new EmployeeDao();

        $EduT = $request->getParameter('EduType');
        $Year = $request->getParameter('EduYear');
        $Slot = $empDao->getGradeYear($EduT,$Year);
        $arr = Array();
        if($Slot[0]->grd_id == null){
            $Slot = $empDao->getGradeYearNull($EduT,$Year);
            foreach ($Slot as $row) {

            $arr[] = $row->grd_id . "|" . $row->grd_name . "|" . $row->grd_desc . "|" . $row->grd_mark ;
            }
        }else{
            foreach ($Slot as $row) {

            $arr[] = $row->grd_id . "|" . $row->grd_name . "|" . $row->grd_desc . "|" . $row->grd_mark ;
        }}

        echo json_encode($arr);
        die;
    }
    
    public function executeEmp_EB_Exam(sfWebRequest $request) {
        if (strlen($_SESSION['PIM_EMPID'])) {

            try {
                $EMPID = $_SESSION['PIM_EMPID'];
                $this->userCulture = $this->getUser()->getCulture();


                $this->sorter = new ListSorter('propoerty.sort', 'pim_module', $this->getUser(), array('', ListSorter::ASCENDING));
                $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

                $this->searchMode = ($request->getParameter('cmbSearchMode') == '') ? 'all' : $request->getParameter('cmbSearchMode');
                $this->searchValue = ($request->getParameter('txtSearchValue') == '') ? '' : $request->getParameter('txtSearchValue');

                $this->sort = ($request->getParameter('sort') == '') ? 'i.ebe_id' : $request->getParameter('sort');
                $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

                $empDao = new EmployeeDao();
                $result = $empDao->searchEmp_EB_Exam($this->searchMode, $this->searchValue, $this->userCulture, $request->getParameter('page'), $this->sort, $this->order , $EMPID);

                $this->listEBExam = $result['data'];
                $this->pglay = $result['pglay'];
                $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
                $this->pglay->setSelectedTemplate('{%page}');
                if (count($result['data']) <= 0) {
                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
                }
            } catch (sfStopException $sf) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }
    
    
        public function executeSaveEmp_EB_Exam(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {


            try {


                if (!strlen($request->getParameter('lock'))) {
                    $this->mode = 0;
                } else {
                    $this->mode = $request->getParameter('lock');
                }
                $ebLockid = $request->getParameter('disId');
                if (isset($this->mode)) {
                    if ($this->mode == 1) {

                        $conHandler = new ConcurrencyHandler();

                        $recordLocked = $conHandler->setTableLock('hs_hr_eb_employee', array($ebLockid), 1);

                        if ($recordLocked) {
                            // Display page in edit mode
                            $this->mode = 1;
                        } else {
                            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                            $this->mode = 0;
                        }
                    } else if ($this->mode == 0) {
                        $conHandler = new ConcurrencyHandler();
                        $recordLocked = $conHandler->resetTableLock('hs_hr_eb_employee', array($ebLockid), 1);
                        $this->mode = 0;
                    }
                }



                $this->userCulture = $this->getUser()->getCulture();
                $empDao = new EmployeeDao();


                $employee = $empDao->read($_SESSION['PIM_EMPID']);

                if ($this->userCulture == "en") {


                    $empName = 'emp_display_name';
                } else {
                    $feildName = 'emp_display_name_' . $this->userCulture;
                    if ($employee[0]->$feildName == "") {
                        $empName = 'emp_display_name';
                    } else {
                        $empName = 'emp_display_name_' . $this->userCulture;
                    }
                }
                $this->defaultEmpName = $employee[0]->$empName;



                $disId = $request->getParameter('disId');
                $atmpt = $request->getParameter('atmpt');
                if (strlen($disId)) {
                    if (!strlen($this->mode)) {
                        $this->mode = 0;
                    }
                    $this->EmployeeEB = $empDao->readEB_Employee_ByID($disId,$atmpt);
                    
                    if (!$this->EmployeeEB) {
                        $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                        $this->redirect('pim/Emp_EB_Exam');
                    }
                } else {
                    $this->mode = 1;
                }
                
                $this->EducationTypeList = $empDao->readEducationTypeList();
                $this->EmpEducationDetail = $empDao->readEmp_EB_Exam_Detail($disId,$_SESSION['PIM_EMPID'],$atmpt);
                
                $this->MediumList = $empDao->getLanguages();
                
                $this->GradeList = $empDao->GradeList();
                $this->EBExamList = $empDao->EBExamList();
                //$this->disId = $request->getParameter('disId');
                
                if ($request->isMethod('post')) { 
                    
                    //die(print_r($_POST));
                    $conn = Doctrine_Manager::getInstance()->connection();
                    $conn->beginTransaction();

                    $empId = $_SESSION['PIM_EMPID'];
                    
                    if ($request->getParameter('cmbAtmpt')!= null && $request->getParameter('cmbEBExam')!=null && $empId!= null) {

                        $empDao->deleteEmp_EB_Exam($empId,$request->getParameter('cmbEBExam'),$request->getParameter('cmbAtmpt'));
                    } 
                        
                    
                    
                    
                    


                    

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
                    
                    $EMPEB = new EBEmployee();
                    
                    if (strlen($request->getParameter('cmbEBExam'))) {
                        $EMPEB->setEbh_id(trim($request->getParameter('cmbEBExam')));
                    } else {
                        $EMPEB->setEbh_id(null);
                    }
                    if (strlen($empId)) {
                        $EMPEB->setEmp_number(trim($empId));
                    } else {
                        $EMPEB->setEmp_number(null);
                    }
                    
                    

//                    
//                    $EmpEduDetail = new EducationEMPDetail();
//                    if($disId!= null){
//                    $EmpEduDetail->setEduh_id($disId);
//                    }else{
//                    $MaxEmpEduHead = $empDao->getLastEmpEducationHeadID(); 
//                    $EmpEduDetail->setEduh_id($MaxEmpEduHead[0]['MAX']);
//                    }



                    $v = "a_" . $uniqueRowIds[$i];



                    if (!strlen(${$v}[cmbSubject])) { 
                        $EMPEB->setEbd_id(null);
                    } else {
                        $EBDeatil = $empDao->ReadSubjectID($request->getParameter('cmbEBExam'),(${$v}[cmbSubject]));
                        
                        if($EBDeatil[0]->ebd_id!== null){
                            $EMPEB->setEbd_id($EBDeatil[0]->ebd_id);
                        }
                       
                    }
                    
                    if (!strlen(${$v}[txtStartdate])) {

                        $EMPEB->setEbe_start_date(null);
                    } else {
                        $EMPEB->setEbe_start_date(${$v}[txtStartdate]);
                    }
                    if (!strlen(${$v}[txtEnddate])) {

                        $EMPEB->setEbe_complete_date(null);
                    } else {
                        $EMPEB->setEbe_complete_date(${$v}[txtEnddate]);
                    }
                    if (!strlen(${$v}[txtMarks])) {

                        $EMPEB->setEbe_marks(null);
                    } else {
                        $EMPEB->setEbe_marks(${$v}[txtMarks]);
                    }
                    if (!strlen(${$v}[cmbStatus])) {

                        $EMPEB->setEbe_flg_pass(2);
                    } else {
                        $EMPEB->setEbe_flg_pass(${$v}[cmbStatus]);
                    }
                     if (!strlen($request->getParameter('cmbAtmpt'))) {

                        $EMPEB->setEbe_attepmt(null);
                    } else {
                        $EMPEB->setEbe_attepmt($request->getParameter('cmbAtmpt'));
                    }
                     if (!strlen(${$v}[txtComment])) {

                        $EMPEB->setEbe_comment(null);
                    } else {
                        $EMPEB->setEbe_comment(${$v}[txtComment]);
                    }
                    //$empDao->saveRateDetail($EmpEduDetail);
                    $EMPEB->save();
                }

                    
                    $conn->commit();
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                    $this->redirect('pim/Emp_EB_Exam');
                }
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/Emp_EB_Exam');
            } catch (sfStopException $sf) {
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/Emp_EB_Exam');
            }
        } else {
            $this->setMessage('NOTICE', array($this->getContext()->geti18n()->__('Please select a employee')));
            $this->redirect('pim/list');
        }
    }

    
   public function executeLoadEMPEBSubjects(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->empNumber = $_SESSION['PIM_EMPID'];
        }
        $empDao = new EmployeeDao();

        $GradeID = $request->getParameter('GradeID');
        $EBID = $request->getParameter('EBID');
        $Subject = $empDao->readEBExamsSubjectsbyID($EBID);
    foreach ($Subject as $row) {

            $arr[] = $row->EBSubject->ebs_id . "|" . $row->EBSubject->ebs_name . "|" . $row->EBSubject->ebs_name_si . "|" . $row->EBSubject->ebs_name_ta ;
        }

        echo json_encode($arr);
        die;
    }
    
    public function executeLoadEMPEBSubjectHistory(sfWebRequest $request) {

        if (strlen($_SESSION['PIM_EMPID'])) {
            $this->empNumber = $_SESSION['PIM_EMPID'];
        }
        $empDao = new EmployeeDao();

        $SUBID = $request->getParameter('SUBID');
        $EBID = $request->getParameter('EBID');
        $Atmpt = $request->getParameter('Atmpt');
        
        $EBDeatil = $empDao->ReadSubjectID($EBID,$SUBID);
                        
        if($EBDeatil[0]->ebd_id!== null){
            $SUBID=$EBDeatil[0]->ebd_id;
        }else{
            $SUBID= null;
        }
        
        $Subject = $empDao->readEmpEBExamsSubjectsbyID($SUBID,$EBID,$this->empNumber,$Atmpt);
    

        $arr = $Subject->ebe_start_date . "|" . $Subject->ebe_complete_date . "|" . $Subject->ebe_marks . "|" . $Subject->ebe_flg_pass . "|" . $Subject->ebe_comment ;
        

        echo json_encode($arr);
        die;
    }
    
    
    public function executeDeleteEmp_EB_Exam(sfWebRequest $request) {

        $EmpHeadDelete = $request->getParameter('chkID', array());
        if ($EmpHeadDelete) {

            $empDao = new EmployeeDao();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();


                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($EmpHeadDelete); $i++) {

                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_eb_employee', array($EmpHeadDelete[$i]), 1);


                    if ($isRecordLocked) {
                        $countArr = $EmpHeadDelete[$i];
                    } else {
                        $saveArr = $EmpHeadDelete[$i];

                        $empDao->deleteEmpEBEducationBYID($EmpHeadDelete[$i]);
                        
                        $conHandler->resetTableLock(' hs_hr_eb_employee', array($EmpHeadDelete[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('pim/Emp_EB_Exam');
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
        $this->redirect('pim/Emp_EB_Exam');
    }
    
    
    public function executeLoadGrid(sfWebRequest $request) {
        $culture = $this->getUser()->getCulture();
        $empDao = new EmployeeDao();
        $empId = $request->getParameter('empid');

        $emplist = $empDao->getEmployee($empId);
        $arr = Array();


foreach ($emplist as $row) {

    if ($culture == "en") {
        $abc = "emp_display_name";
    } else {
        $abc = "emp_display_name_" . $culture;
    }
    if ($culture == "en") {
        $title = "title";
    } else {
        $title = "title_" . $culture;
    }


    
    $arr[$row['employeeId']] = $row['employeeId'] . "|" . $row[$abc] ."|". $row['empNumber'] ;
}
echo json_encode($arr);
        die;
}

// Progress approve
    
        public function executeListJobProgress(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();
            $empDao = new EmployeeDao();

            $this->sorter = new ListSorter('ListJobProgress', 'pim', $this->getUser(), array('j.jph_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('pim/ListJobProgress');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'j.jph_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'DESC' : $request->getParameter('order');
            
            $this->emp = ($request->getParameter('txtEmpId') == null) ? $request->getParameter('emp') : $_POST['txtEmpId'];
            $this->type = ($request->getParameter('txtType') == null) ? $request->getParameter('type') : $_POST['txtType'];
            
            $res = $empDao->listJobProgress($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'), $this->emp, $this->type);
            $this->JobProgressList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }
    
    
     public function executeUpdateJobProgress(sfWebRequest $request) {


        $empDao = new EmployeeDao(); 
        //$EvaluationService = new EvaluationService();
        $this->myCulture = $this->getUser()->getCulture();
         
        if($_SESSION['empNumber']){
        $Employee=$empDao->LoadEmpData($_SESSION['empNumber']);
        $this->EmployeeNumber= $Employee[0]['empNumber'];
        $this->EmpDisplayName= $Employee[0]['emp_display_name'];
        }
        $this->type=$request->getParameter('type');
        $jp=$request->getParameter('jp');
         $this->jp=$jp;
         
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

                    $recordLocked = $conHandler->setTableLock('hs_hr_job_progress_head', array($VTID), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_hr_job_progress_head', array($VTID), 1);
                    $this->lockMode = 0;
                }
            }

            //Table lock code is closed


            $JobProgress = $empDao->readJobProgress($encrypt->decrypt($request->getParameter('id')));
            if (!$JobProgress) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('pim/ListJobProgress');
            }
        } else {

            $this->lockMode = 1;
        }
        $this->JobProgress = $JobProgress;
        
        
        if ($request->isMethod('post')) { //die(print_r($_POST));
            
             $conn = Doctrine_Manager::getInstance()->connection();
             $conn->beginTransaction();
          try {  
            if(strlen($request->getParameter('txtid'))){
                $JobProgressHead=$empDao->readJobProgress($request->getParameter('txtid'));
            }else{
                 $JobProgressHead=new JobProgressHead();
            }
            if(strlen($request->getParameter('txtEmpId'))){
                $JobProgressHead->setJph_emp_number($request->getParameter('txtEmpId'));
            }
            else{
                $JobProgressHead->setJph_emp_number(null);
            }
            if(strlen($request->getParameter('cmbYear'))){
                $JobProgressHead->setJph_year($request->getParameter('cmbYear'));
            }
//            else{
//                $JobProgressHead->setJph_year(null);
//            }
            if(strlen($request->getParameter('cmbMonth'))){
                $JobProgressHead->setJph_month($request->getParameter('cmbMonth'));
            }
//            else{
//                $JobProgressHead->setJph_month(null);
//            }
            if(strlen($request->getParameter('txtEmpId2'))){
                $JobProgressHead->setJph_app_emp_number($request->getParameter('txtEmpId2'));
            }
//            else{
//                $JobProgressHead->setJph_app_emp_number(null);
//            }
            if(strlen($request->getParameter('txtComment'))){
                $JobProgressHead->setJph_comment($request->getParameter('txtComment'));
            }else{
                $JobProgressHead->setJph_comment(null);
            }
                $JobProgressHead->save();
                $HeadMax=$empDao->getMaxJobProgressHead();
                if($jp!= '1'){
                $empDao->deleteJobProgressDetails($request->getParameter('txtid'));
                
                
                $i=0;
                foreach ($_POST['date'] as $row){
                    if($_POST['date'][$i]!= null){
                        
                        $JobProgressDetail = new JobProgressDetails();
                        $DetailMax=$empDao->getMaxJobProgressDetails();

                         $JobProgressDetail->setJpd_id($DetailMax[0]['Max']+1);
                    if(strlen($_POST['txtid'])){                        
                         $JobProgressDetail->setJph_id($_POST['txtid']);
                    }else{
                         $JobProgressDetail->setJph_id($HeadMax[0]['Max']);
                    }
                    if(strlen($_POST['date'][$i])){                        
                         $JobProgressDetail->setJpd_date($_POST['date'][$i]);
                    }else{
                         $JobProgressDetail->setJpd_date(null);
                    }
                    if(strlen($_POST['txtDesc'][$i])){                        
                         $JobProgressDetail->setJpd_description(mysql_real_escape_string($_POST['txtDesc'][$i]));
                    }
                    
                        $JobProgressDetail->save();
                    
                    }
                    $i++;
                    }
                    
          }else{
              $i=0;
                foreach ($_POST['date'] as $row){ 
                    if($_POST['date'][$i]!= null && $JobProgressHead->jph_id!= null ){
              $readProgressDetail= $empDao->getProgressDetail($JobProgressHead->jph_id,$_POST['date'][$i]);
              //die(print_r($readProgressDetail));
              if(strlen($readProgressDetail->jph_id) && strlen($readProgressDetail->jpd_id)){ //die(print_r($readProgressDetail->jpd_id));
              if(strlen($_POST['txtJP'][$i])){                        
                         $readProgressDetail->setJpd_jp(mysql_real_escape_string($_POST['txtJP'][$i]));
                    }
                    $readProgressDetail->save();
              }
              
              }
              $i++;
              }
          }
            
            
                
                $conn->commit();
                
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollback();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('txtid') != null) {
                    $this->redirect('pim/UpdateJobProgress?id=' . $encrypt->encrypt($request->getParameter('txtid')) .'&jp='. $this->jp. '&lock=0&type='.$this->type);
                } else {
                    $this->redirect('pim/ListJobProgress');
                }
            } catch (sfStopException $sf) {
                $this->redirect('default/error');    
            } catch (Exception $e) {
                $conn->rollback();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                if ($request->getParameter('txtid') != null) {
                    $this->redirect('pim/UpdateJobProgress?id=' . $encrypt->encrypt($request->getParameter('txtid')).'&jp='. $this->jp . '&lock=0&type='.$this->type);
                } else {
                    $this->redirect('pim/ListJobProgress');
                }
            }
            if ($request->getParameter('txtid') != null) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
                $this->redirect('pim/UpdateJobProgress?id=' . $encrypt->encrypt($request->getParameter('txtid')).'&jp='. $this->jp . '&lock=0&type='.$this->type);
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
                $this->redirect('pim/ListJobProgress');
            }
        }
    }
    
        public function executeAjaxGetEmplyeeProgress(sfWebRequest $request) {

        $Year = $request->getParameter('Year');
        $Month = $request->getParameter('Month');
        $employee = $request->getParameter('employee');
        
        $empDao = new EmployeeDao();
        $EmplyeeData = $empDao->getGetFTData($Year,$Month,$employee);
        //die(print_r($EmplyeeData));
        foreach ($EmplyeeData as $row) {
           
            $date = new DateTime($row['jpd_date']);
            $name = $date->format("l");
            $row['datename'] = $name;             
            $array[] = $row;
            
        }
        
        echo json_encode(array($array));
        die;
    }
    
    public function executeAjaxGetMonth(sfWebRequest $request) {

        $Year = $request->getParameter('Year');
        $Month = $request->getParameter('Month');
        
        $num = cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
        for($i=1; $i <= $num; $i++){
            $date = new DateTime($Year."-".$Month."-".$i);
            $Date = $date->format("Y-m-d");
            $name = $date->format("l");
            $days[$i]=$Date."|".$name;
        }


        echo json_encode(array($days));
        die;
    }
    
    public function executeAjaxApprove(sfWebRequest $request) {


        $id = $request->getParameter('ev_id');
        
        $empDao = new EmployeeDao();
        $JobProgressHead = $empDao->readJobProgress($id);
        $JobProgressHead->setJph_app_flg(1);
        $JobProgressHead->save();
        
        if($JobProgressHead){
        $e = getdate();
        $today = date("Y-m-d", $e[0]);    
            
        $EmployeeNotifiation = new NotificationEmployee();
        $EmployeeNotifiation->setMod_id("PIM");
        $message = "Job Progress of ".$JobProgressHead->jph_year."/".$JobProgressHead->jph_month." Approved by ".$JobProgressHead->ApprovalEmployee->emp_display_name;
        $EmployeeNotifiation->setNot_message($message);
        $EmployeeNotifiation->setEmp_number($JobProgressHead->jph_emp_number);
        $EmployeeNotifiation->setStatus(0);
        $EmployeeNotifiation->setCreate_date($today);
        $EmployeeNotifiation->setCreate_emp_number($JobProgressHead->jph_app_emp_number);
        $EmployeeNotifiation->save();
        }
        
        
        
        echo json_encode("Successfully Approved");
        die;
    }
    
     public function executeSignature(sfWebRequest $request) {
         
         if ($request->isMethod('post')) { //die(print_r($_POST));
         try{
         $empDao = new EmployeeDao();
         
          
              $empid = $_POST['txtEmpId'];
              $signature = $_POST['output'];
              $img = sigJsonToImage($signature);

              $png=  imagepng($img);
              
              $parts = explode(',', $_POST['signature']);  
              $data = $parts[1];
              
              //die(print_r($png));
              if($empid!= null && $signature!= null){
                  $empDao->deleteSignature($empid);
                  $EmployeeSignature = new EmployeeSignature();
                  $EmployeeSignature->setEmp_number($empid);
                  $EmployeeSignature->setSignature($signature);
                  //$EmployeeSignature->setSig_image(base64_encode($png));
                  $EmployeeSignature->setSig_image(base64_decode($data));
                   //$EmployeeSignature->setSig_image($png);
                  $EmployeeSignature->save();
              }
              
              
              

//// Save to file
//imagepng($img, 'signature.png');
//
//// Output to browser
//header('Content-Type: image/png');
//imagepng($img);
////die(print_r(imagepng($img)));
//// Destroy the image in memory when complete
////imagedestroy($img);
//          
//die;
            $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Saved')));
            $this->redirect('pim/Signature');
         
      } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        } catch (sfStopException $sf) {
            $this->redirect('default/error');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
     }
     }
}
