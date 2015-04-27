# Web Development - Style

## The Concept of Style in Clips Tool

In the Clips Tool style web application, the style should be seperate from the view logic and flow logic.

In HTML, there is a very good abstraction for style, that is called [CSS](http://en.wikipedia.org/wiki/Cascading_Style_Sheets), this is the baseline for Clips Tool's view style.

But CSS is not perfect, it has no functions, it has no nest structures, and the syntax is not quite powerful, so Clips Tool suggest another way to get CSS done, that is [SASS](http://sass-lang.com)

## SASS In Clips Tool

Clips Tool uses SASS as the core part of the style operation by use a php extension called [php-sass](https://github.com/guitarpoet/php-sass). 

php-sass is a wrapper for [libsass](http://libsass.org) in php, it provides many nice function to sass, and can let the sass code to call php code, convert php object into sass object and vice versa.

By using php-sass, Clips Tool provides a very powerful SassCompiler, it can compile very complex sass file within a second and store the result in the cache so that next time, there is no need to compile.

### Basic Usage for Sass Compiler Usage

In most case, you don't even bother to know there is a SASS compiler, since the only thing you need is to add an annotation to you controller, say, you want to add a style file locate in application/static/scss/home/index.scss.

The code you need is this:

	/**
	 * @Clips\Scss("home/index")
	 */
	public function index() {
		return "home/index";
	}

And if you want to add some [Widgets]({{siteurl "web/06-widgets"}})(The widget may have its styles) to you home page, you should add this:


	/**
	 * @Clips\Widget({"form", "grid"})
	 * @Clips\Scss("home/index")
	 */
	public function index() {
		return "home/index";
	}

And all the scss file(including the dependencies and yours) will be compiled to 1 file at runtime, and save that file to cache, so that next time you visit the page, compiler won't compile it again.

But, if we changed some file, and want compiler to compile that again?

You can change the configuration, and add this line to it:

	"debug_sass": true

And, you are done, with this configuration, SASS compiler will compile the sass any time the page is requestted(NOTE, this is only for testing and development cause, in live server, this will bring very big performance penalty).

## Advanced SASS In Clips Tool

The SASS compiler is extendable, and have these plugins by default:

AutoConstruct: The constructor of the SCSS module, each file is a SCSS module in Clips Tool, it can have its constructor(the same name as the module file name), and this plugin will call this constructor after all the SASS code. This is quite useful for initializing the widgets

AutoResolution: The auto resolution constructor, this part will be describe in detail at [Smart Responsive]({{siteurl "web/06-smart_responsive"}})

You can add your plugin as well:

1. All SassPlugin must extend class Clips\Libraries\Sass\SassPlugin
2. You can configure the SASS Plugin that SASS compiler uses by configure the configuration of 'sass_plugins'
3. All SassPlugin must in Libraries namespace

You can use your SASS plugin to add the function you needed or alter the sass content before or after the compile of SASS code.

## What if I want to use [Bootstrap](http://getbootstrap.com)'s styles?

Bootstrap has a SCSS version of css, you can get it to work in Clips Tool quite easily, in fact, Clips Tool do ship with a version of Bootstrap's scss version, you can view [Widgets]({{siteurl "web/06-widgets"}}) for more detail.
