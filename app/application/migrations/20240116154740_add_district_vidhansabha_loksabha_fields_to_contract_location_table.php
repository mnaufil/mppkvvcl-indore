<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_district_vidhansabha_loksabha_fields_to_contract_location_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'district' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
				'after' => 'division_id'
			),
			'vidhansabha' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
				'after' => 'district'
			),
			'loksabha' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
				'after' => 'vidhansabha'
			)
		);

		$this->dbforge->add_column('contract_location', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract_location', 'district');
		$this->dbforge->drop_column('contract_location', 'vidhansabha');
		$this->dbforge->drop_column('contract_location', 'loksabha');
	}
}
?>