<?php

require_once '../include/config.inc.php';
require_once '../include/hosts.inc.php';
require_once '../include/actions.inc.php';
require_once '../include/items.inc.php';

include('config.php');

require_once 'lib/ZabbixApi.class.php';
use ZabbixApi\ZabbixApi;
$api = new ZabbixApi($zabURL.'api_jsonrpc.php', ''. $zabUser .'', ''. $zabPass .'');

$hostid = array();
$conta = array();

//$hostid = $_REQUEST['hostid'];

if(isset($_REQUEST['hostid'])) {
	
	$hostid = explode(",",$_REQUEST['hostid']);
	
	$period = $_REQUEST['period'];
	
	if(isset($period)) {
		$period = $_REQUEST['period'];
	}
	else {
		$period = 60;
	}
	
	$sep = implode(",",$hostid); 
	  
// get all graphs
/*
 $graphs = $api->graphGet(array(
     'output' => 'extend',
     'hostids' => $hostid,         
     'sortfield' => 'name',
	  'sortorder' => 'ASC'
 ));
 */
//https://zabbix.mpro.mp.br/zabbix/chart2.php?graphid=17101&from=2019-05-09+00%3A00%3A00&to=2019-05-28+00%3A00%3A00&profileIdx=web.graphs.filter&profileIdx2=17101&width=1720&_=tn9a35vt&screenid= 
 
}

else {
	echo '<script type="text/javascript">';
		echo 'history.back();';
	echo '</script>';
}

if(isset($_REQUEST['item'])) {
	//$item = "'search' => array('name' => '".$_REQUEST['item']."'),";
	$item = $_REQUEST['item'];
}
else {
	$item = '';
}	
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv='refresh' content='3000'>

<title>ZabGraphs - Host Graphs</title>

<link rel="icon" href="img/favicon.ico" type="image/x-icon" />
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/styles.css" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<!--<script type="text/javascript" src="js/jquery-ui-1.10.2.custom.min.js"></script>-->
<!--<script type="text/javascript" src="js/jquery-3.3.1.js"></script>-->
<script type="text/javascript" src="js/gallery.js"></script>

<!--<link rel="stylesheet" href="inc/datatables/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="inc/datatables/css/dataTables.bootstrap.min.css"> 
<script src="inc/datatables/js/jquery.dataTables.min.js"></script>
<script src="inc/datatables/js/dataTables.bootstrap.min.js"></script>

</head>
<body>

<div id="time" class="container col-md-11 col-sm-11" style="padding-top: 20px; float:none; margin-right:auto; margin-left:auto;">
	<span class="btn-group pull-left col-md-2 col-sm-2">
	  <button type="button" class="btn btn-primary" onclick="javascript:window.location='treeview.php';"><i class="fa fa-arrow-left"></i>&nbsp; <?php echo $labels['Back']; ?></button>
	</span> 
	<div class="row col-md-10 col-sm-10" id="buttons" style="margin-bottom:-60px;">
		<span class="btn-group pull-right">
			<button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=5m&hostid=<?php echo $sep;?>&item=<?php echo $item;?>";'>5m</button>
<!--			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=15m&hostid=<?php //echo $sep;?>&item=<?php //echo $item;?>";'>15m</button>-->
			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=30m&hostid=<?php echo $sep;?>&item=<?php echo $item;?>";'>30m</button>
			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=60m&hostid=<?php echo $sep;?>&item=<?php echo $item;?>";'>1h</button>
<!--			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=2h&hostid=<?php //echo $sep;?>&item=<?php //echo $item;?>";'>2h</button>-->
			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=6h&hostid=<?php echo $sep;?>&item=<?php echo $item;?>";'>6h</button>
			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=12h&hostid=<?php echo $sep;?>&item=<?php echo $item;?>";'>12h</button>
			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=1d&hostid=<?php echo $sep;?>&item=<?php echo $item;?>";'>1d</button>
<!--			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=3d&hostid=<?php //echo $sep;?>&item=<?php //echo $item;?>";'>3d</button>-->
			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=7d&hostid=<?php echo $sep;?>&item=<?php echo $item;?>";'>7d</button>
			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=30d&hostid=<?php echo $sep;?>&item=<?php echo $item;?>";'>1m</button>
<!--			  <button type="button" class="btn btn-primary" onclick='location.href="host_graphs.php?period=90d&hostid=<?php //echo $sep;?>&item=<?php //echo $item;?>";'>3m</button>-->
		</span>
	</div>
</div>

