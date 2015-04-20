# Base Concepts - Migration

## The Concept of Migration in Clips Tool

Clips Tool used [Phinx](http://phinx.org/) to do the migration but in a better way.

For Clips Tool, you'll write all your metadata of Schema in a [YAML](http://yaml.org/) document, Clips Tool's AbstractMigrations will read this to perform the up and down migration, and the scaffold generator will take advantage of this configuration too.

## How to use migration in Clips Tool
Here is the phinx version of the migration:

	<?php

	use Phinx\Migration\AbstractMigration;

	class CreateUserLoginsTable extends AbstractMigration
	{
		/**
		 * Change Method.
		 *
		 * More information on this method is available here:
		 * http://docs.phinx.org/en/latest/migrations.html#the-change-method
		 *
		 * Uncomment this method if you would like to use it.
		 */
		public function change()
		{
			// create the table
			$table = $this->table('user_logins');
			$table->addColumn('user_id', 'integer')
				  ->addColumn('created', 'datetime')
				  ->create();
		}

		/**
		 * Migrate Up.
		 */
		public function up()
		{

		}

		/**
		 * Migrate Down.
		 */
		public function down()
		{

		}
	}

and this is the Clips Tool's version:

	<?php

	use Clips\Libraries\AbstractMigration;

	class Sample extends AbstractMigration {
	}



And the data in sample.yml:

	user_logins:
		user_id:
			label: User ID
			key: true
		created:
			label: Created
			type: datetime
			options:
				'null': true


Seems better?

To run the migration, just went to your application's folder, and run this command:

	./vendor/bin/clips phinx migrate

## The details of YAML schema definitions

Let's take a detail look at the YAML schema configuration.

Here is the sample schema configuration:

	user_logins:
		user_id:
			label: User ID
			key: true
		created:
			label: Created
			type: datetime
			options:
				'null': true

The root element of configuration(user_logins in this example), is table name. It means migration will create a new table using this name(prefixed with the configuration though).

The collection under tables name, is the columns configurtations. For version 1.0, Clips Tool supports these options:

* label: The label presentation for this column, this will have nothing to do with the database, but will affect the form and pagination part for scaffolding
* refer: Tell the migration that this column will represents the table when other tables are referencing it, this is useless for migration, but it will fits for pagination
* key: Tell the migration that this column is a key(only support single key for version 1.0)
* foreign_key: Tell the migration that this columns is a foreign key, the value must be the table this foreign key references, only support foreign id references for version 1.0
* type: The type of this column, support all the types that [phinx](http://docs.phinx.org/en/latest/migrations.html#working-with-tables) supports
* options: The options of the column, support all the options that [phinx](http://docs.phinx.org/en/latest/migrations.html#valid-column-options) needed
* rules: This has nothing to do with migration, but will apply for form validation for this table, the validation rules will apply for client and server side of form validation

## What if my schema is quite complex?

As for version 1.0 of Clips Tool, the function of schema only supports very small features of phinx, so, if you really want to write more complex migration, I suggest you just use phnix's migration base class, and use MigrationTool in library to aid you.

## How to create a new migration?

By using phinx's command:

	./vendor/bin/clips phinx create
