<div class="eight columns centered">

	<h2>Log in</h2>
	<p class="error"><?php if (!empty($error)) { echo $error; } ?> </p>
	<form method="post" action="/login"> <!-- Self referencing form -->

		<label>
			E-mail <input type="email" name="email" required="required" placeholder="Your e-mail">
		</label>


		<label>
			Password <input type="password" name="password" required="required" placeholder="Your password">
		</label>

		<input type="submit" name="submit" value="submit" />

	</form>

</div>
