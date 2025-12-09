<?php 
    $optionsId = $optionsId ?? 'options';
?>

<style>
    .check-item:hover {
        background-color: #dedede;
        cursor: pointer;
    }
    .check-item:focus-within {
        background-color: #dedede;
        border: none !important;
        outline: none !important;
    }
</style>

<div class="d-flex flex-column gap-2">
    <div class="border rounded d-flex flex-row align-items-center justify-content-between form-control" id="drop-items" tabindex="0">
        <p>Selecione o serviço</p>
        <i class="bi bi-caret-down-fill"></i>
    </div>
    <div id="<?= $optionsId ?>" class="border rounded p-2 d-flex flex-column gap-1 d-none" style="min-height: 100px;">
        <div class="check-item d-flex flex-row align-items-center justify-content-between p-1" tabindex="0">
            <input type="checkbox" name="Test" id="Test" class="d-none">
            <label for="Test" class="fw-medium">Test</label>
            <i class="bi bi-check-lg text-danger d-none"></i>
        </div>
        <div class="check-item d-flex flex-row align-items-center justify-content-between p-1" tabindex="0">
            <input type="checkbox" name="Test" id="Test1" class="d-none">
            <label for="Test1" class="fw-medium">Test</label>
            <i class="bi bi-check-lg text-danger d-none"></i>
        </div>
        <div class="check-item d-flex flex-row align-items-center justify-content-between p-1" tabindex="0">
            <input type="checkbox" name="Test" id="Test2" class="d-none">
            <label for="Test2" class="fw-medium">Test</label>
            <i class="bi bi-check-lg text-danger d-none"></i>
        </div>
        <div class="check-item d-flex flex-row align-items-center justify-content-between p-1" tabindex="0">
            <input type="checkbox" name="Test" id="Test4" class="d-none">
            <label for="Test3" class="fw-medium">Test</label>
            <i class="bi bi-check-lg text-danger d-none"></i>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        
        $(document).on('click', '.check-item', function () {
            const checkbox = $(this).find('input[type="checkbox"]');
            const icon = $(this).find('i');

            if (checkbox.prop('checked')) {
                checkbox.prop('checked', false);
                icon.addClass('d-none');
                $(this).removeClass('active-item');
                return;
            }

            $('.check-item').each(function() {
                $(this).find('input[type="checkbox"]').prop('checked', false);
                $(this).find('i').addClass('d-none');
                $(this).removeClass('active-item');
            });

            checkbox.prop('checked', true);
            icon.removeClass('d-none');
            $(this).addClass('active-item');
        });

        $(document).on('keydown', '.check-item', function(e) {
            if (e.key === " ") {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        $('#drop-items').on('click', function() {
            const icon = $(this).find('i');
            $('#<?= $optionsId ?>').toggleClass('d-none');
            icon.toggleClass('bi-caret-down-fill');
            icon.toggleClass('bi-caret-up-fill');
        });

        $('#drop-items').on('keydown', function(e) {
            const icon = $(this).find('i');
            if (e.key === " ") {
                e.preventDefault();
                $('#<?= $optionsId ?>').toggleClass('d-none');
                icon.toggleClass('bi-caret-down-fill');
                icon.toggleClass('bi-caret-up-fill');
            }
        });
    });

    function loadOptions(options, selected=[]){
        $('#<?= $optionsId ?>').empty()
        let html = '';
        options.forEach((p)=>{
            const isChecked = selected.includes(p.id.toString()) || selected.includes(p.id);
            html += `
                <div class="check-item d-flex flex-row align-items-center justify-content-between p-1" tabindex="0">
                    <input type="checkbox" name="${p.name}" id="${p.id}" value="${p.id}" class="d-none" ${isChecked ? 'checked': ''}>
                    <label for="${p.id}" class="fw-medium">${p.label}</label>
                    <i class="bi bi-check-lg text-danger ${isChecked?'':'d-none'}"></i>
                </div>
            `;
        });
        $('#<?= $optionsId ?>').html(html);
    }

    

    
</script>