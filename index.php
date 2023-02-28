<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> CMS </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <h1 class="p-3 text-center mt-4 text-danger border-bottom">CMS</h1>
    <form id="form_data" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4 border-end">
            </div>
            <div class="col-sm-4 border-bottom pb-5">
                <h2 class="text-center text-secondary border-bottom"> Import Full Table</h2>
                <span id="success"></span>
                <input type="file" name="file" class="form-control form-control-sm">
                <div class="text-center mt-4">

                    <button onclick="ajaxCall('form_data','import_full_table.php','success')" type="button" class="btn btn-primary btn-sm">Upload File</button>
                </div>
            </div>
            <div class="col-sm-4 border-start">

            </div>
        </div>

    </form>
    <hr>
    <form id="form_data1" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4 border-end">
            </div>

            <div class="col-sm-4 border-bottom pb-5">
                <h2 class="text-center text-success border-bottom">Import Csv By Table</h2>
                <span id="success1"></span>
                <input type="file" name="file" class="form-control form-control-sm">
                <div class="text-center mt-4">

                    <button onclick="ajaxCall('form_data1','import.php','success1')" type="button" class="btn btn-primary btn-sm">Upload File</button>
                </div>
            </div>
            <div class="col-sm-4 border-start">

            </div>
        </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <?php include_once "framework/ajax/method.php"
    ?>

</body>

</html>