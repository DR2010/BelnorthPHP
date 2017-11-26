
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


if ($ffanumber != "" )
{
    $player = new Player();

    $player->ffanumber = $ffanumber;
    $player->firstname = $firstname;
    $player->lastname = $lastname;
    $player->dateofbirth = $dateofbirth;
    $player->gender = $gender;
    $player->trialagegroup = $trialagegroup;
    $player->trialpreferredposition = $preferredposition;
    $player->haveyouregistered = $haveyouregistered;
	$player->emailaddress = $emailaddress;
    $player->trialopengirls = $trialopengirls;
    $player->igivepermission = "Y";
    $player->display = "Y";
    $player->fkagegroupid = "NOTDEFINED";
    $player->fkteamid = "NOTDEFINED";
    $player->BIBnumber = "0";

	showvariables(  $player ); 
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
	var $trialpreferredposition;
	var $haveyouregistered;
	var $igivepermission;
	var $BIBnumber;
	var $emailaddress;
}

function showvariables( $player )
{
	echo '<H1>Results</H1>';
	echo '<p/>';
	echo '<b>FFA Number: '.$player->ffanumber.'</b>';
	echo '<p/>';
	echo 'First Name: '.$player->firstname;
	echo '<p/>';
	echo 'Surname: '.$player->lastname;
	echo '<p/>';

	$db_hostname = 'belnorth.com';
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
		, trialpreferredposition 
		, gender 
		, display 
        , fkagegroupid
        , fkteamid
        , trialopengirls
        , haveyouregistered
        , igivepermission
        , BIBnumber


		) 
				VALUES ('" 
			.$player->ffanumber. 
		"','".$player->firstname. 
		"','".$player->lastname. 
		"','".$player->emailaddress. 
		"','".$player->dateofbirth. 
		"','".$player->trialagegroup. 
		"','".$player->trialpreferredposition. 
		"','".$player->gender. 
		"','".$player->display. 
		"','".$player->fkagegroupid. 
		"','".$player->fkteamid. 
		"','".$player->trialopengirls. 
		"','".$player->haveyouregistered. 
		"','".$player->igivepermission. 
		"','".$player->BIBnumber. 
		"')";

	if ( 
		$player->ffanumber== "" || 
		$player->firstname == "" ||
		$player->lastname == "" ||
		$player->emailaddress == "" ||
		$player->trialagegroup == "" 	
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
			echo "Error updating record: " . $mysqli->error;
		}
	}

	$mysqli->close();
}



echo "<form method=post name=f1 action=''>";

echo "<p>FFA Number:</p> ";
echo '<input type="text" name="ffanumber" required>';
echo '<p/>';

echo "<p>First Name:</p> ";
echo '<input type="text" name="firstname" required>';
echo '<p/>';

echo "<p>Last Name:</p> ";
echo '<input type="text" name="lastname" required>';
echo '<p/>';

echo "<p>Email Address:</p> ";
echo '<input type="text" name="emailaddress" required>';
echo '<p/>';

echo "<p>Date of Birth:</p> ";
echo "<input type='date' name='dateofbirth' id='dateofbirth' value='".$dateofbirth."' required>";
echo '<p/>';

echo "<p>Gender:</p> ";
echo "<select name='gender' id='gender'>";
			echo '<Option value="">Select...</option>';
			echo '<Option value="M">Male</option>';
			echo '<Option value="F">Female</option>';
			echo '<Option value="O">Other</option>';
			echo '</select>';
echo "<p/>";

echo "<p>Trials for Open or Girls:</p> ";
echo "<select name='trialopengirls' id='trialopengirls'>";
			echo '<Option value="Open">Open</option>';
			echo '<Option value="Girls">Girls</option>';
			echo '</select>';
echo "<p/>";

echo "<p>Trial for Age Group:</p> ";
echo "<select name='trialagegroup' id='trialagegroup'>";
			echo '<Option value="">Select...</option>';
			echo '<Option value="U10">U10</option>';
			echo '<Option value="U11">U11</option>';
			echo '<Option value="U12">U12</option>';
			echo '<Option value="U13">U13</option>';
			echo '<Option value="U14">U14</option>';
			echo '<Option value="U15">U15</option>';
			echo '<Option value="U16">U16</option>';
			echo '<Option value="U17">U17</option>';
			echo '<Option value="U18">U18</option>';
			echo '</select>';
echo "<p/>";

echo "<p>Preferred Position:</p> ";
echo '<ul>';
echo '<li><input type="checkbox" name="posBack" id="chk1">Back</li>';
echo '<li><input type="checkbox" name="posMidfield" id="chk2">Midfield</li>';
echo '<li><input type="checkbox" name="posAttack" id="chk3">Attack</li>';
echo '<li><input type="checkbox" name="posKeeper" id="chk4">Goalkeeper</li>';
echo '</ul>';

  echo "<p/>";

echo "<p>Have you registered with myfootball:</p> ";
echo "<select name='haveyouregistered' id='haveyouregistered' required>";
			echo '<Option value="">Select...</option>';
			echo '<Option value="Y">Yes</option>';
			echo '<Option value="N">No</option>';
			echo '</select>';
echo "<p/>";

echo "<p/>";

echo "<input type=submit value=Submit>";

echo "</form>";
