<?php
/**
 * @package     TBMG.Site
 * @subpackage  com_tbmg_reports
 *
 * @copyright   2017 Tech Briefs Media Group All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('TBMGReportsHelperDatabase', JPATH_COMPONENT . '/helpers/database.php');

$controller = JControllerLegacy::getInstance('TBMGReports');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
