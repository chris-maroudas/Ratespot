<div class="nine columns">

<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

	<label>
		Title <input name = "title" type="text" value = "<?php echo $title; ?>" />
	</label>
	<label>
		Rating <input name = "rating" type="text" value = "<?php if (isset($rating)) {echo $rating; }?>" />
	</label>
	<label>
		Image Name <input name = "imageName" type="text" value = "<?php echo $imageName; ?>" />
	</label>
	<label>
		Author <input name = "author" type="text" value = "<?php echo $author; ?>" />
	</label>
	<label>
		Category <input name = "category" type="text" value = "<?php echo $category; ?>" />
	</label>
	<label>
		Content <textarea name="content"> <?php echo $content; ?></textarea>
	</label>

	<input type="submit" name="edit"/>
</form>

</div>