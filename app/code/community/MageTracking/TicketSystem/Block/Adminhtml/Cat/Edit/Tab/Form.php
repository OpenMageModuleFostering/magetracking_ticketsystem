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
class MageTracking_TicketSystem_Block_Adminhtml_Cat_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('cat_form', array('legend'=>Mage::helper('ticketsystem')->__('Edit Department')));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
      /*$fieldset->addField('pophost', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Pop 3 Host'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'pophost',
      ));
      
      $fieldset->addField('popuser', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Pop 3 User'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'popuser',
      ));
      
      $fieldset->addField('poppass', 'password', array(
          'label'     => Mage::helper('ticketsystem')->__('Pop 3 Password'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'poppass',
      ));*/
      
      
      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'email',
      ));

      $fieldset->addField('signature', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Signature'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'signature',
      	 'style'		=> 'width: 600px',
      ));
		
      $fieldset->addField('hidden', 'hidden', array(
          'label'     => Mage::helper('ticketsystem')->__('Hidden'),
          'name'      => 'hidden',
      ));
	  
	  $fieldset->addField('reply_method', 'select', array(
          'name'  	=> 'reply_method',
          'label' 	=> Mage::helper('ticketsystem')->__('Reply Method'),
          'title' 	=> Mage::helper('ticketsystem')->__('Reply Method'),
          'class' 	=> 'input-select',
          'style'		=> 'width: 250px',
          'options'	=> array('url' => Mage::helper('ticketsystem')->__('Send URL to load ticket'), 'message' => Mage::helper('ticketsystem')->__('Show message in email')),
      ));

	  
      if ( Mage::getSingleton('adminhtml/session')->getCatData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCatData());
          Mage::getSingleton('adminhtml/session')->setCatData(null);
      } elseif ( Mage::registry('cat_data') ) {
          $form->setValues(Mage::registry('cat_data')->getData());
      }
      return parent::_prepareForm();
  }
}