<?php
    /*
    Template Name: Belnorth Preseason Form 
    Requested on: 18-Jan-2018
    Create a new table "preseason"
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

                var strU = "U";

                if (agegrnextyear > 13) 
                {
                    strU = "";
                    agegrnextyear = "Not allowed";
                }
                if (agegrnextyear < 8) 
                {
                    strU = "";
                    agegrnextyear = "Not allowed";
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
                                emailaddress,
                                mobile,
                                shirtsize 
                                )       
                    {
                        this.ffanumber=ffanumber;
                        this.firstname=firstname;
                        this.lastname=lastname;
                        this.dateofbirth=dateofbirth;
                        this.gender=gender;
                        this.emailaddress=emailaddress;
                        this.mobile=mobile;
                        this.shirtsize=shirtsize;
                    }

                }

                var ffanumber = document.getElementById("ffanumber");

                // This form is for the PRESEASON using the new PLAYERDETAILS table - to be reused for different registrations
                // The player details are now on a single, reusable table
                // Particulars of the competition will be listed at the competition table
                // Particulars of the registration will be listed at the registration table
                // The URL below should refer to GETPLAYERDETAILS 
                var url = 'http://belnorth.com/api/bnapiplayerrepo.php?action=getplayerdetails&ffanumber='+ffanumber.value;

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

                    // var emailaddress = document.getElementById("emailaddress");
                    // emailaddress.value = player.emailaddress;

                    var gender = document.getElementById("gender");
                    setSelectedValue(gender, player.gender);

                    var haveyouregistered = document.getElementById("haveyouregistered");
                    haveyouregistered.value = player.haveyouregistered;

                    // var mobile = document.getElementById("mobile");
                    // mobile.value = player.mobile;
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

            // Competition
            $competitionmanualid = "BELNORTHPRESEASON2018";

            // Registration
            $agegroupdob = $_POST['agegroupdob'];
            $haveyouregistered = $_POST['haveyouregistered'];

            // Player Details
            $ffanumber = $_POST['ffanumber'];
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $dateofbirth = $_POST['dateofbirth'];
            $gender = $_POST['gender'];
            $emailaddress = $_POST['emailaddress'];
            $mobile = $_POST['mobile'];
            $shirtsize = $_POST['shirtsize'];

            $todays_date = date("Y-m-d");

            // Registration read input
            $registrationdate = $todays_date;
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
            class Registration
            {   
                var $competitionmanualid;
                var $ffanumber;
                var $registrationdate;
                var $haveyouregistered;
                var $agegroupdob;
                var $igivepermission;
            }

            // update/ insert
            class Player
            {   
                var $ffanumber;
                var $firstname;
                var $lastname;
                var $dateofbirth;
                var $gender;
                var $emailaddress;
                var $agegroupdob;
                var $mobile;
                var $shirtsize;

            }

            if ($ffanumber != "" )
            {
                $player = new Player();

                $player->ffanumber = $ffanumber;
                $player->firstname = $firstname;
                $player->lastname = $lastname;
                $player->dateofbirth = $dateofbirth;
                $player->gender = $gender;
                $player->haveyouregistered = $haveyouregistered;
                $player->emailaddress = $emailaddress;
                $player->mobile =  $mobile;
                $player->shirtsize =  $shirtsize;

                $registration = new Registration();
                $registration->igivepermission = "Y";
                $registration->competitionmanualid = $competitionmanualid;
                $registration->ffanumber = $ffanumber;
                $registration->registrationdate = $registrationdate;
                $registration->haveyouregistered = $haveyouregistered;
                $registration->agegroupdob = $agegroupdob;


                // echo '<p/>';
                // echo 'Check registration agegroupdob:';
                // echo '<p/>';
                // echo $registration->agegroupdob;
                // echo '<p/>';
                
                if ($registration->agegroupdob == "Not allowed")
                {
                    echo '<p/>';
                    echo("Registration is not valid.");
                    echo '<p/>';
                    echo("Only U8-U13 can register for preseason.");
                    echo '<p/>';
                    return;
                }
                else {
                    // echo '<p/>';
                    // echo 'Going ahead';
                    // echo '<p/>';
                    addplayerregistration( $player, $registration ); 
                }
            }

            echo "<form method=post name=f1 action=''>";

            echo "<p>Player FFA Number:</p>";
            echo '<input type="text" name="ffanumber" id="ffanumber" required onchange="javascript:getplayerdetails()">';
            echo "<p/>";

            echo "<p>Player Surname:</p>";
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

            echo "<p>Shirt Size (umbro):</p> ";
            echo "<select name='shirtsize' id='shirtsize' required>";
            echo '            <Option value="">Select...</option>';
            echo '            <Option value="Size8">Size 8</option>';
            echo '            <Option value="Size10">Size 10</option>';
            echo '            <Option value="Size12">Size 12</option>';
            echo '            <Option value="Size14">Size 14 Adult XS</option>';
            echo '            <Option value="Size16">Size 16 Adult S</option>';
            echo '            <Option value="AdultMedium">Adult Medium</option>';
            echo '            <Option value="AdultLarge">Adult Large</option>';
            echo "            </select>";
            echo "<p/>";

            echo "<p>Contact Email Address:</p> ";
            echo '<input type="email" name="emailaddress" id="emailaddress" required>';
            echo "<p/>";

            echo "<p>Contact Mobile Number:</p> ";
            echo '<input type="text" name="mobile" id="mobile" required>';
            echo "<p/>";
        
            echo "<p>Have you registered with myfootball:</p>";
            echo "<select name='haveyouregistered' id='haveyouregistered' required>";
            echo '"      <Option value="">Select...</option>';
            echo '      <Option value="Y">Yes</option>';
            echo '      <Option value="N">No</option>';
            echo "</select>";
            echo "<p/>";

            echo "<p/>";

            echo '<input type=submit value=Submit id="submit">';

            /*
            -----------------------------------------------------------------
            Results Add Player
            -----------------------------------------------------------------
            */
            function addplayerregistration( $player, $registration )
            {
                echo '<H1>Results</H1>';
                echo '<p/>';
                echo '<b>FFA Number: '.$player->ffanumber.'</b>';
                echo '<p/>';
                echo 'First Name: '.$player->firstname;
                echo '<p/>';
                echo 'Surname: '.$player->lastname;
                echo '<p/>';

                if ($registration->agegroupdob == "Not Allowed")
                {
                    echo '<p/>';
                    echo("Only U8-U13 can register for preseason.");
                    return;
                }

                if ($registration->haveyouregistered == "N")
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

                $sql =  "REPLACE INTO playerdetails 
                ( ffanumber, firstname, lastname, emailaddress, dob, gender, mobile, shirtsize ) 
                        VALUES ('" 
                    .$player->ffanumber. 
                "','".$player->firstname. 
                "','".$player->lastname. 
                "','".$player->emailaddress. 
                "','".$player->dateofbirth. 
                "','".$player->gender. 
                "','".$player->mobile. 
                "','".$player->shirtsize. 
                "')";

                if ( $player->ffanumber== "" || $player->firstname == "" || $player->lastname == "" || $player->emailaddress == "" )
                {
                    // do nothing
                    echo ' fields empty </p>';
                    echo $sql;
                }
                else
                {
                    if ($mysqli->query($sql) === TRUE) {

                        $sqlregistration =  "REPLACE INTO registration 
                        ( ffanumber, competitionmanualid, registrationdate, haveyouregistered, agegroupdob, igivepermission ) 
                                VALUES ('" 
                            .$registration->ffanumber. 
                        "','".$registration->competitionmanualid. 
                        "','".$registration->registrationdate. 
                        "','".$registration->haveyouregistered. 
                        "','".$registration->agegroupdob. 
                        "','".$registration->igivepermission. 
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
