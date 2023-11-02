<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_system_ref_no_field_to_contract_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'system_ref_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,
				'after' => 'price_bid_opening_date'
			) 
		);

		$this->dbforge->add_column('contract', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract', 'system_ref_no');
	}
}


?>