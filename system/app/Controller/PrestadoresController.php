<?php

App::uses('AppController', 'Controller');


class PrestadoresController extends AppController {

    public $helpers = array('Html', 'Form', 'Paginator');

    public $uses = array('Prestador', 'Servico');

    public $components = array('Paginator', 'RequestHandler', 'Flash');


    public function index() {
        
    }

    // public function getAll() {
    //     $this->autoRender = false;

    //     $page = isset($this->request->query['page']) ? (int)$this->request->query['page'] : 1;
        
    //     // Configuração da paginação
    //     $this->Paginator->settings = array(
    //         'limit' => 5,      // itens por página
    //         'order' => array('Prestador.nome' => 'ASC')
    //     );

    //     // Executa a paginação
    //     $prestadores = $this->Paginator->paginate('Prestador');

    //     $response = array(
    //         'data' => $prestadores,
    //         'page' => $this->request->params['paging']['Prestador']['page'],
    //         'totalPages' => $this->request->params['paging']['Prestador']['pageCount']
    //     );

    //     // $this->set(compact('prestadores'))
    //     return json_encode($response);
    // }

    public function getAllWithFilters() {
        $this->autoRender = false;

        $this->Prestador->unbindModel([
            'hasAndBelongsToMany' => ['Servico']
        ], true);

        $this->Prestador->Servico->unbindModel([
            'hasAndBelongsToMany' => ['Prestador']
        ], true);

        $this->Prestador->Behaviors->unload('Containable');

        $busca = isset($this->request->query['q']) ? trim($this->request->query['q']) : '';
        $page = isset($this->request->query['page']) ? (int)$this->request->query['page'] : 1;

        $conditions = array(
            'OR' => array(
                'Prestador.telefone LIKE' => "%{$busca}%",
                'Prestador.nome LIKE'     => "%{$busca}%",
                'Prestador.email LIKE'    => "%{$busca}%"
            )
        );

        // Configuração da paginação
        $this->Paginator->settings = array(
            'joins' => array(
                array(
                    'table' => 'prestadores_servicos',
                    'alias' => 'PrestadorServico',
                    'type' => 'INNER',
                    'conditions' => ['Prestador.id = PrestadorServico.prestador_id']
                ),
                array(
                    'table' => 'servicos',
                    'alias' => 'Servico',
                    'type' => 'INNER',
                    'conditions' => ['Servico.id = PrestadorServico.servico_id']
                )
            ),
            'fields' => array(
                'Prestador.*',
                'Servico.*',
                'PrestadorServico.*'

            ),
            'conditions' => $conditions,
            'limit' => 5,
            'page' => $page,
            'order' => array('Prestador.nome' => 'ASC')
        );

        $prestadores = $this->Paginator->paginate('Prestador');

        $response = array(
            'data' => $prestadores,
            'page' => $this->request->params['paging']['Prestador']['page'],
            'totalPages' => $this->request->params['paging']['Prestador']['pageCount']
        );

        return json_encode($response);
    }

    public function add() {

    }

