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
//xajax headers
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
<?php include_http_metas() ?>
<?php include_metas() ?>

        <title>OrangeHRM - Employee Details</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

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
        <link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<?php echo javascript_include_tag('orangehrm.validate.js'); ?>      
<?php include ROOT_PATH . "/lib/common/calendar.php"; ?>
        <script type="text/javascript"><!--//--><![CDATA[//><!--

            function displayLayer(panelNo) {

                switch(panelNo) {
                    case 1 : showPane('personal');break;
                    case 2 : showPane('job');break;
                    case 3 : showPane('dependents');break;
                    case 4 : showPane('contacts'); break;
                    case 5 : showPane('emgcontacts'); break;
                    case 6 : showPane('attachments'); break;
                    case 7 : break;
                    case 8 : break;
                    case 9 : showPane('education'); break;
                    case 10 : showPane('immigration'); break;
                    case 11 : showPane('languages');break;
                    case 12 : showPane('licenses'); break;
                    case 13 : showPane('memberships'); break;
                    case 14 : showPane('payments'); break;
                    case 15 : showPane('report-to'); break;
                    case 16 : showPane('skills'); break;
                    case 17 : showPane('work-experiance'); break;
                    case 18 : showPane('tax'); break;
                    case 19 : showPane('direct-debit'); break;
                    case 20 : showPane('custom'); break;
                    case 21 : showPane('photo'); break;
                    case 22 : showPane('ebexam'); break;
                    case 23 : showPane('servicerec'); break;
                }
            }

            function showPane(paneId) {
                var allPanes = new Array('personal','job','dependents','contacts','emgcontacts','attachments','education','immigration','languages','licenses',
                'memberships','payments','report-to','skills','work-experiance', 'tax', 'direct-debit','custom', 'photo','ebexam','servicerec');
                var numPanes = allPanes.length;
                for (i=0; i< numPanes; i++) {
                    pane = allPanes[i];
                    if (pane != paneId) {
                        var paneDiv = document.getElementById(pane);
                        if (paneDiv.className.indexOf('currentpanel') > -1) {
                            paneDiv.className = paneDiv.className.replace(/\scurrentpanel\b/,'');
                        }

                        // style link
                        var link = document.getElementById(pane + 'Link');
                        if (link && (link.className.indexOf('current') > -1)) {
                            link.className = '';
                        }
                    }
                }

                var currentPanel = document.getElementById(paneId);
                if (currentPanel.className.indexOf('currentpanel') == -1) {
                    currentPanel.className += ' currentpanel';
                }
                var currentLink = document.getElementById(paneId + 'Link');
                if (currentLink && (currentLink.className.indexOf('current') == -1)) {
                    currentLink.className = 'current';
                }

            }


            function showPhotoHandler() {
                displayLayer(21);
            }

            function showAddPane(paneName) {
                YAHOO.OrangeHRM.container.wait.show();

                addPane = document.getElementById('addPane'+paneName);
                summaryPane = document.getElementById('summaryPane'+paneName);
                editPane = document.getElementById('editPane'+paneName);
                parentPane = document.getElementById('parentPane'+paneName);

                if (addPane && addPane.style) {
                    addPane.style.display = tableDisplayStyle;
                } else {
                    return;
                }

                if (editPane && parentPane) {
                    parentPane.removeChild(editPane);
                }

                YAHOO.OrangeHRM.container.wait.hide();
            }

            function showPaneData(paneName) {
                YAHOO.OrangeHRM.container.wait.show();

                pane = document.getElementById(paneName);

                if (pane && pane.style) {
                    pane.style.display = 'block';
                } else {
                    return;
                }

                YAHOO.OrangeHRM.container.wait.hide();
            }

            function hidePaneData(paneName) {
                YAHOO.OrangeHRM.container.wait.show();

                pane = document.getElementById(paneName);

                if (pane && pane.style) {
                    pane.style.display = 'none';
                } else {
                    return;
                }

                YAHOO.OrangeHRM.container.wait.hide();
            }

            function showHideSubMenu(link) {

                var uldisplay;
                var newClass;

                if (link.className == 'expanded') {

                    // Need to hide
                    uldisplay = 'none';
                    newClass = 'collapsed';

                } else {

                    // Need to show
                    uldisplay = 'block';
                    newClass = 'expanded';
                }

                var parent = link.parentNode;
                uls = parent.getElementsByTagName('ul');
                for(var i=0; i<uls.length; i++) {
                    ul = uls[i].style.display = uldisplay;
                }

                link.className = newClass;
            }

            tableDisplayStyle = "table";
            //--><!]]></script>


        <style type="text/css">
            <!--
            ul.error_list {
                color: #ff0000;
            }

            :disabled:not[type="image"] {
                background-color:#FFFFFF;
                color:#444444;
            }

            input[type=text] {
                border-top: 0px;
                border-left: 0px;
                border-right: 0px;
                border-bottom: 1px solid #888888;
            }

            table.historyTable th {
                border-width: 0px;
                padding: 3px 3px 3px 5px;
                text-align: left;
            }
            table.historyTable td {
                border-width: 0px;
                padding: 3px 3px 3px 5px;
                text-align: left;
            }

            .locationDeleteChkBox {
                padding:2px 4px 2px 4px;
                border-style: solid;
                border-width: thin;
                display:block;
            }

            .pimpanel {
                position:absolute;
                left:-9999px;
            }
            .currentpanel {
                margin-top: 10px;
<?php if ($_SESSION['PIM_MENU_TYPE'] == 'left') { ?>
                left:190px;
<?php } else { ?>
                left:130px;
<?php } ?>

            }
            #photodiv {
                margin-top:19px;
                float:left;
                text-align:center;
                margin-left: 650px;
                padding: 2px;
                border: 1px solid #FAD163;
            }
            #photodiv span {
                color: black;
                font-weight: bold;
            }

            #empname {
                display:block;
                color: black;
            }

            #personalIcons,
            #employmentIcons,
            #qualificationIcons {
                display:block;
                position:absolute;
                left:-999px;
                width:400px;
                text-align:center;
                padding-left:100px;
                padding-right:100px;
            }

            #icons div a {
                display:block;
                float:left;
                height: 50px;
                width: 54px;
                text-decoration:none;
                text-align:center;
                vertial-align:bottom;
                padding-top: 45px;
                outline: 0;
                background-position: top center;
                margin-left:8px;
                margin-right:8px;
            }

            #icons div a:hover {
                color: black;
                text-decoration: underline;
            }

            #icons div a.current {
                font-weight: bold;
                color:black;
                cursor:default;
            }

            #icons div a.current:hover {
                color:black;
                text-decoration:none;
            }

            #icons {
                display:block;
                clear:both;
                margin-left: 130px;
                margin-top: 5px;
                margin-bottom: 2px;
                width:500px;
                height: 60px;
            }
            #pimleftmenu {
                display:block;
                float: left;
                background: #FFFBED;
                padding: 2px 2px 2px 2px;
                margin: 10px 0px 0px 5px;
            }
            #pimleftmenu ul {
                list-style-type: none;
                padding-left: 0;
                margin-left: 0;
                width: 12em;
            }

            #pimleftmenu ul.pimleftmenu li {
                list-style-type:none;
                margin-left: 0;
                margin-bottom: 1px;
                padding-left:5px;
            }

            #pimleftmenu ul li.parent {
                padding-left: 0px;
                padding-top:4px;
                font-weight: bold;
            }

            #pimleftmenu ul.pimleftmenu li a {
                display:block;
                outline: 0;
                padding: 2px 2px 2px 4px;
                text-decoration: none;
                background:#FAD163 none repeat scroll 0 0;
                border-color:#CD8500 #8B5A00 #8B5A00 #CD8500;
                border-style:solid;
                border-width:1px;
                color:#d87415;
                font-size: 11px;
                font-weight:bold;
                text-align: left;
            }
            #pimleftmenu ul.pimleftmenu li a:hover {
                color: #FFFBED;
                background-color: #e88d1e;
            }

            #pimleftmenu ul.pimleftmenu li a.current {
                color: #FFFBED;
                background-color: #e88d1e;
            }

            #pimleftmenu ul.pimleftmenu li a.collapsed,
            #pimleftmenu ul.pimleftmenu li a.expanded {
                display:block;
                outline: 0;
                padding: 2px 2px 2px 4px;
                text-decoration: none;
                border: 0 ;
                color: #CC6600;
                font-size: 11px;
                font-weight:bold;
                text-align: left;
            }

            #pimleftmenu ul.pimleftmenu li a.expanded {
                background: #FFFBED url(<?php echo public_path("../../themes/orange/icons/expanded.gif"); ?>) no-repeat center right;
            }

            #pimleftmenu ul.pimleftmenu li a.collapsed {
                background: #FFFBED url(<?php echo public_path("../../themes/orange/icons/collapsed.gif"); ?>) no-repeat center right;
                border-bottom: 1px solid #d87415;
            }

            #pimleftmenu ul.pimleftmenu li a.collapsed:hover span,
            #pimleftmenu ul.pimleftmenu li a.expanded:hover span {
                color: #8d4700;
            }


            #pimleftmenu ul span {
                display:block;
            }

            #pimleftmenu li.parent span.parent {
                color: #CC6600;
            }

            #pimleftmenu ul span span {
                display:inline;
                text-decoration:underline;
            }

            div.requirednotice {
                margin-left: 15px;
            }

            #parentPaneDependents {
                float:left;
                width: 50%;
            }

            #parentPaneChildren {
                float:left;
                width: 50%;
            }

            /** Job */
            h3#locationTitle, table#assignedLocationsTable {
                margin-left:10px;
            }

            #jobSpecDuties {
                width:400px;
            }

            /** Dependents */
            div#addPaneDependents {
                width:100%;
            }

            div#addPaneDependents label {
                width: 100px;
            }

            div#addPaneDependents br {
                clear:left;
            }

            div#addPaneDependents input {
                display:block;
                margin: 2px 2px 2px 2px;
                float:left;
            }

            div.formbuttons {
                text-align:left;
            }

            input.hiddenField {
                display:none;
            }

            /* Children */
            div#addPaneChildren {
                width:100%;
            }

            div#addPaneChildren label {
                width: 100px;
            }

            div#addPaneChildren br {
                clear:left;
            }

            div#addPaneChildren input {
                display:block;
                margin: 2px 2px 2px 2px;
                float:left;
            }

            /* education */
            div#editPaneEducation {
                width:100%;
            }

            div#editPaneEducation label {
                width: 200px;
            }

            div#editPaneEducation br {
                clear:left;
            }

            div#editPaneEducation input {
                display:block;
                margin: 2px 2px 2px 2px;
                float:left;
            }

            div#editPaneEducation #educationLabel {
                display:inline;
                font-weight:bold;
                padding-left:2px;
            }

            div.formbuttons {
                text-align:left;
            }

            /* membership */
            label#membershipLabel,
            label#membershipTypeLabel {
                font-weight:bold;
            }

            div#editPaneMemberships {
                width:100%;
            }

            div#editPaneMemberships label {
                width: 200px;
            }

            div#editPaneMemberships br {
                clear:left;
            }

            div#editPaneMemberships input {
                display:block;
                margin: 2px 2px 2px 2px;
                float:left;
            }

            div#editPaneMemberships #membershipTypeLabel,
            div#editPaneMemberships #membershipLabel {
                display:inline;
                font-weight:bold;
                padding-left:2px;
            }

            /* photo */
            #currentImage {
                padding: 2px;
                margin: 14px 4px 14px 8px;
                border: 1px solid #FAD163;
                cursor:pointer;
            }

            #imageSizeRule {
                width:200px;
            }

            #imageHint {
                font-size:10px;
                color:#999999;
                padding-left:8px;
            }



            -->
        </style>


    </head>
    <body>
        <script type="text/javaScript"><!--//--><![CDATA[//><!--
            YAHOO.OrangeHRM.container.init()
    
            //--><!]]></script>

        <div id="cal1Container"></div>
