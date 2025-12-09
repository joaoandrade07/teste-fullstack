<?php

class Prestador extends AppModel{
    public $useTable = 'prestadores'; 

    public $hasAndBelongsToMany = array(
        'Servico' => array(
            'className' => 'Servico',
            'joinTable' => 'prestadores_servicos',
            'foreignKey' => 'prestador_id',
            'associationForeignKey' => 'servico_id',
            'unique' => true,
            'with' => 'PrestadoresServico'
        )
    );

    public $validate = array(
        'nome' => array('rule' => 'notBlank', 'message' => 'Nome é obrigatório'),
        'email' => array('rule' => 'email', 'allowEmpty' => false)
    );
}