<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['type']			= array( 'Art der Punktegutschrift', 'Wählen Sie wie die Punkte gutgeschrieben werden sollen' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['name']			= array( 'Name', 'Geben Sie einen Namen für diese Einstellung ein.' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['minimum_total']	= array( 'Minimaler Betrag', 'Geben Sie ein Zahl grösser als 0 ein, wenn diese Einstellung erst ab einem gewissen Totalbetrag zur Verfügung steht.' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['maximum_total']	= array( 'Maximaler Betrag', 'Geben Sie ein Zahl grösser als 0 ein, wenn diese Einstellung nur bis zu einem gewissen Totalbetrag zur Verfügung steht.' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['points']			= array( 'Bonuspunkte', 'Wie viele Bonuspunkte sollen dem Kundenkonto gut geschrieben werden?' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['enabled']		= array( 'Einstellung aktivieren', 'Klicken Sie hier wenn diese Einstellung für Kunden aktiv sein soll.' );


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['type_legend']	= 'Name & Typ';
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['config_legend']	= 'Allgemeine Einstellungen';
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['enabled_legend']	= 'Aktivierung';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['new']	= array( 'Neue Einstellung', 'Erstellen Sie eine neue Einstellung' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['edit']	= array( 'Einstellung bearbeiten', 'Einstellung ID %s bearbeiten' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['copy']	= array( 'Einstellung kopieren', 'Einstellung ID %s kopieren' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['delete'] = array( 'Einstellung löschen', 'Einstellung ID %s löschen' );
$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['show']	= array( 'Einstellungsdetails', 'Details der Einstellung ID %s anzeigen' );

?>