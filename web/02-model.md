# Web Development - Model

## The Concept of Model in Clips Tool

Different with Java's Blueprints. Clips Tool's model will be [DAO](http://en.wikipedia.org/wiki/Data_access_object) and [Service]() altogether.

So, the features of Clips Tool should list as below:

1. CRUD Operations for DataObjects: All the basic data operations for the DataObjects as foundation
2. Domain Operations for DataObjects: For example, register, login, logout, add item to shopping cart, any method that can be describe using domain language
3. Transaction Operations: The domain operations that should using transaction management

## A Simple Model

Here is a simple example code of model:

	<?php namespace Demo\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");
	

	use Clips\Model;
	
	/**
	 * @Clips\Model
	 */
	class UserModel extends Model {

	}

## Data Source

Though you can use model to do any operation you want to access the data layer. Clips Tool provides the data source support for aid you to manipulate the data sources.

DataSource in Clips Tool, is like a operation facade of collection of data objects, you can manipulating the data objects using the function DataSource provides to you.

Clips Tool now only supports 1 data source, MySQLiDataSource, and will try to support as many datasource as possible in the future.

The DataSource, in Clips Tool, must provide these functions:

* Query: You can use a query string and an array of args to query the datasource for the results
* Insert: You can insert an object into the datasource
* Update: You can update the object in datasource using its id
* Delete: You can delete the objects in datasource using their ids
* Fetch: You can fetch the data in datasource using simple object query

### The Context of DataSource

Since the concept of DataSource is a facade of collection of data objects, what kind of objects is the metadata of the DataSource.

Each DataSource can have a context, so that it can know, which data collection to be focus to.

For example, in a Database DataSource, the context can be the table name. So that when you trying to insert the object, DataSource will know which table to insert that object to.

In a Solr DataSource, the context can be the collection, since same documents in the same collection shared the same schema.

## DataBase Model

Since most of the model's function is basic CRUD operation on DataBase and the higher level operation above that, Clips Tool provides a parent class for all the DataBase model.

The DBModel is based on a rule based SQL generation framework(only support MySQL5 now). So you can use the function like this to query the DataBase:

	$this->select('id, username as name, password')->from('users')->where(array('username' => 'jack'))->result();

And get the query result.


## More about SQL generation

The SQL generation function is much like [CI](http://codeigniter.com)'s ActiveRecord, but in a more pleasant way, here is another example of the function of DBModel to generate SQL.

	$this->select('count(*) as user_count, groups.name as group_name')->from('users')
		->join('groups', array('users.group_id' => 'groups.id'), 'left')
		->groupBy('users.group_id')
		->orderBy('users.id')->one();

The SQL generated will honor the table prefix in the settings, so, if you have set the table prefix to 'demo_' in the configuration, the sql generated will be:

	select count(*) from user_count, groups.name as group_name from demo_users as users left join demo_groups as groups on users.group_id = groups.id group by users.group_id order by users.id

## Base CRUD Operations

Since most the model should provide the basic CRUD operations for DataObjects. It is better to let them inheired them from a super class, and that super class is DBModel.

DBModel provides the basic operations function like:

* Insert: Insert array or object to DB
* Update: Update array or object based on it's id
* Load: Load the object from DB using its id
* Delete: Delete the objects using their ids

So, if you want to do operations like that, you didn't need to run the query manually, just use the method DBModel provides.

But, there is some catch for this, list as below:

### Clean Fields

In most of the time, insert or update can be dangerous if you didn't clean the object before run the insert of update method.

Since DBModel won't know much about the table it should insert or update the object data with, so, if there is other fields that in the object didn't defined in database(php is dynamic, you know, you really can't controller what field is there before you get the object), you'll get an error(field not exists) trying to do the insert or update.

So, why don't DBModel just get the metadata of the table from DataBase and filter the additional fields out of the insert or update query?

It is for the efficiency, DBModel won't check for the metadata by default for better performance, but this will sacrifice the safety of the method, so DBModel provides a method called cleanFields to do this.

If you really want to filter the additional fields out of the update or insert object for safety, be sure to call this method.
