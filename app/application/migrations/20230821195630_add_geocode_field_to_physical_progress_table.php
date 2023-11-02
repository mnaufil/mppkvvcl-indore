<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_geocode_field_to_physical_progress_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'geo_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
				'after' => 'reported_date'
			)
		);

		$this->dbforge->add_column('physical_progress', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('physical_progress', 'geo_code');
	}
}
?>