<div id="graphs" class="container col-md-11 col-sm-11" style="margin-top:10px; margin-bottom: 50px; float:none; margin-right:auto; margin-left:auto; text-align:center;">	
	
	<div class='row'>
		<?php		
		foreach( $hostid as $h ) {
		
			// get all graphs
			 $graphs = $api->graphGet(array(
			     'output' => 'extend',
			     'hostids' => $h,       
			     'search' => array('name' => $item),  
			     'sortfield' => 'name',
				  'sortorder' => 'ASC'
			));
			
			if(count($graphs) > 0) {
			
			//divide array em celulas
			if(count($graphs) > 1) {
				$rows = array_chunk($graphs,3);
				$conta = [1,2,3];			
			}
			else {
				$rows = array_chunk($graphs,1);
				$conta = [1];
			}
			//api com array_keys
			//$graphs = $api->graphGet(array(), 'name');
			
			echo "<h4 style='color:#000 !important; float:none; margin-right:auto; margin-left:auto; margin-bottom: 6px; margin-top:5px;' class='well'> ".get_hostname($h)."</h4>\n";
			
			?>
			<table id="" class="display table table-condensed table-hover" >
			<thead>
				<tr>
				<?php
					foreach($conta as $c) {
						echo "<th></th>\n"; 				
					}
				?>
				</tr>
			</thead>
			<tbody>
			<?php
			
			if(count($rows) > 1) {
				foreach ($rows as $row) {
								
					if(count($row) == 1) {
						array_push($row,'cp','cp');
					}
					if(count($row) == 2) {
						array_push($row,'cp');
					}			
					
					echo "<tr>\n";
					foreach($row as $g) {	
				
						echo "<td>\n";
						echo "<div class='thumb' style='padding: 5px !important; margin-bottom:0px;'>";
								if($g != 'cp') {								
									echo '<a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="" data-caption="" data-image="../chart2.php?graphid='.$g->graphid.'&from=now-'.$period.'&to=now&profileIdx=web.graphs.filter&profileIdx2='.$g->graphid.'&width=1200&height=320" alt="" data-target="#image-gallery">';
									echo '<img class="img-responsive ximg-thumbnail ximg-rounded" src="'.$zabURL.'chart2.php?graphid='.$g->graphid.'&from=now-'.$period.'&to=now&profileIdx=web.graphs.filter&profileIdx2='.$g->graphid.'&height=250" />';
								} else {
									echo '<a class="thumbnailx" href="#" data-image-id="" data-toggle="modal" data-title="" data-caption="" data-image="img/blank.png" alt="" data-target="#image-galleryx">';
									echo '<img class="img-responsive ximg-thumbnail ximg-rounded" src="img/blank.png" />';									
								}
							echo '</a>';
						echo "</div>\n";
						echo "</td>\n";		
					}	
					echo "</tr>\n";		
				}	
			}
			else {
				foreach ($rows as $row) {													
				echo "<tr>\n";
				foreach($row as $g) {	
			
					echo "<td>\n";
					echo "<div class='thumb' style='padding: 5px !important; margin-bottom:0px;'>";
						echo '<a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="" data-caption="" data-image="../chart2.php?graphid='.$g->graphid.'&from=now-'.$period.'&to=now&profileIdx=web.graphs.filter&profileIdx2='.$g->graphid.'&width=1200&height=320" alt="" data-target="#image-gallery">';
							echo '<img class="img-responsive ximg-thumbnail ximg-rounded" src="'.$zabURL.'chart2.php?graphid='.$g->graphid.'&from=now-'.$period.'&to=now&profileIdx=web.graphs.filter&profileIdx2='.$g->graphid.'&height=250" />';
						echo '</a>';
					echo "</div>\n";
					echo "</td>\n";		
				}	
				echo "</tr>\n";		
				}
			}
				echo "</tbody>\n";
				echo "</table>\n";
				//echo "</div>\n";
			} //end if graph > 0
		} //end foreach hostid
		?>

	</div>	
</div>

<!--modal-->
<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:1200px;">
        <div class="modal-content" style="width:1200px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="image-gallery-title"></h4>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive" src="">
            </div>
            <div class="modal-footer">

                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="show-previous-image"><?php echo $labels['Previous']; ?></button>
                </div>

                <div class="col-md-8 text-justify" id="image-gallery-caption">                    
                </div>

                <div class="col-md-2">
                    <button type="button" id="show-next-image" class="btn btn-default"><?php echo $labels['Next']; ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    $('table.display').DataTable( {
        "paging":   true,
        "ordering": false,
        "info":     true,
        "searching":   false,
      //  "scrollY":     '55vh',
      //  "scrollCollapse": true,
        "lengthMenu": [[3, 5, 10, 25, 50, -1], [3, 5, 10, 25, 50, "All"]],
        "dom": '<"top"<"clear">>rt<"bottom"iflp<"clear">>'
    } );
    //alert('oi');
} );
</script>

</body>
</html>