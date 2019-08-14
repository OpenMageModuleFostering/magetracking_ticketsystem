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

class MageTracking_TicketSystem_Block_Adminhtml_Ticketsystem_Setting_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ticketsystem_setting', array('legend'=>Mage::helper('ticketsystem')->__('Settings')));
	  $data =Mage::registry('ticketsystem_settingdata');

      $fieldset->addField('answer_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Answer Subject'),
          'required'  => false,
          'name'      => 'answer_subj',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('answer_msg', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Answer Message'),
          'required'  => false,
          'name'      => 'answer_msg',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('remove_tag', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Remove Tag'),
          'required'  => false,
          'name'      => 'remove_tag',
          'style'		=> 'width: 600px',
      ));
	  
      $fieldset->addField('ticket_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Ticket Subject'),
          'required'  => false,
          'name'      => 'ticket_subj',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('ticket_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Ticket Message'),
          'required'  => false,
          'name'      => 'ticket_msg',
          'style'		=> 'width: 600px',
      ));
            
      $fieldset->addField('alert_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Alert Subject'),
          'required'  => false,
          'name'      => 'alert_subj',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('alert_msg', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Alert Message'),
          'required'  => false,
          'name'      => 'alert_msg',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('alert_email', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Alert Emails of Admins'),
          'required'  => false,
          'name'      => 'alert_email',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('alert_user', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Alert Emails of Users'),
          'required'  => false,
          'name'      => 'alert_user',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('alert_new', 'checkbox', array(
          'label'     => Mage::helper('ticketsystem')->__('Alert New'),
          'required'  => false,
          'name'      => 'alert_new',
          'style'		=> 'text-align:left;width: 20px',
          'checked'   => $data->getData('alert_new'),
          'value'   => 1,
      ));
      
      $fieldset->addField('message_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Message Subject'),
          'required'  => false,
          'name'      => 'message_subj',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('message_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Message Message'),
          'required'  => false,
          'name'      => 'message_msg',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('trans_subj', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Transfer Subject'),
          'required'  => false,
          'name'      => 'trans_subj',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('trans_msg', 'textarea', array(
          'label'     => Mage::helper('ticketsystem')->__('Transfer Message'),
          'required'  => false,
          'name'      => 'trans_msg',
          'style'		=> 'width: 600px',
      ));
      
      $fieldset->addField('root_url', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Root Url'),
          'required'  => false,
          'name'      => 'root_url',
          'style'		=> 'width: 300px',
      ));
            
      $fieldset->addField('smtp_host', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Smtp Host'),
          'required'  => false,
          'name'      => 'smtp_host',
          'style'		=> 'width: 300px',
      ));
      
      $fieldset->addField('smtp_port', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Smtp Port'),
          'required'  => false,
          'name'      => 'smtp_port',
          'style'		=> 'width: 60px',
      ));
      
      $fieldset->addField('smtp_auth', 'checkbox', array(
          'label'     => Mage::helper('ticketsystem')->__('Smtp Auth'),
          'required'  => false,
          'name'      => 'smtp_auth',
          'style'		=> 'text-align:left;width: 20px',
      	  'checked'   => $data->getData('smtp_auth'),
          'value'   => 1,
      ));
      
      $fieldset->addField('smtp_user', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Smtp User'),
          'required'  => false,
          'name'      => 'smtp_user',
          'style'		=> 'width: 150px',
      ));
      
      $fieldset->addField('smtp_pass', 'password', array(
          'label'     => Mage::helper('ticketsystem')->__('Smtp Password'),
          'required'  => false,
          'name'      => 'smtp_pass',
          'style'		=> 'width: 150px',
      ));
      
      $fieldset->addField('sendmail_path', 'text', array(
          'label'     => Mage::helper('ticketsystem')->__('Send Mail Path'),
          'required'  => false,
          'name'      => 'sendmail_path',
          'style'		=> 'width: 300px',
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getTicketsystemSettingData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTicketsystemSettingData());
          Mage::getSingleton('adminhtml/session')->getTicketsystemSettingData(null);
      } elseif ( Mage::registry('ticketsystem_settingdata') ) {
          $form->setValues(Mage::registry('ticketsystem_settingdata')->getData());
      }
      return parent::_prepareForm();
  }
}