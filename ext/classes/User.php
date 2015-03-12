<?php
class User {
    private $uid;     // user id
    private $fields;  // other record fields

    // initialize a User object
    public function __construct() {
        $this->uid = null;
        $this->fields = array('username' => '',
                              'password' => '',
                              'email' => '',
                              'isActive' => false);
    }

    // override magic method to retrieve properties
    // advantage here is no need to have separate get_xxxx
    // methods to retrieve individual properties
    public function __get($field) {
        if ($field == 'userId') {
            return $this->uid;
        }
        else {
            return $this->fields[$field];
        }
    }

    // override magic method to set properties
    // same advantage as for __get() and here we also do
    // some data validation
    public function __set($field, $value) {
        if (array_key_exists($field, $this->fields)) {
            $this->fields[$field] = $value;
        }
    }

    // return if username is valid format
    public static function validateUsername($username) {
        return preg_match('/^[A-Z0-9]{2,20}$/i', $username);
    }
    
    // return if email address is valid format
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    // return an object populated based on the record's user id
    public static function getById($dbc, $uid) {
        $u = new User();

        $query = sprintf('SELECT username, password, email, is_active ' .
            'FROM users WHERE user_id = %d',
            $uid);

        write_db_log($query);
        $res = mysqli_query($dbc, $query);

        if (mysqli_num_rows($res)) {
            $row = mysqli_fetch_assoc($res);
            $u->username = $row['username'];
            $u->password = $row['password'];
            $u->email = $row['email'];
            $u->isActive = $row['is_active'];
            $u->uid = $uid;
        }
        mysqli_free_result($res);

        return $u;
    }

    // return an object populated based on the record's username
    public static function getByUsername($dbc, $username)
    {
        $u = new User();

        $query = sprintf('SELECT user_id, password, email, is_active ' .
            'FROM users WHERE username = "%s"',
            mysqli_real_escape_string($dbc, $username));

        write_db_log($query);
        $res = mysqli_query($dbc, $query);

        if (mysqli_num_rows($res)) {
            $row = mysqli_fetch_assoc($res);
            $u->username = $username;
            $u->password = $row['password'];
            $u->email = $row['email'];
            $u->isActive = $row['is_active'];
            $u->uid = $row['user_id'];
        }

        mysqli_free_result($res);
        return $u;
    }

    public static function getByEmail($dbc, $email)
    {
      $u = new User();

      $query = sprintf('SELECT user_id, username, password, is_active ' .
        'FROM users WHERE email = "%s"',
        mysqli_real_escape_string($dbc, $email));

      write_db_log($query);
      $res = mysqli_query($dbc, $query);

      if (mysqli_num_rows($res)) {
        $row = mysqli_fetch_assoc($res);
        $u->email = $email;
        $u->username = $row['username'];
        $u->password = $row['password'];
        $u->isActive = $row['is_active'];
        $u->uid = $row['user_id'];
      }

      mysqli_free_result($res);
      return $u;
    }

    // save the record to the database
    public function save($dbc)
    {
        if ($this->uid) {
            $query = sprintf('UPDATE users SET username = "%s", ' .
                'password = "%s", email = "%s", is_active = %d ' .
                'WHERE user_id = %d',
                mysqli_real_escape_string($dbc, $this->username),
                mysqli_real_escape_string($dbc, $this->password),
                mysqli_real_escape_string($dbc, $this->email),
                $this->isActive,
                $this->userId);

          write_db_log($query);
          mysqli_query($dbc, $query);
        }
        else {
            $query = sprintf('INSERT INTO users (username, password, ' .
                'email, is_active) VALUES ("%s", "%s", "%s", %d)',
                mysqli_real_escape_string($dbc, $this->username),
                mysqli_real_escape_string($dbc, $this->password),
                mysqli_real_escape_string($dbc, $this->email),
                $this->isActive);

          write_db_log($query);
          mysqli_query($dbc, $query);

            $this->uid = mysqli_insert_id($dbc);
        }
    }

    // set the record as inactive and return an activation token
    public function setInactive($dbc) {
        $this->isActive = false;
        $this->save($dbc); // make sure the record is saved

        $token = random_text(10);
        $query = sprintf('INSERT INTO pending (user_id, token) ' .
            'VALUES (%d, "%s")',
            $this->uid,
            $token);

        write_db_log($query);
        mysqli_query($dbc, $query);

        return $token;
    }

    // clear the user's pending status and set the record as active
    public function setActive($dbc, $token) {
        $query = sprintf('SELECT token FROM pending WHERE user_id = %d ' .
            'AND token = "%s"',
            $this->uid,
            mysqli_real_escape_string($dbc, $token));

        write_db_log($query);
        $res = mysqli_query($dbc, $query);

        if (!mysqli_num_rows($res)) {
            mysqli_free_result($res);
            return false;
        }
        else {
            mysqli_free_result($res);
            $query = sprintf('DELETE FROM pending WHERE user_id = %d ' .
                'AND token = "%s"',
                $this->uid,
                mysqli_real_escape_string($dbc, $token));

            write_db_log($query);
            mysqli_query($dbc, $query);

            $this->isActive = true;
            $this->save($dbc);
            return true;
        }
    }
}
?>
