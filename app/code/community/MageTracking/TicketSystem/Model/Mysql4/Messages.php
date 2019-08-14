<?php

class MageTracking_TicketSystem_Model_Mysql4_Messages extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the id refers to the key field in your database table.
        $this->_init('ticketsystem/messages', 'ticket');
    }
    
    
    public function save(Mage_Core_Model_Abstract $object)
    {
		$this->_beforeSave($object);
        $this->_checkUnique($object);

        $this->_getWriteAdapter()->insert($this->getMainTable(), $this->_prepareDataForSave($object));
        $object->setId($this->_getWriteAdapter()->lastInsertId($this->getMainTable()));

        $this->_afterSave($object);
    
		return $this;
    }
}