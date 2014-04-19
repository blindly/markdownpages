<?php
header("Content-Type: text/html; charset=utf-8");
session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
	<!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>MarkdownPages</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="css/main.css">

		<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>
	<body>

		<div class="container">
			<!--
			<div class="header">
			<h3 class="text-muted">MarkdownPages</h3>
			</div>
			-->

			<div class="row noprint">
				<div class="col-md-9 col-sm-7 col-xs-12">
					<div class="input-group">
						<input id="fld_search" type="text" class="form-control" data-bind="value: searchInput, valueUpdate: 'afterkeydown', disable: getEditMode() == true" autofocus>
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" data-bind="click: resetSearch, touchstart:resetSearch, disable: getEditMode() == true">
								<span class="glyphicon glyphicon-remove"></span>
							</button>
							<button class="btn btn-default" type="button" data-bind="click:doSearch, touchstart:doSearch, disable: getEditMode() == true">
								<span class="glyphicon glyphicon-play"></span>
							</button> 
						</span>
					</div>
				</div>
				
				<div class="col-md-3 col-sm-5 col-xs-12 noprint">
					<div class="pull-right">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-bind="visible: getEditMode() != true">
								Recent <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" data-bind="foreach: recentPagesArray, visible: recentPagesArray().length > 0">
								<li><a href="#" data-bind="click:$parent.viewPageByListEntry, text:pageName"></a></li>
							</ul>
						</div>
					
						<button id="" class="btn btn-default" type="button" data-bind="visible: getEditMode() != true, click:initModalBox" data-toggle="modal" data-target="#modalBox">
							New
						</button> 
					
					
						<button id="" class="btn btn-default" type="button" data-bind="visible: getEditMode() != true && searchResultArray().length <= 0, click:setEditMode, touchstart:setEditMode">
							Edit
						</button> 
						<button id="" class="btn btn-default" type="button" data-bind="visible: getEditMode() == true, click:setViewMode, touchstart:setViewMode">
							Cancel
						</button>
						<button id="" class="btn btn-default" type="button" data-bind="visible: getEditMode() == true, click:savePage, touchstart:savePage">
							Save
						</button> 
					</div>
				</div>
				
			</div>
			
			<div class="row">

				<div class="col-sm-12" data-bind="visible: searchResultArray().length > 0">
					<div>
						<span>&nbsp;</span>
					</div>

					<div class="list-group" data-bind="foreach: searchResultArray, visible: searchResultArray().length > 0">
						<a href="#" class="list-group-item" data-bind="click:$parent.viewPageByListEntry, text:pageName"></a>
					</div>

				</div>
				
				
				<div class="col-sm-12" data-bind="visible: getEditMode() != true && searchResultArray().length <= 0">
					<div data-bind="html:pageHTML">
					</div>
					<div class="highlight" data-bind="visible: attachmentsArray().length > 0">
						<i class="glyphicon glyphicon-file"></i> Attachments: 
						<div class="" data-bind="foreach: attachmentsArray">
							<a href="#"  data-bind="text: filename, attr: {href: path}" target="_new"></a>
						</div>
					</div>
					
				</div>
				
				
				<div class="col-sm-12 hidden" data-bind="css: { hidden: false }, visible: getEditMode() == true && searchResultArray().length <= 0">
					<div>
						<span>&nbsp;</span>
					</div>
					<textarea class="form-control md-editor" rows="20" data-bind="value:pageMarkup, valueUpdate: 'afterkeydown'"></textarea>
				</div>
				
			</div>


			<div class="row">
				<div class="col-md-12">
					<hr/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<span  data-bind="text: pageName, visible: searchResultArray().length <= 0," class="badge"></span>
					<span class="pull-right">&copy; unicate.ch</span>
				</div>
			</div>

			
			<!-- Modal -->
			<div class="modal fade" id="modalBox" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title">New Page</h4>
			      </div>
			      <div class="modal-body">
			        Create new Page:
			        <input id="fld_createPage" type="text" class="form-control" data-bind="value:createPageInput, valueUpdate: 'afterkeydown'" autofocus>
			       		<p class="text-center">
							<span data-bind="text: createPageInfo, css: {'text-success': createPageInfo() == 'Success', 'text-danger': createPageInfo() != 'Success'}"></span>
						</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn btn-primary" data-bind="click:newPage, touchstart:newPage">Create</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

		</div>
		<!-- /container -->

		<script src='js/vendor/knockout-3.0.0.js'></script>
		
		<script src="js/vendor/jquery-1.9.1.min.js"></script>

		<script src="js/vendor/bootstrap.min.js"></script>

		<script src="js/vendor/bootstrap3-typeahead.min.js"></script>

		<script src="js/helper.js"></script>
		<script src="js/service.js"></script>
		<script src="js/main.js"></script>
	</body>
</html>
