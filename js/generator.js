const generatorDiv = document.querySelector(".generator");
const generateBtn = generatorDiv.querySelector(".generator-form button");
const qrImg = generatorDiv.querySelector(".generator-img img");
const downloadBtn = generatorDiv.querySelector(".generator-btn .download-btn");
const printBtn = generatorDiv.querySelector(".generator-btn .print-btn");


let imgURL = '';


generateBtn.addEventListener("click", () => {
    const productName = document.getElementById('productId').value;
    const batchNumber = document.getElementById('batchNumber').value;
    const productionDate = document.getElementById('productionDate').value;
    const productId = document.getElementById('productId').value;

    if (!productName.trim() || !batchNumber.trim() || !productionDate.trim()) {
        alert("Please fill in all fields.");
        return;
    }

    generateBtn.innerText = "Generating QR Code..."; 

    const qrData = JSON.stringify({
        id: productId,
        batchNumber: batchNumber,
        productionDate: productionDate
    });

    const imgURL = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrData)}`;
    qrImg.src = imgURL;

    qrImg.addEventListener("load", () => {
        generatorDiv.classList.add("active");
        generateBtn.innerText = "Generate QR Code"; 

        fetch(imgURL)
            .then(res => res.blob())
            .then(blob => {
                const reader = new FileReader();
                reader.onloadend = () => {
                    const base64data = reader.result;

                    // Send data to PHP
                    fetch('http://localhost/QR-CODE/create-qrcode.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: productId,
                            qrImage: base64data
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                };
                reader.readAsDataURL(blob);
            });
    });
});

downloadBtn.addEventListener("click", () => {
    if (!imgURL) return;
    fetchImage(imgURL);
});

printBtn.addEventListener("click", () => {
    if (!imgURL) return;
    window.open(imgURL);
});

function fetchImage(url) {
    fetch(url).then(res => res.blob()).then(file => {
        console.log(file);
        let tempFile = URL.createObjectURL(file);
        let fileName = url.split("/").pop().split(".")[0];
        let extension = file.type.split("/")[1];
        download(tempFile, fileName, extension);
    }).catch(() => {
        console.error("Failed to fetch image.");
        imgURL = '';
    });
}

function download(tempFile, fileName, extension) {
    let a = document.createElement('a');
    a.href = tempFile;
    a.download = `${fileName}.${extension}`;
    document.body.appendChild(a);
    a.click();
    a.remove();
}

const qrInput = generatorDiv.querySelector(".generator-form input");
qrInput.addEventListener("input", () => {
    if (!qrInput.value.trim())
        generatorDiv.classList.remove("active");
});
