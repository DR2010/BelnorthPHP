
$agegroup = $_POST['agegroup'];
$teamname = $_POST['teamname'];

if ($teamname != "" )
{
	showlocation( $agegroup, $teamname ); 
}


function showlocation( $agegroup, $teamname )
{

	$db_hostname = 'belnorth.com';
	$db_username = 'belnorth_machado';
	$db_password = 'M@ch@d)';
	$db_database = 'belnorth_players';

	$mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

	$lastnameUpper = strtoupper( $lastname );
	$playerteam = "";
	
 	$sqlplayer = "SELECT fkagegroupid, idteam, division FROM team where name like '%".$teamname."%'";

	$r_queryteam = $mysqli->query($sqlplayer);
	
	if ( $r_queryteam->num_rows > 0  )
	{		
		echo '<table class="table" align="center" border="1" >';
		echo '<th>Age Group</th>';
		echo '<th>Team</th>';
		echo '<th>Division</th>';
		
		while ($rowteam = mysqli_fetch_assoc($r_queryteam))
		{
			echo '<tr>';
			echo '<td>'.$rowteam['fkagegroupid'].'</td>';
			echo '<td>'.$rowteam['idteam'].'</td>';
			echo '<td>'.$rowteam['division'].'</td>';
			echo '</tr>';
		}
		
		echo '</table>';
		echo '<p/>';
	}
}


echo "<form method=post name=f1 action=''>";


echo "<p>Age Group:</p> "; 
echo "<select name='agegroup' id='agegroup' required onchange="">
			echo '<Option value="">Select...</option>';
			echo '</select>';
			echo '<Option value="U10">U10</option>';
			echo '<Option value="U11">U11</option>';
			echo '<Option value="U12">U12</option>';
			echo '<Option value="U13">U13</option>';
			echo '<Option value="U14">U14</option>';
			echo '<Option value="U15">U15</option>';
			echo '<Option value="U16">U16</option>';
    	    echo '<Option value="U17">U17</option>';
            echo '<Option value="U18">U18</option>';
echo "<p/>";

echo "<p>Team:</p> ";
echo "<select multiple name='teamname' id='teamname' required>";
			echo '<Option value="">Select...</option>';
			echo '<Option value="Back">Back</option>';
			echo '<Option value="Midfield">Midfield</option>';
			echo '<Option value="Attack">Attack</option>';
			echo '<Option value="Keeper">Goalkeeper</option>';
			echo '</select>';

echo "<p/>";

echo '<select name="meal" id="meal" onChange="changecat(this.value);">';
echo '<option value="" disabled selected>Select</option>';
echo '<option value="A">A</option>';
echo '<option value="B">B</option>';
echo '<option value="C">C</option>';
echo '</select>';
echo '<select name="category" id="category">';
echo '<option value="" disabled selected>Select</option>';
echo '</select>';

echo "<p/>";

echo "<input type=submit value=Submit>";

echo "</form>";


