<?php
 
 

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