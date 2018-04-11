<?php
include('config1.php');

//include('config1.php');

include('services/Website_service.php');

//$con = mysql_connect('localhost','getsport_gs',',WRI%yyw%;Z3');


 // $selected = mysql_select_db('getsport_gs') or die("Could not select databasename");
 //}else

    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    if(!is_numeric($page_number))
    {
        header('HTTP/1.1 500 Invalid page number!');
        exit;
    }
    $item_per_page = 5;
    $position = (($page_number-1) * $item_per_page);
    $input = $_REQUEST['act'];
    $request           =   new Website_service();
    echo $position; 
    switch ($input)
    {   
        case 'event':
        $request->get_event_data($item_per_page,$position);
        break;
        case 'job':
        $request->get_job_data($item_per_page,$position);
        break;
        case 'tournament':
        $request->get_tournament_data($item_per_page,$position);
        break;
        case 'article':
        $request->get_article_data($item_per_page,$position);
        break;
        default:
        break;
    }

