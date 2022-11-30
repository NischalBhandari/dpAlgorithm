<?php

$solution = [];

function calculateMaximum(&$ballons)
{

    $count = count($ballons);

    $rows = array_fill(0,$count*2,0);
    $solution = array_fill(0,$count*2,$rows);
    for($s=0; $s<$count+1; $s++){
        for($i=0; $i<$count;$i++){
            for($j=$i;$j<$i+$s;$j++){
                $preMultiplier = 1;
                $postMultiplier = 1;
                if(array_key_exists($i-1,$ballons)){
                    $preMultiplier = $ballons[$i-1];
                }
                if(array_key_exists($i+$s,$ballons)){
                    $postMultiplier = $ballons[$i+$s];
                }
                $prepend = 0;
                $postpend = 0;
                $main = 0;

                if(array_key_exists($i,$solution)){
                    if(array_key_exists($j-1,$solution[$i])){
                        $prepend = $solution[$i][$j-1];
                    }
                }
                if(array_key_exists($j+1,$solution)){
                    if(array_key_exists($i+$s-1,$solution[$j+1])){
                        $postpend = $solution[$j+1][$i+$s-1];
                    }
                }
                if(array_key_exists($j,$ballons)){
                    $main = $ballons[$j];
                }
            //    echo $i+$s-1;
                // $solution[$i][$i+$s-1]= max($solution[$i][$i+$s-1], 
                // $solution[$i][$j-1] + ($preMultiplier * $ballons[$j] * $postMultiplier) +
                // $solution[$i+$j][$i+$s-1]);
                $solution[$i][$i+$s-1]= max($solution[$i][$i+$s-1], 
                $prepend + ($preMultiplier * $main * $postMultiplier) +
                $postpend);
                $output = sprintf("solution[%s][%s] = solution[%s][%s] + ballons[%s ,%s ,%s] + solution[%s][%s] = %s + %s * %s * %s + %s = %s",
                $i,$i+$s-1,
                $i,$j-1,
                $i-1,$j,
                $i+$s,
                $j+1,$i+$s-1,
                $prepend,
                $preMultiplier,
                $main,
                $postMultiplier,
                $postpend,
                $solution[$i][$i+$s-1]
            );
            echo $output;
            echo "\n";
                
            }
            
    
            echo "\n";
    
        }
    }
    //print_r($solution);
    echo "Answer: ";
    print_r($solution[0][$count-1]);



}

$ballons = [3,1,5,8];
$numberOfBallons = (int)readline('Enter the number of ballons : ');
$isRandom = readline('Do you want data to be random?(Y/N)  : ');
if($isRandom == 'Y' || $isRandom == 'y'){
    for($i=0; $i<$numberOfBallons; $i++)
    {
        $message = sprintf("Enter the %s th array number\n",$i);
        $ballons[$i] = rand(0, 100);
    }  
}
else{
    for($i=0; $i<$numberOfBallons; $i++)
    {
        $message = sprintf("Enter the %s th array number\n",$i);
        $ballons[$i] = (int)readline($message);
    }
}
echo "input: ";
print_r($ballons);


calculateMaximum($ballons);