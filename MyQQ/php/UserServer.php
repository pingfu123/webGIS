<?php

include_once './Server.php';


class UserServer extends Server{
    public function __construct() {
        parent::__construct();
    }
    
    public function __destruct() {
        parent::__destruct();
    }
    
    public function run() {
        parent::run();

        switch ($this->_request->type){
            case "USER_LOGIN":
                $this->login();
                break;
            case "USER_REGISTER":
                $this->register();
                break;
            case "FRIENDS_GET":
                $this->getfriends();
                break;
        }
    }
    
    protected function login(){
        
        $sql = "select count(1) from qq_user where username=$1 and password=md5($2)";
        $result = pg_query_params($this->_connection,$sql,array(
            $this->_request->params->username,
            $this->_request->params->password
        ));
        $row = pg_fetch_row($result);
        if(intval($row[0]) === 1){
            $this->makeResponse(true, "登陆成功");
        }else{
            $this->makeResponse(false, "登录失败");
        }
        pg_free_result($result);
    }
    
    protected function register(){
        $this->makeResponse(true, "register ok");
    }
    
    protected function getfriends(){
        $username= $this->_request->params->username;
        $sql="select user2 from qq_friendship where user1='$username';";
        $result= pg_query($this->_connection,$sql);
        $row= pg_fetch_all($result);
        $this->makeResponse(true, "好友列表加载完成", $row);
    }
}
