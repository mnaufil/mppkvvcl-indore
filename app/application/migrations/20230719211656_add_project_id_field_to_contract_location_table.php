<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_project_id_field_to_contract_location_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'project_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,
				'after' => 'feeder_id'
			) 
		);

		$this->dbforge->add_column('contract_location', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract_location', 'project_id');
	}
}


?>