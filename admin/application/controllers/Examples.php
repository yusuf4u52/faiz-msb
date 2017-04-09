<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	function faiz()
{
	session_start();
		if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('nationalminerals52@gmail.com','mesaifee52@gmail.com','mustukotaliya53@gmail.com','murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','mustafamnr@gmail.com')))
		{

		}else
		 header("Location: http://www.faizstudents.com/users/login.php");

    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('thalilist');

    if ($_SESSION['email'] =='mustukotaliya53@gmail.com')
    {
    $crud->unset_edit();
    $crud->unset_delete();
    $crud->where('Transporter', 'Mustafa Bhai') && $crud->where('Active', '1');
    $crud->columns('Thali','NAME','CONTACT','Active','Transporter','Full_Address');
	}


    $output = $crud->render();
 
    $this->_example_output($output);
}

function notpickedup()
{
	session_start();
		if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('mesaifee52@gmail.com','murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','mustafamnr@gmail.com')))
		{

		}else
		 header("Location: http://www.faizstudents.com/users/login.php");

    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('not_picked_up');

    $output = $crud->render();
 
    $this->_example_output($output);
}

function daily_hisab_items()
{
	session_start();
		if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('bscalcuttawala@gmail.com','mesaifee52@gmail.com','murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','mustafamnr@gmail.com')))
		{

		}else
		 header("Location: http://www.faizstudents.com/users/login.php");

    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('daily_hisab_items');

    $output = $crud->render();
 
    $this->_example_output($output);
}

function daily_menu_count()
{
	session_start();
		if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('bscalcuttawala@gmail.com','mesaifee52@gmail.com','murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','mustafamnr@gmail.com')))
		{

		}else
		 header("Location: http://www.faizstudents.com/users/login.php");

    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('daily_hisab');

    $output = $crud->render();
 
    $this->_example_output($output);
}

function sf_hisab()
{
	session_start();
		if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('bscalcuttawala@gmail.com','mesaifee52@gmail.com','murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','mustafamnr@gmail.com')))
		{

		}else
		 header("Location: http://www.faizstudents.com/users/login.php");

    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('sf_hisab');

    $output = $crud->render();
 
    $this->_example_output($output);
}

function receipts()
{
	session_start();
		if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('nationalminerals52@gmail.com','mesaifee52@gmail.com','bscalcuttawala@gmail.com','murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','mustafamnr@gmail.com')))
		{

		}else
		 header("Location: http://www.faizstudents.com/users/login.php");

    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('receipts');
    $crud->unset_edit();
    if ($_SESSION['email'] =='bscalcuttawala@gmail.com')
    {
    $crud->unset_delete();
	}
    $crud->columns('Receipt_No','Thali_No','name','Amount','Date');

    $output = $crud->render();
 
    $this->_example_output($output);
}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

		
	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}
			
}