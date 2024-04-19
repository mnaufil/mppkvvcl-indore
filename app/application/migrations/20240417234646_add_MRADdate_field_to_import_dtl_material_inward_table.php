<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_MRADdate_field_to_import_dtl_material_inward_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'mrad_date' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE,
				'after' => 'received_date'
			),
		);

		$this->dbforge->add_column('import_dtl_material_inward', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('import_dtl_material_inward', 'mrad_date');
	}
}