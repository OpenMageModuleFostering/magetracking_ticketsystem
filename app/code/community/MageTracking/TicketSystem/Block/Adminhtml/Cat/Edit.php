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
class MageTracking_TicketSystem_Block_Adminhtml_Cat_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'ticketsystem';
        $this->_controller = 'adminhtml_ticketsystem';
        
        $this->_updateButton('delete', 'label', Mage::helper('ticketsystem')->__('Delete Department'));
        
        $this->_updateButton('save', 'label', Mage::helper('ticketsystem')->__('Save Department'));
        
    }
    

    public function getHeaderText()
    {
        if( Mage::registry('cat_data') && Mage::registry('cat_data')->getId() ) {
            return Mage::helper('ticketsystem')->__("Edit Department '%s'", Mage::registry('cat_data')->getData('name'));
        } else {
            return Mage::helper('ticketsystem')->__('New Department');
        }
    }
}