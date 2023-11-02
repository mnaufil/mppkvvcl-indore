<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_quantity_revisedquantity_unitprice_from_contract_material_log_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'quantity' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => FALSE
			), 
			'revised_quantity' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => FALSE
			),
			'unit_price' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => FALSE
			)
		);

		$this->dbforge->modify_column('contract_material_log', $fields);
	}

	public function down()
	{
		$fields = array(
			'quantity' => array(
				'type' => 'DECIMAL',
				'constraint' => '7,2',
				'null' => FALSE
			), 
			'revised_quantity' => array(
				'type' => 'DECIMAL',
				'constraint' => '7,2',
				'null' => FALSE
			),
			'unit_price' => array(
				'type' => 'DECIMAL',
				'constraint' => '7,2',
				'null' => FALSE
			)
		);

		$this->dbforge->modify_column('contract_material_log', $fields);
	}
}

?>