<?php
if ((isset($getArr['capturemode'])) && ($getArr['capturemode'] == 'updatemode')) {
    $first = $employee->firstName;
    $last = $employee->lastName;
    $currentEmployeeName = $first . ' ' . $last;
}
?>
        <div align="right" id="status" style="display: none;"><img src="<?php echo public_path("../../themes/beyondT/icons/loading.gif"); ?>" alt="" width="20" height="20" style="vertical-align:bottom;"/> <span style="vertical-align:text-top"><?php echo __("Loading Page"); ?>...</span></div>

        <div class="navigation">
        <?php if (isset($locRights['ESS']) && !$locRights['ESS']) {
 ?>
                <input type="button" class="backbutton" value="<?php echo __('Back'); ?>" id="backbtn" />
<?php } ?>
        </div>

            <?php
            if (isset($getArr['message'])) {

                $expString = $getArr['message'];
            ?>
        <?php } ?>
        <?php if (isset($getArr['capturemode']) && $getArr['capturemode'] == 'updatemode') {
 ?>

        <?php if ($_SESSION['PIM_MENU_TYPE'] == 'left') {
 ?>
                    <div id="pimleftmenu">
                        <ul class="pimleftmenu">
                            <li class="l1 parent">
                                <a href="#" class="expanded" onclick="showHideSubMenu(this);">
                                    <span class="parent personal"><?php echo __("Personal"); ?></span></a>
                                <ul class="l2">
                                    <li class="l2">
                                        <a href="javascript:displayLayer(1)" id="personalLink" class="personal" accesskey="p">
                                            <span><?php echo __("Personal Details"); ?></span></a></li>
                                    <li class="l2">
                                        <a href="javascript:displayLayer(4)" id="contactsLink" class="personal" accesskey="c">
                                            <span><?php echo __("Contact Details"); ?></span></a></li>
                                    <li class="l2">
                                        <a href="javascript:displayLayer(5)" id="emgcontactsLink" class="personal"  accesskey="e">
                                            <span><?php echo __("Emergency Contacts"); ?></span></a></li>

                                    <li class="l2">
                                        <a href="javascript:displayLayer(3)" id="dependentsLink" class="personal"  accesskey="d">
                                            <span><?php echo __("Dependents"); ?></span></a></li>
                                    <li class="l2">
                                        <a href="javascript:displayLayer(10)" id="immigrationLink" class="personal" accesskey="i" >
                                            <span><?php echo __("Immigration"); ?></span></a></li>
                                    <li class="l2">
                                        <a href="javascript:displayLayer(21)" id="photoLink" class="personal" accesskey="f" >
                                            <span><?php echo __("Photograph"); ?></span></a></li>
                                </ul>
                            </li>
                            <li class="l1 parent">
                                <a href="#" class="expanded" onclick="showHideSubMenu(this);"><span class="parent employment">
<?php echo __("Employment"); ?></span></a>
                                <ul class="l2">
                                    <li class="l2">
                                        <a href="javascript:displayLayer(2)" id="jobLink" accesskey="j" class="employment"  >

                                            <span><?php echo __("Job"); ?></span></a></li>
                        <li class="l2">
                            <a href="javascript:displayLayer(14)" id="paymentsLink" class="employment" accesskey="s" >
                                <span><?php echo __("Salary"); ?></span></a></li>
                        <li class="l2">
                            <a href="javascript:displayLayer(18)" id="taxLink" class="employment" accesskey="t" >
                                <span><?php echo __("Tax Exemptions"); ?></span></a></li>

                        <li class="l2">
                            <a href="javascript:displayLayer(19)" id="direct-debitLink" class="employment" accesskey="o" >
                                <span><?php echo __("Direct Deposit"); ?></span></a></li>
                        <li class="l2">
                            <a href="javascript:displayLayer(15)" id="report-toLink" class="employment" accesskey="r" >
                                <span><?php echo __("Report-to"); ?></span></a></li>
                        <li class="l2">
                            <a href="javascript:displayLayer(23)" id="report-toLink" class="employment" accesskey="r" >
                                <span><?php echo __("Service Record"); ?></span></a></li>
                    </ul>
                </li>
                <li class="l1 parent">
                    <a href="#" class="expanded" onclick="showHideSubMenu(this);">
                        <span class="parent pimqualifications"><?php echo __("Qualifications"); ?></span></a>
                    <ul class="l2">
                        <li class="l2">
                            <a href="javascript:displayLayer(17)" id="work_experienceLink" class="pimqualifications" accesskey="w" >

                                <span><?php echo __("Work experience"); ?></span></a></li>
                        <li class="l2">
                            <a href="javascript:displayLayer(9)" id="educationLink" class="pimqualifications" accesskey="n" >
                                <span><?php echo __("Education"); ?></span></a></li>
                        <li class="l2">
                            <a href="javascript:displayLayer(16)" id="skillsLink" class="pimqualifications" accesskey="k" >
                                <span><?php echo __("Skills"); ?></span></a></li>

                        <li class="l2">
                            <a href="javascript:displayLayer(11)" id="languagesLink" class="pimqualifications" accesskey="g" >
                                <span><?php echo __("Languages"); ?></span></a></li>
                        <li class="l2">
                            <a href="javascript:displayLayer(12)" id="licensesLink" class="pimqualifications" accesskey="l" >
                                <span><?php echo __("License"); ?></span></a></li>
                        <li class="l2">
                            <a href="javascript:displayLayer(22)" id="EbexamLink" class="pimqualifications" accesskey="e" >
                                <span><?php echo __("EB Exam"); ?></span></a></li>

                    </ul>
                </li>
                <li class="l1 parent">
                    <a href="#" class="expanded" onclick="showHideSubMenu(this);"><span class="parent other"><?php echo __("Other"); ?></span></a>
                    <ul class="l2">
                        <li class="l2">
                            <a href="javascript:displayLayer(13)" id="membershipsLink" class="pimmemberships" accesskey="m">
                                <span><?php echo __("Membership"); ?></span>
                            </a>
                        </li>
                        <li class="l2">
                            <a href="javascript:displayLayer(6)" id="attachmentsLink" class="attachments" accesskey="a">
                                <span><?php echo __("Attachments"); ?></span>
                            </a>
                        </li>
                        <li class="l1">
                            <a href="javascript:displayLayer(20)" id="customLink" class="l1_link custom" accesskey="u">
                                <span><?php echo __("Custom"); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
<?php
                }
                $requiredNotice = __('Fields marked with an asterisk #star are required', array('#star' => '<span class="required">*</span>'));
?>
                <div id="servicerec" class="pimpanel formPIM<?php echo ($postArr['pane'] == '23') ? ' currentpanel' : ''; ?>">

                    <div class="outerbox">
                        <div class="mainHeading"><h2><?php echo __("Service Record"); ?></h2></div>
<?php include_partial('servicerec', array('getArr' => $getArr, 'postArr' => $postArr, 'locRights' => $locRights,
                    'employee' => $employee, 'currentPane' => $currentPane, 'userCulture' => $userCulture, 'serviceRec' => $serviceRec)); ?>
                    </div>
                    <br class="clear"/>
                    <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="ebexam" class="pimpanel formPIM<?php echo ($postArr['pane'] == '1') ? ' currentpanel' : ''; ?>">

            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("EB Exam"); ?></h2></div>
<?php include_partial('ebexam', array('getArr' => $getArr, 'postArr' => $postArr, 'locRights' => $locRights,
                    'employee' => $employee, 'currentPane' => $currentPane, 'userCulture' => $userCulture, 'gradeList' => $gradeList, 'serviceList' => $serviceList, 'EBExam' => $EBExam)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="personal" class="pimpanel formPIM<?php echo ($postArr['pane'] == '1') ? ' currentpanel' : ''; ?>">

            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Personal Details"); ?></h2></div>
<?php
                include_partial('personal_details', array('getArr' => $getArr, 'postArr' => $postArr, 'locRights' => $locRights,
                    'employee' => $employee, 'empTitles' => $empTitles, 'genders' => $genders, 'maritalStatusList' => $maritalStatusList,
                    'nationalityList' => $nationalityList, 'ethnicRaceList' => $ethnicRaceList, 'religionList' => $religionList,
                    'languageList' => $languageList, 'countryList' => $countryList, 'currentPane' => $currentPane, 'userCulture' => $userCulture)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>

        <div id="job" class="pimpanel formPIM<?php echo ($postArr['pane'] == '2') ? ' currentpanel' : ''; ?>">

            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Job"); ?></h2></div>
<?php
                include_partial('job', array('getArr' => $getArr, 'postArr' => $postArr,
                    'employee' => $employee, 'locRights' => $locRights, 'popArr' => $popArr, 'currentPane' => $currentPane,
                    'jobTitleList' => $jobTitleList, 'jobCategories' => $jobCategories, 'employeeStatusList' => $employeeStatusList, 'userCulture' => $userCulture, 'empStateList' => $empStateList, 'serviceList' => $serviceList, 'empClassList' => $empClassList, 'gradeList' => $gradeList)); ?>
                <?php $as = 1; ?>
                <?php $as = 1; ?>
                <br class="clear"/>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>

        <div id="dependents" class="pimpanel formPIM<?php echo ($postArr['pane'] == '3') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Dependents"); ?></h2></div>
                <?php include_partial('dependents', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'empRelationships' => $empRelationships, 'locRights' => $locRights, 'userCulture' => $userCulture)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>

        <div id="contacts" class="pimpanel formPIM<?php echo ($postArr['pane'] == '4') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Contact Details"); ?></h2></div>
                <?php include_partial('contact_details', array('getArr' => $getArr, 'postArr' => $postArr, 'locRights' => $locRights,
                    'currentPane' => $currentPane, 'employee' => $employee, 'countries' => $countries, 'provinces' => $provinces, 'empContact' => $empContact, 'country' => $countries, 'userCulture' => $userCulture)); ?>

            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>

        <div id="emgcontacts" class="pimpanel formPIM<?php echo ($postArr['pane'] == '5') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Emergency Contacts"); ?></h2></div>
                <?php include_partial('emergency_contacts', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights, 'userCulture' => $userCulture, 'mode' => $mode)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="attachments" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '6') ? 'currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Attachments"); ?></h2></div>
                <?php
                include_partial('attachments', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights, 'popArr' => $popArr,
                    'attachmentList' => $attachmentList, 'userCulture' => $userCulture, 'attachmentTypeList' => $attachmentTypeList));
                ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="education" class="pimpanel formPIM<?php echo ($postArr['pane'] == '9') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Education"); ?></h2></div>
