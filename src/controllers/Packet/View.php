<?php

namespace BNETDocs\Controllers\Packet;

use \BNETDocs\Libraries\Comment;
use \BNETDocs\Libraries\Exceptions\PacketNotFoundException;
use \BNETDocs\Libraries\Packet;
use \BNETDocs\Libraries\Product;
use \BNETDocs\Models\Packet\View as PacketViewModel;

use \CarlBennett\MVC\Libraries\Common;
use \CarlBennett\MVC\Libraries\Controller;
use \CarlBennett\MVC\Libraries\Router;
use \CarlBennett\MVC\Libraries\View as ViewLib;

use \DateTime;
use \DateTimeZone;

class View extends Controller {
  public function &run(Router &$router, ViewLib &$view, array &$args) {
    $model            = new PacketViewModel();
    $model->packet_id = array_shift($args);

    try {
      $model->packet  = new Packet($model->packet_id);
    } catch (PacketNotFoundException $e) {
      $model->packet  = null;
    }

    if ($model->packet) {
      $model->comments = Comment::getAll(
        Comment::PARENT_TYPE_PACKET,
        $model->packet_id
      );
      $model->used_by = Product::getProductsFromIds(
        $model->packet->getUsedBy()
      );
    } else {
      $model->used_by = null;
    }

    $view->render($model);
    $model->_responseCode = ($model->packet ? 200 : 404);
    return $model;
  }
}
