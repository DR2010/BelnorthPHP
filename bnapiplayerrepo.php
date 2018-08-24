<?php
	/*
	Team Repository
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
    if ( $remoteip == '13.75.157.255' || $remoteip == '1.40.128.147' || $remoteip == '1.41.14.183')  { 
        // All good
    }
    else  {
        echo 'access denied';
        exit();
    }

    // http://belnorth.com/api/bnapiplayerrepo.php?action=getplayer&ffanumber=222222222&lastname=Machado&dateofbirth=2004-10-10&debug=Y
        
    switch ($action) {
        case 'getplayer':
            getPlayer( $ffanumber, $debug ); 
            break;
        case 'getplayerdetails':
            getplayerdetails( $ffanumber ); 
            break;
        case 'getpaymentdetails':
            getpaymentdetails( $ffanumber ); 
            break;
        case 'getteam':
            getTeam( $infkagegroupid, $inteamid ); 
            break;
        case 'getPlayersGrading':
            getPlayersGrading(); 
            break;
        case 'ListCompetitionPlayers':
            ListCompetitionPlayers( $competition ); 
            break;
        case 'ListCompetitionTeams':
            ListCompetitionTeams( $competition ); 
            break;
        case 'CountCompetitionTeams':
            CountCompetitionTeams( $competition ); 
            break;
        case 'ListCompetitionTeamNames':
            ListCompetitionTeamNames( $competition ); 
            break;
        case 'ListCompetitionCoachesManagers':
            ListCompetitionCoachesManagers( $competition ); 
            break;
        case 'ListCompetitions':
            ListCompetitions(); 
            break;
        case 'listteams':
            listteams(); 
        break;
        case 'payments':
            listPlayerTransactionPayment(); 
        break;
        case 'addteam':
            insertteam( $infkagegroupid, $inteamid, $name, $showindropdown, $IsGungahlinTeam, $division );
            break;
    }
    
    // if (  $gameid != "") {
    //     getGame( $gameid ); 
    // }
    // else {
    //     GetGameIDByOther( $indate, $inhometeam, $inawayteam, $inagegroupid );
    // }
        
        
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

    class TeamNameRegistration
    {   
        var $idteam;
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
    //   Retrieve player details
    // -------------------------------------------------------------------------
    function getPlayer( $ffanumber, $debug  )
    {

        if ( $debug == "Y" )
        {   echo 'ffanumber:';
            echo $ffanumber;
        }


       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                 SELECT 
                 ffanumber   
                 ,firstname
                 ,lastname
                 ,dob
                 ,emailaddress
                 ,gender 
                 ,display 
                 ,fkagegroupid
                 ,fkteamid
                 ,trialagegroup
                 ,trialopengirls
                 ,haveyouregistered
                 ,igivepermission
                 ,BIBnumber
                 ,posBack
                 ,posMidfield
                 ,posAttack
                 ,posKeeper
                 ,agegroupdob
                 ,mobile
                 ,olderinterested
                 ,olderagetrial 
                  FROM player 
                 WHERE ffanumber = '".$ffanumber."' ";
                    
        $r_queryinner = $mysqli->query($sqlinner);

        $playerfound = new Player();

        if ($ffanumber == "")
        {
            echo (json_encode( $playerfound ));
            return;
        }

        // Get input fields
        $playerfound->ffanumber = $ffanumber;

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
               
                $playerfound->firstname = $rowinner['firstname'];
                $playerfound->lastname = $rowinner['lastname'];
                $playerfound->dateofbirth = $rowinner['dob'];
                $playerfound->emailaddress = $rowinner['emailaddress'];
                $playerfound->gender = $rowinner['gender'];
                $playerfound->display = $rowinner['display'];
                $playerfound->fkagegroupid = $rowinner['fkagegroupid'];
                $playerfound->fkteamid = $rowinner['fkteamid'];
                $playerfound->trialagegroup = $rowinner['trialagegroup'];
                $playerfound->trialopengirls = $rowinner['trialopengirls'];
                $playerfound->haveyouregistered = $rowinner['haveyouregistered'];
                $playerfound->igivepermission = $rowinner['igivepermission'];
                $playerfound->BIBnumber = $rowinner['BIBnumber'];
                $playerfound->emailaddress = $rowinner['emailaddress'];
                $playerfound->posBack = $rowinner['posBack'];
                $playerfound->posMidfield = $rowinner['posMidfield'];
                $playerfound->posAttack = $rowinner['posAttack'];
                $playerfound->posKeeper = $rowinner['posKeeper'];
                $playerfound->agegroupdob = $rowinner['agegroupdob'];
                $playerfound->mobile = $rowinner['mobile'];
                $playerfound->olderinterested = $rowinner['olderinterested'];
                $playerfound->olderagetrial = $rowinner['olderagetrial'];
                break;
            }
        }

        if ( $debug == "Y" )
        {
            echo $sqlinner;
        }

        echo (json_encode( $playerfound ));
    }

    // -------------------------------------------------------------------------
    //   List Grading Players 
    // -------------------------------------------------------------------------
    function getPlayersGrading()
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                 SELECT 
                 ffanumber   
                 ,firstname
                 ,lastname
                 ,dob
                 ,emailaddress
                 ,gender 
                 ,display 
                 ,fkagegroupid
                 ,fkteamid
                 ,trialagegroup
                 ,trialopengirls
                 ,haveyouregistered
                 ,igivepermission
                 ,BIBnumber
                 ,posBack
                 ,posMidfield
                 ,posAttack
                 ,posKeeper
                 ,agegroupdob
                 ,mobile
                 ,olderinterested
                 ,olderagetrial 
                 FROM player 
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
                $playerfound->dateofbirth = $rowinner['dob'];
                $playerfound->firstname = $rowinner['firstname'];
                $playerfound->lastname = $rowinner['lastname'];
                $playerfound->emailaddress = $rowinner['emailaddress'];
                $playerfound->gender = $rowinner['gender'];
                $playerfound->display = $rowinner['display'];
                // $playerfound->fkagegroupid = $rowinner['fkagegroupid'];
                // $playerfound->fkteamid = $rowinner['fkteamid'];
                $playerfound->trialagegroup = $rowinner['trialagegroup'];
                $playerfound->trialopengirls = $rowinner['trialopengirls'];
                $playerfound->haveyouregistered = $rowinner['haveyouregistered'];
                $playerfound->igivepermission = $rowinner['igivepermission'];
                $playerfound->BIBnumber = $rowinner['BIBnumber'];
                $playerfound->emailaddress = $rowinner['emailaddress'];
                $playerfound->posBack = $rowinner['posBack'];
                $playerfound->posMidfield = $rowinner['posMidfield'];
                $playerfound->posAttack = $rowinner['posAttack'];
                $playerfound->posKeeper = $rowinner['posKeeper'];
                $playerfound->agegroupdob = $rowinner['agegroupdob'];
                $playerfound->mobile = $rowinner['mobile'];
                $playerfound->olderinterested = $rowinner['olderinterested'];
                $playerfound->olderagetrial = $rowinner['olderagetrial'];

                $playerlist[] = $playerfound;
            
            }
        }

        echo (json_encode( $playerlist ));
        
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
    //   ListCompetitionTeamNames
    // -------------------------------------------------------------------------
    function ListCompetitionTeamNames( $competition )
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                   SELECT 
                          TEAMREG.FKidteam idteam
                   FROM 
                        belnorth_players.teamregistration TEAMREG, belnorth_players.team TEAM
                    WHERE 
                        TEAMREG.FKcompetitionmanualid = '".$competition."'   AND  
                        TEAM.fkagegroupid = TEAMREG.FKteamagegroup AND
                        TEAM.idteam       = TEAMREG.FKidteam
                    ORDER BY TEAMREG.FKidteam
                 ";
                   

        // echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        $teamlist = array();

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
               
                $soccerteam = new TeamNameRegistration();
                $soccerteam->idteam = $rowinner['idteam'];

                $teamlist[] = $soccerteam;
           
            }
        }

        echo (json_encode( $teamlist ));
        
    }

    // -------------------------------------------------------------------------
    //   CountCompetitionTeams
    // -------------------------------------------------------------------------
    function CountCompetitionTeams( $competition )
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                   SELECT 
                          count(*) numberofteams
                   FROM 
                        belnorth_players.teamregistration TEAMREG, belnorth_players.team TEAM
                    WHERE 
                        TEAMREG.FKcompetitionmanualid = '".$competition."'   AND  
                        TEAM.fkagegroupid = TEAMREG.FKteamagegroup AND
                        TEAM.idteam       = TEAMREG.FKidteam
                    ORDER BY TEAMREG.FKidteam
                 ";
                   

        // echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        $numberofteams = 0;

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
              
                $numberofteams = $rowinner['numberofteams'];
                break;
         
            }
        }

        echo (json_encode( $numberofteams ));
        
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
    //   List Grading Players 
    // -------------------------------------------------------------------------
    function listPlayerTransactionPayment()
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "

       SELECT   FKCompetition,
                FFA,
                Name,
                Date,
                CCFName,
                TransactionRef,
                Reference,
                Disbursement_ID,
                Amount,
                CC_Number,
                Card_Holder_Name,
                Club
         FROM   playertransactionpayment
         ORDER BY Name
                 ";
                    

        // echo $sqlinner;

        $r_queryinner = $mysqli->query($sqlinner);

        $paymentrow = new Payment();

        // Get input fields
        $paymentrow->FFA = $ffanumber;

        $paymentlist = array();

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
                $paymentrow = new Payment();
                $paymentrow->FKCompetition = $rowinner['FKCompetition'];
                $paymentrow->FFA = $rowinner['FFA'];
                $paymentrow->Name = $rowinner['Name'];
                $paymentrow->Date = $rowinner['Date'];
                $paymentrow->CCFName = $rowinner['CCFName'];
                $paymentrow->TransactionRef = $rowinner['TransactionRef'];
                $paymentrow->Reference = $rowinner['Reference'];
                $paymentrow->DisbursementID = $rowinner['Disbursement_ID'];
                $paymentrow->Amount = $rowinner['Amount'];
                $paymentrow->CCNumber = $rowinner['CC_Number'];
                $paymentrow->CardHolderName = $rowinner['Card_Holder_Name'];
                $paymentrow->Club = $rowinner['Club'];
                $paymentlist[] = $paymentrow;
            
            }
        }

        echo (json_encode( $paymentlist ));
        
    }

    // -------------------------------------------------------------------------
    //   Retrieve team details
    // -------------------------------------------------------------------------
    function getTeam( $infkagegroupid, $inteamid )
    {

        global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

        $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                 SELECT 
                 fkagegroupid   
                 ,idteam 
                 ,division 
                 ,name 
                 ,showindropdown
                 ,IsGungahlinTeam 
                  FROM team 
                 WHERE idteam = '".$inteamid."' and fkagegroupid like '%" . trim($infkagegroupid) . "%' ";
                    
        $r_queryinner = $mysqli->query($sqlinner);

        $teamlist = array();
        
        $team = new Team();
        $team->NameID = "Not found";
        
        
        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {


                $team->FKAgeGroupID = $rowinner['fkagegroupid'];
                $team->UID = $rowinner['idteam'];
                $team->FKDivisionID = $rowinner['division'];
                $team->NameID = $rowinner['name'];
                $team->showindropdown = $rowinner['showindropdown'];
                $team->IsGungahlinTeam = $rowinner['IsGungahlinTeam'];

                $teamlist[] = $team;
                
                break;

            }
        }

       // echo $sqlinner;

        echo (json_encode( $team ));
        
    }

    // -----------------------------------------------------------------
    //    Insert Team 
    // -----------------------------------------------------------------
    function insertteam( $fkagegroupid, $idteam, $name, $showindropdown, $IsGungahlinTeam, $division )
    {
        echo '<p/>fkagegroupid: ';
        echo $fkagegroupid;
        echo '<p/>idteam: ';
        echo $idteam;
        echo '<p/>name: ';
        echo $name;
        echo '<p/>showindropdown : ';
        echo $showindropdown;
        echo '<p/>IsGungahlinTeam :';
        echo $IsGungahlinTeam;
        echo '<p/>division: ';
        echo $division;
        echo '<p/>';
        
        
        
        global $db_hostname,$db_username,$db_password, $db_database, $mysqli;  

        $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);


        if ( $fkagegroupid == "" || $idteam == "" || $name == ""  )
        {
            // do nothing
            echo 'empty parms';
        }
        else
        {
            // echo 'sql..';
            
            $sql = 
                "
                   INSERT INTO team 
                   (
                     fkagegroupid   
                     ,idteam 
                     ,name 
                     ,showindropdown 
                     ,IsGungahlinTeam 
                     ,division 
                   )
                     VALUES  
                   ( 
                      '".$fkagegroupid.  "','"
                       .$idteam.         "','"
                       .$name.           "','"
                       .$showindropdown. "','"
                       .$IsGungahlinTeam."','"
                       .$division.
                      "')"; 
            
            echo $sql;
        
            if ($mysqli->query($sql) === TRUE) {
    //		    echo "Record updated successfully";
            } else {
    //		    echo "Error updating record: " . $mysqli->error;
            }
            
            // echo $sql;
            
        }
    //	echo '</p>';
    //	echo $gameid;
    //	echo '</p>';
    //	echo $refereeid;

        $mysqli->close();
    }




    // -------------------------------------------------------------------------
    //   List all teams
    // -------------------------------------------------------------------------
    function listteams()
    {

        global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

        $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                 SELECT 
                 fkagegroupid   
                 ,idteam 
                 ,division 
                 ,name 
                 ,showindropdown
                 ,IsGungahlinTeam 
                  FROM team 
                 ORDER BY fkagegroupid, idteam ";
                    
        $r_queryinner = $mysqli->query($sqlinner);

        $teamlist = array();
        

        
        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {

                $team = new Team();
                $team->FKAgeGroupID = strtoupper($rowinner['fkagegroupid']);
                $team->UID = $rowinner['idteam'];
                $team->FKDivisionID = $rowinner['division'];
                $team->NameID = strtoupper($rowinner['name']);
                $team->showindropdown = $rowinner['showindropdown'];
                $team->IsGungahlinTeam = $rowinner['IsGungahlinTeam'];

                $teamlist[] = $team;

            }
        }

       // echo $sqlinner;

        echo (json_encode( $teamlist ));
    }

    // -------------------------------------------------------------------------
    //   Retrieve player details - from details table
    // -------------------------------------------------------------------------
    function getPlayerDetails( $ffanumber  )
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "
                 SELECT 
                 ffanumber   
                 ,firstname
                 ,lastname
                 ,dob
                 ,emailaddress
                 ,gender 
                 ,mobile
                 ,shirtsize
                  FROM playerdetails 
                 WHERE ffanumber = '".$ffanumber."' ";
                    
        $r_queryinner = $mysqli->query($sqlinner);

        $playerfound = new PlayerDetails();

        if ($ffanumber == "")
        {
            echo (json_encode( $playerfound ));
            return;
        }

        // Get input fields
        $playerfound->ffanumber = $ffanumber;

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
               
                $playerfound->dateofbirth = $rowinner['dob'];
                $playerfound->firstname = $rowinner['firstname'];
                $playerfound->lastname = $rowinner['lastname'];
                $playerfound->emailaddress = $rowinner['emailaddress'];
                $playerfound->gender = $rowinner['gender'];
                $playerfound->emailaddress = $rowinner['emailaddress'];
                $playerfound->mobile = $rowinner['mobile'];
                $playerfound->shirtsize = $rowinner['shirtsize'];
                break;
            }
        }

        if ( $debug == "Y" )
        {
            echo $sqlinner;
        }

        echo (json_encode( $playerfound ));
    }

    
    // -------------------------------------------------------------------------
    //   getPaymentDetails
    // -------------------------------------------------------------------------
    function getPaymentDetails( $ffanumber  )
    {

       global $db_hostname,$db_username,$db_password, $db_database, $mysqli;

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

       $sqlinner = "


       SELECT   FKCompetition,
                FFA,
                Name,
                Date,
                CCFName,
                TransactionRef,
                Reference,
                Disbursement_ID,
                Amount,
                CC_Number,
                Card_Holder_Name,
                Club
         FROM   playertransactionpayment
        WHERE   FFA = '".$ffanumber."' ";
                    
        $r_queryinner = $mysqli->query($sqlinner);

        $paymentrow = new Payment();

        if ($ffanumber == "")
        {
            echo (json_encode( $paymentrow ));
            return;
        }

        // Get input fields
        $paymentrow->FFA = $ffanumber;

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
               
                $paymentrow->FKCompetition = $rowinner['FKCompetition'];
                $paymentrow->FFA = $rowinner['FFA'];
                $paymentrow->Name = $rowinner['Name'];
                $paymentrow->Date = $rowinner['Date'];
                $paymentrow->CCFName = $rowinner['CCFName'];
                $paymentrow->TransactionRef = $rowinner['TransactionRef'];
                $paymentrow->Reference = $rowinner['Reference'];
                $paymentrow->DisbursementID = $rowinner['Disbursement_ID'];
                $paymentrow->Amount = $rowinner['Amount'];
                $paymentrow->CCNumber = $rowinner['CC_Number'];
                $paymentrow->CardHolderName = $rowinner['Card_Holder_Name'];
                $paymentrow->Club = $rowinner['Club'];
                break;
            }
        }

        if ( $debug == "Y" )
        {
            echo $sqlinner;
        }

        echo (json_encode( $paymentrow ));
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

                // Single coach returned
                $coachmanagerout = $coachmanagerdetails;
                break;
            }
        }

        echo (json_encode( $coachmanagerout ));
    }


?>
