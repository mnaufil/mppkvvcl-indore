<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_description_field_to_mst_unit_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => 220,
				'null' => TRUE,
				'after' => 'name'
			)
		);

		$this->dbforge->add_column('mst_unit', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('mst_unit', 'description');
	}
}
?>