<?php
class Count_page_pdf extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();

    }
	function getNumPagesPdf($filepath){
		$fp = @fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
		$max=0;
		while(!feof($fp)) {
				$line = fgets($fp,255);
				if (preg_match('/\/Count [0-9]+/', $line, $matches)){
						preg_match('/[0-9]+/',$matches[0], $matches2);
						if ($max<$matches2[0]) $max=$matches2[0];
				}
		}
		fclose($fp);
		if($max==0){
			$im = new imagick($filepath);
			$max=$im->getNumberImages();
		}

		return $max;
	}
}

//echo getNumPagesPdf("upload/file_pdf/1502300764.pdf");
?>