<?php
/**
 * generates password hash
 *
 * @param string $pw
 * @return string
 */
function generate_pw_hash($pw)
 {
  $salt = bin2hex(openssl_random_pseudo_bytes(22));
  $hash = crypt($pw, '$6$rounds=5000$'.$salt.'$');
  return $hash;
 }

/**
 * checks password comparing it with the hash
 *
 * @param string $pw
 * @param string $hash
 * @return bool
 */
function is_pw_correct($pw,$hash)
 {
  if(strlen($hash)==50) // salted sha1 hash with salt
   {
    $salted_hash = substr($hash,0,40);
    $salt = substr($hash,40,10);
    if(sha1($pw.$salt)==$salted_hash) return true;
    else return false;
   }
  elseif(crypt($pw, $hash) == $hash) return true;
  else return false;
 }

function move_up($item, $section, $table)
 {
  $dbr = Database::$content->prepare("SELECT ".$section.", sequence FROM ".$table." WHERE id=:id LIMIT 1");
  $dbr->bindParam(':id', $item, PDO::PARAM_INT);
  $dbr->execute();
  $data = $dbr->fetch();
  if(isset($data['sequence']))
   {
    if($data['sequence'] > 1)
     {
      Database::$content->beginTransaction();
      $dbr = Database::$content->prepare("UPDATE ".$table." SET sequence=:new_sequence WHERE ".$section."=:section AND sequence=:sequence");
      $dbr->bindParam(':section', $data[$section], PDO::PARAM_STR);
      $dbr->bindValue(':new_sequence', 0, PDO::PARAM_INT);
      $dbr->bindValue(':sequence', $data['sequence']-1, PDO::PARAM_INT);
      $dbr->execute();
      $dbr->bindValue(':new_sequence', $data['sequence']-1, PDO::PARAM_INT);
      $dbr->bindValue(':sequence', $data['sequence'], PDO::PARAM_INT);
      $dbr->execute();
      $dbr->bindValue(':new_sequence', $data['sequence'], PDO::PARAM_INT);
      $dbr->bindValue(':sequence', 0, PDO::PARAM_INT);
      $dbr->execute();
      Database::$content->commit();
     }
    return $data[$section];
   }
  return false;;
 }

function move_down($item, $section, $table)
 {
  $dbr = Database::$content->prepare("SELECT ".$section.", sequence FROM ".$table." WHERE id=:id LIMIT 1");
  $dbr->bindParam(':id', $item, PDO::PARAM_INT);
  $dbr->execute();
  $data = $dbr->fetch();
  if(isset($data['sequence']))
   {
    $dbr = Database::$content->prepare("SELECT sequence FROM ".$table." WHERE ".$section."=:section ORDER BY sequence DESC LIMIT 1");
    $dbr->bindParam(':section', $data[$section], PDO::PARAM_STR);
    $dbr->execute();
    $last = $dbr->fetchColumn();
    if($data['sequence'] < $last)
     {
      Database::$content->beginTransaction();
      $dbr = Database::$content->prepare("UPDATE ".$table." SET sequence=:new_sequence WHERE ".$section."=:section AND sequence=:sequence");
      $dbr->bindParam(':section', $data[$section], PDO::PARAM_STR);
      $dbr->bindValue(':new_sequence', 0, PDO::PARAM_INT);
      $dbr->bindValue(':sequence', $data['sequence']+1, PDO::PARAM_INT);
      $dbr->execute();
      $dbr->bindValue(':new_sequence', $data['sequence']+1, PDO::PARAM_INT);
      $dbr->bindValue(':sequence', $data['sequence'], PDO::PARAM_INT);
      $dbr->execute();
      $dbr->bindValue(':new_sequence', $data['sequence'], PDO::PARAM_INT);
      $dbr->bindValue(':sequence', 0, PDO::PARAM_INT);
      $dbr->execute();
      Database::$content->commit();
     }
    return $data[$section];
   }
  return false;
 }

?>
