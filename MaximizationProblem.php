<?php

$solution = [];

function calculateMaximum(&$ballons)
{

    $count = count($ballons);

    // initialize a multidimensional array with zeroes.
    $rows = array_fill(0,$count*2,0);
    $solution = array_fill(0,$count*2,$rows);

    // we have to use dp algorithm (bottom up ) so we create sub problems for the main problem
    // the sub problem will have arrays of different sizes that need to be solved 
    //we are starting here with a size of 1 array problem(base problem) then moving upwards with 
    //size 2 , 3 and so on untill we reach our initial problem.
    // solving each sub problem and storing them in a table gives lets us use those sub problem to 
    // be used in future
    for($s=1; $s<$count+1; $s++){
        // here i is the starting position for the sub problem 
        // here i + size of the array is the ending position of the sub problem
        // for eg if we use a sub problem of size 1 then i = 0 and the end of the subproblem is 
        // i + size of the array.
        for($i=0; $i<$count;$i++){

            // j is the index used for the solution of the sub problem.
            // since we are using a bottom up approach then we start with the index that we think 
            // will be popped the last.
            // for eg. if the index 0 is popped last then no other numbers are there in the 
            // sub problem 
            for($j=$i;$j<$i+$s;$j++){
                $preMultiplier = 1;
                $postMultiplier = 1;
                // since we might be going out of bounds of array we are using this logic to 
                // multiply using a 1 in case of this condition
                if(array_key_exists($i-1,$ballons)){
                    $preMultiplier = $ballons[$i-1];
                }
                if(array_key_exists($i+$s,$ballons)){
                    $postMultiplier = $ballons[$i+$s];
                }


                $prepend = 0;
                $postpend = 0;
                $main = 0;
                // since there are many conditions where the array may go out of bounds
                // we are using this logic .
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
                /**
                 * Main Logic
                 * 
                 */
                // the solution is the solution of each sub problem.
                // here i is the starting position of the sub problem 
                // i + s -1 is the ending position of the sub-problem.
                // for each sub problem we find the maximum of this solution and the previously 
                // gotten maximum . hence by this we only get the maximum of the sub problem.

                // prepend = $solution[$i][$j-1] -> we are prepending between the start of sub problem 
                //                                  the index before the current index.

                //postpend = $solution[$j+1][$i+$s-1] -> we are postpending the sub problem between a index after
                //                                      the current index and end of the sub problem

                // premultiplier and post multiplier is out of the sub problem as we assume that
                // the jth index is the last to be popped so there are no numbers in the sub problem

                $solution[$i][$i+$s-1]= max($solution[$i][$i+$s-1], 
                $prepend + ($preMultiplier * $main * $postMultiplier) +
                $postpend);


            // print the output
            //     $output = sprintf("solution[%s][%s] = solution[%s][%s] + ballons[%s ,%s ,%s] + solution[%s][%s] = %s + %s * %s * %s + %s = %s",
            //     $i,$i+$s-1,
            //     $i,$j-1,
            //     $i-1,$j,
            //     $i+$s,
            //     $j+1,$i+$s-1,
            //     $prepend,
            //     $preMultiplier,
            //     $main,
            //     $postMultiplier,
            //     $postpend,
            //     $solution[$i][$i+$s-1]
            // );
            // echo $output;
            // echo "\n";
                
            }
            
    
    
        }
    }
    //print_r($solution);
    echo "\n";
    echo "Answer: ";

    // the solution finally is the sub problem of 0 to the count of the ballons.
    // each sub problem was solving the maximum of their array.
    // so our 0 to count-1 sub problem is the actual solution.
    print_r($solution[0][$count-1]);



}


// take the input for number of ballons to pop
$numberOfBallons = (int)readline('Enter the number of ballons : ');

// take input if the data is random or you need to enter data manually.
$isRandom = readline('Do you want data to be random?(Y/N)  : ');
if($isRandom == 'Y' || $isRandom == 'y'){
    for($i=0; $i<$numberOfBallons; $i++)
    {
        // generate random numbers between 0 to 100 for each position in ballons array
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
// show the input ballons
echo "input: ";
print_r($ballons);

// use the algorithm to calculate the maximum number of coins
calculateMaximum($ballons);