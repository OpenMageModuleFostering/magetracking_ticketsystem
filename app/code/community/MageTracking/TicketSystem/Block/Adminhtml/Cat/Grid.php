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
class MageTracking_TicketSystem_Block_Adminhtml_Cat_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('catGrid');
      $this->setDefaultSort('name');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('ticketsystem/cats')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  
  protected function _prepareColumns()
  {
      $this->addColumn('ID', array(
          'header'    => Mage::helper('ticketsystem')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'ID',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('ticketsystem')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
	  
      $this->addColumn('email', array(
          'header'    => Mage::helper('ticketsystem')->__('Email'),
          'align'     =>'left',
          'index'     => 'email',
      ));
      
      $this->addColumn('signature', array(
          'header'    => Mage::helper('ticketsystem')->__('Signature'),
          'align'     =>'left',
          'index'     => 'signature',
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
                    ),
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

        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}