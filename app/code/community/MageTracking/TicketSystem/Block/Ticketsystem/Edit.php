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
 		
 			//$reps=Mage::helper('ticketsystem')->getAllRepresantatives(true);
 			$answers='';
			$model_ans  = Mage::getModel('ticketsystem/answers');
			foreach ($model_ans->getCollection()->addFieldToFilter('ticket',$ticketId)->load() as $item){
				$message=$item->getData('message');
				//$rep=$item->getData('rep');
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