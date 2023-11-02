<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_invoice_table extends CI_Migration {

	public function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }


  public function up()
  {
  	$fields = array(
      'invoice_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'null' => FALSE
      ), 
      'contract_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => FALSE
      ), 
      'type_of_invoice_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => FALSE
      ), 
      'invoice_no' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => FALSE
      ), 
      'invoice_date' => array(
        'type' => 'DATE',
        'null' => FALSE
      ), 
      'cis_booking_portal_date' => array(
        'type' => 'DATE',
        'null' => FALSE
      ), 
      'invoice_amount_without_gst' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => FALSE
      ), 
      'gst_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => FALSE
      ), 
      'invoice_amount_with_gst' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
      ), 
      'di_emb_no' => array(
        'type' => 'VARCHAR',
        'constraint' => 30,
        'null' => TRUE
      ), 
      'balance_to_claim' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
      ), 
      'balance_to_pay' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
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

    $this->dbforge->add_key('invoice_id',TRUE);

    $this->dbforge->create_table('invoice',TRUE); 
  }

  public function down()
  {
  	$this->dbforge->drop_table('invoice', TRUE);
  }
}