
<div class="d-flex flex-row justify-content-between">
    <div class="flex flex-col gap-1 mb-3">
        <p class="h1">Prestadores</p>
        <p class="text-base">Veja sua lista de prestadores de serviço</p>
    </div>

    <div class="d-flex flex-row align-items-center gap-2">
        <button class="btn btn-outline-secondary  d-flex flex-row gap-2 align-items-center">
            <i class="bi bi-upload"></i>
            <p class="text-base mb-0">
                Importar
            </p>
        </button>

        <a href="<?= $this->Html->url(array('controller' => 'prestadores', 'action' => 'add')); ?>" class="text-decoration-none">
          <button class="btn btn-danger d-flex flex-row align-items-center gap-1">
              <i class="bi bi-plus-lg"></i>
              <p class="text-base">
                  Add novo prestador
              </p>
          </button>
        </a>
    </div>

</div>


<!-- 
<input type="text" id="buscaPrestador" class="form-control mb-3 w-50"
       placeholder="Digite para buscar..." autocomplete="off"> -->

<?= $this->element('search_prestadores'); ?>

<div id="listaPrestadores">
    <?= $this->element('prestadores_lista'); ?>
</div>



<!-- Modais -->

<div class="modal fade" id="modalImportar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>

<script>

</script>