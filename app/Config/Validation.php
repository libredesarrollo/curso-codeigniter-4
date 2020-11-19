<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	public $movies =[
		'title' => 'required|min_length[3]|max_length[255]',
		'description' => 'min_length[3]|max_length[5000]'
	];

	public $categories =[
		'title' => 'required|min_length[3]|max_length[255]'
	];

	public $users =[
		'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
		'email' => 'required|min_length[3]|max_length[20]|is_unique[users.email]',
		'password' => 'required|min_length[5]|max_length[15]'
	];

	public $usersUpdate =[
		'password' => 'required|min_length[5]|max_length[15]'
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		//'list'   => 'CodeIgniter\Validation\Views\list',
		'list'   => 'App\Views\Validations\list_bootstrap',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
