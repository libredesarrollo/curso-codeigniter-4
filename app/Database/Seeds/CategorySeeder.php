<?php namespace App\Database\Seeds;

class CategorySeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {

            $this->db->table('categories')->where('id >',1)->delete();


                for ($i=1; $i <= 20; $i++) { 
                    $data = [
                        'title' => "Categoría $i"
                    ];
                    $this->db->table('categories')->insert($data);
                }

                
        }
}