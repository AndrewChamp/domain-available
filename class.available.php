<?php

  class available{
		
		
		private $domains = array();
		private $status = true;
		private $available = null;
		private $ext = '.txt';
		
		
		public function __construct($_domains=null, $_email){
			if($_domains == null)
				throw new Exception('You need to specify the domains to check in '.__CLASS__.' class.');
				
			$this->domains = $_domains;
			$this->email = $_email;
			
			if(count($this->domains) > 1):
				foreach($this->domains as $dom):
					$this->check($dom);
					if($this->status && !file_exists($dom.$this->ext)):
						$this->available .= $dom."\r\n";
						$this->cache($dom);
					endif;
					$this->reset();
				endforeach;
			else:
				$this->check($this->domains);
				if($this->status && !file_exists($this->domains.$this->ext)):
					$this->available = $this->domains."\r\n";
					$this->cache($this->domains);
				endif;
			endif;
			
			if($this->available != null)
				$this->mailer();
		}
		
		
		public function __destruct(){
			$this->reset();
		}
		
		
		private function check($domain){
			if(checkdnsrr($domain.'.', 'ANY'))
				$this->status = false;
		}
		
		
		private function reset(){
			foreach(get_class_vars(get_class($this)) as $name => $default):
				if($name != 'available')
					$this->$name = $default;
			endforeach;
		}
		
		
		private function mailer(){
			$subject = 'Domains available!';
			$message = 'New domain(s) available!'."\r\n\r\n".$this->available."\r\n";
			$headers = 'From: noreply@yourdomain.com' . "\r\n".'Reply-To: noreply@yourdomain.com'."\r\n".'X-Mailer: PHP/'.phpversion();
			mail($this->email, $subject, $message, $headers);
		}
		
		
		private function cache($domain){
			file_put_contents($domain.$this->ext, '');
		}


	}

?>
