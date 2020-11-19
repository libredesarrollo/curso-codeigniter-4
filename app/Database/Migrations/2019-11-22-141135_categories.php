<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categories extends Migration
{
	public function up(){
		$this->forge->addField([
			'id'          => [
					'type'           => 'INT',
					'constraint'     => 5,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
			],
			'title'       => [
					'type'           => 'VARCHAR',
					'constraint'     => '255',
			],
	]);
	$this->forge->addKey('id', TRUE);
	$this->forge->createTable('categories');
}

//--------------------------------------------------------------------

public function down()
{
	$this->forge->dropTable('categories');
}
}
