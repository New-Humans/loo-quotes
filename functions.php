<?php
/**
 * Author: June McIntyre
 * Date: 21/1/2018
 * Time: 10:02 AM
 */

// Function to collect document, and grab x lines from it
// Document and x lines are based on function arguments
function gen($url, $lines) {
    // Download LoO
    $loo = file_get_contents($url);

    var_dump($loo);
    die();

    // Find start point (random num between 0 and total # lines)

    // Go to start point (or to a real startpoint, if whiteline)

    // Parse until $lines whitepsace lines encountered
    // OR 2 lines whitepace in row
    // OR chapter
    // OR EoF

    // Collect lines

    // Return
}
