<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_discompackageno_field_to_contract_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'discom_package_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 25,
				'null' => TRUE,
				'after' => 'package_group_no'
			)
		);

		$this->dbforge->add_column('contract', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract', 'discom_package_no');
	}
}
?>