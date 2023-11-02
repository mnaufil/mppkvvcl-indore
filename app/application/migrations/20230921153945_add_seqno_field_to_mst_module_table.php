<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_seqno_field_to_mst_module_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'seqno' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'icon'
			)
		);

		$this->dbforge->add_column('mst_module', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('mst_module', 'seqno');
	}
}
?>