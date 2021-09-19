<?php
	if(!defined('INCONAY')) die();

	class Users extends dbConn
	{
		public $row; public $str; public $int;

		public function GetGender($value) // isme göre accounts tablosundan çeker
		{
			$txt = "Yok";
			switch($value)
			{
				case 1: $txt = "Erkek";
				case 2: $txt ="Kadın";
			}
			return $txt;
		}
		
		// UCP News
		public function GetNewsCommentCount($id)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_news_comments WHERE news_id = ?");
			$stmt->execute([$id]); $this->str = $stmt->rowCount();
			return $this->str;
		}

		public function IsValidNewsID($id)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_news WHERE id = ?");
			$stmt->execute([$id]); $this->str = $stmt->rowCount();
			if($this->str > 0) return true;
			else return false;
		}

		// UCP Account
		public function GetAccount($name, $value) // isme göre accounts tablosundan çeker
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE name = ?");
			$stmt->execute([$name]); $row = $stmt->fetch();
			return $row[$value];
		}

		public function GetAccountFromID($id, $value) // isme göre accounts tablosundan çeker
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE id = ?");
			$stmt->execute([$id]); $row = $stmt->fetch();
			return $row[$value];
		}

		public function GetAccountCount($id)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM players WHERE AccountID = ?");
			$stmt->execute([$id]); $this->str = $stmt->rowCount();
			return $this->str;
		}

		public function SetAccount($id, $column, $value)
		{
			$stmt = $this->connect()->prepare("UPDATE accounts SET ".$column." = ? WHERE id = ?");
			$stmt->execute([$value, $id]);
			if($stmt) return 1;
			else return 0;
		}

		// Player Ingame Account
		public function GetPlayer($id, $value) // idye göre players tablosundan çeker
		{
			$stmt = $this->connect()->prepare("SELECT * FROM players WHERE id = ?");
			$stmt->execute([$id]); $this->row = $stmt->fetch();
			return $this->row[$value];
		}

		public function GetPlayerQueue($id)
		{
			$say = 0;
		  	$stmt = $this->connect()->prepare("SELECT * FROM players WHERE AccountStatus = 0"); $stmt->execute();
		   	while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
		   	{
		   		if($rows['accountid'] == $id) { break; }	
				$say++;	
		   	}
			return $say;
		}

		public function GetPlayerApplication($id, $name, $value)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_applications_pool WHERE char_name = ? AND account_id = ?");
			$stmt->execute([$name, $id]); $row = $stmt->fetch();
			return $row[$value];
		}

		public function SetPlayer($id, $column, $value)
		{
			$stmt = $this->connect()->prepare("UPDATE players SET ".$column." = ? WHERE id = ?");
			$stmt->execute([$value, $id]);
			if($stmt) return 1;
			else return 0;
		}

		public function RegisterPlayerToServer($a, $n, $bd, $bp, $rt, $rip)
		{
			$stmt = $this->connect()->prepare("INSERT INTO players (accountid, Name, Birthdate, Birthplace, RegTime, RegisterIP) VALUES(?, ?, ?, ?, ?, ?)");
			$stmt->execute([$a, $n, $bd, $bp, $rt, $rip]);
			if($stmt) return 1;
			else return 0;
		}

		public function RegisterPlayerToPool($a, $ch, $s, $b, $p, $terms, $time)
		{
			$stmt = $this->connect()->prepare("INSERT INTO ucp_applications_pool (account_id, char_name, story, background, policy, terms, time, status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)"); 
			$stmt->execute([$a, $ch, $s, $b, $p, $terms, $time]);
			if($stmt) return 1;
			else return 0;
		}

		public function Player_LoginCheck($username, $password)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE name = ? AND password = ?");
			$stmt->execute([$username, $password]); 
			if($stmt->rowCount()) return 1;
			else return 0;
		}

		public function OnAccountConnect($username)
		{
			$_SESSION['is_logged'] = true;
			$_SESSION['account_id'] = $this->GetAccount($username, 'id');
			$_SESSION['account_name'] = $this->GetAccount($username, 'name');
			$_SESSION['player_id'] = $this->GetAccount($username, 'active_id');
			$_SESSION['is_admin'] = $this->GetAccount($username, 'adminlevel');
			$_SESSION['admin_name'] = $this->GetAccount($username, 'adminname');
			$_SESSION['is_tester'] = $this->GetAccount($username, 'testerlevel');
			$_SESSION['tester_name'] = $this->GetAccount($username, 'testername');
			$_SESSION['login_attemps'] = 0;

			$this->SetAccount($_SESSION['account_id'], 'last_ucp_time', $_SERVER['REQUEST_TIME']);
			$this->SetAccount($_SESSION['account_id'], 'last_ucp_ip', $_SERVER["REMOTE_ADDR"]); 
			if(!$this->GetAccountFromID($_SESSION['account_id'], 'is_logged')) $this->SetAccount($_SESSION['account_id'], 'is_logged', 1); 
		}

		public function OnAccountDisconnect()
		{
			session_destroy();
		}

		// UCP Applications
		public function GetPlayerApplicationCount()
		{
			$stmt = $this->connect()->prepare("SELECT * FROM players WHERE AccountStatus = 0");
			$stmt->execute(); $this->str = $stmt->rowCount();
			return $this->str;
		}

		public function GetDifference($id, $value, $input) // isme göre accounts tablosundan çeker
		{
			$app_date = 0;
			$ratio = 0; $max_ratio = 0; $owner_name = "yok"; $owner_result = "yok"; $app_status = 0;
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_applications_pool WHERE account_id != ? AND status != 1"); 
			$stmt->execute([$id]);
			while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
   			{	
				$stmtt = $this->connect()->prepare("SELECT SIMILARITY_STRING(?, ?) AS sonuc"); 
				$stmtt->execute([$input, $rows[$value]]);
				$this->row = $stmtt->fetch();
				$ratio = $this->row['sonuc'];

				if($ratio > $max_ratio)
				{
					$app_date = $rows['time'];
					$app_status = $rows['status'];
					$owner_name = $rows['char_name'];
					$owner_result = $rows[$value];
					$max_ratio = $ratio;
				}
   			}
			return $max_ratio."-".$owner_name."-".$owner_result."-".$app_status."-".$app_date;
		}

		public function GetDifferenceColor($value, $brightness = 255, $max = 100, $min = 0, $thirdColorHex = '00')
		{       
		    // Calculate first and second color (Inverse relationship)
		    $first = (1-($value/$max))*$brightness;
		    $second = ($value/$max)*$brightness;
		 
		    // Find the influence of the middle color (yellow if 1st and 2nd are red and green)
		    $diff = abs($first-$second);    
		    $influence = ($brightness-$diff)/2;     
		    $first = intval($first + $influence);
		    $second = intval($second + $influence);
		 
		    // Convert to HEX, format and return
		    $firstHex = str_pad(dechex($first),2,0,STR_PAD_LEFT);     
		    $secondHex = str_pad(dechex($second),2,0,STR_PAD_LEFT); 
		 
		    return $firstHex . $secondHex . $thirdColor ; 
		 
		    // alternatives:
		    // return $thirdColorHex . $firstHex . $secondHex; 
		    // return $firstHex . $thirdColorHex . $secondHex;
		}

		public function GetDifferenceStatus($value)
		{       
		    $txt = "";
		    switch($value)
		    {
		    	case 0: $txt = "beklemede";
		    	case 1: $txt = "kabul edilmiş";
		    	case 2: $txt = "reddedilmiş";
		    }
		    return $txt;
		}

		public function getID($n)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE name = ?");
			$stmt->execute([$n]); $this->row = $stmt->fetch();
			return $this->row['id'];
		}

		public function getEmail($i)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE id = ?");
			$stmt->execute([$i]); $this->row = $stmt->fetch();
			return $this->row['email'];
		}

		public function setUserHash($i)
		{
			$stmt = $this->connect()->prepare("UPDATE accounts SET hash = 0 WHERE hash = ?");
			$stmt->execute([$i]);
			if(!$stmt) return 0;
			else return 1;
		}

		public function getNameFromEmail($i)
		{
			$stmt = $this->connect()->prepare("SELECT name FROM accounts WHERE email = ?");
			$stmt->execute([$i]); $this->row = $stmt->fetch();
			return $this->row['name'];
		}

		public function getEmailFromHash($i)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE hash = ?");
			$stmt->execute([$i]); $this->row = $stmt->fetch();
			return $this->row['email'];
		}

		public function getNameFromHash($i)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE hash = ?");
			$stmt->execute([$i]); $this->row = $stmt->fetch();
			return $this->row['name'];
		}

		public function getName($i)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE id = ?");
			$stmt->execute([$i]); $this->row = $stmt->fetch();
			return $this->row['name'];
		}

		public function getAdminName($i)
		{
			$stmt = $this->connect()->prepare("SELECT name FROM accounts WHERE id = ?");
			$stmt->execute([$i]); $this->row = $stmt->fetch();
			if(!$this->row) return "LSS-RP";
			else return $this->row['name'];
		}

		public function getNameFo($column, $value)
		{
			$stmt = $this->connect()->prepare("SELECT name FROM accounts WHERE id = ?");
			$stmt->execute([$i]); $this->row = $stmt->fetch();
			if(!$this->row) return "LSS-RP";
			else return $this->row['name'];
		}

		public function GetNewsCount()
		{
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_news");
			$stmt->execute();
			$this->int = $stmt->rowCount();
			return $this->int;
		}

		public function GetActiveCharName($i)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM players WHERE AccountID = ?");
			$stmt->execute([$i]); $this->row = $stmt->fetch();
			return $this->row['Name'];
		}

		public function IsUsernameExists($u)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE name = ?");
			$stmt->execute([$u]); $this->str = $stmt->rowCount();
			if($this->str > 0) return true;
			else return false;
		}

		public function IsCharacterExists($n)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM players WHERE name = ?");
			$stmt->execute([$n]); $this->row = $stmt->rowCount();
			if($this->str > 0) return 1;
			else return 0;
		}	

		public function IsEmailExists($u)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE email = ?");
			$stmt->execute([$u]); $this->str = $stmt->rowCount();
			if($this->str > 0) return true;
			else return false;
		}

		public function IsIPExists($ip)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE reg_ip = ? OR last_ucp_ip = ? OR last_game_ip = ?");
			$stmt->execute([$ip, $ip, $ip]); $this->str = $stmt->rowCount();
			if($this->str > 0) return true;
			else return false;
		}

		public function IsRelativeAccount($u, $e)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM accounts WHERE name = ? AND email = ?");
			$stmt->execute([$u, $e]); $this->str = $stmt->rowCount();
			if($this->str > 0) return true;
			else return false;
		}

		public function updateUserPassword($name, $pw)
		{
			$stmt = $this->connect()->prepare("UPDATE accounts SET password = ? WHERE name = ?");
			$stmt->execute([$pw, $name]);
			if($stmt) return 1;
			else return 0;
		}

		public function lostpassUser($name, $hash)
		{
			$stmt = $this->connect()->prepare("UPDATE accounts SET hash = ? WHERE name = ?");
			$stmt->execute([$hash, $name]);
			if(!$stmt) return false;
			else return true;
		}

		public function getUserInf($id)
		{
			$sql = "SELECT * FROM accounts WHERE id=?";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			$this->row = $stmt->fetch();
		}

		public function cevapKontrol($soruid)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM answers WHERE id = ?");
			$stmt->execute([$soruid]); $row = $stmt->fetch();
			return $row['correct_answer'];
		}

		public function generateRandomString($length = 10) 
		{
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    
		    for ($i = 0; $i < $length; $i++) 
		    {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}

		public function validateEmail($email)
		{
		    $whitelisted_domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com']; 

		    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		        return false;
		    }

		    $email_parts = explode('@', $email);
		    if (!in_array(end($email_parts), $whitelisted_domains)) {
		        return false;
		    }

		    return true;
		}
		
		public function GetPlayerForApplication($id, $value)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM players WHERE AccountID = ?");
			$stmt->execute([$id]); $row = $stmt->fetch();
			return $row[$value];
		}

		public function registerUser($n, $p, $sq, $sw, $mw, $mh, $e, $rg, $ri)
		{
			$stmt = $this->connect()->prepare("INSERT INTO accounts (name, password, security_question, security_word, memorable_word, memorable_hint, email, reg_time, reg_ip) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->execute([$n, $p, $sq, $sw, $mw, $mh, $e, $rg, $ri]);
			if(!$stmt) return 0;
			else return 1;
		}

		// UCP IP Block
		public function GetUCPIPBlock($ip, $value)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_blocks WHERE ip_address = ?");
			$stmt->execute([$ip]); $row = $stmt->fetch();
			return $row[$value];
		}

		public function SetUCPIPBlock($id, $column, $value)
		{
			$stmt = $this->connect()->prepare("UPDATE ucp_blocks ? = ? WHERE id = ?");
			$stmt->execute([$column, $value, $id]);
			if(!$stmt) return 0;
			else return 1;
		}

		public function AddUCPIPBlock($ip, $name, $time)
		{
			$stmt = $this->connect()->prepare("INSERT INTO ucp_blocks (ucp_name, ip_address, blocked_time) VALUES (?, ?, ?)");
			$stmt->execute([$name, $ip, $time]);
			if(!$stmt) return 0;
			else return 1;
		}

		public function DeleteUCPIPBlock($ip)
		{
			$stmt = $this->connect()->prepare("DELETE FROM ucp_blocks WHERE ip_address = ?");
			$stmt->execute([$ip]);
			if($stmt) return 1;
			else return 0;
		}

		public function GetAllUCPIPBlocks($ip)
		{
			$stmt = $this->connect()->prepare("SELECT id FROM ucp_blocks WHERE ip_address = ?");
			$stmt->execute([$ip]); $this->str = $stmt->rowCount();
			return $this->str;
		}


		// UCP Mailbox
		public function GetUCPMsg($id, $value)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_mailboxes WHERE id = ?");
			$stmt->execute([$id]); $row = $stmt->fetch();
			return $row[$value];
		}

		public function SetUCPMsg($id, $column, $value)
		{
			$stmt = $this->connect()->prepare("UPDATE ucp_mailboxes SET ".$column." = ? WHERE id = ?");
			$stmt->execute([$value, $id]);
			if($stmt) return 1;
			else return 0;
		}

		public function DeleteUCPMsg($id)
		{
			$stmt = $this->connect()->prepare("DELETE FROM ucp_mailboxes WHERE id = ?");
			$stmt->execute([$id]);
			if($stmt) return 1;
			else return 0;
		}

		public function GetAllUCPMsgs($id)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_mailboxes WHERE to_id = ?"); 
			$stmt->execute([$id]); $this->str = $stmt->rowCount();
			return $this->str;
		}

		public function GetAllUnreadUCPMsgs($id)
		{
			$stmt = $this->connect()->prepare("SELECT * FROM ucp_mailboxes WHERE to_id = ? AND is_read = 0"); 
			$stmt->execute([$id]); $this->str = $stmt->rowCount();
			return $this->str;
		}

		public function AddUCPMsg($f, $t, $tit, $con, $ti)
		{
			$stmt = $this->connect()->prepare("INSERT INTO ucp_mailboxes (from_id, to_id, msg_title, msg_content, time) VALUES (?, ?, ?, ?, ?)");
			$stmt->execute([$f, $t, $tit, $con, $ti]);
			if($stmt) return 1;
			else return 0;
		}
	}

	class Chars extends Users
	{
		public $int;
		public $str;
		public $row;

		public function checkCharExistance($n)
		{
			$sql = "SELECT * FROM players WHERE Name=?";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$n]);
			$this->int = $stmt->rowCount();

			if($this->int > 0)
				return true;
			else
				return false;
		}

		public function updateChar($t, $d, $i)
		{
			$sql = "UPDATE players SET ".$t."=? WHERE id=?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$d, $i]);
		}

		public function getID($n)
		{
			$sql = "SELECT * FROM players WHERE Name=?";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$n]);

			$this->row = $stmt->fetch();
			$this->int = $this->row['id'];

			return $this->int;
		}

		public function sendApp($name, $origin, $gender, $age, $story, $answer1, $answer2, $answer3, $acc_id)
		{
			$sql = "INSERT INTO players(Name, Birthplace, birthdate, Gender, story, answer1, answer2, answer3, accountid) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$name, $origin, $age, $gender, $story, $answer1, $answer2, $answer3, $acc_id]);

			if($stmt)
				return true;
			else
				return false;
		}

		public function hasThreeChars($i)
		{
			$sql = "SELECT * FROM players WHERE accountid=?";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$i]);
			$this->int = $stmt->rowCount();

			if($this->int > 3)
				return true;
			else
				return false;
		}

		public function reddet($i)
		{
			$stmt = $this->connect()->prepare("DELETE FROM players WHERE id=?");
			$stmt->execute([$i]);
		}

		public function onayla($i)
		{
			$stmt = $this->connect()->prepare("UPDATE players SET status='2' WHERE id=?");
			$stmt->execute([$i]);
		}

	}

	class Time extends Chars
	{
		public function GetFullTime($time_stamp)
		{
			//12 Şubat 2012 Perşembe 11:22.12
			$the_time = sprintf("%s %s %s %s %s", date("d", $time_stamp), $this->GetMonth($time_stamp), date("Y", $time_stamp), $this->GetWeekDay($time_stamp), date("h:i.s", $time_stamp-3600*3));
			return $the_time;
		}

		public function GetMonth($time_stamp)
		{
			$dw = date("m", $time_stamp);
			$mon_txt;
			switch($dw)
			{
				case 1: $mon_txt = "Ocak"; break;
				case 2: $mon_txt = "Şubat"; break;
				case 3: $mon_txt = "Mart"; break;
				case 4: $mon_txt = "Nisan"; break;
				case 5: $mon_txt = "Mayıs"; break;
				case 6: $mon_txt = "Haziran"; break;
				case 7: $mon_txt = "Temmuz"; break;
				case 8: $mon_txt = "Ağustos"; break;
				case 9: $mon_txt = "Eylül"; break;
				case 10: $mon_txt = "Ekim"; break;
				case 11: $mon_txt = "Kasım"; break;
				case 12: $mon_txt = "Aralık"; break;
			}
			return $mon_txt;
		}

		public function GetWeekDay($time_stamp)
		{
			$dw = date("w", $time_stamp);
			$day_txt;
			switch($dw)
			{
				case 0: $day_txt = "Pazar"; break;
				case 1: $day_txt = "Pazartesi"; break;
				case 2: $day_txt = "Salı"; break;
				case 3: $day_txt = "Çarşamba"; break;
				case 4: $day_txt = "Perşembe"; break;
				case 5: $day_txt = "Cuma"; break;
				case 6: $day_txt = "Cumartesi"; break;
			}
			return $day_txt;
		}
	}
 ?>
