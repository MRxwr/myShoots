<div class="row p-5" style="align-items: center; justify-content: center;">
    <div class="col-6"><img src="https://i.imgur.com/yWCfKJE.png" class="img-fluid" /></div>
    <div class="col-6">
        <h2 class="font-weight-bold"><?php echo $settingsTitle ?></h2>
        <h3 class="font-weight-bold"><?php echo direction("Something Went Wrong","حدث خطأ ما") ?></h3>
        <h4 class="mb-4"><?php echo direction("We are sorry, we doing maintenance, we will be back soon.","نعتذر، نحن في الصيانة، سوف نعود قريبا.") ?></h4>
        <a class="btn btn-primary mb-2" style="font-weight:600; letter-spacing:1px; background: linear-gradient(90deg, <?php echo $websiteColors["button1"] ?> 0%, <?php echo $websiteColors["button2"] ?> 100%); border:none; color:#fff;" href="/?v=Home"><?php echo direction("Back to Home","العودة إلى الصفحة الرئيسية") ?></a>
    </div>
</div>