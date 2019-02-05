<?php

class Schedule{

  const TABLE = 'skm_schedule';

  static function add($value){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;

    $toSave = [
      'event_id'  => $value['event_id'],
      'sunday'    => $value['sunday'],
      'monday'    => $value['monday'],
      'tuesday'   => $value['tuesday'],
      'wednesday' => $value['wednesday'],
      'thursday'  => $value['thursday'],
      'friday'    => $value['friday'],
      'saturday'  => $value['saturday'],
      'timetable' => $value['timetable']
    ];

    $result = $wpdb->insert($tablename, $toSave);
    return $result>0 ? $wpdb->insert_id : 0;
  }

  static function delete($id){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;
    return $wpdb->delete( $tablename, ['id' => $id]);
  }

  static function getAll(){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;

    $queryStr = 'SELECT * FROM '. $tablename .' ORDER BY id ASC';
    return $wpdb->get_results($queryStr, ARRAY_A);
  }

  static function getByDay($name){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;
    $postTable = $wpdb->prefix . 'posts';

    $cols = [
      'mon' => 'monday',
      'tue' => 'tuesday',
      'wed' => 'wednesday',
      'thu' => 'thursday',
      'fri' => 'friday',
      'sat' => 'saturady',
      'sun' => 'sunday',
    ];


    $queryStr = 'SELECT * FROM '. $tablename;
    $queryStr .= ' LEFT JOIN '.$postTable.' ON '.$tablename.'.event_id='.$postTable.'.ID';
    $queryStr .= ' WHERE '.$tablename.'.'.$cols[$name].'=1';
    $query = $wpdb->prepare($queryStr, array($name));
    return $wpdb->get_results($query, ARRAY_A);
  }

  static function getById($id){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;
    $postTable = $wpdb->prefix . 'posts';


    $queryStr = 'SELECT * FROM '. $tablename;
    $queryStr .= ' LEFT JOIN '.$postTable.' ON '.$tablename.'.event_id='.$postTable.'.ID';
    $queryStr .= ' WHERE '.$tablename.'.id=%d';
    $query = $wpdb->prepare($queryStr, array($id));
    return $wpdb->get_results($query, ARRAY_A);
  }

  static function getEventById($event_id){
    return get_post($event_id, ARRAY_A);
  }
}
