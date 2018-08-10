<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

(function ($extKey, $table) {
  // add groups from Inet service
  $GLOBALS['TCA'][$table]['columns']['fe_group']['config']['itemsProcFunc'] =
    \Twtdh\TwtdhInetauth\Userfunc\FeGroupsInetService::class . '->getAllGroups';
})('twtdh_inetauth', 'tt_content');