<?php include_partial('education', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'userCulture' => $userCulture, 'locRights' => $locRights, 'unassignedEducationList' => $unassignedEducationList)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="immigration" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '10') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Immigration"); ?></h2></div>
<?php include_partial('immigration', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights, 'countries' => $countries)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="languages" class="pimpanel formPIM<?php echo ($postArr['pane'] == '11') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Languages"); ?></h2></div>
<?php include_partial('languages', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'userCulture' => $userCulture, 'locRights' => $locRights, 'languages' => $languages)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="licenses" class="pimpanel formPIM<?php echo ($postArr['pane'] == '12') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("License"); ?></h2></div>
<?php include_partial('licenses', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights, 'userCulture' => $userCulture)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="memberships" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '13') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Membership"); ?></h2></div>
                <?php
                include_partial('membership', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights, 'membershipList' => $membershipList,
                    'membershipTypeList' => $membershipTypeList));
                ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="payments" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '14') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Salary"); ?></h2></div>
<?php
                include_partial('payment', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights, 'salaryGradeList' => $salaryGradeList,
                    'payPeriodList' => $payPeriodList, 'unAssignedCurrencyList' => $unAssignedCurrencyList));
?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="report-to" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '15') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Report-to"); ?></h2></div>
<?php include_partial('report_to', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights, 'userCulture' => $userCulture)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="skills" class="pimpanel formPIM<?php echo ($postArr['pane'] == '16') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Skills"); ?></h2></div>
<?php include_partial('skills', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'userCulture' => $userCulture, 'locRights' => $locRights, 'unassignedSkills' => $unassignedSkills)); ?>

            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="work-experiance" class="pimpanel formPIM<?php echo ($postArr['pane'] == '17') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Work Experience"); ?></h2></div>
