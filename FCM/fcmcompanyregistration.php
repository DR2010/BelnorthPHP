<?php
    /*
    Construction Outcomes Client Data Entry
    Date: 03-Mar-2018

    */
    get_header();

    // $db_hostname = 'localhost';
    // $db_username = 'fcmuser';
    // $db_password = 'fcmpassword';
    // $db_database = 'fcmschema';

    $db_hostname = 'localhost';
    $db_username = 'danieladmin';
    $db_password = 'oculos18';
    $db_database = 'fcmschema';
    
    // Database Connection String
    $mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_database);

    /* check connection */
    if ($mysqli ->connect_errno) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <script language=JavaScript>
            function setSelectedValue(selectObj, valueToSet) 
            {
                for (var i = 0; i < selectObj.options.length; i++) {
                    if (selectObj.options[i].value == valueToSet) {
                        selectObj.options[i].selected = true;
                        return;
                     }
                }
            }

        </script>    

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <style>
            input[type=text] {
                width: 80%;
            }
            input[type=email] {
                width: 80%;
            }
            select {
                width: 80%;
            }
        </style> 

    </head>

    <body>
        <?php
        
            $austbusnumber         = $_POST['austbusnumber'];
            $tradingname           = $_POST['tradingname'];
            $legalname             = $_POST['legalname'];
            $managingdirector      = $_POST['managingdirector'];
            $projectmanager        = $_POST['projectmanager'];
            $projectrepresentative = $_POST['projectrepresentative'];
            $whsauditor            = $_POST['whsauditor'];
            $companyaddress        = $_POST['companyaddress'];
            $companyphone          = $_POST['companyphone'];
            $companyfax            = $_POST['companyfax'];
            $companymobile         = $_POST['companymobile'];
            $emailaddress          = $_POST['emailaddress'];
            $systemsmanager        = $_POST['systemsmanager'];
            $sitemanager           = $_POST['sitemanager'];
            $supervisor            = $_POST['supervisor'];
            $leadinghand1          = $_POST['leadinghand1'];
            $leadinghand2          = $_POST['leadinghand2'];
            $hsrepresentative      = $_POST['hsrepresentative'];
            $adminperson           = $_POST['adminperson'];
            $datepolicy            = $_POST['datepolicy'];
            $wccoordinator         = $_POST['wccoordinator'];
            $scopeofservices       = $_POST['scopeofservices'];
            $actionplandate        = $_POST['actionplandate'];
            $certificationtargetdate = $_POST['certificationtargetdate'];
            $timetrading           = $_POST['timetrading'];
            $regionsofoperation    = $_POST['regionsofoperation'];
            $seniormanagementmeeting = $_POST['seniormanagementmeeting'];
            $operationmeetingsfreq   = $_POST['operationmeetingsfreq'];
            $projectmeetingsfreq     = $_POST['projectmeetingsfreq'];
            $contactperson           = $_POST['contactperson'];

            class Company
            {   

                var $tradingname;
                var $abn;
                var $legalname;
                var $managingdirector;
                var $projectmanager;
                var $projectrepresentative;
                var $whsauditor;
                var $companyaddress;
                var $companyphone;
                var $companyfax;
                var $companymobile;
                var $emailaddress;
                var $systemsmanager;
                var $sitemanager;
                var $supervisor;
                var $leadinghand1;
                var $leadinghand2;
                var $hsrepresentative;
                var $adminperson;
                var $datepolicy;
                var $wccoordinator;
                var $scopeofservices;
                var $actionplandate;
                var $certificationtargetdate;
                var $timetrading;
                var $regionsofoperation;
                var $seniormanagementmeeting;
                var $operationmeetingsfreq;
                var $projectmeetingsfreq;
                var $contactperson;

            }



            if ($austbusnumber != "" )
            {
                $company = new Company();

                $company->tradingname = $tradingname;
                $company->austbusnumber = $austbusnumber;
                $company->legalname = $legalname;
                $company->managingdirector = $managingdirector;
                $company->projectmanager = $projectmanager;
                $company->projectrepresentative = $projectrepresentative;
                $company->whsauditor = $whsauditor;
                $company->companyaddress = $companyaddress;
                $company->companyphone = $companyphone;
                $company->companyfax = $companyfax; 
                $company->companymobile = $companymobile;
                $company->emailaddress = $emailaddress;
                $company->systemsmanager = $systemsmanager;
                $company->sitemanager =$sitemanager;
                $company->supervisor = $supervisor;
                $company->leadinghand1 = $leadinghand1;
                $company->leadinghand2 = $leadinghand2;
                $company->hsrepresentative = $hsrepresentative;
                $company->adminperson = $adminperson;
                $company->datepolicy = $datepolicy; 
                $company->wccoordinator = $wccoordinator;
                $company->scopeofservices = $scopeofservices;
                $company->actionplandate = $actionplandate;
                $company->certificationtargetdate = $certificationtargetdate;
                $company->timetrading = $timetrading;
                $company->regionsofoperation = $regionsofoperation;
                $company->seniormanagementmeeting =$seniormanagementmeeting;
                $company->operationmeetingsfreq = $operationmeetingsfreq;
                $company->projectmeetingsfreq = $projectmeetingsfreq;
                $company->contactperson = $contactperson;

                addcompanyregistration( $company ); 
            }

            echo "<form method=post name=f1 action='' >";

            // @* (01) Business/ Trading Name *@
            echo '<p>Business/ Trading Name:</p>';
            echo '<input type="text" name="tradingname" id="tradingname" required>';
            echo "<p/>";

            //  @* (02) ABN (austbusnumber) *@
            echo "<p>ABN:</p> ";
            echo "<input type='text' name='austbusnumber' id='austbusnumber'  required>";
            echo "<p/>";

            // @* (3) Legal Name *@
            echo "<p>Legal Name:</p>";
            echo '<input type="text" name="legalname" id="legalname" required>';
            echo "<p/>";

            // @* (4) Managing Director MD1 *@
            echo "<p>Managing Director (MD1):</p>";
            echo '<input type="text" name="managingdirector" id="managingdirector" required>';
            echo "<p/>";

            // @* (5) Project Manager PM1 *@
            echo "<p>Project Manager (PM1):</p>";
            echo '<input type="text" name="projectmanager" id="projectmanager" required>';
            echo "<p/>";

            // @* (6) Project OHSE Representative POHSEREP *@
            echo "<p>Project WHS Representative:</p>";
            echo '<input type="text" name="projectrepresentative" id="projectrepresentative" required>';
            echo "<p/>";

            // @* (7) OHSE Auditor OHSEAUDITOR *@
            echo "<p>WHS Auditor:</p>";
            echo '<input type="text" name="whsauditor" id="whsauditor" required>';
            echo "<p/>";

            // @* (8) Company Address *@
            echo "<p>Company Physical Address:</p>";
            echo '<input type="text" name="companyaddress" id="companyaddress" required>';
            echo "<p/>";

            // @* (9) Company Phone *@
            echo "<p>Company Phone:</p>";
            echo '<input type="text" name="companyphone" id="companyphone" required>';
            echo "<p/>";

            // @* (10) Company Fax *@
            echo "<p>Company Fax:</p>";
            echo '<input type="text" name="companyfax" id="companyfax" required>';
            echo "<p/>";

            // @* (11) Company Mobile *@
            echo "<p>Company Mobile:</p>";
            echo '<input type="text" name="companymobile" id="companymobile" required>';
            echo "<p/>";

            // @* (12) Email Address *@
            echo "<p>Email Address:</p>";
            echo '<input type="email" name="emailaddress" id="emailaddress" required>';
            echo "<p/>";

            // @* (13) Systems Manager SMN1 *@
            echo "<p>Systems Manager:</p>";
            echo '<input type="text" name="systemsmanager" id="systemsmanager" required>';
            echo "<p/>";

            // @* (14) Site Manager SM1 *@
            echo "<p>Site Manager:</p>";
            echo '<input type="text" name="sitemanager" id="sitemanager" required>';
            echo "<p/>";

            // @* (15) Supervisor SUP1 *@
            echo "<p>Supervisor:</p>";
            echo '<input type="text" name="supervisor" id="supervisor" required>';
            echo "<p/>";

            // @* (16)  Leading Hand 1 LEADHAND1 *@
            echo "<p>Leading Hand 1:</p>";
            echo '<input type="text" name="leadinghand1" id="leadinghand1" required>';
            echo "<p/>";

            // @* (17) Leading Hand 2 LEADHAND2*@
            echo "<p>Leading Hand 2:</p>";
            echo '<input type="text" name="leadinghand2" id="leadinghand2" required>';
            echo "<p/>";

            // @* (18)  Health and Safety Representative HSR1*@
            echo "<p>Work Health and Safety Representative :</p>";
            echo '<input type="text" name="hsrepresentative" id="hsrepresentative" required>';
            echo "<p/>";

            // @* (19) Administration Person ADMIN *@
            echo "<p>Administration Person:</p>";
            echo '<input type="text" name="adminperson" id="adminperson" required>';
            echo "<p/>";

            // @* (20) Date to enter on policies *@
            echo "<p>Date to enter on policies:</p>";
            echo '<input type="date" name="datepolicy" id="datepolicy" required>';
            echo "<p/>";

            // @* (21) Workers Compensation Coordinator*@
            echo "<p>Workers Compensation Coordinator:</p>";
            echo '<input type="text" name="wccoordinator" id="wccoordinator" required>';
            echo "<p/>";

            // @* (22) Scope of Services *@
            echo "<p>Scope of Services:</p>";
            echo '<input type="text" name="scopeofservices" id="scopeofservices" required>';
            echo "<p/>";

            // @* (23) Action plan date *@
            echo "<p>Action plan date:</p>";
            echo '<input type="date" name="actionplandate" id="actionplandate" required>';
            echo "<p/>";

            // @* (24) Certification Target Date *@
            echo "<p>Certification Target Date:</p>";
            echo '<input type="date" name="certificationtargetdate" id="certificationtargetdate" required>';
            echo "<p/>";

            // @* (25) Time Company has been Trading *@
            echo "<p>Time Company has been Trading:</p>";
            echo '<input type="text" name="timetrading" id="timetrading" required>';
            echo "<p/>";

            // @*(26) Regions of Operation *@
            echo "<p>Regions of Operation:</p>";
            echo '<input type="text" name="regionsofoperation" id="regionsofoperation" required>';
            echo "<p/>";

            // @*(26.1)  Senior Management Meetings Frequency *@
            echo "<p>Senior Management Review Meetings Frequency:</p>";
            echo '<input type="text" name="seniormanagementmeeting" id="seniormanagementmeeting" required>';
            echo "<p/>";


            // @*(27)  Operation Meetings Frequency *@
            echo "<p>Operation Meetings Frequency:</p>";
            echo '<input type="text" name="operationmeetingsfreq" id="operationmeetingsfreq" required>';
            echo "<p/>";

            // @* (28) Project Meetings Frequency *@
            echo "<p>Project Meetings Frequency:</p>";
            echo '<input type="text" name="projectmeetingsfreq" id="projectmeetingsfreq" required>';
            echo "<p/>";

            // @* (29) Contact Person *@
            echo "<p>Contact Person:</p>";
            echo '<input type="text" name="contactperson" id="contactperson" required>';
            echo "<p/>";
            echo "<p/>";

            echo '<input type=submit value=Submit id="submit">';

            /*
            -----------------------------------------------------------------
            Results Add Player
            -----------------------------------------------------------------
            */
            function addcompanyregistration( $clientfcm )
            {

                echo '<H1>Results</H1>';
                echo '<p/>';
                echo '<b>Email Address: '.$clientfcm->tradingname.'</b>';
                echo '<p/>';
                echo 'Last Name: '.$clientfcm->austbusnumber;
                echo '<p/>';

                $db_hostname = 'localhost';
                $db_username = 'danieladmin';
                $db_password = 'oculos18';
                $db_database = 'fcmschema';

                $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

                $sql =  "REPLACE INTO clientfcm 
                ( 
                    tradingname, 
                    austbusnumber,
                    legalname,
                    managingdirector,
                    projectmanager,
                    projectrepresentative,
                    whsauditor,
                    companyaddress,
                    companyphone,
                    companyfax,
                    companymobile,
                    emailaddress,
                    systemsmanager,
                    sitemanager,
                    supervisor,
                    leadinghand1,
                    leadinghand2,
                    hsrepresentative,
                    adminperson,
                    datepolicy,
                    wccoordinator,
                    scopeofservices,
                    actionplandate,
                    certificationtargetdate,
                    timetrading,
                    regionsofoperation,
                    seniormanagementmeeting,
                    operationmeetingsfreq,
                    projectmeetingsfreq,
                    contactperson
                ) 
                        VALUES (
                       '".$clientfcm->tradingname.
                    "','".$clientfcm->austbusnumber.
                    "','".$clientfcm->legalname.
                    "','".$clientfcm->managingdirector.
                    "','".$clientfcm->projectmanager.
                    "','".$clientfcm->projectrepresentative.
                    "','".$clientfcm->whsauditor.
                    "','".$clientfcm->companyaddress.
                    "','".$clientfcm->companyphone.
                    "','".$clientfcm->companyfax.
                    "','".$clientfcm->companymobile.
                    "','".$clientfcm->emailaddress.
                    "','".$clientfcm->systemsmanager.
                    "','".$clientfcm->sitemanager.
                    "','".$clientfcm->supervisor.
                    "','".$clientfcm->leadinghand1.
                    "','".$clientfcm->leadinghand2.
                    "','".$clientfcm->hsrepresentative.
                    "','".$clientfcm->adminperson.
                    "','".$clientfcm->datepolicy.
                    "','".$clientfcm->wccoordinator.
                    "','".$clientfcm->scopeofservices.
                    "','".$clientfcm->actionplandate.
                    "','".$clientfcm->certificationtargetdate.
                    "','".$clientfcm->timetrading.
                    "','".$clientfcm->regionsofoperation.
                    "','".$clientfcm->seniormanagementmeeting.
                    "','".$clientfcm->operationmeetingsfreq.
                    "','".$clientfcm->projectmeetingsfreq.
                    "','".$clientfcm->contactperson.
                "')";

                // echo $sql;

                if ( $clientfcm->tradingname== "" || $clientfcm->austbusnumber == "" || $clientfcm->legalname == "" )
                {
                    // do nothing
                    echo 'Error during registration. Please contact Construction Outcomes </p>';
                    echo $sql;
                }
                else
                {
                    if ($mysqli->query($sql) === TRUE) {

                        echo '<H2>Registration created successfully.</H2>';

                    } else {
                        echo "Registration UNSUCCESSFUL - Contact Construction Outcomes with error: " . $mysqli->error;

                        echo "<p/>";
                        echo "SQL Statement:";
                        echo "<p/>";
                        echo $sql;
                    }
                }

                $mysqli->close();
            }

            echo "</form>";
        ?>
    </body>
</html>
