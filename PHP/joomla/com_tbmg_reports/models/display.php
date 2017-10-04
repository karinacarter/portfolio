<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
class tbmgReportsModelDisplay extends JModelItem{
	protected $data;
    public function getData() {
	    
	    // Get The Parameters from the menu.    
	    $jinput = JFactory::getApplication()->input;
		$serverHost     = $jinput->get('serverHost', 'localhost');
		$tableName     = $jinput->get('tableName', '');
		$rows     = $jinput->get('rows', 'ALL', 'raw');
		$databaseName     = $jinput->get('databaseName', 'blasts');
		if($rows == "ALL"){$rows="*";}
        $option = array(); //prevent problems

		// Hard coded Database information
		if ($serverHost != 'local'){
			$option['driver']   = 'mysql';            // Database driver name
			$option['host']     = $serverHost;    // Database host name
			$option['user']     = 'XXXX';       // User for database authentication
			$option['password'] = 'XXXX';   // Password for database authentication
			$option['database'] = $databaseName;      // Database name
			$option['prefix']   = '';             // Database prefix (may be empty)
		
		
		}else {
				$option['driver']   = 'mysql';            // Database driver name
			$option['host']     = 'localhost';    // Database host name
			$option['user']     = 'XXXX';       // User for database authentication
			$option['password'] = 'XXXX';   // Password for database authentication
			$option['database'] = 'intranet';      // Database name
			$option['prefix']   = '';             // Database prefix (may be empty)
		}
	

		// Connect to the database and Grab the Data
		$db = JDatabaseDriver::getInstance( $option );
		$query = $db->getQuery(true);
		
		$query
		    ->select($rows)
		    ->from($db->quoteName($tableName));
		
	
		$db->setQuery($query);
		$data = $db->loadAssocList();
	    return $data;
	}
}