<?php include_partial('work_experience', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'userCulture' => $userCulture, 'locRights' => $locRights)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="tax" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '18') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Tax Exemptions"); ?></h2></div>
<?php include_partial('tax', array('getArr' => $getArr, 'postArr' => $postArr, 'locRights' => $locRights, 'currentPane' => $currentPane,
                    'employee' => $employee, 'states' => $provinces)); ?>

            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="direct-debit" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '19') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Direct Deposit"); ?></h2></div>
<?php include_partial('direct_debit', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="custom" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '20') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Custom"); ?></h2></div>
<?php include_partial('custom_fields', array('getArr' => $getArr, 'postArr' => $postArr, 'currentPane' => $currentPane,
                    'employee' => $employee, 'locRights' => $locRights, 'customFieldList' => $customFieldList)); ?>
            </div>
            <br class="clear"/>
            <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
        </div>
        <div id="photo" class="pimpanel formpage2col<?php echo ($postArr['pane'] == '21') ? ' currentpanel' : ''; ?>">
            <div class="outerbox">
                <div class="mainHeading"><h2><?php echo __("Photograph"); ?></h2></div>
<?php include_partial('photo', array('getArr' => $getArr, 'postArr' => $postArr, 'locRights' => $locRights, 'currentPane' => $currentPane,
                    'employee' => $employee, 'userCulture' => $userCulture)); ?>
                    </div>
                    <br class="clear"/>
                    <div class="requirednotice"><?php echo $requiredNotice; ?>.</div>
                </div>

