<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_auth_token_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'auth_token_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'createddate' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'token' => array(
				'type' => 'varchar',
				'constraint' => 500,
				'null' => FALSE
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('auth_token_id', TRUE);

		$this->dbforge->create_table('auth_token', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('auth_token', TRUE);
	}
}
?>