# Base Concepts - [CLIPS](http://clipsrules.sourceforge.net/)

## What is [CLIPS](http://clipsrules.sourceforge.net/)

CLIPS is a productive development and delivery expert system tool which provides a complete environment for the construction of rule and/or object based expert systems. Created in 1985, CLIPS is now widely used throughout the government, industry, and academia. Its key features are:

* Knowledge Representation: CLIPS provides a cohesive tool for handling a wide variety of knowledge with support for three different programming paradigms: rule-based, object-oriented and procedural. Rule-based programming allows knowledge to be represented as heuristics, or "rules of thumb," which specify a set of actions to be performed for a given situation. Object-oriented programming allows complex systems to be modeled as modular components (which can be easily reused to model other systems or to create new components). The procedural programming capabilities provided by CLIPS are similar to capabilities found in languages such as C, Java, Ada, and LISP.
* Portability: CLIPS is written in C for portability and speed and has been installed on many different operating systems without code changes. Operating systems on which CLIPS has been tested include Windows XP, MacOS X, and Unix. CLIPS can be ported to any system which has an ANSI compliant C or C++ compiler. CLIPS comes with all source code which can be modified or tailored to meet a user's specific needs.
    Integration/Extensibility: CLIPS can be embedded within procedural code, called as a subroutine, and integrated with languages such as C, Java, FORTRAN and ADA. CLIPS can be easily extended by a user through the use of several well-defined protocols.
* Interactive Development: The standard version of CLIPS provides an interactive, text oriented development environment, including debugging aids, on-line help, and an integrated editor. Interfaces providing features such as pulldown menus, integrated editors, and multiple windows have been developed for the MacOS, Windows XP, and X Window environments.
* Verification/Validation: CLIPS includes a number of features to support the verification and validation of expert systems including support for modular design and partitioning of a knowledge base, static and dynamic constraint checking of slot values and function arguments, and semantic analysis of rule patterns to determine if inconsistencies could prevent a rule from firing or generate an error.
* Fully Documented: CLIPS comes with extensive documentation including a Reference Manual and a User's Guide.
* Low Cost: CLIPS is maintained as public domain software. 

## How to play with CLIPS using Clips Tool

You can run Clips's command line console juse using clips command.

Like this:

	clips

And you'll get a console of [PHP-CLIPS](https://github.com/guitarpoet/php-clips) and ready to play with it.

Or, if you just want to test your rules, you can run the rules by using this command

	clips run xxxx.rules

## How to use CLIPS in your TestCase

Rules is your code too, you should test them using automating test tools.
Here is how you test your rules using Clips Tool.

