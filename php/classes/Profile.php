<?php
namespace Edu\Cnm\DataDesign;

/**
 * Cross Section of a Twitter Profile
 *
 * This is a cross section of what is probably stored about a Twitter user. This entity is a top level entity that
 * holds the keys to the other entities in this example (i.e., Favorite and Profile).
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 3.0.0
 **/
class Profile implements \JsonSerializable {
	/**
	 * id for this Profile; this is the primary key
	 * @var int $profileId
	 **/
	private $profileId;

	/**
	 * at handle for this Profile; this is a unique index
	 * @var string $profileAtHandle
	 **/
	private $profileAtHandle;

	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 *v@var $profileActivationToken
	 **/
	private $profileActivationToken;

	/**
	 * email for this Profile; this is a unique index
	 * @var string $profileEmail
	 **/
	private $profileEmail;

	/**
	 * hash for profile password
	 *
	 * @var $profileHash
	 */
	private $profileHash;

	/**
	 * phone number for this Profile
	 * @var string $profilePhone
	 **/
	private $profilePhone;

	/**
	 * salt for profile password
	 *
	 * @var $profileSalt
	 */
	private $profileSalt;

	/**
	 * constructor for this Profile
	 *
	 * @param int|null $newProfileId id of this Profile or null if a new Profile
	 * @param string $newProfileActivationToken activation token to safe guard against malicious accounts
	 * @param string $newProfileAtHandle string containing newAtHandle
	 * @param string $newProfileEmail string containing email
	 * @param string $newProfileHash string containing password hash
	 * @param string $newProfilePhone string containing phone number
	 * @param string $newProfileSalt string containing passowrd salt
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(?int $newProfileId, ?string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileEmail, string $newProfileHash, ?string $newProfilePhone, string $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfilePhone($newProfilePhone);
			$this->setProfileSalt($newProfileSalt);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int|null value of profile id (or null if new Profile)
	 **/
	public function getProfileId() {
		return($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId value of new profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(?int $newProfileId) {
		// verify the profile id is positive
		//if($newProfileId <= 0) {
		//	throw(new \RangeException("profile id is not positive"));
		//}

		// convert and store the profile id
		$this->profileId = $newProfileId;


	}

	/**
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token
	 */
	public function getProfileActivationToken () {
		return($this->profileActivationToken);
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 *
	 */
	public function setProfileActivationToken(?string $newProfileActivationToken ) {
		//make sure activation token is lower case and secure
		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("user activation token cannot be null"));
		}

		//make sure user activation token is only 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->profileActivationToken = $newProfileActivationToken;
	}


	/**
	 * accessor method for at handle
	 *
	 * @return string value of at handle
	 **/
	public function getProfileAtHandle() {
		return($this->profileAtHandle);
	}

	/**
	 * mutator method for at handle
	 *
	 * @param string $newProfileAtHandle new value of at handle
	 * @throws \InvalidArgumentException if $newAtHandle is not a string or insecure
	 * @throws \RangeException if $newAtHandle is > 32 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/
	public function setProfileAtHandle(string $newProfileAtHandle) {
		// verify the at handle is secure
		$newProfileAtHandle = trim($newProfileAtHandle);
		$newProfileAtHandle = filter_var($newProfileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAtHandle) === true) {
			throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
		}

		// verify the at handle will fit in the database
		if(strlen($newProfileAtHandle) > 32) {
			throw(new \RangeException("profile at handle is too large"));
		}

		// store the at handle
		$this->profileAtHandle = $newProfileAtHandle;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getProfileEmail() {
		return $this->profileEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newProfileEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail) {
		// verify the email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}

		// verify the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}

		// store the email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profileHash
	 *
	 * @return string value of hash
	 */

	public function getProfileHash() {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash(string $newProfileHash) {
		//enforce that the hash is properly formatted
		//$newProfileHash = trim($newProfileHash);
		//$newProfileHash =strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}

		//enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		//enforce that the hash is exactly 128 characters.
		//if(strlen($newProfileHash) !== 128 ) {
		//	throw(new \RangeException("profile hash must be 128 characters"));
		//}

		//store the hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for phone
	 *
	 * @return string value of phone
	 **/
	public function getProfilePhone() {
		return($this->profilePhone);
	}

	/**
	 * mutator method for phone
	 *
	 * @param string $newProfilePhone new value of phone
	 * @throws \InvalidArgumentException if $newPhone is not a string or insecure
	 * @throws \RangeException if $newPhone is > 32 characters
	 * @throws \TypeError if $newPhone is not a string
	 **/
	public function setProfilePhone(?string $newProfilePhone) {
		// verify the phone is secure
		$newProfilePhone = trim($newProfilePhone);
		$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfilePhone) === true) {
			throw(new \InvalidArgumentException("profile phone is empty or insecure"));
		}

		// verify the phone will fit in the database
		if(strlen($newProfilePhone) > 32) {
			throw(new \RangeException("profile phone is too large"));
		}

		// store the phone
		$this->profilePhone = $newProfilePhone;
	}

	/**
	 *accessor method for profile salt
	 *
	 * @return string representation of the salt hexadecimal
	 */
	public function getProfileSalt() {
		return $this->profileSalt;
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 * @throws \InvalidArgumentException if the salt is not secure
	 * @throws \RangeException if the salt is not 64 characters
	 * @throws \TypeError if profile salt is not a string
	 */
	public function setProfileSalt(string $newProfileSalt) {
		//enforce that the salt is properly formatte
		//d
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt =strtolower($newProfileSalt);

		//enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		//enforce that the salt is exactly 64 characters.
		//if(strlen($newProfileSalt) !==64 ) {
		//	throw(new \RangeException("profile salt must be 128 characters"));
		// }

		//store the hash
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the profileId is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}

		// create query template
		$query = "INSERT INTO profile(profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt) VALUES (:profileActivationCode, :profileAtHandle, :profileEmail, :profileHash, :profilePhone, :profileSalt)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash"=> $this->profileHash, "profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt ];
		$statement->execute($parameters);

		// update the null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// enforce the profileId is not null (i.e., don't delete a profile that does not exist)
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that does not exist"));
		}

		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		// enforce the profileId is not null (i.e., don't update a profile that does not exist)
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that does not exist"));
		}

		// create query template
		$query = "UPDATE profile SET profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash"=> $this->profileHash, "profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);
	}

	/**
	 * gets the Profile by profile id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param int $profileId profile id to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, int $profileId) {
		// sanitize the profile id before searching
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not postive"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"],$row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * gets the Profile by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmail email to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail) {
		// sanitize the email before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("not a valid email"));
		}

		// create query template
		$query = "SELECT FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"],$row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * gets the Profile by at handle
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileAtHandle at handle to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileAtHandle(\PDO $pdo, string $profileAtHandle) {
		// sanitize the at handle before searching
		$profileAtHandle = trim($profileAtHandle);
		$profileAtHandle = filter_var($profileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileAtHandle) === true) {
			throw(new \PDOException("not a valid at handle"));
		}

		// create query template
		$query = "SELECT  profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileAtHandle = :profileAtHandle";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileAtHandle" => $profileAtHandle];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"],$row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * get the profile by profile activation token
	 *
	 * @param string $profileActivationToken
	 * @param \PDO object $pdo
	 * @return profile object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) {
		//make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) ===false ) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}

		//create the query template
		$query = "SELECT  profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);

		// bind the profile activation token to the placeholder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"],$row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		return(get_object_vars($this));

	}
}