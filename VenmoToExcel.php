<?php
function getBetween($content,$start,$end){
  $r = explode($start, $content);
  if (isset($r[1])){
      $r = explode($end, $r[1]);
      return $r[0];
  }
  return '';
}

if ($_POST["data"]) {
  $data = $_POST["data"];
  $data = explode('PUBLIC   FRIENDS   MINE', $data)[1];
  if(count(explode('No more payments', $data))>1){
    $data = explode('No more payments', $data)[0];
  }
  else{
    $data = explode('More', $data)[0];
  }
  
  $rows = explode(PHP_EOL, $data);
  $itemsSetup = array();
  $preList = array();
  foreach ($rows as &$row) {
    $row = str_replace("\r","",$row);
    if (preg_replace('/\s+/', '', $row) != ""){
      array_push($preList,$row);
      if(substr($row,0,1) == "+"){
        array_push($itemsSetup,$preList);
        $preList = array();
      }
      elseif(substr($row,0,1) == "-"){
        $preList = array();
      }
    }
  }
  
  $itemsFinal = array();
  foreach ($itemsSetup as &$item) { 
    $arr["Name"] = explode(" paid", $item[0])[0];
    $arr["Description"] = $item[1];
    $arr["Date"] = strtotime(explode("\xc2\xb7", $item[2])[1]);
    if($item[4] == "Leave a comment..."){
      $arr["Price"] = substr($item[5], 1);
    }
    else{
      $arr["Price"] = substr($item[4], 1);
    }
    array_push($itemsFinal,$arr);
  }
  
  
  echo "<table border='1'><tr> <th>Name</th> <th>Description</th> <th>Date</th> <th>Price</th> </tr>";
  foreach ($itemsFinal as &$items) {
    echo "<tr>";
    echo "<td>". $items['Name'] ."</td>";
    echo "<td>". $items['Description'] ."</td>";
    echo "<td>". $items['Date'] ."</td>";
    echo "<td>". $items['Price'] ."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
else{
?>

<!DOCTYPE html>
<html>
<body>

<form method="post" action="">
  Data:<br>
  <textarea rows="20" cols="100" name="data"></textarea>
  <br><br>
  <input type="submit" value="Submit">
</form> 
</body>
</html>
<?php
} 
 ?>
