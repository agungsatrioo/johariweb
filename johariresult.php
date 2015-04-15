<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
        <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="/static/bootflat/css/bootflat.min.css" rel="stylesheet" />
        <link href="/static/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="/static/sweetalert-master/lib/sweet-alert.css" rel="stylesheet" />
        <link href="lib/site.css" rel="stylesheet" />
        <title>ジョハリの窓</title>
    </head>
    <body>
    <div class="docs-header">
    	<div class="inner-box">
    		<span><img src="http://potect-a.com/wp-content/uploads/2013/11/logo.gif" alt="自己分析診断テスト「ポテクト」" /></span>
    	</div>
    	<nav class="navbar navbar-default navbar-custom" role="navigation">
    		<div class="container">
    		</div>
    	</nav>
    </div>
	<div class="container">
		<div class="jumbotron">
			<div class="jumbotron-contents">
				<h1>ジョハリの窓 Web実行ツール</h1>
				<hr/>
				<div class="row">
					<div name="conResult" class="jumbotron-contents">
						<h2>診断結果</h2>
						<div style='page-break-after:always'></div><!-- page break for printout -->
						<div id="result">
						<!-- final result is shown here -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="site-footer">
		<div class="container">
			<p>© 2015 Kazunori Hashikuchi All rights reserved.</p>
		</div>
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery.js"></script>
	<script type="text/javascript" src="/static/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/static/bootflat/js/icheck.min.js"></script>
	<script type="text/javascript" src="/static/bootflat/js/jquery.fs.selecter.min.js"></script>
	<script type="text/javascript" src="/static/bootflat/js/jquery.fs.stepper.min.js"></script>
	<script type="text/javascript" src="/static/selecter/jquery.fs.selecter.min.js"></script>
	<script type="text/javascript" src="/static/bootstrap-select/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="/static/sweetalert-master/lib/sweet-alert.min.js"></script>
	<script type="text/javascript" src="lib/site.js"></script>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '802789449809942',
	      xfbml      : true,
	      version    : 'v2.3'
	    });
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
	<script>
		var players, currentPlayer, myFeatures, yourFeatures, features;
 		function initialize(){
			// reset elements
			showResult();
		}

		function showResult(){
			<?php
				$key = isset($_GET["key"])?$_GET["key"]:"";
				if($key):
			?>
			$.post(
				"process/result.php",
				{key: "<?php echo $key ?>"},
				function(data){
					var d = JSON.parse(data);
					if(d.error){
						showErrorMessage();				
					}else{
						var johariWindows = getJohariWindows(d.players, d.myFeatures, d.yourFeatures, d.features);
						showJohariWindow(johariWindows, d.features);
					}
				}
			);
			<?php else: ?>
			showErrorMessage();
			<?php endif; ?>
		}

		function showErrorMessage(){
			var result = $("#result");
			result.append("<h3>URLに誤りがあります。</h3>");
			result.append("<p>結果が表示できません。URLをもう一度お確かめください。</p>");		
		}

		$(document).ready(function(){
			initialize();
		});
	</script>
    </body>
</html>
