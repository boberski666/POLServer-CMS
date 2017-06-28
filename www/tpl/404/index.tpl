<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>404 Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="/css/404.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="main">
		<!-- header -->
		<div id="header">
			<h1>No pages here as you see!<span>404 error - not found.</span></h1>
		</div>
		<!-- content -->
		<div id="content">
			<ul class="nav">
         	<li class="home"><a href="http://hell-yeah.eu/" rel="nofollow">Home Page</a></li>
         </ul>
         <p>Unless creepy emptiness was what you were looking for, this place has nothing that you want.</p>
		</div>
		<!-- footer -->
		<div id="footer">
      	{$smarty.const.SITE_NAME} - site <a href="{$smarty.const.DOMAIN}" target="_blank" rel="nofollow">here</a>!
      </div>
	</div>
{if isset($debug) && $debug == true}
	{include file='../sys/debug.tpl'}
{/if}
</body>
</html>