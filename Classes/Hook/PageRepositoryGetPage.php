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
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 *  Get Page with Permission over the Internet
 */
class PageRepositoryGetPage implements \TYPO3\CMS\Frontend\Page\PageRepositoryGetPageHookInterface
{
  /**
   * Check rights for every page
   *
   * @param int $uid
   * @param bool $disableGroupAccessCheck
   * @param PageRepository $parentObject
   */
  public function getPage_preProcess(&$uid, &$disableGroupAccessCheck, PageRepository $parentObject)
  {
// var_dump($GLOBALS['TSFE']->fe_user);
    /** @var INetAuthenticationService $iNetAuthenticationService */
    $iNetAuthenticationService = GeneralUtility::makeInstance(INetAuthenticationService::class);
    if ($iNetAuthenticationService->hasAccessForGroups()) {
      $parentObject->where_groupAccess = $parentObject->where_groupAccess . ' OR 1=1';
      var_dump($parentObject->where_groupAccess);

    }
  }

}
