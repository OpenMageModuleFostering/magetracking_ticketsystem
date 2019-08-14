<?php

class MageTracking_TicketSystem_Model_Cats extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ticketsystem/cats');
    }
    

}