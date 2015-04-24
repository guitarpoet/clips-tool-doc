# Web Development - Controller

## The Concept of Controller in Clips Tool

The Controller in Clips Tool is just a facade open to Http Requests. I suggest to write controllers as *thin* as possible. How thin a controller should be? There is no standards about that, but I suggest that all controller's method code should show in one screen without scrolling, since controller can access session and request(and cookies) quite easily, so, the best place to write the manipulate code for these is at the controller

## The sample Controller code

Here is the sample code for controller:

	<?php namespace Demo\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

	use Clips\Controller;

	/**
	 * @Clips\Widget({"lang"})
	 */
	class SampleController extends Controller {

		public function index() {
			return "sample/index";
		}
	}
