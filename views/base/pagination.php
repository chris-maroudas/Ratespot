<?php if ($leftLink[strlen($leftLink)-1] > 0) { ?>
<a href=<?php echo $leftLink; ?>><-</a>
<?php } ?>

<?php   $content = $this->errorHandler->errorMsg;
		if ($content != "No content found!") {
?>
<a href=<?php echo $rightLink; ?>>-></a>

<?php } ?>