<?php

class Elements extends Model
{
  public function dateFormat($date)
  {
    if ($date == null) {
      $date = "-";
    } else {
      $date = date("d/m/Y", strtotime($date));
    }
    return $date;
  }

  public function checkNull($data)
  {
    if ($data == null || $data == "undefined") {
      return "-";
    } else {
      return $data;
    }
  }

  public function referencetable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $database = Database::openConnection();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "CAST(f.noakaun AS TEXT) = '" . $searchValue . "' OR h.adpg1 LIKE '%" . $searchValue . "%' OR h.adpg2 LIKE '%" . $searchValue . "%' OR h.adpg3 LIKE '%" . $searchValue . "%' OR h.adpg4 LIKE '%" . $searchValue . "%' OR h2.bgn_bnama = '" . $searchValue . "'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.reff f ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.reff f ";
    $sql .= "LEFT JOIN data.hvnduk h on f.noakaun = h.peg_akaun ";
    $sql .= "INNER JOIN data.hbangn h2 on h.peg_jpkod = h2.bgn_bgkod ";
    if ($searchValue != "") {
      $sql .= "WHERE " . $searchQuery;
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT f.*, h.adpg1, h.adpg2, h.adpg3, h.adpg4, h2.bgn_bnama FROM data.reff f ";
    $query .= "LEFT JOIN data.hvnduk h on f.noakaun = h.peg_akaun ";
    $query .= "INNER JOIN data.hbangn h2 on h.peg_jpkod = h2.bgn_bgkod ";
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
    $database->prepare($query);
    $database->execute();

    $rows = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {
      $rowOutput["id"] = $val["id"];
      $rowOutput["noakaun"] = $val["noakaun"];
      $rowOutput["nolot"] = $val["nolot"];
      $rowOutput["keluasan"] = $val["keluasan"];
      $rowOutput["hargasmp"] = $val["hargasmp"];
      $rowOutput["nilaitahunan"] = $val["nilaitahunan"];
      $rowOutput["adpg1"] = $val["adpg1"];
      $rowOutput["adpg2"] = $val["adpg2"];
      $rowOutput["adpg3"] = $val["adpg3"];
      $rowOutput["adpg4"] = $val["adpg4"];
      $rowOutput["bgn_bnama"] = $val["bgn_bnama"];
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;

    // $dbOracle->closeOciConnection();
  }

  public function meetingtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "CAST(f.noakaun AS TEXT) = '" . $searchValue . "' OR h.adpg1 LIKE '%" . $searchValue . "%' OR h.adpg2 LIKE '%" . $searchValue . "%' OR h.adpg3 LIKE '%" . $searchValue . "%' OR h.adpg4 LIKE '%" . $searchValue . "%' OR h2.bgn_bnama = '" . $searchValue . "'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_HMMACM v ";
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);
    $records = $dbOracle->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_HMMACM v ";
    if ($searchValue != "") {
      $sql .= "WHERE " . $searchQuery;
    }
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);

    $records = $dbOracle->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT MCM_BLNGN, MCM_TKHPL, MCM_BULAN, MCM_KKRJA, MCM_STATF, MCM_TKHTK, ";
    $query .= "CASE MCM_BULAN ";
    $query .= "WHEN '01' THEN 'JANUARI' WHEN '02' THEN 'FEBRUARI' WHEN '03' THEN 'MAC' WHEN '04' THEN 'APRIL' WHEN '05' THEN 'MEI' WHEN '06' THEN 'JUN' ";
    $query .= "WHEN '07' THEN 'JULAI' WHEN '08' THEN 'OGOS' WHEN '09' THEN 'SEPTEMBER' WHEN '10' THEN 'OKTOBER' WHEN '11' THEN 'NOVEMBER' WHEN '12' THEN 'DECEMBER' ";
    $query .= "END eld3 ";
    $query .= "FROM ( SELECT tmp.*, rownum rn ";
    $query .= "FROM( SELECT * FROM SPMC.V_HMMACM v ";
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= ") tmp ";
    $query .= "WHERE rownum <= " . (int) ($row + $rowperpage) . " ) h ";
    $query .= "WHERE rn > " . (int) $row;
    $dbOracle->prepare($query);
    $dbOracle->execute();

    $rows = $dbOracle->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {
      $rowOutput["mcm_blngn"] = $val["mcm_blngn"];
      $rowOutput["mcm_tkhpl"] = $this->dateFormat($val["mcm_tkhpl"]);
      $rowOutput["mcm_tkhtk"] = $this->dateFormat($val["mcm_tkhtk"]);
      $rowOutput["mcm_kkrja"] = $val["mcm_kkrja"];
      $rowOutput["mcm_statf"] = $val["mcm_statf"];
      $rowOutput["mcm_bulan"] = $val["mcm_bulan"];
      $rowOutput["eld3"] = $val["eld3"];
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;

    $dbOracle->closeOciConnection();
  }

  public function streettable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "v.acm_sbktr LIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_MKWJLN v ";
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);
    $records = $dbOracle->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_MKWJLN v ";
    if ($searchValue != "") {
      $sql .= "WHERE " . $searchQuery;
    }
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);

    $records = $dbOracle->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT jln_jlkod, kws_kwkod, kws_knama, jln_jnama, jln_poskd ";
    $query .= "FROM ( SELECT tmp.*, rownum rn ";
    $query .= "FROM( SELECT * FROM SPMC.V_MKWJLN v ";
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= ") tmp ";
    $query .= "WHERE rownum <= " . (int) ($row + $rowperpage) . " ) h ";
    $query .= "WHERE rn > " . (int) $row;
    $dbOracle->prepare($query);
    $dbOracle->execute();

    $rows = $dbOracle->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {
      $rowOutput["jln_jlkod"] = $val["jln_jlkod"];
      $rowOutput["kws_kwkod"] = $val["kws_kwkod"];
      $rowOutput["kws_knama"] = $val["kws_knama"];
      $rowOutput["jln_jnama"] = $val["jln_jnama"];
      $rowOutput["jln_poskd"] = $val["jln_poskd"];
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;

    $dbOracle->closeOciConnection();
  }

  public function reasontable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "v.acm_sbktr LIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_ACMRSN v ";
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);
    $records = $dbOracle->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_ACMRSN v ";
    if ($searchValue != "") {
      $sql .= "WHERE " . $searchQuery;
    }
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);

    $records = $dbOracle->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * ";
    $query .= "FROM ( SELECT tmp.*, rownum rn ";
    $query .= "FROM( SELECT * FROM SPMC.V_ACMRSN v ";
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= ") tmp ";
    $query .= "WHERE rownum <= " . (int) ($row + $rowperpage) . " ) h ";
    $query .= "WHERE rn > " . (int) $row;
    $dbOracle->prepare($query);
    $dbOracle->execute();

    $rows = $dbOracle->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {
      $rowOutput["acm_sbkod"] = $val["acm_sbkod"];
      $rowOutput["acm_sbktr"] = $val["acm_sbktr"];
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;

    $dbOracle->closeOciConnection();
  }

  public function customertable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "pid_plgid LIKE '%" . $searchValue . "%' OR pid_pnama LIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_PLNGAN ";
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);
    $records = $dbOracle->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_PLNGAN ";
    if ($searchValue != "") {
      $sql .= " WHERE " . $searchQuery;
    }
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);

    $records = $dbOracle->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * FROM (";
    $query .= "SELECT tmp.*, rownum rn FROM(";
    $query .= "SELECT DISTINCT PID_PLGID, PID_PNAMA, PID_JENPG, VAL_AMTID, VAL_ALMT1, VAL_ALMT2, VAL_ALMT3, VAL_ALMT4, VAL_ALMT5, VAL_POSKD FROM SPMC.V_PLNGAN ";
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= ") tmp WHERE rownum <= " . (int) ($row + $rowperpage) . " ) h ";
    $query .= "WHERE rn > " . (int) $row;
    $dbOracle->prepare($query);
    $dbOracle->execute();

    $row = $dbOracle->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {
      $rowOutput["pid_plgid"] = $val["pid_plgid"];
      $rowOutput["pid_pnama"] = $val["pid_pnama"];
      $rowOutput["pid_jenpg"] = $val["pid_jenpg"];
      $rowOutput["val_almt1"] = $val["val_almt1"];
      $rowOutput["val_almt2"] = $val["val_almt2"];
      $rowOutput["val_almt3"] = $val["val_almt3"];
      $rowOutput["val_almt4"] = $val["val_almt4"];
      $rowOutput["val_almt5"] = $val["val_almt5"];
      $rowOutput["role"] = Session::getUserRole();
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;

    $dbOracle->closeOciConnection();
  }

  public function customeraddtable($plgid)
  {
    $dbOracle = new Oracle();
    $query = "SELECT distinct pid_plgid, pid_pnama, pid_jenpg, val_amtid, val_almt1, val_almt2, val_almt3, val_almt4, val_almt5, val_poskd FROM SPMC.V_PLNGAN ";
    $query .= "WHERE pid_plgid = '" . $plgid . "'";
    $dbOracle->prepare($query);
    $dbOracle->execute();

    $row = $dbOracle->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {
      $rowOutput["pid_plgid"] = $val["pid_plgid"];
      $rowOutput["pid_pnama"] = $val["pid_pnama"];
      $rowOutput["pid_jenpg"] = $val["pid_jenpg"];
      $rowOutput["val_amtid"] = $val["val_amtid"];
      $rowOutput["val_almt1"] = $val["val_almt1"];
      $rowOutput["val_almt2"] = $val["val_almt2"];
      $rowOutput["val_almt3"] = $val["val_almt3"];
      $rowOutput["val_almt4"] = $val["val_almt4"];
      $rowOutput["val_almt5"] = $val["val_almt5"];
      $rowOutput["val_poskd"] = $val["val_poskd"];
      $rowOutput["role"] = Session::getUserRole();
      array_push($output, $rowOutput);
    }

    return ["data" => $output];
  }

  public function accounttable()
  {
    $dbOracle = new Oracle();

    $query = "SELECT peg_akaun, pmk_nmbil, peg_htkod, hrt_hnama, jln_jlkod, jln_kwkod, jln_knama, jln_jnama ";
    $query .= "FROM SPMC.V_HVNDUK ";

    $dbOracle->prepare($query);
    $dbOracle->execute();

    $info = $dbOracle->fetchAllAssociative();
    return $info;

    $dbOracle->closeOciConnection();
  }

  public function acctTable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area = "")
  {
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "v.peg_akaun LIKE '%" . $searchValue . "%' OR v.pmk_nmbil iLIKE '%" . $searchValue . "' OR v.hrt_hnama iLIKE '%" . $searchValue . "' OR ";
      $searchQuery .= "v.jln_knama iLIKE '%" . $searchValue . "' OR v.jln_jnama iLIKE '%" . $searchValue . "'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_HVNDUK v ";
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);
    $records = $dbOracle->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_HVNDUK v ";
    if ($area != "" && $searchValue != "") {
      $sql .= "WHERE v.jln_kwkod = " . $area . " AND " . $searchQuery;
    } elseif ($area != "" && $searchValue == "") {
      $sql .= "WHERE v.jln_kwkod = " . $area;
    } elseif ($area == "" && $searchValue != "") {
      $sql .= "WHERE " . $searchQuery;
    }
    $sel = $dbOracle->prepare($sql);
    $dbOracle->execute($sel);

    $records = $dbOracle->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * ";
    $query .= "FROM ( SELECT tmp.*, rownum rn ";
    $query .= "FROM( SELECT peg_akaun, pmk_nmbil, peg_htkod, hrt_hnama, jln_jlkod, jln_kwkod, jln_knama, jln_jnama FROM SPMC.V_HVNDUK v ";
    if ($area != "" && $searchValue != "") {
      $query .= "WHERE v.jln_kwkod = " . $area . " AND " . $searchQuery;
    } elseif ($area != "" && $searchValue == "") {
      $query .= "WHERE v.jln_kwkod = " . $area;
    } elseif ($area == "" && $searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= ") tmp ";
    $query .= "WHERE rownum <= " . (int) ($row + $rowperpage) . " ) h ";
    $query .= "WHERE rn > " . (int) $row;
    $dbOracle->prepare($query);
    $dbOracle->execute();

    $rows = $dbOracle->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {
      $rowOutput["jln_jlkod"] = $this->checkNull($val["jln_jlkod"]);
      $rowOutput["jln_kwkod"] = $this->checkNull($val["jln_kwkod"]);
      $rowOutput["peg_htkod"] = $this->checkNull($val["peg_htkod"]);
      $rowOutput["peg_akaun"] = $val["peg_akaun"];
      $rowOutput["pmk_nmbil"] = $val["pmk_nmbil"];
      $rowOutput["jln_jnama"] = $val["jln_jnama"];
      $rowOutput["jln_knama"] = $val["jln_knama"];
      $rowOutput["hrt_hnama"] = $val["hrt_hnama"];
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecordwithFilter,
      "data" => $output,
    ];

    return $response;

    $dbOracle->closeOciConnection();
  }

  public function htanah()
  {
    $dbOracle = new Oracle();

    $query = "SELECT tnh_thkod, tnh_tnama FROM SPMC.V_HTANAH ";

    $dbOracle->prepare($query);
    $dbOracle->execute();

    $info = $dbOracle->fetchAllAssociative();
    return $info;
  }

  public function hbangn()
  {
    $dbOracle = new Oracle();

    $query = "SELECT * FROM SPMC.V_HBANGN ";

    $dbOracle->prepare($query);
    $dbOracle->execute();

    $rows = $dbOracle->fetchAllAssociative();
    return $rows;
  }

  public function hharta()
  {
    $dbOracle = new Oracle();

    $query = "SELECT * FROM V_HHARTA ORDER BY hrt_htkod";

    $dbOracle->prepare($query);
    $dbOracle->execute();

    $info = $dbOracle->fetchAllAssociative();
    return $info;
  }

  public function hstbgn()
  {
    $dbOracle = new Oracle();

    $query = "SELECT * FROM V_HSTBGN ";

    $dbOracle->prepare($query);
    $dbOracle->execute();

    $info = $dbOracle->fetchAllAssociative();
    return $info;
  }

  public function hjenpk()
  {
    $dbOracle = new Oracle();
    // $query = "SELECT * FROM SPMC.V_HJENPK WHERE jpk_stcbk = 'T'";
    $query = "SELECT * FROM V_HJENPK ";
    $dbOracle->prepare($query);
    $dbOracle->execute();
    $info = $dbOracle->fetchAllAssociative();
    return $info;
  }

  public function area()
  {
    $dbOracle = new Oracle();

    $query = "SELECT kws_kwkod, kws_knama FROM V_MKWJLN ";
    $query .= "GROUP BY kws_kwkod, kws_knama ";
    $query .= "ORDER BY kws_kwkod ASC";
    $dbOracle->prepare($query);
    $dbOracle->execute();

    $rows = $dbOracle->fetchAllAssociative();

    return $rows;
  }

  public function street($area)
  {
    $dbOracle = new Oracle();

    $query = "SELECT jln_jlkod, jln_jnama FROM V_MKWJLN WHERE kws_kwkod ='" . $area . "'";
    $dbOracle->prepare($query);
    $dbOracle->execute();

    $rows = $dbOracle->fetchAllAssociative();

    return $rows;
  }

  public function updateRate($rate, $kwkod, $htkod)
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $currentrate = $dbOracle->compareRate($kwkod, $htkod);

    if ($rate == $currentrate) {
      $status =  "1";
    } elseif ($rate != $currentrate) {
      $query = "UPDATE data.kadar_nilai SET kadar_nilai=:rate ";
      $query .= "WHERE kws_kwkod = :kws_kwkod AND hrt_htkod = :hrt_htkod";
      $database->prepare($query);
      $database->bindValue(":rate", $rate);
      $database->bindValue(":kws_kwkod", (int) $kwkod);
      $database->bindValue(":hrt_htkod", (int) $htkod);
      $database->execute();

      $status =  "2";
    }

    return $status;
  }
}