    public function edit($id=null) {
        if (!$id) {
            throw new NotFoundException('Prestador inválido');
        }

        $prestador = $this->Prestador->findById($id);
        if (!$prestador) {
            throw new NotFoundException('Prestador não encontrado');
        }

        if ($this->request->is(array('post', 'put'))) {

            $this->Prestador->id = $id;

            // --- Upload nova foto (opcional) ----
            // FALTA FAZER


            if ($this->Prestador->save($this->request->data['Prestador'])) {

                if (!empty($this->request->data['Servico'])) {
                    $this->loadModel('PrestadoresServico');

                    $this->PrestadoresServico->deleteAll(['PrestadoresServico.prestador_id' => $id], false);

                    $servicos = $this->request->data['Servico'];
                    $todosOk = true;

                    foreach ($servicos as $servicoId) {

                        $this->PrestadoresServico->create();
                        $ok = $this->PrestadoresServico->save([
                            'prestador_id' => $id,
                            'servico_id'   => $servicoId,
                            'valor'        => $this->request->data['Prestador']['valor'],
                        ]);

                        if (!$ok) {
                            $todosOk = false;
                            break;
                        }
                    }

                    if($todosOk){
                        return $this->redirect(array('action' => 'index'));
                        // $this->response->type('json');
                        // $this->response->body(json_encode(array('success'=>true,'message'=>'Prestador salvo com sucesso','data'=>$this->Prestador->read())));
                        // return;
                    }else{
                        $this->response->type('json');
                        $this->response->body(json_encode(array('success'=>false,'message'=>'Erro ao salvar os serviços')));
                        return;
                    }
                }else{
                    $this->response->type('json');
                    $this->response->body(json_encode(array('success'=>true,'message'=>'Prestador salvo com sucesso','data'=>$this->Prestador->read())));
                    return;
                }
            }else{
                $this->response->type('json');
                $this->response->body(json_encode(array('success'=>false,'message'=>'Erro ao atualizar')));
                return;
            }

            $this->Session->setFlash('Erro ao atualizar prestador.', 'default', array('class'=>'alert alert-danger'));
        }


        if (!$this->request->data) {


            $this->loadModel('PrestadoresServico');

            // Buscar apenas 1 registro — o primeiro
            $pivot = $this->PrestadoresServico->find('first', [
                'conditions' => ['prestador_id' => $id],
                'fields'     => ['servico_id', 'valor'],
                'recursive'  => -1
            ]);

            // Se existir pivot, joga no form
            if (!empty($pivot)) {
                $prestador['Servico'] = [$pivot['PrestadoresServico']['servico_id']];
                $prestador['Prestador']['valor'] = $pivot['PrestadoresServico']['valor'];
            } else {
                $prestador['Servico'] = [];
                $prestador['Prestador']['valor'] = '';
            }

            // Preenche o formulário
            $this->request->data = $prestador;

            // Envia para o JS caso ainda esteja usando
            $this->set('servicosMarcadosJson', json_encode($prestador['Servico']));
            $this->set('imagePreview', ($prestador['Prestador']['foto']));
            $this->set('prestadorId', ($prestador['Prestador']['id']));

        }
    }

    public function addPrestador() {
        $this->autoRender = false;

        

        if ($this->request->is('post')) {

            if (!empty($this->request->data['Prestador']['foto']['tmp_name']) && $this->request->data['Prestador']['foto']['size']>0) {
                $file = $this->request->data['Prestador']['foto'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = array('jpg','jpeg','png','gif');
                if (!in_array($ext, $allowed)) {
                    $this->response->type('json');
                    $this->response->body(json_encode(array('success'=>false,'message'=>'Erro ao salvar foto, extenção não permitida')));
                    return;
                }else if($file['size'] > (2*800*400)){
                    $this->response->type('json');
                    $this->response->body(json_encode(array('success'=>false,'message'=>'Erro ao salvar foto, tamanho excedido')));
                    return;
                }else{
                    $fileName = 'prestador_'.time().'.'.$ext;
                    $destFolder = WWW_ROOT . 'img' . DS . 'prestadores' . DS . $fileName;
                    move_uploaded_file($file['tmp_name'], $destFolder);
                    $this->request->data['Prestador']['foto'] = 'prestadores/' . $fileName;
                    $this->Prestador->create();
                    if ($this->Prestador->save($this->request->data['Prestador'])) {

                        $prestadorId = $this->Prestador->id; // Salvar cada serviço + valor 
                        if (!empty($this->request->data['Servico'])) { 
                            $this->loadModel('PrestadoresServico'); 
                            $servicos = $this->request->data['Servico']; // ex: [1, 4, 7]

                            $todosOk = true;

                            foreach ($servicos as $servicoId) {

                                $this->PrestadoresServico->create();
                                $ok = $this->PrestadoresServico->save([
                                    'prestador_id' => $prestadorId,
                                    'servico_id'   => $servicoId,
                                    'valor'        => $this->request->data['Prestador']['valor'],
                                ]);

                                if (!$ok) {
                                    $todosOk = false;
                                    break; // já pode parar
                                }
                            }

                            if($todosOk){
                                $this->response->type('json');
                                $this->response->body(json_encode(array('success'=>true,'message'=>'Prestador salvo com sucesso','data'=>$this->Prestador->read())));
                                return;
                            }else{
                                $this->response->type('json');
                                $this->response->body(json_encode(array('success'=>false,'message'=>'Erro ao salvar os serviços')));
                                return;
                            }

                        }
                        // $this->response->type('json');
                        // $this->response->body(json_encode(array('success'=>true,'message'=>'Prestador salvo com sucesso','data'=>$this->Prestador->read())));
                        // return;
                    } else {
                        $this->response->type('json');
                        $this->response->body(json_encode(array('success'=>false,'message'=>'Erro ao salvar')));
                        return;
                    }
                }
            } else {
                $this->response->type('json');
                $this->response->body(json_encode(array('success'=>false,'message'=>'Erro ao salvar foto, tamanho excedido')));
                return;
            }
        }
    }
}