<?php } ?>

            <script type="text/javaScript"><!--//--><![CDATA[//><!--
                if (document.getElementById && document.createElement) {
                    roundBorder('outerbox');
                }

                displayLayer(<?php echo isset($currentPane) ? $currentPane : '1'; ?>);
<?php if (isset($postArr['txtShowAddPane']) && !empty($postArr['txtShowAddPane'])) { ?>
                    showAddPane('<?php echo $postArr['txtShowAddPane']; ?>');
<?php } ?>
                $(document).ready(function() {

                    $('#backbtn').click(function() {
                        location.href="<?php echo url_for('pim/list') ?>";
                });

                // TODO: move to separate ready() functions in the different templates
                setupJobsalDetails();
                setupPersonalDetails();
                setupContactDetails();
                setupEmergencyContacts();
                setupDependents();
                setupLanguages();
                setupWorkExperience();
                setupSkills();
                setupEducation();
                setupLicense();
                setupReportTo();
                setupPhoto();
                setupAttachments();
                setupEBExam();
                setupServiceRecord();

                setupJobHistory();
                setupContracts();
                setupTax();
                setupMemberships();
                setupPayment();
                setupDirectDebit();
                setupImmigration();
                setupChildren();
                setupCustomFields();
        

            });
            //--><!]]></script>
    </body>
</html>
