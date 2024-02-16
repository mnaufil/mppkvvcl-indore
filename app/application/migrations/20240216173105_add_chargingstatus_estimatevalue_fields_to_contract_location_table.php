<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_chargingstatus_estimatevalue_fields_to_contract_location_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'charging_status' => array(
				'type' => 'VARCHAR',
				'constraint' => 25,
				'null' => TRUE,
				'after' => 'geo_code'
			),
			'estimate_value' => array(
				'type' => 'DECIMAL',
				'constraint' => '18,2',
				'null' => TRUE,
				'after' => 'charging_status'
			)
		);

		$this->dbforge->add_column('contract_location', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract_location', 'charging_status');
		$this->dbforge->drop_column('contract_location', 'estimate_value');
	}
}
?>