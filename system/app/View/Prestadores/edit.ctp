
<style>
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* cinza transparente */
        z-index: 9999; /* fica acima de tudo */
    }
</style>

<div id="loadingOverlay" class="d-none justify-content-center align-items-center">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Carregando...</span>
    </div>
</div>
<div>
    <p class="h1 mb-5">Cadastro de Prestador de Serviço</p>
    <p class="fw-bold">Informações pessoais</p>
    <p>Cadastre suas informações e adicione uma foto</p>
</div>
<?php echo $this->Form->create('Prestador', array('id'=>'formPrestador'));?>
<table class="table my-3">
    <thead>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="fw-medium">Nome</td>
            <td><?php echo $this->Form->input('nome',array('label' => false, 'class'=> 'form-control'))?></td>
            <td></td>
        </tr>
        <tr>
            <td class="fw-medium">Email</td>
            <td><?php echo $this->Form->input('email',array('label' => false, 'class'=> 'form-control', 'type' => 'email'))?></td>
            <td></td>
        </tr>
        <tr>
            <td class="fw-medium">Foto</td>
            <!-- <td><?php echo $this->Form->input('foto',array('type'=>'file','label' => false, 'class'=> 'form-control'))?></td> -->
            <td><?php echo $this->element('upload_image', array('imageIdPreview' => 'idPreview', 'imagePreview' => $imagePreview)); ?></td>
            <td></td>
        </tr>
        <tr>
            <td class="fw-medium">Telefone</td>
            <td><?php echo $this->Form->input('telefone',array('label' => false, 'class' => 'form-control', 'id' => 'telefone', 'maxlength' => '15'))?></td>
            <td></td>
        </tr>
        <tr>
            <td class="fw-medium">Quais serviços você vai prestar</td>
            <td>
                <?php
                    echo $this->element('multiple_select');
                ?>
            </td>
            <td>
                <button type="button" class="btn btn-danger d-flex flex-row align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalAddServico">
                    <i class="bi bi-plus-lg"></i>
                    <p class="text-base">
                        Cadastrar serviço
                    </p>
                </button>
            </td>
        </tr>
        <tr>
            <td class="fw-medium">Valor do serviço</td>
            <td>
                <?php echo $this->Form->input('valor',array('label' => false, 'class'=> 'form-control', 'type' => 'number'))?>
            </td>
            <td></td>
        </tr>
    </tbody>
</table>

<div class="w-100 d-flex flex-row align-items-center justify-content-end gap-2">
    <?php 
        echo $this->Html->link(
            'Cancelar',
            array('controller' => 'prestadores', 'action' => 'index'),
            array('class' => 'text-decoration-none btn btn-outline-secondary')
        ); 
    ?>
    <button id="submitPrestador" class="btn btn-danger">Salvar</button>
    <?php echo $this->Form->end('salvar'); ?>
</div>




<div class="modal fade" id="modalAddServico" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo $this->Form->create('Servico', array('id'=>'formServico')); ?>
                <div class="d-flex flex-column gap-3">
                    <p class="fw-medium">Cadastre um serviço</p>
                        <div class="form-colum">
                            <div class="form-group"><?php echo $this->Form->input('nome', array('class'=>'form-control','label'=>'Nome')); ?></div>
                            <div class="form-group"><?php echo $this->Form->input('descricao', array('class'=>'form-control','label'=>'Descrição', 'rows' => '1')); ?></div>
                        </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary w-50" data-bs-dismiss="modal">Cancelar</button>
                        <button id="submitServico" class="btn btn-danger w-50">Cadastrar</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        loadServicos();
    });

    
    $('#submitPrestador').on('click', function(e){
        e.preventDefault();
        let form = $('#formPrestador')[0];
        let fd = new FormData(form);
        let prestadorId = '<?= $prestadorId ?>';
        $.ajax({
            url: '<?php echo $this->Html->url(array('controller' => 'prestadores', 'action' => 'edit')); ?>' + '/'+ prestadorId ,
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: () => {
                $('#submitPrestador').prop('disabled', true);
                $('#loadingOverlay').removeClass('d-none').addClass('d-flex');
            },
            success: (resp) => {
                $('#loadingOverlay').addClass('d-none').removeClass('d-flex');
                $('#submitPrestador').prop('disabled', false);
                console.log(resp);
                try { 
                    resp = (typeof resp === 'string') ? JSON.parse(resp) : resp; 
                } catch(e){ 
                    console.error(resp); return; 
                }
                if (resp.success) {
                    $('#formPrestador')[0].reset();
                    $('#idPreview').attr('src', $('#idPreview').data('default-src'));
                    showSuccessToast(resp.message || 'Prestador salvo com sucesso');
                } else {
                    console.log(resp.message || 'Erro ao salvar');
                    showErrorToast(resp.message || 'Erro ao salvar');
                }
            }, error: function(xhr){
                console.error('Erro', xhr.responseText);
            }
        });
    });

    $('#submitServico').on('click', function(e){
        e.preventDefault();
        let form = $('#formServico')[0];
        let fd = new FormData(form);
        // console.log(fd);
        // return;
        $.ajax({
            url: '<?php echo $this->Html->url(array('controller' => 'servicos', 'action' => 'addServico')); ?>',
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: () => {
                $('#submitServico').prop('disabled', true);
                $('#loadingOverlay').removeClass('d-none').addClass('d-flex');
            },
            success: (resp) => {
                $('#loadingOverlay').addClass('d-none').removeClass('d-flex');
                $('#submitServico').prop('disabled', false);
                try { 
                    resp = (typeof resp === 'string') ? JSON.parse(resp) : resp; 
                } catch(e){ 
                    console.error(resp); return; 
                }
                if (resp.success) {
                    const modalEl = document.getElementById('modalAddServico');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();
                    showSuccessToast(resp.message || 'Serviço salvo com sucesso');
                    loadServicos();
                } else {
                    console.log(resp.message || 'Erro ao salvar');
                    showErrorToast(resp.message || 'Erro ao salvar');
                }
            }, error: function(xhr){
                console.error('Erro', xhr.responseText);
            }
        });
    });

    $('#telefone').on('input', function() {
        this.value = formatPhone(this.value);
    });

    function loadServicos() {
        console.log(<?= $servicosMarcadosJson ?>)
        $.ajax({
            url: "/servicos/getAll",
            method: "GET",
            success: function(res) {
                res = JSON.parse(res);
                if(res != null && res.length > 0 ){
                    let servicos = res.map(i => ({
                        id: i.Servico.id,
                        name: `data[Servico][]`,
                        label: i.Servico.nome
                    }))
                    loadOptions(servicos, <?= $servicosMarcadosJson ?>);
                }
            }
        });
    }
</script>