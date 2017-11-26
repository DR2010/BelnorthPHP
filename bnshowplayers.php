echo "<form method=post name=f1 action=''>";

echo "<p/>";

echo "<p>Team Name:</p> ";
echo '<input type="text" name="teamname">';
echo '<p/>';
echo "<p/>";
echo "<input type=submit value=Submit>";

echo "</form>";

$teamname = $_POST['teamname'];

if ($teamname != "")
{
	showteam($teamname); 
}
			

function showteam( $teamname )
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