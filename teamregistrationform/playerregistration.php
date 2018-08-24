<?php
    /*
    Template Name: Player Registration
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
            function reload(form)
            {
                var val=form.agegroupselected.options[form.agegroupselected.options.selectedIndex].value;
                self.location='?page_id=1410&agegroupselected=' + val ;
            }

            /*
            ---------------------------------------------------
            Calculate the Age Group based on the date of birth
            ---------------------------------------------------
            */
            function setagegroupdob( invalue )
            {
                var objagegroupdob = document.getElementById("agegroupdob");
                var submit = document.getElementById("submit");

                // Calculate age group at birth
                var uage = calculateagegroupdob( invalue );

                // Set Calculated Age Group value
                objagegroupdob.value = uage;
            }


            /*
                  Calculate Age Group DOB
            */
            function calculateagegroupdob( invalue )
            {
                var objagegroupdob = document.getElementById("agegroupdob");

                var parts =invalue.split('-');
                var partsB =invalue.split('/');

                // get birth year
                var year = parts[0];

                substring = "/";
                if ( invalue.indexOf(substring) >= 0)
                {
                    year = parts[2];
                }

                // get next years 2018 age group
                var agegrnextyear = 2018-year;

                var strU = "";

                if (agegrnextyear > 100) 
                {
                    strU = "";
                    agegrnextyear = "N/A";
                }
                if (agegrnextyear < 5) 
                {
                    strU = "";
                    agegrnextyear = "N/A";
                }

                var uage = strU.concat(agegrnextyear);

                // Return calculated age group DOB
                return uage;
            }


            /*
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

            /*
            -------------------------------------------------------------
            Get player details
            -------------------------------------------------------------
            */
            function getplayerdetails()
            {

                class JSPlayer {
                    constructor(ffanumber,
                                firstname,
                                lastname,
                                dateofbirth,
                                gender,
                                display,
                                fkagegroupid,
                                fkteamid,
                                trialagegroup,
                                trialopengirls,
                                haveyouregistered,
                                igivepermission,
                                BIBnumber,
                                emailaddress,
                                posBack,
                                posMidfield,
                                posAttack,
                                posKeeper,
                                agegroupdob,
                                mobile,
                                olderinterested,
                                olderagetrial 
                                )       
                    {
                        this.ffanumber=ffanumber;
                        this.firstname=firstname;
                        this.lastname=lastname;
                        this.dateofbirth=dateofbirth;
                        this.gender=gender;
                        this.display=display;
                        this.fkagegroupid=fkagegroupid;
                        this.fkteamid=fkteamid;
                        this.trialagegroup=trialagegroup;
                        this.trialopengirls=trialopengirls;
                        this.haveyouregistered=haveyouregistered;
                        this.igivepermission=igivepermission;
                        this.BIBnumber=BIBnumber;
                        this.emailaddress=emailaddress;
                        this.posBack=posBack;
                        this.posMidfield=posMidfield;
                        this.posAttack=posAttack;
                        this.posKeeper=posKeeper;
                        this.agegroupdob=agegroupdob;
                        this.mobile=mobile;
                        this.olderinterested=olderinterested;
                        this.olderagetrial=olderagetrial;
                    }

                }

                var ffanumber = document.getElementById("ffanumber");
                var lastname = document.getElementById("lastname");

                var url = 'http://belnorth.com/api/bnapiplayerrepo.php?action=getplayer&ffanumber='+ffanumber.value;

                var req = new Request(url, {method: 'GET', cache: 'reload'});

                fetch(req).then(function(response) {
                    var res = response.json();
                    window.console.log("maybe here..",res);
                    return res;
                }).then(function(json) {
                    window.console.log("here",json);

                    var player = new JSPlayer();
                    player = json;

                    window.console.log("player name:",player.firstname);

                    var firstname = document.getElementById("firstname");
                    firstname.value = player.firstname;

                    var firstname = document.getElementById("lastname");
                    firstname.value = player.lastname;

                    var agegroupdob = document.getElementById("agegroupdob");
                    agegroupdob.value = player.agegroupdob;
                });
            }

            function setSelectedValue(selectObj, valueToSet) 
            {
                for (var i = 0; i < selectObj.options.length; i++) {
                    if (selectObj.options[i].value == valueToSet) {
                        selectObj.options[i].selected = true;
                        return;
                     }
                }
            }


            /*
            -------------------------------------------------------------
            Get List of Teams for Competition 
            -------------------------------------------------------------
            */
            function getlistofteamsforcompetition()
            {

                // Get number of teams

                class SoccerTeamReg {
                    constructor( idteam )       
                    {
                        this.idteam=idteam;
                    }
                }

                var competitionid = document.getElementById("competition");

                var url = 'http://belnorth.com/api/bnapiplayerrepo.php?action=ListCompetitionTeamNames&competition='+competitionid.value;

                var req = new Request(url, {method: 'GET', cache: 'reload'});

                fetch(req).then(function(response) {
                    var res = response.json();
                    window.console.log("maybe here..",res);
                    return res;
                }).then(function(json) {
                    window.console.log("here",json);

                    // var competitionlist = [] SoccerTeamReg();
                    // var competitionlist = new SoccerTeamReg()[2];
                    var competitionlist = json;

                    var playerteam = document.getElementById("playerteam");

                    for(var i = 0; i < competitionlist.length; ++i) {
                        var option = document.createElement('option');
                        option.text = option.value = competitionlist[i].idteam;
                        // playerteam.options.add(option, 0);
                        playerteam.appendChild(option);
                    }

                });
            }

        </script>        
    </head>

    <body>
        <?php

            $competitionmanualid = $_POST['competition'];
            $ffanumber = $_POST['ffanumber'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $dateofbirth = $_POST['dateofbirth'];
            $winterclub = $_POST['winterclub'];
            $winterteamdivision = $_POST['winterteamdivision'];
            $parentname = $_POST['parentname'];
            $emailaddress = $_POST['emailaddress'];
            $mobile = $_POST['mobile'];
            $playerteam = $_POST['playerteam'];
            $agegroupdob = $_POST['agegroupdob'];

            // Registration read input
            $todays_date = date("Y-m-d");
            $registrationdate = $todays_date;
            $status = "ACTIVE";

            class Player
            {   
                var $ffanumber;
                var $firstname;
                var $lastname;
                var $fkteamid;
                var $winterclub;
                var $winterteamdivision;
                var $parentname;
                var $emailaddress;
                var $mobile;
            }

            class Registration
            {   
                var $competitionmanualid;
                var $ffanumber;
                var $registrationdate;
                var $status;
                var $team;
                var $agegroupdob;
            }

            if ($ffanumber != "" )
            {
                $player = new Player();
                $player->ffanumber = $ffanumber;
                $player->firstname = $firstname;
                $player->lastname = $lastname;
                $player->dateofbirth = $dateofbirth;
                $player->winterclub =  $winterclub;
                $player->winterteamdivision =  $winterteamdivision;
                $player->parentname =  $parentname;
                $player->emailaddress = $emailaddress;
                $player->mobile =  $mobile;
                $player->fkteamid =  $playerteam;

                $registration = new Registration();
                $registration->competitionmanualid = $competitionmanualid;
                $registration->ffanumber = $ffanumber;
                $registration->registrationdate = $registrationdate;
                $registration->status = $status;
                $registration->team = $playerteam;
                $registration->agegroupdob = $agegroupdob;

                addplayer( $player, $registration ); 
            }

            echo "<form method=post name=f1 action=''>";

            echo "<b>";
            echo "<p>Competition:</p> ";
            echo "<select name='competition' id='competition' required onchange='javascript:getlistofteamsforcompetition()'>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="SUMMERCOMPSIXASIDE2018">Six a Side Summer Comp 2018</option>';
            echo "            </select>";
            echo "</b>";
            echo "<p/>";

            echo "<p>Player FFA Number:</p>";
            echo '<input type="text" name="ffanumber" id="ffanumber" required>';
            echo "<p/>";

            echo "<b>";
            echo "<p>Select your team:</p> ";
            echo "<select name='playerteam' id='playerteam'  required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="NOTEAM">No Team</option>';
            echo "            </select>";
            echo "</b>";
            echo "<p/>";

            echo "<p>Player Last Name:</p>";
            echo '<input type="text" name="lastname" id="lastname" required>';
            echo "<p/>";

            echo "<p>Player First Name:</p>";
            echo '<input type="text" name="firstname" id="firstname" required>';
            echo "<p/>";

            echo "<p>Player Date of Birth:</p> ";
            echo "<input type='date' name='dateofbirth' id='dateofbirth' required onchange='setagegroupdob(this.value)'>";
            echo "<p/>";

            echo "<p>Player Group:</p> ";
            echo "<input type='text' name='agegroupdob' id='agegroupdob' readonly>";
            echo "<p/>";

            echo "<p>Contact Email Address:</p> ";
            echo '<input type="email" name="emailaddress" id="emailaddress" required>';
            echo "<p/>";

            echo "<p>Contact Mobile Number:</p> ";
            echo '<input type="text" name="mobile" id="mobile" required>';
            echo "<p/>";
        
            echo "<p/>";

            echo '<input type=submit value=Submit id="submit">';


            function addplayer( $player, $registration )
            {
                echo '<H1>Results</H1>';
                echo '<p/>';
                echo '<b>FFA Number: '.$player->ffanumber.'</b>';
                echo '<p/>';
                echo 'First Name: '.$player->firstname;
                echo '<p/>';
                echo 'Surname: '.$player->lastname;
                echo '<p/>';

                $db_hostname = 'localhost';
                $db_username = 'belnorth_machado';
                $db_password = 'M@ch@d)';
                $db_database = 'belnorth_players';

                $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

                    $sql =  "REPLACE INTO player 
                    (
                      ffanumber   
                    , firstname  
                    , lastname   
                    , DOB   
                    , emailaddress 
                    , fkteamid
                    , agegroupdob
                    , mobile
                    , winterclub
                    , winterteamdivision
                    , parentname
                    ) 
                            VALUES ('" 
                        .$player->ffanumber. 
                    "','".$player->firstname. 
                    "','".$player->lastname. 
                    "','".$player->dateofbirth. 
                    "','".$player->emailaddress. 
                    "','".$player->fkteamid. 
                    "','".$player->agegroupdob. 
                    "','".$player->mobile. 
                    "','".$player->winterclub. 
                    "','".$player->winterteamdivision. 
                    "','".$player->parentname. 
                    "')";

                if ( 
                    $player->ffanumber== "" || 
                    $player->firstname == "" ||
                    $player->lastname == ""
                )
                {
                    // do nothing
                    echo ' Please make sure details are entered correctly. </p>';
                    echo ' The registration has not been submitted. </p>';
                    echo $sql;
                }
                else
                {
                    if ($mysqli->query($sql) === TRUE) {

                        $sqlregistration =  "REPLACE INTO registration 
                        ( competitionmanualid, ffanumber, registrationdate, status, agegroupdob, playerteam ) 
                                VALUES ('" 
                                    .$registration->competitionmanualid. 
                                "','".$registration->ffanumber. 
                                "','".$registration->registrationdate. 
                                "','".$registration->status. 
                                "','".$registration->agegroupdob. 
                                "','".$registration->playerteam. 
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
                        
                    }
                }

                $mysqli->close();
            }

            echo "</form>";

        ?>
    </body>
</html>
