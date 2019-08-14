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
 * @version 		1.0
 * @license		http://opensource.org/licenses/gpl-3.0.html GNU GENERAL PUBLIC LICENSE (GNU 3.0) 
 */


class MageTracking_TicketSystem_Block_Adminhtml_Ticketsystem_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'ticketsystem';
        $this->_controller = 'adminhtml_ticketsystem';
        
        $this->_updateButton('delete', 'label', Mage::helper('ticketsystem')->__('Delete Ticket'));
        
        if( $this->getId() )
        	$this->_updateButton('save', 'label', Mage::helper('ticketsystem')->__('Reply to Message'));
        else 
        	$this->_updateButton('save', 'label', Mage::helper('ticketsystem')->__('Save Ticket'));
        
        
		if($this->getId() )
		$this->_addButton('transfer_cats', array(
            'label'     => Mage::helper('ticketsystem')->__('Transfer Department'),
			'class'     => 'transfer_cats',
		    'onclick'   => 'transferCats(\''. $this->getUrl('*/*/transcat', array("id" => $this->getRequest()->getParam("id"))) .'\')',
            'level'     => -1
			), 100);

		if($this->getId() )
		$this->_addButton('newstat', array(
            'label'     => Mage::helper('ticketsystem')->__('Set New Status'),
			'class'     => 'newstat',
		    'onclick'   => 'newStatus(\''. $this->getUrl('*/*/setstat', array("id" => $this->getRequest()->getParam("id"))) .'\')',
            'level'     => -1
			), 100);


        
        $this->_formScripts[] = "
           
            
            function newStatus(url){
            	var newStatus= document.forms['edit_form'].new_status.value;
            	if (newStatus =='0'){
            		alert('". Mage::helper('ticketsystem')->__('Please select a status'). "');
            	}else{
        			document.forms['edit_form'].action=url+'new_status/'+newStatus+'/';
            		document.forms['edit_form'].submit();
            	}
            }
            
            function transferReps(url){
            	var representative= document.forms['edit_form'].rep.value;
            	if (representative =='0'){
            		alert('". Mage::helper('ticketsystem')->__('Please select a representative'). "');
            	}else{
        			document.forms['edit_form'].action=url+'reps/'+representative+'/';
            		document.forms['edit_form'].submit();
            	}
            }
            
            function transferCats(url){
            	var category= document.forms['edit_form'].cat.value;
            	var cats_message= document.forms['edit_form'].trans_msg.value;
            	var cat_alert= document.forms['edit_form'].cat_alert.value;
            	if (category =='0'){
            		alert('". Mage::helper('ticketsystem')->__('Please select a department'). "');
            	}else{
        			document.forms['edit_form'].action=url+'cats/'+category+'/'+'message/'+ cats_message +'/cat_alert/'+cat_alert+'/';
            		document.forms['edit_form'].submit();
            	}
            }		
        ";
    }

    
	public function getId()
    {
        return (Mage::registry('ticketsystem_data') && Mage::registry('ticketsystem_data')->getId());
    }
    
    public function getHeaderText()
    {
        if( $this->getId() ) {
            return Mage::helper('ticketsystem')->__("Edit Ticket '%s'", $this->htmlEscape(Mage::registry('ticketsystem_data')->getId()));
        } else {
            return Mage::helper('ticketsystem')->__('New Ticket');
        }
    }
}