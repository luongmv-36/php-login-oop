<?php

class User{
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();

        $this->_sessionName	= Config::get('session/session_name');

        $this->_cookieName	= Config::get('remember/cookie_name');

        if (!$user)
        {
            if (Session::exists($this->_sessionName))
            {
                $user = Session::get($this->_sessionName);

                if ($this->find($user))
                {
                    $this->_isLoggedIn = true;

                }else{
                    //process logout
                }

            }

        }else{
            $this->find($user);
        }
    }

    public function find($user = null)
    {
        if ($user)
        {
            $field = (is_numeric($user)) ? 'uid' : 'username';

            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count())
            {
                $this->_data = $data->first();
                return true;
            }
        }

    }

    public function login($username = null, $password = null, $remember = false)
    {
        if (!$username && !$password && $this->exists())
        {
            Session::put($this->_sessionName, $this->data()->uid);
        }
        else{
            $user = $this->find($username);

            if ($user){
//                if ($this->data()->password === Hash::)
            }
        }
    }

    public function create($fields = array())
    {
        if(!$this->_db->insert('users', $fields))
        {
            throw new Exception("Problem Creating User Account");

        }
    }

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
}