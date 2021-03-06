<?php
    /*
    Template Name: Belnorth Grading Input 
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
            function setagegroupdobOLD( invalue )
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

                var strU = "U";

                if (agegrnextyear > 18) 
                {
                    strU = "";
                    agegrnextyear = "Adult";
                }
                if (agegrnextyear < 5) 
                {
                    agegrnextyear = 5;
                }

                var uage = strU.concat(agegrnextyear);

                // Set Calculated Age Group value
                objagegroupdob.value = uage;

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

                var strU = "U";

                if (agegrnextyear > 18) 
                {
                    strU = "";
                    agegrnextyear = "No Trial";
                }
                if (agegrnextyear < 10) 
                {
                    strU = "";
                    agegrnextyear = "No Trial";
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
            Try for older age group
            -------------------------------------------------------------
            */
            function tryoldergroup( invalue )
            {
                // var olderinterested = document.getElementById("olderinterested");
                var olderagetrial = document.getElementById("olderagetrial");
                // var trialagegroup = document.getElementById("trialagegroup");

                // olderinterested
                // olderagetrial
                // trialagegroup
                
                if ( invalue == "Y")
                {
                    // olderagetrial.setAttribute("disabled", false);
                    // trialagegroup.setAttribute("disabled", false);
                    olderagetrial.disabled = false;
                    // trialagegroup.disabled = false;
                }
                else
                {
                    // olderagetrial.removeAttribute("disabled");
                    // trialagegroup.removeAttribute("disabled");
                    // trialagegroup.disabled = true;
                    olderagetrial.disabled = true;
                    olderagetrial.value = "";
                    // trialagegroup.value = "";

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

                // var url = 'http://belnorth.com/api/bnapiplayerrepo.php?action=getplayer&ffanumber=222222222&firstname=Daniel&lastname=Machado';
                // var url = 'http://belnorth.com/api/bnapiplayerrepo.php?action=getplayer&ffanumber='+ffanumber.value+'&firstname='+firstname.value+'&lastname='+lastname.value;
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

                    // var dateofbirth = document.getElementById("dateofbirth");
                    // dateofbirth.value = player.dateofbirth;

                    var agegroupdob = document.getElementById("agegroupdob");
                    agegroupdob.value = player.agegroupdob;

                    // var emailaddress = document.getElementById("emailaddress");
                    // emailaddress.value = player.emailaddress;

                    var gender = document.getElementById("gender");
                    setSelectedValue(gender, player.gender);

                    var trialopengirls = document.getElementById("trialopengirls");
                    setSelectedValue(trialopengirls, player.trialopengirls);

                    // var trialagegroup = document.getElementById("trialagegroup");
                    // setSelectedValue(trialagegroup, player.trialagegroup);

                    var posBack = document.getElementById("chk1");
                    posBack.checked = player.posBack;

                    var posMidfield = document.getElementById("chk2");
                    posMidfield.checked = player.posMidfield;

                    var posAttack = document.getElementById("chk3");
                    posAttack.checked = player.posAttack;

                    var posKeeper = document.getElementById("chk4");
                    posKeeper.checked = player.posKeeper;

                    var haveyouregistered = document.getElementById("haveyouregistered");
                    haveyouregistered.value = player.haveyouregistered;

                    // var mobile = document.getElementById("mobile");
                    // mobile.value = player.mobile;

                    // var olderinterested = document.getElementById("olderinterested");
                    // olderinterested.value = player.olderinterested;

                    var olderagetrial = document.getElementById("olderagetrial");
                    olderagetrial.value = player.olderagetrial;

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

        </script>        
    </head>

    <body>
        <?php

            $ffanumber = $_POST['ffanumber'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $dateofbirth = $_POST['dateofbirth'];
            $gender = $_POST['gender'];
            $trialagegroup = $_POST['trialagegroup'];
            $trialopengirls = $_POST['trialopengirls'];
            $preferredposition = $_POST['preferredposition'];
            $haveyouregistered = $_POST['haveyouregistered'];
            $emailaddress = $_POST['emailaddress'];

            $posBack = $_POST['posBack'];
            $posMidfield = $_POST['posMidfield'];
            $posAttack = $_POST['posAttack'];
            $posKeeper = $_POST['posKeeper'];
            $agegroupdob = $_POST['agegroupdob'];
            $mobile = $_POST['mobile'];
            $olderinterested  = $_POST['olderinterested'];
            $olderagetrial  = $_POST['olderagetrial'];

            class Player
            {   
                var $ffanumber;
                var $firstname;
                var $lastname;
                var $dateofbirth;
                var $gender;
                var $display;
                var $fkagegroupid;
                var $fkteamid;
                var $trialagegroup;
                var $trialopengirls;
                var $haveyouregistered;
                var $igivepermission;
                var $BIBnumber;
                var $emailaddress;
                var $posBack;
                var $posMidfield;
                var $posAttack;
                var $posKeeper;
                var $agegroupdob;
                var $mobile;
                var $olderinterested;
                var $olderagetrial;

            }

            if ($ffanumber != "" )
            {
                $player = new Player();

                $player->ffanumber = $ffanumber;
                $player->firstname = $firstname;
                $player->lastname = $lastname;
                $player->dateofbirth = $dateofbirth;
                $player->gender = $gender;
                $player->trialagegroup = $trialagegroup;
                $player->haveyouregistered = $haveyouregistered;
                $player->emailaddress = $emailaddress;
                $player->trialopengirls = $trialopengirls;

                $player->posBack = $posBack;
                $player->posMidfield =  $posMidfield;
                $player->posAttack =  $posAttack;
                $player->posKeeper =  $posKeeper;
                $player->agegroupdob =  $agegroupdob;
                $player->mobile =  $mobile;
                $player->olderinterested =  $olderinterested;
                $player->olderagetrial =  $olderagetrial;

                $player->igivepermission = "Y";
                $player->display = "Y";
                $player->fkagegroupid = "NOTDEFINED";
                $player->fkteamid = "NOTDEFINED";
                $player->BIBnumber = "0";

                addplayer(  $player ); 
            }

            echo "<form method=post name=f1 action=''>";

            echo "<p>Player FFA Number:</p>";
            echo '<input type="text" name="ffanumber" id="ffanumber" required onchange="javascript:getplayerdetails()">';
            echo "<p/>";

            echo "<p>Player Last Name:</p>";
            echo '<input type="text" name="lastname" id="lastname" required>';
            echo "<p/>";

            echo "<p>Player First Name:</p>";
            echo '<input type="text" name="firstname" id="firstname" required>';
            echo "<p/>";

            echo "<p>Player Gender:</p> ";
            echo "<select name='gender' id='gender' required onchange='checkgenderselection()'>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="M">Male</option>';
            echo '            <Option value="F">Female</option>';
            echo '            <Option value="O">Other</option>';
            echo "            </select>";
            echo "<p/>";

            echo "<p>Player Date of Birth:</p> ";
            echo "<input type='date' name='dateofbirth' id='dateofbirth' required onchange='setagegroupdob(this.value)'>";
            echo "<p/>";

            echo "<p>Age Group:</p> ";
            echo "<input type='text' name='agegroupdob' id='agegroupdob' readonly>";
            echo "<p/>";

            // echo "<p>Would like to try for an older age group?</p> ";
            // echo "<select name='olderinterested' id='olderinterested' onchange='tryoldergroup(this.value)'>";
            // echo '"      <Option value="">Select...</option>';
            // echo '      <Option value="Y">Yes</option>';
            // echo '      <Option value="N">No</option>';
            // echo "</select>";
            // echo "<p/>";


            // <textarea name="Text1" cols="40" rows="5"></textarea>
            // <textarea name="textarea" style="width:250px;height:150px;"></textarea>


            echo "<p>Additional information regarding the trialling age group for player:</p> ";
            echo "<input type='text' name='olderagetrial' id='olderagetrial' >";
            echo "<p/>";

            // truncates: not good yet.
            // echo "<p>Additional information regarding the trialling age group for player:</p> ";
            // echo "<textarea name='olderagetrial' id='olderagetrial' style='width:350px;height:150px;'></textarea>";
            // echo "<p/>";


            // echo "<p>Select Older Age Trial:</p>";
            // echo "<select name='trialagegroup' id='trialagegroup'  disabled >";
            // echo '            <Option value="">Select...</option>';
            // echo '            <Option value="U10">U10</option>';
            // echo '            <Option value="U11">U11</option>';
            // echo '            <Option value="U12">U12</option>';
            // echo '            <Option value="U13">U13</option>';
            // echo '            <Option value="U14">U14</option>';
            // echo '            <Option value="U15">U15</option>';
            // echo '            <Option value="U16">U16</option>';
            // echo '            <Option value="U17">U17</option>';
            // echo '            <Option value="U18">U18</option>';
            // echo '            </select>';
            // echo '<p/>';

            echo "<p>Preferred Position:</p>";
            echo '<input type="checkbox" name="posBack" id="chk1"> Back  </input>';
            echo '<input type="checkbox" name="posMidfield" id="chk2"> Midfield  </input>';
            echo '<input type="checkbox" name="posAttack" id="chk3"> Attack  </input>';
            echo '<input type="checkbox" name="posKeeper" id="chk4"> Goalkeeper </input>';
            echo '<p/>';

            echo '<p>Trials for Open or Girls:</p>';
            echo "<select name='trialopengirls' id='trialopengirls' required onchange='checkgenderselection()'>";
            echo '            <Option value="Open">Open</option>';
            echo '            <Option value="Girls">Girls</option>';
            echo "            </select>";
            echo "<p/>";

            echo "<p>Contact Email Address:</p> ";
            echo '<input type="email" name="emailaddress" id="emailaddress" required>';
            echo "<p/>";

            echo "<p>Contact Mobile Number:</p> ";
            echo '<input type="text" name="mobile" id="mobile" required>';
            // echo '<input type="text" name="mobile" id="mobile" required pattern="[0-9]">';
            echo "<p/>";
        
            echo "<p>Have you registered with myfootball for the upcoming season:</p>";
            echo "<select name='haveyouregistered' id='haveyouregistered' required>";
            echo '"      <Option value="">Select...</option>';
            echo '      <Option value="Y">Yes</option>';
            echo '      <Option value="N">No</option>';
            echo "</select>";
            echo "<p/>";

            echo "<p/>";

            echo '<input type=submit value=Submit id="submit">';


            function addplayer( $player )
            {
                echo '<H1>Results</H1>';
                echo '<p/>';
                echo '<b>FFA Number: '.$player->ffanumber.'</b>';
                echo '<p/>';
                echo 'First Name: '.$player->firstname;
                echo '<p/>';
                echo 'Surname: '.$player->lastname;
                echo '<p/>';

                if ($player->haveyouregistered == "N")
                {
                    echo("Important!!");
                    echo '<p/>';
                    echo("All players must be registered on myfootball prior to attending grading sessions.");
                    echo '<p/>';
                    echo("Go to <a href='https://live.myfootballclub.com.au/SelfReg/Login.aspx?chkcookie=1'>myfootball</a> or <a href='http://belnorth.com/registrations/'>belnorth</a> website.");
                    echo '<p/>';
                }

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
                    , emailaddress 
                    , dob   
                    , trialagegroup 
                    , gender 
                    , display 
                    , fkagegroupid
                    , fkteamid
                    , trialopengirls
                    , haveyouregistered
                    , igivepermission
                    , BIBnumber
                    , posBack
                    , posMidfield
                    , posAttack
                    , posKeeper
                    , agegroupdob
                    , mobile
                    , olderinterested 
                    , olderagetrial 
                    ) 
                            VALUES ('" 
                        .$player->ffanumber. 
                    "','".$player->firstname. 
                    "','".$player->lastname. 
                    "','".$player->emailaddress. 
                    "','".$player->dateofbirth. 
                    "','".$player->trialagegroup. 
                    "','".$player->gender. 
                    "','".$player->display. 
                    "','".$player->fkagegroupid. 
                    "','".$player->fkteamid. 
                    "','".$player->trialopengirls. 
                    "','".$player->haveyouregistered. 
                    "','".$player->igivepermission. 
                    "','".$player->BIBnumber. 
                    "','".$player->posBack. 
                    "','".$player->posMidfield. 
                    "','".$player->posAttack. 
                    "','".$player->posKeeper. 
                    "','".$player->agegroupdob. 
                    "','".$player->mobile. 
                    "','".$player->olderinterested. 
                    "','".$player->olderagetrial. 
                    "')";

                if ( 
                    $player->ffanumber== "" || 
                    $player->firstname == "" ||
                    $player->lastname == "" ||
                    $player->emailaddress == "" || 	  	
                    $player->dateofbirth == "" || 	
                    $player->agegroupdob == "" ||	
                    $player->agegroupdob == "UNaN"  	

                )
                {
                    // do nothing
                    echo ' fields empty </p>';
                    echo $sql;
                }
                else
                {
                    if ($mysqli->query($sql) === TRUE) {
                        echo '<H2>Registration created or updated successfully.</H2>';
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
