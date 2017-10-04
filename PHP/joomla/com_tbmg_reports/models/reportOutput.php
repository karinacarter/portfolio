<?php
/**
 * @package    TBMG.Site
 * @subpackage TBMG_Reports
 *
 * @author     Tech Briefs Media Group <it@techbriefs.com>
 * @copyright  2017 Tech Briefs Media Group. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://www.techbriefsmediagroup.com
 */

defined('_JEXEC') or die;

/**
 * Class TBMGReportsModelReportOutput
 *
 * @since 2.5
 */
class TBMGReportsModelReportOutput extends JModelItem
{
	/**
	 * Pull data for display
	 *
	 * @return mixed
	 * @throws \Exception
	 * @throws \RuntimeException
	 *
	 * @since 2.5
	 */
	public function getData()
	{
		$jinput = JFactory::getApplication()->input;
		
		$tableName = $jinput->get('tableName', '');
		$rows      = $jinput->get('rows', 'ALL', 'raw');
		
		if ($rows === 'ALL') {
			$rows = '*';
		}
		
		$db = TBMGReportsHelperDatabase::getDBO();
		
		$query = $db->getQuery(true);
		
		$query
			->select($rows)
			->from($db->quoteName($tableName));
		#   ->where($db->quoteName('profile_key') . ' LIKE '. $db->quote('\'custom.%\''))
		#   ->order('ordering ASC')
		//;
		
		$db->setQuery($query);
		
		return $db->loadAssocList();
	}
}