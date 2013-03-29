<?php

class Router
{
	private $routes;

	function __construct()
	{
		$this->routes = array(
			"home" => "indexPage",
			"reviews" => "reviewsDisplay",
			"articles" => "articlesDisplay",
			"signup" => "signUp",
			"login" => "logIn",
			"logout" => "logOut",
			"profile" => "myProfile",
			"categories" => "categories",
			"admin" => "adminPanel",
			"postnew" => "postNewReview",
			"search" => "searchReview",
			"about" => "about",
			"success" => "success"
		);
	}

	public function lookup($query)
	{
		if (array_key_exists($query, $this->routes)) {
			return $this->routes[$query]; /* If the array key exists, return me the current value */
		}
		else {
			return FALSE;
		}
	}
}

