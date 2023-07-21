$(function () {
    showComplaint();
});

function showComplaint() {
    $('.detail').click(function () {


        $('#category').html(
          `
            <div class="card mb-2">  
                <img src="public/img/kebersihan-lingkungan.png" height="200">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <p class="card-text">Kebersihan lingkungan</p>
                    <div class="">
                        <a href="" class="btn btn-primary">Update</a>
                        <button  class="btn btn-primary klasifikasi">Detail</button>
                    </div>
                 </div>
            </div>
            
              <div class="card mb-2">  
                <img src="public/img/perawatan-club-house.png" height="200">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <p class="card-text">Perawatan Club House</p>
                    <div class="">
                        <a href="" class="btn btn-primary">Update</a>
                        <button  class="btn btn-primary klasifikasi">Detail</button>
                    </div>
                 </div>
            </div>
            
            
            
          `
        );
        showKlasifikasi();
    });
}

function showKlasifikasi() {
    $('.klasifikasi').click(function () {

        $('#klasifikasi').html(
          `
          <div class="card">
            <div class="card-header">
                Featured
            </div>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Accordion Item #1
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Accordion Item #2
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                    </div>
                </div>
            </div>
        </div>
          `
        );
    });
}