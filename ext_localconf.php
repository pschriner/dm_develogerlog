<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// Define the timestamp for the current run
// TODO: move to tx_devlog constructor (as static variables)

if (!$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['mstamp']) {
    // Timestamp with microseconds to make sure 2 log runs can always be distinguished
    // even when happening very close to one another
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['mstamp'] = str_replace('.', '', microtime(true));
    // Normal timestamp
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['tstamp'] = $GLOBALS['EXEC_TIME'];
}

// Register the logging method with the appropriate hook

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_div.php']['devLog'][$_EXTKEY] = 'DieMedialen\DmDeveloperlog\Utility\Developerlog->devLog';
?>