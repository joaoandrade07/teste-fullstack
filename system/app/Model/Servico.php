<?php

class Servico extends AppModel {
    public $useTable = 'servicos'; 
    public $actsAs = array('Containable');

    public $hasAndBelongsToMany = array(
        'Prestador' => array(
            'className' => 'Prestador',
            'joinTable' => 'prestadores_servicos',
            'foreignKey' => 'servico_id',
            'associationForeignKey' => 'prestador_id',
            'unique' => true,
            'with' => 'PrestadoresServico'
        )
    );

    public $validate = array(
        'nome' => array('rule' => 'notBlank', 'message' => 'Nome do serviço é obrigatório'),
    );
}