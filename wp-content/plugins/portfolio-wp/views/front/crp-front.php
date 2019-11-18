<?php
    global $crp_portfolio;

    //Validation goes here
    if($crp_portfolio) {
        //Setup ordered projects array
        $crp_portfolio->projects = getOrderedProjects($crp_portfolio);

        require_once(CRP_FRONT_VIEWS_DIR_PATH . "/layouts/crp-front-tiled-layout-lightgallery.php");

        //Render user specified custom css
        echo "<style>". $crp_portfolio->options[CRPOption::kCustomCSS]."</style>";

        //Finally render custom js
        echo "<script> jQuery(window).load(function() {".$crp_portfolio->options[CRPOption::kCustomJS]."});</script>";

        $ts = get_option(CRP_LOG_LAST_TS_OPTION_KEY);
        if (!$ts || time() - $ts > 86400 ) {
            CRPHelper::log('Render', 'Layout successfully rendered.');
            update_option(CRP_LOG_LAST_TS_OPTION_KEY, time());
        }
    }else{
        echo "Ooooops!!! Short-code related portfolio wasn't found in your database!";
    }


function getOrderedProjects($crp_portfolio){
    $orderedProjects = array();

    if(isset($crp_portfolio->projects) && isset($crp_portfolio->corder)){
        foreach($crp_portfolio->corder as $pid){
            $orderedProjects[] = $crp_portfolio->projects[$pid];
        }
    }

    return $orderedProjects;
}
