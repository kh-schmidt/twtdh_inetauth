<?php

namespace Twtdh\TwtdhInetauth\Service;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Karlheinz Schmidt <welt@arcor.de>
 *  All rights reserved
 *
 *  The TYPO3 Extension ap_docchecklogin is licensed under the MIT License
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;

/**
 * Service 'AuthenticationService' for the 'login' extension.
 *
 * @author Karlheinz Schmidt <welt@arcor.de>
 */

class DummyAuthentication implements INetAuthenticationInterface{

  protected static $users = [
    'user_a' => [
      'uid' => 1,
      'username' => 'user_a',
      'password' => 'a',
      'firstname' => 'a',
      'lastname' => 'aa',
      'email' => 'a@a.de',
      'loggedIn' => false,
      'user-groups' => '1'
    ],
    'user_b' => [
      'uid' => 2,
      'username' => 'user_b',
      'password' => 'b',
      'firstname' => 'b',
      'lastname' => 'b',
      'email' => 'b@a.de',
      'loggedIn' => false,
      'user-groups' => '2'
    ],
    'user_c' => [
      'uid' => 3,
      'username' => 'user_c',
      'password' => 'c',
      'firstname' => 'c',
      'lastname' => 'cc',
      'email' => 'c@a.de',
      'loggedIn' => false,
      'user-groups' => ''
    ],
  ] ;

  protected static $userGroups = [
    1 => [
      'uid' => 1,
      'title' => 'user_a'
    ],
    2 => [
      'uid' => 2,
      'title' => 'user_b'
    ],
    3 => [
      'uid' => 3,
      'title' => 'user_c'
    ],
  ] ;
  /**
   * Authentication of login data
   *
   * @param string $username
   * @param string $password
   * @return string|null token for user
   */
  public function authLoginData(string $username, string $password) :? string {
    if (isset(self::$users[$username])
    && self::$users[$username]['password'] == $password) {
      return $username;
    } else {
      return null;
    }

  }

  /**
   * Fetches Personal Data
   *
   * @param string $token
   * @return FrontendUser|null
   */
  public function getPersonalData(string $token) :? FrontendUser {
    if (isset(self::$users[$token])) {
      $feUser = GeneralUtility::makeInstance(FrontendUser::class);
      /** @var FrontendUser $feUser **/
      $feUser->setUsername(self::$users[$token]['username']);
      $feUser->setFirstName(self::$users[$token]['firstname']);
      return $feUser;
    } else {
      return null;
    }
  }

  /**
   * Loggs out to delete usersession remote
   *
   * @param array $user
   * @return bool
   */
  public function logout(array $user) : bool {

  }

  /**
   * checks if token is still valid
   *
   * @param array $user
   * @return bool
   */
  public function isLoggedIn(array $user) : bool {
    if (isset(self::$users[$user['username']]['inetauth_token'])) {
      return true;
    } else {
      return false;
    }
  }


  /**
   * checks if the user (token) has access to a page with the given user groups
   *
   * @return array|null
   */
  public function getAllUserGroups() :? array {
    return self::$userGroups;
  }
  /**
   * checks if the user (token) has access to a page with the given user groups
   *
   * @param array $user
   * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup[] ...$userGroups
   * @return bool
   */
  public function hasAccessForGroups(array $user, FrontendUserGroup ...$userGroups) : bool {
    $usersUserGroups = explode(',', $user['user-goups']);
    foreach ($userGroups as $userGroup) {
      if (in_array($userGroup->getUid(), $usersUserGroups)) {
        return true;
      }
    }
    return false;
  }
}
