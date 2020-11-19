<?php namespace App\Database\Seeds;

class MovieSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {

            $this->db->table('movies')->where('id >',1)->delete();

     

                // Simple Queries
                // $this->db->query("INSERT INTO movies (title, description) VALUES(:title:, :description:)",
                //         $data
                // );

                // Using Query Builder

                for ($i=1; $i <= 20; $i++) { 
                    $data = [
                        'title' => "Movie $i",
                        'category_id' =>  $i,
                        'description'    => 'Database seeding is a simple way to add data into your database. It is especially useful during development where you need to populate the database with sample data that you can develop against, but it is not limited to that. Seeds can contain static data that you don’t want to include in a migration, like countries, or geo-coding tables, event or setting information, and more.'
                    ];
                    $this->db->table('movies')->insert($data);
                }

                
        }
}