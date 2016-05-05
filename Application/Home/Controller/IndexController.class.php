<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;
use Think\Page;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){

        // $category = D('Category')->getTree();
        // $lists    = D('Document')->lists(null);

        // $this->assign('category',$category);//栏目
        // $this->assign('lists',$lists);//列表
        // $this->assign('page',D('Document')->page);//分页
        
        //院内新闻
        $news = D('Document')->lists(40);
        //优惠政策
        $policy = D('Document')->lists(41);
        //挂号大厅
        $hall = D('Document')->lists(42);
        //椎间盘突出
        $zjp = D('Document')->limit(6)->lists(101);
        //风湿
        $fs =  D('Document')->limit(6)->lists(44);
        //类风湿
        $lfs = D('Document')->limit(6)->lists(67);
        //产后风湿
        $chf = D('Document')->limit(6)->lists(117);
        //强直性脊柱炎
        $qzx = D('Document')->limit(6)->lists(109);
        //关节炎
        $gjy = D('Document')->limit(6)->lists(85);
        //中安绿色疗法
        $green =  D('Document')->limit(6)->lists(137);
        //专家团队
        $team = D('Document')->lists(136);
       
        // 案例分享 position 4 风湿60 椎间盘突出106 类风湿72
        $case1 = M('Document')->where(array('category_id'=>60,'position'=>4,'status'=>1))->limit(1)->select();
        $case2 = M('Document')->where(array('category_id'=>106,'position'=>4,'status'=>1))->limit(1)->select();
        $case3 = M('Document')->where(array('category_id'=>72,'position'=>4,'status'=>1))->limit(1)->select();
        $case4 = array_merge($case1,$case2);
        $case = array_merge($case3,$case4);
        $this->assign('case',$case);
        $this->assign('team',$team);
        $this->assign('green',$green);
        $this->assign('zjp',$zjp);
        $this->assign('fs',$fs);
        $this->assign('lfs',$lfs);
        $this->assign('chf',$chf);
        $this->assign('qzx',$qzx);
        $this->assign('gjy',$gjy);
        $this->assign('hall',$hall);
        $this->assign('policy',$policy);
        $this->assign('news',$news);
        $this->assign('symptom',$symptom);
        $this->display();
    }
    //二级病种页面
    public function topic($cate_name=null){
        if(!empty($cate_name)){

            $know_id = M('category')->where(array('name'=>$cate_name.'-know','status'=>1))->field('id')->find();
            $early_id = M('category')->where(array('name'=>$cate_name.'-early','status'=>1))->field('id')->find();
            $medium_id = M('category')->where(array('name'=>$cate_name.'-medium','status'=>1))->field('id')->find();
            $later_id = M('category')->where(array('name'=>$cate_name.'-later','status'=>1))->field('id')->find();
            $case_id = M('category')->where(array('name'=>$cate_name.'-case','status'=>1))->field('id')->find();
            $video_id = M('category')->where(array('name'=>$cate_name.'-video','status'=>1))->field('id')->find();
            //认识病种
            $know = M('Document')->where(array('category_id'=>$know_id['id'],'status'=>1))->find();
            //早期
            $early = M('Document')->where(array('category_id'=>$early_id['id'],'status'=>1))->limit(4)->select();
            //中期
            $medium = M('Document')->where(array('category_id'=>$medium_id['id'],'status'=>1))->limit(4)->select();
            //晚期
            $later = M('Document')->where(array('category_id'=>$later_id['id'],'status'=>1))->limit(4)->select();
            //案例分享
            $case = M('Document')->where(array('category_id'=>$case_id['id'],'status'=>1,'position'=>array('neq',4)))->limit(4)->select();
            //视频
            $video1 = M('Document')->where(array('category_id'=>$video_id['id'],'status'=>1))->field('id')->find();
            $video = D('Document')->detail($video1['id']);
            //只需三步
            $painful = D('Document')->limit(4)->lists(80,'`level` desc');
            $cost =  D('Document')->limit(4)->lists(83,'`level` desc');
            $repeat =  D('Document')->limit(4)->lists(82,'`level` desc');
            $care =  D('Document')->limit(4)->lists(81,'`level` desc');
            
            //感谢信
            $thanks = D('Document')->limit(5)->lists(61);
            //锦旗故事
            $story = D('Document')->limit(5)->lists(62);
            //热点导读
            $hot = D('Document')->limit(8)->lists(63);
            
            $this->assign('hot',$hot);
            $this->assign('thanks',$thanks);
            $this->assign('story',$story);
            $this->assign('painful',$painful);
            $this->assign('cost',$cost);
            $this->assign('repeat',$repeat);
            $this->assign('care',$care);
            $this->assign('know',$know);
            $this->assign('early',$early);
            $this->assign('medium',$medium);
            $this->assign('later',$later);
            $this->assign('case',$case);
            $this->assign('video',$video);
            $this->display();
        }else{
            $this->error('参数错误');
        }   

    	
    }
    //列表页面
    public function lists($cid,$p = 1){
        if(!empty($cid)){
          //数据        
          $data = D('Document')->page($p,20)->lists($cid);
          // 分页
          $total = count(D('Document')->lists($cid));
          $this->assign('_page',$this->fpage($total,20));

          //热门关键词
          $hotkey = D('Document')->lists(132);
          $this->assign('hotkey',$hotkey);
          $this->assign('data',$data);
        }else{
            $this->error('参数错误');
        }
    	$this->display();
    }
    //更多列表
    public function morelists($p = 1){
        //案例更多 风湿60 椎间盘突出106 类风湿72
        $fs = D('Document')->lists(60);
        $zjp = D('Document')->lists(106);
        $lfs = D('Document')->lists(72);
        $arr1 = array_merge($fs,$zjp);
        $data = array_merge($arr1,$lfs);
        // 分页
        $total = count($data);
        $this->assign('_page',$this->fpage($total,20));
        //热门关键词
        $hotkey = D('Document')->lists(132);
        $this->assign('hotkey',$hotkey);
        $this->assign('data',$data);
        $this->display('lists');
    }
    //详细页面
    public function details($id=null){
        if(!empty($id)){
            //热门关键词
            $hotkey = D('Document')->lists(132);
            $data1 = D('Document')->detail($id);
            $this->assign('hotkey',$hotkey);
            //$data = str_replace("/newzayy", "", $data1);
            $data = str_replace('"/Uploads', '"/newzayy/Uploads', $data1);
            $this->assign('data',$data);
        }else{
            $this->error('参数错误');
        }
    	$this->display();
    }
    //主治疾病ajax请求
    public function diseasesAjax($cate=null){
         if(empty($cate)){
            $this->ajaxReturn(-1);//参数错误
         }else{
            $data = D('Document')->lists($cate);
            $this->ajaxReturn($date);
         }

         
    }
    //搜索页
    public function search($p = 1){
        
        if($_REQUEST['keyword'] == ''){
            $this->error('查询关键词不能为空');
        }else{
            $map['title'] = array('like','%'.$_REQUEST['keyword'].'%');
            $map['status'] =1;
            $data = M('Document')->where($map)->page($p,10)->select();
            $keyword = array(
                'name'=>$_POST['keyword'],
                'create_time'=>time(),
                'ip'=>$_SERVER['REMOTE_ADDR']
                );
            M('keyword')->add($keyword);
            $total = count(M('Document')->where($map)->select());
            $this->assign('_page',$this->fpage($total,10));
            $this->assign('data',$data);
            $this->display();
        }
    }
    //分页
    public function fpage($total,$listRow){
            $page = new \Think\Page($total,$listRow);
            if($total>$listRows){
                $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            }
            return $page->show();
            
    }
    //医院介绍
    public function introduce(){
        //中安介绍140专家团队141十大荣誉142网上挂号143
        $introduce = D('Document')->limit(1)->lists(140);
        $proteam = D('Document')->limit(4)->lists(141,'`level` desc');
        $honor = D('Document')->lists(142);
        $online = D('Document')->limit(1)->lists(143);
        // 优惠政策
        $policy = D('Document')->limit(1)->lists(41);
        $this->assign('policy',$policy);
        $this->assign('online',$online);
        $this->assign('introduce',$introduce);
        $this->assign('proteam',$proteam);
        $this->assign('honor',$honor);
        $this->display();
    }
    // 专家团队
    public function proteam($cid=141,$p=1){
        if(!empty($cid)){
          //数据        
          $data1 = D('Document')->page($p,5)->lists(144);
          $data2 = D('Document')->page($p,3)->lists(145);
          $data3 = D('Document')->page($p,2)->lists(146);
          $data4 = array_merge($data1,$data2);
          $data  = array_merge($data4,$data3); 
          // 分页
          $total = count(D('Document')->lists(144)) + count(D('Document')->lists(145)) + count(D('Document')->lists(146));
          $this->assign('_page',$this->fpage($total,10));
          $this->assign('data',$data);
        }else{
            $this->error('参数错误');
        }
        $this->display();
    }
    //疗法
    public function treat(){
        //专家团队 内蒙144 河北145 山东146 147
        $hbpro = D('Document')->limit(6)->lists(145);
        $nmpro = D('Document')->limit(7)->lists(144);
        $sdpro = D('Document')->limit(5)->lists(146);
        // 优惠政策
        $policy = D('Document')->limit(1)->lists(41);
        //视频病历
        $videocase = D('Document')->limit(4)->lists(147,'`level` desc');
        $this->assign('videocase',$videocase);
        $this->assign('policy',$policy);
        $this->assign('hbpro',$hbpro);
        $this->assign('nmpro',$nmpro);
        $this->assign('sdpro',$sdpro);
        $this->display();
    }
    //ajax pro
    public function proajax($id = 0){
        if($id === false){
            $this->ajaxReturn(-1);
        }else{
            $data = D('Document')->detail($id);
            $data['cover_img'] = get_cover($data['cover_id'],'path');
            $this->ajaxReturn($data);
        }
        
    }
}