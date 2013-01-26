<?php
	require 'config.php';

	$dates = $sql->query("SELECT DISTINCT(DATE_FORMAT(dateadded,'%Y-%m-%d')) FROM rtmfanpages");
?>
<!DOCTYPE html>
<html>
<head>	
	<!--<meta http-equiv="refresh" content="60">-->
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css">
	<link rel='stylesheet' href='graph.css'>
	<link rel='stylesheet' href='detail.css'>
	<link rel='stylesheet' href='legend.css'>
	<link rel='stylesheet' href='extensions.css'>

	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js'></script>
	<script src='d3.v2.js'></script>
	<script src='rickshaw.min.js'></script>
	<script src='Rickshaw.Graph.Ajax.js'></script>
	<script src='Rickshaw.Graph.HoverDetail.js'></script>
	<script src='extensions.js'></script>
	<script src="graph.js"></script>
	<style>
		.rickshaw_graph .detail .x_label { display: none }
		.rickshaw_graph .detail .item { line-height: 1.4; padding: 0.5em }
		.detail_swatch { float: right; display: inline-block; width: 10px; height: 10px; margin: 0 4px 0 0 }
		.rickshaw_graph .detail .date { color: #a0a0a0 }
	</style>
</head>
<body>
<div id="content">
	<form id="side_panel">
		<h1>Facebook Data Graph</h1>
		<section><div id="legend"></div></section>
		<section>
			<div id="renderer_form" class="toggler">
				<input type="radio" name="renderer" id="area" value="area" checked>
				<label for="area">area</label>
				<input type="radio" name="renderer" id="bar" value="bar">
				<label for="bar">bar</label>
				<input type="radio" name="renderer" id="line" value="line">
				<label for="line">line</label>
				<input type="radio" name="renderer" id="scatter" value="scatterplot">
				<label for="scatter">scatter</label>
			</div>
		</section>
		<section>
			<div id="offset_form">
				<label for="stack">
					<input type="radio" name="offset" id="stack" value="zero" checked>
					<span>stack</span>
				</label>
				<label for="stream">
					<input type="radio" name="offset" id="stream" value="wiggle">
					<span>stream</span>
				</label>
				<label for="pct">
					<input type="radio" name="offset" id="pct" value="expand">
					<span>pct</span>
				</label>
				<label for="value">
					<input type="radio" name="offset" id="value" value="value">
					<span>value</span>
				</label>
			</div>
			<div id="interpolation_form">
				<label for="cardinal">
					<input type="radio" name="interpolation" id="cardinal" value="cardinal" checked>
					<span>cardinal</span>
				</label>
				<label for="linear">
					<input type="radio" name="interpolation" id="linear" value="linear">
					<span>linear</span>
				</label>
				<label for="step">
					<input type="radio" name="interpolation" id="step" value="step-after">
					<span>step</span>
				</label>
			</div>
		</section>
		<section>
			<h6>Smoothing</h6>
			<div id="smoother"></div>
		</section>
		<section>
			<h6>Choose Date</h6>
			<div id="date-chooser">
				<select name="date" id="date">
					<option value=''>Select Date</option>
					<?php while(list($date) = $dates->fetch_row()){
						echo '<option>'.$date.'</option>';
					}?>
				</select>
			</div>
		</section>
		<section>
			<div id="throbber"><img src="images/ajax-loader.gif"></div>
		</section>
	</form>

	<div id="chart_container">
		<div id="chart"></div>
		<div id="timeline"></div>
		<div id="slider"></div>
	</div>
</div>
</body>
</html>