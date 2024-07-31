<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_lotno_field_to_tkc_plan_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'lot_no' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'after' => 'to_date'
			)
		);

		$this->dbforge->add_column('tkc_plan', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('tkc_plan', 'lot_no');
	}
}