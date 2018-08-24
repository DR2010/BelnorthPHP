<?php
	/*
	Competition Repository
	*/
	
    // $db_hostname = 'belnorth.com';
    // Connection failed: Host '69.195.124.175' is blocked because of many connection errors; unblock with 'mysqladmin flush-hosts'
    // ---> Replace hostaname by localhost
    $db_hostname = 'localhost';
    $db_username = 'belnorth_machado';
    $db_password = 'M@ch@d)';
    $db_database = 'belnorth_players';

	$mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

	/* check connection */
	if ($mysqli ->connect_errno) {
		printf("Connection failed: %s\n", $mysqli->connect_error);
		exit();
	}
	
    $requestmethod = $_SERVER['REQUEST_METHOD'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $remoteipforwarded = $_SERVER['HTTP_X_FORWARDED_FOR']; // easily spoofed
	
    $action=$_GET['action'];
    $ffanumber=$_GET['ffanumber'];
    $firstname=$_GET['firstname'];
    $lastname=$_GET['lastname'];
    $dateofbirth=$_GET['dateofbirth'];
    $debug=$_GET['debug'];
    $competition=$_GET['competition'];
    $emailaddress=$_GET['emailaddress'];
    $kitid=$_GET['kitid'];
    $datechanged=$_GET['datechanged'];
    $comments=$_GET['comments'];
    $keynumber=$_GET['keynumber'];
    $keycolour=$_GET['keycolour'];
    
    // Use API Key from the API Management
    // send via body POST I think
    // Golang sends like this:
    //    req.Header.Set("MachadoDaniel-Application-Key", "eb9f7b1620494fb2bdc7815705fd8c7e")
    // acho que e' assim
    // $apikey = $_SERVER['MachadoDaniel-Application-Key']; 
    // ----------------------------------------------------------------------------------
    // !!! Lembre que o GradingForm also calls the API and would have to send the APIKEY
    // ----------------------------------------------------------------------------------
    
    // Block IP addresses
    
    // Azure Linux
    if ( $remoteip == '13.75.157.255' || $remoteip == '1.40.128.147')  { 
        // All good
    }
    else  {
        echo 'access denied';
        exit();
    }

    // http://belnorth.com/api/bnapiplayerrepo.php?action=getplayer&ffanumber=222222222&lastname=Machado&dateofbirth=2004-10-10&debug=Y
        
    switch ($action) {

        case 'ListCompetitionPlayers':
            ListCompetitionPlayers( $competition ); 
            break;
        case 'ListCompetitionTeams':
            ListCompetitionTeams( $competition ); 
            break;
        case 'ListCompetitionCoachesManagers':
            ListCompetitionCoachesManagers( $competition ); 
            break;
        case 'ListCompetitions':
            ListCompetitions(); 
            break;
        case 'GetCompetitionSingleCoach':
            GetCompetitionCoach( $competition, $emailaddress ); 
            break;
        case 'UpdateKitDetails':
            UpdateKitDetails( $competition, $emailaddress, $kitid, $datechanged, $comments );
        case 'UpdateKitKeyDetails':
            UpdateKitKeyDetails( $competition, $emailaddress, $kitid, $datechanged, $comments, $keycolour, $keynumber );
            break;
    }
    
    class Team
    {   
        var $FKAgeGroupID;
        var $UID;
        var $FKDivisionID;
        var $NameID;
        var $PublicName;
        var $showindropdown;
        var $IsGungahlinTeam;

    }

    class SoccerTeamReg
    {   
        var $fkagegroupid;
        var $idteam;
        var $teamname;
        var $showindropdown;
        var $IsGungahlinTeam;
        var $division;
        var $fkclubname;
        var $shirtcolour;
        var $gender;
        var $contactname;
        var $emailaddress;
        var $mobile;
        var $FKteamagegroup;
        var $FKidteam;
        var $registrationdate;
        var $status;
        var $fkcompetitionmanualid;
    }

    class CoachesManagers
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
        var $kitnumber;
        var $hiredatekit;
        var $comments;
    }

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
        var $shirtsize;

    }

    class Competition 
    {
        var $idcompetition;
        var $competitionmanualid;
        var $name;
        var $year;
        var $month;
        var $type;
        var $formurl;
    }

    class PlayerDetails
    {   
        var $ffanumber;
        var $firstname;
        var $lastname;
        var $dateofbirth;
        var $gender;
        var $emailaddress;
        var $mobile;
        var $shirtsize;
    }

    class Payment
    {   
        var $FKCompetition;
        var $FFA;
        var $Name;
        var $Date;
        var $CCFName;
        var $TransactionRef;
        var $Reference;
        var $DisbursementID;
        var $Amount;
        var $CCNumber;
        var $CardHolderName;
        var $Club;

    }


    // -------------------------------------------------------------------------
    //   ListCompetitionPlayers 
    // -------------------------------------------------------------------------
    function ListCompetitionPlayers( $competition )
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                   SELECT 
                     idregistration
                    ,PLAYER.ffanumber    
                    ,firstname
                    ,lastname
                    ,dob
                    ,gender 
                    ,emailaddress
                    ,mobile
                    ,shirtsize
                    ,competitionmanualid
                    ,registrationdate
                    ,haveyouregistered
                    ,agegroupdob
                    ,igivepermission
                   FROM 
                        belnorth_players.playerdetails PLAYER, belnorth_players.registration REG
                    WHERE 
                        competitionmanualid = '".$competition."' AND
                        PLAYER.ffanumber = REG.ffanumber
                    ORDER BY lastname
                 ";
                    

        // echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        $playerfound = new Player();

        // Get input fields
        $playerfound->ffanumber = $ffanumber;

        $playerlist = array();

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
               
                $playerfound = new Player();
                $playerfound->ffanumber = $rowinner['ffanumber'];
                $playerfound->firstname = $rowinner['firstname'];
                $playerfound->lastname = $rowinner['lastname'];
                $playerfound->dateofbirth = $rowinner['dob'];
                $playerfound->emailaddress = $rowinner['emailaddress'];
                $playerfound->gender = $rowinner['gender'];
                $playerfound->haveyouregistered = $rowinner['haveyouregistered'];
                $playerfound->igivepermission = $rowinner['igivepermission'];
                $playerfound->emailaddress = $rowinner['emailaddress'];
                $playerfound->agegroupdob = $rowinner['agegroupdob'];
                $playerfound->mobile = $rowinner['mobile'];
                $playerfound->shirtsize = $rowinner['shirtsize'];

                $playerlist[] = $playerfound;
            
            }
        }

        echo (json_encode( $playerlist ));
        
    }

    // -------------------------------------------------------------------------
    //   ListCompetitionTeams
    // -------------------------------------------------------------------------
    function ListCompetitionTeams( $competition )
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                   SELECT 
                     TEAMREG.FKcompetitionmanualid
                    ,TEAMREG.FKteamagegroup   
                    ,TEAMREG.FKidteam
                    ,TEAMREG.registrationdate
                    ,TEAMREG.status
                    ,TEAM.fkagegroupid
                    ,TEAM.idteam
                    ,TEAM.name
                    ,TEAM.showindropdown
                    ,TEAM.division
                    ,TEAM.fkclubname
                    ,TEAM.shirtcolour
                    ,TEAM.gender
                    ,TEAM.contactname
                    ,TEAM.emailaddress
                    ,TEAM.mobile

                   FROM 
                        belnorth_players.teamregistration TEAMREG, belnorth_players.team TEAM
                    WHERE 
                        TEAMREG.FKcompetitionmanualid = '".$competition."'   AND  
                        TEAM.fkagegroupid = TEAMREG.FKteamagegroup AND
                        TEAM.idteam       = TEAMREG.FKidteam
                    ORDER BY fkclubname
                 ";
                    

        // echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        // $soccerteam = new SoccerTeam();

        $teamlist = array();

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
               
                $soccerteam = new SoccerTeamReg();
                $soccerteam->fkagegroupid = $rowinner['fkagegroupid'];
                $soccerteam->idteam = $rowinner['idteam'];
                $soccerteam->teamname = $rowinner['name'];
                $soccerteam->showindropdown = $rowinner['showindropdown'];
                $soccerteam->division = $rowinner['division'];
                $soccerteam->fkclubname = $rowinner['fkclubname'];
                $soccerteam->shirtcolour = $rowinner['shirtcolour'];
                $soccerteam->gender = $rowinner['gender'];
                $soccerteam->contactname = $rowinner['contactname'];
                $soccerteam->emailaddress = $rowinner['emailaddress'];
                $soccerteam->mobile = $rowinner['mobile'];
                $soccerteam->FKteamagegroup = $rowinner['FKteamagegroup'];
                $soccerteam->FKidteam = $rowinner['FKidteam'];
                $soccerteam->registrationdate = $rowinner['registrationdate'];
                $soccerteam->status = $rowinner['status'];
                $soccerteam->fkcompetitionmanualid = $rowinner['FKcompetitionmanualid'];

                $teamlist[] = $soccerteam;
           
            }
        }

        echo (json_encode( $teamlist ));
        
    }

    // -------------------------------------------------------------------------
    //   ListCompetitions
    // -------------------------------------------------------------------------
    function ListCompetitions()
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                   SELECT 
                     idcompetition
                    ,competitionmanualid   
                    ,name   
                    ,year   
                    ,month   
                    ,type   
                    ,FormURL   
                   FROM 
                    belnorth_players.competition 
                    ORDER BY idcompetition
                 ";
                    

        // echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        $competitionlist = array();

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
               
                $competition = new Competition();
                $competition->idcompetition = $rowinner['idcompetition'];
                $competition->competitionmanualid = $rowinner['competitionmanualid'];
                $competition->name = $rowinner['name'];
                $competition->year = $rowinner['year'];
                $competition->month = $rowinner['month'];
                $competition->type = $rowinner['type'];
                $competition->formurl = $rowinner['FormURL'];

                $competitionlist[] = $competition;
           
            }
        }

        echo (json_encode( $competitionlist ));
        
    }

    // -------------------------------------------------------------------------
    //   ListCompetitionCoachesManagers
    //   Esta e'a lista de coaches e managers
    // -------------------------------------------------------------------------
    function ListCompetitionCoachesManagers( $competition )
    {
       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                   SELECT 
                     COACHES.fkcompetitionmanualid
                    ,COACHES.emailaddress   
                    ,COACHES.lastname
                    ,COACHES.firstname
                    ,COACHES.mobile
                    ,COACHES.teamname
                    ,COACHES.role
                    ,COACHES.gender
                    ,COACHES.agegroup
                    ,COACHES.kitnumber
                    ,COACHES.hiredatekit
                    ,COACHES.comments
                    ,COACHES.keycolour
                    ,COACHES.keynumber
                   FROM 
                        belnorth_players.coachmanagerdetails COACHES
                    WHERE 
                        COACHES.FKcompetitionmanualid = '".$competition."'   
                    ORDER BY lastname
                 ";
                    

        // echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        // $soccerteam = new SoccerTeam();

        $coachmanagerlist = array();

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
                           
                $coachmanagerdetails = new CoachesManagers();
                $coachmanagerdetails->fkcompetitionmanualid = $rowinner['fkcompetitionmanualid'];
                $coachmanagerdetails->emailaddress = $rowinner['emailaddress'];
                $coachmanagerdetails->lastname = $rowinner['lastname'];
                $coachmanagerdetails->firstname = $rowinner['firstname'];
                $coachmanagerdetails->mobile = $rowinner['mobile'];
                $coachmanagerdetails->teamname = $rowinner['teamname'];
                $coachmanagerdetails->role = $rowinner['role'];
                $coachmanagerdetails->gender = $rowinner['gender'];
                $coachmanagerdetails->agegroup = $rowinner['agegroup'];
                $coachmanagerdetails->kitnumber = $rowinner['kitnumber'];
                $coachmanagerdetails->hiredatekit = $rowinner['hiredatekit'];
                $coachmanagerdetails->comments = $rowinner['comments'];
                $coachmanagerdetails->keycolour = $rowinner['keycolour'];
                $coachmanagerdetails->keynumber = $rowinner['keynumber'];

                $coachmanagerlist[] = $coachmanagerdetails;
            }
        }

        echo (json_encode( $coachmanagerlist ));
    }


    // -------------------------------------------------------------------------
    //   GetCompetitionCoach
    //   Get info for a single coach - manager
    // -------------------------------------------------------------------------
    function GetCompetitionCoach( $competition, $emailaddress )
    {
       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                   SELECT 
                     COACHES.fkcompetitionmanualid
                    ,COACHES.emailaddress   
                    ,COACHES.lastname
                    ,COACHES.firstname
                    ,COACHES.mobile
                    ,COACHES.teamname
                    ,COACHES.role
                    ,COACHES.gender
                    ,COACHES.agegroup
                    ,COACHES.kitnumber
                    ,COACHES.hiredatekit
                    ,COACHES.comments
                    ,COACHES.keycolour
                    ,COACHES.keynumber
                   FROM 
                        belnorth_players.coachmanagerdetails COACHES
                    WHERE 
                        COACHES.FKcompetitionmanualid = '".$competition."' AND
                        COACHES.emailaddress = '".$emailaddress."'
                 ";
                    

        // echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        // $soccerteam = new SoccerTeam();

        $coachmanagerout = new CoachesManagers();

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
                           
                $coachmanagerdetails = new CoachesManagers();
                $coachmanagerdetails->fkcompetitionmanualid = $rowinner['fkcompetitionmanualid'];
                $coachmanagerdetails->emailaddress = $rowinner['emailaddress'];
                $coachmanagerdetails->lastname = $rowinner['lastname'];
                $coachmanagerdetails->firstname = $rowinner['firstname'];
                $coachmanagerdetails->mobile = $rowinner['mobile'];
                $coachmanagerdetails->teamname = $rowinner['teamname'];
                $coachmanagerdetails->role = $rowinner['role'];
                $coachmanagerdetails->gender = $rowinner['gender'];
                $coachmanagerdetails->agegroup = $rowinner['agegroup'];
                $coachmanagerdetails->kitnumber = $rowinner['kitnumber'];
                $coachmanagerdetails->comments = $rowinner['comments'];
                $coachmanagerdetails->keycolour = $rowinner['keycolour'];
                $coachmanagerdetails->keynumber = $rowinner['keynumber'];

                // Single coach returned
                $coachmanagerout = $coachmanagerdetails;
                break;
            }
        }

        echo (json_encode( $coachmanagerout ));
    }


    // -------------------------------------------------------------------------
    //   UpdateKitDetails
    //   Update Details
    // -------------------------------------------------------------------------
    function UpdateKitDetails( $competition, $emailaddress, $kitid, $datechanged, $comments )
    {
       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;
       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

        //----------------------------------------------------------


        if ( $kitid == "" || $datechanged == "" )
        {
            // do nothing
            echo 'empty parms';
        }
        else
        {
            // echo "<div></div>"  ;
            // echo 'sql..';
            
            $sql = 
                "
                UPDATE belnorth_players.coachmanagerdetails 
                SET kitnumber   = '".$kitid."'
                    ,hiredatekit = '".$datechanged."'
                    ,comments = '".$comments."'
                WHERE 
                FKcompetitionmanualid = '".$competition."' AND
                emailaddress = '".$emailaddress."'
                "; 

        // echo "<div></div>"  ;
        // echo $sql;

            if ($mysqli->query($sql) === TRUE) {
        //		    echo "Record updated successfully";
            } else {
        //		    echo "Error updating record: " . $mysqli->error;
            }
        }

        //-----------------------------------------------------------


        $sqlinner = "
                    SELECT 
                        COACHES.fkcompetitionmanualid
                        ,COACHES.emailaddress   
                        ,COACHES.lastname
                        ,COACHES.firstname
                        ,COACHES.mobile
                        ,COACHES.teamname
                        ,COACHES.role
                        ,COACHES.gender
                        ,COACHES.agegroup
                        ,COACHES.kitnumber
                        ,COACHES.hiredatekit
                        ,COACHES.comments
                    FROM 
                            belnorth_players.coachmanagerdetails COACHES
                        WHERE 
                            COACHES.FKcompetitionmanualid = '".$competition."' AND
                            COACHES.emailaddress = '".$emailaddress."'
                    ";
                        

                    //  echo "<div></div>"  ;
                    //  echo $sqlinner;

            $r_queryinner = $mysqli->query($sqlinner);

            // $soccerteam = new SoccerTeam();

            $coachmanagerout = new CoachesManagers();

            if ( $r_queryinner )
            {
                while ($rowinner = mysqli_fetch_assoc($r_queryinner))
                {
                            
                    $coachmanagerdetails = new CoachesManagers();
                    $coachmanagerdetails->fkcompetitionmanualid = $rowinner['fkcompetitionmanualid'];
                    $coachmanagerdetails->emailaddress = $rowinner['emailaddress'];
                    $coachmanagerdetails->lastname = $rowinner['lastname'];
                    $coachmanagerdetails->firstname = $rowinner['firstname'];
                    $coachmanagerdetails->mobile = $rowinner['mobile'];
                    $coachmanagerdetails->teamname = $rowinner['teamname'];
                    $coachmanagerdetails->role = $rowinner['role'];
                    $coachmanagerdetails->gender = $rowinner['gender'];
                    $coachmanagerdetails->agegroup = $rowinner['agegroup'];
                    $coachmanagerdetails->kitnumber = $rowinner['kitnumber'];
                    $coachmanagerdetails->hiredatekit = $rowinner['hiredatekit'];
                    $coachmanagerdetails->comments = $rowinner['comments'];

                    // Single coach returned
                    $coachmanagerout = $coachmanagerdetails;
                    break;
                }
            }

        echo (json_encode( $coachmanagerout ));
    }


    // -------------------------------------------------------------------------
    //   UpdateKitKeyDetails
    //   Update Details
    // -------------------------------------------------------------------------
    function UpdateKitKeyDetails( $competition, $emailaddress, $kitid, $datechanged, $comments, $keycolour, $keynumber )
    {
       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;
       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       //----------------------------------------------------------


        // echo "<div></div>"  ;
        // echo 'sql..';
        
        $sql = 
            "
            UPDATE belnorth_players.coachmanagerdetails 
            SET kitnumber   = '".$kitid."'
                ,hiredatekit = '".$datechanged."'
                ,comments = '".$comments."'
                ,keycolour = '".$keycolour."'
                ,keynumber = '".$keynumber."'
            WHERE 
            FKcompetitionmanualid = '".$competition."' AND
            emailaddress = '".$emailaddress."'
            "; 

        echo "<div></div>"  ;
        echo $sql;

        if ($mysqli->query($sql) === TRUE) 
        {
        //		    echo "Record updated successfully";
        } else {
        //		    echo "Error updating record: " . $mysqli->error;
        }

        //-----------------------------------------------------------


        $sqlinner = "
        SELECT 
            COACHES.fkcompetitionmanualid
        ,COACHES.emailaddress   
        ,COACHES.lastname
        ,COACHES.firstname
        ,COACHES.mobile
        ,COACHES.teamname
        ,COACHES.role
        ,COACHES.gender
        ,COACHES.agegroup
        ,COACHES.kitnumber
        ,COACHES.hiredatekit
        ,COACHES.comments
        ,COACHES.keycolour
        ,COACHES.keynumber
        FROM 
            belnorth_players.coachmanagerdetails COACHES
        WHERE 
            COACHES.FKcompetitionmanualid = '".$competition."' AND
            COACHES.emailaddress = '".$emailaddress."'
        ";
                    

        //  echo "<div></div>"  ;
        //  echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        // $soccerteam = new SoccerTeam();

        $coachmanagerout = new CoachesManagers();

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
                        
                $coachmanagerdetails = new CoachesManagers();
                $coachmanagerdetails->fkcompetitionmanualid = $rowinner['fkcompetitionmanualid'];
                $coachmanagerdetails->emailaddress = $rowinner['emailaddress'];
                $coachmanagerdetails->lastname = $rowinner['lastname'];
                $coachmanagerdetails->firstname = $rowinner['firstname'];
                $coachmanagerdetails->mobile = $rowinner['mobile'];
                $coachmanagerdetails->teamname = $rowinner['teamname'];
                $coachmanagerdetails->role = $rowinner['role'];
                $coachmanagerdetails->gender = $rowinner['gender'];
                $coachmanagerdetails->agegroup = $rowinner['agegroup'];
                $coachmanagerdetails->kitnumber = $rowinner['kitnumber'];
                $coachmanagerdetails->hiredatekit = $rowinner['hiredatekit'];
                $coachmanagerdetails->comments = $rowinner['comments'];
                $coachmanagerdetails->keycolour = $rowinner['keycolour'];
                $coachmanagerdetails->keynumber = $rowinner['keynumber'];

                // Single coach returned
                $coachmanagerout = $coachmanagerdetails;
                break;
            }
        }
        echo (json_encode( $coachmanagerout ));
    }

?>
