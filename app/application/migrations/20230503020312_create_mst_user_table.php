<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_mst_user_table extends CI_Migration {

 public function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }

   public function up()
  {
  	$fields = array(
      'user_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'null' => FALSE
      ),
      'username' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => FALSE
      ),
      'email' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => FALSE
      ),
      'password' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => FALSE
      ),
      'contact_no' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => TRUE
      ),
      'designation' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => TRUE
      ),
      'location' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => TRUE
      ),
      'reportingto_user_id' => array(
        'type' => 'INT',
        'constraint' => 10,
        'null' => TRUE
      ),
      'role_id' => array(
        'type' => 'INT',
        'constraint' => 10,
        'null' => FALSE
      ),
      'is_full_data_access' => array(
        'type' => 'BIT',
        'null' => FALSE
      ),
      'is_active' => array(
        'type' => 'BIT',
        'null' => FALSE
      ),
      'createdby' => array(
        'type' => 'INT',
        'constraint' => 10,
        'null' => FALSE
      ),
      'createddate' => array(
        'type' => 'DATETIME',
        'null' => FALSE
      ),
      'modifiedby' => array(
        'type' => 'INT',
        'constraint' => 10,
        'null' => TRUE
      ),
      'modifieddate' => array(
        'type' => 'DATETIME',
        'null' => TRUE
      ),
      'deletedby' => array(
        'type' => 'INT',
        'constraint' => 10,
        'null' => TRUE
      ),
      'deleteddate' => array(
        'type' => 'DATETIME',
        'null' => TRUE
      )      


    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('user_id',TRUE);
   // $this->dbforge->add_key('username');
    $this->dbforge->create_table('mst_user',TRUE); 
  }

  public function down()
  {
    $this->dbforge->drop_table('mst_user', TRUE);
  }


}