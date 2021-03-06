<?php

namespace BNETDocs\Models\News;

use \CarlBennett\MVC\Libraries\Model;

class Create extends Model {

  public $acl_allowed;
  public $category;
  public $content;
  public $csrf_id;
  public $csrf_token;
  public $error;
  public $markdown;
  public $news_categories;
  public $rss_exempt;
  public $title;
  public $user;

}
