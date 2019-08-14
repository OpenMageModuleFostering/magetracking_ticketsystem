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





require_once 'Mail_data.php';



class Ticket {

	



  /* ID of the ticket.

   * @var int

   */

  public $id          = 0;

  

  

  /* Name of the person filling out the ticket.

   * @var int

   */

  public $name          = '';

  

   /**

   * Email of the person filling out the ticket.

   * @var int

   */

  public $email          = '';

  

   /**

   * Phone of the person filling out the ticket.

   * @var int

   */

  public $phone          = '';

  

   /**

   * Category of the ticket.

   * @var int

   */

  public $category          = 0;

  

  /**

   * Email priority (1 = High, 2 = Normal, 3 = low).

   * @var int

   */

  public $priority          = 2;

  

   /**

   * IP of the client.

   * @var int

   */

  public $ip          = '';

  

   /**

   * Message coming the first time from the user.

   * @var int

   */

  public $message          = '';

  

   /**

   * Subject of the Message.

   * @var int

   */

  public $subject          = '';

  

   /**

   * Subject of the Message.

   * @var int

   */

  public $timestamp          = '';

  

  

  function create($sendmail = TRUE) {



 

  	  	if ($this->id && $this->priority && $this->category && $this->subject && $this->name && $this->email){

			$db_settings=Mage::helper('ticketsystem')->getMailDBSettings();



		    if (($this->ip != '') && ($_SERVER['REMOTE_ADDR'] != ''))

		        $this->ip = $_SERVER['REMOTE_ADDR'];

		    

		    if (($this->priority == '') || ($this->priority < 0 || $this->priority > 3)) 

		    	$this->priority = 2;

		    	

		    $this->priority = preg_replace('/\D+/', '', $this->priority); //sanitise

		    $this->category = preg_replace('/\D+/', '', $this->category); //sanitise

		    $this->timestamp = now();

		    



		    // insert a new ticket...

		    $model = Mage::getModel('ticketsystem/ticketsystem');

		    $model->setData('ID',$this->id);

		    $model->setData('subject',$this->subject);

		    $model->setData('name',$this->name);

		    $model->setData('email',strtolower($this->email));

		    $model->setData('cat',$this->category);

		    $model->setData('priority',$this->priority);

		    $model->setData('phone',$this->phone);
			
			$model->setData('orders',$this->orders);

		    $model->setData('ip',$this->ip);

		    $model->setData('message',$this->message);

		    $model->setData('timestamp',$this->timestamp);

		    $model->save();

		    

		    $c = Mage::getModel('ticketsystem/cats')->load($this->category);

		   	$mailsubj = $db_settings['ticket_subj'];

	        $mailmsg = $db_settings['ticket_msg'];

	        $signature= $c->getData('signature');

	        

		    if ($sendmail) { //should we send?

		 		$mail=new Mail_data();

		        $mail->sendEmail($this->id, $this->subject, $this->name, $this->email, $c, $this->priority, $this->message,$mailsubj, $mailmsg, $signature);

		    }

		    return true;

  	  	}else

  	  		return false;

	}



	

	function close($ticketID) {

		$this->changeStatus($ticketID, 'closed');

	}

	function reopen($ticketID) {

		$this->changeStatus($ticketID, 'reopened');

	}

	function putonHold($ticketID) {

		$this->changeStatus($ticketID, 'onhold');

	}

	function delete($ticketID) {

	   	$ticketID = preg_replace('/\D+/', '', $ticketID); //sanitise

	    // delete ticket

		$model = Mage::getModel('ticketsystem/ticketsystem');

		$model->setId($ticketID)->delete();

			   

		// delete messages

		$model = Mage::getModel('ticketsystem/messages');

		$model->setTicket($ticketID)->delete();

			

		// delete answers

		$model = Mage::getModel('ticketsystem/answers');

		foreach ($model->getCollection()->addFieldToFilter('ticket',$ticketID)->load() as $item){

			$ans_id=$item->getData('ID');

			if ($ans_id){

				Mage::getModel('ticketsystem/answers')

				->setId($ans_id)

				->delete();

			}

		}

	}



	function changeStatus($ticketId, $status){

	    $ticketId = preg_replace('/\D+/', '', $ticketId); //sanitise

	    $model = Mage::getModel('ticketsystem/ticketsystem')->load($ticketId);

	    $model->setData('status',$status);

	    $model->update();

	}

	

	function changeRep($ticketId, $repId){

	    $ticketId = preg_replace('/\D+/', '', $ticketId); //sanitise

	    $model = Mage::getModel('ticketsystem/ticketsystem')->load($ticketId);

	    $model->setData('rep',$repId);

	    $model->update();

	}

	

