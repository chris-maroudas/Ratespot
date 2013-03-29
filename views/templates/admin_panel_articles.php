<article>

	<h2><?php if (isset($title)) { echo $title; } ?></h2>

	<p><em>Published at:</em> <strong><?php if (isset($date)) { echo $date; } ?> </strong>
		by <em><?php if (isset($author)) { echo $author; } ?> </em>
		<em> , under: </em><strong><?php if (isset($category)) { echo $category; } ?></strong>
	</p>
	<a class="commentsLink" href="/articles/<?php if(isset($title)) {echo strtolower(urlencode($title));} ?>#disqus_thread"></a>

	<img src="<?php if (isset($imageName)) { echo $imageName; } ?>"/>

		<p><?php if (!empty($content)) { echo str_replace('&lt;br /&gt;', " </p> <p>", $content); } ?> </p>



	<?php if (isset($approved)) { if($approved == 1 ){
		?> <a href="#" class="success">Already approved!</a> |<?php
	} else { ?>
	<a href="/admin/articles/approve/<?php if (!empty($id)) { echo $id; }?>">Approve article</a> |

	<?php } }?>

	<a href="/admin/articles/delete/<?php if (!empty($id)) { echo $id; }?>">Delete review</a> |

	<a href="/admin/articles/edit/<?php if (!empty($id)) { echo $id; }?>">Edit review</a>

</article>