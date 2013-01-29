<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  2013
 * @author     numero2 - Agentur für Internetdienstleistungen
 * @package    Isotope eCommerce
 * @license    LGPL
 * @filesource
 */


/**
 * Isotope modules
 */
$GLOBALS['ISO_MOD']['checkout']['bonuspoints'] = array(
	'tables'	=> array('tl_iso_bonuspoints')
,	'icon'		=> 'system/modules/isotope-bonuspoints/html/setup-icon.png'
);
$GLOBALS['BE_MOD']['isotope']['iso_setup']['tables'][] = 'tl_iso_bonuspoints';


/**
 * Permissions are access settings for user and groups (fields in tl_user and tl_user_group)
 */
$GLOBALS['TL_PERMISSIONS'][] = 'iso_bonuspoints';
$GLOBALS['TL_PERMISSIONS'][] = 'iso_bonuspointsp';


/**
 * Hooks
 */
$GLOBALS['ISO_HOOKS']['addProductToCollection'][] = array( 'IsotopeBonusPoints', 'checkBeforeAddToCollection' );
$GLOBALS['ISO_HOOKS']['updateProductInCollection'][] = array( 'IsotopeBonusPoints', 'checkBeforeUpdateCollection' );
$GLOBALS['ISO_HOOKS']['postCheckout'][] = array( 'IsotopeBonusPoints', 'setPointsOnProfile' );
$GLOBALS['ISO_HOOKS']['checkoutSurcharge'][] = array( 'IsotopeBonusPoints', 'addPointsAsSurcharges' );
$GLOBALS['ISO_HOOKS']['getOrderEmailData'][] = array( 'IsotopeBonusPoints', 'generateOrderEmailData' );

?>