<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_vendorname_field_to_material_status_detail_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'vendor_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,
				'after' => 'di_quantity'
			)
		);

		$this->dbforge->add_column('material_status_detail', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('material_status_detail', 'vendor_name');
	}
}