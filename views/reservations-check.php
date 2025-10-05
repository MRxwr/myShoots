<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
          <div class="card-body p-5">
            <h2 class="shoots-Head mb-4 text-center" style="font-weight:700; color:#333; letter-spacing:1px;">
              <?php echo direction("Reservation Number","رقم الحجز") ?>
            </h2>
            <div class="row justify-content-center mb-4">
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-lg rounded-3" id="bookingid" value="">
              </div>
              <div class="col-md-5 mb-3">
                <button class="btn btn-lg btn-primary btn-block rounded-pill shadow-sm" style="font-weight:600; letter-spacing:1px; background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%); border:none; color:#fff;" id="book-btn">
                  <?php echo direction("Search","بحث") ?>
                </button>
              </div>
            </div>
            <div id="bars1" style="display:none">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
            <div id="bookingDataDiv"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>