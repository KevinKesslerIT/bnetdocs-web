<?php

namespace BNETDocs\Models\Comment;

use \CarlBennett\MVC\Libraries\Model;

class Delete extends Model {

  public $acl_allowed;
  public $comment;
  public $csrf_id;
  public $csrf_token;
  public $error;
  public $id;
  public $parent_id;
  public $parent_type;
  public $user;

}
