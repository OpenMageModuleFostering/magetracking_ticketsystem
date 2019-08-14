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
 * @created     Manmeet Kaur 24th Sep,2014
 * @author      Clarion magento team<Manmeet Kaur>   

 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/community-edition
 */

class MageTracking_TicketSystem_Block_Adminhtml_Ticketsystem_Mail_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ticketsystem_mail', array('legend'=>Mage::helper('ticketsystem')->__('New Ticket Reply').'&nbsp;&nbsp;&nbsp;: '.Mage::helper('ticketsystem')->__('Message sent when a new ticket is opened')));
	  $data =Mage::registry('ticketsystem_maildata');
        
      $fieldset->addField('ticket_response', 'checkbox', array(
          'label'     => Mage::helper('ticketsystem')->__('Enable'),
          'title' 	  => Mage::helper('ticketsystem')->__('Enable'),
          'name'      => 'ticket_response',
      	  'id'        => 'ticket_response',
          'value'     => 1,
      	  'checked'   => $data->getData('ticket_response')
      ));
      
      $fieldset->addField('ticket_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Subject'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'ticket_subj',
      ));

      $fieldset->addField('ticket_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Message'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'ticket_msg',
	  ));
		


	  $fieldset = $form->addFieldset('ticketsystem_newmessagereply', array('legend'=>Mage::helper('ticketsystem')->__('New Message Reply').'&nbsp;&nbsp;&nbsp;: '.Mage::helper('ticketsystem')->__('Message sent everytime a reply is made to a ticket.')));
      
      $fieldset->addField('message_response', 'checkbox', array(
          'label'     => Mage::helper('ticketsystem')->__('Enable'),
          'required'  => false,
          'name'      => 'message_response',
          'value'     => 1,
          'checked'   => $data->getData('message_response')
      ));
      
      $fieldset->addField('message_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Subject'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'message_subj',
      ));

      $fieldset->addField('message_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Message'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'message_msg',
	  ));

	  
	  	  
	  $fieldset = $form->addFieldset('ticketsystem_categorytransfernotification', array('legend'=>Mage::helper('ticketsystem')->__('Department Transfer Notification').'&nbsp;&nbsp;&nbsp;: '.Mage::helper('ticketsystem')->__('Message sent when a message has been transfered to a different department.')));
      
      $fieldset->addField('trans_response', 'checkbox', array(
          'label'     => Mage::helper('ticketsystem')->__('Enable'),
          'required'  => false,
          'name'      => 'trans_response',
          'value'     => 1,
          'checked'   => $data->getData('trans_response')
      ));
      
      $fieldset->addField('trans_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Subject'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'trans_subj',
      ));

      $fieldset->addField('trans_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Message'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'trans_msg',
	  ));
		
	 
	  

	  
	  $fieldset = $form->addFieldset('softicket_answermessage', array('legend'=>Mage::helper('ticketsystem')->__('Answer Message').'&nbsp;&nbsp;&nbsp;: '.Mage::helper('ticketsystem')->__('Message sent when answering a ticket, changing it is not recommended.')));
      
      $fieldset->addField('answer_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Subject'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'answer_subj',
      ));

      $fieldset->addField('answer_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Message'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'answer_msg',
	  ));
	      

	  
      if ( Mage::getSingleton('adminhtml/session')->getTicketsystemMailData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTicketsystemMailData());
          Mage::getSingleton('adminhtml/session')->setSofTicketMailData(null);
      } elseif ( Mage::registry('ticketsystem_maildata') ) {
          $form->setValues(Mage::registry('ticketsystem_maildata')->getData());
      }
      return parent::_prepareForm();
  }
}