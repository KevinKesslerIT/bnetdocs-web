<?php

namespace BNETDocs\Libraries;

use \CarlBennett\MVC\Libraries\Common;
use \CarlBennett\MVC\Libraries\Database;
use \CarlBennett\MVC\Libraries\DatabaseDriver;
use \PDO;
use \PDOException;

class Credits {

  public static function &getTotalUsers($no_cache = false) {
    $cache_key = "bnetdocs-credits-totalusers";
    $cache_val = Common::$cache->get($cache_key);
    if (!$no_cache && $cache_val !== false) {
      $cache_val = (int) $cache_val;
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT COUNT(*) AS `sum` FROM `users`;
    ");
    $stmt->execute();
    $obj = $stmt->fetch(PDO::FETCH_OBJ);
    $stmt->closeCursor();
    $sum = (int) $obj->sum;
    Common::$cache->set($cache_key, $sum, 300);
    return $sum;
  }

  public function &getTopContributorsByDocuments() {
    $cache_key = "bnetdocs-credits-documents";
    $cache_val = Common::$cache->get($cache_key);
    if ($cache_val !== false) {
      $cache_val = unserialize($cache_val);
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT
        `u`.`id` AS `user_id`,
        IFNULL(
          IFNULL(`u`.`display_name`, `u`.`username`),
          'Anonymous'
        ) AS `name`,
        COUNT(`d`.`id`) AS `documents_authored`
      FROM
        `users` AS `u`
      RIGHT JOIN
        `documents` AS `d` ON `d`.`user_id` = `u`.`id`
      GROUP BY
        `u`.`id`
      ORDER BY
        `documents_authored` DESC,
        `d`.`created_datetime` ASC
      LIMIT 5;
    ");
    $stmt->execute();
    $result = new \SplObjectStorage();
    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
      $result->attach($obj);
    }
    $stmt->closeCursor();
    Common::$cache->set($cache_key, serialize($result), 300);
    return $result;
  }

  public function &getTopContributorsByNewsPosts() {
    $cache_key = "bnetdocs-credits-newsposts";
    $cache_val = Common::$cache->get($cache_key);
    if ($cache_val !== false) {
      $cache_val = unserialize($cache_val);
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT
        `u`.`id` AS `user_id`,
        IFNULL(
          IFNULL(`u`.`display_name`, `u`.`username`),
          'Anonymous'
        ) AS `name`,
        COUNT(`n`.`id`) AS `news_posts_created`
      FROM
        `users` AS `u`
      RIGHT JOIN
        `news_posts` AS `n` ON `n`.`user_id` = `u`.`id`
      GROUP BY
        `u`.`id`
      ORDER BY
        `news_posts_created` DESC,
        `n`.`created_datetime` ASC
      LIMIT 5;
    ");
    $stmt->execute();
    $result = new \SplObjectStorage();
    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
      $result->attach($obj);
    }
    $stmt->closeCursor();
    Common::$cache->set($cache_key, serialize($result), 300);
    return $result;
  }

  public function &getTopContributorsByPackets() {
    $cache_key = "bnetdocs-credits-packets";
    $cache_val = Common::$cache->get($cache_key);
    if ($cache_val !== false) {
      $cache_val = unserialize($cache_val);
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT
        `u`.`id` AS `user_id`,
        IFNULL(
          IFNULL(`u`.`display_name`, `u`.`username`),
          'Anonymous'
        ) AS `name`,
        COUNT(`p`.`id`) AS `packets_authored`
      FROM
        `users` AS `u`
      RIGHT JOIN
        `packets` AS `p` ON `p`.`user_id` = `u`.`id`
      GROUP BY
        `u`.`id`
      ORDER BY
        `packets_authored` DESC,
        `p`.`created_datetime` ASC
      LIMIT 5;
    ");
    $stmt->execute();
    $result = new \SplObjectStorage();
    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
      $result->attach($obj);
    }
    $stmt->closeCursor();
    Common::$cache->set($cache_key, serialize($result), 300);
    return $result;
  }

  public function &getTopContributorsByServers() {
    $cache_key = "bnetdocs-credits-servers";
    $cache_val = Common::$cache->get($cache_key);
    if ($cache_val !== false) {
      $cache_val = unserialize($cache_val);
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT
        `u`.`id` AS `user_id`,
        IFNULL(
          IFNULL(`u`.`display_name`, `u`.`username`),
          'Anonymous'
        ) AS `name`,
        COUNT(`s`.`id`) AS `servers_owned`
      FROM
        `users` AS `u`
      RIGHT JOIN
        `servers` AS `s` ON `s`.`user_id` = `u`.`id`
      GROUP BY
        `u`.`id`
      ORDER BY
        `servers_owned` DESC,
        `s`.`created_datetime` ASC
      LIMIT 5;
    ");
    $stmt->execute();
    $result = new \SplObjectStorage();
    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
      $result->attach($obj);
    }
    $stmt->closeCursor();
    Common::$cache->set($cache_key, serialize($result), 300);
    return $result;
  }

  public static function getTotalDocumentsByUserId($user_id) {
    $cache_key = "bnetdocs-credits-documentsbyuserid-" . (int) $user_id;
    $cache_val = Common::$cache->get($cache_key);
    if ($cache_val !== false) {
      $cache_val = (int) $cache_val;
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT COUNT(*) AS `sum` FROM `documents` WHERE `user_id` = :id;
    ");
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $obj = $stmt->fetch(PDO::FETCH_OBJ);
    $stmt->closeCursor();
    Common::$cache->set($cache_key, $obj->sum, 300);
    return (int) $obj->sum;
  }

  public static function getTotalNewsPostsByUserId($user_id) {
    $cache_key = "bnetdocs-credits-newspostsbyuserid-" . (int) $user_id;
    $cache_val = Common::$cache->get($cache_key);
    if ($cache_val !== false) {
      $cache_val = (int) $cache_val;
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT COUNT(*) AS `sum` FROM `news_posts` WHERE `user_id` = :id;
    ");
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $obj = $stmt->fetch(PDO::FETCH_OBJ);
    $stmt->closeCursor();
    Common::$cache->set($cache_key, $obj->sum, 300);
    return (int) $obj->sum;
  }

  public static function getTotalPacketsByUserId($user_id) {
    $cache_key = "bnetdocs-credits-packetsbyuserid-" . (int) $user_id;
    $cache_val = Common::$cache->get($cache_key);
    if ($cache_val !== false) {
      $cache_val = (int) $cache_val;
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT COUNT(*) AS `sum` FROM `packets` WHERE `user_id` = :id;
    ");
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $obj = $stmt->fetch(PDO::FETCH_OBJ);
    $stmt->closeCursor();
    Common::$cache->set($cache_key, $obj->sum, 300);
    return (int) $obj->sum;
  }

  public static function getTotalServersByUserId($user_id) {
    $cache_key = "bnetdocs-credits-serversbyuserid-" . (int) $user_id;
    $cache_val = Common::$cache->get($cache_key);
    if ($cache_val !== false) {
      $cache_val = (int) $cache_val;
      return $cache_val;
    }
    if (!isset(Common::$database)) {
      Common::$database = DatabaseDriver::getDatabaseObject();
    }
    $stmt = Common::$database->prepare("
      SELECT COUNT(*) AS `sum` FROM `servers` WHERE `user_id` = :id;
    ");
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $obj = $stmt->fetch(PDO::FETCH_OBJ);
    $stmt->closeCursor();
    Common::$cache->set($cache_key, $obj->sum, 300);
    return (int) $obj->sum;
  }

}
