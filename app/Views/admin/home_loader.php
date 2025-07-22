<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Loading</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
    #loading-screen {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: #f4f6f9;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

        #loadingSpinner {
        text-align: center;
        padding: 40px 0;
    }
  </style>
</head>
<body>

     <div id="loading-screen">
        <h5>⏳ Memuat data API...</h5>
        <div class="progress" style="width: 250px;">
            <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 100%">
            Tunggu sebentar...
            </div>
        </div>
    </div>

<!-- Konten dashboard akan dimuat di sini -->
<div id="dashboard-content"></div>

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

<script>
  $(document).ready(function () {
    $('#dashboard-content').load("<?= base_url('admin/data') ?>", function () {
      $('#loading-screen').fadeOut(300);
    });
  });


</script>

</body>
</html>
