<article>

	<h2><?php if (isset($title)) { echo $title; } ?></h2>

	<p><em>Published at:</em> <strong><?php if (isset($date)) { echo $date; } ?> </strong>
		by <em><?php if (isset($author)) { echo $author; } ?> </em>
		<em> , under: </em><strong><?php if (isset($category)) { echo $category; } ?></strong>
	</p>
	<a class="commentsLink" href="/reviews/<?php if(isset($title)) {echo strtolower(urlencode( $title));} ?>#disqus_thread"></a>

	<img src="<?php if (isset($imageName)) { echo $imageName; } ?>"/>

	<p> <?php if(isset($content)) { echo substr(str_replace('&lt;br /&gt;', "</p> <p>", $content), 0, 500) . '...'; } ?> </p>

	<a class="readMore" href="/reviews/<?php if (isset($title)) { echo strtolower(urlencode($title));} ?>"> Read the whole article</a>

</article>