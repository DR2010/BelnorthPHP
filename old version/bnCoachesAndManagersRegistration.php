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

        </script>    

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <style>
            input[type=text] {
                width: 80%;
                font-size:16px;
            }
            input[type=email] {
                width: 80%;
                font-size:16px;
            }
            select {
                width: 80%;
                font-size:16px;
            }
        </style> 

    </head>

    <body>
        <?php

            // Competition
            // $competitionmanualid = "NORTHERNSTRIKETOURNAMENT2018";
            $competitionmanualid = $_POST['competition'];

/*
            1. Competition Name 
            2. Email Address
            3. Last Name
            4. First Name
            5. Mobile Number     
            6. Team Name
            7. Role (Coach/Manager)
            8. Gender:Male/Female/Other
            9. Age group: 
  */      

            // Coach Manager Details
            $emailaddress = $_POST['emailaddress'];
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $mobile = $_POST['mobile'];
            $teamname = $_POST['teamname'];
            $role = $_POST['role'];
            $gender = $_POST['gender'];
            $agegroup = $_POST['agegroup'];

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
                var $teamname;
                var $role;
                var $gender;
                var $agegroup;

            }


            if ($emailaddress != "" )
            {
                $coachmanagerdetails = new CoachManagerDetails();

                $coachmanagerdetails->fkcompetitionmanualid = $competitionmanualid;
                $coachmanagerdetails->emailaddress = $emailaddress; 
                $coachmanagerdetails->lastname = $lastname; 
                $coachmanagerdetails->firstname = $firstname; 
                $coachmanagerdetails->mobile = $mobile; 
                $coachmanagerdetails->teamname = $teamname; 
                $coachmanagerdetails->role = $role; 
                $coachmanagerdetails->gender = $gender; 
                $coachmanagerdetails->agegroup = $agegroup; 
              
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

            echo "<p>Team Name:</p> ";
            echo "<select name='teamname' id='teamname'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="U12DIV1">U12DIV1</option>';
            echo '            <Option value="U12DiV2">U12DiV2</option>';
            echo '            <Option value="U15DIV1">U15DIV1</option>';
            echo '            <Option value="U15DIV2">U15DIV2</option>';
            echo '            <Option value="Other">Other</option>';
            echo "            </select>";
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
            echo "<select name='agegroup' id='agegroup'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="U8">U8</option>';
            echo '            <Option value="U9">U9</option>';
            echo '            <Option value="U10">U10</option>';
            echo '            <Option value="U11">U11</option>';
            echo '            <Option value="U13">U13</option>';
            echo '            <Option value="U14">U14</option>';
            echo '            <Option value="U15">U15</option>';
            echo '            <Option value="O">Other</option>';
            echo '            </select>';
            echo '<p/>';

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
                ( fkcompetitionmanualid, emailaddress, lastname, firstname, mobile, teamname, role, gender, agegroup) 
                        VALUES ('" 
                         .$coachmanagerdetails->fkcompetitionmanualid. 
                    "','".$coachmanagerdetails->emailaddress. 
                    "','".$coachmanagerdetails->lastname. 
                    "','".$coachmanagerdetails->firstname. 
                    "','".$coachmanagerdetails->mobile. 
                    "','".$coachmanagerdetails->teamname. 
                    "','".$coachmanagerdetails->role. 
                    "','".$coachmanagerdetails->gender. 
                    "','".$coachmanagerdetails->agegroup. 

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
