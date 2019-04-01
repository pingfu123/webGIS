<?php
include_once './Server.php';
include_once './UserServer.php';

$requestobj = json_decode($_REQUEST["request"]);

$sv = new Server();


$type = $requestobj->type;
$typearr = explode("_", $type);

switch ($typearr[0]){
    case "USER":
        $sv = new UserServer();
        break;
    case "FRIENDS":
        $sv = new UserServer();
        break;
}

$sv->setRequest($requestobj);
if(!$sv->openConnection()){
    echo json_encode($sv->getResponse());
    exit(1);
}
$sv->run();
$sv->closeConnection();


echo json_encode($sv->getResponse());

