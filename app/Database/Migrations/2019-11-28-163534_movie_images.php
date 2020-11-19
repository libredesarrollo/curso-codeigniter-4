<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MovieImages extends Migration
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
			'movie_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => TRUE
			],
			'image'       => [
					'type'           => 'VARCHAR',
					'constraint'     => '100',
			]
	]);
	$this->forge->addKey('id', TRUE);
	$this->forge->createTable('movie_images');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('movie_images');
	}
}
