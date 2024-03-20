<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_isinrange_field_to_tkc_physical_progress_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'is_inrange' => array(
				'type' => 'BIT',
				'null' => TRUE,
				'after' => 'geo_code'
			)
		);

		$this->dbforge->add_column('tkc_physical_progress', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('tkc_physical_progress', 'is_inrange');
	}
}
?>