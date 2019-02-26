<?php

class Schedule{

  const TABLE = 'skm_schedule';

  static function getCols(){
    return [
      'mon' => 'monday',
      'tue' => 'tuesday',
      'wed' => 'wednesday',
      'thu' => 'thursday',
      'fri' => 'friday',
      'sat' => 'saturady',
      'sun' => 'sunday',
    ];
  }

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
      'begin_time' => $value['begin_time'],
      'end_time' => $value['end_time'],
      'radio_id' => $value['radio_id']
    ];

    $result = $wpdb->insert($tablename, $toSave);
    return $result>0 ? $wpdb->insert_id : 0;
  }

  static function delete($id){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;
    return $wpdb->delete( $tablename, ['id' => $id]);
  }

  static function edit($id, $value){
    global $wpdb;
    $table = $wpdb->prefix . self::TABLE;

    $toSave = [
      'event_id'  => $value['event_id'],
      'sunday'    => $value['sunday'],
      'monday'    => $value['monday'],
      'tuesday'   => $value['tuesday'],
      'wednesday' => $value['wednesday'],
      'thursday'  => $value['thursday'],
      'friday'    => $value['friday'],
      'saturday'  => $value['saturday'],
      'begin_time' => $value['begin_time'],
      'end_time' => $value['end_time'],
      'radio_id' => $value['radio_id']
    ];

    $result = $wpdb->update( $table, $toSave, ['schedule_id' => $id]);
    return $result>0 ? $id : 0;
  }
   
  static function getAll(){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;
    $postTable = $wpdb->prefix . 'posts';
    $radiosTable = $wpdb->prefix . Radios::TABLE;

    $queryStr = 'SELECT * FROM '. $tablename;
    $queryStr .= ' LEFT JOIN '.$radiosTable.' ON '.$tablename.'.radio_id='.$radiosTable.'.id';
    $queryStr .= ' LEFT JOIN '.$postTable.' ON '.$tablename.'.event_id='.$postTable.'.ID';
    $queryStr .= ' ORDER BY schedule_id ASC';
    return $wpdb->get_results($queryStr, ARRAY_A);
  }

  static function getByDay($name){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;
    $postTable = $wpdb->prefix . 'posts';

    $cols = self::getCols();

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
    $radiosTable = $wpdb->prefix . Radios::TABLE;


    $queryStr = 'SELECT * FROM '. $tablename;
    $queryStr .= ' LEFT JOIN '.$radiosTable.' ON '.$tablename.'.radio_id='.$radiosTable.'.id';
    $queryStr .= ' LEFT JOIN '.$postTable.' ON '.$tablename.'.event_id='.$postTable.'.ID';
    $queryStr .= ' WHERE '.$tablename.'.schedule_id=%d';
    $query = $wpdb->prepare($queryStr, array($id));
    return $wpdb->get_results($query, ARRAY_A);
  }

  static function getByRadioAndDay($radio, $day){
    global $wpdb;
    $tablename = $wpdb->prefix . self::TABLE;
    $postTable = $wpdb->prefix . 'posts';
    $radiosTable = $wpdb->prefix . Radios::TABLE;

    $cols = self::getCols();

    $queryStr  = 'SELECT * FROM '. $tablename;
    $queryStr .= ' LEFT JOIN '.$radiosTable.' ON '.$tablename.'.radio_id='.$radiosTable.'.id';
    $queryStr .= ' LEFT JOIN '.$postTable.' ON '.$tablename.'.event_id='.$postTable.'.ID';
    $queryStr .= ' WHERE '.$radiosTable.'.id=%d AND '.$tablename.'.'.$cols[$day].'=1';

    $query = $wpdb->prepare($queryStr, array($radio));

    return $wpdb->get_results($query, ARRAY_A);
  }

  static function getEventById($event_id){
    return get_post($event_id, ARRAY_A);
  }

}
