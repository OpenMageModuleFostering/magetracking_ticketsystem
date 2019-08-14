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
 * @created     Manmeet Kaur 25th Sep,2014
 * @author      Clarion magento team<Manmeet Kaur>   

 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/community-edition
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