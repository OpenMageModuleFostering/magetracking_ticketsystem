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
class MageTracking_TicketSystem_Block_Adminhtml_Ticketsystem_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ticketsystem_form', array('legend'=>Mage::helper('ticketsystem')->__('Ticket Information')));
     
      $fieldset->addField('ID', 'label', array(
          'label'     => Mage::helper('ticketsystem')->__('Ticket ID'),
          'id'      => 'ID',
      	  'name'      => 'ID',
      ));
      $fieldset->addField('hidden_ID', 'hidden', array(
          'label'     => Mage::helper('ticketsystem')->__('Ticket ID'),
          'id'      => 'hidden_ID',
      	  'name'      => 'hidden_ID',
      ));
      
      $fieldset->addField('status', 'label', array(
		  'name'  	=> 'status',
          'label' 	=> Mage::helper('ticketsystem')->__('Status'),
          'id'    	=> 'status',
          'title' 	=> Mage::helper('ticketsystem')->__('Status'),
      ));
      $fieldset->addField('hidden_status', 'hidden', array(
		  'name'  	=> 'hidden_status',
          'label' 	=> Mage::helper('ticketsystem')->__('Status'),
          'id'    	=> 'hidden_status',
          'title' 	=> Mage::helper('ticketsystem')->__('Status'),
      ));
      
      $fieldset->addField('subject', 'label', array(
          'label'     => Mage::helper('ticketsystem')->__('Subject'),
          'id'      => 'subject',
      	  'name'      => 'subject',
	  ));
      $fieldset->addField('hidden_subject', 'hidden', array(
          'label'     => Mage::helper('ticketsystem')->__('Subject'),
          'id'      => 'hidden_subject',
      	  'name'      => 'hidden_subject',
	  ));
	  
      $fieldset->addField('name', 'label', array(
          'label'     => Mage::helper('ticketsystem')->__('Name'),
          'id'      => 'name',
      	  'name'      => 'name',
      ));
      $fieldset->addField('hidden_name', 'hidden', array(
          'label'     => Mage::helper('ticketsystem')->__('Name'),
          'id'      => 'hidden_name',
      	  'name'      => 'hidden_name',
      ));
      
      $fieldset->addField('email', 'label', array(
          'label'     => Mage::helper('ticketsystem')->__('Email'),
          'id'      => 'email',
      	  'name'      => 'email',
	  ));
      $fieldset->addField('hidden_email', 'hidden', array(
          'label'     => Mage::helper('ticketsystem')->__('Email'),
          'id'      => 'hidden_email',
      	  'name'      => 'hidden_email',
	  ));
	  
	  $fieldset->addField('phone', 'label', array(
          'label'     => Mage::helper('ticketsystem')->__('Phone'),
          'id'      => 'phone',
      	  'name'      => 'phone',
      ));
      $fieldset->addField('hidden_phone', 'hidden', array(
          'label'     => Mage::helper('ticketsystem')->__('Phone'),
          'id'      => 'hidden_phone',
      	  'phone'      => 'hidden_phone',
      ));
	  
	  $fieldset->addField('orders', 'label', array(
          'label'     => Mage::helper('ticketsystem')->__('Order'),
          'id'      => 'orders',
      	  'name'      => 'orders',
      ));
      $fieldset->addField('hidden_order', 'hidden', array(
          'label'     => Mage::helper('ticketsystem')->__('Order'),
          'id'      => 'hidden_order',
      	  'phone'      => 'hidden_order',
      ));
      
	  $fieldset->addField('priority', 'select', array(
          'name'  	=> 'priority',
          'label' 	=> Mage::helper('ticketsystem')->__('Priority'),
          'id'    	=> 'priority',
          'title' 	=> Mage::helper('ticketsystem')->__('Priority'),
          'class' 	=> 'input-select',
          'style'		=> 'width: 250px',
          'options'	=> array('1' => Mage::helper('ticketsystem')->__('Low'), '2' => Mage::helper('ticketsystem')->__('Medium'), '3' => Mage::helper('ticketsystem')->__('High')),
      ));
		      
      $fieldset->addField('cat', 'select', array(
          'name'  	=> 'cat',
          'label' 	=> Mage::helper('ticketsystem')->__('Department'),
          'id'    	=> 'cat',
          'title' 	=> Mage::helper('ticketsystem')->__('Department'),
          'class' 	=> 'input-select',
          'style'	=> 'width: 250px',
          'options'	=> $this->getCategories(),
      ));
      
      if ((Mage::registry('ticketsystem_data')->getData('trans_note'))){
	      $fieldset->addField('trans_note', 'textarea', array(
	          'label'     => Mage::helper('ticketsystem')->__('Transfer Note'),
	          'required'  => false,
	          'name'      => 'trans_note',
	          'style'	=> 'width: 600px; rows:5; background:#f2f2f2; height: 50px;',
	          'readonly'	=> 'readonly',
		  )); 
      }         
      $fieldset->addField('trans_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Optional Department Message'),
          'required'  => false,
          'name'      => 'trans_msg',
          'style'	=> 'width: 600px; height: 60px;',
	  ));
      $fieldset->addField('cat_alert', 'checkbox', array(
          'name'  	=> 'cat_alert',
          'label' 	=> Mage::helper('ticketsystem')->__('Department Send Alert'),
      	  'class' => 'attribute-checkbox',
      ));
      
      $fieldset->addField('message', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Message'),
          'required'  => false,
          'name'      => 'message',
      	  'class' 	=> 'input-select',
      	  'style'	=> 'width: 600px; background:#f2f2f2; height: 120px;',
      	  'readonly'	=> 'readonly',
	  ));
	  
	  $statuses= Mage::getSingleton('ticketsystem/status');
	  
	  $fieldset->addField('new_status', 'select', array(
          'name'  	=> 'new_status',
          'label' 	=> Mage::helper('ticketsystem')->__('New Status'),
          'id'    	=> 'new_status',
          'title' 	=> Mage::helper('ticketsystem')->__('New Status'),
          'class' 	=> 'input-select',
          'style'	=> 'width: 150px',
          'options'	=> $statuses->getOptionArray(),
      ));
	  
      $fieldset->addField('answer', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Answer'),
          'required'  => false,
          'name'      => 'answer',
      	  'style'	=> 'width: 600px; height: 120px;',
	  ));
	  
	  
      if ( Mage::getSingleton('adminhtml/session')->getTicketSystemData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTicketSystemData());
          Mage::getSingleton('adminhtml/session')->setTicketSystemData(null);
      } elseif ( Mage::registry('ticketsystem_data') ) {
          $form->setValues(Mage::registry('ticketsystem_data')->getData());
      }
      return parent::_prepareForm();
  }
  
	public function getRepresantatives() 
	{
		//$reps=Mage::registry('ticketsystem_represantatives');
		$model_reps= Mage::getModel('admin/user');
		$return_array=array();
  	 
	 
		foreach ($model_reps->getCollection()->load() as $key=>$val) { 
			$name=$val->getData('firstname').' '.$val->getData('lastname');
			$return_array[$val->getData('user_id')]= $name;
		}
	
		return $return_array;
	}
  
  public function getCategories() {
  	 $cats=Mage::registry('ticketsystem_categories');
  	 $return_array=array();
  	 array_unshift($return_array,'');
  	 if ($cats)
 	 foreach ($cats as $key=>$val){
 	 	if ($val){
			$name=$val->getData('name');
			$return_array[$val->getData('ID')]= $name;
 	 	}
	}
	return $return_array;
  }

}
