<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

class DB {
    protected $conn;
    protected $db = 'blog';
    protected $user = 'root';
    protected $pass = '';

    public function __construct()
    {
        if (!$this->conn) {
            $this->conn = mysqli_connect('localhost',$this->user,$this->pass,$this->db);
            mysqli_set_charset($this->conn,"UTF8");
        }
    }

    public function query($sql)
    {
        mysqli_query($this->conn,$sql);
    }

    public function handleSQL($sql)
    {
        // $this->connect();
        mysqli_query($this->conn,$sql);
    }

    public function getList($sql)
    {
        // $this->connect();
        $data = [];
        $query = mysqli_query($this->conn,$sql);
        while ($row = mysqli_fetch_array($query,1)) {
            $data[] = $row;
        }

        return $data;
    }

    public function getOneRow($table,$id)
    {
        // $this->connect();
        $sql = "SELECT * FROM $table WHERE id = $id";
        $query = mysqli_query($this->conn,$sql);
        $data = mysqli_fetch_assoc($query);
        return $data;
    }

    public function getOneRowFromTable($table)
    {
        // $this->connect();
        $sql = "SELECT * FROM $table";
        $query = mysqli_query($this->conn,$sql);
        $data = mysqli_fetch_assoc($query);
        return $data;
    }
    
    public function checkLogin($username,$password)
    {
        // $this->connect();
        $sql = "SELECT * FROM account WHERE `username` = '$username' AND `password` = '$password'";
        $data = mysqli_fetch_assoc(mysqli_query($this->conn,$sql));
        if (is_array($data)) {
            return ([
                'status' => true,
                'id' => $data['id'],
                'username' =>$data['username']
            ]);
        }
        return ['status' => false];
    }

    public function getOneRowWithSQL($sql)
    {
        // $this->connect();
        $query = mysqli_query($this->conn,$sql);
        $data = mysqli_fetch_assoc($query);
        return $data;
    }

    public function getCountRow($sql)
    {
        $result = mysqli_query($this->conn,$sql);
        $data = mysqli_fetch_assoc($result);
        // mysqli_close($this->conn);
        return $data['total'];
    }

    public function checkExistsRow($sql)
    {
        $query = mysqli_query($this->conn,$sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }

        return false;
    }

    public function getCountOfTable($table,$condition = 1)
    {
        $sql = "SELECT COUNT(*) as total FROM $table WHERE $condition";
        $data = $this->getOneRowWithSQL($sql);
        return $data;
    }

    public function checkAdmin($username,$password)
    {
        $sql = "SELECT * FROM b_user WHERE `username` = '$username' AND `password` = '$password'";
        $data = $this->getOneRowWithSQL($sql) ?? [];
        if (count($data) >= 1) {
            if ($data['admin'] == 1) {
                return true;
            }
        }

        return false;
    }
}
