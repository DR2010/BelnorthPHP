<?php
	/*
	Team Repository
	*/
	
    // $db_hostname = 'belnorth.com';
    // Connection failed: Host '69.195.124.175' is blocked because of many connection errors; unblock with 'mysqladmin flush-hosts'
    // ---> Replace hostaname by localhost

    $db_hostname = 'localhost';
    $db_username = 'danieladmin';
    $db_password = 'oculos18';
    $db_database = 'fcmschema';

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
    $austbusnumber= $_GET['austbusnumber'];
   
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
    // https://constructionoutcomes.com.au/api/wp-fcmclientrepo.php?action=getclient&austbusnumber=78102725093
    // https://www.constructionoutcomes.com.au/fcmrepo.php?action=getclient&austbusnumber=78102725093
        
    switch ($action) {
        case 'getclient':
            getclient( $austbusnumber ); 
            break;
    }

    // getclient( 78102725093 ); 
    
    class Client
    {   
        var $tradingname;
        var $abn;
        var $legalname;
        var $managingdirector;
        var $projectmanager;
        var $projectrepresentative;
        var $whsauditor;
        var $companyaddress;
        var $companyphone;
        var $companyfax;
        var $companymobile;
        var $emailaddress;
        var $systemsmanager;
        var $sitemanager;
        var $supervisor;
        var $leadinghand1;
        var $leadinghand2;
        var $hsrepresentative;
        var $adminperson;
        var $datepolicy;
        var $wccoordinator;
        var $scopeofservices;
        var $actionplandate;
        var $certificationtargetdate;
        var $timetrading;
        var $regionsofoperation;
        var $seniormanagementmeeting;
        var $operationmeetingsfreq;
        var $projectmeetingsfreq;
        var $contactperson;

    }

    // -------------------------------------------------------------------------
    //   Retrieve client details
    // -------------------------------------------------------------------------
    function getclient( $austbusnumber  )
    {

        $db_hostname = 'localhost';
        $db_username = 'danieladmin';
        $db_password = 'oculos18';
        $db_database = 'fcmschema';

       $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);
       
       $sqlinner = " 
        SELECT
            tradingname, 
            austbusnumber,
            legalname,
            managingdirector,
            projectmanager,
            projectrepresentative,
            whsauditor,
            companyaddress,
            companyphone,
            companyfax,
            companymobile,
            emailaddress,
            systemsmanager,
            sitemanager,
            supervisor,
            leadinghand1,
            leadinghand2,
            hsrepresentative,
            adminperson,
            datepolicy,
            wccoordinator,
            scopeofservices,
            actionplandate,
            certificationtargetdate,
            timetrading,
            regionsofoperation,
            seniormanagementmeeting,
            operationmeetingsfreq,
            projectmeetingsfreq,
            contactperson
            FROM clientfcm
            WHERE austbusnumber = '".$austbusnumber."' ";
            

        $r_queryinner = $mysqli->query($sqlinner);

        $clientfound = new Client();

        if ($austbusnumber == "")
        {
            echo (json_encode( $clientfound ));
            return;
        }

        // Get input fields
        $clientfound->abn = $abn;

        if ( $r_queryinner )
        {

            while ($rowinner = mysqli_fetch_assoc($r_queryinner))
            {

                $clientfound->tradingname= $rowinner['tradingname'];
                $clientfound->abn= $rowinner['austbusnumber'];
                $clientfound->legalname= $rowinner['legalname'];
                $clientfound->managingdirector= $rowinner['managingdirector'];
                $clientfound->projectmanager= $rowinner['projectmanager'];
                $clientfound->projectrepresentative= $rowinner['projectrepresentative'];
                $clientfound->whsauditor= $rowinner['whsauditor'];
                $clientfound->companyaddress= $rowinner['companyaddress'];
                $clientfound->companyphone= $rowinner['companyphone'];
                $clientfound->companyfax= $rowinner['companyfax'];
                $clientfound->companymobile= $rowinner['companymobile'];
                $clientfound->emailaddress= $rowinner['emailaddress'];
                $clientfound->systemsmanager= $rowinner['systemsmanager'];
                $clientfound->sitemanager= $rowinner['sitemanager'];
                $clientfound->supervisor= $rowinner['supervisor'];
                $clientfound->leadinghand1= $rowinner['leadinghand1'];
                $clientfound->leadinghand2= $rowinner['leadinghand2'];
                $clientfound->hsrepresentative= $rowinner['hsrepresentative'];
                $clientfound->adminperson= $rowinner['adminperson'];
                $clientfound->datepolicy= $rowinner['datepolicy'];
                $clientfound->wccoordinator= $rowinner['wccoordinator'];
                $clientfound->scopeofservices= $rowinner['scopeofservices'];
                $clientfound->actionplandate= $rowinner['actionplandate'];
                $clientfound->certificationtargetdate= $rowinner['certificationtargetdate'];
                $clientfound->timetrading= $rowinner['timetrading'];
                $clientfound->regionsofoperation= $rowinner['regionsofoperation'];
                $clientfound->seniormanagementmeeting= $rowinner['seniormanagementmeeting'];
                $clientfound->operationmeetingsfreq= $rowinner['operationmeetingsfreq'];
                $clientfound->projectmeetingsfreq= $rowinner['projectmeetingsfreq'];
                $clientfound->contactperson= $rowinner['contactperson'];
                break;
            }
        }
        else
        {   
            echo "Error:";

            // echo json_encode(mysql_error()); 
            die('Could not query:' . mysql_error());
        }

        echo (json_encode( $clientfound ));
    }
  

?>
