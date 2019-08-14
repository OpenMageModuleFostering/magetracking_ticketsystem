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



class MageTracking_TicketSystem_Adminhtml_TicketsystemController extends Mage_Adminhtml_Controller_action

{

	protected function _initAction() {

		$this->loadLayout()

			->_setActiveMenu('ticketsystem/ticket')

			->_addBreadcrumb(Mage::helper('ticketsystem')->__('TicketSystem'), Mage::helper('ticketsystem')->__('View Tickets'));

		return $this;

	}   

 

	public function indexAction() {

		$this->_initAction();

		$this->renderLayout();

	}



    

	public function editAction() {

		$this->loadLayout();

		$this->_setActiveMenu('ticketsystem/items');

		$this->_addBreadcrumb(Mage::helper('ticketsystem')->__('Ticket'), Mage::helper('ticketsystem')->__('View Tickets'));

		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);



		$cats = Mage::helper('ticketsystem')->getAllCategories(true);

		//$reps=Mage::helper('ticketsystem')->getAllRepresantatives();

		//Mage::register('ticketsystem_represantatives',$reps);

		Mage::register('ticketsystem_categories', $cats);

		

		$id = $this->getRequest()->getParam('id');

		// Edit Ticket

		if ($id > 0) {

			

			// **********************************************

			$model  = Mage::getModel('ticketsystem/ticketsystem')->load($id);

			$model->setData('hidden_ID',$id);

			$model->setData('hidden_status',$model->getData('status'));

			$model->setData('hidden_subject',$model->getData('subject'));

			$model->setData('hidden_name',$model->getData('name'));

			$model->setData('hidden_email',$model->getData('email'));

			$model->setData('hidden_phone',$model->getData('phone'));
			
			$model->setData('hidden_order',$model->getData('order'));

			$model->setData('cat_alert',1);

			$model->setData('rep_alert',1);

			// **********************************************

			Mage::register('ticketsystem_data', $model);

			

			$answers='';

			$model_ans  = Mage::getModel('ticketsystem/answers');

			foreach ($model_ans->getCollection()->addFieldToFilter('ticket',$id)->load() as $item){

				$message=$item->getData('message');

				$rep=$item->getData('rep');

				$timestamp=$item->getData('timestamp');
		
				$answers .='('.$timestamp.') '.$message."\n";

			}

			$model_msg  = Mage::getModel('ticketsystem/messages')->load($id, 'ticket');

			$message = $model_msg->getMessage();

			$timestamp= $model_msg->getTimestamp();

			
			$message ='('.$timestamp.') '.$message."\n";

			

			if ($answers)

				$message = $message."\n".$answers;

			// **********************************************

			

			// Set message to front

			$model->setData('message', $message);

			$model->setData('trans_note', $model->getData('trans_msg'));

			$model->setData('trans_msg','');

			

			$this->_addContent($this->getLayout()->createBlock('ticketsystem/adminhtml_ticketsystem_edit'))

			->_addLeft($this->getLayout()->createBlock('ticketsystem/adminhtml_ticketsystem_edit_tabs'));

			

		} else {

			// New Ticket

			$this->_addContent($this->getLayout()->createBlock('ticketsystem/adminhtml_ticketsystem_edit'))

			->_addLeft($this->getLayout()->createBlock('ticketsystem/adminhtml_ticketsystem_edit_newtabs'));

		}

