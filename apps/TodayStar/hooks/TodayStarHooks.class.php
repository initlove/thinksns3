<?php

class TodayStarHooks extends Hooks
{
	/**
     * 主页右钩子
     */
    public function home_index_right_top()
    {
	   $data = model('Cache')->get('TodayStarData');
	   if($data==false)
	   {
			$stime = mktime(0,  0,  0,  date('m'), date('d'), date('Y'));
			$etime = mktime(23, 59, 59, date('m'), date('d'), date('Y'));

			//查出原创微博统计
			$db_prefix = C('DB_PREFIX');
			$sql_weibo = "SELECT count(*) as weibo_count,uid FROM {$db_prefix}feed WHERE `publish_time` >= {$stime} AND `publish_time` <= {$etime} AND is_del=0 GROUP BY uid";
			$res_weibo = M('')->query( $sql_weibo );
			$stat_weibo = array();
			foreach($res_weibo as $vw){
			   $stat_weibo[$vw['uid']] = $vw['weibo_count'];
			}
		   //查出微博评论统计
		   $sql_comment = "SELECT count(*) as comment_count,uid FROM {$db_prefix}comment WHERE `ctime` >= {$stime} AND `ctime` <= {$etime} AND is_del=0 GROUP BY uid";
		   $res_comment = M('')->query($sql_comment);
		   $stat_comment = array();
		   foreach($res_comment as $vc){
			  $stat_comment[$vc['uid']] = $vc['comment_count'];
		   }
		
		   //进行处理
		   $comment_uids = array_keys($stat_comment);
		   foreach($stat_weibo as $k =>$v){
			 if(in_array($k,$comment_uids)){
				 $stat_comment[$k] = $stat_comment[$k] + $v*5;
			 }else{
				 $stat_comment[$k] = $v*5;
			 }
		   }
           arsort($stat_comment);
		   if(count($stat_comment)>5)
			  $list = array_slice($stat_comment,0,5,true);
		   else
			  $list = $stat_comment;  
       
		  
		   $data_temp = array();
		   $i=0;
		   foreach($list as $kk=>$vv){
			  $data_temp[$i]['uid'] = $kk;
			  $data_temp[$i]['count'] = $vv;
			  $i++;
		   }
		   $data = array();
		   foreach($data_temp as $kd =>$kv){
			  $data[$kd]['user_info'] = model('User')->getUserInfo($kv['uid']); 
			  $data[$kd]['uid'] = $kv['uid'];
			  $data[$kd]['count'] = $kv['count'];
		   }
		   //缓存数据
		  model('Cache')->set('TodayStarData',$data,120);  //缓存2分钟
		}
	   $this->assign('todaystar',$data);
       $this->display('todaystar');
    }
}