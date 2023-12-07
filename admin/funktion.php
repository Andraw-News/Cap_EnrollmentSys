<?php
class adminfunktion {
    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = '';
    private $database  = 'enrollsys_db';   
	private $userTable = 'tblaccounts';
	private $schoolTable = 'shscampus';
	private $strandTable = 'tblshsstrands';
	private $trackTable = 'tblshstracks';
	private $ssubjTable = 'tblspecialized';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	public function closeConnection() {
        if ($this->dbConnect instanceof mysqli) {
            $this->dbConnect->close();
            $this->dbConnect = false; // Reset the connection property
        }
    }
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error($this->dbConnect));
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function registrarCount() {
		$sqlQuery = "
			SELECT * FROM ".$this->userTable." ";
		
		return $this->getNumRows($sqlQuery);
	}
	public function schoolCount() {
		$sqlQuery = "
			SELECT *
			FROM ".$this->schoolTable." ";
		
		return $this->getNumRows($sqlQuery);
	}
	public function ssubjectsCount() {
		$sqlQuery = "
			SELECT *
			FROM ".$this->strandTable." ";
		
		return $this->getNumRows($sqlQuery);
	}
	public function checkLogin(){
		if(empty($_SESSION['userid'])) {
			header("Location:../login.php");
		}
	}
	//Account management
	public function getAccountList(){				
		$sqlQuery = "SELECT * FROM ".$this->userTable." as u
			INNER JOIN ".$this->schoolTable." as s ON u.school_id = s.id ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'WHERE account_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR u.account_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR s.name LIKE "%'.$_POST["search"]["value"].'%" ';		
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY u.account_id ASC ';
		}
		
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$accountData = array();	
		while( $account = mysqli_fetch_assoc($result) ) {			
			$accountRows = array();
			$accountRows[] = $account['account_id'];
			$accountRows[] = $account['account_name'];
			$accountRows[] = $account['name'];
			$accountRows[] =
			'<div class="btn-group ml-2 mb-1" role="group" aria-label="First group">
			<button type="button" name="view" id="'.$account["account_id"].'" class="btn btn-primary btn-sm rounded-0 view" title="view"><i class="far fa-eye"></i></button>
			<button type="button" name="update" id="'.$account["account_id"].'" class="btn btn-info btn-sm rounded-0 update" title="update"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete" id="'.$account["account_id"].'" class="btn btn-danger btn-sm rounded-0 delete" title="delete"><i class="fas fa-trash-alt"></i></button>
			</div>';
			$accountRows[] ="";
			$accountData[] = $accountRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$accountData
		);
		echo json_encode($output);
	}
	public function schoolDropdownList(){		
		$sqlQuery = "SELECT * FROM ".$this->schoolTable."  
			ORDER BY name ASC";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$schoolHTML = '';
		while( $school = mysqli_fetch_assoc($result)) {
			$schoolHTML .= '<option value="'.$school["id"].'">'.$school["name"].' </option>';	
		}
		return $schoolHTML;
	}
	public function saveAccount() {
		$pass= md5($_POST['cpassword']);		
		$sqlInsert = "
			INSERT INTO ".$this->userTable."(email, password, account_type, account_name, school_id) 
			VALUES ('".$_POST['email']."', '".$pass."', '".$_POST['acctype']."'
			, '".$_POST['name']."', '".$_POST['schoolid']."')";		
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		echo 'New Account Added';
	}	
	public function getAccount(){
		$sqlQuery = "
			SELECT * FROM ".$this->userTable." 
			WHERE account_id = '".$_POST["id"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}	
	public function updateAccount() {		
		if($_POST['id']) {	
			$sqlUpdate = "
				UPDATE ".$this->userTable." 
				SET  email = '".$_POST['email']."', password = '".$_POST['cpassword']."',
				account_name = '".$_POST['name']."', school_id = '".$_POST['schoolid']."'
				WHERE account_id = '".$_POST["id"]."'";
			$result = mysqli_query($this->dbConnect, $sqlUpdate);
			echo 'Account Updated';
		}	
	}	
	public function deleteAccount(){
		$sqlQuery = "
			DELETE FROM ".$this->userTable." 
			WHERE account_id = '".$_POST["id"]."'";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);		
	}
	public function viewAccountDetails(){
		$sqlQuery = "SELECT * FROM ".$this->userTable." as u
			INNER JOIN ".$this->schoolTable." as s ON u.school_id = s.id
			WHERE u.account_id = '".$_POST["id"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$accountDetails = '<div class="table-responsive-md">
			<table class="table table-striped table-sm">';
		while( $account = mysqli_fetch_assoc($result) ) {
			$accountDetails .= '
			<tr>
				<th scope="row">Account ID</th>
				<td>'.$account["account_id"].'</th>
			</tr>
			<tr>
				<th scope="row">Name</th>
				<td>'.$account["account_name"].'</th>
			</tr>
			<tr>
				<th scope="row">Email</th>
				<td>'.$account["email"].'</td>
			</tr>
			<tr>
				<th scope="row">Type</th>
				<td>'.$account["account_type"].'</td>
			</tr>
			<tr>
				<th scope="row">Affiliated School</th>
				<td>'.$account["name"].'</td>
			</tr>			
			';
		}
		$accountDetails .= '
			</table>
		</div>
		';
		echo $accountDetails;
	}
	//School Management
	public function getSchoolList(){		
		$sqlQuery = "SELECT * FROM ".$this->schoolTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'WHERE id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR code LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR descript LIKE "%'.$_POST["search"]["value"].'%" ';	
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id ASC ';
		}

		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			echo $sqlQuery;
			die('Error in query: '. mysqli_error($this->dbConnect));
		} else {
			$numRows = mysqli_num_rows($result);
			$schoolData = array();	
			while( $school = mysqli_fetch_assoc($result) ) {		
				$schoolRows = array();
				$schoolRows[] = $school['id'];
				$schoolRows[] = $school['name'];
				$schoolRows[] = $school['descript'];
				$schoolRows[] = 
				'<div class="btn-group ml-2 mb-1" role="group" aria-label="First group">
				<button type="button" name="update" id="'.$school["id"].'" class="btn btn-info btn-sm rounded-0 update" title="update"><i class="fas fa-edit"></i></button>
				<button type="button" name="delete" id="'.$school["id"].'" class="btn btn-danger btn-sm rounded-0 delete" title="delete"><i class="fas fa-trash-alt"></i></button>
				</div>';
				$schoolData[] = $schoolRows;
			}
			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"  	=>  $numRows,
				"recordsFiltered" 	=> 	$numRows,
				"data"    			=> 	$schoolData
			);
			echo json_encode($output);
		}
		
	}
	public function getSchool(){
		$sqlQuery = "
			SELECT * FROM ".$this->schoolTable." 
			WHERE id = '".$_POST["id"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			echo $sqlQuery;
			die('Error in query: '. mysqli_error($this->dbConnect));
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo json_encode($row);
		}	
		
	}
	public function saveSchool() {
		$sqlQuery = "
			SELECT * FROM ".$this->schoolTable." 
			WHERE id = '".$_POST["schoolid"]."'";
		$row = $this->getNumRows($sqlQuery);
		if ($row > 0) {
			echo 'School Already Registered';
		} else {
			$sqlInsert = "
			INSERT INTO ".$this->schoolTable."(id, code, name, descript) 
			VALUES ('".$_POST['schoolid']."', '".$_POST['code']."', 
			'".$_POST['schoolname']."', '".$_POST['description']."')";		
			$result = mysqli_query($this->dbConnect, $sqlInsert);
			if(!$result){
				echo $sqlInsert;
				die('Error in query: '. mysqli_error($this->dbConnect));
			} else {
				echo 'New School Added';
			}
		}
	}			
	public function updateSchool() {
		if($_POST['schoolid']) {	
			$sqlInsert = "
				UPDATE ".$this->schoolTable." 
				SET  code= '".$_POST['code']."', name= '".$_POST['schoolname']."',descript= '".$_POST['description']."' 
				WHERE id = '".$_POST['schoolid']."'";		
			$result = mysqli_query($this->dbConnect, $sqlInsert);
			if(!$result){
				echo $sqlInsert;
				die('Error in query: '. mysqli_error($this->dbConnect));
			} else {
				echo 'School Edited';
			}	
		}	
	}	
	public function deleteSchool(){
		$sqlQuery = "
			DELETE FROM ".$this->schoolTable." 
			WHERE id = '".$_POST['id']."'";		
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			echo $sqlQuery;
			die('Error in query: '. mysqli_error($this->dbConnect));
		} else {
			echo 'School Deleted';
		}		
	}

	//Strand Management
	public function getStrandList(){				
		$sqlQuery = "SELECT * FROM ".$this->strandTable." as s
			INNER JOIN ".$this->trackTable." as t ON s.track_id = t.track_id ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'WHERE strand_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR track_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR strand_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR strand_descript LIKE "%'.$_POST["search"]["value"].'%" ';		
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY s.strand_id ASC ';
		}
		
		
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$strandData = array();	
		while( $strand = mysqli_fetch_assoc($result) ) {			
			$strandRows = array();
			$strandRows[] = $strand['strand_id'];
			$strandRows[] = $strand['track_name'];;
			$strandRows[] = $strand['strand_name'];
			$strandRows[] = $strand['strand_descript'];
			$strandRows[] =
			'<div class="btn-group ml-2 mb-1" role="group" aria-label="First group">
			<button type="button" name="update" id="'.$strand["strand_id"].'" class="btn btn-info btn-sm rounded-0 update" title="update"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete" id="'.$strand["strand_id"].'" class="btn btn-danger btn-sm rounded-0 delete" ><i class="fas fa-trash-alt"></i></button>
			</div>';
			$strandRows[] ="";
			$strandData[] = $strandRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$strandData
		);
		echo json_encode($output);
	}
	public function trackDropdownList(){		
		$sqlQuery = "SELECT * FROM ".$this->trackTable."  
			ORDER BY track_name ASC";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$trackHTML = '';
		while( $track = mysqli_fetch_assoc($result)) {
			$trackHTML .= '<option value="'.$track["track_id"].'">'.$track["track_name"].' Track</option>';	
		}
		return $trackHTML;
	}
	public function saveStrand() {		
		$sqlInsert = "
			INSERT INTO ".$this->strandTable."(track_id, strand_name, strand_descript) 
			VALUES ('".$_POST["trackid"]."', '".$_POST['name']."', '".$_POST['description']."')";		
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		echo 'New Strand Added';
	}	
	public function getStrand(){
		$sqlQuery = "
			SELECT * FROM ".$this->strandTable." 
			WHERE strand_id = '".$_POST["id"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}	
	public function updateStrand() {		
		if($_POST['id']) {	
			$sqlUpdate = "
				UPDATE ".$this->strandTable." 
				SET track_id = '".$_POST['trackid']."', strand_name = '".$_POST['name']."', strand_descript = '".$_POST['description']."'
				WHERE strand_id = '".$_POST["id"]."'";
			$result = mysqli_query($this->dbConnect, $sqlUpdate);
			echo 'Strand Updated';
		}	
	}	
	public function deleteStrand(){
		$sqlQuery = "
			DELETE FROM ".$this->strandTable." 
			WHERE strand_id = '".$_POST["id"]."'";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);		
	}

	// Subject Management
	public function strandDropdownList(){		
		$sqlQuery = "SELECT * FROM ".$this->strandTable."  
			ORDER BY strand_name ASC";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$strandHTML = '';
		while( $strand = mysqli_fetch_assoc($result)) {
			$strandHTML .= '<option value="'.$strand["strand_id"].'">'.$strand["strand_name"].'</option>';	
		}
		return $strandHTML;
	}
	public function getSubjList(){				
		$sqlQuery = "SELECT * FROM ".$this->strandTable." as s
			INNER JOIN ".$this->ssubjTable." as ss ON s.strand_id = ss.strand_id ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'WHERE specialized_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR specialization_name LIKE "%'.$_POST["search"]["value"].'%" ';		
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY ss.specialized_id ASC ';
		}
	// echo $sqlQuery;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$subjData = array();	
		while( $subj = mysqli_fetch_assoc($result) ) {			
			$subjRows = array();
			$subjRows[] = $subj['specialized_id'];
			$subjRows[] = $subj['strand_name'];
			$subjRows[] = $subj['specialization_name'];
			$subjRows[] =
			'<div class="btn-group ml-2 mb-1" role="group" aria-label="First group">
			<button type="button" name="update" id="'.$subj["specialized_id"].'" class="btn btn-info btn-sm rounded-0 update" title="update"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete" id="'.$subj["specialized_id"].'" class="btn btn-danger btn-sm rounded-0 delete" ><i class="fas fa-trash-alt"></i></button>
			</div>';
			$subjRows[] ="";
			$subjData[] = $subjRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$subjData
		);
		echo json_encode($output);
	}

	public function saveSubj() {		
		$sqlInsert = "
			INSERT INTO ".$this->ssubjTable."(strand_id, specialization_name) 
			VALUES ('".$_POST["strandid"]."', '".$_POST['name']."')";		
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		if(!$result){
			echo $sqlInsert;
			die('Error in query: '. mysqli_error($this->dbConnect));
		} else {
			echo 'New Track Specialization Added';
		}
	}

	public function getSubj(){
		$sqlQuery = "
			SELECT * FROM ".$this->ssubjTable." 
			WHERE specialized_id = '".$_POST["id"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			echo $sqlQuery;
			die('Error in query: '. mysqli_error($this->dbConnect));
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo json_encode($row);
		}	
		
	}	
	public function updateSubj() {		
		if($_POST['id']) {	
			$sqlUpdate = "
				UPDATE ".$this->ssubjTable." 
				SET strand_id = '".$_POST['strandid']."', specialization_name = '".$_POST['name']."'
				WHERE specialized_id = '".$_POST["id"]."'";
			$result = mysqli_query($this->dbConnect, $sqlUpdate);
			if(!$result){
				echo $sqlUpdate;
				die('Error in query: '. mysqli_error($this->dbConnect));
			} else {
				echo 'Track Specialization&apos;s Info Updated';
			}
		}	
	}	
	public function deleteSubj(){
		$sqlQuery = "
			DELETE FROM ".$this->ssubjTable." 
			WHERE specialized_id = '".$_POST["id"]."'";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			echo $sqlQuery;
			die('Error in query: '. mysqli_error($this->dbConnect));
		} else {
			echo 'Track Specialization Deleted';
		}		
	}
}
?>