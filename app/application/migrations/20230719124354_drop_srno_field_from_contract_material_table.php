<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Drop_srno_field_from_contract_material_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->drop_column('contract_material', 'sr_no');
	}

	public function down()
	{
		$fields = array(
			'sr_no' => array(
				'type' => 'INT',
				'null' => FALSE,
				'after' => 'contract_id'
			)
		);

		$this->dbforge->add_column('contract_material', $fields);
	}
}


?>