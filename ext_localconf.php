<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey) {

      // Xclass for fe user authentification via internet
      $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class] = [
        'className' => \Twtdh\TwtdhInetauth\Frontend\Authentication\FrontendUserAuthentication::class
      ];
      // hook for checking rights for every page
//      $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = \Twtdh\TwtdhInetauth\Hook\PageRepositoryGetPage::class;
      // add the authentication service
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService($extKey, 'auth', \Twtdh\TwtdhInetauth\Service\INetAuthenticationService::class, array(
        'title' => 'Internet Authentication Service',
        'description' => 'Authenticates users through an Internet Authentication Service',
        'subtype' => 'getUserFE,authUserFE,getGroupsFE', // authGroupsFE
        'available' => TRUE,
        'priority' => 60,
        'quality' => 60,
        'os' => '',
        'exec' => '',
        'className' => \Twtdh\TwtdhInetauth\Service\INetAuthenticationService::class
      ));

      $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] = true;

      $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = true;
      $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_alwaysAuthUser'] = true;

      $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['writeDevLog'] = true;

      if (TYPO3_MODE === 'BE') {

      }
    },
  $_EXTKEY
);
