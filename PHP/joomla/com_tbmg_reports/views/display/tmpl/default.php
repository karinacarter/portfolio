<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('tbmg.user');

JHtml::script('jui/jquery.min.js', false, true);
JHtml::script('com_tbmg_reports/persistentHeader.js', false, true);
JHtml::script('com_tbmg_reports/jquery.tablesorter.js', false, true);
JHtml::script('com_tbmg_reports/tbmg.js', false, true);


JHtml::stylesheet('com_tbmg_reports/tbmg_reports.css', [], true);

$jinput      = JFactory::getApplication()->getParams();

$tableHeader = $jinput->get('tableHeader', '', 'raw');

$available_fields = [
	'TopBanner', 'TopSponsor', 'Banner2', 'Banner3', 'Sponsor2', 'Sponsor3',
];
for ($i = 1; $i <= 12; $i++) {
	$available_fields[] = 'Position_' . $i;
}

$headers = array_keys($this->data[0]);
$columns = count($headers);
$tableFields = json_decode(json_encode($jinput->get('Columns','text','raw')),TRUE);

$trclass = '';


// alternate usage example
//if (TBMGUser::inGroup('ScheduleEditor')) {
if (TBMGUser::isScheduleEditor()) {
	$ingroup = 'yes';
	JHtmlBootstrap::framework();
	JHtmlBootstrap::loadCss();
	JHtml::script('com_tbmg_reports/tbmg-editable.js', false, true);

	
	JHtml::script('com_tbmg_reports/jquery.poshytip.min.js', false, true);
	JHtml::stylesheet('com_tbmg_reports/tip-yellowsimple.css', [], true);

	JHtml::stylesheet('com_tbmg_reports/jquery-editable.css', [], true);
	JHtml::script('com_tbmg_reports/jquery-editable-poshytip.js', false, true);
	JHtml::stylesheet('com_tbmg_reports/tbmg_editable.css', [], true);


	
	$databaseName = $jinput->get('databaseName', '', 'raw');
	$tablename    = $jinput->get('tableName', '', 'raw');
	$serverHost   = $jinput->get('serverHost', '', 'raw');
	$columns = $columns+1;
	
}
?>

<div class="backRtoeports"><a href="/tbmg-intranet/reports"><< Back to Reports</a></div>

<div class="table-responsive">
	<table class='table table-striped table-bordered user-select-none reportPage persistentHeader <?php if (TBMGUser::isScheduleEditor()) : ?> editable-table <?php endif ?>tablesorter'
		   id="tbmg-editable-table">

		<thead>
		<tr>
			<td colspan='<?= $columns ?>' class='tableHeaders rowHeader'><?= $tableHeader ?></td>
		</tr>
		
		<tr>
			<?php if (TBMGUser::isScheduleEditor()) : ?>
						<th class="header-none"> &nbsp;</th>
					<?php endif ?>
		<?php foreach ($headers as $headerText) :
			if (is_array($tableFields)) { $headerOutput = array_column($tableFields, $headerText);
				if (isset($headerOutput[0]) && $headerOutput[0]=='hidden'){
					$classaddition="hidden";
				}else {
					$classaddition="";
				}
			}

			$headerText = str_replace('_', ' ', $headerText);
			$headerText = preg_replace('/(?<!\ -)[A-Z]/', ' $0', $headerText);
			$headerText = trim($headerText);
			if (TBMGUser::isScheduleEditor()) : ?>
			
			
					<?php endif ?>
			<th class='header-<?= $headerText ?> <?= $classaddition ?>'><?= $headerText ?></th>
		<?php endforeach; ?>
		</thead>
		<tbody>
		<?php 
			$count = 1;foreach ($this->data as $row) : ?>
			<?php 
if (isset($row['Edition'])) {
	$trclass = 'edition-' . preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(html_entity_decode($row['Edition'])));
}
?>
			<tr class='<?= $trclass ?>'>
				<?php foreach ($row as $column => $value) : ?>
					<?php if ($column == 'TransmissionDate' || $column == 'date') : ?>
						<?php $value = date('F d', strtotime($value)) ?>
					<?php elseif (empty($value) && in_array($value, $available_fields) && !TBMGUser::isScheduleEditor()) : ?>
						<?php $value = "<span class='red'>AVAILABLE</span>"; ?>
					<?php elseif (empty($value) && !TBMGUser::isScheduleEditor()) : ?>
						<?php $value = "<span class='red'>AVAILABLE</span>"; ?>
					<?php endif ?>
					
					<?php 
						
						if (is_array($tableFields)) { $output = array_column($tableFields, $column);}
						
						if (isset($output[0]) && $output[0]=='hidden'){
							$classaddition="hidden";
							$output[0] = 'text';
							
						}else{$classaddition='';}
						if (TBMGUser::isScheduleEditor()) : ?>
					
					
					
					<?php 
						
						
						
						
						
						
						if (isset($output[0]) && $output[0]=='country'){
						
						$countrylist ="['USA','Canada', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bonaire', 'Bosnia and Herzegovina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territories', 'British Virgin Islands', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'C.A.R.', 'Cambodia', 'Cameroon', 'Canada', 'Canary Islands', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos Islands', 'Colombia', 'Comoros', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote Divoire', 'Croatia', 'Cuba', 'Curacao', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Territories', 'Gabon', 'Galapagos Islands', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea, North', 'Korea, South', 'Kosovo', 'Kuala Lumpur', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn', 'Poland', 'Portugal', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia', 'Samoa', 'San Marino', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Eustatius', 'Sint Maarten', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'Spain', 'Sri Lanka', 'St Vincent', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Syrian Arab Republic', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Tibet', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'Uruguay', 'USA', 'Uzbekistan', 'Vanuatu', 'Venezuela', 'Vietnam', 'Virgin Islands (British)', 'Virgin Islands (US)', 'Western Sahara','Yemen', 'Yugoslavia', 'Zaire', 'Zambia', 'Zimbabwe']";
						$output[0] = 'select" data-source='.'"'.$countrylist .'"';
						}
						if (isset($output[0]) && ($output[0]=='select' OR $output[0]=='checklist')){
						$selectList = $column;
						$dataColumn   = $output[1]['data'];

						$output[0] .= '" data-source='.'"['.$dataColumn .']"';
						
						}
						if(!isset($output[0])){
						$output[0]= 'text';
						

						}	
						
						if (isset($row['id'])){
							$rowid = $row['id'];
						}else{
							$rowid = $row['Recid'];
							}


						 if ($count == 1){ 
							?>
						<td id="delete-<?= $rowid ?>" class="deleteRow"> <a href="/index.php?option=com_tbmg_reports&task=reportupdate.updateReport&format=json&databaseName=<?= $databaseName ?>&serverHost=<?= $serverHost ?>&tableName=<?= $tablename ?>'">Delete Row</a></td>
			<?php } ?>
			
						<td class="<?=$classaddition?>"id="<?= $column ?>-<?= $rowid ?>"><a href="#" data-type="<?=$output[0]?>" data-value='<?= $value ?>' data-url='/index.php?option=com_tbmg_reports&task=reportupdate.updateReport&format=json&databaseName=<?= $databaseName ?>&serverHost=<?= $serverHost ?>&tableName=<?= $tablename ?>'><?= $value ?></a></td>
					<?php else : ?>
						<td class="<?=$classaddition?>" ><?= $value ?></td>
					<?php endif ?>
					
				<?php $count = $count +1; endforeach; $count = 1;?>
			</tr>
		<?php endforeach; ?>
		</tbody>

	</table>
</div>


