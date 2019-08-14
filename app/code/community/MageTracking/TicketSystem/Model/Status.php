<?php
/**
 * Magento Community Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Community Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/community-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *  
 * 
 * @category    MageTracking
 * @package     MageTracking_TicketSystem
 * @created     Manmeet Kaur 28th Sep,2014
 * @author      Clarion magento team<Manmeet Kaur>   

 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/community-edition
 */
class MageTracking_TicketSystem_Model_Status extends Varien_Object
{
	const STATUS_EMPTY	= '';
    const STATUS_NEW	= 'new';
    const STATUS_ONHOLD	= 'onhold';
    const STATUS_CUSTREPLIED	= 'custreplied';
    const STATUS_AWAITING	= 'awaitingcustomer';
    const STATUS_REOPENED	= 'reopened';
    const STATUS_CLOSED	= 'closed';
    
    
    static public function getOptionArray()
    {
        return array(
            self::STATUS_EMPTY    		=> Mage::helper('ticketsystem')->__(''),
            self::STATUS_NEW    		=> Mage::helper('ticketsystem')->__('New'),
            self::STATUS_ONHOLD   		=> Mage::helper('ticketsystem')->__('On Hold'),
            self::STATUS_CUSTREPLIED   	=> Mage::helper('ticketsystem')->__('Customer Replied'),
            self::STATUS_AWAITING   	=> Mage::helper('ticketsystem')->__('Awaiting Customer'),
            self::STATUS_REOPENED   	=> Mage::helper('ticketsystem')->__('Reopened'),
            self::STATUS_CLOSED   		=> Mage::helper('ticketsystem')->__('Closed'),
        );
    }
}