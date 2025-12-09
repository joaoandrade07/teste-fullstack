<input type="text" id="buscaPrestador" class="form-control mb-3 w-50"
       placeholder="Digite para buscar..." autocomplete="off">



<script>
    $(document).ready(function() {
        $("#buscaPrestador").keyup(function() {
            let termo = $(this).val();
            getPrestadores(termo);
        });
    });
</script>