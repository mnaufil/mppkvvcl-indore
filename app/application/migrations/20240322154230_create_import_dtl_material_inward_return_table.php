<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_import_dtl_material_inward_return_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'import_material_in_return_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'import_hdr_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'lot_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'circle' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'material_description' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'unit' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'name_of_vendor' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'di_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'di_date' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'di_quantity' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'received_quantity' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'received_date' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'returned_quantity' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'returned_date' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'error_message' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'is_valid' => array(
				'type' => 'BIT',
				'null' => TRUE
			),
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE
			),
			'createdby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'createddate' => array(
				'type' => 'DATETIME',
				'null' => FALSE
			),
			'modifiedby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'modifieddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'deletedby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'deleteddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('import_material_in_return_id', TRUE);

		$result = $this->dbforge->create_table('import_dtl_material_inward_return', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('import_dtl_material_inward_return', TRUE);
	}
}

?>