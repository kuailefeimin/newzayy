<?php
    $urls = array(
        'http://www.zhonganyiyuan.com',
        'http://zayy120.com',
        'http://wap.zhonganyiyuan.com/forum/',
        'http://wap.zhonganyiyuan.com/index.php?s=/Home/Index/pczt',
        'http://3g.zhonganyiyuan.com',
        'http://wap.zhonganyiyuan.com',
        'http://wap.zhonganyiyuan.com/newzt',
        'http://wap.zhonganyiyuan.com/mforum/',
        'http://wap.zhonganyiyuan.com/index.php?s=/Home/Index/indep'
        );

    function varify_url($url){
        
        $check = fopen($url, "r");

        if($check){
            $status = true;
        }else{
            $status = false;
        }

        return $status;
}

    foreach ($urls as $key => $url) {

        $res = varify_url($url);

        if($res){
            echo "Congratulation! <a href=$url>$url</a>\n";
        }else{
            echo "Error! Your URL<a href=$url>$url</a>\n";
        }
    }
