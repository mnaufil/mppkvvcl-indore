<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_inspectionremarks_diremarks_fields_to_material_status_detail_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'inspection_remarks' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE,
				'after' => 'date_of_inspection'
			), 
			'di_remarks' => array(
				'type' => 'VARCHAR', 
				'constraint' => 500,
				'null' => TRUE,
				'after' => 'di_quantity'
			)
		);

		$this->dbforge->add_column('material_status_detail', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('material_status_detail', 'inspection_remarks');
		$this->dbforge->drop_column('material_status_detail', 'di_remarks');
	}
}
?>