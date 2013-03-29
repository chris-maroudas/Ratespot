<?php
require_once("app/constants.php");
require_once("app/model.php");
require_once("app/router.php");
require_once("app/session_handler.php");
require_once("app/error_handler.php");
error_reporting(E_ALL);

class Controller
{
	public $user;

	function __construct()
	{
		/* Initializing private variables/objects */
		$this->model = new Model();
		$this->router = new Router();
		$this->session = new Session();
		$this->errorHandler = new ErrorHandler();

		$this->user = $this->session->user;

		$page = $this->proccessPageString();    // Get page from URL
		$urlParams = $this->proccessQueryString();  // Get the url parameters from URL

		// Handle page load
		$endpoint = $this->router->lookup($page);
		if ($endpoint == FALSE) {
			$this->redirectTo("/404.html");
		} else {
			$this->$endpoint($urlParams); /* endpoint will be the function returned by router */
		}
	}


	/* GENERAL USAGE METHODS */

	private function proccessPageString()
	{
		$page = FALSE;
		if (isset($_GET['page']) && is_string($_GET['page'])) {
			$page = $_GET['page'];
		}
		return $page;
	}

	private function proccessQueryString()
	{
		$urlParams = FALSE;
		if (strlen($_GET['query']) > 0) {
			$urlParams = explode("/", $_GET['query']);
		}
		return $urlParams;
	}


	private function loadPage($view, $data = NULL)
	{
		if (isset($this->user) && is_string($this->user) && !empty($this->user)) {
			$this->loadView("control_bar", $this->user); // If a user is logged in,
		} else {
			$this->loadView("login_bar");
		}

		if ($view == "front_page") {
			$sliderData = $this->getSliderData(); // Get the last 3 articles
			$this->loadView("front_header", $sliderData);
		} elseif ($view == "admin_panel_reviews" || $view == "admin_panel_articles") {
			$this->loadView("admin_header");
		} else {
			$this->loadView("header");
		}

		if (!empty($this->errorHandler->errorMsg)) {
			$this->loadView("display_error", Array("error" => $this->errorHandler->errorMsg));
		} elseif (!empty($this->errorHandler->successMsg)) {
			$this->loadView("display_success", Array("msg" => $this->errorHandler->successMsg));
		}

		$this->loadView($view, $data, $template = TRUE); /* Content */

		$sidebarData = $this->getSidebarData();
		$this->loadView("sidebar", $sidebarData); /* Sidebar */

		$this->loadView("footer"); /* Footer */
	}


	private function loadView($view, $data = NULL, $template = FALSE)
	{
		$files = array_merge(scandir('views/templates'), scandir('views/base'));
		$view = $view . '.php';
		if (in_array($view, $files)) { // If the view file exist in the view files directory

			if (is_array($data)) {
				if (is_array(reset($data))) { // If the first element of an array is an array (like frontPage f.e.)
					for ($i = 0; $i < count($data); $i++) {
						$data[$i] = array_map("htmlspecialchars", $data[$i]); // XSS escaping
						$this->requireView($view, $data[$i], $template);
					}
				} else {
					$data = array_map("htmlspecialchars", $data); // XSS escaping
					extract($data);
					$this->requireView($view, $data, $template);
				}
			} else if (is_int($data) || is_string($data) || is_null($data)) {
				$data = htmlspecialchars($data);
				$this->requireView($view, $data, $template);
			}
		}
	}

	private function requireView($name, $data = [], $template = FALSE)
	{
		if (is_array($data)) {
			extract($data);
		}
		if ($template == FALSE) {
			require("views/base/" . $name);
		} elseif ($template == TRUE) {
			require("views/templates/" . $name);
		}
	}


	// Method for hashing our passwords safely
	private function blowfishCrypt($password, $cost)
	{
		$chars = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$salt = sprintf('$2y$%02d$', $cost);
		//Create a 22 character salt
		mt_srand();
		for ($i = 0; $i < 22; $i++) $salt .= $chars[mt_rand(0, 63)];

		return array("password" => crypt($password, $salt),
		             "salt"     => $salt
		); // Return the hashed password, and the salt used
	}

