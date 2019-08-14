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

class MageTracking_TicketSystem_Adminhtml_CatController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('ticketsystem/cat')
			->_addBreadcrumb(Mage::helper('ticketsystem')->__('Departments'), Mage::helper('ticketsystem')->__('Departments'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction();
		$this->renderLayout();
	}
	

	public function editAction() {
		$this->loadLayout();
		$this->_setActiveMenu('ticketsystem/cat');
		$this->_addBreadcrumb(Mage::helper('ticketsystem')->__('Tickets'), Mage::helper('ticketsystem')->__('Departments'));
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		

		$id = $this->getRequest()->getParam('id');
		// Edit Ticket
		if ($id > 0) {
			
			$model  = Mage::getModel('ticketsystem/cats')->load($id);
			// set data for the front.
			Mage::register('cat_data', $model);
		}
		$this->_addContent($this->getLayout()->createBlock('ticketsystem/adminhtml_cat_edit'))
			 ->_addLeft($this->getLayout()->createBlock('ticketsystem/adminhtml_cat_edit_tabs'));
		$this->renderLayout();
	}
 

	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		$id=$this->getRequest()->getParam('id');
		$data = $this->getRequest()->getPost();
	
		$is_new=false;
		if ($id == 0)
			$is_new=true;
		try {
			// *********************************************
			// New Cat
			if ($is_new){
				$cat= Mage::getModel('ticketsystem/cats');
				$cat->setData($data);
				$cat->save();
			}
			// Existing Cat
			else{
				$cat=Mage::getModel('ticketsystem/cats')->load($id);
				$cat->setData($data);
				$cat->setData('ID',$id);
				$cat->save();
			}
			
			// *********************************************
					
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Department was successfully saved'));

        	if ($is_new)
				$this->_redirect('*/*/', array('id' => $id));
			else
				$this->_redirect('*/*/edit', array('id' => $id));
	
		} catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/', array('id' => $id));
        }	
       
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('ticketsystem/cats');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Department was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $ticketsystemIds = $this->getRequest()->getParam('ticketsystem');
        if(!is_array($ticketsystemIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Please select department(s)'));
        } else {
            try {
                foreach ($ticketsystemIds as $ticketsystemId) {
                    $ticketsystem = Mage::getModel('ticketsystem/cats')->load($ticketsystemId);
                    $ticketsystem->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ticketsystem')->__(
                        'Total of %d record(s) were successfully deleted', count($ticketsystemIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    
  
    public function exportCsvAction()
    {
        $fileName   = 'ticketsystem.csv';
        $content    = $this->getLayout()->createBlock('ticketsystem/adminhtml_softicket_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'ticketsystem.xml';
        $content    = $this->getLayout()->createBlock('ticketsystem/adminhtml_softicket_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}