	function postMessage($ticketId, $message, $header = '', $notifyuser = true, $newstatus = 'new') {

	

		$db_settings=Mage::helper('ticketsystem')->getMailDBSettings();



	    $ticketId = preg_replace('/\D+/', '', $ticketId); //sanitise

	    $errors = array();



	    $this->reopen($ticketId);

	    $header = $db_settings['save_headers'] ? $header : '';

	    

	    $model = Mage::getModel('ticketsystem/messages');

	    $model->setData('headers',$header);

	    $model->setData('message',$message);

	    $model->setData('ticket',$ticketId);

	    $model->setData('timestamp',now());

	    $id=$model->save()->getId();

	

	    

	    //update ticket status

	    $this->changeStatus($ticketId, $newstatus);

	    

	    if ($db_settings['alert_new']) {

	    	$mail = new Mail_data();

	        $mail->emailAlert($ticketId, $id);

	    }

	    if ($db_settings['message_response'] && $notifyuser) {

	    	$t = Mage::getModel('ticketsystem/ticketsystem')->load($ticketId);

	    	$c = Mage::getModel('ticketsystem/cats')->load($t->getData('cat'));



	        $mailsubj = $db_settings['message_subj'];

	        $mailmsg = $db_settings['message_msg'];

	        $signature= $c->getData('signature');

	       	$mail=new Mail_data();

		    $mail->sendEmail($t->getData('ID'), $t->getData('subject'), $t->getData('name'), $t->getData('email'), $c, $t->getData('priority'), $t->getData('message'), $mailsubj, $mailmsg, $signature);

	    }

	}

	function postAnswer($message, $repid, $rep_name, $ticketid, $newstatus) {



		$db_settings=Mage::helper('ticketsystem')->getMailDBSettings();

		

	    $msg_res = Mage::getModel('ticketsystem/messages')->load($ticketid,'ticket');

	    $msgid= $msg_res->getData('ID');

	    

	    $t = Mage::getModel('ticketsystem/ticketsystem')->load($ticketid);



	   	$this->changeStatus($ticketid, $newstatus);

	    if (! ($rep_name == 'Administrator')) {

	    	if($repid > 0)

	    		$this->changeRep($ticketid, $repid);

	    }

	    

	    $answers=Mage::getModel('ticketsystem/answers');

	    $answers->setData('ticket',$ticketid);

	    $answers->setData('message',$message);

	    $answers->setData('reference',$msgid);

	    $answers->setData('rep',$repid);

	    $answers->save();

	   	

	    $catid=$t->getData('cat');

	    $cat_res=Mage::getModel('ticketsystem/cats')->load($catid);

	    $answer_subj = $db_settings['answer_subj'];

	    $answer_msg = $db_settings['answer_msg'];

	    $signature= $cat_res->getData('signature');

	   	$mail=new Mail_data();

		$mail->sendEmail($ticketid, $t->getData('subject'), $t->getData('name'), $t->getData('email'), $cat_res, $t->getData('priority'), $message, $answer_subj, $answer_msg, $signature, true);   

	}

	

	

	function postPrivMessage($ticket, $repid, $msg) {

	    $db_settings=Mage::helper('ticketsystem')->getMailDBSettings();

	    $id = preg_replace('/\D+/', '', $id); //sanitise

	    $errors = array();

	    $model=Mage::getModel('ticketsystem/privmsg');

	    $model->setData('ticket',$ticket);

	    $model->setData('rep',$repid);

	    $model->setData('message',$msg);

	    $model->setData('timestamp',now());

	    $model->save();

	    return $errors ? $errors : $id;

	}

	

	

