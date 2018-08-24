<?php
    /*
    Template Name: Team Registration
    Date: 21-Aug-2018
    Requested by: Meggsie

    - Club Name  
    1. Team Name  
    2. + Team previous name (if applicable) 
    3. Shirt colour
    - Gender:(drop down menu) Boy/Girl/Other
    4. Age group
    5. Division 
    6. Team contacts name  < Manager name 
    7. Team Contacts email address < Manager email
    8. Team contacts Mobile Number < Manager phone number 
    9. Coach or secondary contact 
    10. Coach or secondary contact number 
    11. Coach or secondary contact email 

    SELECT * FROM belnorth_players.teamregistration R, belnorth_players.team T where R.FKcompetitionmanualid = "SUMMERCOMPSIXASIDE2018" and R.FKidteam = T.idteam;

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

            // Team Details

            $fkclubname = $_POST['fkclubname']; // not used
            $gender = $_POST['gender']; // not used
       
            $idteam = $_POST['teamname'];        // 1.
            $idteam = strtoupper($idteam);
            $teamname = $_POST['teamname'];
            $teamname = strtoupper($teamname);
           
            $teampreviousname = $_POST['teampreviousname'];         // 2.
            $teampreviousname = strtoupper($teampreviousname);
        
            $shirtcolour = $_POST['shirtcolour']; // 3.
            $shirtcolour = strtoupper($shirtcolour);
        
            $agegroup = $_POST['agegroup']; // 4.
            $division = $_POST['division']; // 5.
        
            $contactname = $_POST['contactname']; // 6. Manager Name
            $mobile = $_POST['mobile']; // 7. Manager Mobile Phone
            $emailaddress = $_POST['emailaddress']; // 8. Manager Email Address
        
            $secondcontactname = $_POST['contactname'];   //  9. Manager Name
            $secondmobile = $_POST['mobile'];             // 10. Manager Mobile Phone
            $secondemailaddress = $_POST['emailaddress']; // 11. Manager Email Address
        
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
                var $fkagegroupid;   // 4.
                var $idteam;         // 1.
                var $teamname;       // 1.
                var $teampreviousname;  // 2.
                var $showindropdown; // not sure
                var $division;       // 5.
                var $fkclubname;     // not used
                var $shirtcolour;    // 3.
                var $gender;         // not used
                var $contactname;    // 6. Manager Name
                var $emailaddress;   // 8. Manager Email
                var $mobile;         // 7. Manager Mobile
                var $secondcontactname;    // 9. second Manager Name
                var $secondemailaddress;   // 11. second Manager Email
                var $secondmobile;         // 10. second Manager Mobile
            }

            // update/ insert
            class TeamRegistration
            {   
                var $competitionmanualid;
                var $registrationdate;
                var $status;
                var $agegroup;
                var $idteam;
                var $division;
            }
            

            if ($teamname != "" )
            {
                $team = new Team();

                $team->fkagegroupid = $agegroup;
                $team->idteam = $idteam; // team ID 
                $team->teamname = $teamname; // team name
                $team->teampreviousname = $teampreviousname; // team previous name
                $team->showindropdown = "Y";
                $team->division = $division;
                $team->fkclubname = $fkclubname;
                $team->shirtcolour = $shirtcolour;
                $team->gender = $gender;
                $team->contactname =  $contactname;
                $team->emailaddress = $emailaddress;
                $team->mobile =  $mobile;
                $team->secondcontactname =  $secondcontactname;
                $team->secondemailaddress = $secondemailaddress;
                $team->secondmobile =  $secondmobile;

                $registration = new TeamRegistration();
                $registration->competitionmanualid = $competitionmanualid;
                $registration->registrationdate = $registrationdate;
                $registration->status = "Active";
                $registration->agegroup = $agegroup;
                $registration->idteam = $idteam; 
                $registration->division = $division; 

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
            echo '            <Option value="SUMMERCOMPSIXASIDE2018">Six a Side Summer Comp 2018</option>';
            echo "            </select>";
            echo "</b>";
            echo "<p/>";

            // echo "<p>Club Name:</p> ";
            // echo "<select name='fkclubname' id='fkclubname'  required>";
            // echo '            <Option value="">Select...</option>';
            // echo '            <Option value="Belnorth">Belnorth</option>';
            // echo '            <Option value="Belsouth">Belsouth</option>';
            // echo '            <Option value="Belwest">Belwest</option>';
            // echo '            <Option value="Majura">Majura</option>';
            // echo '            <Option value="Gungahlin">Gungahlin</option>';
            // echo '            <Option value="Other">Other</option>';
            // echo "            </select>";
            // echo "<p/>";

            echo "<p>Team Name:</p>";
            echo '<input type="text" name="teamname" id="teamname" class="w3-input" required>';
            echo "<p/>";
            
            echo "<p>Team Previous Name (if applicable):</p>";
            echo '<input type="text" name="teampreviousname" id="teampreviousname" class="w3-input">';
            echo "<p/>";

            echo "<p>Shirt colour:</p>";
            echo "<input type='text' name='shirtcolour' id= 'shirtcolour'  required>";
            echo "<p/>";

            // echo "<p>Player Gender:</p> ";
            // echo "<select name='gender' id='gender' required>";
            // echo '            <Option value="">Select...</option>';
            // echo '            <Option value="M">Male</option>';
            // echo '            <Option value="F">Female</option>';
            // echo '            <Option value="O">Other</option>';
            // echo "            </select>";
            // echo "<p/>";

            echo "<p>Age Group:</p>";
            echo "<select name='agegroup' id='agegroup'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="ADULT">Adult</option>';
            echo '            <Option value="U16">U16</option>';
            echo '            <Option value="U15">U15</option>';
            echo '            <Option value="U14">U14</option>';
            echo '            </select>';
            echo '<p/>';

            echo "<p>Division:</p>";
            echo "<select name='division' id='division'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="PLATE">Plate (div1)</option>';
            echo '            <Option value="SOCIAL">Social</option>';
            echo '            </select>';
            echo '<p/>';

            echo "<p>Manager Name:</p> ";
            echo "<input type='text' name= 'contactname' id= 'contactname' required>";
            echo "<p/>";

            echo "<p>Manager Email Address:</p> ";
            echo "<input type='email' name='emailaddress' id='emailaddress' required>";
            echo "<p/>";

            echo "<p>Manager Mobile Number:</p> ";
            echo "<input type='text' name='mobile' id='mobile' required>";
            echo "<p/>";

            echo "<p>Coach or Second Contact Name:</p> ";
            echo "<input type='text' name= 'secondcontactname' id= 'secondcontactname'>";
            echo "<p/>";

            echo "<p>Coach or Second Contact Email Address:</p> ";
            echo "<input type='email' name='secondemailaddress' id='secondemailaddress'>";
            echo "<p/>";

            echo "<p>Coach or Second Contact Mobile Number:</p> ";
            echo "<input type='text' name='secondmobile' id='secondmobile'>";
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
                ( fkagegroupid, idteam, name, showindropdown, IsGungahlinTeam, division, fkclubname, shirtcolour,  gender, contactname, emailaddress, mobile, secondcontactname, secondemailaddress, secondmobile, teampreviousname) 
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
                    "','".$team->secondcontactname. 
                    "','".$team->secondemailaddress. 
                    "','".$team->secondmobile. 
                    "','".$team->teampreviousname. 
                "')";

                if ( $team->idteam== "" || $team->teamname == "" )
                {
                    // do nothing
                    echo 'Error during registration. Please contact the club </p>';
                    echo $sql;
                }
                else
                {

                    if ($mysqli->query($sql) === TRUE) {

                        $sqlregistration =  "REPLACE INTO teamregistration 
                        ( fkcompetitionmanualid, fkteamagegroup, fkidteam, registrationdate, status, division ) 
                                VALUES ('" 
                             .$registration->competitionmanualid. 
                        "','".$registration->agegroup. 
                        "','".$registration->idteam. 
                        "','".$registration->registrationdate. 
                        "','".$registration->status. 
                        "','".$registration->division. 
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



