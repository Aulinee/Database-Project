<?php 
class User{
    private $userID;
    private $userName;
    private $firstName;
    private $lastName;
    private $password;
    private $authenticated;

    /* Constructor */
	public function __construct()
	{
		/* Initialize the $id and $name variables to NULL */
		$this->userID = NULL;
		$this->userName = NULL;
        $this->firstName = NULL;
        $this->lastName = NULL;
        $this->password = NULL;
		$this->authenticated = FALSE;
	}
	
	/* Destructor */
	public function __destruct(){}

    /* A sanitization check for the account username */
    public function isNameValid(string $name): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;
        
        /* Example check: the length must be between 8 and 16 chars */
        $len = mb_strlen($name);
        
        if (($len < 8) || ($len > 16))
        {
            $valid = FALSE;
        }
        
        /* You can add more checks here */
        return $valid;
    }

    /* A sanitization check for the account password */
    public function isPasswdValid(string $passwd): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;
        
        /* Example check: the length must be between 8 and 16 chars */
        $len = mb_strlen($passwd);
        
        if (($len < 8) || ($len > 16))
        {
            $valid = FALSE;
        }
        
        /* You can add more checks here */
        return $valid;
    }

    /* Returns the account id having $name as name, or NULL if it's not found */
    public function getIdFromName(string $name): ?int
    {
        /* Global $pdo object */
        global $pdo;
        
        /* Since this method is public, we check $name again here */
        if (!$this->isNameValid($name))
        {
            throw new Exception('Invalid user name');
        }
        
        /* Initialize the return value. If no account is found, return NULL */
        $id = NULL;
        
        /* Search the ID on the database */
        $query = 'SELECT account_id FROM myschema.accounts WHERE (account_name = :name)';
        $values = array(':name' => $name);
        
        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
        }
        
        $row = $res->fetch(PDO::FETCH_ASSOC);
        
        /* There is a result: get it's ID */
        if (is_array($row))
        {
            $id = intval($row['account_id'], 10);
        }
        
        return $id;
    }

    /* Add a new account to the system and return its ID (the account_id column of the accounts table) */
    public function addAccount(string $name, string $passwd): int
    {
        /* Global $pdo object */
        global $pdo;
        
        /* Trim the strings to remove extra spaces */
        $name = trim($name);
        $passwd = trim($passwd);
        
        /* Check if the user name is valid. If not, throw an exception */
        if (!$this->isNameValid($name))
        {
            throw new Exception('Invalid user name');
        }
        
        /* Check if the password is valid. If not, throw an exception */
        if (!$this->isPasswdValid($passwd))
        {
            throw new Exception('Invalid password');
        }
        
        /* Check if an account having the same name already exists. If it does, throw an exception */
        if (!is_null($this->getIdFromName($name)))
        {
            throw new Exception('User name not available');
        }
        
        /* Finally, add the new account */
        
        /* Insert query template */
        $query = 'INSERT INTO myschema.accounts (account_name, account_passwd) VALUES (:name, :passwd)';
        
        /* Password hash */
        $hash = password_hash($passwd, PASSWORD_DEFAULT);
        
        /* Values array for PDO */
        $values = array(':name' => $name, ':passwd' => $hash);
        
        /* Execute the query */
        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
        }
        
        /* Return the new ID */
        return $pdo->lastInsertId();
    }
}

?>