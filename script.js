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

    fetch('upload.php', { // Replace with your server-side upload script
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const fileURL = `https://storage-s3.scriptseller.shop/uploads/${data.fileName}`;
            document.getElementById('fileURL').value = fileURL;
            document.getElementById('uploadResult').classList.remove('hidden');
        } else {
            alert('Upload failed: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error uploading file:', error);
        alert('An error occurred during the upload.');
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
            alert('Failed to copy link.');
        });
});
