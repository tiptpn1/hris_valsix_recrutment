<!DOCTYPE html>
<html>

<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../docs.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>

<body>
	<div role="navigation" class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button><a href="#" class="navbar-brand">Lab</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="#tab-Overview" id="#btn-Overview">Overview</a></li>
				</ul>
			</div>
		</div>
	</div>
<!--
	<div class="container">
		<div class="jumbotron">
			<h1>jQuery MultiFile</h1>
			<p>Unobstrusive and downgradable plugin to select multiple files for upload</p>
		</div>
	</div>
-->
	<div class="container-fluid">

		<form action="test.php" method="post" enctype="multipart/form-data" target="upload-frame">
			<div class="row-fluid">
				<div class="col-md-4">
					<input name="files[]" type="file" multiple class="maxsize-1024" id="our-test" />
				</div>
				<div class="col-md-8">
					<input type="submit" value="Report Results"/>
					<br/>
					Files will never be uploaded. You can see the code <a href="">here</a>.
					<br/>
					<iframe id="upload-frame" name="upload-frame" src="about:blank" style="border:#ccc solid 1px; height:600px; width:100%;"></iframe>
				</div>
			</div>
		</form>
		<script>
// wait for document to load
$(function(){

	// invoke plugin
	$('#our-test').MultiFile({
		onFileChange: function(){
			console.log(this, arguments);
		}
	});

});
		</script>
	

<pre><code class="language-markup">&lt;form action=&quot;test.php&quot; method=&quot;post&quot; enctype=&quot;multipart/form-data&quot; target=&quot;upload-frame&quot;&gt;
	&lt;input type=&quot;submit&quot; value=&quot;Report&quot;/&gt; (will NEVER upload)
	&lt;br/&gt;
	&lt;input name=&quot;files[]&quot; type=&quot;file&quot; multiple=&quot;multiple&quot; class=&quot;multi maxsize-1024&quot; /&gt;
&lt;/form&gt;</code></pre>

  </div>

	<!--// plugin-specific resources //-->
	<script src='../jquery.MultiFile.js' type="text/javascript" language="javascript"></script>

</body>

</html>
