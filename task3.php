<?php
declare(strict_types=1);

function nextNumber(string $letter)
{
    ++$letter;
    if(strlen($letter)>1)
    {
     $letter=$letter[0];
    echo $letter;
    }
    else
    {
        echo $letter;
    }
}

nextNumber('z')

?>