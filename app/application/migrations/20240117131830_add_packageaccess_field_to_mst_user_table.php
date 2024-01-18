<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_packageaccess_field_to_mst_user_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'package_access' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
				'after' => 'is_full_data_access'
			)
		);

		$this->dbforge->add_column('mst_user', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('mst_user', 'package_access');
	}
}
?>