<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| MY_Exceptions
| -------------------------------------------------------------------------
| Extendiendo la clase "Exceptions" del core de CI
| 
|
|	http://codeigniter.com/user_guide/general/core.html
|
*/

class MY_Exceptions extends CI_Exceptions {
    function log_exception($severity, $message, $filepath, $line) {
        $current_reporting = error_reporting();
        $should_report = $current_reporting & $severity;

        if ($should_report) {
            $severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];
            log_message('error', 'Severity: '.$severity.'  --> '.$message. ' '.$filepath.' '.$line, TRUE);
        }
    }
}


/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */