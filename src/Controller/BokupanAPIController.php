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
    public function index() {
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
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
        $result = ["status" => $status];
        $this->set('result', json_encode($result));
    }
}