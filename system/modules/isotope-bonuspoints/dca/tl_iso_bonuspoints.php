<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
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
 * Table tl_iso_bonuspoints
 */
$GLOBALS['TL_DCA']['tl_iso_bonuspoints'] = array(

	'config' => array(
		'dataContainer'               => 'Table'
	,	'enableVersioning'            => true
	,	'closed'					  => true
	,	'onload_callback'			  => array(
			array('IsotopeBackend', 'initializeSetupModule')
		,	array('tl_iso_bonuspoints', 'checkPermission'),
		)
	)
	
,	'list' => array(

		'sorting' => array(
			'mode'                    => 1
		,	'fields'                  => array('name')
		,	'flag'                    => 1
		,	'panelLayout'             => 'sort,filter;search,limit'
		)
	,	'label' => array(
			'fields'                  => array('name', 'type')
		,	'format'                  => '%s <span style="color:#b3b3b3; padding-left:3px;">[%s]</span>'
		,	'label_callback'		  => array('IsotopeBackend', 'addPublishIcon')
		)
	,	'global_operations' => array(
			'back' => array(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['backBT']
			,	'href'                => 'mod=&table='
			,	'class'               => 'header_back'
			,	'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		,	'new' => array(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['new']
			,	'href'                => 'act=create'
			,	'class'               => 'header_new'
			,	'attributes'          => 'onclick="Backend.getScrollOffset();"',
			)
		,	'all' => array(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all']
			,	'href'                => 'act=select'
			,	'class'               => 'header_edit_all'
			,	'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		)
	,	'operations' => array(
			'edit' => array(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['edit']
			,	'href'                => 'act=edit'
			,	'icon'                => 'edit.gif'
			)
		,	'delete' => array(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['delete']
			,	'href'                => 'act=delete'
			,	'icon'                => 'delete.gif'
			,	'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			,	'button_callback'     => array('tl_iso_bonuspoints', 'deletePointsSetting'),
			)
		,	'show' => array(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['show']
			,	'href'                => 'act=show'
			,	'icon'                => 'show.gif'
			)
		)
	)
	
,	'palettes' => array(
		'default'				=> '{type_legend},name,type;{config_legend},minimum_total,maximum_total,points;{enabled_legend},enabled'
	)

,	'fields' => array(

		'name' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['name']
		,	'exclude'                 => true
		,	'search'                  => true
		,	'inputType'               => 'text'
		,	'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		)
	/*
	,	'type' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['type']
		,	'exclude'                 => true
		,	'filter'                  => true
		,	'inputType'               => 'select'
		,	'default'				  => 'cash'
		,	'options_callback'        => array('tl_iso_bonuspoints', 'getModules')
		,	'eval'                    => array('submitOnChange'=>true, 'chosen'=>true, 'tl_class'=>'w50')
		)
	*/
	,	'minimum_total' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['minimum_total']
		,	'exclude'                 => true
		,	'inputType'               => 'text'
		,	'default'                 => 0
		,	'eval'                    => array( 'maxlength'=>255, 'rgxp'=>'price', 'tl_class'=>'clr w50' )
		)
	,	'maximum_total' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['maximum_total']
		,	'exclude'                 => true
		,	'inputType'               => 'text'
		,	'default'                 => 0
		,	'eval'                    => array( 'maxlength'=>255, 'rgxp'=>'price', 'tl_class'=>'w50' )
		)
	,	'points' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['points']
		,	'exclude'                 => true
		,	'inputType'               => 'text'
		,	'default'                 => 0
		,	'eval'                    => array( 'maxlength'=>10, 'rgxp'=>'digit', 'tl_class'=>'w50' )
		)
	,	'enabled' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iso_bonuspoints']['enabled']
		,	'exclude'                 => true
		,	'inputType'               => 'checkbox'
		),
	)
);


class tl_iso_bonuspoints extends Backend {


