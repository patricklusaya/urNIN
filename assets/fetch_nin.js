$(document).ready(function() {
    // When the form is submitted
    $('#searchForm').on('submit', function(event) {
        event.preventDefault();

        var nin = $('#ninInput').val(); // Get the NIN value from the input
        $('#result').html('<div class="spinner-border" role="status" style="justify-content: center; align-items:center; border-radius: 5px;" ><span class="sr-only">Searching...</span></div>'); // Display a loading spinner


        function formatNIN(nin) {
            // Add dashes after 8, 13, and 19 digits
            return nin.replace(/(\d{8})(\d{5})(\d{6})(\d{2})/, '$1-$2-$3-$4');
        }
        // AJAX call to fetch_nin.php
        $.ajax({
            url: '/nida/scripts/fetch_nin.php',
            type: 'POST',
            data: { nin: nin }, // Send NIN to fetch_nin.php
            success: function(response) {
                try {
                    // Parse the JSON response
                    var data = JSON.parse(response);
                    var result = data.obj.result;

                    console.log('Parsed result:', result);
                    $sex = result.SEX; // Retrieve the SEX value from the result set

                    console.log('sex',result.SEX )

                    // Determine the image source based on the SEX value
                    const imageSrc = ($sex === 'MALE') ? '../assets/images/male.png' : '../assets/images/woman.png';

                    if (result && result.NIN) {

                        console.log('got the results')
                        // Log the successful search into the database

                  
                        $.ajax({
                            url: '/nida/scripts/log_search.php',
                            type: 'POST',
                            data: {
                                nin: result.NIN,
                                firstname: result.FIRSTNAME,
                                middlename: result.MIDDLENAME,
                                lastname: result.SURNAME,
                                username: '<?php echo $_SESSION["username"]; ?>' // Pass the logged-in username
                            },
                            success: function(logResponse) {
                                console.log('Search logged successfully');
                            },
                            error: function(xhr, status, error) {
                                console.error('Failed to log search: ' + error);
                            }
                        });
                    }


                    const formattedNIN = formatNIN(result.NIN);
                   



                    // Format the output with Bootstrap cards and National ID card
                    var html = `
                        <div class="container" >
                            <div class="row">
                                <div class="col-md-6" style="margin-top:"100px"">
                                    <div class="card mb-4">
                                        <div class="card-header bg-primary text-white">
                                            <h4 class="mb-0">Search Result</h4>
                                        </div>
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-4">NIN:</dt>
                                                <dd class="col-sm-8">${result.NIN}</dd>
                                                <dt class="col-sm-4">First Name:</dt>
                                                <dd class="col-sm-8">${result.FIRSTNAME}</dd>
                                                <dt class="col-sm-4">Middle Name:</dt>
                                                <dd class="col-sm-8">${result.MIDDLENAME}</dd>
                                                <dt class="col-sm-4">Last Name:</dt>
                                                <dd class="col-sm-8">${result.SURNAME}</dd>
                                                <dt class="col-sm-4">Sex:</dt>
                                                <dd class="col-sm-8">${result.SEX}</dd>
                                                <dt class="col-sm-4">Date of Birth:</dt>
                                                <dd class="col-sm-8">${result.DATEOFBIRTH}</dd>
                                                <dt class="col-sm-4">Nationality:</dt>
                                                <dd class="col-sm-8">${result.NATIONALITY}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                              <div class="col-md-6">
                        
                            <div class="id-card-holder">
                                <div class="id-card-tag"></div>
                                <div class="id-card-tag-strip"></div>
                                <div class="id-card-hook"></div>
                                <div class="id-card">
                                    <div class="id-card-header">
                                    <div class="id-card-emblem"><img src="../assets/images/emb.png" alt="Photo" class="embem-img">   </div>
                                    <div class="id-card-title">
                                    <p class="tag1">JAMHURI YA MUUNGANO WA TANZANIA</p>
                                        <h3 class="tag2">KITAMBULISHO CHA TAIFA</h3>
                                        <p class="tag1">THE UNITED REPUBLIC OF TANZANIA</p>
                                        <h3 class="tag3">CITIZEN IDENTITY CARD</h3>
                               </div>
                                <div class="id-card-flag">   <img src="../assets/images/tz.png"alt="Photo" class="flag-img"></div>
                                    
                             </div>
                                
                                    
                                <div class="photo">

                                    <div class="details">
                                        <p class="nin">${result.NIN}</p>
                                        <p class="info">JINA LA KWANZA:  <span class="bold-text"> ${result.FIRSTNAME}</span> </p>
                                        <p class="info2">First Name</p>
                                        <p class="info">MAJINA YA KATI:  <span class="bold-text">${result.MIDDLENAME}</span>  </p>
                                        <p class="info2">Middle Name</p>
                                        <p class="info">JINA LA MWISHO:  <span class="bold-text">${result.SURNAME}</span>  </p>
                                        <p class="info2">Last Name</p>
                                        <p class="info">JINSIA:   <span class="bold-text">${result.SEX}</span>  </p>
                                        <p class="info2">Sex</p>
                                        
                                    </div>
                                   <div class="id-image">
                                <img src="${imageSrc}" alt="Photo" class="info-img">
                               </div>
    
                                </div>    
                                </div>
                            </div>
                        </div> 
                            </div>
                        </div>
                    `;
                    $('#result').html(html); // Display the formatted data
                } catch (e) {
                    $('#result').html('<div class="alert alert-danger" role="alert">An error occurred while processing the data.</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#result').html('<div class="alert alert-danger" role="alert">An error occurred: ' + error + '</div>');
            }
        });
    });
});
