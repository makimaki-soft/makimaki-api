<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * BokupanAPI Controller
 *
 * @property \App\Model\Table\RoomsTable $Rooms
 */
class BokupanAPIController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    /**
     * Actionの直前に呼ばれる
     *
     * @return void
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Rooms = TableRegistry::get('Rooms', ['connection' => ConnectionManager::get('bokupan')]);
    }

    /**
     * Index method APIサンプル置き場
     *
     * @return void
     */
    public function index() {}

    /**
     * 部屋を作成
     *
     * @retrun void json表示viewに値を渡す
     */
    public function add() {
        $status = $this->status_code['FAIL'];

        $room = $this->Rooms->newEntity();
        if ($this->request->is('post')) {
            // 部屋作成時にシステム側で入力する値を設定
            $post = $this->request->data;
            $post["member_num"] = 1; // 部屋人数を1人に
            $room = $this->Rooms->patchEntity($room, $post);
            Log::write('debug', print_r($post, true));
            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));
                $status = $this->status_code['SUCCESS'];
                Log::write('debug', "success");
            } else {
                $this->Flash->error(__('The room could not be saved. Please, try again.'));
                Log::write('debug', "fail");
            }
        }
        $this->viewBuilder()->autoLayout(false);
        $result = ["status" => $status, "data" => compact('room')];
        $this->set('result', json_encode($result));
        $this->render('json');
    }

    /**
     * 部屋を編集
     *
     * @return void json表示viewに値を渡す
     */
    public function edit() {
        $status = $this->status_code['FAIL'];

        if ($this->request->is(['post'])) {
            $post = $this->request->data;

            // 部屋情報を取得
            $room = $this->Rooms->get($post['id']);

            // リクエストされたデータとマージ
            $room = $this->Rooms->patchEntity($room, $post);
            $room['id'] = $post["host_user_pid"];
            $room['host_user_pid'] = $post["host_user_pid"];
            Log::write('debug', print_r($post, true));
            Log::write('debug', print_r($room, true));
            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));
                $status = $this->status_code['SUCCESS'];
                Log::write('debug', "success");
            } else {
                $this->Flash->error(__('The room could not be saved. Please, try again.'));
                Log::write('debug', "fail");
            }
        }
        $this->viewBuilder()->autoLayout(false);
        $result = ["status" => $status, "data" => compact('room')];
        $this->set('result', json_encode($result));
        $this->render('json');
    }


    /**
     * 部屋を削除
     *
     * @param string|null $id Room id.
     * @return void json表示viewに値を渡す
     */
    public function delete() {
        $status = $this->status_code['FAIL'];

        if ($this->request->is(['post'])) {
            $post = $this->request->data;

            // 部屋情報を取得
            $room = $this->Rooms->get($post['id']);

            // 部屋を削除する
            if ($this->Rooms->delete($room)) {
                $this->Flash->success(__('The room has been deleted.'));
                $status = $this->status_code['SUCCESS'];
                Log::write('debug', "success");
            } else {
                $this->Flash->error(__('The room could not be deleted. Please, try again.'));
                Log::write('debug', "fail");
            }
        }
        $this->viewBuilder()->autoLayout(false);
        $result = ["status" => $status, "data" => compact('room')];
        $this->set('result', json_encode($result));
        $this->render('json');
    }

    /**
     * 部屋一覧を取得
     *
     * @return void json表示viewに値を渡す
     */
    public function roomList() {
        $status = $this->status_code['FAIL'];

        if ($this->request->is(['post'])) {
            // 部屋一覧を取得
            $rooms = $this->Rooms->find()->all();
            if(!$rooms) {
                Log::write('debug', "fail");
                throw new \Cake\Network\Exception\NotFoundException('Could not find that room');
            }
            $status = $this->status_code['SUCCESS'];
            Log::write('debug', "success");
            Log::write('debug', print_r($rooms, true));

        }
        $this->viewBuilder()->autoLayout(false);
        $result = ["status" => $status, "data" => compact('rooms')];
        $this->set('result', json_encode($result));
        $this->render('json');
    }
}