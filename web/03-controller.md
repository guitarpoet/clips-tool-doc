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
			echo "Hello world";
		}
	}

## Rule Based Request Routing

The request routing in Clips\Tool is rule based. Clips\Tool use the same method like [CI](http://codeigniter.com), all the request should routing using index.php. So, all the request to Clips\Tool web application should be something like this:

	/index.php/user/show/1

Clips Tool's router will use the uri segments to find out which controller to initialize and which controller method to call.

Clips Tool use the CI's default routing scheme by default, the rules is like this(The real rules code, since the rules are simple enough):

	(defrule explode-the-uri-to-segments
		(uri ?uri)
		=>
		(assert (segments (explode "/" ?uri)))
	)

	(defrule take-the-controller-and-method-seg
		(not (controller ?))
		(segments $?segs)
		=>
		(assert (controller (nth$ 1 $?segs)))
		(assert (method (nth$ 2 $?segs)))
	)

	(defrule if-seg-length-is-bigger-than-2-try-controller-with-namespace
		(declare (salience ?*low*))
		(not (Clips\RouteResult)) ; No route result is found
		(segments $?segs &: (> (length$ $?segs) 2)) ; The segment is larger than 2
		?c <- (controller ?name &:(not (eq ?name (str-cat (ucfirst (nth$ 1 $?segs)) "\\" (ucfirst (nth$ 2 $?segs))))))
		=>
		(retract ?c)
		(assert (controller (str-cat (ucfirst (nth$ 1 $?segs)) "\\" (ucfirst (nth$ 2 $?segs)))))
		(assert (method (nth$ 3 $?segs)))
	)

	(defrule try-default-method-if-the-seg-length-is-equals-to-2
		(declare (salience ?*low*))
		(not (Clips\RouteResult)) ; No route result is found
		(segments $?segs &: (= (length$ $?segs) 2))
		?c <- (controller ?name &:(not (eq ?name (str-cat (ucfirst (nth$ 1 $?segs)) "\\" (ucfirst (nth$ 2 $?segs))))))
		?m <- (method ?)
		=>
		(retract ?c)
		(retract ?m)
		(assert (controller (str-cat (ucfirst (nth$ 1 $?segs)) "\\" (ucfirst (nth$ 2 $?segs)))))
		(assert (method ""))
	)

	(defrule try-to-find-controller-by-controller-seg
		(controller ?c&~"")
		(test (php_call "Clips\\controller_exists" ?c))
		=>
		(assert (Clips\RouteResult (controller (php_call "Clips\\controller_class" ?c))))
	)

	(defrule if-no-controller-is-found-using-the-controller-seg-show-error
		(declare (salience ?*low*))
		(controller ?c&~"")
		(not (test (php_call "Clips\\controller_exists" ?c)))
		=>
		(assert (RouteError (str-cat "No controller named " ?c " found!")))
	)

	(defrule use-default-index-method-if-no-method-set
		?m <- (method ""|nil)
		=>
		(retract ?m)
		(assert (method "index"))
	)

	(defrule if-is-ajax-prefer-ajax-suffix-method
		(RequestType "ajax")
		?method <- (method ?m&:(not (str-index "_ajax" ?m)))
		?r <- (Clips\RouteResult (controller ?c&~nil) (method nil))
		(test (method-exists ?c (str-cat ?m "_ajax")))
		=>
		(retract ?method)
		(assert (method (str-cat ?m "_ajax")))
	)

	(defrule if-is-pagination-prefer-pagination-suffix-method
		(RequestType "ajax")
		(Parameter "draw" ?)
		(Parameter "start" ?)
		(Parameter "length" ?)
		?method <- (method ?m&:(not (str-index "_pagination" ?m)))
		?r <- (Clips\RouteResult (controller ?c&~nil) (method nil))
		(test (method-exists ?c (str-cat ?m "_pagination")))
		=>
		(retract ?method)
		(assert (method (str-cat ?m "_pagination")))
	)

	(defrule if-is-pagination-and-no-pagination-suffix-method-use-default-pagination-method
		(segments $?segs)
		(RequestType "ajax")
		(Parameter "draw" ?)
		(Parameter "start" ?)
		(Parameter "length" ?)
		?method <- (method ?m&:(and (not (eq "pagination" ?m)) (not (str-index "_pagination" ?m))))
		?r <- (Clips\RouteResult (controller ?c&~nil) (method nil))
		=>
		(retract ?method)
		(assert (method "pagination"))
		(if (and 
				(> (length$ $?segs) 2)
				(numberp (member$ ?m $?segs))
				(>= (length$ $?segs) (+ (member$ ?m $?segs) 1)))
		then 
			(modify ?r (args (subseq$ $?segs (+ (member$ ?m $?segs) 1) (length$ $?segs))))
		else 
			(modify ?r (args (create$ ?m)))
		)
	)

	(defrule if-is-post-prefer-form-suffix-method
		(RequestMethod "post")
		?method <- (method ?m&:(not (str-index "_form" ?m)))
		?r <- (Clips\RouteResult (controller ?c&~nil) (method nil))
		(test (method-exists ?c (str-cat ?m "_form")))
		=>
		(retract ?method)
		(assert (method (str-cat ?m "_form")))
	)

	(defrule insert-a-result-if-nothing-found
		(declare (salience ?*low*))
		(not (Clips\RouteResult))
		=>
		(assert (Clips\RouteResult))
	)

	(defrule set-the-method-to-result-if-the-method-matched
		(method ?m&~"")
		?r <- (Clips\RouteResult (controller ?c&~nil) (method nil))
		(test (method-exists ?c ?m))
		=>
		(modify ?r (method ?m))
	)

	(defrule add-the-uri-if-method-found
		(controller ?c&~"")
		(Clips\RouteResult (controller ~nil) (method ?m&~nil))
		=>
		(assert (server-uri (str-cat ?c "/" ?m)))
	)

	(defrule set-the-args-to-the-result
		?r <- (Clips\RouteResult (controller ~nil) (method ?m) (args $?args&:(= (length$ $?args) 0)))
		(segments $?segs)
		(test (> (length$ $?segs) 2))
		(test (numberp (member$ ?m $?segs)))
		(test (>= (length$ $?segs) (+ (member$ ?m $?segs) 1)))
		=>
		(modify ?r (args (subseq$ $?segs (+ (member$ ?m $?segs) 1) (length$ $?segs))))
	)

	(defrule if-the-method-is-not-found-at-all-then-error
		(method ?m&~"")
		?r <- (Clips\RouteResult (controller ?c&~nil) (method nil))
		(test (not (method-exists ?c ?m)))
		=>
		(assert (RouteError (str-cat "No method named " ?m " found in controller " ?c "!")))
	)


Using these rules, router can have these routing functions addtional than CI:


1. Controllers can have namespaces, for example, demo/user/show will let router try to find the UserController class in Demo namespace(with namespace prefix configured in config)
2. Method can be suffixed, for example, when handling ajax request, method_ajax will be better result than method it self, so you can the processing in different method, but keep the same uri
3. Auto pagination support based on the Router

You can add your rules too, for example:

	(defrule set-the-controller-to-welcome-controller-if-no-controller-found
		?c <- (controller "")
		=>
		(retract ?c)
		(assert (controller "home"))
	)

This rule will let the controller routing result be HomeController when no controller is found.

You can do anything more than this, since you can see in the rules above, for the run of routing rules, you can get RouteResult(this leads to the controller processing) or a RouteError(show the error in routing).


## The Concept of Filters

In Clips Tool, nearly everything you used can be customized and changed in the runtime. So, for web applications, Clips tool designed a filter based processing pattern. 

The Filter in Clips Tool is something like J2EE's filter but with more functions.

You can use the filter to handle every phase of the request processing:

* Before controller's method execution: You can stop the method execution, change the session, alter the request as you like at this phase, this phase mostly used for security engine(yes, we have a security filter)
* After Controller's method execution: You can get the execution result at this phase, this phase mostly used for rendering or adding metadatas(http headers for example)
* Before Render: You can get the template and data to render in this phase, this phase mostly used for alter the rendering data or add something new into the template engine, or stop the render completely.

### The Whole Filtering Process

1. Construct the HttpRequest Object
2. Run the route rule against the request(uri and parameters)
3. Initialising the controller(using IoC support)
4. Construct the filter chain(construct all the filters)
5. Trigger all the filter_before method of all validate filters
6. Execute the controller's method with args(come from route result)
7. Trigger all the filter_after method of all validate filters

There won't be any filter_render method call here, since that will be called in the render engine(mostly filters).

## The Filters in Clips Tool

There are a few filters in Clips Tool(they can be located at namespace Clips\Filters), let me explain them to you:

* CssFilter: This filter will trigger at any request's filter after phase, will put all the css file in the context's css value to a link reference
* DirectViewFilter: This filter will provide the direct view render engine
* FormFilter: This filter will filter all the form request(default to post, if you want to filter get request as well, set Clips\Form annotations's get attribute to true), using the rule you defined in form configuration to validate the form request
* JsFilter(@deprecated): This filter will generate the Script tags using Context's js value, this is desprated for version 1.0, since there is a better way to do this by using smarty plugin js.
* MustacheViewFilter: This filter will provide the mustache view render engine
* RulesFilter: This filter will trigger the rules filter, it will initialize the rule engine using your rules at filter before phase, and it'll run the rule engine at the filter after phase, so that, if your request is a rule based one, you'll need write quite little code
* ScssFilter: This filter will using SassCompiler to compile all the value in Context's scss value to 1 scss_file, and add it to Context's css value
* SmartyViewFilter: This filter will provde the smarty render engine

### The order of filters

As you can see, filter can generate the input of other filter(by using [context]({{siteurl "base_concepts/context"}})), so, if you put the wrong order of filters, you may got the wrong answer.

### Write You Own Filter

You can write your own filter, and that's quite easy:

1. Make your filter class extends Clips\AbstractFilter(if your filter is a view filter, extends AbstractViewFilter)
2. Override the function filter_before, filter_after or filter_render
3. Configure your filter to Clips Tool using configuration file

## The Views

In Clips Tool's controller, you can render the output using these ways:

### Just Echo

You can just echo, print_r or vardump the data right in the controller, this won't affect any view, and if you do not return anything in controller, all the filter after(mostly the render engines) won't take any effect

### Default Render Engine

You can just return a string to represent the template you want to like this:

	return "home/index";

And, Clips Tool will using the default render engine(smarty, by default) to find the template(mostly, application/views/home/index.tpl) and render it.

If you want to add some data to render, you should using this:

	return $this->render('home/index', array('promote_products' => $this->product->getPromoteProducts()));

And then, you can access the promote products in your template using variable promote_products.

### Choose A Render Engine

You can choose the render engine you want to use too, first, you must configure it as the filter like this:

    "filters": ["Rules", "Form", "Scss", "Css", "SmartyView", "MustacheView", "JsonView", "DirectView"],

As you can see, in this configuration, you can use smarty, mustache, json and direct as render engine.

Let's see how to use them.

If you want to choose a render engine to render, just adding the render engine to the render method:

	return $this->render('home/index', array('promote_products' => $this->product->getPromoteProducts()), 'smarty');

And you'll render the home/index template using smarty template.

There is 2 special render engine, json and direct, they don't need any template. For json render engine, it will render the return data as json, so you can use it like this:

	return $this->render('', array('hello' => 'world'), 'json');

And you'll get {"hello":"world"} as result. Of course, you can use the json method in Clips\Controller, it run like this too(but added the json headers by default).

For direct render engine, it'll output anything at the first argument, in most case, you don't need to write anything, since in most case, you'll just using direct render engine to send headers(redirect, for example).

## The Request and Session

When the http request comes to Clips Tool, it'll construct a Clips\HttpRequest object and add it as a field to the controller.

You can get lots of things using this object.

For example:

### Browser Metadata

Clips Tool use [bcap](http://browscap.org) data to detect browser's capacity and doing the browser hack automaticly.

And you can get the request browser's metadata quite easily using HttpRequest's browserMeta function.

In order to use this method, you should download the process the bcap file, it should be quite easy in Clips Tool, by using this method:

	$ ./vendor/bin/clips get bcap

Here is an example of my browser meta:

stdClass Object
(
    [browser_name] => Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/600.5.17 (KHTML, like Gecko) Version/8.0.5 Safari/600.5.17
    [browser_name_regex] => ^mozilla/5\.0 \(.*mac os x 10_10.*\) applewebkit/.* \(khtml, like gecko\) .*version/(\d)\.(\d).* safari/.*$
    [browser_name_pattern] => Mozilla/5.0 (*Mac OS X 10_10*) AppleWebKit/* (KHTML, like Gecko) *Version/8.0* Safari/*
    [parent] => Safari 8.0
    [platform] => MacOSX
    [comment] => Safari 8.0
    [browser] => Safari
    [version] => 8.0
    [device_type] => Desktop
    [ismobiledevice] => 
    [istablet] => 
)

### Breadscrumb

Clips Tool support breadscrumb at the root of web application(in router) and store the breadscrum in session. 

So you can access the breadscrum anywhere you want in controller.

### Request IP

You can get the request browser's ip address just by call getIP() method in request object.

### Session

The session in Clips Tool is just the plain PHP session. You can use session method to access it.

When you want get a value from session use the method like this:

	$this->request->session('name');

When you want to update a value or insert a value into session, use the method like this:

	$this->request->session('name', 'value');

When you want to delete the value from session, use the method like this:

	$this->request->session('name', null);

When you want to get the whole session object, use the method like this:

	$this->request->session();

When you want to destroy the whole session, use the method like this:

	$this->request->session()->destroy();

### Server Data

You can get any server data using server method like this:

	$this->request->server('SCRIPT_FILENAME');

### Http Request Headers

You can get any request header using header method like this:

	$this->request->header('Content-Type');

### Request Type

In clips, there are 3 request type for http request:

1. http: The get or post request
2. ajax: The get or post request that using XMLHttpRequest
3. cli: The request is comming from cli, not a web request

### Request Parameters

You can get any request parameter(no matter get or post) by using param method like this:

	$this->request->param('name');

And, if no parameter is there, you can set the default return value as you want:

	$this->request->param('name', 'nobody');

Or, you can get all the parameters as array by using this:
	
	$this->request->param();

This is quite useful, when you processing update action, for example, to update the user information:

	$this->user->update($this->user->cleanFields($this->request->param()));

This applies to get and post too. You can use method of get and post like this.
