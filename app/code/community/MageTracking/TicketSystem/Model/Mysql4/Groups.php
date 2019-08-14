<?php

class MageTracking_TicketSystem_Model_Mysql4_Groups extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the id refers to the key field in your database table.
        $this->_init('ticketsystem/groups', 'ID');
    }
    

}