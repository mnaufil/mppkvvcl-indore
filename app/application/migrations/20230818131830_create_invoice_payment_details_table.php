<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_invoice_payment_details_table extends CI_Migration {

	public function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }


  public function up()
  {
  	$fields = array(
      'invoice_payment_details_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'null' => FALSE
      ), 
      'invoice_claim_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => FALSE
      ),
      'paid_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => FALSE
      ), 
      'paid_date' => array(
        'type' => 'DATE',
        'null' => FALSE
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

    $this->dbforge->add_key('invoice_payment_details_id',TRUE);

    $this->dbforge->create_table('invoice_payment_details',TRUE); 
  }

  public function down()
  {
  	$this->dbforge->drop_table('invoice_payment_details', TRUE);
  }
}