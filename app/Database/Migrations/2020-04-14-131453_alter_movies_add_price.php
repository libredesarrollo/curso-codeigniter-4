<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMoviesAddPrice extends Migration
{
	public function up()
	{

		$fields = [
			'price' => [
				'type' => 'DECIMAL',
				'constraint' => '10,2',
				'default' => 5.00
			]
		];

		$this->forge->addColumn('movies', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('movies', 'price');
	}
}
