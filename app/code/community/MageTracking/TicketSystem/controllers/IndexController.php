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
 * @created     Manmeet Kaur 27th Sep,2014
 * @author      Clarion magento team<Manmeet Kaur>   

 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/community-edition
 */


require 'MageTracking/TicketSystem/Helper/Ticket.php'; 



class MageTracking_TicketSystem_IndexController extends Mage_Core_Controller_Front_Action

{

	

    protected function _getSession()

    {

        return Mage::getSingleton('customer/session');

    }



    public function preDispatch()

    {

        parent::preDispatch();

		

		if (Mage::getSingleton('customer/session')->isLoggedIn()) {

			if (! $this->_getSession()->authenticate($this)) {

				$this->setFlag('', 'no-dispatch', true);

			}

		}

    }



    public function indexAction()

    {

    	$ticketsystemModel = Mage::getModel('ticketsystem/ticketsystem');

		$customerId= $this->_getSession()->getCustomerId();

		$ticketsystem= $ticketsystemModel->getAllTickets($customerId);

		Mage::register('ticketsystem_all', $ticketsystem, true);

		

    	if ((is_null($ticketsystem) == false) && (empty($ticketsystem) == false) ) {

	        $this->loadLayout();

	        $this->_initLayoutMessages('customer/session');

	        $this->renderLayout();

    	}

        else {

            $this->getResponse()->setRedirect(Mage::getUrl('*/*/add'));

        }

    }



    public function addAction()

    {

        $this->loadLayout();

        $this->_initLayoutMessages('customer/session');        
    	if ($navigationBlock = $this->getLayout()->getBlock('customer_account_navigation')) {

	            $navigationBlock->setActive('ticketsystem');

	    }

        $this->renderLayout();

    }

    

    public function editAction()

    {

        $this->loadLayout();

        $this->_initLayoutMessages('customer/session');

    	if ($navigationBlock = $this->getLayout()->getBlock('customer_account_navigation')) {

	            $navigationBlock->setActive('ticketsystem');

	    }



        $this->renderLayout();

    }



    public function editPostAction()

    {

    	$data= $this->getRequest()->getPost();

		

    	if ($data && $data['ID'] && $data['ID'] >0 ) {

            try {

            	

            	$id=$data['ID'];

            	$answer=$data['answer'];

            	$rep_name='';

		    	



				$ticket = new Ticket();

		    	$ticket->postAnswer($answer, '','', $id, 'custreplied');

		    	if (Mage::getSingleton('customer/session')->isLoggedIn()) {

					$this->_getSession()->addSuccess($this->__('Ticket was successfully updated')); 

				}

				else

				{

					Mage::getSingleton('core/session')->addSuccess($this->__('Ticket was successfully updated'));

				}

			    $this->_redirectSuccess(Mage::getUrl('*/*/', array('_secure'=>true, 'id'=>$id)));

			    return;

            }

            catch (Mage_Core_Exception $e) {

                $this->_getSession()->setticketsystemFormData($this->getRequest()->getPost())

                    ->addException($e, $e->getMessage());

            }

            catch (Exception $e) {

                $this->_getSession()->setticketsystemFormData($this->getRequest()->getPost())

                    ->addException($e, $this->__('Ticket cannot be saved'));

            }

        }

		if (Mage::getSingleton('customer/session')->isLoggedIn()) {

			$this->_getSession()->addError($this->__('Ticket cannot be saved'));

		} else {

			Mage::getSingleton('core/session')->addError($this->__('Ticket cannot be saved'));	

		}

		$this->_redirectError(Mage::getUrl('*/*/'));

    }



   

    public function addPostAction()

    {

        $data= $this->getRequest()->getPost();    
        
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        
		$select = "SELECT * from mticketing_tickets where status NOT LIKE 'CLOSED' AND email = '".$data['email']."' ";
        $rowArray = $connection->fetchAll($select);   //return row       
        $ticket_id = $rowArray[0]['ID']; 
        $ticket_count = count($rowArray);
       
                 
            try {

		    	$ticket = new Ticket();

	    		$id=Mage::helper('ticketsystem')->getTicketID();

				$ticket->id=$id;

				$ticket->message=$data['message'];

				$ticket->timestamp=now();

                $ticket->subject=$data['subject'];

				$ticket->name=$data['name'];

				$ticket->email=$data['email'];

				$ticket->priority=$data['priority'];

				$ticket->category=$data['cat'];

				$ticket->ip=$_SERVER['REMOTE_ADDR'];

				$ticket->phone=$data['phone'];
				if ($data['orders']=='Select Order') {
					$ticket->orders= '';
				} else {
					$ticket->orders=$data['orders'];
				}

		    	if(!$ticket->create(true)){ 

					$this->_getSession()->addError($this->__('Ticket cannot be saved'));

					$this->_redirectError(Mage::getUrl('*/*/'));

					return;

				}else{

		        	$ticket->postMessage($id, $ticket->message, '', true, 'new');

					if (Mage::getSingleton('customer/session')->isLoggedIn()) {

						$this->_getSession()->addSuccess($this->__('Ticket was successfully saved')); 

					}

					else {

						Mage::getSingleton('core/session')->addSuccess($this->__('Ticket was successfully saved'));

					}

		        	$this->_redirectSuccess(Mage::getUrl('*/*/', array('_secure'=>true)));

		        	return;

				}

            }

            catch (Mage_Core_Exception $e) {

                $this->_getSession()->setticketsystemFormData($this->getRequest()->getPost())

                    ->addException($e, $e->getMessage());

            }

            catch (Exception $e) {

                $this->_getSession()->setticketsystemFormData($this->getRequest()->getPost())

                    ->addException($e, $this->__('Ticket cannot be saved'));

            }

      
        $this->_redirectError(Mage::getUrl('*/*/edit', array('id'=>$id)));

    }

    

}