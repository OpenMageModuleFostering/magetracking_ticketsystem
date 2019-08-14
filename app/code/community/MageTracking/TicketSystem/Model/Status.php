<?php

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