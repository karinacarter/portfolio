<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<div class="backRtoeports"><a href="/tbmg-intranet/reports"><< Back to Reports</a></div>
<?php 



$jinput = JFactory::getApplication()->input;
$tableHeader     = $jinput->get('tableHeader');
//var_dump($tableHeader);

echo "<table class='reportPage'>";
$count = 1;
//print_r($this->data);
foreach ($this->data as $row) {
	$headers=array_keys($row);
   $tableRows .= "
   <tr>";
   
   foreach ($row as $column) {
     $tableRows .= "<td>$column</td>
     ";
     

   	
   }
     
      
   
   $tableRows .=  "</tr>";
}  

print "<th colspan ='".count($headers)."' class='tableHeaders'>".$tableHeader."</th></tr>";


 foreach ($headers as $headerText) {
     $headerRow .= "<th>$headerText</th>";
     

   	
   	
   	
   	
   }
   
   $headerRow .="</tr>";
   echo $headerRow;
   echo  $tableRows;
echo "</table>";

//print_r($headers);
	

	
	
	
	
?>