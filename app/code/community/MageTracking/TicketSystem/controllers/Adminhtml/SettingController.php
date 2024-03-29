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
 * @created     Manmeet Kaur 27th Sep,2014
 * @author      Clarion magento team<Manmeet Kaur>   

 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/community-edition
 */

class MageTracking_TicketSystem_Adminhtml_SettingController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('ticketsystem/setting')
			->_addBreadcrumb(Mage::helper('ticketsystem')->__('TicketSystem'), Mage::helper('ticketsystem')->__('Settings'));
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		return $this;
	}   
 
	public function indexAction() {
		$this->_forward('edit');
			
	}

	public function editAction() {
		$this->loadLayout();
		$this->_setActiveMenu('ticketsystem/setting');
		$this->_addBreadcrumb(Mage::helper('ticketsystem')->__('TicketSystem'), Mage::helper('ticketsystem')->__('Settings'));
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		
		$model  = Mage::getModel('ticketsystem/settings');

		if ($model){
			$array =  array();
			foreach($model->getCollection()->load() as $_item) { 
				$key=$_item->getData('key');
				$value=$_item->getData('value');
				$array[$key]= $value;
			} 
			$model->setData($array);
			Mage::register('ticketsystem_settingdata', $model);

			$this->_addContent($this->getLayout()->createBlock('ticketsystem/adminhtml_ticketsystem_setting'))
				->_addLeft($this->getLayout()->createBlock('ticketsystem/adminhtml_ticketsystem_setting_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	
	
	
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('ticketsystem/settings');

			try {
				foreach($model->getCollection()->load() as $_item) { 
					$id=$_item->getData('ID');
					$key=$_item->getData('key');
					$array= null;
					if(array_key_exists($key,$data)){
						$value=1;
						if (! (strstr($key,'smtp_auth') || strstr($key,'alert_new')))
							$value=$data[$key];
						$array = array('ID'=> $id, 'key'=> $key, 'value'=> $value);
					}
					else if (strstr($key,'smtp_auth') ||strstr($key,'alert_new')) {
						$array = array('ID'=> $id, 'key'=> $key, 'value'=>0);
					}
					if($array){
						$model->setData($array);
						$model->save();
					}
				} 
					
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Settings were successfully updated'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit');
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit');
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 

}