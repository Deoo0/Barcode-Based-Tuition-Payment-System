document.addEventListener("DOMContentLoaded", function () {
    const startButton = document.getElementById("start-scanning");
    const stopButton = document.getElementById("stop-scanning");
    let qrScanner;

    function initializeScanner() {
        qrScanner = new Html5Qrcode("scanner-container");
        const config = { fps: 10, qrbox: 250 };

        qrScanner
            .start(
                { facingMode: "environment" },
                config,
                (decodedText, decodedResult) => {
                    console.log("QR Code detected:", decodedText);
                    document.getElementById("scanner-container").style.border =
                        "3px solid green";
                    document.getElementById("barcode").value = decodedText;
                    // Find the form and submit it
                    const form = document.querySelector('form[action="/scan"]');
                    if (form) {
                        form.submit();
                        console.log("submitted search request", decodedText);
                    } else {
                        console.error("Form not found");
                        showError("Form not found. Cannot submit.");
                    }
                    stopScanner();
                },
                (errorMessage) => {
                    // showError(errorMessage);
                }
            )
            .then(() => {
                startButton.classList.add("d-none");
                stopButton.classList.remove("d-none");
            })
            .catch((err) => {
                console.error("Failed to start scanner:", err);
                showError("Failed to start QR scanner. Check camera access.");
            });
    }

    function stopScanner() {
        if (qrScanner) {
            qrScanner
                .stop()
                .then(() => {
                    startButton.classList.remove("d-none");
                    stopButton.classList.add("d-none");
                    qrScanner.clear();
                })
                .catch((err) => {
                    console.error("Failed to stop scanner:", err);
                });
        }
    }

    startButton.addEventListener("click", initializeScanner);
    stopButton.addEventListener("click", stopScanner);
    window.addEventListener("beforeunload", stopScanner);
});

function showError(message) {
    const alertDiv = document.createElement("div");
    alertDiv.className = "alert alert-danger mt-3";
    alertDiv.innerHTML = `
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            ${message}
        `;
    document.querySelector(".scanner-controls").prepend(alertDiv);
}

document.addEventListener("DOMContentLoaded", function () {
    const paymentMethod = document.getElementById("payment_method");
    const referenceInput = document.getElementById("reference");
    const form = document.getElementById("paymentForm");

    function toggleReferenceRequirement() {
        const method = paymentMethod.value;
        const status = document.querySelector('select[name="status"]').value;

        if (method === "cash" || status === "Partial") {
            referenceInput.removeAttribute("required");
        } else {
            referenceInput.setAttribute("required", "required");
        }
    }

    paymentMethod.addEventListener("change", toggleReferenceRequirement);

    form.addEventListener("submit", function (e) {
        const method = paymentMethod.value;
        const refValue = referenceInput.value.trim();

        if (refValue === "") {
            const randomRef = Math.floor(10000 + Math.random() * 90000);
            referenceInput.value = randomRef;
        }
    });
});
