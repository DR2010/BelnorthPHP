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

            // --------------------------------------
            //       Add New Item to Order
            // --------------------------------------
            function addNewItem() {

                var table = document.getElementById("myTable");
                var playername = document.getElementById("playername");
                var playerffanumber = document.getElementById("playerffanumber");
                var dob = document.getElementById("dob");
                var winterteam = document.getElementById("winterteam");
                var divisionskillage = document.getElementById("divisionskillage");

                var lastRow = table.rows[table.rows.length];
                var lastRowNumber = table.rows.length;

                var row = table.insertRow(lastRow);

                var cell0 = row.insertCell(0);
                var cell1 = row.insertCell(1);
                var cell2 = row.insertCell(2);
                var cell3 = row.insertCell(3);
                var cell4 = row.insertCell(4);
                var cell5 = row.insertCell(5);

                x = '<input type=checkbox name=row' + lastRowNumber + ' id=checkitem' + lastRowNumber + '>';
                b = "<button type=button onclick='RemoveRow(this)'>Remove</button>";

                cell0.innerHTML = b;

                // cell1.innerHTML = playername.value;
                cell1.innerHTML = "<input type='text' style='width: 200px;' name='playername"+lastRowNumber+"' id='playername"+lastRowNumber+"' value='"+playername.value +"'>";
                
                // cell2.innerHTML = dob.value;
                cell2.innerHTML = "<input type='date' style='width: 200px;' name='dob"+lastRowNumber+"' id='dob"+lastRowNumber+"' value='"+dob.value +"'>";

                // cell3.innerHTML = playerffanumber.value;
                cell3.innerHTML = "<input type='text' style='width: 200px;' name='playerffanumber"+lastRowNumber+"' id='playerffanumber"+lastRowNumber+"' value='"+playerffanumber.value +"'>";

                // cell4.innerHTML = winterteam.value;
                cell4.innerHTML = "<input type='text' style='width: 200px;' name='winterteam"+lastRowNumber+"' id='winterteam"+lastRowNumber+"' value='"+winterteam.value +"'>";

                // cell5.innerHTML = divisionskillage.value;
                cell5.innerHTML = "<input type='text' style='width: 200px;' name='divisionskillage"+lastRowNumber+"' id='divisionskillage"+lastRowNumber+"' value='"+divisionskillage.value +"'>";


            }

            // --------------------------------------
            //   Remove Selected Rows from Order
            // --------------------------------------

            function removeSelectedRows() {
                // JavaScript & jQuery Course - http://coursesweb.net/javascript/
                var selchbox = []; // array that will store the value of selected checkboxes

                var table = document.getElementById("myTable");
                var lastRowNumber = table.rows.length;

                var row = 0;
                var itemchknumber = 0;
                var numberofrows = table.rows.length;
                while (numberofrows >= 1) {

                    numberofrows = table.rows.length;

                    itemchknumber = row;
                    var chk = document.getElementById('checkitem' + itemchknumber);

                    if (chk != null) {
                        if (chk.checked) { 
                            table.deleteRow(row) 
                            row++;
                        }
                        else{
                            row++;
                        }
                    }
                    else {
                        row++;
                    }

                    if (row > table.rows.length) {
                        break;
                    }
                }

                return selchbox;
            }

            function RemoveRow(elm) {
               elm.parentNode.parentNode.parentNode.removeChild(elm.parentNode.parentNode);
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
        
            // Input Player List
            //
            $playerList = array();

            for ($x = 0; $x <= 20; $x++) {

                $playernamevar = 'playername'.$x;
                $dateofbirthvar = 'dob'.$x;
                $playerffanumbervar = 'playerffanumber'.$x;
                $winterteamvar = 'winterteam'.$x;
                $divisionskillagevar = 'divisionskillage'.$x;
               
                $playername = $_POST[$playernamevar];
                $dateofbirth = $_POST[$dateofbirthvar];
                $playerffanumber = $_POST[$playerffanumbervar];
                $winterteam = $_POST[$winterteamvar];
                $divisionskillage = $_POST[$divisionskillagevar];

                $player = new Player();
                $player->playername = $playername;
                $player->dateofbirth = $dateofbirth;
                $player->playerffanumber = $playerffanumber;
                $player->winterteam = $winterteam;
                $player->divisionskillage = $divisionskillage;

                $playerList[] = $player;
            }

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

            class Player
            {   
                var $playername;
                var $dateofbirth;
                var $ffanumber;
                var $winterfutsalteam;
                var $divisionskillagegroup;
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

                // for ($x = 0; $x <= 20; $x++) {

                //     echo ">>> SECOND LOOP <<<";
                //     echo "<br/>";

                //     echo "playerList:";
                //     echo "<br/>";
                //     echo $playerList[$x]->playername;
                //     echo "<br/>";
                //     echo $playerList[$x]->dateofbirth;
                //     echo "<br/>";
                //     echo $playerList[$x]->playerffanumber;
                //     echo "<br/>";
                //     echo $playerList[$x]->winterteam;
                //     echo "<br/>";
                //     echo $playerList[$x]->divisionskillage;
                //     echo "<br/>";
                // } 

                // return;
               
                addteamegistration( $team, $registration, $playerList ); 
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
            echo '            <Option value="DIV1">Division 1</option>';
            echo '            <Option value="DIV2">Division 2</option>';
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

            echo "<p><h2>Add Player Details and hit Add to List - repeat until all players are listed</h2></p> ";
            echo "<p/>";

            echo "<div class='boxed'>";
            echo "<p>Player Name:</p> ";
            echo "<input type='text' name='playername' id='playername'>";
            echo "<p/>";
            echo "<p>Player FFA Number:</p> ";
            echo "<input type='text' name='playerffanumber' id='playerffanumber'>";
            echo "<p/>";
            echo "<p>Date of Birth:</p> ";
            echo "<input type='date' name='dob' id='dob'>";
            echo "<p/>";
            echo "<p>Winter/Futsal Team:</p> ";
            echo "<input type='text' name='winterteam' id='winterteam'>";
            echo "<p/>";
            echo "<p>Division/ Skill and/or Age Group:</p> ";
            echo "<input type='text' name='divisionskillage' id='divisionskillage'>";
            echo "<p/>";
            echo "<p/>";

            echo "<button type=button onclick='addNewItem()'>Add to List</button>";
            echo "</div>";

            echo "<p/>";

            echo "<div>";
            // echo "<div style='float:left;' class='table-responsive'>";

            echo "<table id='myTable'  class='table table-striped table-bordered'>";
            echo "    <tr>";
            echo "        <th>Action</th>";
            echo "        <th>Player Name</th>";
            echo "        <th>DOB</th>";
            echo "        <th>FFA #</th>";
            echo "        <th>Winter/futsal Team</th>";
            echo "        <th>Division/skill and/or age group</th>";
            echo "    </tr>";
            echo "</table>";
            
            echo "</div>";

            echo '<input type=submit value=Submit id="submit">';

            /*
            -----------------------------------------------------------------
            Results Add Player
            -----------------------------------------------------------------
            */
            function addteamegistration( $team, $registration, $playerList )
            {
                echo '<H1>Results</H1>';
                echo '<p/>';
                echo 'Team Name: '.$team->teamname;
                echo '<p/>';

                $db_hostname = 'localhost';
                $db_username = 'belnorth_machado';
                $db_password = 'M@ch@d)';
                $db_database = 'belnorth_players';

                $todays_date = date("Y-m-d");

                $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

                $sqlteam =  "REPLACE INTO team 
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
                    echo $sqlteam;
                }
                else
                {

                    if ($mysqli->query($sqlteam) === TRUE) {

                        $sqlteamregistration =  "REPLACE INTO teamregistration 
                        ( fkcompetitionmanualid, fkteamagegroup, fkidteam, registrationdate, status, division ) 
                                VALUES ('" 
                             .$registration->competitionmanualid. 
                        "','".$registration->agegroup. 
                        "','".$registration->idteam. 
                        "','".$registration->registrationdate. 
                        "','".$registration->status. 
                        "','".$registration->division. 
                        "')";

                        if ($mysqli->query($sqlteamregistration) === TRUE) {

                            // Insert Players Records

                            for ($x = 0; $x <= 20; $x++) {

                                // skip empty rows
                                if ($playerList[$x]->playerffanumber == "") continue;

                                $sqlplayer =  "REPLACE INTO player 
                                (
                                  ffanumber   
                                , DOB   
                                , firstname  
                                , fkteamid
                                , winterclub
                                , winterteamdivision
                                ) 
                                        VALUES ('" 
                                     .$playerList[$x]->playerffanumber. 
                                "','".$playerList[$x]->dateofbirth. 
                                "','".$playerList[$x]->playername.
                                "','".$team->idteam.
                                "','".$playerList[$x]->winterteam. 
                                "','".$playerList[$x]->divisionskillage. 
                                "')";

                                if ($mysqli->query($sqlplayer) === TRUE) {

                                    $sqlregistration =  "REPLACE INTO registration 
                                    ( competitionmanualid, ffanumber, registrationdate, status, agegroupdob, playerteam ) 
                                            VALUES ('" 
                                                .$registration->competitionmanualid. 
                                            "','".$playerList[$x]->playerffanumber. 
                                            "','".$todays_date. 
                                            "','".'Active'. 
                                            "','".$team->fkagegroupid. 
                                            "','".$team->idteam. 
                                    "')";

                                    if ($mysqli->query($sqlregistration) === TRUE) {
                                        echo '<H2>Team Registered Successfully. (Player)</H2>';

                                    } else {
                                        echo "Registration UNSUCCESSFUL - Contact Club with error: (Registration Player) - " . $mysqli->error;

                                        echo "<p/>";
                                        echo "Registration Player - SQL Statement:";
                                        echo "<p/>";
                                        echo $sqlregistration;
                                    }    
    
                                } else {
                                    echo "Registration UNSUCCESSFUL - Contact Club with error: (Player) - " . $mysqli->error;

                                    echo "<p/>";
                                    echo "PLAYER - SQL Statement:";
                                    echo "<p/>";
                                    echo $sqlplayer;
                                }    
                            } 

                            echo '<H2>Team Registered Successfully.</H2>';

                        } else {
                            echo "Registration UNSUCCESSFUL - Contact Club with error: (Team Registration) " . $mysqli->error;

                            echo "<p/>";
                            echo "SQL Statement:";
                            echo "<p/>";
                            echo $sqlteamregistration;
                        }

                    } else {
                        echo "Registration UNSUCCESSFUL - Contact Club with error: (Team) " . $mysqli->error;

                        echo "<p/>";
                        echo "SQL Statement:";
                        echo "<p/>";
                        echo $sqlteam;
                    }
                }
                $mysqli->close();
            }
            echo "</form>";
        ?>
    </body>
</html>
