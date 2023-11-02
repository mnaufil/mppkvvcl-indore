<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_accesskey_field_from_mst_report_access_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'access_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE
			)
		);

		$this->dbforge->modify_column('mst_report_access', $fields);
	}

	public function down()
	{
		$fields = array(
			'access_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE
			)	
		);

		$this->dbforge->modify_column('mst_report_access', $fields);
	}
}


?>