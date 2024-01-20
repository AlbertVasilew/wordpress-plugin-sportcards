class CropperManager {
    constructor(modal, croppedImage) {
        this.modal = modal;
        this.croppedImage = croppedImage;
    }

    open = image => {
        if (this.cropper)
            this.cropper.destroy();

        const reader = new FileReader();
        reader.readAsDataURL(image);

        reader.onload = () => {
            this.croppedImage.src = reader.result;
            this.cropper = new Cropper(this.croppedImage, {aspectRatio: 1, viewMode: 1});
        }

        this.modal.style.display = "block";
    }

    close = () => this.modal.style.display = "none";
    getImageData = () => this.cropper?.getCroppedCanvas()?.toDataURL();
}