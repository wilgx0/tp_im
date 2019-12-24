<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Released under the MIT License.
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;


use cmf\controller\AdminBaseController;



class MainController extends AdminBaseController
{

    const  ES_SERVER  = '192.168.0.111:9501';


    public function dashboardWidget()
    {
        $dashboardWidgets = [];
        $widgets          = $this->request->param('widgets/a');
        if (!empty($widgets)) {
            foreach ($widgets as $widget) {
                if ($widget['is_system']) {
                    array_push($dashboardWidgets, ['name' => $widget['name'], 'is_system' => 1]);
                } else {
                    array_push($dashboardWidgets, ['name' => $widget['name'], 'is_system' => 0]);
                }
            }
        }

        cmf_set_option('admin_dashboard_widgets', $dashboardWidgets, true);

        $this->success('更新成功!');

    }


    public function index()
    {
        return $this->fetch();
    }

    /**
     * 首页
     * @return mixed
     */
    public function im(){

        //trace(session('token'));

        $this->assign('server_ws','ws://'.self::ES_SERVER);
        $this->assign('server_api',"http://".self::ES_SERVER);
        return $this->fetch();
    }

    /**
     * 消息通知页面
     */
    public function messageBox(){
        return send_get('http://'.self::ES_SERVER.'/User/messageBox',['token'=>session('token')]);
    }

    /**
     * 聊天记录页面
     */
    public function chatLog(){
        $params = $this->request->param();
        return send_get('http://'.self::ES_SERVER.'/User/chatLog',[
            'token'=>session('token'),
            'id'=>$params['id'],
            'type'=>$params['type']
        ]);
    }


    /**
     * 查找页面
     */
    public function find(){
        $params = $this->request->param();
        return send_get('http://'.self::ES_SERVER.'/User/find',[
            'token'=>session('token'),
            'wd'=>$params['wd'] ?? '',
            'type'=>$params['type'] ??''
        ]);
    }


    /**
     * 创建群组页面
     */
    public function createGroup(){
        return send_get('http://'.self::ES_SERVER.'/User/createGroup',[
            'token'=>session('token')
        ]);
    }


}
