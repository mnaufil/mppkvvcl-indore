<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Modify_contractid_field_from_contract_material_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'contract_id' => array(
				'name' => 'package_group_no',
				'type' => 'INT'
			)
		);

		$this->dbforge->modify_column('contract_material', $fields);
	}

	public function down()
	{
		$fields = array(
			'package_group_no' => array(
				'name' => 'contract_id',
				'type' => 'INT'
			)
		);

		$this->dbforge->modify_column('contract_material', $fields);
	}
}

?>