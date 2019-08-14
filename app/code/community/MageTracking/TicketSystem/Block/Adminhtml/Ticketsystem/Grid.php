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

class MageTracking_TicketSystem_Block_Adminhtml_Ticketsystem_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	  public function __construct()
	  {
	      parent::__construct();
	      $this->setId('ticketsystemGrid');
	      $this->setDefaultSort('timestamp');
	      $this->setDefaultDir('ASC');
	      $this->setSaveParametersInSession(true);
	  }
	
	  
	  protected function _prepareCollection()
	  {
	      $collection = Mage::getModel('ticketsystem/ticketsystem')->getCollection();
	      $this->setCollection($collection);
	      return parent::_prepareCollection();
	  }

	  protected function _prepareColumns()
	  {
	  	  $this->addColumn('timestamp', array(
	          'header'    => Mage::helper('ticketsystem')->__('Timestamp'),
	          'align'     =>'left',
	          'index'     => 'timestamp',
	          'width'     => '125px',
	      ));
	      
	      $this->addColumn('subject', array(
	          'header'    => Mage::helper('ticketsystem')->__('Subject'),
	          'align'     =>'left',
	          'index'     => 'subject',
	          'width'     => '200px',
	      ));
	      
	      $this->addColumn('ID', array(
	          'header'    => Mage::helper('ticketsystem')->__('ID'),
	          'align'     =>'right',
	          'width'     => '70px',
	          'index'     => 'ID',
	      ));
	
	      $this->addColumn('name', array(
	          'header'    => Mage::helper('ticketsystem')->__('Name'),
	          'align'     =>'left',
	          'index'     => 'name',
	          'width'     => '200px',
	      ));
	
	      $this->addColumn('email', array(
				'header'    => Mage::helper('ticketsystem')->__('Email'),
				'width'     => '250px',
				'index'     => 'email',
	      ));
	
	      $statuses= Mage::getSingleton('ticketsystem/status')->getOptionArray();
	      $this->addColumn('status', array(
	          'header'    => Mage::helper('ticketsystem')->__('Status'),
	          'align'     => 'left',
	          'width'     => '150px',
	          'index'     => 'status',
	          'type'      => 'options',
	          'options'   => $statuses,
	      ));
		  
	      $this->addColumn('Action',
	            array(
	                'header'    =>  Mage::helper('ticketsystem')->__('Action'),
	                'width'     => '100',
	                'type'      => 'action',
	                'getter'    => 'getId',
	                'actions'   => array(
	                    array(
	                        'caption'   => Mage::helper('ticketsystem')->__('Edit'),
	                        'url'       => array('base'=> '*/*/edit'),
	                        'field'     => 'id'
	                    )
	                ),
	                'filter'    => false,
	                'sortable'  => false,
	                'index'     => 'stores',
	                'is_system' => true,
	        ));
			
			$this->addExportType('*/*/exportCsv', Mage::helper('ticketsystem')->__('CSV'));
			$this->addExportType('*/*/exportXml', Mage::helper('ticketsystem')->__('XML'));
		  
	      return parent::_prepareColumns();
	  }

	  protected function _prepareMassaction()
	  	{
	        $this->setMassactionIdField('ticketsystem_id');
	        $this->getMassactionBlock()->setFormFieldName('ticketsystem');
	
	
	        $this->getMassactionBlock()->addItem('delete', array(
	             'label'    => Mage::helper('ticketsystem')->__('Delete'),
	             'url'      => $this->getUrl('*/*/massDelete'),
	             'confirm'  => Mage::helper('ticketsystem')->__('Are you sure?')
	        ));
	
			$status = Mage::getSingleton('ticketsystem/status');
	        $this->getMassactionBlock()->addItem('status', array(
	             'label'=> Mage::helper('ticketsystem')->__('Change status'),
	             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
	             'additional' => array(
	                    'visibility' => array(
	                         'name' => 'status',
	                         'type' => 'select',
	                         'class' => 'required-entry',
	                         'label' => Mage::helper('ticketsystem')->__('Status'),
	                         'values' => $status->getOptionArray(),
	                     )
	             )
	        ));
	        return $this;
	   }
	
	public function getRowUrl($row)
	{
		   return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

}