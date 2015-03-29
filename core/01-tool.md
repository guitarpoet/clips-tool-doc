# Core - Tool

Clips\Tool is the heart object of the Clips Tool, it behaves as:

1. Class Loader(CI Style and PSR4-Style)
2. Object Factory(Create and enhance the object using annotations)
3. Singleton Service locator
4. Command executor(for command line)

## Class Loading


### [PSR4](http://php-fig.org/psr/psr-4/) Class Loading

Clips\Tool use [PSR4](http://php-fig.org/psr/psr-4/) class loading method by default.
All class loading using PSR4 method will use composer's autoloader to load.

Clips\Tool extends this by using auto namespace support. Auto namespace support is done like this:

1. Your code trying to load a class, say Dummy
2. Tool will try to find Dummy in all the namespace you have configured in "namespace"
3. If not found, it will try Clips namespace

This class loading method will give you the flexiablity of replacing any core class of Clips Tool
to use your own.

Let's say you want to use Clips\Engine
