<?php
$file=fopen('blogs.txt','r') or die('unable to open file');
function deleteRecord()
{
//reading the entire file to array
$fc=file("blogs.txt"); 
echo($fc[0]);
$f=fopen("blogs.txt","w");

//loop through array using foreach

foreach($fc as $key=>$line)
{
      if (!strstr($line,$key)) //look for $key in each line
         {
             fputs($f,$line);
          } //place $line back in file
}
fclose($f);
}
while(!feof($file))
{
    echo fgets($file);
   echo "<form method=get><button type=sumbit name=delete class=btn-primary>Delete</button></form>" ;
}

if(array_key_exists('delete', $_GET))
{
    deleteRecord();
}
fclose($file);

?>