	// Method for avoiding handling the POST requests locally
	private function getPostParameter($queryParameter, $validateRegexp = LREGEXPRULES)
	{
		if (array_key_exists($queryParameter, $_POST)) {
			if (preg_match($validateRegexp, $_POST[$queryParameter]) && !empty($_POST[$queryParameter])) {
				return trim(nl2br($_POST[$queryParameter]));
			}
		}

		return FALSE;
	}

	/* POST variables need to: 1) Exist in the $_POST array,
							   2) Match the regular expression
							   3) Don't be empty     */


	/* This function method gets the latest 3 articles from model, and prepares them to serve them to slider template */
	private function getSliderData()
	{
		$queryParam = Array("approved" => 1);
		$data = $this->model->select("articles", $queryParam);

		for ($i = 0; $i < 3; $i++) {

			extract($data[$i]);
			$sliderData['title' . $i] = $title;
			$sliderData['content' . $i] = substr($content, 0, 220) . "..";
			$sliderData['imageName' . $i] = $imageName;
			$sliderData['id' . $i] = $id;

		}

		if (is_array($sliderData)) {
			return $sliderData;
		} else {
			return FALSE;
		}
	}


	private function getSidebarData()
	{
		$limit = 10; // Top 10 reviews, latest 10 articles

		$queryParams = Array("approved" => 1);
		$data = $this->model->sidebarData("reviews", $queryParams);
		for ($i = 0; $i < $limit; $i++) {
			if (isset($data[$i]) && is_array($data[$i])) {
				extract($data[$i]);
				$sidebarData['title' . $i] = $title;
				$sidebarData['id' . $i] = $id;
				$sidebarData['rating' . $i] = $rating;
			}
		}

		$queryParams = Array("approved" => 1);
		$data = $this->model->sidebarData("articles", $queryParams);
		for ($i = 0; $i < $limit; $i++) {
			if (isset($data[$i]) && is_array($data[$i])) {
				extract($data[$i]);
				$sidebarData['title' . ($i + 10)] = $title;
				$sidebarData['id' . ($i + 10)] = $id;
			}
		}

		if (is_array($sidebarData)) {
			return $sidebarData;
		} else {
			return FALSE;
		}

	}

	private function checkForErrors($data)
	{
		if (empty($data)) {
			$this->errorHandler->setErrorMsg("No content found!");
		}
	}

	private function redirectTo($url, $time = FALSE)
	{
		if ($time == FALSE) {
			header("Location: " . $url);
		} elseif (is_int($time)) {
			header("refresh:" . $time . ";url=" . $url);
		}
	}


	/* ================================================================================== */


	/* PAGES functions */

	private function indexPage()
	{
		$queryParams = Array("approved" => 1);
		$data = $this->model->select('reviews', $queryParams, 10);
		$this->checkForErrors($data);
		$this->loadPage("front_page", $data);
	}

	// Called for a specific article, and a title is also given
	private function reviewsDisplay($urlParams)
	{
		if ($urlParams != FALSE) {
			if ($urlParams[0] == 'category' && !empty($urlParams[1])) /*  /reviews/category/gpu   */ {
				$queryParams = Array("category" => $urlParams[1],
				                     "approved" => 1);
				$page = "reviews_categories_specific";

			} else { // Specific review was requested
				$queryParams = array('title'    => urldecode($urlParams[0]),
				                     "approved" => 1);
				$page = "reviews";
			}
		} else { // user pressed on review button
			$queryParams = Array("approved" => 1);
			$page = "reviews_categories_generic";
		}

		$data = $this->model->select('reviews', $queryParams);
		$this->checkForErrors($data);
		$this->loadPage($page, $data);
	}


	private function articlesDisplay($urlParams)
	{
		if ($urlParams != FALSE) {
			if ($urlParams[0] == 'category' && !empty($urlParams[1])) /*  /reviews/category/gpu   */ {

				$queryParams = Array("category" => $urlParams[1],
				                     "approved" => 1);
				$page = "articles_categories_specific";
			} else { // Specific article was requested

				$queryParams = Array('title'    => urldecode($urlParams[0]),
				                     "approved" => 1);
				$page = "articles";
			}
		} else { // user pressed on articles button
			$queryParams = Array("approved" => 1);
			$page = "articles_categories_generic";
		}

		$data = $this->model->select('articles', $queryParams);
		$this->checkForErrors($data);
		$this->loadPage($page, $data);
	}


