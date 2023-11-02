<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_mrcgeneratedno_mrcgenerateddate_fields_from_material_status_detail_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'mrc_generated_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE
			),
			'mrc_generated_date' => array(
				'type' => 'DATE',
				'null' => TRUE
			) 
		);

		$this->dbforge->modify_column('material_status_detail', $fields);
	}

	public function down()
	{
		$fields = array(
			'mrc_generated_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE
			),
			'mrc_generated_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			)
		);

		$this->dbforge->modify_column('material_status_detail', $fields);
	}
}


?>