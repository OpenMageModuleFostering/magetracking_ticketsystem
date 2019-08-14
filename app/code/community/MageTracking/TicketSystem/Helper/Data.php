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
 * @version 	beta
 * @license		http://opensource.org/licenses/gpl-3.0.html GNU GENERAL PUBLIC LICENSE (GNU 3.0) 
 */


class MageTracking_TicketSystem_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getPriorities(){
    	return  array(1=>$this->__('Low'), 2=>$this->__('Medium'), 3=>$this->__('High'));
    }

    public function isAdmin(){
  		$user=Mage::getSingleton('admin/session')->getUser();
  		$userId=$user->getUserId();
        $roleId = implode('', $user->getRoles());
        $roleName = Mage::getModel('admin/roles')->load($roleId)->getRoleName();
  		if ($roleName == 'Administrators')
  			return true;
  		return false;
    }
  
	public function getMailDBSettings(){
		$array =  array();
		$model  = Mage::getModel('ticketsystem/mail');
		if ($model){
			foreach($model->getCollection()->load() as $_item) { 
				$key=$_item->getData('key');
				$value=$_item->getData('value');
				$array[$key]= $value;
			} 
		}
		return $array;
	}
	

	public function getAllCategories($admin=true){
		
		$model_cats  = Mage::getModel('ticketsystem/cats');
		$cats = array();
		foreach ($model_cats->getCollection()->load() as $item){
			$hidden=$item->getData('hidden');
			if (! ($admin ==false && $hidden =='1')){
				$key=$item->getData('ID');
				$cats[$key]= $item;
			}
		}
		return $cats;
	}
	
	public function getCategory($catID){
		$cats=$this->getAllCategories();
		if ($catID >0 && $cats[$catID])
			return $cats[$catID]->getName();
	}
	
	public function getMessage($id){
		$model  = Mage::getModel('ticketsystem/messages');
		if ($id >0 && $model)
			return $model->load($id);
	}
	
	public function getTicket($id){
    	if ($id>0){
    		$softicketModel = Mage::getModel('ticketsystem/ticketsystem')->load($id);
			return $softicketModel;
    	}
	}
		
    public function getTicketID() {
	    do {
	        mt_srand((double)microtime() *1000000);
	        $min = 100000;
	        $max = 999999;
	        $id = mt_rand($min, $max);
	    }while ($this->validID($id));
		return $id;
	}
	function validID($id) {
		$model= Mage::getModel('ticketsystem/ticketsystem');
		return $model->load($id)->getData('ID');
	}
}