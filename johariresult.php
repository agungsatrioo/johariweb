<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
        <meta property="og:title" content="ジョハリの窓 Web実行ツールで自己分析を行いました！"/>
		<meta property="og:description" content="あの人の分析結果を今すぐチェック！"/>
        <meta property="og:image" content="http://potect-a.com/wp-content/uploads/2015/03/johari_app.jpg"/>
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
						<button type="button" id="btnLink" class="btn btn-primary">診断はこちらから！</button>
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
			$("#btnLink").click(
			function(){
				location.href='http://potect-a.com/johari-app/';
			});
		}

		function showResult(){
			<?php
				$test_key = isset($_GET["test_key"])?$_GET["test_key"]:"";
				$member_key = isset($_GET["member_key"])?$_GET["member_key"]:"";
				if($test_key && $member_key):
			?>
			$.post(
				"process/result.php",
				{test_key: "<?php echo $test_key ?>", member_key: "<?php echo $member_key ?>"},
				function(data){
					var d = JSON.parse(data);
					if(d.error){
						showErrorMessage(d.error);
					}else{
						var johariWindows = [];
						johariWindows.push(getJohariWindows(d.players, d.myFeatures, d.yourFeatures, d.features));
						showJohariWindow(johariWindows, d.features, false);
					}
				}
			);
			<?php else: ?>
			showErrorMessage();
			<?php endif; ?>
		}

		function showErrorMessage(msg){
			if(!msg){
				msg = "エラーが発生しました。"
			}
			var result = $("#result");
			result.append("<h3>"+msg+"</h3>");
			result.append("<p>結果が表示できません。URLをもう一度お確かめください。</p>");		
		}

		$(document).ready(function(){
			initialize();
		});
	</script>
    </body>
</html>
