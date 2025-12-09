-- Seeds: Dados de exemplo para teste
-- Sistema de Gerenciamento de Prestadores - Seu João

-- Inserir Serviços
INSERT INTO `servicos` (`id`, `nome`, `descricao`, `created`, `modified`) VALUES
(1, 'Encanamento', 'Instalação e reparos hidráulicos em geral, incluindo torneiras, canos, e tubulações.', NOW(), NOW()),
(2, 'Elétrica', 'Instalações e manutenções elétricas residenciais e comerciais, tomadas, luminárias.', NOW(), NOW()),
(3, 'Pintura', 'Pintura interna e externa de residências e estabelecimentos comerciais.', NOW(), NOW()),
(4, 'Jardinagem', 'Manutenção de jardins, poda de árvores, plantio e cuidados com áreas verdes.', NOW(), NOW()),
(5, 'Limpeza', 'Limpeza residencial e comercial, incluindo faxinas gerais e limpeza pós-obra.', NOW(), NOW()),
(6, 'Marcenaria', 'Fabricação e reparo de móveis de madeira, portas, janelas e armários.', NOW(), NOW()),
(7, 'Alvenaria', 'Construção e reforma de muros, paredes, pisos e estruturas de alvenaria.', NOW(), NOW()),
(8, 'Serralheria', 'Instalação e manutenção de portões, grades, estruturas metálicas.', NOW(), NOW()),
(9, 'Ar Condicionado', 'Instalação, manutenção e limpeza de aparelhos de ar condicionado.', NOW(), NOW()),
(10, 'Dedetização', 'Controle de pragas urbanas, dedetização residencial e comercial.', NOW(), NOW());

-- Inserir Prestadores
INSERT INTO `prestadores` (`id`, `nome`, `telefone`, `email`, `foto`, `created`, `modified`) VALUES
(1, 'Carlos Silva', '79987654321', 'carlos.silva@email.com', NULL, NOW(), NOW()),
(2, 'Maria Santos', '79976543210', 'maria.santos@email.com', NULL, NOW(), NOW()),
(3, 'João Oliveira', '79965432109', 'joao.oliveira@email.com', NULL, NOW(), NOW()),
(4, 'Ana Costa', '79954321098', 'ana.costa@email.com', NULL, NOW(), NOW()),
(5, 'Pedro Souza', '79943210987', 'pedro.souza@email.com', NULL, NOW(), NOW()),
(6, 'Juliana Lima', '79932109876', 'juliana.lima@email.com', NULL, NOW(), NOW()),
(7, 'Roberto Alves', '79921098765', 'roberto.alves@email.com', NULL, NOW(), NOW()),
(8, 'Fernanda Rocha', '79910987654', 'fernanda.rocha@email.com', NULL, NOW(), NOW()),
(9, 'Lucas Martins', '79909876543', 'lucas.martins@email.com', NULL, NOW(), NOW()),
(10, 'Patrícia Dias', '79998765432', 'patricia.dias@email.com', NULL, NOW(), NOW());

-- Relacionar Prestadores com Serviços
INSERT INTO `prestadores_servicos` (`prestador_id`, `servico_id`, `valor`, `created`) VALUES
-- Carlos Silva: Encanamento, Elétrica
(1, 1, 150.00, NOW()),
(1, 2, 180.00, NOW()),

-- Maria Santos: Pintura, Limpeza
(2, 3, 120.00, NOW()),
(2, 5, 80.00, NOW()),

-- João Oliveira: Encanamento, Jardinagem
(3, 1, 150.00, NOW()),
(3, 4, 100.00, NOW()),

-- Ana Costa: Elétrica, Ar Condicionado
(4, 2, 180.00, NOW()),
(4, 9, 160.00, NOW()),

-- Pedro Souza: Alvenaria, Marcenaria
(5, 6, 200.00, NOW()),
(5, 7, 220.00, NOW()),

-- Juliana Lima: Limpeza
(6, 5, 80.00, NOW()),

-- Roberto Alves: Serralheria, Alvenaria
(7, 7, 220.00, NOW()),
(7, 8, 190.00, NOW()),

-- Fernanda Rocha: Jardinagem, Limpeza
(8, 4, 100.00, NOW()),
(8, 5, 80.00, NOW()),

-- Lucas Martins: Pintura, Marcenaria
(9, 3, 120.00, NOW()),
(9, 6, 200.00, NOW()),

-- Patrícia Dias: Dedetização
(10, 10, 140.00, NOW());

-- Confirma inserções
SELECT 'Seeds executados com sucesso!' as status;
SELECT COUNT(*) as total_servicos FROM servicos;
SELECT COUNT(*) as total_prestadores FROM prestadores;
SELECT COUNT(*) as total_relacionamentos FROM prestadores_servicos;