<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_feedername_feederid_to_contract_location_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'feeder_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
				'after' => 'location_name'
			),
			'feeder_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
				'after' => 'feeder_name'
			)
		);

		$this->dbforge->add_column('contract_location', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract_location', 'feeder_name');
		$this->dbforge->drop_column('contract_location', 'feeder_id');
	}
}
?>