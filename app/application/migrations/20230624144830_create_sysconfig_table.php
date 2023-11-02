<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_sysconfig_table extends CI_Migration {

	public function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }


  public function up()
  {
  	$fields = array(
      'config_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'null' => FALSE
      ), 
      'module' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => FALSE
      ), 
      'display_name' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => FALSE
      ), 
      'fieldvalue' => array(
        'type' => 'VARCHAR',
        'constraint' => 500,
        'null' => FALSE
      ), 
      'datatype' => array(
        'type' => 'VARCHAR',
        'constraint' => 20,
        'null' => FALSE
      ), 
      'length' => array(
        'type' => 'NUMERIC', 
        'constraint' => '9,2',
        'null' => FALSE
      ), 
      'control' => array(
        'type' => 'VARCHAR',
        'constraint' => 20,
        'null' => FALSE
      ), 
      'option' => array(
        'type' => 'VARCHAR',
        'constraint' => 500,
        'null' => TRUE
      )
    );

    $this->dbforge->add_field($fields);

    $this->dbforge->add_key('config_id',TRUE);

    $this->dbforge->create_table('sysconfig',TRUE); 
  }

  public function down()
  {
  	$this->dbforge->drop_table('sysconfig', TRUE);
  }
}