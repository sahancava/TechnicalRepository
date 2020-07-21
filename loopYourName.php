<?php

function loopYourName($input){

    $input = trim(strtoupper($input));

    $range = range('A', 'Z');

    $addedRange = array("&nbsp;");

    $letters = array_merge($addedRange,$range);

    $input = str_split($input);

    foreach ($input as $item){
        $input = array_search($item,$letters);
        $name = $letters[$input];
        echo $name;
    }

}

loopYourName("                 SAHAN CAVA ");