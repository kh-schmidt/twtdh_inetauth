<?php

namespace Twtdh\TwtdhInetauth\Service;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Karlheinz Schmidt <welt@arcor.de>
 *  All rights reserved
 *
 *  The TYPO3 Extension is licensed under the MIT License
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use Twtdh\TwtdhInetauth\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service 'AuthenticationService' for the 'login' extension.
 *
 * @author Karlheinz Schmidt <welt@arcor.de>
 */

class INetAuthenticationService extends \TYPO3\CMS\Sv\AbstractAuthenticationService {

	protected $extConf = array();
  /**
   * @var INetAuthenticationInterface
   * @inject
   */
  protected $iNetAuthenticationInterface;

  /**
   * INetAuthenticationService constructor.
   */
	public function __construct() {
    $this->iNetAuthenticationInterface = GeneralUtility::makeInstance(DummyAuthentication::class);
	}

	public function initAuth($mode, $loginData, $authInfo, $pObj) {
		parent::initAuth($mode, $loginData, $authInfo, $pObj );
	}

	/**
	 * Retreive the Dummy User if it can be authentificated
	 *
	 * @return array|null for a user
	 */
	public function getUser() {
	  // get credentials
    $userName = $this->login["uname"];
    $password = $this->login["uident"];
    $user = null;
    $token = $this->iNetAuthenticationInterface->authLoginData($userName, $password);

    // if login data was send and token could be fetched
    if (!empty($token) && !empty($userName) && !empty($password)) {
      // store token in session


      // get user
      $feUser = $this->iNetAuthenticationInterface->getPersonalData($token);
      $user = [];
      #$user['uid'] = $feUser->getId();
      $user['username'] = $feUser->getUsername();
      $user['firstname'] = $feUser->getFirstName();
      $user['lastname'] = $feUser->getLastName();
      $user['email'] = $feUser->getEmail();
      $user['password'] = $feUser->getPassword();

      // token is remebered in user session
      $user['inetauth_token'] = $token;
      // TODO change this with a typo3 session storing for this level
      session_start();
      $_SESSION['inetauth_token'] = $token;
//      /** @var FrontendUserAuthentication $frontendUserAuthentication */
//      $frontendUserAuthentication = GeneralUtility::makeInstance(FrontendUserAuthentication::class);
//      $frontendUserAuthentication->setAndSaveSessionData('tokenfromInet', $token);
    } else {
      /** @var FrontendUserAuthentication $frontendUserAuthentication */
//      $frontendUserAuthentication = GeneralUtility::makeInstance(FrontendUserAuthentication::class);
//      $tokenfromInet = $frontendUserAuthentication->getSessionData('tokenfromInet');
      session_start();
      $tokenfromInet = $_SESSION['inetauth_token'];
      if (!empty($tokenfromInet)) {
        // get user
        $feUser = $this->iNetAuthenticationInterface->getPersonalData($tokenfromInet);
        $user = [];
        #$user['uid'] = $feUser->getId();
        $user['username'] = $feUser->getUsername();
        $user['firstname'] = $feUser->getFirstName();
        $user['lastname'] = $feUser->getLastName();
        $user['email'] = $feUser->getEmail();
        $user['password'] = $feUser->getPassword();
      }
    }
		return $user;
	}

	/**
	 * Authenticate a user
	 * Return 200 if the login is okay. This means that no more checks are needed. Otherwise authentication may fail because we may don't have a password.
	 *
	 * @param array $user array Data of user.
	 * @return	boolean|200|100
	 */
	public function authUser(?array $user) {

		// return values:
		// 200 - authenticated and no more checking needed - useful for IP checking without password
		// 100 - Just go on. User is not authenticated but there's still no reason to stop.
		// false - this service was the right one to authenticate the user but it failed
		// true - this service was able to authenticate the user

		// check token
    $this->iNetAuthenticationInterface->isLoggedIn($user);
		// cool, some auth method thought it's fine. Quickly configure the redirect feature.
    $ok = 200;

		return $ok;
	}

  /**
   * Fetch groups of the user
   *
   * @param array $user
   * @param array $groupDataArr
   * @return array
   */
	public function getGroups(?array $user, array $groupDataArr) {



    $userGroupArray = [
      'inet1' => [
        'uid' => 'inet1',
        'title' => 'gruppe',
        'pid' => 0,
        'TSconfig' => ''
        ]
    ];
	  return $userGroupArray;
  }

  /**
   * Fetch all available groups of the inet service
   *
   * @return array
   */
  public function getAllUserGroups() {
    return $this->iNetAuthenticationInterface->getAllUserGroups();
  }

}
