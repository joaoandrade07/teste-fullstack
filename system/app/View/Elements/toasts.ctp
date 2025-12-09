<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000">

    <!-- Toast de Sucesso -->
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                Sucesso!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
        </div>
    </div>

    <!-- Toast de Erro -->
    <div id="toastError" class="toast align-items-center text-bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                Um erro ocorreu.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
        </div>
    </div>

</div>

<script>
    function showSuccessToast(message = "Operação realizada com sucesso!") {
        const toastEl = document.getElementById('toastSuccess');
        toastEl.querySelector('.toast-body').innerText = message;
        new bootstrap.Toast(toastEl, { delay: 3000 }).show();
    }

    function showErrorToast(message = "Erro ao realizar a operação!") {
        const toastEl = document.getElementById('toastError');
        toastEl.querySelector('.toast-body').innerText = message;
        new bootstrap.Toast(toastEl, { delay: 3000 }).show();
    }
</script>
