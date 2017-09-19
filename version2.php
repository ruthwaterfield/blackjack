<?php

/**
 * makeDeck creates an adapted deck of cards for blackjack (4 sets of: Ace, 2 to 9 and four 10s)
 *
 * @return array the blackjack set of cards
 */
function makeDeck () : array {
    $deck = array ();

    for ($i=0; $i<=3; $i++) {
        array_push($deck, 'Ace',2, 3, 4, 5, 6, 7, 8, 9);
        //add four 10s
        for ($j=0; $j<=3; $j++) {
            array_push($deck, 10);
        }
    }

    return $deck;
}

/**
 * dealCard chooses a random card from the deck and removes it
 *
 * @param $inputDeck array The deck of cards to be chosen from
 *
 * @return array Contains the card chosen (first entry) and the modified deck (second entry)
 */
function dealCard ($inputDeck) : array {
    $chosenCardIndex = array_rand($inputDeck);
    $output = array($inputDeck[$chosenCardIndex]); //chosen card
    unset($inputDeck[$chosenCardIndex]); //remove chosen card from deck
    array_push($output, $inputDeck);

    return $output ;
}

/**
 * calculateScore takes a set of two cards and calculates their score in blackjack
 *
 * @param array $cards The two cards to add up
 *
 * @return Int Calculated score
 */
function calculateScore ($cards) : int {
    if(($cards[0] === 'Ace') && ($cards[1] === 'Ace')) {
        return 12; //Use one Ace as high, and one Ace as low
    }
    else if ($cards[0] === 'Ace') {
        return 11 + $cards[1];
    }
    else if ($cards[1] === 'Ace') {
        return 11 + $cards[0];
    }
    else {
        return $cards[0] + $cards[1];
    }
}


/**
 * playBlackjack creates a deck, deals 4 cards, 2 to the player and 2 to the dealer, it calculates the score and determines the winner
 *
 * @return string The gameplay messages and results
 */
function playBlackjack () : string {
    $myDeck = makeDeck();

    $dealt1 = dealCard($myDeck);
    $result = sprintf('Player given: %s <br>', $dealt1[0]);
    $dealt2 = dealCard($dealt1[1]);
    $result .= sprintf('Dealer given: %s <br>', $dealt2[0]);
    $dealt3 = dealCard($dealt2[1]);
    $result .= sprintf('Player given: %s <br>', $dealt3[0]);
    $dealt4 = dealCard($dealt3[1]);
    $result .= sprintf('Dealer given: %s <br> <br>', $dealt4[0]);

    $playerScore = calculateScore(array($dealt1[0], $dealt3[0]));
    $result .= sprintf('Player has a score of: %s <br>', $playerScore);
    $dealerScore = calculateScore(array($dealt2[0], $dealt4[0]));
    $result .= sprintf('Dealer has a score of: %s <br> <br>', $dealerScore);

    $winner = '';
        if ($dealerScore > $playerScore) {
        $winner = 'Dealer Wins :(';
    }
    else if ($playerScore > $dealerScore) {
        $winner = 'Player Wins :)';
    }
    else {
        $winner = 'It\'s a draw!';
    }

    return $result . $winner;
}

//Run the game:
echo playBlackjack();

