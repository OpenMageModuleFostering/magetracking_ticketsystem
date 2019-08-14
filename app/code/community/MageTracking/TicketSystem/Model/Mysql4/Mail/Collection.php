<?php

class MageTracking_TicketSystem_Model_Mysql4_Mail_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ticketsystem/mail');
    }
}