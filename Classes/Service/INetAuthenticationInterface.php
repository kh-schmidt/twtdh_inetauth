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
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;

/**
 * Service 'AuthenticationService' for the 'login' extension.
 *
 * @author Karlheinz Schmidt <welt@arcor.de>
 */

interface INetAuthenticationInterface {


  /**
   * Authentication of login data
   *
   * @param string $username
   * @param string $password
   * @return string|null token for user
   */
  public function authLoginData(string $username, string $password) :? string;

  /**
   * Fetches Personal Data
   *
   * @param string $token
   * @return FrontendUser|null
   */
  public function getPersonalData(string $token) :? FrontendUser;

  /**
   * Loggs out to delete usersession remote
   *
   * @param string $token
   * @return bool
   */
  public function logout(string $token) : bool;

  /**
   * checks if token is still valid
   *
   * @param string $token
   * @return bool
   */
  public function isLoggedIn(string $token) : bool;

  /**
   * get user groups
   *
   * @return array with \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
   */
  public function getAllUserGroups() :? array;

  /**
   * checks if the user (token) has access to a page with the given user groups
   *
   * @param string $token
   * @param int ...$userGroups
   * @return bool
   */
  public function hasAccessToGroups(string $token, int ...$userGroups) : bool;
}
