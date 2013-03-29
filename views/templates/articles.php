<article>
	<h2><?php if (!empty($title)) { echo $title; } ?></h2>

	<p><?php if (!empty($date)) { echo $date; } ?> </p>

	<p><em>Posted under: </em><?php if (!empty($category)) { echo $category; } ?> </p>

	<img src="<?php if (!empty($imageName)) { echo $imageName; } ?>"/>

	<p><?php if (!empty($content)) { echo str_replace('&lt;br /&gt;', "</p> <p>", $content); } ?> </p>

	<p>Written by <em><?php if (!empty($author)) { echo $author; } ?> </em></p>


</article>

<!-- DISQUSS-->

<div id="disqus_thread"></div>
<script type="text/javascript">
	/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	var disqus_shortname = 'ratespot'; // required: replace example with your forum shortname

	/* * * DON'T EDIT BELOW THIS LINE * * */
	(function() {
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	})();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
