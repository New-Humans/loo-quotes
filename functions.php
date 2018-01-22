<?php
/**
 * Author: June McIntyre
 * Date: 21/1/2018
 * Time: 10:02 AM
 */

// Function to collect document, and grab x lines from it
// Document and x lines are based on function arguments
function gen($url, $linesRequired) {
    // Download LoO
    $loo = file_get_contents($url);

    // Find start point (random num between 0 and total # lines)
    $totalLines = substr_count($loo, "\r\n");
    $totalChars = strlen($loo);
    $startLine = rand(0, $totalLines);

    // Go to start point (or to a real startpoint, if whiteline)
    // Everytime we encounter \r\n, we hit a new line
    $rCheck = false;
    $currentLine = 1;

    // Check for double line breaks
    $doubleBreakPrep = false;
    $doubleBreak = false;
    $tripleBreak = false;
    $paragraphCount = 0;
    $isCollecting = false;



    // Actually place the string in here
    $quote = "";
    for ($i = 0; $i <= $totalChars; $i++) {
        // Get the character
        $char = substr($loo, $i, 1);

        // While we are not yet at the line we want, continue there
        if ($currentLine >= $startLine && ($doubleBreak || $isCollecting) && $paragraphCount < $linesRequired) {
            $isCollecting = true;       // Always collect once we start collecting
            // Now we are at the line, make sure it's valid for selection
            // Must proceed directly after a double line break?

            // Collect character
            $quote .= $char;

        } elseif ($paragraphCount >= $linesRequired) {
            break;
        }

        // Regarless, check if we passed a line
        if ($char === "\r")
            $rCheck = true;
        elseif ($rCheck && $char === "\n") {
            $currentLine++;
            if ($doubleBreak)
                $tripleBreak = true;
            elseif ($doubleBreakPrep)
                $doubleBreak = true;
            else
                $doubleBreakPrep = true;

        } else {
            $rCheck = false;
            $nCheck = false;

            $doubleBreak = false;
            $doubleBreakPrep = false;
            $tripleBreak = false;
        }

        if ($isCollecting && $tripleBreak)
            break;
        elseif ($isCollecting && $doubleBreak)
            $paragraphCount++;
    }
    // Return
    return $quote;
}
