<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_email extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
	} 

	public function index(){		
				//Load email library
				
			
				
				$this->load->library('email');

		
				
				$config['protocol'] = 'smtp';
				$config['smtp_host'] = 'mail.jurusphp.id'; //change this
				$config['smtp_port'] = '26';
				$config['smtp_user'] = 'kirim_laporan@jurusphp.id';
				$config['smtp_pass'] = 'jurusphp';
				$config['mailtype'] = 'html';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = TRUE;
				$config['newline'] = "\r\n";
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");
				
				//Email content
				$htmlContent = '<h1>Sending email via SMTP server</h1>';
				$htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

				$this->email->to('areknganjuk86@gmail.com');
				$this->email->from('mail.adisantoso@gmail.com','Laporan Toko asdasdasd');
				$this->email->subject('Berikut ini adalah Laporan dari Toko ....');
				$this->email->message($htmlContent);
				//$path =  base_url().'upload/attachment/tex.txt';
			
				//Send email
				$this->email->send();
			

				echo $this->email->print_debugger();
			 
	}
	
	
		public function pdf()  {
    
	    //Load the library
	    $this->load->library('html2pdf');
	    
	    //Set folder to save PDF to
	    $this->html2pdf->folder('./upload/attachment/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename('test.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper('a4', 'portrait');
	    
	    $data = array(
	    	'title' => 'PDF Created',
	    	'message' => 'Hello World!'
	    );
	    
	    //Load html view
	    $this->html2pdf->html($this->load->view('pdf', $data, true));
	    
	    if($this->html2pdf->create('save')) {
	    	//PDF was successfully saved or downloaded
	    	echo 'PDF saved';
	    }
	    
    } 

	
}
