<div class="eight columns centered">


<h2>Register!</h2>
	<p class="error"><?php if (!empty($error)) { echo $error; } ?></p>

	<form method="post" action="/signup"> <!-- Self referencing form -->
		<label>
			Name <input type="text" name="name" required="required" placeholder="Your name" value="<?php if (!empty($name)) { echo $name;} ?>">
		</label>

		
		<label>
			E-mail <input type="email" name="email" required="required" placeholder="Your e-mail" value="<?php if (!empty($email)) { echo $email;} ?>">
		</label>


		<label>
			Password <input type="password" name="password" required="required" placeholder="Your password">
		</label>

		<input type="submit" name="submit" value="submit" />

	</form>

</div>