	/**
	 * Check permissions to edit table tl_iso_bonuspoints
	 * @return void
	 */
	public function checkPermission() {

		$this->import('BackendUser', 'User');

		// Return if user is admin
		if( $this->User->isAdmin ){
			return;
		}

		// Set root IDs
		if( !is_array($this->User->iso_bonuspoints) || count($this->User->iso_bonuspoints) < 1 ) {
			$root = array(0);
		} else {
			$root = $this->User->iso_bonuspoints;
		}

		$GLOBALS['TL_DCA']['tl_iso_bonuspoints']['list']['sorting']['root'] = $root;

		// Check permissions to add payment modules
		if( !$this->User->hasAccess('create', 'iso_payment_modulep') ) {
			$GLOBALS['TL_DCA']['tl_iso_bonuspoints']['config']['closed'] = true;
			unset($GLOBALS['TL_DCA']['tl_iso_bonuspoints']['list']['global_operations']['new']);
		}

		// Check current action
		switch( $this->Input->get('act') ) {
			case 'create':
			case 'select':
				// Allow
				break;

			case 'edit':
				// Dynamically add the record to the user profile
				if( !in_array($this->Input->get('id'), $root) ) {

					$arrNew = $this->Session->get('new_records');

					if( is_array($arrNew['tl_iso_bonuspoints']) && in_array($this->Input->get('id'), $arrNew['tl_iso_bonuspoints']) ) {
					
						// Add permissions on user level
						if( $this->User->inherit == 'custom' || !$this->User->groups[0] ) {

							$objUser = $this->Database->prepare("SELECT iso_bonuspoints, iso_bonuspointsp FROM tl_user WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->id);

							$arrPermissions = deserialize($objUser->iso_bonuspointsp);

							if( is_array($arrPermissions) && in_array('create', $arrPermissions) ) {
								$arrAccess = deserialize($objUser->iso_bonuspoints);
								$arrAccess[] = $this->Input->get('id');

								$this->Database->prepare("UPDATE tl_user SET iso_bonuspoints=? WHERE id=?")
											   ->execute(serialize($arrAccess), $this->User->id);
							}

						// Add permissions on group level
						} elseif( $this->User->groups[0] > 0 ) {

							$objGroup = $this->Database->prepare("SELECT iso_bonuspoints, iso_bonuspointsp FROM tl_user_group WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->groups[0]);

							$arrPermissions = deserialize($objGroup->iso_bonuspointsp);

							if( is_array($arrPermissions) && in_array('create', $arrPermissions) ) {
								$arrAccess = deserialize($objGroup->iso_bonuspoints);
								$arrAccess[] = $this->Input->get('id');

								$this->Database->prepare("UPDATE tl_user_group SET iso_bonuspoints=? WHERE id=?")
											   ->execute(serialize($arrAccess), $this->User->groups[0]);
							}
						}

						// Add new element to the user object
						$root[] = $this->Input->get('id');
						$this->User->iso_bonuspoints = $root;
					}
				}
				// No break;

			case 'copy':
			case 'delete':
			case 'show':
				if( !in_array($this->Input->get('id'), $root) || ($this->Input->get('act') == 'delete' && !$this->User->hasAccess('delete', 'iso_bonuspointsp')) ) {
					$this->log('Not enough permissions to '.$this->Input->get('act').' bonus point setting ID "'.$this->Input->get('id').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $this->Session->getData();
				if( $this->Input->get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'iso_bonuspointsp') ) {
					$session['CURRENT']['IDS'] = array();
				} else {
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$this->Session->setData($session);
				break;

			default:
				if( strlen($this->Input->get('act')) ) {
					$this->log('Not enough permissions to '.$this->Input->get('act').' bonus point setting', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
	}


	/**
	 * Return the delete payment module button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function deletePointsSetting( $row, $href, $label, $title, $icon, $attributes ) {
		return ($this->User->isAdmin || $this->User->hasAccess('delete', 'iso_bonuspointsp')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : $this->generateImage(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}
}

?>