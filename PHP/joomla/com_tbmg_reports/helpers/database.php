<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Class TBMGReportsHelperDatabase
 *
 * @since 3.6
 */
class TBMGReportsHelperDatabase
{
	/**
	 * @return \JDatabaseDriver
	 * @throws \Exception
	 * @throws \RuntimeException
	 *
	 * @since 3.6
	 */
	public static function getDBO($serverHost='local', $databaseName='blasts')
	{
		$jconfig = new JConfig();
		if(method_exists(JFactory::getApplication(),'getParams')){
			$jinput  = JFactory::getApplication()->getParams();
		}else{
			$jinput  = JFactory::getApplication()->input;
		}
		$serverHost   = $jinput->get('serverHost', $serverHost);
		$databaseName = $jinput->get('databaseName', $databaseName);
		
		if ($serverHost !== 'local') {
			
			$option = [
				'host'     => $serverHost,
				'user'     => 'tedmor',
				'password' => 'fargone',
				'database' => $databaseName,
			];
			
		} else {
			
			$option = [
				'host'     => $jconfig->host,
				'user'     => $jconfig->user,
				'password' => $jconfig->password,
				'database' => 'intranet',
			];
			
			/*
			 * for local debugging use the tbmg_intranet database based on root DB user
			 */
			if ($option['user'] === 'root') {
				$option['database'] = 'tbmg_intranet';
			}
		}
		
		$option['driver'] = $jconfig->dbtype;
		$option['prefix'] = '';
		
		return JDatabaseDriver::getInstance($option);
	}
}