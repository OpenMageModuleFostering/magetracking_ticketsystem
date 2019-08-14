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

class MageTracking_TicketSystem_Model_Ticketsystem extends Mage_Core_Model_Abstract

{

    public function _construct()

    {

        parent::_construct();

        $this->_init('ticketsystem/ticketsystem');

    }



	

    public function getAllTickets($customerId){



    	$customer = Mage::getModel('customer/customer');

    	if ($customerId) {

    		$customer->load($customerId);

    		$email = $customer->getEmail();

    		

    		// Get softickets for this customer with the email...

			$resource = Mage::getSingleton('core/resource');

			$read= $resource->getConnection('core_read');

			$ticketsystem = $resource->getTableName('mticketing_tickets');

			

			$select = $read->select()

			   ->from($ticketsystem,array('ID','email','subject','status','timestamp', 'cat', 'priority'))

			   ->where('email='."'".$email."'")

			   ->order('timestamp DESC') ;

			return $read->fetchAll($select);

    	}

    	return array();

    }



    

     //save and load methods

	public function save() {
    
		$resource = Mage::getSingleton('core/resource');

		$connection= $resource->getConnection('ticketsystem_write');

		$connection->beginTransaction();



		try {

			$this->_beforeSave();

			if ($this->getID()==0)

				$this->setID(Mage::helper('ticketsystem')->getTicketID());

				

			$query= 'insert into mticketing_tickets (ID, name, subject, orders, phone, timestamp, ip, cat, priority, email) VALUES('

				."'".$this->getID()."',"

				."'".$this->getName()."',"

				."'".$this->getSubject()."',"

				."'".$this->getOrders()."',"

				."'".$this->getPhone()."',"
				
				."'".$this->getTimestamp()."',"

				."'".$this->getIp()."',"
				
				."'".$this->getCat()."',"

				."'".$this->getPriority()."',"

				."'".$this->getEmail()."')";

			

				$connection->query($query);



				$connection->commit();

				$this->_afterSave();

		}

		catch (Exception $e) {

			Mage::log('Exception:'.$e);

			$connection->rollBack();

			throw $e;

		}

		return $this;

	}

	

	public function update() {

		parent::save();

	}



}