<style>
    .image-upload-wrapper {
        border: 2px dashed #ddd;
        padding: 20px;
        border-radius: 10px;
        cursor: pointer;
        position: relative;
    }

    .upload-area {
        padding: 20px 0;
    }

    .upload-area > div:first-child {
        width:40px; 
        height: 40px; 
        background-color: #fafafa;
    }

    .upload-icon {
        font-size: 40px;
        color: #999;
    }

    .preview-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        border: 2px solid #eee;
        background-color: #D9D9D9;
    }

    .image-upload-wrapper.dragover {
        border-color: #4285f4;
        background: #eef5ff;
    }
</style>

<div class="form-group d-flex flex-row gap-3 justify-content-between">  
    
    <!-- <img id="preview-image" src={} class="preview-img bi bi-person-circle text-secondary" alt="Foto"> -->
    <?php 
        $imageIdPreview = $imageIdPreview ?? 'preview-image';
        $imagePreview = $imagePreview ?? 'user_icon.svg';
        echo $this->Html->image(
            $imagePreview,
            array('alt' => 'Foto', 'border' => '0', 'class' => 'preview-img', 'id' => $imageIdPreview, 'data-default-src' => '')
        );
    ?>

    <div class="image-upload-wrapper text-center w-100">

        <?php
            echo $this->Form->input('foto', [
                'type' => 'file',
                'label' => false,
                'id' => 'image-input',
                'style' => 'display:none',
                'accept' => 'image/*'
            ]);
        ?>

        <div class="upload-area d-flex flex-column align-items-center" id="upload-area">
            <div class="d-flex flex-row align-items-center justify-content-center rounded-circle">
                <i class="bi bi-cloud-arrow-up mb-0"></i>
            </div>
            <p><strong>Clique para enviar</strong> ou arraste e solte</p>
            <span>SVG, PNG, JPG ou GIF (max. 800x400px)</span>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        const input = $('#image-input');
        const preview = $('#<?= $imageIdPreview ?>');
        const uploadArea = $('#upload-area');

        uploadArea.on('click', function() {
            input.click();
        });

        input.on('change', function (e) {
            showPreview(e.target.files[0]);
        });

        // Drag & Drop
        uploadArea.on('dragover', function (e) {
            e.preventDefault();
            uploadArea.addClass('dragover');
        });

        uploadArea.on('dragleave drop', function (e) {
            e.preventDefault();
            uploadArea.removeClass('dragover');
        });

        uploadArea.on('drop', function (e) {
            const file = e.originalEvent.dataTransfer.files[0];
            input[0].files = e.originalEvent.dataTransfer.files;
            showPreview(file);
        });

        function showPreview(file) {
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.attr('data-default-src', preview.attr('src'));
                preview.attr('src', e.target.result).show();
                uploadArea.hide();
            };
            reader.readAsDataURL(file);
        }
    });
</script>