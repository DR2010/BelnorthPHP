<?php
    /*
    Template Name: Find Game
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
        <style>
            table, th, td {
                border: 1px solid black;
            }
    
            a.navlink:link {
                text-decoration: underline;
                background-color: #B2FF99;
            }
            a.navlink:visited {
                text-decoration: underline;
                background-color: #FFFF85;
                }
            a.navlink:active {
                text-decoration: underline;
                background-color: #FF704D;
                }
            a.navlink:hover {
                text-decoration: underline;
                background-color: #FF704D;
                }
            
        </style>
        <script language=JavaScript>
            function reload(form)
            {
                var val=form.agegroupselected.options[form.agegroupselected.options.selectedIndex].value;
                self.location='?page_id=next-game-u5-u9&agegroupselected=' + val ;
            }
            
            function reload2(form)
            {
                var val =form.agegroupselected.options[form.agegroupselected.options.selectedIndex].value;
                var val2=form.teamselected.options[form.teamselected.options.selectedIndex].value;
                self.location='?page_id=next-game-u5-u9&agegroupselected=' + val + '&teamselected=' + val2;
            }
            
        </script>        
        <meta charset="utf-8" />
        <title>Where is my team playing?</title>
    </head>
    <body>

        <?php

            // Get Age Group
            // -------------
            @$agegroupselected=$_GET['agegroupselected'];
            @$teamselected=$_GET['teamselected'];
            
            $loc = "findgame.php";
            $sql_agegroup="select idagegroup, description from agegroup where showindropdown = 'Y' order by idagegroup;";
            // $sql_team="select fkagegroupid, idteam, name from team where showindropdown = 'Y' and fkagegroupid='"
            //     .$agegroupselected."' order by fkagegroupid, idteam";

            $sql_team="select fkagegroupid, idteam, name from team where showindropdown = 'Y' and fkagegroupid like '".$agegroupselected."'  order by idteam";

            // $query_agegroup = mysqi_query($sql_agegroup, $con);

            $query_agegroup = $mysqli->query($sql_agegroup);
            
            echo "<form method=post name=f1 action=display()>";

            $todays_date = date("Y-m-d");

            echo "<p/>";
            echo "<p>This option will display the next game for your team. </p> ";
            // echo "<p>It is based on today's date: $todays_date </p> ";
            echo "<p/>";
            echo "<p>Age Group:</p> ";
            echo '<label>';
            echo "<select name='agegroupselected' onchange=\"reload(this.form)\">";
            echo '<Option value="">Select Age Group   </option>';        
            while ($rowinner = mysqli_fetch_assoc($query_agegroup))
            {
                if ($rowinner['idagegroup']==@$agegroupselected)
                {
                    echo "<option selected value='$rowinner[idagegroup]'>$rowinner[idagegroup]</option>"."<BR>";
                }
                else
                {
                    echo '<Option value="'.$rowinner['idagegroup'].'">'.$rowinner['idagegroup'].'</option>';    
                }
            }
            echo '</select>';
            echo '</label>';
            // --------------
            
            // Get Team List
            // -------------
            echo '<p/>';
            
            $query_team = $mysqli->query($sql_team);

            echo "<p>Team:</p> ";
            echo '<label>';
            echo "<select name='teamselected' onchange=\"reload2(this.form)\">";
            echo '<Option value="">Select Team   </option>';        
            
            $found = "N";
            while ($rowinnerx = mysqli_fetch_assoc($query_team))
            {

                if ($rowinnerx['idteam']==@$teamselected)
                {
                    echo "<option selected value='$rowinnerx[idteam]'>$rowinnerx[idteam]</option>";    
                    
                    $found = "Y";
                }
                else
                {
                    echo "<Option value='$rowinnerx[idteam]'>$rowinnerx[idteam]</option>";    
                }
            }
            echo '</select>';
            echo '</label>';
            echo '<p/>';
            // echo "<input type=submit value=Submit>";

            echo "</form>";

            if ($found = "Y")
            {
                display($agegroupselected, $teamselected); 
            }

        ?>
    </body>
</html>

<?php 
do_action('generate_sidebars');
get_footer();

?>

<?php

function display($agegroupselected, $teamselected)
{
        
	$db_hostname = 'localhost';
	$db_username = 'belnorth_machado';
	$db_password = 'M@ch@d)';
    $db_database = 'belnorth_players';
            
        $mysqli = new mysqli($db_hostname,$db_username,$db_password, $db_database);

        $term  = $teamselected;
        
        $sqlinner = "
                    SELECT 
                     game.gameid 
                    ,game.fkhometeamid      fkhometeamid
                    ,game.fkawayteamid      fkawayteamid
                    ,game.fkagegroupid      fkagegroupid
                    ,game.fkroundid         fkroundid
                    ,game.fkgroundplaceid   fkgroundplaceid
                    ,game.referee   referee
                    ,game.homejob   homejob
                    ,game.time      time
                    ,round.idround          idround
                    ,round.date             rounddate
                    ,groundplace.navigate   gpnavigate
                    ,groundplace.address     gpaddress 
                    ,harrisonsfieldschema.fieldid fieldid
                    ,harrisonsfieldschema.imagelocation locationinfield
                    ,case 
                        when ( round.date >= SUBDATE(now(), INTERVAL 1 DAY) and date(round.date) < ADDDATE( now(), INTERVAL 6 DAY)) then '  <<<< NEXT GAME >>>>'
                        else ''
                    end as 'next'
                 FROM game, round, groundplace, harrisonsfieldschema
                WHERE 
                 ( game.fkhometeamid = '".$term."' OR game.fkawayteamid = '".$term."')
                
                   AND game.fkagegroupid like '".$agegroupselected."%' 
                   AND game.fkgroundplaceid = groundplace.idgroundplace 
                   AND game.fkroundid = round.idround 
                   AND game.fkfieldid = harrisonsfieldschema.fieldid
                   AND ( round.date >= SUBDATE(now(), INTERVAL 1 DAY)
                   AND round.date < ADDDATE( now(), INTERVAL 6 DAY)  )
                ORDER BY round.date
                ";
                    
        $r_queryinner = $mysqli->query($sqlinner);

        $todays_date = date("Y-m-d");                        


        $msg = "No games found.";
        
        while ($rowinner = mysqli_fetch_assoc($r_queryinner))
        {    
            $msg = "";
        
            echo '<br/>';

            $mystring = $rowinner['fkhometeamid'];
            $findme   = $term;
            $pos = stripos( $mystring, $findme );

            // Note our use of ===.  Simply == would not work as expected
            // because the position of 'a' was the 0th (first) character.
            // echo '<h3>Age Group: ' .$rowinner['fkagegroupid'].'</h3>';   
            // if ($pos === false) {
                // echo '<h2> Team:      ' .$rowinner['fkawayteamid'].'</h2>';  
            // } else {
                // echo '<h2> Team:      ' .$rowinner['fkhometeamid'].'</h2>';  
            // }

            echo '<table class="task" align="center">';
            
            echo '<tr>';
            echo '   <td>Age group</td><th>'.$rowinner['fkagegroupid'].'</th>';
            echo '</tr>';

            $displaydatein = $rowinner['rounddate'];
            $displaydate = date("d/m/Y", strtotime($displaydatein));
            echo '<tr>';
            echo '   <td>Date</td><th>'.$displaydate.'</th>';
            echo '</tr>';

            echo '<tr>';
            echo '   <td>Time</td><th>'.$rowinner['time'].'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '   <td>Round</td><th>'.$rowinner['idround'].'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '   <td>Home Team</td><th>'.$rowinner['fkhometeamid'].'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '   <td>Away Team</td><th>'.$rowinner['fkawayteamid'].'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '   <td>Referee</td><th>'.$rowinner['referee'].'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '   <td>Home Job</td><th>'.$rowinner['homejob'].'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '   <td>Ground Address</td><th>'.$rowinner['gpaddress'].'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '   <td>Navigate to</td><th><a href="' .$rowinner['gpnavigate']. '" class="navlink">Show in map</a></th>';
            echo '</tr>';
            
            if (! empty( $rowinner['locationinfield'] )) 
            {
                echo '<tr>';
                echo '   <td>Field</td><th>'.$rowinner['fieldid'].'</th>';
                echo '</tr>';
            }
            
            echo '</table>';
            
            if ( ! empty( $rowinner['locationinfield'] ) ) 
            {
                echo '<br /> <img src="/wp-content/uploads/'.$rowinner['locationinfield']. '" alt="Field">';
            }
        }    

        echo '<p/>';
        echo $msg;

}
?>
