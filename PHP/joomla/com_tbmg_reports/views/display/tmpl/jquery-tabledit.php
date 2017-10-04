<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
$doc->addScript("/media/jui/js/jquery.min.js");
//$doc->addScript("components/com_tbmg_reports/views/display/tmpl/assets/javascript/jquery.tablesorter.js");
//$doc->addScript("components/com_tbmg_reports/views/display/tmpl/assets/javascript/persistentHeader.js");
//$doc->addScript("components/com_tbmg_reports/views/display/tmpl/assets/javascript/tbmg.js");

JHtmlBootstrap::framework();
JHtmlBootstrap::loadCss();

JHtml::stylesheet('com_tbmg_reports/jquery-tabledit.css', [], true);
JHtml::script('com_tbmg_reports/jquery.tabledit.js', false, true);

$jinput      = JFactory::getApplication()->input;
$tableHeader = $jinput->get('tableHeader', '', 'raw');

$available_fields = [
	'TopBanner', 'TopSponsor', 'Banner2', 'Banner3', 'Sponsor2', 'Sponsor3',
];
for ($i = 1; $i <= 12; $i++) {
	$available_fields[] = 'Position_' . $i;
}

$headers = array_keys($this->data[0]);
$columns = count($headers);

$trclass = '';
if (isset($this->data[0]['Edition'])) {
	$trclass = 'edition-' . preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(html_entity_decode($row['Edition'])));
}
?>

<div class="backRtoeports"><a href="/tbmg-intranet/reports"><< Back to Reports</a></div>

<div class="table-responsive">
	<table class='table table-striped table-bordered user-select-none' id="tbmg-tabledit-table">

		<thead>
		<tr>
			<td colspan='<?= $columns ?>' class='tableHeaders rowHeader'><?= $tableHeader ?></td>
		</tr>
		</thead>
		
		<?php foreach ($headers as $headerText) :
			$headerText = str_replace('_', ' ', $headerText);
			$headerText = preg_replace('/(?<!\ -)[A-Z]/', ' $0', $headerText);
			$headerText = trim($headerText);
			?>
			<th class='header-<?= $headerText ?>'><?= $headerText ?></th>
		<?php endforeach; ?>

		<tbody>
		<?php foreach ($this->data as $row) : ?>
			<tr class='<?= $trclass ?>'>
				<?php foreach ($row as $column => $value) : ?>
					<?php if ($column == 'TransmissionDate' || $column == 'date') : ?>
						<?php $value = date('F d', strtotime($value)) ?>
					<?php elseif (empty($value) && in_array($value, $available_fields)) : ?>
						<?php $value = "AVAILABLE"; ?>
					<?php elseif (empty($value)) : ?>
						<?php $value = "AVAILABLE"; ?>
					<?php endif ?>
					<td class="tabledit-view-mode" style="cursor: pointer;"
					><span class="tabledit-span" style="display: inline;"><?= $value ?></span><input
								class="tabledit-input form-control input-sm" type="text" value="<?= $value ?>"
								style="display: none;" disabled=""></td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
		</tbody>

	</table>
</div>

<script type="text/javascript">
	(function ($) {
		$(document).ready(function () {
			$('#tbmg-tabledit-table').Tabledit({
				url: '/index.php?option=com_tbmg_reports&controller=tabledit&format=json',
				eventType: 'dblclick',
				editButton: false,
				deleteButton: false,
				hideIdentifier: true,
				columns: {
					identifier: [0, 'id'],
					editable: [
						<?php $colid = 0; ?>
						<?php foreach ($this->data[0] as $column => $value) : ?>
						<?php if ($colid == 0) : $colid = 1;
						continue; endif ?>
						[<?= $colid++ ?>, '<?= $column ?>'],
						<?php endforeach; ?>
					]
				}
			});
		});
	})(jQuery);
</script>
