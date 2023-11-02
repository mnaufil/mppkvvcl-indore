<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_contractoremail_field_to_contract_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'contractor_email' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
				'after' => 'contractor_name'
			)
		);

		$this->dbforge->add_column('contract', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract', 'contractor_email');
	}
}
?>