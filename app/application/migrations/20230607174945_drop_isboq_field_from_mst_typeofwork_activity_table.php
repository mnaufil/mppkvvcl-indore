<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Drop_isboq_field_from_mst_typeofwork_activity_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->drop_column('mst_typeofwork_activity', 'is_boq');
	}

	public function down()
	{
		$fields = array(
			'is_boq' => array(
				'type' => 'BIT',
				'null' => FALSE,
				'after' => 'multiply_factor'
			)
		);

		$this->dbforge->add_column('mst_typeofwork_activity', $fields);
	}
}


?>