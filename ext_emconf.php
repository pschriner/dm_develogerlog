<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "dm_developerlog".
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Devlog replacement',
  'description' => 'Better devlog.',
  'category' => 'misc',
  'version' => '0.1.0',
  'state' => 'alpha',
  'uploadfolder' => false,
  'author' => 'Patrick Schriner',
  'author_email' => 'patrick.schriner@diemedialen.de',
  'author_company' => 'DieMedialen GmbH',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '7.6.2-7.6.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'createDirs' => NULL,
  'clearcacheonload' => false,
  'autoload' =>
    array(
        'psr-4' => array('DieMedialen\\DmDeveloperlog\\' => 'Classes')
    ),
);

