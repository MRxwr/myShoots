<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
          <div class="row no-gutters align-items-center">
            <div class="col-lg-6 p-4">
              <h2 class="shoots-Head mb-4" style="font-weight:700; color:#333; letter-spacing:1px;">
                <?php echo direction("Contact Us","اتصل بنا") ?>
              </h2>
              <ul class="list-unstyled contact-details mb-4">
                <li class="mb-3"><a href="<?php echo $bookingSettings['address_link'] ?>" class="theme-color h5"><i class="fas fa-map-marker-alt mr-2"></i> <?php echo $bookingSettings['address'] ?></a></li>
                <li class="mb-3"><a href="mailto:<?php echo $bookingSettings['email'] ?>" class="theme-color h5"><i class="far fa-envelope mr-1"></i> <?php echo $bookingSettings['email'] ?></a></li>
              </ul>
              <div style="margin-top: 10px;color: red;">*
                <?php echo direction("Note: Please fill in all fields.","ملاحظة: يرجى ملء جميع الحقول.") ?>
              </div>
            </div>
            <div class="col-lg-6 col-xl-6 p-4">
              <form class="contact-form" id="contactForm">
                <div class="form-group row mb-3">
                  <div class="col-md-6 mb-3"><input type="text" class="form-control form-control-lg rounded-3" placeholder="<?php echo direction("Name","الاسم") ?>" required name="name" id="name"></div>
                  <div class="col-md-6 mb-3"><input type="email" name="email" id="email" class="form-control form-control-lg rounded-3" placeholder="<?php echo direction("Email","البريد الإلكتروني") ?>" required></div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-md-6 mb-3"><input type="text" name="phone" id="phone" class="form-control form-control-lg rounded-3" placeholder="<?php echo direction("Phone","الهاتف") ?>" required></div>
                  <div class="col-md-6 mb-3"><input type="text" name="subject" id="subject" class="form-control form-control-lg rounded-3"  placeholder="<?php echo direction("Subject","الموضوع") ?>" required></div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-md-12"><textarea class="form-control form-control-lg rounded-3" id="message" name="message" rows="3" placeholder="<?php echo direction("Message","الرسالة") ?>"></textarea></div>
                </div>
                <div class="mb-3"><button type="submit" class="btn btn-lg btn-primary btn-block rounded-pill shadow-sm" style="font-weight:600; letter-spacing:1px; background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%); border:none; color:#fff;">
                  <?php echo direction("Submit","إرسال") ?>
                </button></div>
                <div id="bars1" style="display:none">
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div id="msgSubmit" class="alert alert-success text-center mt-4 d-none"><?php echo direction("Your message has been sent successfully.","تم إرسال رسالتك بنجاح.") ?></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
