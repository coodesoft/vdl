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


  static function getAll(){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;

    $queryStr = 'SELECT * FROM '. $tablename .' ORDER BY id ASC';
    return $wpdb->get_results($queryStr, ARRAY_A);
  }
}
