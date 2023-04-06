<?php

class Printing extends Model
{
  public function datasubmition($date)
  {
    $database = Database::openConnection();
    $year = substr($date, 0, 4);
    $month = substr($date, 4, -2);
    $day = substr($date, 6, 7);

    $newdate = $year . "-" . $month . "-" . $day;

    $query = "SELECT s.*, s1.* FROM data.submission s ";
    $query .= "LEFT JOIN data.smktpk s1 ON s.id = s1.smk_submit_id ";
    $query .= "WHERE s.submition_date = :date";
    $database->prepare($query);
    $database->bindValue(":date", "2023-04-04");
    $database->execute();

    $rows = $database->fetchAllAssociative();

    return $rows;
  }
}