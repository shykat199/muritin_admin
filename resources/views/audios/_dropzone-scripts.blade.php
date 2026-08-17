<script>
    (function () {
        function setupDropzone({ zoneId, inputId, onFile }) {
            const zone = document.getElementById(zoneId);
            const input = document.getElementById(inputId);
            if (!zone || !input) return;

            zone.addEventListener('click', () => input.click());

            input.addEventListener('change', () => {
                if (input.files[0]) onFile(input.files[0]);
            });

            ['dragenter', 'dragover'].forEach((evt) => zone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.add('border-gray-500', 'bg-gray-50');
            }));

            ['dragleave', 'drop'].forEach((evt) => zone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.remove('border-gray-500', 'bg-gray-50');
            }));

            zone.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                if (files.length) {
                    input.files = files;
                    onFile(files[0]);
                }
            });
        }

        setupDropzone({
            zoneId: 'audio-dropzone',
            inputId: 'audio_file',
            onFile(file) {
                document.getElementById('audio-player').src = URL.createObjectURL(file);
                document.getElementById('audio-filename').textContent = file.name;
                document.getElementById('audio-preview').classList.remove('hidden');
            },
        });

        setupDropzone({
            zoneId: 'thumb-dropzone',
            inputId: 'thumbnail',
            onFile(file) {
                const img = document.getElementById('thumb-preview-img');
                img.src = URL.createObjectURL(file);
                img.classList.remove('hidden');
                document.getElementById('thumb-placeholder').classList.add('hidden');
            },
        });
    })();
</script>
