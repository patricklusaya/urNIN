document.addEventListener("DOMContentLoaded", function() {
    // Ensure the event is delegated to handle dynamically added elements
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('download-btn2')) {
            var card = document.querySelector('.id-card');

            if (card) {
                html2canvas(card).then(function(canvas) {
                    var imgData = canvas.toDataURL('image/png');
                    var pdf = new jsPDF('p', 'mm', 'a4');
                    var imgWidth = 210; // A4 width in mm
                    var imgHeight = (canvas.height * imgWidth) / canvas.width;

                    pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                    pdf.save('search_history_card.pdf');
                }).catch(function(error) {
                    console.error('Error generating PDF:', error);
                });
            } else {
                console.error('Card element not found.');
            }
        }
    });
});
