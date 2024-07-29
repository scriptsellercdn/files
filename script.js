document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];

    if (!file) {
        alert('Please select a file to upload.');
        return;
    }

    const formData = new FormData();
    formData.append('file', file);

    // Perform the file upload
    fetch('upload.php', { // Replace 'upload.php' with your server-side upload script
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const fileURL = `https://storage-s3.scriptseller.shop/uploads/${data.fileName}`;
        document.getElementById('fileURL').value = fileURL;
        document.getElementById('uploadResult').classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error uploading file:', error);
    });
});

document.getElementById('copyButton').addEventListener('click', function() {
    const fileURL = document.getElementById('fileURL');
    fileURL.select();
    fileURL.setSelectionRange(0, 99999); // For mobile devices

    navigator.clipboard.writeText(fileURL.value)
        .then(() => {
            alert('Link copied to clipboard!');
        })
        .catch(err => {
            console.error('Error copying link to clipboard:', err);
        });
});