	private function signUp($urlParams)
	{
		if ($this->getPostParameter('submit')) // If a form is submitted
		{
			if ($this->getPostParameter('name', SREGEXPRULES) && $this->getPostParameter('email', SREGEXPRULES) && $this->getPostParameter('password', SREGEXPRULES)) {

				$cryptResult = $this->blowfishCrypt($this->getPostParameter('password'), 12); // Hashing the password

				$queryParams = Array("name"     => $this->getPostParameter('name'),
				                     "email"    => $this->getPostParameter('email'),
				                     "password" => $cryptResult['password'], // Hashing passwords before storing them into database.
				                     "salt"     => $cryptResult['salt'] // Hashing passwords before storing them into database.
				);

				$queryResult = $this->model->insert("users", $queryParams); // escaping happens inside model, automatically by PDO statements
				if ($queryResult) {
					$this->session->destruct(); // A logged in user cannot be signing up
					$this->redirectTo('/success');
				}
			} else {
				// Some troubleshooting to create sticky forms, storing the current filled values in an array in $data
				// STICKY FORMS
				if ($this->getPostParameter('name', SREGEXPRULES)) {
					$data = Array("name" => $this->getPostParameter('name', SREGEXPRULES));
					$this->errorHandler->setErrorMsg("Invalid email or password. Please check the rules");
				} elseif ($this->getPostParameter('email', SREGEXPRULES)) {
					$data = Array("email" => $this->getPostParameter('email', SREGEXPRULES));
					$this->errorHandler->setErrorMsg("Invalid user name or password. Please check the rules");
				}

				$this->loadPage("sign_up", $data); // Take us to sign up again
			}
		} else { // If for first time
			$this->loadPage("sign_up");
		}
	}

	// If the user is authenticated then it goes to myProfile page. If not it shows the log in form
	private function logIn($urlParams)
	{
		if ($this->session->authenticated == FALSE) { // If the user is NOT already logged in
			if ($this->getPostParameter('submit')) // If a form is submitted
			{
				if ($this->getPostParameter('email', SREGEXPRULES) && $this->getPostParameter('password', SREGEXPRULES)) {

					$queryParams = Array("email"    => $this->getPostParameter('email'),
					                     "password" => $this->getPostParameter('password'));
					$result = $this->model->checkUser($queryParams); // Create the checkout. When user tries to log in, we hash the password and compare it to hash stored into the database
					if (!empty($result) && is_array($result)) { // If a result is returned
						$this->session->setUser($result['name']);
						$this->session->setUserId($result['id']);
						$this->session->setAuthenticated(TRUE);
						$this->session->setCreated(time());
						$this->redirectTo('/home');
					} else { // If the model didn't find a match
						$this->errorHandler->setErrorMsg("Wrong user name or password combination");
						$this->loadPage("log_in");
					}
				} else { // If data failed to pass the POST test
					$this->errorHandler->setErrorMsg("Only English characters allowed!");
					$this->loadPage("log_in");
				}
			} else { // If for first time
				$this->loadPage("log_in");
			}
		} else { // if the user is already logged in
			$this->redirectTo("/profile");
		}
	}

	private function logOut($queryParams)
	{
		if (!empty($this->session->user) || !empty($this->session->admin)) { // If a user or the admin is logged in
			$this->session->destruct();
			$this->redirectTo("/home");
		} else { // Redirect to log In screen. User needs to log in first.
			$this->redirectTo("/login");
		}
	}

	private function myProfile($queryParams)
	{
		if ($this->session->authenticated == TRUE) { // If user is authenticated
			$queryParams = Array("authorId" => $this->session->userId); // Load me all the reviews with his userID
			$data = $this->model->select('reviews', $queryParams);
			$this->checkForErrors($data);
			$this->loadPage("my_profile", $data);
		} else {
			$this->redirectTo("/login"); // If he isn't, redirect him to home
		}
	}

