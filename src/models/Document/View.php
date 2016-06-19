<?php

namespace BNETDocs\Models\Document;

use \BNETDocs\Libraries\Model;

class View extends Model {

  public $comments;
  public $document;
  public $document_id;
  public $user_session;

  public function __construct() {
    parent::__construct();
    $this->comments     = null;
    $this->document     = null;
    $this->document_id  = null;
    $this->user_session = null;
  }

}