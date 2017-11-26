<?php
	/*
	Team Repository
	*/
	
    $db_hostname = 'belnorth.com';
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
    
    // Block IP addresses
    
    // if ( ! $remoteip == '1.41.26.149')
    // {
    //     echo 'access denied';
    //     exit();
    // }

    // http://belnorth.com/api/bnapiplayerrepo.php?action=getplayer&ffanumber=222222222&lastname=Machado&dateofbirth=2004-10-10&debug=Y
        
    switch ($action) {
    case 'getplayer':
        getPlayer( $ffanumber, $dateofbirth, $lastname, $debug ); 
        break;
    case 'getteam':
        getTeam( $infkagegroupid, $inteamid ); 
        break;
    case 'listteams':
        listteams(); 
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

    }

    // -------------------------------------------------------------------------
    //   Retrieve player details
    // -------------------------------------------------------------------------
    function getPlayer( $ffanumber, $dateofbirth, $lastname, $debug  )
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
                  FROM player 
                 WHERE ffanumber = '".$ffanumber."' ";
                    
        $r_queryinner = $mysqli->query($sqlinner);

        $playerfound = new Player();

        // Get input fields
        $playerfound->ffanumber = $ffanumber;
        $playerfound->lastname = $lastname;
        $playerfound->dateofbirth = $dateofbirth;
        $playerfound->firstname = $firstname;
        

        if ( $r_queryinner )
        {
            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {
               
                if ( $debug == "Y" )
                {
                    echo '</p>playerfound->ffa:';
                    echo $playerfound->ffanumber;

                    echo '</p>playerfound->lastname:';
                    echo $playerfound->lastname;

                    echo '</p>playerfound->dateofbirth:';
                    echo $playerfound->dateofbirth;

                    echo '</p>ffa:';
                    echo $ffanumber;
                    echo '</p>lastname:';
                    echo $lastname;
                    echo '</p>dateofbirth:';
                    echo $dateofbirth;
                    echo '</p>';
                }                

                if ( $ffanumber == $playerfound->ffanumber and
                     $lastname == $playerfound->lastname   and
                     $dateofbirth == $playerfound->dateofbirth)
                {
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
                }
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
   
?>

