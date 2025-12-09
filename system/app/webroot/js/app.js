$(document).on("click", "#pagination button", function () {
    let q = $("#search").val();
    let page = $(this).data("page");
    getPrestadores(q, page);
});

// -----------------------------------Funcões---------------------------------------------

const generateTable = (data, target) => {
    let html = "";
    if(data != null && data.length > 0 ){
        data.forEach(p => {

            html += `
                <tr>
                    <td scope="row">
                        <div class="d-flex flex-row align-items-center gap-2">
                            <img src="/img/${p.Prestador.foto != null? p.Prestador.foto: "user_icon.svg"}" alt="foto" class="rounded-circle object-fit-cover" style="width: 32px; height: 32px;"/>
                            <div class="d-flex flex-column align-items-start">
                                <p>${p.Prestador.nome}</p>
                                <p>${p.Prestador.email}</p>
                                
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        ${p.Prestador.telefone}
                    </td>
                    <td class="align-middle">
                        ${p.Servico.nome}
                    </td>
                    <td class="align-middle">
                        R$ ${parseFloat(p.PrestadorServico.valor)}
                    </td>
                    <td class="align-middle">
                        <div class="d-flex flex-row align-items-center gap-2">
                            <a href="/prestadores/edit/${p.Prestador.id}" class="bbi bi-pen text-secondary"></a>
                            <a href="/prestadores/delete/${p.Prestador.id}" class="bi bi-trash3 text-secondary"></a>
                        </div>
                    </td>
                </tr>
            `;
            
        });
    }else {
        html += `
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        `
    }
    
    target.html(html);
}

const generatePagination = (currentPage, totalPages, target) => {
    target.empty()
    target.append(`
        <p class="mb-0 text-dark">
            Página ${currentPage} de ${totalPages}
        </p>
    `);

    let buttons = `<div class="d-flex flex-row justify-content-between align-items-center gap-2">`;

    if (currentPage > 1) {
        buttons += `<button class="btn btn-outline-secondary" data-page="${currentPage - 1}">Anterior</button>`;
    }else {
        buttons += `<button class="btn btn-outline-secondary disabled" data-page="${currentPage}">Anterior</button>`;
    }

    if(currentPage<totalPages) {
        buttons += `<button class="btn btn-outline-secondary" data-page="${currentPage + 1}">Próximo</button>`;
    }else{
        buttons += `<button class="btn btn-outline-secondary disabled" data-page="${currentPage}">Próximo</button>`;
    }

    buttons += `</div>`

   target.append(buttons);
}

const getPrestadores = (q="", page=1) => {
    $.ajax({
        url: "/prestadores/getAllWithFilters",
        method: "GET",
        data: {q: q, page: page},
        success: function(res) {
            console.log(res)
            res = JSON.parse(res);
            generateTable(res.data, $("#body"))
            generatePagination(res.page, res.totalPages, $("#pagination"));
        }
    });
}

const formatPhone = (value) => {
    value = value.replace(/\D/g, '');

    value = value.substring(0, 11);

    if (value.length > 10) {
        value = value.replace(/^(\d{2})(\d{5})(\d{0,4})$/, '($1) $2-$3');
    } else if (value.length > 6) {
        value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
    } else if (value.length > 2) {
        value = value.replace(/^(\d{2})(\d+)/, '($1) $2');
    } else if (value.length > 0) {
        value = value.replace(/^(\d*)/, '($1');
    }

    return value;
}