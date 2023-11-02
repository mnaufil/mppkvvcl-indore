<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_mobilisation_type_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'mobilisation_type_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			), 
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE
			), 
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('mobilisation_type_id', TRUE);

		$this->dbforge->create_table('mst_mobilisation_type', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_mobilisation_type', TRUE);
	}
}
?>