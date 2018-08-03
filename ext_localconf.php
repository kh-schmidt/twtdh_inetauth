<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey) {

// Xclass list module to implement a quick CSV export.
//      $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class] = [
//        'className' => \Twtdh\TwtdhInetauth\Frontend\Authentication\FrontendUserAuthentication::class
//      ];
      $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class] = [
        'className' => \Twtdh\TwtdhInetauth\Frontend\Authentication\FrontendUserAuthentication::class
      ];

      if (TYPO3_MODE === 'BE') {

      }
    },
  $_EXTKEY
);
