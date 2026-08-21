<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Payment</title>
</head>

<body style="background-color: #eeeeee; overflow-x: hidden;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 px-0">
                <div class="card p-3 vh-100">
                    <img src="logo.svg" alt="" class="img-fluid" height="190px" width="190px">
                    <div class="payment-text mt-4">
                        <h2>₹ <?=$this->payment['amount']?></h2>
                        <span class="mt-2">To</span>
                        <p class="mb-0 fw-bold"><?=$this->payment['name']?></p>
                        <p class="fw-bold"><?=$this->payment['mobile']?></p>
                    </div>
                    <div class="loader text-center">
                        <img src="loading-gif.gif" alt="" height="40px" width="40px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" name="redirect" id="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
        <input type="hidden" name="encRequest" id="encRequest" value="<?= $this->paymentGateway['encRequest'] ?>" />
        <input type="hidden" name="access_code" id="access_code" value="<?= $this->paymentGateway['access_code'] ?>" />
    </form>

    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($this->payment['amount'] > 0) { ?>
        <script type="text/javascript">
            setTimeout(function() {
                $("#redirect").submit();
            }, 1000);
        </script>
    <?php } ?>
</body>

</html>