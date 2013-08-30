<?php
/**
     * ***ProtocolModel 
     * 提供给TS核心调用的协议类
     *
     */
class PhotoProtocolModel extends Model {
	// 假删除用户数据
	function deleteUserAppData($uidArr) {
	}
	// 恢复假删除的用户数据
	function rebackUserAppData($uidArr) {
	}
	// 彻底删除用户数据
	function trueDeleteUserAppData($uidArr) {
	}
	// 获取评论内容
	function getSourceInfo($row_id, $_forApi) {
/* 		$blog = D ( 'blog' )->where ( 'id=' . $row_id )->field ( 'title,uid' )->find ();
		$info ['source_user_info'] = model ( 'User' )->getUserInfo ( $blog ['uid'] );
		$info ['source_url'] = U ( 'blog/Index/show', array ( 'id' => $row_id, 'mid' => $blog ['uid'] ) );
		$info ['source_body'] = $blog ['title'] . '<a class="ico-details" href="' . U ( 'blog/Index/show', array ( 'id' => $row_id, 'mid' => $blog ['uid'] ) ) . '"></a>';
 */		
		return $info;
	}
	//在个人空间里查看该应用的内容列表
/* 	function profileContent($uid){
		$map ['uid'] = $uid;
		$map ['status'] = 1;
		$list = M ( 'blog' )->where ( $map )->order ( 'cTime DESC' )->findPage ( 10 );
		foreach ( $list ['data'] as $k => $v ) {
			if (empty ( $v ['category_title'] ) && ! empty ( $v ['category'] ))
				$list ['data'] [$k] ['category_title'] = M ( 'blog_category' )->where ( 'id=' . $v ['category'] )->getField ( 'name' );
		}
		
		$tpl = APPS_PATH . '/blog/Tpl/default/Index/profileContent.html';
		return fetch ( $tpl, $list );
	} */
	
}
