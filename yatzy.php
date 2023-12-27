<?php
// get player input
function get_input($upper = FALSE) 
{
    $userInput = trim(fgets(fopen("php://stdin","r")));
    
    if ($upper === TRUE) {
        return strtoupper($userInput);
    } else {
        return $userInput;
    }
}

// preforms first roll and reroll for dice selected by user
function rollDice(&$dice, &$diceToReroll) {
    for ($i = 0; $i < count($diceToReroll); $i++) { 
        $temp = $diceToReroll[$i] - 1;
        $dice[$temp] = mt_rand(1, 6);
    }
    $diceToReroll = array();
}

// shows the players dice
function displayDice($dice, $text="Dice") {
    $tempString = '';
    foreach ($dice as $value) {
        $tempString .= $value . " ";
    }
    echo "{$text}: " . $tempString . "\n";
}


// checks the dice to see what score category they fit in
function typeOfHandUpper($dice, &$Upperscores, $remainingUpperOptions) {
    $userOptions = array();
    $Upperscores = array();
    $valueCount = array(0, 0, 0, 0, 0, 0);
    $tempScore = 0;

    // counts how many dice are at each value
    $valueCount[0] = array("count"=>count(array_keys($dice, 1)), "total"=>count(array_keys($dice, 1)) * 1);
    $valueCount[1] = array("count"=>count(array_keys($dice, 2)), "total"=>count(array_keys($dice, 2)) * 2);
    $valueCount[2] = array("count"=>count(array_keys($dice, 3)), "total"=>count(array_keys($dice, 3)) * 3);
    $valueCount[3] = array("count"=>count(array_keys($dice, 4)), "total"=>count(array_keys($dice, 4)) * 4);
    $valueCount[4] = array("count"=>count(array_keys($dice, 5)), "total"=>count(array_keys($dice, 5)) * 5);
    $valueCount[5] = array("count"=>count(array_keys($dice, 6)), "total"=>count(array_keys($dice, 6)) * 6);
    //$tempScore = array_sum($dice);

    //print_r($valueCount);
    
    $count=0;
    foreach($valueCount as $key=>$value){
        if($value['count']<1) continue;

        $userOptions[] = $remainingUpperOptions[$key];
        $Upperscores[] = $value["total"];
    }
    //print_r($scores);
    return $userOptions;
}

// checks the dice to see what score category they fit in
function typeOfHand($dice, &$scores, $remainingOptions) {
    $userOptions = array();
    $scores = array();
    $scores = array();
    $valueCount = array(0, 0, 0, 0, 0, 0);
    $tempScore = 0;

    // counts how many dice are at each value
    $valueCount[0] = count(array_keys($dice, 1));
    $valueCount[1] = count(array_keys($dice, 2));
    $valueCount[2] = count(array_keys($dice, 3));
    $valueCount[3] = count(array_keys($dice, 4));
    $valueCount[4] = count(array_keys($dice, 5));
    $valueCount[5] = count(array_keys($dice, 6));
    $tempScore = array_sum($dice);

    // print_r($valueCount);
    // based on how many of each value you have, $userOptions gets each category your dice qualify for
    if (in_array(5, $valueCount) ) {
        $userOptions[] = "Yahtzee";
        $scores[] = 50;
    } 
    foreach($valueCount as $key=>$value){
        if($value ==2){
            $userOptions[] = "Two of a Kind";
            $scores[] = ($key+1) * $value;//$tempScore;
        }
        if($value ==3){
            $userOptions[] = "Three of a Kind";
            $scores[] = ($key+1) * $value;//$tempScore;
        }

        if($value ==4){
            $userOptions[] = "Four of a Kind";
            $scores[] = ($key+1) * $value;//$tempScore;
        }
    }

    //Two pairs
    $no=2;
    $twoPairs = array_filter(
        $valueCount,
        function ($value) use($no) {
            return ($value == $no);
        }
    );
    // print_r($twoPairs);
    if ($twoPairs && count($twoPairs) && in_array("Two pairs", $remainingOptions)) {
        $score=0;
        foreach($twoPairs as $key=>$val){
            $score +=($key+1) * $val;
        }
        $userOptions[] = "Two pairs";
        $scores[] = $score;
    }

    if ((in_array(3, $valueCount) && in_array(2, $valueCount)) && in_array("Full House", $remainingOptions)) {
        $userOptions[] = "Full House";
        $scores[] = 25;
    } 
    
    if (((array_search(0, $valueCount) === 0 || array_search(0, $valueCount) === 5) && (count(array_keys($valueCount, 0)) === 1)) 
        && in_array("Large Straight", $remainingOptions)) {
        $userOptions[] = "Large Straight";
        $scores[] = 40;
    }

    if ((($valueCount[0] >= 1 && $valueCount[1] >= 1 && $valueCount[2] >= 1 && $valueCount[3] >= 1) || 
            ($valueCount[1] >= 1 && $valueCount[2] >= 1 && $valueCount[3] >= 1 && $valueCount[4] >= 1) || 
            ($valueCount[2] >= 1 && $valueCount[3] >= 1 && $valueCount[4] >= 1 && $valueCount[5] >= 1))
            && in_array("Small Straight", $remainingOptions)) {
        $userOptions[] = "Small Straight";
        $scores[] = 30;
    }
    if (in_array("Chance", $remainingOptions)) {
        $userOptions[] = "Chance";
        $scores[] = $tempScore;
    }
    
    return $userOptions;
}

