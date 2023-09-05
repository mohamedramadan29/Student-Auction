<div class="whatsapp_bottom">
    <a href="https://wa.me/+96407710997820"> تواصل معنا <i class="fa fa-whatsapp"></i> </a>
</div>
<div class="footer">
    <div class="container">
        <div class="data desktop">
            <img src="uploads/logo.webp" alt="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="info">
                        <ul class="list-unstyled">
                            <li> <i class="fa fa-whatsapp"></i> <a href="https://wa.me/+96407710997820"> 07710997820 </a></li>
                            <li> <i class="fa fa-whatsapp"></i> <a href="https://wa.me/+96407832301812"> 07832301812 </a> </li>
                            <li> <i class="fa fa-envelope"></i> Alburaqq2016@gmail.com </li>
                            <li style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fa fa-support"></i> للاستفسار والشكاوي </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="info">
                        <p> جميع الحقوق محفوظه لشركة البراق للخدمات المالية </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="data mobile_data">
            <img src="uploads/logo.webp" alt="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="info">
                        <ul class="list-unstyled">
                            <li> <i class="fa fa-whatsapp"></i> <a href="https://wa.me/+96407710997820"> 07710997820 </a></li>

                            <li> <i class="fa fa-envelope"></i> Alburaqq2016@gmail.com </li>
                        </ul>
                        <ul class="list-unstyled">
                            <li> <i class="fa fa-whatsapp"></i> <a href="https://wa.me/+96407832301812"> 07832301812 </a> </li>
                            <li style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fa fa-support"></i> للاستفسار والشكاوي </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="info">
                        <p> جميع الحقوق محفوظه لشركة البراق للخدمات المالية </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> ارسل لنا وسنتواصل معك </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body request_form" style="padding-top: 0;">
                        <div class="data">
                            <form style="box-shadow: none;" action="" method="post">
                                <div class="group_form">
                                    <label for="name"> الأسم بالكامل </label>
                                    <input required type="text" class="form-control" name="name">
                                </div>
                                <div class="group_form">
                                    <label for="name"> رقم الهاتف </label>
                                    <input required type="text" class="form-control" name="phone">
                                </div>
                                <div class="group_form">
                                    <label for="name"> اكتب شكوتك </label>
                                    <textarea name="reason" id="" class="form-control"></textarea>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> اغلاق </button>
                        <button type="submit" name="send_reason" type="button" class="btn btn-primary"> ارسال </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        if (isset($_REQUEST['send_reason'])) {
            $name = sanitizeInput($_POST['name']);
            $phone = sanitizeInput($_POST['phone']);
            $reason = sanitizeInput($_POST['reason']);
            $formerror = [];
            if (empty($name) || empty($phone) || empty($reason)) {
                $formerror[] = 'من فضلك اكمل جميع البيانات';
            }
            if (empty($formerror)) {
                $stmt = $connect->prepare("INSERT INTO inquiries (name,phone,reason)
        VALUES(:zname,:zphone,:zreason)
        ");
                $stmt->execute(array(
                    "zname" => $name,
                    "zphone" => $phone,
                    "zreason" => $reason,
                ));
                if ($stmt) {
        ?>
                    <script src='themes/js/jquery.min.js'></script>
                    <script>
                        $(document).ready(function() {
                            swal({
                                title: "تم  الأرسال بنجاح",
                                icon: "success",
                                buttons: {
                                    cancel: "اغلاق ! ",
                                    defeat: false,
                                },
                            })
                        });
                    </script>
                <?php
                }
            } else {
                foreach ($formerror as $error) {
                ?>
                    <li class="alert alert-danger"> <?php echo $error; ?> </li>
        <?php
                }
            }
        }
        ?>
    </div>
</div>
<script src='<?php echo $js; ?>/jquery.min.js'></script>
<script src='<?php echo $js; ?>/bootstrap.min.js'></script>
<!-- nice vide -->
<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script src="https://kit.fontawesome.com/588e070751.js" crossorigin="anonymous"></script>
<!--<script src='<?php echo $js; ?>/slick.min.js'></script> -->
<!-- Sweet Alert  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--  type js -->
<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
<script src='<?php echo $js; ?>/select2.min.js'></script>
<script src='<?php echo $js; ?>/main.js'></script>
</body>

</html>
<!-- to video -->
<script>
    const player = new Plyr('#player');
    const player2 = new Plyr('#player2');
</script>

<script>
    var typed = new Typed('.element', {
        strings: [" منافذ السحب النقدي ", " صرف العملات ", " التحويلات المالية ", 'الخدمات المساعدة الأخرى'],
        typeSpeed: 50, // سرعة الكتابة بالمللي ثانية
        backSpeed: 30, // سرعة التراجع بالمللي ثانية
        startDelay: 100, // تأخير قبل بدء الكتابة بالمللي ثانية
        loop: true, // تكرار التأثير,

    });
</script>