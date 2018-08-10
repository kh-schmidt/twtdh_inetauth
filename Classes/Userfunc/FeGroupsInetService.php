<?php

namespace Twtdh\TwtdhInetauth\Userfunc;

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

use Twtdh\TwtdhInetauth\Service\INetAuthenticationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;

/**
 * Userfunction for TCA to fill fe groups fields.
 *
 * @author Karlheinz Schmidt <welt@arcor.de>
 */

class FeGroupsInetService {
  /**
   * Manipulate items array
   * uids will be from -1000 on
   *
   * @param array $config
   * @return array
   */
  public function getAllGroups(array $config) {
    $itemList = $config['items'];
    /** @var INetAuthenticationService $iNetAuthenticationService */
    $iNetAuthenticationService = GeneralUtility::makeInstance(INetAuthenticationService::class);
    $feGroups = $iNetAuthenticationService->getAllUserGroups();
    /** @var FrontendUserGroup $group */
    foreach ($feGroups as $group) {
      $itemList[] = [$group->getTitle(), -1000 - (int) $group->getUid()];
    }
    $config['items'] = $itemList;
    return $config;
  }
}
