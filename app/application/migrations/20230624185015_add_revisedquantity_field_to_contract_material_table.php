<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_revisedquantity_field_to_contract_material_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'revised_quantity' => array(
				'type' => 'DECIMAL',
				'constraint' => '7,2',
				'null' => FALSE,
				'after' => 'quantity'
			)
		);

		$this->dbforge->add_column('contract_material', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract_material', 'revised_quantity');
	}
}
?>