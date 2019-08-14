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


class MageTracking_TicketSystem_Block_Adminhtml_Ticketsystem_Setting_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
  	  $this->setId('ticketsystem_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ticketsystem')->__('Settings'));
      parent::__construct();

  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('ticketsystem')->__('Settings'),
          'title'     => Mage::helper('ticketsystem')->__('Settings'),
          'content'   => $this->getLayout()->createBlock('ticketsystem/adminhtml_ticketsystem_setting_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}