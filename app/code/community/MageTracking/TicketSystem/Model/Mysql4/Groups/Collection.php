<?php

class MageTracking_TicketSystem_Model_Mysql4_Groups_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ticketsystem/groups');
    }
}