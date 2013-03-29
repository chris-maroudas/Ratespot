<div id="wrapper">
	<img src="../../images/ratespot.png"/>
</div>

<div class="grap">

	<nav class="row">
		<ul class="twelve columns toplevel">
			<li><a href="/home">home</a></li>
			<li><a href="/reviews">reviews</a>
				<ul class="sublevel">
					<li><a href="/reviews/category/gpu">Graphics</a></li>
					<li><a href="/reviews/category/cpu">Processors</a></li>
					<li><a href="/reviews/category/storage">Storage</a></li>
					<li><a href="/reviews/category/monitor">Monitors</a></li>
				</ul>
			</li>
			<li><a href="/articles">articles</a>
				<ul class="sublevel">
					<li><a href="/articles/category/technology">technology</a></li>
					<li><a href="/articles/category/tuning">Fine tuning</a></li>
					<li><a href="/articles/category/other">off topic</a></li>
				</ul>
			</li>
			<li><a href="/search">forum</a></li>
			<li><a href="/about">about</a></li>
		</ul>
	</nav>


<div class="row">

	<div id="featuredContentOne">

		<div data-caption="#captionOne">
			<img src="<?php if (isset($imageName0)) { echo $imageName0; } ?>" width="1200"/>
		</div>

		<div data-caption="#captionTwo">
			<img src="<?php if (isset($imageName1)) { echo $imageName1; } ?>" width="1200"/>
		</div>

		<div data-caption="#captionThree">
			<img src="<?php if (isset($imageName2)) { echo $imageName2; } ?>" width="1200"/>
		</div>
	</div>

	<span class="orbit-caption" id="captionOne"><h3><?php if (isset($title0)) { echo $title0; } ?></h3><p><?php if(isset($content0)) { echo str_replace('&lt;br /&gt;', "</p> <p>", $content0); } ?></p><a href="/articles/<?php if (isset($title0)) { echo strtolower(urlencode($title0));}  ?>">Read more</a></span>
	<span class="orbit-caption" id="captionTwo"><h3><?php if (isset($title1)) { echo $title1; } ?></h3><p><?php if(isset($content1)) { echo str_replace('&lt;br /&gt;', "</p> <p>", $content1); } ?></p><a href="/articles/<?php if (isset($title1)) { echo strtolower(urlencode($title1));}  ?>">Read more</a></span>
	<span class="orbit-caption" id="captionThree"><h3><?php if (isset($title2)) { echo $title2; } ?></h3><p><?php if(isset($content2)) { echo str_replace('&lt;br /&gt;', "</p> <p>", $content2); } ?></p><a href="/articles/<?php if (isset($title2)) { echo strtolower(urlencode($title2));}  ?>">Read more</a></span>

</div>


<div class="row">
	<div class="eight columns">

