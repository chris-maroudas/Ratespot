<div class="eight columns centered">

<h4><?php if (isset($message)) { echo $message; } ?></h4>

<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

	Review<input type="radio" name="review" value="review">
Article<input type="radio" name="article" value="article">

	<label>
		Title (No special characters allowed)<input name = "title" type="text" value = "<?php if (isset($title)) {echo $title; } ?>" />
	</label>
	<label>
		Rating <input name = "rating" type="text" value = "<?php if (isset($rating)) { echo $rating; } ?>" />
	</label>
	<label>
		Image Name <input name = "imageName" type="text" value = "<?php if (isset($imageName)) { echo $imageName; } ?>" />
	</label>
	<label>
		Category <input name = "category" type="text" value = "<?php if (isset($category)) { echo $category; }?>" />
	</label>
	<label>
		Content <textarea name="content"> <?php if (isset($content)) { echo $content; } ?></textarea>
	</label>

	<input type="submit" name="submit"/>
</form>

</div>