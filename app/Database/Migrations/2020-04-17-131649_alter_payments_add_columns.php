<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPaymentsAddColumns extends Migration
{
	public function up()
	{

		$fields = [
			'payment_id' => [
				'type' => 'VARCHAR',
				'constraint' => '200',
			],
			'type' => [
				'type' => 'ENUM',
				'constraint' => ['paypal','stripe'],
				'default' => 'paypal'
			]
		];

		$this->forge->addColumn('payments', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('payments', 'type');
		$this->forge->dropColumn('payments', 'payment_id');
		//
	}
}
