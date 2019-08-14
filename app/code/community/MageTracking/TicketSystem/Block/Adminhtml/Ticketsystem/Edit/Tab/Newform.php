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
class MageTracking_TicketSystem_Block_Adminhtml_Ticketsystem_Edit_Tab_NewForm extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ticketsystem_form', array('legend'=>Mage::helper('ticketsystem')->__('Ticket information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Name'),
          'id'      => 'name',
      	  'name'      => 'name',
          'class'     => 'required-entry',
          'required'  => true,
      ));
      
      $fieldset->addField('subject', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Subject'),
          'id'      => 'subject',
      	  'name'      => 'subject',
          'class'     => 'required-entry',
          'required'  => true,
	  ));

      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Email'),
          'id'      => 'email',
      	  'name'      => 'email',
          'class'     => 'required-entry',
          'required'  => true,
	  ));
	  
	  $fieldset->addField('phone', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Phone'),
          'id'      => 'phone',
      	  'name'      => 'phone',
          'required'  => false,
	  ));
	  
	  $fieldset->addField('orders', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Order'),
          'id'      => 'order',
      	  'name'      => 'orders',
          'required'  => false,
	  ));
	  
	  $fieldset->addField('priority', 'select', array(
          'name'  	=> 'priority',
          'label' 	=> Mage::helper('ticketsystem')->__('Priority'),
          'id'    	=> 'priority',
          'title' 	=> Mage::helper('ticketsystem')->__('Priority'),
          'class' 	=> 'required-entry',
          'style'		=> 'width: 250px',
	  	  'required'  => true,
          'options'	=> array('1' => Mage::helper('ticketsystem')->__('Low'), '2' => Mage::helper('ticketsystem')->__('Medium'), '3' => Mage::helper('ticketsystem')->__('High')),
      ));
	  
      $fieldset->addField('cat', 'select', array(
          'name'  	=> 'cat',
          'label' 	=> Mage::helper('ticketsystem')->__('Department'),
          'id'    	=> 'cat',
          'title' 	=> Mage::helper('ticketsystem')->__('Department'),
          'class' 	=> 'input-select',
          'style'	=> 'width: 250px',
      	  'required'  => true,
          'options'	=> $this->getCategories(),
      ));
      
	  
      $fieldset->addField('message', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Message'),
          'required'  => false,
          'name'      => 'message',
      	  'style'	=> 'width: 600px',
          'class'     => 'required-entry',
          'required'  => true,
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
  
  public function getRepresantatives() {
  	 $reps=Mage::registry('ticketsystem_represantatives');
  	 $return_array=array();
 	 foreach ($reps as $key=>$val){
		$name=$val->getData('name');
		$return_array[$key]= $name;
	}
	array_unshift($return_array,'');
	return $return_array;
  }
  
  public function getCategories() {
  	 $cats=Mage::registry('ticketsystem_categories');
  	 $return_array=array();
 	 foreach ($cats as $key=>$val){
		$name=$val->getData('name');
		$return_array[$key]= $name;
	}
	return $return_array;
  }
}
