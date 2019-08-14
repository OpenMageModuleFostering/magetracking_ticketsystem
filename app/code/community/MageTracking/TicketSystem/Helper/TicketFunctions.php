<?php
/**********************************************************************************
* eTicket – http://www.eticketsupport.com                                         *
* by Digital Frontiers, UTO                                                       *
***********************************************************************************
* Software Version: eTicket 1.7.3                                                 *
* Software by: Digital Frontiers, UTO (http://www.eticketsupport.com)             *
* Copyright 2008 by: Digital Frontiers, UTO (http://www.eticketsupport.com)       *
* Support, News, Updates at: http://www.eticketsupport.com                        *
***********************************************************************************
* This program is free software; you may redistribute it and/or modify it under   *
* the terms of the provided license as published by Digital Frontiers, UTO.       *
*                                                                                 *
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* See the "license.txt" file for details of the eTicket license.                  *
* The latest version can always be found at http://www.eticketsupport.com.        *
**********************************************************************************/

	//Note: Moved some of the standard functions in here...
	/* Clean Input (html2text,text2html) Start */
	function clean_input($input, $type = 'text') {
	    $output = $input;
	    if ($type == 'html') {
	        $output = html2text($output);
	    }
	    $output = text2html($output);
	    return $output;
	}
	function html2text($html) { //basic version -- borrowed in part from chuggnutt
	    preg_match('/<\s*body\s*\/?>(.*?)<\s*\/\s*body\s*\/?\s*>/is', $html, $match);
	    if (!empty($match[1])) {
	        $text = $match[1];
	    } else {
	        $text = $html;
	    }
	    $text = trim($text);
	    $search = array("/\r/", // Non-legal carriage return
	    "/[\n\t]+/", // Newlines and tabs
	    '/[ ]{2,}/', // Runs of spaces, pre-handling
	    '/<script[^>]*>.*?<\/script>/i', // <script>s -- which strip_tags supposedly has problems with
	    '/<style[^>]*>.*?<\/style>/i', // <style>s -- which strip_tags supposedly has problems with
	    '/<img [^>]*alt="([^"]+)"[^>]*>/ie', // <img>s
	    '/<a [^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/ie',
	    // <a href="">
	    '/<h[123][^>]*>(.*?)<\/h[123]>/ie', // H1 - H3
	    '/<h[456][^>]*>(.*?)<\/h[456]>/ie', // H4 - H6
	    '/<p[^>]*>/i', // <P>
	    '/<br\\\\s*?\\/??>/i', // <br>
	    '/<b[^>]*>(.*?)<\/b>/ie', // <b>
	    '/<strong[^>]*>(.*?)<\/strong>/ie', // <strong>
	    '/<i[^>]*>(.*?)<\/i>/i', // <i>
	    '/<em[^>]*>(.*?)<\/em>/i', // <em>
	    '/(<ul[^>]*>|<\/ul>)/i', // <ul> and </ul>
	    '/(<ol[^>]*>|<\/ol>)/i', // <ol> and </ol>
	    '/<li[^>]*>(.*?)<\/li>/i', // <li> and </li>
	    '/<li[^>]*>/i', // <li>
	    '/<hr[^>]*>/i', // <hr>
	    '/(<table[^>]*>|<\/table>)/i', // <table> and </table>
	    '/(<tr[^>]*>|<\/tr>)/i', // <tr> and </tr>
	    '/<td[^>]*>(.*?)<\/td>/i', // <td> and </td>
	    '/<th[^>]*>(.*?)<\/th>/ie', // <th> and </th>
	    '/&(nbsp|#160);/i', // Non-breaking space
	    '/&(quot|rdquo|ldquo|#8220|#8221|#147|#148);/i',
	    // Double quotes
	    '/&(apos|rsquo|lsquo|#8216|#8217);/i', // Single quotes
	    '/&gt;/i', // Greater-than
	    '/&lt;/i', // Less-than
	    '/&(amp|#38);/i', // Ampersand
	    '/&(copy|#169);/i', // Copyright
	    '/&(trade|#8482|#153);/i', // Trademark
	    '/&(reg|#174);/i', // Registered
	    '/&(mdash|#151|#8212);/i', // mdash
	    '/&(ndash|minus|#8211|#8722);/i', // ndash
	    '/&(bull|#149|#8226);/i', // Bullet
	    '/&(pound|#163);/i', // Pound sign
	    '/&(euro|#8364);/i', // Euro sign
	    '/&[^&;]+;/i', // Unknown/unhandled entities
	    '/[ ]{2,}/'
	    // Runs of spaces, post-handling
	    );
	    $replace = array('', // Non-legal carriage return
	    ' ', // Newlines and tabs
	    ' ', // Runs of spaces, pre-handling
	    '', // <script>s -- which strip_tags supposedly has problems with
	    '', // <style>s -- which strip_tags supposedly has problems with
	    'trim("\\1")', // <img>s
	    'html2link("\\1","\\2")',
	    // <a href=""> 1=link 2=text
	    "strtoupper(\"\n\n\\1\n\n\")", // H1 - H3
	    "ucwords(\"\n\n\\1\n\n\")", // H4 - H6
	    "\n\n\t", // <P>
	    "\n", // <br>
	    'strtoupper("\\1")', // <b>
	    'strtoupper("\\1")', // <strong>
	    '_\\1_', // <i>
	    '_\\1_', // <em>
	    "\n\n", // <ul> and </ul>
	    "\n\n", // <ol> and </ol>
	    "\t* \\1\n", // <li> and </li>
	    "\n\t* ", // <li>
	    "\n-------------------------\n", // <hr>
	    "\n\n", // <table> and </table>
	    "\n", // <tr> and </tr>
	    "\t\t\\1\n", // <td> and </td>
	    "strtoupper(\"\t\t\\1\n\")", // <th> and </th>
	    ' ', // Non-breaking space
	    '"', // Double quotes
	    "'", // Single quotes
	    '>', '<', '&', '(c)', '(tm)', '(R)', '--', '-', '*', '£', 'EUR', // Euro sign. € ?
	    '', // Unknown/unhandled entities
	    ' '
	    // Runs of spaces, post-handling
	    );
	    // Run search-and-replace
	    $text = preg_replace($search, $replace, $text);
	    // Strip any other HTML tags that may have been missed
	    $text = strip_tags($text);
	    // Bring down number of empty lines to 2 max
	    $text = preg_replace("/\n\s+\n/", "\n\n", $text);
	    $text = preg_replace("/[\n]{3,}/", "\n\n", $text);
	    return $text;
	}
	function html2link($link, $text) {
	    $text = trim(htmlspecialchars($text));
	    $link = trim(htmlentities($link));
	    if (!empty($text)) {
	        $link = trim("$link $text");
	    }
	    return "[$link]";
	}
	function text2html($text) {
	    $html = $text; //first step to converting text to html
	    $html = htmlspecialchars_decode($html);
	    $html = htmlspecialchars($html);
	    $html = nl2br($html); //turn new lines to <br>s
	    $html = link2html($html); //create html links
	    return $html;
	}
	function link2html($text) { //borrowed in part from wordpress
	    $text = preg_replace("/\[\[(.*?)[ ]{1}(.*?)\]\]/i", '<a href="\\1">\\2</a>', $text);
	    $text = preg_replace("/\[(.*?)[ ]{1}(.*?)\]/i", '<a href="\\1">\\2</a>', $text);
	    $text = preg_replace(array('#([\s>])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is', '#([\s>])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is', '#([\s>])([a-z0-9\-_.]+)@([^,< \n\r]+)#i'), array('$1<a href="$2" rel="nofollow">$2</a>', '$1<a href="http://$2" rel="nofollow">$2</a>', '$1<a href="mailto:$2@$3">$2@$3</a>'), $text);
	    $text = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $text);
	    $text = trim($text);
	    return $text;
	}
	if (!function_exists('remove_trailing_slash')) {
	    function remove_trailing_slash($dir, $slash = DIRECTORY_SEPARATOR) {
	        if (substr($dir, -1) == $slash) {
	            $dir = substr($dir, 0, -1);
	        }
	        return $dir;
	    }
	}
	if (!function_exists('add_trailing_slash')) {
	    function add_trailing_slash($dir, $slash = DIRECTORY_SEPARATOR) {
	        if (substr($dir, -1) != $slash) {
	            $dir = $dir . $slash;
	        }
	        return $dir;
	    }
	}
	function escape_string($value, $quotes = true) {
	    $value = trim($value);
	    $value = get_magic_quotes_gpc() ? stripslashes($value) : $value;
	    if (!(is_numeric($value) && intval($value) == $value)) {
	        if (function_exists('mysql_real_escape_string')) {
	            $value = mysql_real_escape_string($value);
	        } else {
	            $value = addslashes($value);
	        }
	    }
	    if ($quotes == true) {
	        $value = "'$value'";
	    }
	    return $value;
	}
	function escape_array($array) {
	    $new = array();
	    foreach($array as $key => $val) {
	        $new[$key] = escape_string($val);
	    }
	    return $new;
	}
	function trim_post($array) { //$array is for array of post keys
	    foreach($array as $key) {
	        if (isset($_POST[$key])) {
	            $_POST[$key] = trim($_POST[$key]);
	        }
	    }
	}
	if (!function_exists('array_combine')) {
	    function array_combine($keys, $vals) {
	        $keys = array_values((array)$keys);
	        $vals = array_values((array)$vals);
	        $n = max(count($keys), count($vals));
	        $r = array();
	        for ($i = 0;$i < $n;$i++) {
	            $r[$keys[$i]] = $vals[$i];
	        }
	        return $r;
	    }
	}
	//upload function: name of form file field,destination filename,max file size,file types(.ext or mi/me)
	function upload_file($file, $dest = '', $maxsize = '99999', $types = array(), $errors = array('nodata' => 'No uploaded file data', 'empty' => 'Empty uploaded file data', 'toolong' => 'Filename is too long', 'invalidpath' => 'Upload path is invalid', 'pathwrite' => 'Upload path is NOT writable', 'nofile' => 'Not an uploaded file', 'invalidtype' => 'Invalid file type', 'toosmall' => 'File is too small', 'toobig' => 'File is too big', 'exists' => 'File already exists', 'failed' => 'Upload failed')) {
	    if (empty($dest)) {
	        $dest = './' . $file['name'];
	    }
	    if (!isset($file)) {
	        return $errors['nodata'];
	    }
	    if (empty($file)) {
	        return $errors['empty'];
	    }
	    if (strlen($file['name']) > 60) {
	        return $errors['toolong'];
	    }
	    if ($file['error'] != 0) {
	        return $file['error'];
	    }
	    if (!is_dir(dirname($dest))) {
	        return $errors['invalidpath'];
	    }
	    if (!is_writeable(dirname($dest))) {
	        return $errors['pathwrite'];
	    }
	    if (!is_uploaded_file($file['tmp_name'])) {
	        return $errors['nofile'];
	    }
	    if (!check_file_types($file['name'], $types)) {
	        return $errors['invalidtype'];
	    }
	    if ($file['size'] == 0) {
	        return $errors['toosmall'];
	    }
	    if ($file['size'] > $maxsize) {
	        return $errors['toobig'];
	    }
	    if (file_exists($dest)) {
	        return $errors['exists'];
	    }
	    if (!@copy($file['tmp_name'], $dest)) {
	        return $errors['failed'];
	    }
	    @unlink($file['tmp_name']);
	    return 0;
	}
	function check_file_types($file, $types = array()) {
	    if (!empty($types)) {
	        foreach($types as $type) {
	            if (strstr($type, '/')) {
	                if (strtolower(mime_content_type($file)) == strtolower($type)) {
	                    return TRUE;
	                }
	            } else {
	                if (strtolower(get_ext($file)) == strtolower($type)) {
	                    return TRUE;
	                }
	            }
	        }
	    }
	}
	if (!function_exists('mime_content_type')) {
	    function mime_content_type($filename) {
	        $finfo = finfo_open(FILEINFO_MIME);
	        $mimetype = finfo_file($finfo, $filename);
	        finfo_close($finfo);
	        return $mimetype;
	    }
	}
	function get_ext($file) { //returns .ext, ie: .jpg
	    if (strstr($file, '.')) {
	        $ext = substr($file, strrpos($file, '.'));
	        return $ext;
	    }
	}
	function is_email($email) { //returns email address if it's valid
	    $pattern = '/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/';
	    if (preg_match($pattern, $email)) {
	        if (getmx_from_email($email)) {
	            return $email;
	        }
	    }
	}
	// support windows platforms
	if (!function_exists('getmxrr')) {
	    if ((isset($_ENV['OS'])) && ($_ENV['OS'] == 'Windows_NT')) {
	        function getmxrr($hostname, &$mxhosts, &$mxweight) {
	            if (!is_array($mxhosts)) {
	                $mxhosts = array();
	            }
	            if (!empty($hostname)) {
	                $output = '';
	                $exec = 'nslookup.exe -q=mx ' . escapeshellarg($hostname);
	                @exec($exec, $output);
	                $imx = -1;
	                foreach($output as $line) {
	                    $imx++;
	                    $parts = "";
	                    if (preg_match("/^$hostname\tMX preference = ([0-9]+), mail exchanger = (.*)$/", $line, $parts)) {
	                        $mxweight[$imx] = trim($parts[1]);
	                        $mxhosts[$imx] = trim($parts[2]);
	                    }
	                    if (preg_match("/responsible mail addr = (.*)/", $line, $parts)) {
	                        $mxweight[$imx] = $imx;
	                        $mxhosts[$imx] = trim($parts[1]);
	                    }
	                }
	                return ($imx != -1);
	            }
	            return false;
	        }
	    }
	}
	function getmx_from_email($email) {
	    list($user, $hostname) = split('@', $email);
	    return getmx($hostname);
	}
	function getmx($hostname) {
	    getmxrr($hostname, $mxhosts, $mxweight); //check for a true MX record
	    $mx = array_shift($mxhosts); // get the first MX record
	    if (!empty($mx)) {
	        return $mx;
	    } else { // RFC says use the A line if there is no MX
	        $ip = gethostbyname($hostname); // get the ip from hostname
	        if ($ip != $hostname) { // continue if returned ip not hostname
	            $hostname = gethostbyaddr($ip); // get the rdns (real) hostname
	            $ip = gethostbyname($hostname); // check the (real) hostname has an A record
	            if ($ip != $hostname) { // continue if returned ip not hostname
	                return $hostname;
	            }
	        }
	    }
	}
	
	//This function was introduced to provide better handling of emails
	//The $body is on the understanding that it's plain text and will be converted to HTML
	function send_mail($to, $subject, $body, $from, $priority = 2, $db_settings) { //v0.3
	
	    include_once ('Phpmailer.php');
	    $mail = new Phpmailer();
	    $from_name='';
	    $from_email='';
	    $to_name='';
	    $to_email='';
	    
	    if ($to[0] == ':') {
	        return false;
	    } // this email address is disabled
	    
	    if (preg_match('/(.+)<(.+)>/i', $from, $matches)) {
	        if (!empty($matches[1])) {
	            $from_name = trim($matches[1]);
	        }
	        if (!empty($matches[2])) {
	            $from_email = trim($matches[2]);
	        }
	    }
	    if (empty($from_email)) {
	        $from_email = $from;
	    }
	    
	    if (preg_match('/(.+)<(.+)>/i', $to, $matches)) {
	        if (!empty($matches[1])) {
	            $to_name = trim($matches[1]);
	        }
	        if (!empty($matches[2])) {
	            $to_email = trim($matches[2]);
	        }
	    }
	    
	    if (empty($to_email)) {
	        $to_email = $to;
	    }
	    
	    if (is_array($body)) {
	        if (!empty($body['html'])) {
	            $mail->IsHTML(true);
	            $mail->Body = $body['html'];
	            $htmlbody = $body['html'];
	        }
	        if (!empty($body['text'])) {
	            $mail->AltBody = $body['text'];
	            $body = $body['text'];
	        }
	    } else {
	        $mail->Body = $body;
	    }
	
	    # Priority?
	    if ($priority == 3) {
	        $pri = 1;
	    } elseif ($priority == 1) {
	        $pri = 5;
	    } else {
	        $pri = 3;
	    }
		$db_settings['mail_method'] = "mail";
//print_r($db_settings['mail_method']);die();
	    # SEND THE EMAIL
	    if ($db_settings['mail_method'] == "smtp") {
	        $mail->IsSMTP();
	        $mail->Host = $db_settings['smtp_host'];
	        $mail->Port = $db_settings['smtp_port'];
	        $mail->Helo = $_SERVER['SERVER_NAME']; 
	        if ($db_settings['smtp_auth'] == "1") {
	            $mail->SMTPAuth = TRUE;
	            $mail->Username = $db_settings['smtp_user'];
	            $mail->Password = $db_settings['smtp_pass'];
	        }
	    } elseif ($db_settings['mail_method'] == "mail") {
	        $mail->IsMail();  
	    } else {
	        $mail->IsSendmail();
	        $mail->Sendmail = $db_settings['sendmail_path'];
	    }
		
	    $mail->Hostname = $_SERVER['SERVER_NAME']; 
	    $mail->From = $from_email;
	    $mail->FromName = str_replace('"', '', $from_name);
	    $mail->Subject = $subject;
	    $mail->AddAddress($to_email, $to_name);
	    $mail->Priority = $pri;
	    $mail->CharSet = $db_settings['charset'];
	    if(!$mail->Send()) {
	        $mail_sent = FALSE;
	    } else {
	        $mail_sent = TRUE;
	    }
	    return $mail_sent;
	}
	function size_readable($size, $retstring = null) { //returns a human readable filesize
	    if ((!is_numeric($size)) && (file_exists($size))) {
	        $size = filesize($size);
	    }
	    $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	    if ($retstring === null) {
	        $retstring = '%01.2f %s';
	    }
	    $lastsizestring = end($sizes);
	    foreach($sizes as $sizestring) {
	        if ($size < 1024) {
	            break;
	        }
	        if ($sizestring != $lastsizestring) {
	            $size/= 1024;
	        }
	    }
	    if ($sizestring == $sizes[0]) {
	        $retstring = '%01d %s';
	    } // Bytes aren't normally fractional
	    return sprintf($retstring, $size, $sizestring);
	}
	function format_time($format, $time = false) {
	    if (preg_match('/%/', $format)) {
	        if ($time) {
	            return strftime($format, $time);
	        } else {
	            return strftime($format);
	        }
	    }
	    if ($time) {
	        return date($format, $time);
	    } else {
	        return date($format);
	    }
	}
	
	
	
	function getdirs($dir) {
	    $ignore = array('.', '..', 'index.php');
	    $files = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (!in_array($file, $ignore)) {
	                if (is_dir($dir . $file)) {
	                    $files[] = $file;
	                }
	            }
	        }
	        closedir($handle);
	    }
	    return $files;
	}
	if (!function_exists('htmlspecialchars_decode')) {
	    function htmlspecialchars_decode($text) {
	        return strtr($text, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
	    }
	}
	
	function htmlspecialchars_array($arr = array()) {
	    $rs = array();
	    while (list($key, $val) = each($arr)) {
	        if (is_array($val)) {
	            $rs[$key] = htmlspecialchars_array($val);
	        } else {
	            $rs[$key] = htmlspecialchars($val, ENT_QUOTES);
	        }
	    }
	    return $rs;
	}
	
	
	function keywords($input, $vars, $db_settings) {
	    $vars['url'] = $db_settings['root_url'];
	    foreach($vars as $key => $val) {
	        $input = str_replace("%$key", $val, $input);
	    }
	    return $input;
	}
	
	function getHTML($message, $vars, $template = 'email-example.html', $db_settings) {
		$theme_dir=Mage::getBaseDir().'/app/code/local/MageTracking/TicketSystem/Helper/';
	    if (file_exists($theme_dir . $template)) {
	        $html = file_get_contents($theme_dir . $template);
	        $message = keywords($message, $vars, $db_settings);
	        $message = text2html($message);
	        $html = str_replace('%%MSG%%', $message, $html);
	        foreach($vars as $key => $val) {
	            $vars[$key] = htmlspecialchars($val);
	        }
	        $html = keywords($html, $vars, $db_settings);
	        return $html;
	    }
	}
	
	function addRemoveTag($msg, $db_settings) {
	    if ((isset($db_settings['remove_original'])) && (!empty($db_settings['remove_tag']))) {
	        $msg = $db_settings['remove_tag'] . "\n\n" . $msg;
	    }
	    return $msg;
	}
	
	function addSig($sig, $msg ,$db_settings) {
		
	    if (!empty($sig)) {
	        $sig = "\n" . $db_settings['presig'] . $sig;
	        $sig = str_replace("\r", "\n", $sig);
	        $sig = str_replace("\n\n", "\n", $sig);
	        $msg.= $sig;
	    }
	    return $msg;
	}


?>