	function transCatTicket($tid, $cid, $add_msg = false, $alert = false) {

		

	    $db_settings=Mage::helper('ticketsystem')->getMailDBSettings();

	    

	    $tid = preg_replace('/\D+/', '', $tid); //sanitise

	    $cid = preg_replace('/\D+/', '', $cid); //sanitise



	    $add_msg = $add_msg ? ': ' . $add_msg : '';

	    $add_msg = preg_replace("/%20/", " ", $add_msg);

	    

	    

	    $model=Mage::getModel('ticketsystem/ticketsystem')->load($tid);

	    $catFrom=Mage::getModel('ticketsystem/cats')->load($model->getData('cat'));

		$cat2=Mage::getModel('ticketsystem/cats')->load($cid);

	    $trans_msg = 'From ' . $catFrom->getData('name') . ' ' . ' (' . format_time($db_settings['time_format']) . ') ' . $add_msg;

	    $model->setData('cat',$cid);

	    $model->setData('trans_msg', $trans_msg);

	    $model->update();

	    

	    if ($db_settings['trans_response'] && !$cat2->getData('hidden') && $alert) {

	        $trans_subj = $db_settings['trans_subj'];

	        $trans_msg = $db_settings['trans_msg'];

	        $vars = array();

	        $vars['ticket'] = $tid;

	        $vars['subject'] = $model->getData('subject');

	        $vars['category'] = $cat2->getData('name');

	        $vars['cat_name'] = $cat2->getData('name');

	        $vars['name'] = $model->getData('name');

	        $vars['email'] = $model->getData('email');

	        $vars['status'] = $model->getData('status');

	        $vars['trans_msg'] = $add_msg;

	        //$trans_msg = addRemoveTag($trans_msg, $db_settings);

	        $trans_msg = addSig($cat2->getData('signature'), $trans_msg, $db_settings);

	        $trans_subj = keywords($trans_subj, $vars, $db_settings);

	        $text = keywords($trans_msg, $vars,$db_settings);

	        if ($html = getHTML($trans_msg, $vars, 'email-example.html',$db_settings)) {

	            $body = array();

	            $body['text'] = $text;

	            $body['html'] = $html;

	        } else {

	            $body = $text;

	        }

	        //notify user

	        $from = '"' . $cat2->getData('name') . '" <' . $cat2->getData('email') . '>';

	        $mail=new Mail_data();

            //$mail->sendEmail($tid,$model->getData('subject'),$model->getData('name'),$model->getData('email'), $cat2, $model->getData('priority'),$add_msg,$trans_subj,$text,'',true);
            send_mail($model->getData('email'), $trans_subj, $body, $from, $model->getData('priority'),$db_settings);                       
	        //notify admin

	        $from = $db_settings['alert_email'];

	        $mail=new Mail_data();

	        foreach($mail->getEmails($cat2->getData('ID')) as $to) {

	            if (!empty($to)) {

	                $mail=new Mail_data();

                    send_mail($to, $trans_subj, $body, $from, $model->getData('priority'),$db_settings);

	            }

	        }

	    }

	}

	

	

	function transRepTicket($tid, $rid, $alert = false, $rep_name) {

		$db_settings=Mage::helper('ticketsystem')->getMailDBSettings();

		// Fetch Admin user details
        $query = "SELECT * from admin_user where user_id=$rid"; 
        $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($query);

	    $tid = preg_replace('/\D+/', '', $tid); //sanitise

	    $rid = preg_replace('/\D+/', '', $rid); //sanitise

	    if (empty($tid)) {

	        return;

	    }

	    if (empty($rid)) {

	        return;

	    }

	    

		$model=Mage::getModel('ticketsystem/ticketsystem')->load($tid);

		$repFrom=Mage::getModel('ticketsystem/reps')->load($model->getData('rep'));

		$rep2=Mage::getModel('ticketsystem/reps')->load($rid);

		$model->setData('rep',$rid);

		$model->update();

		

        if ($db_settings['rep_trans_response'] && $alert) {

            $trans_subj = $db_settings['rep_trans_subj'];



            $trans_msg = $db_settings['rep_trans_msg'];

            $vars = array();

            $vars['ticket'] = $tid;

            $vars['subject'] = $model->getData('subject');

            $vars['rep_name'] = $data[0]['firstname']." ".$data[0]['lastname'];

            $vars['name'] = $model->getData('name');

            $vars['email'] = $model->getData('email');

            $vars['status'] = $model->getData('status');

            $trans_subj = keywords($trans_subj, $vars, $db_settings);



            $text = keywords($trans_msg, $vars, $db_settings);

            if ($html = getHTML($trans_msg, $vars, 'email-example.html', $db_settings)) {

                $body = array();

                $body['text'] = $text;

                $body['html'] = $html;

            } else {

                $body = $text;

            }



            //notify admin

            $from = $db_settings['alert_email'];
            if (empty($from)) {
                $user = Mage::getSingleton('admin/session');
                $from = $user->getUser()->getEmail();
            }

            $emails = array();

            

            // alert_users need to be alerted

            if (!empty($db_settings['alert_user'])) {

                $emails = explode(';', $db_settings['alert_user']);

            }

            // The rep who is being transferred from needs to be alerted

            if ($repFrom->getData('email')) {

                $emails[] = $repFrom->getData('email');

            }

            // The rep who is being transferred to needs to be alerted

            if ($rep2->getData('email')) {

                $emails[] = $rep2->getData('email');

            }
            
            // Check the Admin email
            if (!empty($data)) {
                $emails[] = $data[0]['email'];
            }

            // Ensure we don't send to the same email address twice

            $emails = array_unique($emails);
                      

            foreach($emails as $to) {

                if (!empty($to)) {

                    send_mail($to, $trans_subj, $body, $from, $model->getData('priority'),$db_settings);

                }

            }

        }

    

	}

		

}