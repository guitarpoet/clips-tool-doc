# Base Concepts - IoC

## What is IoC

The IoC in Clips-Tool means (Inversion of Control).

IoC is a good way to break donw the depenencies of the components of the application.

IoC sometimes can be called Dpendency Injection - [DI](http://en.wikipedia.org/wiki/Dependency_injection). In software engineering, dependency injection is a software design pattern that implements inversion of control for software libraries. Caller delegates to an external framework the control flow of discovering and importing a service or software module specified or "injected" by the caller. Dependency injection allows a program design to follow the dependency inversion principle where modules are loosely coupled. With dependency injection, the client which uses a module or service doesn't need to know all its details, and typically the module can be replaced by another one of similar characteristics without altering the client.

There are many frameworks that implememnts the IoC, such as [SprintFramework](http://www.springframework.org) and [Guice]() in Java.

## How Clips Tool provides IoC

IoC framework must have a singleton service locator(beanfactory in spring for example) as the container, and have the configuration items to configure the service locator.

All the components is created by the service locator and can be accessed through a method call. All the dependencies of the components are decleared using some kind of configuration method(xml, json or annotations).

This is the same way Clips Tool provides.

1. Clips Tool provides a singleton service locator and loader Clips\Tool
2. All the objects should be create by Clips\Tool
3. You objects that is not created by Clips\Tool, can be get enhanced using Clips\Tool's enhance method

There are 3 benefits to use Clips Tool to create the object for you than new it:

1. All the objects that created by Clips\Tool, Clips\Tool keeps a handle of it, so you can access it anytime, anywhere and don't afraid to recreate twice
2. All the objects that created by Clips\Tool will be enhanced automaticly
3. Clips\Tool will try to guess the namespace of your object, and will let you to change the behaviour of the application without even change the configuration, for example, if you want to add or change some functions to the router service just create your owner router extends Clips\Router and add your functions, since router object is create by Clips Tool, the system will use your Router automaticly

## The power of IoC

Let's see the power of Clips Tool's IoC support.

### Auto Logger Support([PSR-3](http://php-fig.org/psr/psr-3/))

Clips Tool support [PSR-3](http://php-fig.org/psr/psr-3/) - the logging standard use IoC.

If you want to use a logger in your component, just let your Class implements the Psr\Log\LoggerAwareInterface.

### Clips Tool Reference Support

You can get the reference of Clips\Tool's singleton instance just by let your Class implements the Clips\Interfaces\ToolAware interface.

### Clips Engine Reference Support

You can get the reference of Clips\Engine's default instance just by let your class implements the Clips\Interfaces\ClipsAware interface.

### Auto Initialize Support

You can let your component have the auto initialize support just by let your class implements the Clips\Interfaces\Intializable

### Auto Wire Depenencies

All the depenencies(model, library, object) can be required just adding the annotation.

I'll talk about the differences of the model, library and object's differences in Clips Tool here:

1. Model: Model means the object that dealing with domain objects, for example, a UserModel is the object that will handling all the user operations (change password, login, logout, update profile ...), of course when in a bigger system, maybe update profile could be big enough to be a operation domain, so, may be you'll need a ProfileModel as well.

For Models, they should have nothing to do with view or have nothing knowledge about where it should be called(in web or command line).

All models should be located in Models namespace, but can be embbed in inner namespace, user for example. And must have the suffix Model to indicate that it is a model.

So, a typical model should be something like this:

	namespace Demo\Models;	
	class ProfileModel extends BaseModel

And this model can be access through:

	$tool->model('profile')

	or

	/**
	 * @Clips\Model("profile")
	 */
	class TestController extends BaseController

And for the last example, you can access the profile model in controller's method just using this:

	$this->profile

NOTE:
	All the character of the referenced object in later way is lowercased. So, if you have a model name SuperManModel, you should reference it using @Clips\Model("superMan"), and in code $this->superman. This is because I want to let the developer know which property of the object is autowired by Clips\Tool(they are all lowercased)

2. Library; Library is the PHP objects provides some kind of service to let model or controller to call(encrypt or decrypt, for example).

The library class should be locate in Libraries namespace, so a typical library should be something like this:

	namespace Demo\Libraries;

	class Encryptor extends BaseService

And the library can be accessed by:

	$tool->library("encryptor");

or

	/**
	 * @Clips\Library("encryptor")
	 */
	class TestController extends BaseController

3. Object: If model and library can't satisfy you (for example some core objects that is not model and should not be a optional library). You can use object instead. In fact, you can create Model and Library object just using object(though not suggested).

Object has the ability to auto add namespace too.

The object can be accessed by:


	/**
	 * @Clips\Object("engine")
	 */
	class TestController extends BaseController

### Enhance Object Manually

Even though Clips Tool suggest you to create your object using Clips\Tool, but Clips\Tool will provide you another way to use IoC -- Use enhance method manually.

The code for enhance manually is like this:

	$tool->enhance($obj);

## The Future of IoC of Clips Tool

In future version of Clips Tool, the auto depenencies injection will support different versions of the dependencies class.
