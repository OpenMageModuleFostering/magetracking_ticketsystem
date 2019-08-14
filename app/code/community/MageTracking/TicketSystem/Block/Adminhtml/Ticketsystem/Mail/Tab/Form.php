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
	  /*	  
	  $fieldset = $form->addFieldset('ticketsystem_transresponse', array('legend'=>Mage::helper('ticketsystem')->__('Representative Transfer Notification').'&nbsp;&nbsp;&nbsp;: '.Mage::helper('ticketsystem')->__('Message sent when a ticket has been transfered to a different representative.')));
      $fieldset->addField('rep_trans_response', 'checkbox', array(
          'label'     => Mage::helper('ticketsystem')->__('Enable'),
          'required'  => false,
          'name'      => 'rep_trans_response',
          'value'   => 1,
          'checked'   => $data->getData('rep_trans_response')
      ));
      
      $fieldset->addField('rep_trans_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Subject'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'rep_trans_subj',
      ));

      $fieldset->addField('rep_trans_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Message'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'rep_trans_msg',
	  ));*/
	  
	    

	  
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