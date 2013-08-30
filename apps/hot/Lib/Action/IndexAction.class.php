<?php
/**
 * 找人首页控制器
 * @author Liang Chenye <liangchenye@gmail.com>
 * @version TS3.0
 */
class IndexAction extends Action
{
        private $event;

	public function _initialize()
	{
		$this->appCssList[] = 'hot.css';


        	//读取'活动'推荐列表
 	        $this->event = D( 'Event','event' );
	        $is_hot_list = $this->event->getHotList();
	        $this->assign('is_hot_list',$is_hot_list);

			
	}

	public function index()
	{
		//设置‘活动’列表
                $order = 'joinCount DESC,attentionCount DESC,cTime DESC';

		//设置 ‘认证人员’列表
                $type = 'official'; 
                $this->assign('type', $type);
		$conf = model('Xdata')->get('admin_User:official');
		$this->assign('topUser', $conf['top_user']);
		$cate = model('CategoryTree')->setTable('user_official_category')->getNetworkList();

		$cate = getSubByKey($cate,'title');
		$this->setTitle( $title );
		$this->setKeywords( $title );
		$this->setDescription( implode(',', $cate) );
//DLIANG: we get the event list or hot list here, so the image was assigned here
	        $result  = $this->event->getEventList($map,$order,$this->mid,$_GET['order'],200,200);
                $this->assign($result);

		$weiba_list = D('Weiba', 'weiba')->getWeibaList(3);
		$this->assign('weiba', $weiba_list);

		$this->display();
	}

	/**
	 * 获取指定父分类的树形结构
	 * @return integer $pid 父分类ID
	 * @return array 指定父分类的树形结构
	 */
	public function getNetworkList()
	{
		$pid = intval($_REQUEST['pid']);
		$list = model('CategoryTree')->setTable('area')->getNetworkList($pid);
		$id = $pid + 100;
		// exit($list[$id]['child']);
		//dump($list[$id]['child']);
		exit(json_encode($list[$id]['child']));
	}

        /**
         * 热帖推荐
         * @param integer limit 获取微吧条数
         * @return void
         */
        private function _post_recommend($limit){
                $db_prefix = C('DB_PREFIX');
                $sql = "SELECT a.* FROM `{$db_prefix}weiba_post` a, `{$db_prefix}weiba` b WHERE a.weiba_id=b.weiba_id AND ( b.`is_del` = 0 ) AND ( a.`recommend` = 1 ) AND ( a.`is_del` = 0 ) ORDER BY a.recommend_time desc LIMIT ".$limit;
                $post_recommend = D('weiba_post')->query($sql);
                $weiba_ids = getSubByKey($post_recommend, 'weiba_id');
                $nameArr = $this->_getWeibaName($weiba_ids);
                foreach($post_recommend as $k=>$v){
                        $post_recommend[$k]['weiba'] = $nameArr[$v['weiba_id']];
                }
                $this->assign('post_recommend',$post_recommend);
        }

}
