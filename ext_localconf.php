<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
if (version_compare(PHP_VERSION, '5.5.0') >= 0) { // this is a hard requirement
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_div.php']['devLog'][$_EXTKEY] = 'DieMedialen\DmDeveloperlog\Utility\Developerlog->devLog';
}
