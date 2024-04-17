<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_MRADdate_field_to_material_status_material_received_detail_table extends CI_Migration
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
				'type' => 'DATE',
				'null' => TRUE,
				'after' => 'micc_date'
			),
		);

		$this->dbforge->add_column('material_status_material_received_detail', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('material_status_material_received_detail', 'mrad_date');
	}
}