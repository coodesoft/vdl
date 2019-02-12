<?php


class Radios{

  const TABLE = 'skm_radios';

  static function add($value){
    global $wpdb;
    $table = $wpdb->prefix . self::TABLE;

    $result = $wpdb->insert( $table, ['radio' => $value], ['%s'] );
    return $result>0 ? $wpdb->insert_id : 0;
  }

  static function edit($id, $value){
    global $wpdb;
    $table = $wpdb->prefix . self::TABLE;

    $result = $wpdb->update( $table, ['radio' => $value], ['id' => $id], ['%s'], ['%d'] );
    return $result>0 ? $id : 0;
  }

  static function delete($id){
    global $wpdb;
    $table = $wpdb->prefix . self::TABLE;

    return $wpdb->delete( $table, ['id' => $id], ['%d'] );
  }

  static function getAll(){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;

    $queryStr = 'SELECT * FROM '. $tablename .' ORDER BY id ASC';
    return $wpdb->get_results($queryStr, ARRAY_A);
  }

  static function getById($id){
    global $wpdb;
    $table = $wpdb->prefix . self::TABLE;

    $queryStr = 'SELECT * FROM '. $table .' WHERE '.$table.'.id=%d';

    $query = $wpdb->prepare($queryStr, array($id));
    return $wpdb->get_results($query, ARRAY_A);
  }

}