	private function adminPanel($urlParams)
	{
		if ($this->session->admin == FALSE) { // if the admin is not logged in, display him the form
			if ($this->getPostParameter('submit')) { // if a form is submited
				if ($this->getPostParameter('email', SREGEXPRULES) && $this->getPostParameter('password', SREGEXPRULES)) {
					if ($this->getPostParameter('email') == ADMINEMAIL && $this->getPostParameter('password') == ADMINPASS) {
						$this->session->setAdmin(TRUE);
						$this->redirectTo("/admin/reviews"); // Reload the page, so we can show him the control panel
					} else {
						$this->errorHandler->setErrorMsg("Wrong email and password combination");
						$this->loadPage("admin_login"); // Display the view with an error msg
					}
				} else {
					$this->errorHandler->setErrorMsg("Only English characters allowed!");
					$this->loadPage("admin_login"); // Display the view with an error msg
				}
			} else { // If he hasn't POSTed any form yet
				$this->loadPage("admin_login");
			}
		} elseif ($this->session->admin == TRUE) { // Admin already logged in

			if ($urlParams == FALSE) {
				$this->redirectTo("/admin/reviews");
			}


			if ($urlParams[0] == 'reviews') { // If a request for approve or delete was NOT given, display the list of the non-approved articles

				if (!isset($urlParams[1])) {
					$data = $this->model->select('reviews');
					$this->loadPage("admin_panel_reviews", $data);

				} elseif ($urlParams[1] == "approve") {
					$queryParams = array('approved' => 1,
					                     'id'       => $urlParams[2]
					);
					$result = $this->model->update('reviews', $queryParams);
					$this->redirectTo("/admin/reviews");

				} elseif ($urlParams[1] == "delete") {
					$queryParams = array('id' => $urlParams[2]);
					$result = $this->model->remove('reviews', $queryParams);
					$this->redirectTo("/admin/reviews");

				} elseif ($urlParams[1] == "edit") { // If the admin wants to edit the post, we redirect him at the postNew page, and sticky form the

					if (!$this->getPostParameter('edit')) { // If an edit request was not posted, display the form
						$queryParams = Array('id' => $urlParams[2]);
						$data = $this->model->select('reviews', $queryParams);
						$this->loadPage('edit_review', $data); // Show the sticky review form

					} else { // This means admin did an edit and POSTed it
						$temp = Array('title', 'rating', 'imageName', 'author', 'content', 'category');
						for ($i = 0; $i < count($temp); $i++) {
							$queryParams = Array($temp[$i] => $this->getPostParameter($temp[$i]),
							                     'id'      => $urlParams[2]
							);
							$this->model->update('reviews', $queryParams); // Run an update query for each of these POST values. We can't ran the whole query with one big array, because our update method supports only one UPDATE value, the rest are WHERE
						}
						$this->redirectTo("/admin/reviews");
					}
				}

			} else if ($urlParams[0] == 'articles') { // If a request for approve or delete was NOT given, display the list of the non-approved articles

				if (!isset($urlParams[1])) {
					$data = $this->model->select('articles');
					$this->loadPage("admin_panel_articles", $data);

				} elseif ($urlParams[1] == "approve") {
					$queryParams = array('approved' => 1,
					                     'id'       => $urlParams[2]
					);
					$result = $this->model->update('articles', $queryParams);
					$this->redirectTo("/admin/articles");

				} elseif ($urlParams[1] == "delete") {
					$queryParams = array('id' => $urlParams[2]);
					$result = $this->model->remove('articles', $queryParams);
					$this->redirectTo("/admin/articles");

				} elseif ($urlParams[1] == "edit") { // If the admin wants to edit the post, we redirect him at the postNew page, and sticky form the

					if (!$this->getPostParameter('edit')) { // If an edit request was not posted, display the form
						$queryParams = Array('id' => $urlParams[2]);
						$data = $this->model->select('articles', $queryParams);
						$this->loadPage('edit_review', $data); // Show the sticky review form

					} else { // This means admin did an edit and POSTed it
						$temp = Array('title', 'imageName', 'author', 'content', 'category');
						for ($i = 0; $i < count($temp); $i++) {
							$queryParams = Array($temp[$i] => $this->getPostParameter($temp[$i]),
							                     'id'      => $urlParams[2]
							);
							$this->model->update('articles', $queryParams); // Run an update query for each of these POST values. We can't ran the whole query with one big array, because our update method supports only one UPDATE value, the rest are WHERE
						}
						$this->redirectTo("/admin/articles");
					}
				}
			}
		}
	}


