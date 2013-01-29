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


class IsotopeBonusPoints extends Frontend {
	
	
	/**
	 * Calculates if customer has enough bonus points before
	 * adding the product to the cart
	 * @param object The product object
	 * @param integer Number of items to add
	 * @param object The productcollection object
	 * @return boolean
	 */
	public function checkBeforeAddToCollection( IsotopeProduct $oProduct=NULL, $intQuantity=0, IsotopeProductCollection $oCollection=NULL ) {

		$aProducts = array();
		$aProducts = $oCollection->getProducts();
		
		$this->Import('FrontendUser','User');

		$numUsedPoints = 0;
		$numNeededPoints = $oProduct->bonus_points*$intQuantity;
		
		if( !empty($aProducts) ) {
		
			foreach( $aProducts as $product ) {
			
				$numUsedPoints += $product->bonus_points*$product->quantity_requested;
			}
		}
		
		// check if added product would exceed the customers amount of bonus points
		if( ($numUsedPoints+$numNeededPoints) > $this->User->iso_bonus_points ) {
			$_SESSION['ISO_CONFIRM'][] = $GLOBALS['TL_LANG']['MSC']['notEnoughPointsAdd'];
			return 0;
		}

		return $intQuantity;
	}
	

	/**
	 * Calculates if customer has enough bonus before increasing quantity
	 * of bonus products in cart
	 * @param object The product object
	 * @param array Data to update in cart
	 * @param object The productcollection object
	 * @return boolean
	 */	
	public function checkBeforeUpdateCollection( IsotopeProduct $oProduct=NULL, $arrData=NULL, IsotopeProductCollection $oCollection=NULL ) {
	
		if( empty($arrData['product_quantity']) )
			return $arrData;
	
		$aProducts = array();
		$aProducts = $oCollection->getProducts();
		
		$this->Import('FrontendUser','User');
		
		if( !empty($aProducts) ) {
		
			$numUsedPoints = 0;
		
			foreach( $aProducts as $product ) {
			
				$qty = $product->quantity_requested;
			
				if( $product === $oProduct && $product->bonus_points ) {
					$qty = $arrData['product_quantity'];
				}
			
				$numUsedPoints += $product->bonus_points*$qty;
			}
			
			// check if updated product would exceed the customers amount of bonus points
			if( $numUsedPoints > $this->User->iso_bonus_points ) {
				$_SESSION['ISO_CONFIRM'][] = $GLOBALS['TL_LANG']['MSC']['notEnoughPointsUpdate'];
				return false;
			}
		}

		return $arrData;
	}
	
	
	/**
	 * Adds/subtracts points to/from customers account after successfull order
	 * @param object The order object
	 * @return none
	 */
	public function setPointsOnProfile( IsotopeOrder $oOrder=NULL ) {

		$this->import('FrontendUser', 'User');
		
		if( !$this->User->id )
			return;

		// update bonus points in order items table
		$this->Database->prepare(" UPDATE `tl_iso_order_items` AS oi JOIN `tl_iso_products` p ON (p.id = oi.product_id) SET oi.product_bonus_points = (oi.product_quantity*p.bonus_points) WHERE p.bonus_points > 0 AND oi.pid = ? ")->execute( $oOrder->id );
			
		// get overall count of points used for this order
		$oPoints = NULL;
		$oPoints = $this->Database->prepare(" SELECT SUM(product_bonus_points) AS points FROM `tl_iso_order_items` WHERE pid = ? ")->execute( $oOrder->id );

		// subtract points from customer account
		if( $oPoints->points )
			$this->Database->prepare(" UPDATE `tl_member` SET iso_bonus_points = iso_bonus_points-? WHERE id = ? ")->execute( $oPoints->points, $this->User->id );
		
		// check how many points we've earned for this order
		$oPointSettings = NULL;
		$oPointSettings = $this->getPointsSettings($oOrder->grandTotal);

		$numTotalPoints = 0;

		while( $oPointSettings->next() ) {
			$numTotalPoints += $oPointSettings->points;
		}

		// add points to customer account
		if( $numTotalPoints )
			$this->Database->prepare(" UPDATE `tl_member` SET iso_bonus_points = iso_bonus_points+? WHERE id = ? ")->execute( $numTotalPoints, $this->User->id );
	}
	
	
	/**
	 * Add bonus points as surcharges for listing in cart
	 * @param array List of surcharges
	 * @return array
	 */
	public function addPointsAsSurcharges( $aSurcharges=array() ) {
	
		$this->import('FrontendUser', 'User');
		
		if( !$this->User->id )
			return $aSurcharges;
	
		$this->import('Isotope');
		
		$aProducts = array();
		$aProducts = $this->Isotope->Cart->getProducts();
	
		// charge points
		$numPointsCharge = 0;

		if( !empty($aProducts) ) {
		
			foreach( $aProducts as $product ) {
				$numPointsCharge += $product->quantity_requested*$product->bonus_points;
			}
		}
		
		if( $numPointsCharge ) {

			$aSurcharges[] = array(
				'label'			=> $GLOBALS['TL_LANG']['MSC']['tax_bonus_charge'][0]
			,	'price'			=> sprintf( $GLOBALS['TL_LANG']['MSC']['tax_bonus_charge'][1], $numPointsCharge )
			,	'total_price'	=> '-'
			,	'tax_class'		=> 0
			,	'before_tax'	=> 0
			,	'products'		=> array()
			);		
		}
		
		// check how many points we'll earn for this order		
		$oPointSettings = NULL;
		$oPointSettings = $this->getPointsSettings($this->Isotope->Cart->subTotal);

		$numTotalPoints = 0;

		while( $oPointSettings->next() ) {
			$numTotalPoints += $oPointSettings->points;
		}

		if( $numTotalPoints ) {

			$aSurcharges[] = array(
				'label'			=> $GLOBALS['TL_LANG']['MSC']['tax_bonus_credit'][0]
			,	'price'			=> sprintf( $GLOBALS['TL_LANG']['MSC']['tax_bonus_credit'][1], $numTotalPoints )
			,	'total_price'	=> '-'
			,	'tax_class'		=> 0
			,	'before_tax'	=> 0
			,	'products'		=> array()
			);	
		}

		return $aSurcharges;
	}


	/**
	 * Gets the configured settings for the given amount
	 * @param float Amount
	 * @return object
	 */
	private function getPointsSettings( $iAmount=0.00 ) {

		return $this->Database->prepare(" SELECT * FROM `tl_iso_bonuspoints` WHERE enabled = 1 AND ((minimum_total = 0 OR minimum_total <= ?) AND (maximum_total = 0 OR maximum_total >= ?)) ")->execute( $iAmount, $iAmount );
	}


	/**
	 * Returns data used for simple tokens in order mail
	 * @param IsotopeOrder
	 * @return array Simple tokens
	 */	
	public function generateOrderEmailData( IsotopeOrder $oOrder=NULL, $arrData=NULL ) {
		
		$this->import('FrontendUser', 'User');
		
		if( !$this->User->id )
			return $arrData;
		
		$objPoints = NULL;
		$objPoints = $this->Database->prepare(" SELECT m.iso_bonus_points FROM `tl_iso_orders` AS o JOIN tl_member m ON (m.id = o.pid) WHERE o.id = ? ")->limit(1)->execute( $oOrder->id );
		
		$arrData['bonus_points'] = $objPoints->iso_bonus_points;
		
		return $arrData;
	}
}

?>