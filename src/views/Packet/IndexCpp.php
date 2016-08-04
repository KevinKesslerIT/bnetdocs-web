<?php

namespace BNETDocs\Views\Packet;

use \CarlBennett\MVC\Libraries\Common;
use \BNETDocs\Libraries\Exceptions\IncorrectModelException;
use \BNETDocs\Libraries\Model;
use \BNETDocs\Libraries\View;
use \BNETDocs\Models\Packet\Index as PacketIndexModel;

class IndexCpp extends View {

  public function getMimeType() {
    return "text/x-c;charset=utf-8";
  }

  public function render(Model &$model) {
    if (!$model instanceof PacketIndexModel) {
      throw new IncorrectModelException();
    }
    echo "/**\n";
    echo " * BNETDocs: Phoenix\n";
    echo " * Copyright (C) 2003-2016 BNETDocs CC-BY-NC-SA 4.0\n";
    echo " * <" . Common::relativeUrlToAbsolute("/legal") . ">\n";
    echo " *\n";
    echo " * Packet ID constants for C++\n";
    echo " * Generated by BNETDocs on "
      . $model->timestamp->format("r") . "\n";
    echo " */\n\n";
    foreach ($model->packets as $pkt) {
      echo "#define " . $pkt->getPacketName() . " "
        . $pkt->getPacketId(true) . "\n";
    }
  }

}
