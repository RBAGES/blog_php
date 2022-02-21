const inputImage = document.getElementById('image');

inputImage.addEventListener('change', () => {
    if(document.getElementById('remove-file')===null){
        const removeFile = document.createElement('i');
        removeFile.classList.add('ms-3','fs-4','fa-solid','fa-xmark');
        removeFile.setAttribute('id','remove-file');

        removeFile.addEventListener('click',()=>{
            inputImage.value = '';
            removeFile.remove();
        })

        inputImage.parentElement.append(removeFile);
    }

});