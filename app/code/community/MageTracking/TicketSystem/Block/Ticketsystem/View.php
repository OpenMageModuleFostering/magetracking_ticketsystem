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
 * @created     Manmeet Kaur 22nd Sep,2014
 * @author      Clarion magento team<Manmeet Kaur>   

 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/community-edition
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