<?php
    /*
    Template Name: Junior Small Side Game Tournament
    Date: 25-Feb-2018
    Requested by: Jason via email

    1, Club Name, Please have a drop down menu of Belnorth, Belsouth, Belwest, Majura, Gunghalin and Other
    2. Team Name
    3. Shirt colour
    4. Gender:(drop down menu) Boy/Girl/Other
    5. Age group: (drop down menu) 8/9/10/11
    6. Division: Plate (division 1) or social
    7. Team contacts name 
    8. Team Contacts email address
    9. Team contacts Mobile Number
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

            -------------------------------------------------------------
            If Male gender is selected, can only trial for Male.
            -------------------------------------------------------------
            */
            function checkgenderselection()
            {

                var genderselected = document.getElementById("gender");
                var gendertrialobj = document.getElementById("trialopengirls");
                
                if (genderselected.value == "M")
                {
                    if (gendertrialobj.value == "Girls")
                    {
                        window.alert("Boys cannot trial for Girls competition.");
                        gendertrialobj.value = "Open";
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

            // Team Details
            $agegroup = $_POST['agegroup'];
            $fkclubname = $_POST['fkclubname'];
            $idteam = $_POST['teamname'];
            $idteam = strtoupper($idteam);
            $teamname = $_POST['teamname'];
            $teamname = strtoupper($teamname);
            $shirtcolour = $_POST['shirtcolour'];
            $shirtcolour = strtoupper($shirtcolour);
            $division = $_POST['division'];
            $gender = $_POST['gender'];
            $contactname = $_POST['contactname'];
            $emailaddress = $_POST['emailaddress'];
            $mobile = $_POST['mobile'];

            // Registration read input
            $todays_date = date("Y-m-d");
            $registrationdate = $todays_date;
            $status = "ACTIVE";
            //
            // ........................

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
            class Team
            {   
                var $fkagegroupid;
                var $idteam;
                var $teamname;
                var $showindropdown;
                var $division;
                var $fkclubname;
                var $shirtcolour;
                var $gender;
                var $contactname;
                var $emailaddress;
                var $mobile;
            }

            // update/ insert
            class TeamRegistration
            {   
                var $competitionmanualid;
                var $registrationdate;
                var $status;
                var $agegroup;
                var $idteam;
            }
            

            if ($teamname != "" )
            {
                $team = new Team();

                $team->fkagegroupid = $agegroup;
                $team->idteam = $idteam; // team ID 
                $team->teamname = $teamname; // team name
                $team->showindropdown = "Y";
                $team->division = $division;
                $team->fkclubname = $fkclubname;
                $team->shirtcolour = $shirtcolour;
                $team->gender = $gender;
                $team->contactname =  $contactname;
                $team->emailaddress = $emailaddress;
                $team->mobile =  $mobile;

                $registration = new TeamRegistration();
                $registration->competitionmanualid = $competitionmanualid;
                $registration->registrationdate = $registrationdate;
                $registration->status = "Active";
                $registration->agegroup = $agegroup;
                $registration->idteam = $idteam; 

                // if ($registration->agegroupdob == "Not allowed")
                // {
                //     echo '<p/>';
                //     echo("Registration is not valid.");
                //     echo '<p/>';
                //     echo("Only U8-U13 can register for preseason.");
                //     echo '<p/>';
                //     return;
                // }
                // else {
                //     // echo '<p/>';
                //     // echo 'Going ahead';
                //     // echo '<p/>';
                //     addplayerregistration( $player, $registration ); 
                // }
               
                addteamegistration( $team, $registration ); 
            }

            echo "<form method=post name=f1 action='' >";

            echo "<b>";
            echo "<p>Competition:</p> ";
            echo "<select name='competition' id='competition'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="NORTHERNSTRIKETOURNAMENT2018">Northern Strike Tournament</option>';
            echo "            </select>";
            echo "</b>";
            echo "<p/>";

            echo "<p>Club Name:</p> ";
            echo "<select name='fkclubname' id='fkclubname'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="Belnorth">Belnorth</option>';
            echo '            <Option value="Belsouth">Belsouth</option>';
            echo '            <Option value="Belwest">Belwest</option>';
            echo '            <Option value="Majura">Majura</option>';
            echo '            <Option value="Gungahlin">Gungahlin</option>';
            echo '            <Option value="Other">Other</option>';
            echo "            </select>";
            echo "<p/>";

            echo "<p>Team Name:</p>";
            echo '<input type="text" name="teamname" id="teamname" class="w3-input" required>';
            echo "<p/>";

            echo "<p>Shirt colour:</p>";
            echo "<input type='text' name='shirtcolour' id= 'shirtcolour'  required>";
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
            echo '            </select>';
            echo '<p/>';

            echo "<p>Division:</p>";
            echo "<select name='division' id='division'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="PLATE">Plate (div1)</option>';
            echo '            <Option value="SOCIAL">Social</option>';
            echo '            </select>';
            echo '<p/>';

            echo "<p>Team Contact Name:</p> ";
            echo "<input type='text' name= 'contactname' id= 'contactname'  required>";
            echo "<p/>";

            echo "<p>Contact Email Address:</p> ";
            echo "<input type='email' name='emailaddress' id='emailaddress'  required>";
            echo "<p/>";

            echo "<p>Contact Mobile Number:</p> ";
            echo "<input type='text' name='mobile' id='mobile'  required>";
            echo "<p/>";
        
            echo "<p/>";

            echo '<input type=submit value=Submit id="submit">';

            /*
            -----------------------------------------------------------------
            Results Add Player
            -----------------------------------------------------------------
            */
            function addteamegistration( $team, $registration )
            {
                echo '<H1>Results</H1>';
                echo '<p/>';
                echo '<b>Club Number: '.$team->clubname.'</b>';
                echo '<p/>';
                echo 'Team Name: '.$team->teamname;
                echo '<p/>';

                // if ($registration->agegroupdob == "Not Allowed")
                // {
                //     echo '<p/>';
                //     echo("Only U8-U13 can register for preseason.");
                //     return;
                // }

                // if ($registration->haveyouregistered == "N")
                // {
                //     echo("Important!!");
                //     echo '<p/>';
                //     echo("All players must be registered on myfootball prior to attending grading sessions.");
                //     echo '<p/>';
                //     echo("Go to <a href='https://live.myfootballclub.com.au/SelfReg/Login.aspx?chkcookie=1'>myfootball</a> or <a href='http://belnorth.com/registrations/'>belnorth</a> website.");
                //     echo '<p/>';
                // }

                $db_hostname = 'localhost';
                $db_username = 'belnorth_machado';
                $db_password = 'M@ch@d)';
                $db_database = 'belnorth_players';

                $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

                $sql =  "REPLACE INTO team 
                ( fkagegroupid, idteam, name, showindropdown, IsGungahlinTeam, division, fkclubname, shirtcolour,  gender, contactname, emailaddress, mobile) 
                        VALUES ('" 
                         .$team->fkagegroupid. 
                    "','".$team->idteam. 
                    "','".$team->teamname. 
                    "','".$team->showindropdown. 
                    "','".$team->IsGungahlinTeam. 
                    "','".$team->division. 
                    "','".$team->fkclubname. 
                    "','".$team->shirtcolour. 
                    "','".$team->gender. 
                    "','".$team->contactname. 
                    "','".$team->emailaddress. 
                    "','".$team->mobile. 
                "')";

                if ( $team->idteam== "" || $team->fkagegroupid == "" || $team->fkclubname == "" )
                {
                    // do nothing
                    echo 'Error during registration. Please contact the club </p>';
                    echo $sql;
                }
                else
                {

                    if ($mysqli->query($sql) === TRUE) {

                        $sqlregistration =  "REPLACE INTO teamregistration 
                        ( fkcompetitionmanualid, fkteamagegroup, fkidteam, registrationdate, status ) 
                                VALUES ('" 
                             .$registration->competitionmanualid. 
                        "','".$registration->agegroup. 
                        "','".$registration->idteam. 
                        "','".$registration->registrationdate. 
                        "','".$registration->status. 
                        "')";

                        if ($mysqli->query($sqlregistration) === TRUE) {
                            echo '<H2>Registration created or updated successfully.</H2>';
                        } else {
                            echo "Registration UNSUCCESSFUL - Contact Club with error: " . $mysqli->error;

                            echo "<p/>";
                            echo "SQL Statement:";
                            echo "<p/>";
                            echo $sqlregistration;
                        }

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
