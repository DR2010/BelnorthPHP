<?php
    /*
    Template Name: Coaches and Managers Registration
    Date: 03-Mar-2018
    Requested by: Dea

    0. Competition Name 
    1. Club Name
    2. Email Address
    3. Last Name
    4. First Name
    5. Mobile Number     
    6. Team Name
    7. Role (Coach/Manager)
    8. Gender:Male/Female/Other
    9. Age group: 
    */
    get_header();

    $db_hostname = 'localhost';
    $db_username = 'belnorth_machado';
    $db_password = 'M@ch@d)';
    $db_database = 'belnorth_players';
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

                /*
                $coachmanagerdetails->fkcompetitionmanualid = $fkcompetitionmanualid;
                $coachmanagerdetails->emailaddress = $emailaddress; 
                $coachmanagerdetails->lastname = $lastname; 
                $coachmanagerdetails->firstname = $firstname; 
                $coachmanagerdetails->mobile = $mobile; 
                $coachmanagerdetails->teamname = $teamname; 
                $coachmanagerdetails->role = $role; 
                $coachmanagerdetails->gender = $gender; 
                $coachmanagerdetails->agegroup = $agegroup; 
                */

            echo "<b>";
            echo "<p>Competition:</p> ";
            echo "<select name='competition' id='competition'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="WINTER2018">Winter 2018</option>';
            echo "            </select>";
            echo "</b>";
            echo "<p/>";

            echo "<p>Email Address:</p> ";
            echo "<input type='email' name='emailaddress' id='emailaddress'  required>";
            echo "<p/>";

            echo "<p>Last Name:</p>";
            echo '<input type="text" name="lastname" id="lastname" class="w3-input" required>';
            echo "<p/>";

            echo "<p>First Name:</p>";
            echo "<input type='text' name='firstname' id= 'firstname'  required>";
            echo "<p/>";

            echo "<p>Mobile Number:</p> ";
            echo "<input type='text' name='mobile' id='mobile'  required>";
            echo "<p/>";

            echo "<p>Role:</p> ";
            echo "<select name='role' id='role'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="COACH">Coach</option>';
            echo '            <Option value="MANAGER">Manager</option>';
            echo '            <Option value="OTHER">Other</option>';
            echo "            </select>";
            echo "<p/>";

            echo "<p>Gender:</p> ";
            echo "<select name='gender' id='gender' required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="M">Male</option>';
            echo '            <Option value="F">Female</option>';
            echo '            <Option value="O">Other</option>';
            echo "            </select>";
            echo "<p/>";

            echo "<p>Age Group:</p>";
            echo "<select name='agegroup' id='agegroup' onchange='showappropriatefields(this.value)' required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="U5">U5</option>';
            echo '            <Option value="U6">U6</option>';
            echo '            <Option value="U7">U7</option>';
            echo '            <Option value="U6-7 Girls">U6-7 Girls</option>';
            echo '            <Option value="U8">U8</option>';
            echo '            <Option value="U8-9 Girls">U8-9 Girls</option>';
            echo '            <Option value="U9">U9</option>';
            echo '            <Option value="U10">U10</option>';
            echo '            <Option value="U11">U11</option>';
            echo '            <Option value="U12">U12</option>';
            echo '            <Option value="U13">U13</option>';
            echo '            <Option value="U14">U14</option>';
            echo '            <Option value="U15">U15</option>';
            echo '            <Option value="U16">U16</option>';
            echo '            <Option value="U18">U18</option>';
            echo '            </select>';
            echo '<p/>';

            echo "<div id='divteamname'>";
            echo "<p>Team Name:</p> ";
            echo "<input type='text' name='teamname' id='teamname' >";
            echo "<p/>";
            echo "</div>";

            echo "<div id='divteamcolour'>";
                echo "<p>Team Colour:</p> ";
                echo "<input type='text' name='teamcolour' id='teamcolour' >";
                echo "<p/>";
            echo "</div>";

            echo "<div id='divteamdivision'>";
            echo "<p>Team Division:</p> ";
            echo "<input type='text' name='teamdivision' id='teamdivision' >";
            echo "<p/>";
            echo "</div>";

            echo "<div id='divopengirls'>";
            echo "<p>Open or Girls:</p> ";
            echo "<select name='opengirls' id='opengirls'>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="Open">Open</option>';
            echo '            <Option value="Girls">Girls</option>';
            echo "            </select>";
            echo "<p/>";
            echo "</div>";

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
