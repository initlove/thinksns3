<?php
/**
 * TS插件 - 今日之星
 * @author 云脉网
 * @version TS3.0
 */
class TodayStarAddons extends NormalAddons
{
	protected $version = '1.0';
	protected $author = '云脉网';
	protected $site = '';
	protected $info = '今日之星';
	protected $pluginName = '今日之星';
	protected $sqlfile = '暂无';
	protected $tsVersion = "3.0";
	
	/**
	 * 获的改插件使用了那些钩子聚合类，那些钩子是需要进行排序的
	 * @return void
	 */
	public function getHooksInfo()
	{
		$hooks['list'] = array('TodayStarHooks');
		return $hooks;
	}

	/**
	 * 后台管理入口
	 * @return array 管理相关数据
	 */
	public function adminMenu()
	{ 

	}

	public function start()
	{

	}

	public function install()
	{
        return true;
	}

	 public function uninstall()
    {
        return true;
    }
}

