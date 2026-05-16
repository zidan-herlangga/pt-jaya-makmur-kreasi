import './bootstrap';

window.togglePassword = function (btn) {
    const wrapper = btn.closest('.password-toggle');
    const input = wrapper.querySelector('input');
    const showIcon = wrapper.querySelector('.password-eye');
    const hideIcon = wrapper.querySelector('.password-eye-off');

    if (input.type === 'password') {
        input.type = 'text';
        showIcon?.classList.add('hidden');
        hideIcon?.classList.remove('hidden');
    } else {
        input.type = 'password';
        showIcon?.classList.remove('hidden');
        hideIcon?.classList.add('hidden');
    }
};

document.addEventListener('alpine:init', () => {
    Alpine.data('galleryManager', (config = {}) => ({
        existingImages: config.existingImages ?? [],
        newFiles: [],
        deletedImages: [],
        maxFiles: config.maxFiles ?? 4,

        get totalCount() {
            return this.existingImages.length + this.newFiles.length;
        },

        get canAddMore() {
            return this.totalCount < this.maxFiles;
        },

        get statusText() {
            const sisa = this.maxFiles - this.totalCount;
            if (sisa <= 0) return 'Galeri penuh (maks. ' + this.maxFiles + ' gambar)';
            return sisa + ' dari ' + this.maxFiles + ' slot tersisa';
        },

        addFiles(event) {
            const files = Array.from(event.target.files);
            const remaining = this.maxFiles - this.totalCount;

            files.slice(0, remaining).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.newFiles.push({ file, preview: e.target.result });
                };
                reader.readAsDataURL(file);
            });

            event.target.value = '';
        },

        removeNew(index) {
            this.newFiles.splice(index, 1);
        },

        removeExisting(index) {
            this.deletedImages.push(this.existingImages[index].path);
            this.existingImages.splice(index, 1);
        },

        beforeSubmit() {
            try {
                const input = document.querySelector('input[name="images[]"]');

                if (this.newFiles.length > 0 && input) {
                    const dt = new DataTransfer();
                    this.newFiles.forEach(f => dt.items.add(f.file));
                    input.files = dt.files;
                } else if (input) {
                    input.value = '';
                }

                const deletedInput = document.querySelector('input[name="deleted_images"]');
                if (deletedInput) deletedInput.value = JSON.stringify(this.deletedImages);
            } catch (e) {
                console.error('Gallery beforeSubmit error:', e);
            }
        }
    }));
});
