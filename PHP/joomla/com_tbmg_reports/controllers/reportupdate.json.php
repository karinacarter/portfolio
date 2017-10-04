<?php
	require_once JPATH_COMPONENT.'/controller.php';
class tbmgReportsControllerReportupdate extends tbmgReportsController
{
	function updateReport() {
		$jinput 		= JFactory::getApplication()->input;
		$rowID     		= $jinput->get('pk', '');
		
		$serverHost     = $jinput->get('serverHost', 'local');
		$databaseName 	= $jinput->get('databaseName', 'blasts');
		$tableName     	= $jinput->get('tableName', '','raw');
		$Fieldname     	= $jinput->get('value', '','raw');
		$positionName   = $jinput->get('name', '','raw');

		$db = TBMGReportsHelperDatabase::getDBO($serverHost, $databaseName);
		$tableKey = $db->getTableKeys($tableName);
		$id =  $tableKey[0]->Column_name;
		

		$query = $db->getQuery(true);
		if ($positionName =='delete'){
			$conditions = array(
			$db->quoteName($id) . ' = '.$rowID);
			$query->delete($db->quoteName($tableName));
			$query->where($conditions);
		}else{
			if (is_array($Fieldname)){
				$Fieldname = json_encode($Fieldname);
			}
			// Fields to update.
			$fields = array(
			    $db->quoteName($positionName) . " = '" . $Fieldname ."'",
			);     
			$conditions = $db->quoteName($id) . ' = ' . $rowID;

			$query->update($db->quoteName($tableName))
			      ->set($fields)
			      ->where($conditions);
		}
		$db->setQuery($query);
		try
			{
			    $db->execute();
			    echo new JResponseJson('Successfully Updated');
			}
		catch (RuntimeException $e)
			{
			    $e->getMessage();
			    echo new JResponseJson($e->getMessage(), 'ERROR', true);
			}
    }
}