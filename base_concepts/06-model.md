# Base Concepts - Model

## The Concept of Model in Clips Tool

Like other web framework, Clips prefers the [MVC](http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) design pattern.

In Clips Tool, we prefer a very very thin controller, so the model in Clips Tool means to have all the operations to the data.

For example, UserModel can manipulate the user data in the database(or other datasrouce). LoginModel(maybe referenced by UserModel), handles the user's login process.

## Model Reference

Clips Tool suggest that 1 model handles all kind of the operations, for example, LoginModel handles login and logout, it may reference UserModel to get the user data.


So, the code of LoginModel can be something like this:


	/**
	 * @Clips\Model("user")
	 */
	class LoginModel extends DBModel {
		public function login($username, $password) {
			$u = $this->user->getByUserName($username);
			$this->checkPassword($u->password, $password);
		}
	}

Using the IoC support of Clips Tool, the reference of the model can be very easy(and fast, since no matter how many models references the UserModel, the user model will only be intialize once).

## Model is not only about Database

Although you can access the handy methods to access database using DBModel, you can access other datasource in model too.

The class of Clips\Model have nothing dependencies about the database, andy Clips Tool supports multiple datasource configurations. You can use any datasource you want in model(though only database has the best support for version 1.0).
