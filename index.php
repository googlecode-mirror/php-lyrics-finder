<?

/* 
    PHP Lyrics Finder - Find LYRICS For YOU !
    Copyright (C) 2012  Mohd Shahril

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

echo "<LINK REL=StyleSheet HREF='style.css' TYPE='text/css' MEDIA=screen>";

// Disable Error display and other problem
error_reporting(0);
set_time_limit(0);
ini_set('error_log',NULL);
ini_set('max_execution_time',0);
ini_set('log_errors',0);

// If plugins and other important file/folder exist, then include them
if(file_exists("function.php")){ include('function.php'); }else{ echo "<h1><center>function.php not found ! </center></h1>";die(); }
if(file_exists("config.php")){ include('config.php'); }else{ echo "<h1><center>config.php not found ! </center></h1>";die();  }
if(!file_exists("plugins") && !is_dir("plugins")){ echo "<h1><center>PLUGINS folder not found ! </center></h1>";die(); }

echo "<form method=POST>";

if (!isset($_REQUEST['lyrics'])) {
	?> 
	<br><center>
	<h1> Lyrics Finder </h1>
	<br>
	<b>Engine = </b>
	<select name=plugins>
		<?
		foreach(list_plugins() as $option){
			$rename = rename_plugins($option); // rename to replace plugins name with another character
			echo "<option value=\"".$rename."\">".$rename."</option>";
		}
		?>
	</select>
	</center>
	<?
}

// If admin/user enable curl, so this section will show
if (isset($curl) && $curl == "TRUE" && !isset($_REQUEST['lyrics']) && !isset($_POST['lagu'])) { 
	echo "<br><center><b> Curl Status : </b><font color='red'>".curl_status($curl)."</font></center>";
}

// If user select his lyrics from list in search, this section will start
if(isset($_REQUEST['lyrics']) && !empty($_REQUEST['lyrics'])) {
	$getplugins = encode_url($_REQUEST['lyrics'], "decode");
	$getplugins = explode(":", $getplugins);
	if(!strpos("$getplugins[2]", ".")) { echo "<center>Error!</center>";die(); } // Verified data so user can't include file from another source
	$plugins = str_replace('.', '_', $getplugins[2]).".php"; // Rename data that been send by POST request
	include($plugins); // Include plugins
	$class = new lyrics;
	$class->get_result($_REQUEST['lyrics']);
	
	// Show credit and close php after all lyrics was execute 
	credit();
	die();
}
?>
<center>
<br>
<input type=text name='lagu'
value='<? if(isset($_POST['lagu'])){echo strip_tags($_POST['lagu']);} ?>'> <input
type=submit value='search'>
</form>
</center>
<?

// If user make lyrics request, this section will start
if(isset($_POST['lagu']) && !empty($_POST['lagu'])) {
	if(!strpos($_POST['plugins'], ".")) { echo "<center>Error!</center>";die(); } // Verified data so user can't include file from another source
	$plugins = "plugins/".str_replace('.', '_', $_POST['plugins']).".php"; // Rename data that been send by POST request
	include($plugins); // Include plugins
	$class = new lyrics;
	$class->search_result(strip_tags($_POST['lagu']), $plugins);
} else {
	echo("<center><font color='red'>Please Insert Song Name</font></center>"); 
}
credit();

?>