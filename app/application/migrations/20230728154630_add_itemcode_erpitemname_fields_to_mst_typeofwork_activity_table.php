<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_itemcode_erpitemname_fields_to_mst_typeofwork_activity_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'item_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,
				'after' => 'multiply_factor'
			), 
			'erp_item_name' => array(
				'type' => 'VARCHAR', 
				'constraint' => 500,
				'null' => TRUE,
				'after' => 'item_code'
			)
		);

		$this->dbforge->add_column('mst_typeofwork_activity', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('mst_typeofwork_activity', 'item_code');
		$this->dbforge->drop_column('mst_typeofwork_activity', 'erp_item_name');
	}
}
?>