<?php
ob_start();
session_start();
include "init.php";
?>
<div class="balance_account">
    <div class="container">
        <div class="data">
            <h2> معرفة الرصيد </h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="box">
                    <label for=""> ادخل رقم الحساب الخاص بك </label>
                    <input required type="number" class="form-control" name="account_number" value="<?php if (isset($_REQUEST['account_number'])) echo $_REQUEST['account_number']; ?>">
                </div>
                <div class="box">
                    <button name="show_balance" type="submit" class="btn btn-primary"> مشاهدة الرصيد المتاح <i class="fa fa-eye"></i> </button>
                </div>
            </form>
            <?php
            if (isset($_POST['show_balance'])) {
                $account_number = filter_var($_POST['account_number'], FILTER_SANITIZE_NUMBER_INT);
                $fromerror = [];
                if (empty($account_number)) {
                    $fromerror[] = 'من فضلك ادخل رقم الحساب';
                }
                if (empty($fromerror)) {
                    $stmt = $connect->prepare("SELECT * FROM students WHERE card_number = ?");
                    $stmt->execute(array($account_number));
                    $acount_data = $stmt->fetch();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
            ?>
                        <br>
                        <br>
                        <table class="table table-bordered table-hover table-primary">
                            <thead>
                                <tr>
                                    <th> الاسم </th>
                                    <th> رقم الحساب </th>
                                    <th> الرصيد الكلي </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <?php echo $acount_data['name'] ?> </td>
                                    <td> <?php echo $acount_data['card_number'] ?> </td>
                                    <td> <?php echo $acount_data['balance'] ?> ريال </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php
                    } else {
                    ?>
                        <p class="alert alert-danger error_message"> لا يوجد حساب بهذا الرقم </p>
            <?php
                    }
                }
            }

            ?>
        </div>
    </div>
</div>
<?php
include $tem . "footer.php";
ob_end_flush();

?>