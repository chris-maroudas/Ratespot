<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width"/>
	<title><?php echo $this->title ?> | RateSpot.gr | The absolute review community</title>
	<!-- Included CSS Files (Uncompressed) -->
	<!--
	  <link rel="stylesheet" href="stylesheets/foundation.css">
	  -->
	<!-- Included CSS Files (Compressed) -->
	<link rel="stylesheet" href="../../../../stylesheets/foundation.min.css">
	<link rel="stylesheet" href="../../../../stylesheets/screen.css">
	<!-- Typekit fonts !-->
	<script type="text/javascript" src="//use.typekit.net/ixd7wzq.js"></script>
	<script type="text/javascript">try {
		Typekit.load();
	} catch (e) {
	}</script>
	<script src="../../../../javascripts/modernizr.foundation.js"></script>
</head>
<body>

<div id="authenticationPanel">
	<div class="row">
	<ul class="eight columns offset-by-four">
		<li><strong><?php echo $data; ?></strong></li>
		<li><a href="/profile">my profile</a></li>
		<li><a href="/logout">logout</a></li>
		<li><a href="/postnew">post new</a></li>
 		<li><form id="searchBar" method="post" action="/search"><input type="search" name="search"/> <input type="submit" name="submit" value="search"></form></li>
	</ul>
	</div>
</div>