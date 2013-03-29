</div>
<aside class="three columns">
	<div class="twelve columns">
		<h3>highest rated</h3>
		<ul>
			<?php for ($i = 0; $i < 10; $i++) { ?>
			<li><?php $var = "title" . $i;
			if (isset($$var)) {
				echo $$var;
			}
			$var = "rating" . $i;
			if (isset($$var)) {
				echo $$var; ?> / 10 <?php } ?>
			<?php $var = "title" . $i;
			if (isset($$var)) { ?>    <a href="/reviews/<?php  echo strtolower(urlencode( $$var));?>">Read
				it</a></li> <?php } ?>
			<?php } ?>
		</ul>
		<h3>latest articles</h3>
		<ul>
			<?php for ($i = 10; $i < 20; $i++) { ?>
			<li><?php $var = "title" . $i;
			if (isset($$var)) {
				echo $$var;
			} ?>
			<?php $var = "title" . $i;
			if (isset($$var)) { ?>    <a href="/articles/<?php  echo strtolower(urlencode($$var));?>">Read
				it</a></li> <?php } ?>
			<?php } ?>
		</ul>
	</div>
</aside>
</div> <!-- End of row -->