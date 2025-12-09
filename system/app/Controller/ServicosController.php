<?php

App::uses('AppController', 'Controller');


class ServicosController extends AppController {

    public $helpers = array('Html', 'Form', 'Paginator');

    public $uses = array('Servico');

    public $components = array('Paginator', 'RequestHandler', 'Flash');


    public function index() {
        
    }

    public function getAll() {
        $this->autoRender = false;

        // Remover o HABTM antes da consulta
        $this->Servico->unbindModel([
            'hasAndBelongsToMany' => ['Prestador']
        ]);

        $servicos = $this->Servico->find('all', [
            'recursive' => -1  // impede qualquer relacionamento de vir
        ]);

        return json_encode($servicos);
    }

    public function add() {

    }

    public function addServico() {
        $this->autoRender = false;

        if ($this->request->is('post')) {

            if (!empty($this->request->data['Servico']['nome']) && !empty($this->request->data['Servico']['descricao'])) {
                $this->Servico->create();
                if ($this->Servico->saveAll($this->request->data)) {
                    $this->response->type('json');
                    $this->response->body(json_encode(array('success'=>true,'message'=>'Serviço salvo com sucesso','data'=>$this->Servico->read())));
                    return;
                } else {
                    $this->response->type('json');
                    $this->response->body(json_encode(array('success'=>false,'message'=>'Erro ao salvar')));
                    return;
                }
            } else {
                $this->response->type('json');
                $this->response->body(json_encode(array('success'=>false,'message'=>$this->request->data['Servico']['nome'])));
                return;
            }
        }
    }
}