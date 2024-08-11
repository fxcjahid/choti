export default () => ({
    images: [],
    maxFiles: 10,
    acceptedFileTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],

    handleFiles(event) {
        const files = event.target.files;

        // Check if the total number of selected images exceeds the maximum limit
        if (this.images.length + files.length > this.maxFiles) {
            alert(`You can only upload a maximum of ${this.maxFiles} images.`);
            return;
        }

        Array.from(files).forEach(file => {
            // Validate file type
            if (!this.acceptedFileTypes.includes(file.type)) {
                alert(`Invalid file type: ${file.name}. Only images are allowed.`);
                return;
            }

            const reader = new FileReader();

            reader.onload = (e) => {
                this.images.push({
                    file: file,
                    url: e.target.result
                });
            };

            reader.readAsDataURL(file);
        });

        // Clear the file input value to allow re-selection of the same files
        event.target.value = '';
    },

    removeImage(index) {
        this.images.splice(index, 1);
    },

    canAddMoreFiles() {
        return this.images.length < this.maxFiles;
    }
});