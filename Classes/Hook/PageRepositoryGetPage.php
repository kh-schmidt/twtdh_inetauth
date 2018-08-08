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


use TYPO3\CMS\Frontend\Page\PageRepository;
use TYPO3\CMS\Frontend\Page\PageRepositoryGetPageHookInterface;

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
    #var_dump($parentObject->where_groupAccess);
//    $GLOBALS['TSFE']->fe_user->checkPid = '';
//    $info = $GLOBALS['TSFE']->fe_user->getAuthInfoArray();
//    $user = $GLOBALS['TSFE']->fe_user->fetchUserRecord($info['db_user'], $username);
//    $GLOBALS['TSFE']->fe_user->createUserSession($user);
//    //var_dump($user);
//    $parentObject->where_groupAccess = $parentObject->where_groupAccess . '';
    //var_dump($parentObject->where_groupAccess);
  }

}
