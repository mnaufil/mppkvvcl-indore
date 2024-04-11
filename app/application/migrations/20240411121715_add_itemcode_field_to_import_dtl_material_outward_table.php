<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_itemcode_field_to_import_dtl_material_outward_table extends CI_Migration
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
				'after' => 'circle'
			)
		);

		$this->dbforge->add_column('import_dtl_material_outward', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('import_dtl_material_outward', 'item_code');
	}
}