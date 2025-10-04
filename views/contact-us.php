<section>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head"><?php echo direction("Contact Us","اتصل بنا") ?></h2>
        </div>
        <div class="col-lg-6">
          <ul class="list-unstyled contact-details">
            <li class="mb-3"><a href="<?php echo $bookingSettings['address_link'] ?>" class="theme-color h5"><i class="fas fa-map-marker-alt mr-2"></i> <?php echo $bookingSettings['address'] ?></a></li>
            <li class="mb-3"><a href="mailto:<?php echo $bookingSettings['email'] ?>" class="theme-color h5"><i class="far fa-envelope mr-1"></i> <?php echo $bookingSettings['email'] ?></a></li>
          </ul>
        </div>
        <div class="col-lg-6 col-xl-5">
          <form class="contact-form" id="contactForm">
            <div class="form-group row">
              <div class="col-md-6 mb-3"><input type="text" class="form-control form-control-lg" placeholder="<?php echo direction("Name","الاسم") ?>" required name="name" id="name"></div>
              <div class="col-md-6 mb-3"><input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="<?php echo direction("Email","البريد الإلكتروني") ?>" required></div>
            </div>
            <div class="form-group row">
              <div class="col-md-6 mb-3"><input type="text" name="phone" id="phone" class="form-control form-control-lg" placeholder="<?php echo direction("Phone","الهاتف") ?>"required></div>
              <div class="col-md-6 mb-3"><input type="text" name="subject" id="subject" class="form-control form-control-lg"  placeholder="<?php echo direction("Subject","الموضوع") ?>" required></div>
            </div>
            <div class="form-group row">
              <div class="col-md-12"><textarea class="form-control form-control-lg" id="message" name="message" rows="3" placeholder="<?php echo direction("Message","الرسالة") ?>"></textarea></div>
            </div>
            <div><button type="submit" class="btn btn-lg btn-outline-primary btn-block btn-rounded"><?php echo direction("Submit","إرسال") ?></button></div>
            <div id="bars1" style="display:none">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
             </div>
            <div id="msgSubmit" class="alert alert-success text-center mt-4 d-none"><?php echo direction("Your message has been sent successfully.","تم إرسال رسالتك بنجاح.") ?></div>
          </form>
          <div style="margin-top: 10px;color: red;">*
          <?php echo direction("Note: Please fill in all fields.","ملاحظة: يرجى ملء جميع الحقول.") ?>
        </div>
        </div>
      </div>
    </div>
  </section>