function listOptions($userOptions, $scores) {
    $output = "";
    // Iterate through list items
    foreach ($userOptions as $key => $option) {
        // Display each item and a newline
        $key2 = $key + 1;
        $output .= "[{$key2}] {$option} for " . $scores[$key] . "\n\n";
    }

    return $output;
}

function pickOption(&$userOptions, &$scores) {
    do{
        echo "Which way would you like to score your dice? ";
        $input = get_input();
    } while(!is_numeric($input));
    $input -= 1;
    $userOptions = $userOptions[$input];
    $scores = $scores[$input];
}

$continue = TRUE;
$dice = array(0, 0, 0, 0, 0);           // array that holds face values of dice
$diceToReroll = array(1,2,3,4,5);       // array that will hold index of dice to reroll each turn
$rollcount;                             // keeps track of how many times the user has rolled(3 is maximum including initial roll)
$score = 0;                             // keeps track of score
$userOptions = array();                 // holds score options for user at end of turn
$remainingOptions = array("Yahtzee", "Two pairs", "Two of a Kind", "Four of a Kind", "Full House", "Three of a Kind", "Large Straight", "Small Straight", 
"Chance");

$remainingUpperOptions = array("One's", "Two's", "Three's", "Four's", "Five's", "Six's");

while($continue) {
    $dice = array(0, 0, 0, 0, 0);   
    $pickedDice =  array();
    $diceToReroll = array(1,2,3,4,5);
    rollDice($dice, $diceToReroll);
    $rollcount = 1;
    displayDice($dice);
    $diceReroll=array();

    // asks user if they would like to reroll some of their dice
    echo "Would you like to reroll some of your dice? (Y or N)";
    $answer = get_input(TRUE);
    while($answer === 'Y' && $rollcount < 3) {
        $rollcount++;
        // prints out values again
        displayDice($dice);

        // asks which ones to reroll
        $label=count($diceReroll)>0?implode(",", $diceReroll):"1, 2, 3, ...";
        
        echo "Which dice would you like to reroll e.g dice index: ".$label."? ";
        $diceReroll = get_input();
        if(!empty($diceReroll)){
            $diceReroll = explode(',', $diceReroll);

            foreach ($diceReroll as $key => $value) {
                $diceReroll[$key] = trim($value);
            }


            $dicePicked=array();
            $keysOfDicePicked=array();
            foreach($diceReroll as $x=>$v){
                $keysOfDicePicked=array_diff(array(1,2,3,4,5), $diceReroll);
                if(!is_numeric($v)) continue;
                array_push($dicePicked, $dice[$v-1]);
            }
            //print_r($dicePicked);
            $newpickedDice=array_diff($dice, $dicePicked);
            
            $pickedDice=array_merge($pickedDice, $newpickedDice);
            echo "Dice picked: no:".trim(implode(", no:", $keysOfDicePicked), ", ")."\n";
            echo "Dice to reroll: no:". trim(implode(", no:", $diceReroll), ", ")."\n";
            
            rollDice($dice, $diceReroll);
            displayDice($dice);
        }
        $diceReroll=array();

        if ($rollcount < 3) {           // checks to see how many times the user has rolled their dice
            // asks if you would like to reroll again
            echo "Would you like to reroll again? ";
            $answer = get_input(TRUE);  
        } else {
            // tells the user they have rolled 3 times and ends the game loop
            echo "You have rolled 3 times. Your turn is completed!\n";
            $answer = "done";
        }
    }

    //asort($dice);                                                         // sorts the dice into value order after the users turn
    displayDice($dice); 

    echo "Final dice rolled: ";
    displayDice($dice); 
    asort($dice);   
    $UpperOptions = typeOfHandUpper($dice, $Upperscores, $remainingUpperOptions);           
    // print_r($UpperOptions);      
    if (empty($UpperOptions)) {
        $UpperOptions = $remainingUpperOptions;
        $scores = array();
        for ($i=0; $i < count($UpperOptions); $i++) { 
            $scores[] = 0;
        }
    }
                            // displays sorted dice
    $userOptions = typeOfHand($dice, $scores, $remainingOptions);           // checks to see what score options the user has
    //var_dump($userOptions);
    if (empty($userOptions)) {
        $userOptions = $remainingOptions;
        $scores = array();
        for ($i=0; $i < count($userOptions); $i++) { 
            $scores[] = 0;
        }
    }

    echo "\n\n";
    $userOptions=array_merge($UpperOptions, $userOptions);
    $scores=array_merge($Upperscores, $scores);

    //echo listOptions($UpperOptions, $Upperscores);
    echo listOptions($userOptions, $scores);                                // lists options for user to score

    pickOption($userOptions, $scores);                                      // allows user to pick how to score their turn

    $choice = array_search($userOptions, $remainingOptions);                // finds where the user's choice is in the $remainingOptions array
    unset($remainingOptions[$choice]);                                      // removes the users choice from the available choices
    $remainingOptions = array_values($remainingOptions);
    $score += $scores;                                                      // adds the users score from the turn to their total score

    echo "You had a {$userOptions} with a score of {$scores}!\n";           // displays the users choice for the round and how much they scored that turn
    $continue=FALSE;
    if (empty($remainingOptions)) {
        $continue = FALSE;
    }
}

echo "Your final score is {$score}!\n";

?>