		$this->renderLayout();

	}

 



	public function onholdAction() {

		$ticket = new Ticket();

		$ticket->id = $this->getRequest()->getParam('id');

		$ticket->changeStatus('onhold');

		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Status was successfully changed'));

		$this->_redirect('*/*/');

		return;

	}

 

	

	public function setstatAction() {

		$ticket = new Ticket();

		$id = $this->getRequest()->getParam('id');

		$new_status     = $this->getRequest()->getParam('new_status');

		if($new_status){

			$ticket->changeStatus($id,$new_status);  

			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Status was successfully changed'));

		}else{

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Please select a status'));

		}

		$this->_redirect('*/*/edit', array('id' => $id));

		return;

	}

 

	

	public function transrepAction() {

		$id     = $this->getRequest()->getParam('id');

		$repId  = $this->getRequest()->getParam('reps');

		$alert 	= $this->getRequest()->getParam('rep_alert');  

		if($repId){

			$ticket = new Ticket();

			$ticket->transRepTicket($id, $repId, $alert);

			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Represantative was successfully assigned'));

		}else{

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Please select a represantative'));

		}

		$this->_redirect('*/*/edit', array('id' => $id));

		return;

	}

	

	

	public function transcatAction() {

		$id     	= $this->getRequest()->getParam('id');

		$catId     	= $this->getRequest()->getParam('cats');

		$cat_message = $this->getRequest()->getParam('message');

		$alert 	= $this->getRequest()->getParam('cat_alert');



		$ticket = new Ticket();

		$ticket->transCatTicket($id, $catId, $cat_message, $alert);

		

		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Ticket is transfered to department successfully'));

		$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

		return;

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

			// New Ticket

			if ($is_new){

				if (empty($data['name'])==false && empty($data['email'])==false && empty($data['subject'])==false && empty($data['message'])==false)

					$id=Mage::helper('ticketsystem')->getTicketID();

				else {

					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Please enter all required fields'));

					$this->_redirect('*/*/new', array('id' => $this->getRequest()->getParam('id')));

					return;

				}

			}

			// Existing Ticket

			else if(is_array($data) && empty($data['answer'])){

				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Please enter the new message'));	

				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

				return;

			}

			

			// *********************************************

			$ticket = new Ticket();

			$ticket->id=$id;

			$ticket->message=$data['message'];

			$ticket->timestamp=now();

			if ($is_new){

				$ticket->subject=$data['subject'];

				$ticket->name=$data['name'];

				$ticket->email=$data['email'];

				$ticket->priority=$data['priority'];

				$ticket->category=$data['cat'];

				$ticket->ip=$_SERVER['REMOTE_ADDR'];

				$ticket->phone=$data['phone'];
				
				$ticket->orders=$data['orders'];



				if(!$ticket->create(true)){

					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Ticket could not be saved. Check all fields.'));

					return;

				}else{

					// Do not notify user for the message post

		        	$ticket->postMessage($id, $ticket->message, '', false, 'new');

		        	Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Ticket was successfully saved'));  

				}

			}else if (is_array($data) && empty($data['answer'])==false && empty($data['priority'])==false && empty($data['cat'])==false) {



				$answer=$data['answer'];

				if (!empty($answer)) {

					$user = Mage::getSingleton('admin/session')->getData('user');

					$username= $user->getData('username');

					if ($username){

						$ticket->postAnswer($answer, '', '', $ticket->id, 'awaitingcustomer');

					}

				}

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Ticket was successfully saved'));

			}else{

				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Ticket could not be saved. Check all fields.'));

			}

			// *********************************************

						

        	if ($is_new)

				$this->_redirect('*/*/', array('id' => $id));

			else

				$this->_redirect('*/*/edit', array('id' => $id));

	

		} catch (Exception $e) {

            //Mage::log('Save exception:'.$e);

            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

            Mage::getSingleton('adminhtml/session')->setFormData($data);

            $this->_redirect('*/*/', array('id' => $id));

        }	

	}

 

	public function deleteAction() {

		$id=$this->getRequest()->getParam('id');

		if( $id > 0 ) {

			try {

				$ticket = new Ticket();

				$ticket->delete($id);			

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticketsystem')->__('Ticket was successfully deleted'));

				$this->_redirect('*/*/');

			} catch (Exception $e) {

				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

				$this->_redirect('*/*/edit', array('id' => $id));

			}

		}

		$this->_redirect('*/*/');

	}



    public function massDeleteAction() {

        $softicketIds = $this->getRequest()->getParam('ticketsystem');

        if(!is_array($softicketIds)) {

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Please select ticket(s)'));

        } else {

            try {

                foreach ($softicketIds as $softicketId) {

                    $ticket = new Ticket();

					$ticket->delete($softicketId);

                }

                Mage::getSingleton('adminhtml/session')->addSuccess(

                    Mage::helper('ticketsystem')->__('Total of %d record(s) were successfully deleted', count($softicketIds)));

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

            }

        }

        $this->_redirect('*/*/index');

    }

	

    public function massStatusAction()

    {

        $softicketIds = $this->getRequest()->getParam('ticketsystem');

        $status = $this->getRequest()->getParam('status');

        if(!is_array($softicketIds)) {

            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Please select ticket(s)'));

        } else {

            try {

                foreach ($softicketIds as $softicketId) {

                	if ($softicketId >0){

                		$ticket = new Ticket();

						$ticket->changeStatus($softicketId, $status);

                	}else{

                		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticketsystem')->__('Please select ticket(s)'));

                		$this->_redirect('*/*/index');

                		return;

                	}

                }

                $this->_getSession()->addSuccess(Mage::helper('ticketsystem')->__('Total of %d record(s) were successfully updated', count($softicketIds)));

            } catch (Exception $e) {

                $this->_getSession()->addError($e->getMessage());

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