<?php
 $num1=10;
 $num2=20;
 echo "the value of the first number before swap =" .$num1;
 echo "<br>";
 echo "the value of the second number before swap =" .$num2;
echo "<br>";
 $num1=$num1+$num2;
 $num2=$num1-$num2;
 $num1=$num1-$num2;

 echo "the value of the first number after swap =" .$num1;
 echo "<br>";
 echo "the value of the second number after swap =" .$num2;
?>