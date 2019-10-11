<?php

namespace App\Controller;

// Users Controller
// @property \App\Model\Table\UsersTable $Users

class LoginController extends AppController
{
    // ログイン画面/ログイン処理
    // @return \Cake\Http\Response|null ログイン成功後にログインTOPへ遷移する

    public function index()
    {
        $user = $this->Users->newEntity();
        if ($this->Auth->isAuthorized()) {
            return $this->redirect($this->Auth-redirectUrl());
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('ユーザー名またはパスワードが不正です');
        }
        $this->set(compact('user'));
    }
}