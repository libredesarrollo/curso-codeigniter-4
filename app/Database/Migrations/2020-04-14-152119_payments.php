<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Movies extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'price' => [
				'type' => 'DECIMAL',
				'constraint' => '10,2',
				'default' => 5.00
			],
			'user_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => TRUE
			],
			'e_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => TRUE
			],
			'model'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '10',
			],
			'created_at' => [
				'type'           => 'DATETIME',
			],
			'updated_at' => [
				'type'           => 'DATETIME',
			],
		]);
		$this->forge->addKey('id', TRUE);

		$this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');

		$this->forge->createTable('payments');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('payments');
	}
}
