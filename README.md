# Guia Completo de Instalação

Este arquivo contém todas as instruções para instalar, configurar e rodar o projeto **teste-fullstack** em um único lugar.

---

## 1. Requisitos

- Docker
- Docker Compose
- Git
- Mysql Client

---

## 2. Clonar o repositório

```bash
git clone <URL_DO_REPOSITORIO>
cd teste-fullstack
```

---

## 3. Subir o ambiente com Docker

O projeto já possui `docker-compose.yml` e `Dockerfile`. Para criar e subir os containers:

```bash
cd ./docker
docker-compose up -d --build
```

Isso fará:
- Container PHP (backend)
- Container MySQL (banco de dados)
- Mapear a aplicação local para dentro do container

Certifique-se de que as portas definidas no `docker-compose.yml` não estão em uso.

---

## 4. Configuração do Banco de Dados

### Passo 1: Criar as tabelas

```bash
cd ../database
mysql -u root -p -h localhost -P 3306 system < schema.sql
#senha: 12345678
```
### Passo 2: Enviar os Seedrs

```bash
mysql -u root -p -h localhost -P 3306 system < seedrs.sql
# Senha: 12345678
```
---
## 5. Inicialização do Projeto

Após subir os containers, acesse a aplicação:

```
http://localhost:8080
```

---

## 6. Parar e remover containers

Para parar:

```bash
docker-compose down
```

Para remover containers e volumes:

```bash
docker-compose down -v
```

---

## 7. Observações

- Certifique-se de que a pasta `database/` está corretamente mapeada no container para importar os arquivos SQL.
- Se houver atualizações no `schema.sql` ou `seedrs.sql`, reimporte usando os comandos SQL.
- Para verificar problemas ou logs dos containers:

```bash
docker-compose logs -f
```

---

## 9. Troubleshooting

### Container não inicia
Verifique se as portas estão disponíveis:
```bash
docker ps
netstat -tulpn | grep PORTA
```

### Erro de conexão com banco de dados
Certifique-se de que o container do MySQL está rodando:
```bash
docker-compose ps
```

### Reimportar banco de dados
```bash
docker exec -it teste-fullstack_db_1 mysql -u root -proot teste_fullstack < /caminho/para/schema.sql
```