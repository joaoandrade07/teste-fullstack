<div class="rounded-3 overflow-hidden border">
    <div class="table-responsive">
        <table class="table">
            <thead class="table-secondary">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Serviços</th>
                    <th scope="col">Valor</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody id="body">
                
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center px-2 py-3" id="pagination">
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "/prestadores/getAllWithFilters",
            method: "GET",
            success: function(res) {
                res = JSON.parse(res);
                if(res.data != null && res.data.length > 0 ){
                    console.log(res.data);
                    generateTable(res.data, $("#body"));
                }
                generatePagination(res.page, res.totalPages, $("#pagination"));
            }
        });
    });
</script>