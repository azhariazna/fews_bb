<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

</head>
<body class="p-3">
    <div class="container-fluid">

    <!-- JUDUL DATA INSTRUMEN -->
    <div class="row">
      <div class="col-12">
        <h4 class="fw-bold mb-3 text-primary" style="letter-spacing:1px;">DATA INSTRUMEN</h4>
      </div>
    </div>

    <div class="row">
        <!-- GROUP 1: Bendungan Tiu Suntuk -->
        <div class="col-12 col-lg-6 mb-3">
            <div class="card card-primary card-outline mt-3 shadow-sm">
                <div class="card-header bg-dark text-white py-2 px-3 d-flex align-items-center" style="font-size:0.95rem;">
                    <span class="fw-bold"><i class="fas fa-water me-2"></i> Bendungan Tiu Suntuk</span>
                </div>
                <div class="card-body py-2 px-2">
                    <div class="row g-2">
                        <?php foreach ([$logger5, $logger7, $logger8, $logger6] as $logger): ?>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-2">
                                <div class="card border-dark h-100">
                                    <div class="card-header bg-secondary text-white text-center fw-semibold py-1 px-2" style="font-size:0.93em;">
                                        <?= esc($logger['nama_pos']) ?> <br>
                                        <span class="fw-normal" style="font-size:0.9em;">Logger ID: <?= esc($logger['id_logger']) ?></span>
                                    </div>
                                    <div class="card-body p-2" style="font-size:0.93em;">
                                        <p class="mb-1"><strong>Status:</strong>
                                            <?php if ($logger['status_koneksi'] == "Koneksi Terputus"): ?>
                                                <span class="badge badge-danger"><?= esc($logger['status_koneksi']) ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-success"><?= esc($logger['status_koneksi']) ?></span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="mb-1"><strong>Waktu:</strong> <small><?= esc($logger['data']['waktu']) ?></small></p>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($logger['data'] as $key => $val): ?>
                                                <?php if ($key === 'waktu') continue; ?>
                                            <?php endforeach; ?>
                                            <?php foreach ($logger['data'] as $item): ?>
                                                <?php if (is_array($item)) {
                                                    foreach ($item as $param): ?>
                                                        <li class="list-group-item py-1 px-2" style="font-size:0.93em;">
                                                            <small>
                                                                <strong><?= esc($param['nama_parameter']) ?>:</strong>
                                                                <?= esc($param['nilai']) ?> <?= esc($param['satuan']) ?>
                                                            </small>
                                                        </li>
                                                    <?php endforeach;
                                                    break;
                                                } ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- GROUP 2: Bendungan Bintang Bano -->
        <div class="col-12 col-lg-6 mb-3">
            <div class="card card-primary card-outline mt-3 shadow-sm">
                <div class="card-header bg-dark text-white py-2 px-3 d-flex align-items-center" style="font-size:0.95rem;">
                    <span class="fw-bold"><i class="fas fa-tint me-2"></i> Bendungan Bintang Bano</span>
                </div>
                <div class="card-body py-2 px-2" style="font-size:0.93rem;">
                    <div class="row g-2">
                        <div class="col-12 col-sm-4 mb-2">
                            <div class="card border-warning h-100">
                                <div class="card-header bg-warning text-white py-1 px-2" style="font-size:0.93em;">
                                    Data Logger - AWLR
                                </div>
                                <div class="card-body p-2" style="font-size:0.93em;">
                                    <p class="mb-1"><strong>Waktu:</strong> <?= esc($logger3['waktu']) ?></p>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($logger3['data_terakhir'] as $item): ?>
                                            <li class="list-group-item py-1 px-2" style="font-size:0.93em;">
                                                <strong><?= esc($item['sensor']) ?>:</strong> <?= esc($item['data']) ?> <?= esc($item['satuan']) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <div class="card border-secondary h-100">
                                <div class="card-header bg-secondary text-white py-1 px-2" style="font-size:0.93em;">
                                    Data Logger - V Notch
                                </div>
                                <div class="card-body p-2" style="font-size:0.93em;">
                                    <p class="mb-1"><strong>Waktu:</strong> <?= esc($logger4['waktu']) ?></p>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($logger4['data_terakhir'] as $item): ?>
                                            <li class="list-group-item py-1 px-2" style="font-size:0.93em;">
                                                <strong><?= esc($item['sensor']) ?>:</strong> <?= esc($item['data']) ?> <?= esc($item['satuan']) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <div class="card border-success h-100">
                                <div class="card-header bg-success text-white py-1 px-2" style="font-size:0.93em;">
                                    Data Logger - Klimatologi
                                </div>
                                <div class="card-body p-2" style="font-size:0.93em;">
                                    <p class="mb-1"><strong>Waktu:</strong> <?= esc($logger2['waktu']) ?></p>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($logger2['data_terakhir'] as $item): ?>
                                            <li class="list-group-item py-1 px-2" style="font-size:0.93em;">
                                                <strong><?= esc($item['sensor']) ?>:</strong> <?= esc($item['data']) ?> <?= esc($item['satuan']) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /row -->
                </div> <!-- /card-body -->
            </div> <!-- /card -->
        </div>
    </div>

    <!-- GROUP 3: AWLR Sungai -->
    <div class="row">
  <div class="col-12">
    <div class="card card-primarycard-outline mt-4 shadow">
      <div class="card-header bg-info text-white d-flex align-items-center" style="font-size:0.95rem;">
        <span class="fw-bold"><i class="fas fa-info-circle me-2"></i> Informasi AWLR Sungai</span>
      </div>
      <div class="card-body py-2 px-2" style="font-size:0.93rem;">
        <div class="row g-2">
          <?php
          $awlrNames = [
            'AWLR MATAIYANG',
            'AWLR SAMPIR',
            'AWLR MENEMENG'
          ];
          foreach ($awlrNames as $name):
            $found = null;
            if (isset($awlrSungaiList) && is_array($awlrSungaiList)) {
              foreach ($awlrSungaiList as $item) {
                if (isset($item['nama_lokasi']) && $item['nama_lokasi'] === $name) {
                  $found = $item;
                  break;
                }
              }
            }
          ?>
          <div class="col-12 col-sm-4 mb-2">
            <div class="card border-info h-100">
              <div class="card-header bg-info text-white text-center fw-semibold py-1 px-2" style="font-size:0.93em;">
                <?= esc($name) ?>
              </div>
              <div class="card-body p-2" style="font-size:0.93em;">
                <p class="mb-1"><strong>Status:</strong>
                  <?php if ($found && isset($found['status_koneksi'])): ?>
                    <?php if ($found['status_koneksi'] == "Koneksi Terputus"): ?>
                      <span class="badge badge-danger"><?= esc($found['status_koneksi']) ?></span>
                    <?php else: ?>
                      <span class="badge badge-success"><?= esc($found['status_koneksi']) ?></span>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="badge badge-secondary">-</span>
                  <?php endif; ?>
                </p>
                <p class="mb-1"><strong>Waktu:</strong>
                  <?php if ($found && isset($found['waktu'])): ?>
                    <?= esc($found['waktu']) ?>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </p>
                <p class="mb-1"><strong>TMA:</strong>
                  <?php if ($found && isset($found['tma'])): ?>
                    <?= esc($found['tma'])/100 ?> m
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
    </div>
</body>
</html>
</body>
</html>
