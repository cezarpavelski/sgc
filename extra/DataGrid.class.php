<link rel="stylesheet" type="text/css" media="screen" href="extra/data_grid/themes/redmond/jquery-ui-1.7.1.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="extra/data_grid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="extra/data_grid/themes/ui.multiselect.css" />
<style>
html, body {
	margin: 0;			/* Remove body margin/padding */
	padding: 0;
	overflow: hidden;	/* Remove scroll bars on browser window */	
    font-size: 75%;
}
/*Splitter style */


#LeftPane {
	/* optional, initial splitbar position */
	overflow: auto;
}
/*
 * Right-side element of the splitter.
*/

#RightPane {
	padding: 2px;
	overflow: auto;
}
.ui-tabs-nav li {position: relative;}
.ui-tabs-selected a span {padding-right: 10px;}
.ui-tabs-close {display: none;position: absolute;top: 3px;right: 0px;z-index: 800;width: 16px;height: 14px;font-size: 10px; font-style: normal;cursor: pointer;}
.ui-tabs-selected .ui-tabs-close {display: block;}
.ui-layout-west .ui-jqgrid tr.jqgrow td { border-bottom: 0px none;}
.ui-datepicker {z-index:1200;}
</style>
<script src="extra/data_grid/js/ui.multiselect.js" type="text/javascript"></script>


<?php 
include("model/DAO.class.php");
class DataGrid extends DAO{
	
	public function gerarScript(){
		$script='';
		return $script;
	}
	
	public function gerarGrid(){
		$html='<table id="table1">
				<thead>';
		$html.='<tr>       
			      <th>Col 0</th>
			      <th>Col 1</th>
			      <th>Col 2</th>
			      <th>Col 3</th>
			    </tr>';
		$html.='</thead>
  				<tbody>';
		/*$html.='<tr>
			       <td>static col 1</td>
			       <td>static col 2</td>
			       <td>static col 3</td>
			       <td>static col 4</td>
			    </tr>
			    ';*/
		$html.='</tbody>
				  </table>';
		return $this->gerarScript().$html;
	}
}

?>