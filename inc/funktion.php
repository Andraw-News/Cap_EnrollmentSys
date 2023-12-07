<?php
date_default_timezone_set('Asia/Manila');
class funktion
{
	private $host  = 'localhost';
	private $user  = 'root';
	private $password   = '';
	private $database  = 'enrollsys_db';
	private $userTable = 'tblaccounts';
	private $schoolTable = 'shscampus';
	private $trackTable = 'tblshstracks';
	private $strandTable = 'tblshsstrands';
	private $spclTable = 'tblspecialized';
	private $offersTable = 'tblshsoffers';
	private $regformTable = 'regform';
	private $studentTable = 'studentdetails';
	private $dbConnect = false;

	public function __construct()
	{
		if (!$this->dbConnect) {
			$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
			if ($conn->connect_error) {
				die("Error failed to connect to MySQL: " . $conn->connect_error);
			} else {
				$this->dbConnect = $conn;
			}
		}
	}
	private function getData($sqlQuery)
	{
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error($this->dbConnect));
		}
		$data = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}
	public function login($email, $pass)
	{
		$sqlQuery = "
			SELECT *
			FROM " . $this->userTable . " 
			WHERE email='" . $email . "' AND password='" . $pass . "'";
		return  $this->getData($sqlQuery);
	}
	public function getSchool($schoolid)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->schoolTable . " 
			WHERE id='" . $schoolid . "'";
		return  $this->getData($sqlQuery);
	}
	public function generateRegID()
	{
		$randomNum = rand(1000000, 9999999);

		$sqlQuery = "
			SELECT * FROM " . $this->regformTable . "
			WHERE reg_id = '" . $randomNum . "' ";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if ($result) {
			$numRows = mysqli_num_rows($result);
			if ($numRows > 0) {
				return $this->generateRegID();
			}
		}
		return $randomNum;
	}
	public function generateStudentID()
	{
		$randomNum = rand(1000, 9999);

		$sqlQuery = "
			SELECT * FROM " . $this->studentTable . " as s
			INNER JOIN " . $this->regformTable . " as r on s.stud_id = r.stud_id
			WHERE stud_id = '" . $randomNum . "' ";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if ($result) {
			$numRows = mysqli_num_rows($result);
			if ($numRows > 0) {
				return $this->generateStudentID();
			}
		}
		return $randomNum;
	}
	// SAVE STUDENT INFO IN DATABASE
	public function saveRegForm()
	{
		$currentYr = date('Y');
		$nextYr = date('Y') + 1;
		$SY = $currentYr . ' - ' . $nextYr;
		$datetime = date('Y-m-d h:i:s');
		$studid = $currentYr % 100 . '' . $this->generateStudentID();

		if (!empty($_POST)) {
			$sqlQuery = "
					SELECT * FROM " . $this->regformTable . " WHERE reg_id ='" . $_POST["inputRegId"] . "' ";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			if (!$result) {
				echo $sqlQuery;
				die('Error in query: ' . mysqli_error($this->dbConnect));
			}
			$numRows = mysqli_num_rows($result);
			if ($numRows > 0) {
			} else {
				$sqlUpdate = "
				UPDATE " . $this->regformTable . " 
				SET stud_id='" . $studid . "', offer_id='" . $_POST["inputStrand"] . "', school_id='" . $_POST["inputSchool"] . "', grade_lvl='" . $_POST["inputGrade"] . "', semester='" . $_POST["inputSem"] . "', 
				AY='" . $SY . "', stud_type='" . $_POST["stype"] . "', date_enrolled='" . $datetime . "', viewed='0', approved='0' 
				WHERE stud_id ='" . $_POST['studentid'] . "' ";
				//echo $sqlUpdate;
				$result = mysqli_query($this->dbConnect, $sqlUpdate);
				if (!$result) {
					echo $sqlUpdate;
					die('Error in query: ' . mysqli_error($this->dbConnect));
				}
			}

			$sqlInsertStud = " 
		  	  	INSERT INTO " . $this->studentTable . "(stud_id, stud_email, LRN, stud_Lname, stud_Fname, stud_Mname, 
		  	  	BirthDate, BirthPlace, Gender, Age, Current_Address, Home_Address, 
		  	  	ParentFname, ParentFContact, ParentMname, ParentMContact, GuardianName, GuardianContact) 
		  	  	VALUES ('" . $studid . "', '', '" . $_POST["inputLRN"] . "', '" . $_POST["inputLname"] . "', '" . $_POST["inputFname"] . "', 
		  	  	'" . $_POST["inputMname"] . "', '" . $_POST["inputBDate"] . "', '" . $_POST["inputBPlace"] . "', '" . $_POST["inputGender"] . "', 
		  	  	'" . $_POST["inputAge"] . "', '" . $_POST["caddr"] . "', '" . $_POST["haddr"] . "', '" . $_POST["inputPFname"] . "', 
		  	  	'" . $_POST["inputPFcontact"] . "', '" . $_POST["inputPMname"] . "', '" . $_POST["inputPMcontact"] . "', '" . $_POST["inputGname"] . "', '" . $_POST["inputGcontact"] . "')";
			$result = mysqli_query($this->dbConnect, $sqlInsertStud);

			if (!$result) {
				echo $sqlInsertStud;
				die('Error in query: ' . mysqli_error($this->dbConnect));
			} else {
				echo "<p class='text-justify'>At this point, you can wait to receive the email confirming 
		 		the approval of your application and proceed with completing the necessary paperwork in person. 
		 		Please take note that it might take a few days to receive the email.</p>
		 		<p class='text-justify'>Please keep in mind the information below as it may aid in the next steps of the enrolling process.</p>
		 		<strong><p>Registration ID: <i>" . $_POST["inputRegId"] . "</i></p><p>Student ID: <i>" . $studid . "</i></p></strong>";
			}
		}
	}
	// UPDATE STUDENT INFO IN DATABASE FOR OLD STUDENT
	public function updateRegForm()
	{
		$currentYr = date('Y');
		$nextYr = date('Y') + 1;
		$SY = $currentYr . ' - ' . $nextYr;
		$datetime = date('Y-m-d h:i:s');
		if ($_POST['studentid']) {
			$sqlUpdate = "
				UPDATE " . $this->regformTable . " 
				SET offer_id='" . $_POST["inputStrand"] . "', grade_lvl='" . $_POST["inputGrade"] . "', semester='" . $_POST["inputSem"] . "', 
				AY='" . $SY . "', stud_type='" . $_POST["stype"] . "', date_enrolled='" . $datetime . "', viewed='0', approved='0' 
				WHERE stud_id ='" . $_POST['studentid'] . "' ";
			//echo $sqlUpdate;
			$result = mysqli_query($this->dbConnect, $sqlUpdate);
			if (!$result) {
				echo $sqlUpdate;
				die('Error in query: ' . mysqli_error($this->dbConnect));
			} else {
				$sqlUpdate = "
					UPDATE " . $this->studentTable . " SET 
					stud_Lname='" . $_POST["inputLname"] . "', stud_Fname='" . $_POST["inputFname"] . "', stud_Mname='" . $_POST["inputMname"] . "',
					BirthDate='" . $_POST["inputBDate"] . "', BirthPlace='" . $_POST["inputBPlace"] . "', Gender='" . $_POST["inputGender"] . "', Age='" . $_POST["inputAge"] . "',
					Current_Address='" . $_POST["caddr"] . "', Home_Address='" . $_POST["haddr"] . "',
					ParentFname='" . $_POST["inputPFname"] . "', ParentFContact='" . $_POST["inputPFcontact"] . "',
					ParentMname='" . $_POST["inputPMname"] . "', ParentMContact='" . $_POST["inputPMcontact"] . "',
					GuardianName='" . $_POST["inputGname"] . "', GuardianContact='" . $_POST["inputGcontact"] . "' 
					WHERE stud_id ='" . $_POST['studentid'] . "' ";
				$result = mysqli_query($this->dbConnect, $sqlUpdate);
				if (!$result) {
					echo $sqlUpdate;
					die('Error in query: ' . mysqli_error($this->dbConnect));
				} else {
					echo "<p class='text-justify'> Again at this point, you can wait to receive the email confirming 
					the approval of your application and proceed with completing the necessary paperwork in person. 
					Please take note that it might take a few days to receive the email.</p>
					<p class='text-justify'>Please keep in mind the information below as it may aid in the next steps of the enrolling process.</p>
					<strong><p>Registration ID: <i>" . $_POST["inputRegId"] . "</i></p><p>Student ID: <i>" . $_POST['studentid'] . "</i></p></strong>";
				}
			}
		}
	}
	//GET STUDENT INFO FOR OLD STUDENT
	public function getDetails()
	{
		$sqlQuery = "
			SELECT * FROM " . $this->regformTable . " as rf
			INNER JOIN " . $this->studentTable . " as st ON rf.stud_id = st.stud_id 
			WHERE st.stud_id ='" . $_POST['studid'] . "' ";
		// echo $sqlQuery;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			echo $sqlQuery;
			die('Error in query: ' . mysqli_error($this->dbConnect));
		} else {

			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo json_encode($row);
		}
	}
	//UPLOAD REQUIRED DOCUMENT AND SAVE THE UPLOADED FILE INTO DATABASE
	public function uploadFile()
	{
		$name = $_POST['name'];
		$regid = $_POST['rid'];
		if (isset($_FILES['file'])) {
			$uploadDirectory = '../uploads/';

			$fileName = $_FILES['file']['name'];
			$fileType = $_FILES['file']['type'];

			$allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
			if (!in_array($fileType, $allowedImageTypes)) {
				die("Invalid file type. Only JPEG, PNG, and GIF images are allowed.</br>");
			}
			$uniqueFileName = uniqid() . '_' . $fileName;

			$filePath = $uploadDirectory . $uniqueFileName;
			if (file_exists($filePath)) {
				echo "Sorry, file already exists.";
			} else {
				if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {  //SAVE THE FILE WITHIN THE 
					//FILTER IF THERES EXISTING RECORD OF STUDENT
					$sqlQuery = "
					SELECT * FROM " . $this->regformTable . " WHERE reg_id ='" . $regid . "' ";
					$result = mysqli_query($this->dbConnect, $sqlQuery);

					$numRows = mysqli_num_rows($result);
					if ($numRows > 0) {
					} else {
						$sqlInsert = "
						INSERT " . $this->regformTable . "(reg_id) VALUE('" . $regid . "') ";
						$result = mysqli_query($this->dbConnect, $sqlInsert);
						if (!$result) {
							echo $sqlInsert;
							die('Error in query: ' . mysqli_error($this->dbConnect));
						}
					}
					//SAVE THE THE FILEPATH AND ALERT THE STUDENT THAT HIS/HER FILE UPLOADED SUCCESS
					$sqlUpdate = " 
					UPDATE " . $this->regformTable . " SET";
					if ($name == "birthCert") {
						$sqlUpdate .= " birthCert_filepath='" . $filePath . "' ";
					}
					if ($name == "SF9card") {
						$sqlUpdate .= " sf9Card_filepath='" . $filePath . "' ";
					}
					if ($name == "G10Diploma") {
						$sqlUpdate .= " g10Diplo_filepath='" . $filePath . "' ";
					}
					$sqlUpdate .= " WHERE reg_id='" . $regid . "' ";
					$result = mysqli_query($this->dbConnect, $sqlUpdate);
					if (!$result) {
						echo $sqlUpdate;
						die('Error in query: ' . mysqli_error($this->dbConnect));
					} else {
						echo "The file " . htmlspecialchars($fileName) . " has been uploaded succefully.";
					}
				} else {
					die("Error uploading file");
				}
			}
		} else {
			echo "No file submitted.";
		}
	}
	// DROPDOWN LIST
	public function getList()
	{
		$sqlQuery = "
				SELECT * FROM " . $this->regformTable . " as rf
				INNER JOIN " . $this->offersTable . " as co ON rf.offer_id = co.offer_id
				INNER JOIN " . $this->spclTable . " as sp ON co.specialized_id = sp.specialized_id
				INNER JOIN " . $this->strandTable . " as s ON sp.strand_id = s.strand_id
				INNER JOIN " . $this->trackTable . " as t ON s.track_id = t.track_id
				WHERE rf.stud_id ='" . $_POST['id'] . "'
				GROUP BY rf.school_id";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			echo $sqlQuery;
			die('Error in query: ' . mysqli_error($this->dbConnect));
		} else {
			while ($course = mysqli_fetch_assoc($result)) {
				$output['school_id'] = $course['school_id'];
				$output['track_id'] = $course['track_id'];
				$output['offer_id'] = $course['offer_id'];
				$output["track_select_box"] = $this->trackDropdownList($course['school_id']);
				$output["course_select_box"] = $this->strandDropdownList($course['track_id'], $course['school_id']);
			}
			echo json_encode($output);
		}
	}
	public function schoolDropdownList()
	{
		$sqlQuery = "SELECT * FROM " . $this->schoolTable . "  
			ORDER BY name ASC";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$schoolHTML = '';
		while ($school = mysqli_fetch_assoc($result)) {
			$schoolHTML .= '<option value="' . $school["id"] . '">' . $school["name"] . ' </option>';
		}
		return $schoolHTML;
	}
	public function trackDropdownList($schoolid)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->offersTable . " as o
			INNER JOIN " . $this->spclTable . " as s on o.specialized_id = s.specialized_id
			INNER JOIN " . $this->strandTable . " as st on s.strand_id = st.strand_id
			INNER JOIN " . $this->trackTable . " as t on st.track_id = t.track_id
			WHERE o.school_id = '" . $schoolid . "'
			GROUP BY t.track_name
			ORDER BY t.track_name DESC";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$trackHTML = '<option value="">Choose Track</option>';
		while ($track = mysqli_fetch_assoc($result)) {
			$trackHTML .= '<option value="' . $track["track_id"] . '">' . $track["track_descript"] . ' Track</option>';
		}
		return $trackHTML;
	}
	public function strandDropdownList($trackid, $schoolid)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->offersTable . " as o
			INNER JOIN " . $this->spclTable . " as s on o.specialized_id = s.specialized_id
			INNER JOIN " . $this->strandTable . " as st on s.strand_id = st.strand_id
			INNER JOIN " . $this->trackTable . " as t on st.track_id = t.track_id
			WHERE st.track_id = '" . $trackid . "' AND o.school_id ='" . $schoolid . "'
			ORDER BY st.strand_name DESC";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$strandHTML = '<option value="">Choose Strand</option>';
		while ($strand = mysqli_fetch_assoc($result)) {

			$strandHTML .= '<option value="' . $strand["offer_id"] . '">' . $strand["strand_name"] . ' - ' . $strand["specialization_name"] . ' </option>';
		}
		return $strandHTML;
	}
}