	private function postNewReview($urlParams)
	{
		if ($this->session->authenticated == TRUE) { // If the user is logged in
			if ($this->getPostParameter('submit')) { // If a review is posted

				// If review was posted
				if ($this->getPostParameter('review')) {

					if ($this->getPostParameter('title') && $this->getPostParameter('category') && $this->getPostParameter('imageName') && $this->getPostParameter('content') && $this->getPostParameter('rating')) {
						// Insert to database

						$queryParams = Array('title'     => strtolower($this->getPostParameter('title', TREGEXPRULES)), // Title is used in the URL, and even though our DB is registered as Case Insensitive, I want to play it safe. So the entry data is only lowercase letters, numbers & spaces.
						                     'category'  => $this->getPostParameter('category'),
						                     'imageName' => $this->getPostParameter('imageName'),
						                     'content'   => $this->getPostParameter('content'),
						                     'rating'    => $this->getPostParameter('rating'),
						                     'author'    => $this->user,
						                     'authorId'  => $this->session->userId
						);
						$queryResult = $this->model->insert('reviews', $queryParams); // Insert the review to the database
						if ($queryResult) { // if the insertion succeded
							$this->redirectTo("/success");
						}
					} else { // If some values fail to post
						$this->errorHandler->setErrorMsg("There was an error in your data");
						$data = Array('title'     => $this->getPostParameter('title'),
						              'category'  => $this->getPostParameter('category'),
						              'imageName' => $this->getPostParameter('imageName'),
						              'content'   => $this->getPostParameter('content'),
						              'rating'    => $this->getPostParameter('rating'),
						);
						$this->loadPage("post_new_review", $data);
					}

				} // If article was posted
				elseif ($this->getPostParameter('article')) {

					if ($this->getPostParameter('title') && $this->getPostParameter('category') && $this->getPostParameter('imageName') && $this->getPostParameter('content')) {
						// Insert to database

						$queryParams = Array('title'     => strtolower($this->getPostParameter('title', TREGEXPRULES)), // Title is used in the URL, and even though our DB is registered as Case Insensitive, I want to play it safe. So the entry data is only lowercase letters, numbers & spaces.
						                     'category'  => $this->getPostParameter('category'),
						                     'imageName' => $this->getPostParameter('imageName'),
						                     'content'   => $this->getPostParameter('content'),
						                     'author'    => $this->user,
						                     'authorId'  => $this->session->userId
						);
						$queryResult = $this->model->insert('articles', $queryParams); // Insert the review to the database
						if ($queryResult) { // if the insertion succeded
							$this->redirectTo("/success");
						}
					} else { // If some values fail to post
						$this->errorHandler->setErrorMsg("There was an error in your data");
						$data = Array('title'     => $this->getPostParameter('title'),
						              'category'  => $this->getPostParameter('category'),
						              'imageName' => $this->getPostParameter('imageName'),
						              'content'   => $this->getPostParameter('content')
						);
						$this->loadPage("post_new_review", $data);
					}
				}
			} else { // If a submit is not posted, just show the form.
				$this->loadPage("post_new_review");
			}
		} else { // If the user is not logged
			$this->redirectTo("/login");
		}
	}

	private function searchReview($urlParams)
	{
		if ($this->getPostParameter('submit') && $this->getPostParameter('search')) { // If a search has been posted

			$queryParams = Array('content' => '%' . $this->getPostParameter('search') . '%');
			$data = $this->model->search('reviews', $queryParams);
			$this->checkForErrors($data);
			$this->loadPage("search_result", $data);
		} else { // If a search query is not given, just redirect to home
			$this->errorHandler->setErrorMsg("Specify a query!");
			$this->loadPage("search_result");
		}
	}

	private function about($urlParams)
	{
		$this->loadPage("about");
	}

	private function success()
	{
		$this->redirectTo("/home", 3);
		$this->errorHandler->setSuccessMsg("Thank you!");
		$this->loadPage("success");
	}
}