All tests in Clips Tool are done using [PHPUnit](https://phpunit.de/).

The test case of a rule should be something like this:

	<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

	class MyRulesTest extends Clips\TestCase {

		/**
		 * @Clips\Rules(rules = {"my.rules"})
		 */
		public function testMyRulesInConditionA() {
			// ...
			//
			// Asserting your facts
			//
			// ...

			$this->clips->run();

			// ...
			//
			// Test the result facts
			//
			// ...
		}
	}

Generate as much test data as possible if you can. And do the test more thoroughly, because complex are not that easy to write.

The test part and how to generate test data automaticly, see the section for testing.

## Hello world

I really don't want write too much on the concept of CLIPS, so if you are not famillar with CLIPS, please do read them [here](http://clipsrules.sourceforge.net/documentation/v630/bpg.htm), but, you won't need to install any CLIPS runtime to test the code, since Clips Tool has the whole runtime(including a better console), Clips Tool means to port the CLIPS to PHP and create a better environment to play with it, after all.

Launch clips console
Input the command

	(printout t "Hello world" crlf)

The output should be "Hello world"

You can run the rule file like this:

Save This to the file hello.rules

	(printout t "Hello world" crlf) 

Then Run command 

	clips run hello.rules

## A more complex example

Hello world is too easy to show the power of CLIPS, let's make a little complex. How about fibonacci?

Create a file named fibo.rules, and code it like below:

	(defrule fibonacci-base
		"Create the rule base when initializing"
		(n ?n&:(and (integerp ?n) (> ?n 0)))
		=>
		(assert (f 1 1) (f 2 1))
	)

	(defrule fibonacci-calculate
		"Calculating fibonacci using formula f(n + 1) = f(n) + f(n - 1)"
		(n ?max)
		(f ?n ?v)
		(f ?n1&:(and (= ?n1 (+ ?n 1)) (<= ?n1 ?max)) ?v1)
		=>
		(assert (f (+ ?n1 1) (+ ?v ?v1)))
	)

	(defrule fibonacci-get-result
		"Getting the result"
		(n ?n)
		(f ?i&:(= ?i ?n) ?v)
		=>
		(assert (result ?v))
	)

Let me explain the code:

	(defrule fibonacci-base
		"Create the rule base when initializing"
		(n ?n&:(and (integerp ?n) (> ?n 0)))
		=>
		(assert (f 1 1) (f 2 1))
	)

The code above is a rule, the rule contains 3 parts:

1. Meta: Such as rule name, and rule doc, in above code, fibonacci-base is the rule's name and 
"Create the rule base when initializing" is the document of the rule, you can write comments to your rule too.
2. Conditions: Conditions are coding like lisp, let me explain the code in more detail

	(n ?n&:(and (integerp ?n) (> ?n 0)))

The code means, this rule matches when there is a fact named "n", with first element type is integer and bigger than 0.
The &: means ?n must fits the conditions.

So, in this condition, we need (a fact named n, the first element of this fact must be an integer bigger than 0)
3. Operations: This part defined if the conditions is matched, how the rule perform, in the code above
	
		(assert (f 1 1) (f 2 1))
	
This means if the condition(we do have a fact named "n", with first element type is integer and bigger than 0), please add 2 more
facts into the execution environment (f 1 1) and (f 2 2)

Can we run this code? Nope, we can't.

Since we don't really have fact "n" in the execution environment, so the rules won't run.

Let's adding some code to it to start the execution, like this: 

	(assert (n 10)); Asserting fact n with 10
	(run); Run the rules
	(facts); Print out all the facts in the environment

So, the complete code is like this in fibo.rules:

	(defrule fibonacci-base
		"Create the rule base when initializing"
		(n ?n&:(and (integerp ?n) (> ?n 0)))
		=>
		(assert (f 1 1) (f 2 1))
	)

	(defrule fibonacci-calculate
		"Calculating fibonacci using formula f(n + 1) = f(n) + f(n - 1)"
		(n ?max)
		(f ?n ?v)
		(f ?n1&:(and (= ?n1 (+ ?n 1)) (< ?n1 ?max)) ?v1)
		=>
		(assert (f (+ ?n1 1) (+ ?v ?v1)))
	)

	(defrule fibonacci-get-result
		"Getting the result"
		(n ?n)
		(f ?i&:(= ?i ?n) ?v)
		=>
		(assert (result ?v))
	)

	(assert (n 10))
	(run)
	(facts)

And run it

	clips run fibo.rules

You'll get the result like this:

	f-0     (initial-fact)
	f-1     (n 10)
	f-2     (f 1 1)
	f-3     (f 2 1)
	f-4     (f 3 2)
	f-5     (f 4 3)
	f-6     (f 5 5)
	f-7     (f 6 8)
	f-8     (f 7 13)
	f-9     (f 8 21)
	f-10    (f 9 34)
	f-11    (f 10 55)
	f-12    (result 55)
	For a total of 14 facts.

As you can see, all the n(n <= 10) is calculated, and the result for fibo(10) is 55.

This code is not good enough though, as you can see, for fibo(10), there will be 12 facts there(1 for n, 1 for result, and 10 for
all the fibonacci number through 1~10). Then if we're calculating fibo(10000), there will be 10002 facts there, such a waste, since
we just want the result.

Let's make it better by retracting some facts after the calculation. Change the code to this:

	(defrule fibonacci-base
		"Create the rule base when initializing"
		(n ?n&:(and (integerp ?n) (> ?n 0)))
		=>
		(assert (f 1 1) (f 2 1))
	)

	(defrule fibonacci-calculate
		"Calculating fibonacci using formula f(n + 1) = f(n) + f(n - 1)"
		(n ?max)
		?old <- (f ?n ?v)
		(f ?n1&:(and (= ?n1 (+ ?n 1)) (< ?n1 ?max)) ?v1)
		=>
		(assert (f (+ ?n1 1) (+ ?v ?v1)))
		(retract ?old)
	)

	(defrule fibonacci-get-result
		"Getting the result"
		(n ?n)
		(f ?i&:(= ?i ?n) ?v)
		=>
		(assert (result ?v))
	)

	(assert (n 10))
	(run)
	(facts)

See the difference?

The difference is at this rule:

	(defrule fibonacci-calculate
		"Calculating fibonacci using formula f(n + 1) = f(n) + f(n - 1)"
		(n ?max)
		?old <- (f ?n ?v) ; <- This means we need to get the pointer of this fact
		(f ?n1&:(and (= ?n1 (+ ?n 1)) (< ?n1 ?max)) ?v1)
		=>
		(assert (f (+ ?n1 1) (+ ?v ?v1)))
		(retract ?old) ; <- This means we should delete the old entry to free some space
	)

The result will be like this:

	f-0     (initial-fact)
	f-1     (n 10)
	f-10    (f 9 34)
	f-11    (f 10 55)
	f-12    (result 55)
	For a total of 5 facts.

It is nicer, isn't it?

## Let's get some PHP code

CLIPS can do far more powerful than this, but, wait, Clips Tool is a framework of PHP, isn't it?
How can I use PHP code in the rule engine?

Let's suppose, we need to get the timestamp of tomorrow(or even more complex, 3 weeks later). How can we do it?
You can achieve this use CLIPS's functions, but why need that since PHP already has strtotime?

Let's code this in php.rules:

	(deffunction parse-time (?str) (php_call "strtotime" ?str))
	(printout t (parse-time "tomorrow"))

The result depends on your machine time, for the time I writting this document, it is 1426608000.

This is quite quite useful, since you can call any method in PHP using rules, and even put parameters to it.

The conversion is done by this, left to right:

|PHP Type 			|CLIPS Type 	|
|:-----------------:|:-------------:|
|Long 				|Integer   		|
|Double 			|Float			|
|String 			|String 		|
|Array 				|Fact 			|
|Object 			|Template Fact 	|
|Object In Context 	|Instance 	 	|

The conversion back is done by this, left to right:

|CLIPS Type 	|PHP Type 			|
|:-------------:|:-----------------:|
|Long 			|Long   			|
|Float 	 		|Double				|
|String 		|String 			|
|Symbol 		|String 			|
|Fact 			|Array 				|
|Template Fact	|Object 			|
|Instance  		|Object In Context 	|

## Let's add some priorities and use some handy functions

Clips Tool embeded some handy functions and constants, to make write rules easier, for example:

	(php-require-once "some_function.php")

Or like this:
	
	(explode ":" "a:b:c:d")

And, as you know, the rules can executed based on the priority you want, for example, for login processing, user can login use usename password, or
use oauth, or use mobile phone(sms code), and if nothing login method fits, warn user about this. Here is the example rule code:

	(defrule user-can-login-by-username-and-password
		(not (login ?status&~nil)); If we are logged in or logged failed, skip this rule
		(username ?username&~nil)
		(password ?password&~nil)	
		=>
		(if 
			(php_call "Demo\\username_and_password_fits" ?username ?password)
		 then
			(assert (login success))
		 else
			(assert (login failed) (fail-message (str-cat "Username " ?username " and password " ?password " are not match!")))
		)
	)

	(defrule user-can-login-by-email-and-password
		(not (login ?status&~nil)); If we are logged in or logged failed, skip this rule
		(email ?email&~nil)
		(password ?password&~nil)	
		=>
		(if 
			(php_call "Demo\\email_and_password_fits" ?email ?password)
		 then
			(assert (login success))
		 else
			(assert (login failed) (fail-message (str-cat "Email " ?email " and password " ?password " are not match!")))
		)
	)

	(defrule user-can-login-by-mobile
		(not (login ?status&~nil)); If we are logged in or logged failed, skip this rule
		(mobile ?mobile&~nil)
		(code ?code&~nil)	
		=>
		(if 
			(php_call "Demo\\mobile_and_code_fits" ?mobile ?code)
		 then
			(assert (login success))
		 else
			(assert (login failed) (fail-message (str-cat "Mobile " ?mobile " and code " ?code " are not match!")))
		)
	)

	(defrule if-no-method-match-login-failed
		(declare (salience ?*low*))
		(not (login ?status&~nil)); If we are logged in or logged failed, skip this rule
		=>	
		(assert (login failed) (fail-message "No login method matched, login failed!"))
	)

By adding this code:
	
		(declare (salience ?*low*))	

You can make rule if-no-method-match-login-failed has the lower execute priority when executing the rules, so that rule engine
will use other rules and skip it when any of the login rules applies.
