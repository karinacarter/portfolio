<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
$doc->addScript("/media/jui/js/jquery.min.js");
$doc->addScript("components/com_tbmg_reports/views/display/tmpl/assets/javascript/jquery.tablesorter.js");
$doc->addScript("components/com_tbmg_reports/views/display/tmpl/assets/javascript/persistentHeader.js");
$doc->addScript("components/com_tbmg_reports/views/display/tmpl/assets/javascript/tbmg.js");

?>

<div class="backRtoeports"><a href="/tbmg-intranet/reports"><< Back to Reports</a></div>


<?php 



$jinput = JFactory::getApplication()->input;
$tableHeader     = $jinput->get('tableHeader', '', 'raw');
//$jinput->get('rows', 'ALL', 'raw');
//var_dump($tableHeader);

print "<table class='reportPage persistentHeader tablesorter'>";

$count = 1;
$tableRows ='';
$headerRow ='';
foreach ($this->data as $row) {
	$headers=array_keys($row);
	//Add edition as a class to the TR
	if (isset($row['Edition'])){
		//$trclass = '$trclass'
		$trclass='edition-' . preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(html_entity_decode($row['Edition'])));
	} else{
		$trclass ='';
	}
	
	// Reformat depending on what report/element is being displaied
	
	if (isset($row['TransmissionDate']) AND isset($row['TransmissionDate'])){
		//$trclass = '$trclass'
		$row['TransmissionDate'] = date('F d', strtotime($row['TransmissionDate']));
	}
	if (isset($row['date'])AND isset($row['date'])){
		//$trclass = '$trclass'
		$row['date'] = date('F d', strtotime($row['date']));
	}
	
	
	// Some Specific Rows need to show available if it's empty. 
	if (empty($row['TopBanner']) AND isset($row['TopBanner']) ){
		$row['TopBanner'] = '<span class="red">AVAILABLE</span>';
	}
	if (empty($row['TopSponsor']) AND isset($row['TopSponsor'])){
		$row['TopSponsor'] = '<span class="red">AVAILABLE</span>';
	}
	if (empty($row['Banner2']) AND isset($row['Banner2'])){
		$row['Banner2'] = '<span class="red">AVAILABLE</span>';
	}
	if (empty($row['Banner3']) AND isset($row['Banner3'])){
		$row['Banner3'] = '<span class="red">AVAILABLE</span>';
	}
	if (empty($row['Sponsor3']) AND isset($row['Sponsor3'])){
		$row['Sponsor3'] = '<span class="red">AVAILABLE</span>';
	}
	if (empty($row['Sponsor2']) AND isset($row['Sponsor2'])){
		$row['Sponsor2'] = '<span class="red">AVAILABLE</span>';
	}
	
	// Loop through the 12 positions and display The Vendor if they aren't avaiable. Or show AVAILABLE if open. 
	for ($i = 1; $i <= 12; $i++) {
	    if (empty($row['Position_'.$i]) AND isset($row['Position_'.$i])){
			//$trclass = '$trclass'
			$row['Position_'.$i] = '<span class="red">AVAILABLE</span>';
		}
	}

		
   $tableRows .= "
   
   <tr class='$trclass' >";
   
   foreach ($row as $column) {
	  
     $tableRows .= "<td>$column</td>
     ";
   }
   $tableRows .=  "</tr>";
}  
// Display the column Headers
print "<thead><tr><td colspan ='".count($headers)."' class='tableHeaders rowHeader'>".$tableHeader."</td></tr>";


 foreach ($headers as $headerText) {
	$headerText = str_replace( '_', ' ', $headerText );
	$headerText = preg_replace('/(?<!\ -)[A-Z]/', ' $0', $headerText);
	$headerText = trim($headerText);

     $headerRow .= "<th class='header-$headerText'>$headerText</th>";
   }

   $headerRow .="</tr></thead>";
   // Display each Row in the database
   print $headerRow;
   print "<tbody>";
   print  $tableRows;
   print "<tbody></table>";
	
?>