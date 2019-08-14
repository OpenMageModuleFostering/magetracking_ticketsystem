<?php
/**
 * Sofhere SofTicket Magento Component
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU (3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@sofhere.com so we can send you a copy immediately.
 * 
 * @category	design_default
 * @author 		sofhere.com
 * @package		Sofhere_SofTicket
 * @copyright  	Copyright (c) 2008-2009 Sofhere IT Solutions.(http://www.sofhere.com)
 * @version 	0.5 beta
 * @license		http://opensource.org/licenses/gpl-3.0.html GNU GENERAL PUBLIC LICENSE (GNU 3.0) 
 */


class MageTracking_TicketSystem_Block_Ticketsystem_View extends Mage_Core_Block_Template
{
 	protected function _prepareLayout(){
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('ticketsystem')->__('Ticket'));
        return parent::_prepareLayout();
    }
	
    public function getTickets(){
    	return Mage::registry('ticketsystem_all');
    }
    
 	public function getDepartments(){
    	return Mage::helper('ticketsystem')->getAllCategories(false);
    }
    
    public function getDepartment($id){
    	return Mage::helper('ticketsystem')->getCategory($id);
    }
    
    public function getPriority($priority){
    	$priorites= Mage::helper('ticketsystem')->getPriorities();
    	return $priorites[$priority];
    }
    
    public function getStatus($status){
    	$statuses = Mage::getSingleton('ticketsystem/status')->getOptionArray();
    	return $statuses[$status];
    }
    
    
}