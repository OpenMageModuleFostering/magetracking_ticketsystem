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

		//print_r($data);die();

    	if ($data && $data['ID'] && $data['ID'] >0 ) {

            try {

            	//$repid=$data['rep'];

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
        //print_r($data);die();
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        //$select = "SELECT * from ticket_tickets where status NOT LIKE 'CLOSED' AND email = '".$data['email']."' ";
		$select = "SELECT * from mticketing_tickets where status NOT LIKE 'CLOSED' AND email = '".$data['email']."' ";
        $rowArray = $connection->fetchAll($select);   //return row       
        $ticket_id = $rowArray[0]['ID']; 
        $ticket_count = count($rowArray);
        //print_r($data['email']);die();
    	//if ($data && $ticket_count==0) {
                 
            try {

		    	$ticket = new Ticket();
//echo "look";die();
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

       // }
	   /*
        else
        {
            // To get the refrence ID
            $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
            $select_message_id = "SELECT id from ticket_messages where ticket = '".$ticket_id."'";
            $rowArray_message = $connection->fetchRow($select_message_id);   //return row  
            
            $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
            $connection->beginTransaction();
            $fields = array();
            $fields['ticket']= $ticket_id;        
            $fields['message']= $data['message'];
            $fields['reference']= $rowArray_message['id'];

            $connection->insert('ticket_answers', $fields);
            $connection->commit(); 
            
            Mage::getSingleton('core/session')->addSuccess('Ticket was successfully saved');
            $this->_redirectSuccess(Mage::getUrl('*//*/index', array('_secure'=>true)));
            return;
              
        }*/

        $this->_redirectError(Mage::getUrl('*/*/edit', array('id'=>$id)));

    }

    

}