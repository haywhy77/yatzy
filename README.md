# Yatzy
Yatzy Code Challenge 

The choice of programming used is PHP with command-line which is generally available to manage.

Game Algorithm

- Write a function that accepts input from the keyboard
- Write a function that picks 5 random numbers between 1-6
- Write a function that displays the 5 random numbers
- Display all the random number
- Ask if the player wants to reroll
- If yes, write a function that accepts the player selection of numbers as a string separated with a comma
- Splits the number into an array and find the difference from the previous array
- Write a function to count and sum similar numbers in the array
- Display all new random numbers and existing numbers
- If no, do sum of all the 5 random number
- Check if the roll attempt is <3
- If yes, reroll again 
- If no, do sum of all of similar numbers
- Compare the sum value with the game rules set below


YATZY GAME RULES

- Players agree on the random score option
- Players roll a dice and the highest score starts the game
- The first player rolls all 5 dices and selects which to hold and which to reroll if necessary
- Player have a chance to reroll twice after the first roll (3 attempts)
- Player decides the choice of game point to fill on the scoresheet

- If player choice is to fill in the Ones after the first roll, player holds all 1s on first roll and reroll others
- If player gets all 1s, player scores the point else player holds all 1s and rerolls again for the last chance
- Player gets points based on the number of 1s gotten (1 x number of dice with 1s)

- If player choice is to fill Twos after the first roll, player holds all 2s on the first roll and reroll other dice
- If player gets all 2s, player scores the point else player rerolls again for last chance
- Player gets points based on the number of 2s gotten (2 x number of dice with 2s)

- If player choice is to fill Threes after the first roll, player holds all 3s on the first roll and reroll other dice
- If player gets all 3s, player scores the point else player rerolls again for last chance
- Player gets points based on the number of 3s gotten (3 x number of dice with 3s)

- If player choice is to fill Fours after the first roll, player holds all 4s on the first roll and reroll other dice
- If player gets all 4s, player scores the point else player rerolls again for last chance
- Player gets points based on the number of 4s gotten (4 x number of dice with 4s)

- If player choice is to fill Fives after the first roll, player holds all 5s on the first roll and reroll other dice
- If player gets all 5s, player scores the point else player rerolls again for last chance
- Player gets points based on the number of 5s gotten (5 x number of dice with 5s)

- If player choice is to fill Sixes after the first roll, player holds all 6s on the first roll and reroll other dice
- If player gets all 6s, player scores the point else player rerolls again for last chance
- Player gets points based on the number of 6s gotten (6 x number of dice with 6s)

- If the sum of all points from ones to sixes =>63, a player gets a bonus point of 50

- If player choice is to fill Pairs after the first roll, player holds 2 similar numbers 
- If player gets a pair of two similar numbers, player scores the point else player rerolls again on two other attempts
- Player gets points based on the number in pairs (2 x numbers in the two pairs) 

- If player choice is to fill a Two of kind after the first roll, player holds 2 similar numbers 
- If player gets two similar numbers, player scores the point else player rerolls again on two other attempts
- Player gets points based on the number in the pair (2 x number gotten) 

- If player choice is to fill a Three of a kind after the first roll, player holds 3 similar numbers 
- If player gets three similar numbers, player scores the point else player rerolls again on two other attempts
- Player gets points based on the number in threes (3 x numbers gotten) 

- If player choice is to fill a Four of a kind after the first roll, player holds 4 similar numbers 
- If player gets four similar numbers, player scores the point else player rerolls again on two other attempts
- Player gets points based on the number in fours (4 x numbers gotten) 

- If player choice is to fill a Small Straight after the first roll, player holds number 1,2,3,4,5 
- If player gets all 1,2,3,4,5 numbers, player scores 15 points else player rerolls again on two other attempts

- If player choice is to fill a Full House after the first roll, player holds pair of 3 similar numbers and 2 similar numbers 
- If player gets a pair of 3 similar numbers and 2 similar numbers, player scores the point else player rerolls again on two other attempts
- Player gets the points based on the number in pairs (sum of all numbers)

- If player choice is to fill a Yatzy after the first roll, player holds all five similar numbers
- If player gets all five similar numbers, player scores 50 points else player rerolls again on two other attempts

- Else, the player can fill Chance and score points based on the sum of all numbers in the 3 attempts 

