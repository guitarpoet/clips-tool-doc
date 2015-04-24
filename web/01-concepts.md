# Web Development - Concepts

## The MVC Concepts Of Web Development Using Clips Tool

The web application using [Clips Tool](http://github.com/guitarpoet/clips-tool/) is based on the [MVC](http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)pattern.

Nearly all web frameworks agree with this pattern.

In Clips Tool, MVC can be break into 3 parts:

1. Model: Where the domain object operation should be done. Clips Tool support [DAO]() and [DO]() pattern by default. The model in Clips Tool is the service component that provides DAO(Data Access Object) and DS(Domain Service) services
2. Controller: The Controller in Clips Tool is just a facade open to Http Requests. I suggest to write controllers as *thin* as possible. How thin a controller should be? There is no standards about that, but I suggest that all controller's method code should show in one screen without scrolling, since controller can access session and request(and cookies) quite easily, so, the best place to write the manipulate code for these is at the controller
3. View: The view for Clips Tool stands for the template engine. Clips Tool provides at least 2 kind of template engines to support the web development. one is handlebars(the default template engine), the other is smarty(the default view render engine).
