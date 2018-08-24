<?php
    /*
    Construction Outcomes Client Data Entry
    Date: 03-Mar-2018

    UID bigint(20) NOT NULL,
    Name varchar(200) NOT NULL,
    LegalName varchar(200) DEFAULT NULL,
    Address varchar(200) DEFAULT NULL,
    Mobile varchar(50) DEFAULT NULL,
    Phone varchar(50) DEFAULT NULL,
    Fax varchar(50) DEFAULT NULL,
    MainContactPersonName` varchar(50) DEFAULT NULL,
    EmailAddress varchar(200) DEFAULT NULL,
    ABN varchar(20) DEFAULT NULL,

    Criar a single table com as informacoes abaixo. Nao precisar ser varias tabelas, relationship, and all that BS

            @* Contractor Size - Dropdown *@
        @* (01) Business/ Trading Name *@
        @* (2) ABN *@
        @* (3) Legal Name *@
        @* (4) Managing Director MD1 *@
        @* (5) Project Manager PM1 *@
        @* (6) Project OHSE Representative POHSEREP *@
        @* (7) OHSE Auditor OHSEAUDITOR *@
        @* (8) Company Address *@
        @* (9) Company Phone *@
        @* (10) Company Fax *@
        @* (11) Company Mobile *@
        @* (12) Email Address *@
        @* (13) Systems Manager SMN1 *@
        @* (14) Site Manager SM1 *@
        @* (15) Supervisor SUP1 *@
        @* (16)  Leading Hand 1 LEADHAND1 *@
        @* (17) Leading Hand 2 LEADHAND2*@
        @* (18)  Health and Safety Representative HSR1*@
        @* (19) Administration Person ADMIN *@
        @* (20) Date to enter on policies *@
        @* (21) Workers Compensation Coordinator*@
        @* (22) Scope of Services *@
        @* (23) Action plan date *@
        @* (24) Certification Target Date *@
        @* (25) Time Company has been Trading *@
        @*(26) Regions of Operation *@
        @*(27)  Operation Meetings Frequency *@
        @* Project Meetings Frequency *@
        @* Contact Person *@



    */
    get_header();

    $db_hostname = 'localhost';
    $db_username = 'fcmuser';
    $db_password = 'fcmpassword';
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

            function showappropriatefields( invalue )
            {
                var agegroupselected = document.getElementById("agegroup");

                var divteamname = document.getElementById("divteamname");
                var divteamcolour = document.getElementById("divteamcolour");
                var divteamdivision = document.getElementById("divteamdivision");
                var divopengirls = document.getElementById("divopengirls");

                divteamname.style.display = "none";
                divteamcolour.style.display = "none";
                divteamdivision.style.display = "none";
                divopengirls.style.display = "none";

                if ( agegroupselected.value == "U5"         || 
                     agegroupselected.value == "U6"         ||
                     agegroupselected.value == "U7"         ||
                     agegroupselected.value == "U8"         ||
                     agegroupselected.value == "U9"         ||
                     agegroupselected.value == "U6-7 Girls" ||
                     agegroupselected.value == "U8-9 Girls" )
                {
                    divteamname.style.display = "block";
                    divteamcolour.style.display = "none";
                    divteamdivision.style.display = "none";
                    divopengirls.style.display = "none";
                }

                if ( agegroupselected.value == "U10" || 
                     agegroupselected.value == "U11" )
                {
                    divteamname.style.display = "none";
                    divteamcolour.style.display = "block";
                    divteamdivision.style.display = "none";
                    divopengirls.style.display = "block";
                }

                if ( agegroupselected.value == "U12" || 
                     agegroupselected.value == "U13" ||
                     agegroupselected.value == "U14" ||
                     agegroupselected.value == "U15" ||
                     agegroupselected.value == "U16" ||
                     agegroupselected.value == "U18" )
                {
                    divteamname.style.display = "none";
                    divteamcolour.style.display = "none";
                    divteamdivision.style.display = "block";
                    divopengirls.style.display = "block";
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

            // Competition
            // $competitionmanualid = "NORTHERNSTRIKETOURNAMENT2018";

/*
            1. Competition Name 
            2. Email Address
            3. Last Name
            4. First Name
            5. Mobile Number     
            6. Role (Coach/Manager)
            7. Gender:Male/Female/Other
            8. Age group: 
            9. Team Name  (U5..U9)
            10. Team Colour (U10..U11)
            11. Open / Girls (U10..U11) (U12..U18)
            12. Division (U12..U18)
  */      

           $competitionmanualid = $_POST['competition'];
  // Coach Manager Details
            $emailaddress = $_POST['emailaddress'];
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $mobile = $_POST['mobile'];
            $role = $_POST['role'];
            $gender = $_POST['gender'];
            $agegroup = $_POST['agegroup'];
            $teamname = $_POST['teamname'];
            $teamcolour = $_POST['teamcolour'];
            $opengirls = $_POST['opengirls'];
            $teamdivision = $_POST['teamdivision'];

            // read only
            class Competition
            {   
                var $competitionid;
                var $competitionmanualid;
                var $name;
                var $year;
                var $month;
                var $type;
            }

            // update/ insert
            class CoachManagerDetails
            {   
                var $fkcompetitionmanualid;
                var $emailaddress;
                var $lastname;
                var $firstname;
                var $mobile;
                var $role;
                var $gender;
                var $agegroup;
                var $teamname;
                var $teamcolour;
                var $opengirls;
                var $teamdivision;

            }


            if ($emailaddress != "" )
            {
                $coachmanagerdetails = new CoachManagerDetails();

                $coachmanagerdetails->fkcompetitionmanualid = $competitionmanualid;
                $coachmanagerdetails->emailaddress = $emailaddress; 
                $coachmanagerdetails->lastname = $lastname; 
                $coachmanagerdetails->firstname = $firstname; 
                $coachmanagerdetails->mobile = $mobile; 
                $coachmanagerdetails->role = $role; 
                $coachmanagerdetails->gender = $gender; 
                $coachmanagerdetails->agegroup = $agegroup; 
                $coachmanagerdetails->teamname = $teamname; 
                $coachmanagerdetails->teamcolour = $teamcolour; 
                $coachmanagerdetails->opengirls = $opengirls; 
                $coachmanagerdetails->teamdivision = $teamdivision; 
              
                addcoachmanagerdetails( $coachmanagerdetails ); 
            }

            echo "<form method=post name=f1 action='' >";

            // @* (01) Business/ Trading Name *@
            echo "<p>Business/ Trading Name:</p>";
            echo '<input type="text" name="tradingname" id="tradingname" required>';
            echo "<p/>";

            //  @* (02) ABN *@
            echo "<p>ABN:</p> ";
            echo "<input type='text' name='abn' id='abn'  required>";
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
            echo "<p>Project OHSE Representative:</p>";
            echo '<input type="text" name="projectrepresentative" id="projectrepresentative" required>';
            echo "<p/>";

            // @* (7) OHSE Auditor OHSEAUDITOR *@
            echo "<p>OHSE Auditor:</p>";
            echo '<input type="text" name="ohseauditor" id="ohseauditor" required>';
            echo "<p/>";

            // @* (8) Company Address *@
            echo "<p>Company Address:</p>";
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
            echo '<input type="text" name="emailaddress" id="emailaddress" required>';
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
            echo "<p>Health and Safety Representative :</p>";
            echo '<input type="text" name="hsrepresentative" id="hsrepresentative" required>';
            echo "<p/>";

            // @* (19) Administration Person ADMIN *@
            echo "<p>Administration Person:</p>";
            echo '<input type="text" name="adminperson" id="adminperson" required>';
            echo "<p/>";

            // @* (20) Date to enter on policies *@
            echo "<p>Date to enter on policies:</p>";
            echo '<input type="text" name="datepolicy" id="datepolicy" required>';
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
            echo '<input type="text" name="actionplandate" id="actionplandate" required>';
            echo "<p/>";

            // @* (24) Certification Target Date *@
            echo "<p>Certification Target Date:</p>";
            echo '<input type="text" name="certificationtargetdate" id="certificationtargetdate" required>';
            echo "<p/>";

            // @* (25) Time Company has been Trading *@
            echo "<p>Time Company has been Trading:</p>";
            echo '<input type="text" name="timetrading" id="timetrading" required>';
            echo "<p/>";

            // @*(26) Regions of Operation *@
            echo "<p>Regions of Operation:</p>";
            echo '<input type="text" name="regionsofoperation" id="regionsofoperation" required>';
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

            echo "<p>Role:</p> ";
            echo "<select name='role' id='role'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="COACH">Coach</option>';
            echo '            <Option value="MANAGER">Manager</option>';
            echo '            <Option value="OTHER">Other</option>';
            echo "            </select>";
            echo "<p/>";

            echo "<p/>";

            echo '<input type=submit value=Submit id="submit">';

            /*
            -----------------------------------------------------------------
            Results Add Player
            -----------------------------------------------------------------
            */
            function addcoachmanagerdetails( $coachmanagerdetails )
            {
                echo '<H1>Results</H1>';
                echo '<p/>';
                echo '<b>Email Address: '.$coachmanagerdetails->emailaddress.'</b>';
                echo '<p/>';
                echo 'Last Name: '.$coachmanagerdetails->lastname;
                echo '<p/>';

                $db_hostname = 'localhost';
                $db_username = 'belnorth_machado';
                $db_password = 'M@ch@d)';
                $db_database = 'belnorth_players';

                $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

                $sql =  "REPLACE INTO coachmanagerdetails 
                ( fkcompetitionmanualid, emailaddress, lastname, firstname, mobile, role, gender, agegroup, teamname, teamcolour, teamdivision, opengirls ) 
                        VALUES ('" 
                         .$coachmanagerdetails->fkcompetitionmanualid. 
                    "','".$coachmanagerdetails->emailaddress. 
                    "','".$coachmanagerdetails->lastname. 
                    "','".$coachmanagerdetails->firstname. 
                    "','".$coachmanagerdetails->mobile. 
                    "','".$coachmanagerdetails->role. 
                    "','".$coachmanagerdetails->gender. 
                    "','".$coachmanagerdetails->agegroup. 
                    "','".$coachmanagerdetails->teamname. 
                    "','".$coachmanagerdetails->teamcolour. 
                    "','".$coachmanagerdetails->teamdivision. 
                    "','".$coachmanagerdetails->opengirls. 

                "')";

                if ( $coachmanagerdetails->fkcompetitionmanualid== "" || $coachmanagerdetails->emailaddress == "" || $coachmanagerdetails->lastname == "" )
                {
                    // do nothing
                    echo 'Error during registration. Please contact the club </p>';
                    echo $sql;
                }
                else
                {
                    if ($mysqli->query($sql) === TRUE) {

                        echo '<H2>Registration created or updated successfully.</H2>';

                    } else {
                        echo "Registration UNSUCCESSFUL - Contact Club with error: " . $mysqli->error;

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
