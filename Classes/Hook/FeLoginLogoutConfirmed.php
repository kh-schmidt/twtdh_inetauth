<?php
namespace Twtdh\TwtdhInetauth\Hook;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */


use Twtdh\TwtdhInetauth\Service\INetAuthenticationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Felogin\Controller\FrontendLoginController;

/**
 *  Logout vie interface
 */
class FeLoginLogoutConfirmed
{
  /**
   * Process after logout
   *
   * @param array $_params
   * @param FrontendLoginController $callingObject
   * @return void
   */
  public function logoutFromINetAuthenticationService(array $_params, FrontendLoginController $callingObject)
  {
    // logout if logout is processed
    if(GeneralUtility::_GP('logintype') === 'logout') {
      // delete token in session
      unset($_SESSION['inetauth_token']);
      $loggedUser = INetAuthenticationService::getLoggedFeUser();
      if (!empty($loggedUser['inetauth_token'])) {
        /** @var INetAuthenticationService $iNetAuthenticationService */
        $iNetAuthenticationService = GeneralUtility::makeInstance(INetAuthenticationService::class);
        $iNetAuthenticationService->logOut();
      }
    }
    return $_params['content'];
  }

}
