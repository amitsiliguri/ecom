
export function imagePreview() {
    const getMultiplePreviewImages = (images) => {
        let tempImagesItems = [];
        if (Array.isArray(images) && images.length === 0){
            images.forEach((item) => {
                tempImagesItems.push(
                    getPreviewImage(
                        item.id,
                        item.image,
                        item.alt_name
                    )
                );
            })
        } else {
            tempImagesItems.push(
                constructImageObject([])
            );
        }
        return tempImagesItems;
    }

    const getPreviewImage = (id, url, name, size = 102400) => {
        let preview = [];
        if (id){
            preview.push({
                id : id,
                initial_sort_index : null,
                url : url,
                name : name,
                size : size,
                file : null,
                show: true
            });
        }
        return preview;
    }

    const constructImageObject = (banner) => {
        if (Array.isArray(banner) && banner.length === 0){
            return [{
                id : null,
                initial_sort_index : null,
                url : '',
                name : '',
                size : '',
                file : null,
                show: true
            }]
        } else {
            return banner;
        }
    }

    return { getPreviewImage, constructImageObject, getMultiplePreviewImages }
}
