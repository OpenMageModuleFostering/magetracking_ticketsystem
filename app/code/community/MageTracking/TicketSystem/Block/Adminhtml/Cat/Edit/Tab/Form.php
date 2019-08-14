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