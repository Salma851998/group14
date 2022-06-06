<?php
declare(strict_types=1);
function returnText(string $url)
{
  $pos=strpos($url,'/',$offset=-10);
  
 for($i=++$pos;$i<strlen($url);$i++)
 {
    echo $url[$i];  
 } 
}
returnText('http://www.example.com/547')
?>