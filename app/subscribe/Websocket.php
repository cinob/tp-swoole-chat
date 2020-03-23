<?php
declare (strict_types = 1);

namespace app\subscribe;

class Websocket
{

    protected $socket = null;
    protected $room = null;
    protected $table = null;

    public function __construct()
    {
    	$this->socket = app('think\swoole\Websocket');
    	$this->room = app('think\swoole\Websocket\Room');
    	$this->table = app('swoole.table.users');
    }

    /**
     * 加入房间
     * @param $msg
     * @author Cinob
     */
    public function onJoin($msg)
    {
//        加入房间
        $this->table->set((string)(string)$this->socket->getSender(), ['name' => $msg['name']]);
        $this->socket->join($msg['room']);
//        将用户名和fd关联起来并存入table
        $this->socket->emit('join', $msg);
        $this->sendMsg($msg['room'], '用户 '.$msg['name'].' 加入房间');
    }

    /**
     * 发送消息
     * @param $msg
     * @author Cinob
     */
    public function onMessage($msg)
    {
        $this->sendMsg($msg['room'],'用户 '.$this->table->get((string)$this->socket->getSender(), 'name').' 说： '.$msg['msg']);
    }

    /**
     * 离开房间
     * @param $msg
     * @author Cinob
     */
    public function onLeave($msg)
    {
        $name = $this->table->get((string)$this->socket->getSender(), 'name');
        $this->table->del((string)$this->socket->getSender());
        $this->socket->leave($msg['room']);
        $this->socket->emit('leave', array_merge(['msg' => '用户 '.$name.' 离开房间'], $msg));
        $this->sendMsg($msg['room'], '用户 '.$name.' 离开房间');
    }

    public function sendMsg($room, $msg)
    {
        $this->socket->to($room)->emit('message', [
        	'msg' => $msg
        ]);
    }
}
