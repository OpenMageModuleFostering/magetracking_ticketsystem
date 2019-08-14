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

class MageTracking_TicketSystem_Block_Ticketsystem_Edit extends Mage_Core_Block_Template
{
	
 	protected function _prepareLayout()
    {
        return parent::_prepareLayout();  
    }

 	public function getName(){
 		$session = Mage::getSingleton('customer/session'); 
 		if ($session){
	 		$customerId= $session->getCustomerId();
	 		if ($customerId>0){
	 			$customer = Mage::getModel('customer/customer')->load($customerId);
		    	return $customer->getName();
	 		}
 		}
 		return '';
    }
    
 	public function getEmail(){
 		$session = Mage::getSingleton('customer/session'); 
 		if ($session){
	 		$customerId= $session->getCustomerId();
	 		if ($customerId>0){
	 			$customer = Mage::getModel('customer/customer')->load($customerId);
		    	return $customer->getEmail();
	 		}
 		}
 		return '';
    }
    
 	public function getTicket($id){
 		if ($id>0)
    		return Mage::helper('ticketsystem')->getTicket($id);
    }
    
 	public function getDepartments(){
    	return Mage::helper('ticketsystem')->getAllCategories(false);
    }
    
    
 	public function getDepartment($id){
    	return Mage::helper('ticketsystem')->getCategory($id);
    }
    
 	public function getMessage($ticketId){
 		
 			
 			$answers='';
			$model_ans  = Mage::getModel('ticketsystem/answers');
			foreach ($model_ans->getCollection()->addFieldToFilter('ticket',$ticketId)->load() as $item){
				$message=$item->getData('message');
				
				$timestamp=$item->getData('timestamp');
				$represantative='';
				$answers .='('.$timestamp.') '.$message."<br>";
			}
			$model_msg  = Mage::getModel('ticketsystem/messages')->load($ticketId, 'ticket');
			$message = $model_msg->getMessage();
			$timestamp= $model_msg->getTimestamp();
			
			$message ='('.$timestamp.') '.$message."<br>";
			
			if ($answers)
				$message = $message."<br>".$answers;
			// **********************************************
			
    	
    	if ($message)
    		return $message;
    	return '';
    }
    
 	public function getPriorities(){
    	return Mage::helper('ticketsystem')->getPriorities();
    }
    
    public function getPriority($priority){
    	$priorites= Mage::helper('ticketsystem')->getPriorities();
    	return $priorites[$priority];
    }
    
    public function getTitle($id)
    { 
        if ($title = $this->getData('title')) {
            return $title;
        }
        if ($id)
        	return Mage::helper('ticketsystem')->__('Edit Ticket');
        return Mage::helper('ticketsystem')->__('Add Ticket');
    }

    public function getBackUrl()
    {
        if ($this->getData('back_url')) {
            return $this->getData('back_url');
        }
        return $this->getUrl('ticketsystem/');
    }

    public function getSaveUrl($id)
    {
    	if($id>0)
        	return Mage::getUrl('ticketsystem/index/editPost', array('_secure'=>true, 'id'=>$id));
        return Mage::getUrl('ticketsystem/index/addPost', array('_secure'=>true));
    }

}