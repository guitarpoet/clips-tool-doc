# Base Concepts - Migration

## The Concept of Migration in Clips Tool

Clips Tool used [Phinx](http://phinx.org/) to do the migration but in a better way.

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


Better?
