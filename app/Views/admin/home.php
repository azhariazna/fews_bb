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
      <div class="card-header bg-dark text-white py-2 px-3 d-flex align-items-center" style="font-size:0.95rem;">
        <span class="fw-bold"><i class="fas fa-water me-2"></i> DATA INSTRUMEN</span>
    </div>

    <div class="container-fluid">
    <!-- INFO & JUDUL DATA INSTRUMEN -->
    <div class="row">
      <div class="col-12 mb-2">
        <!-- Penampang 1 -->
        <h5 class="fw-bold text-secondary mb-2">AVWR STA. 0+100</h5>
        <div class="row g-2 align-items-start">
          <div class="col-md-6 ps-1">
            <img src="<?= base_url('assets/img/100.jpg') ?>"alt="Skema Penampang 2"class="img-fluid"style="width:98%; height:auto; border:none; padding:0; margin:0;">
          </div>
          <div class="col-md-6 ps-1">
            <div class="table-responsive w-100">
              <table class="table table-bordered table-sm mb-0" style="font-size:0.93em; min-width:320px;">
                <thead class="thead-light" style="background:#e9ecef;">
                  <tr>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Lokasi</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Kode</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Elevasi</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Frekuensi (Hz)</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">P (kPa)</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">P (mH2O)</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Temp. (°C)</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td rowspan="4" class="align-middle">Pondasi</td><td>FP 1</td><td>36.50</td><td><?= esc($avwData['FP1'][0] ?? '-') ?></td><td><?= esc($avwData['FP1'][1] ?? '-') ?></td><td><?= esc($avwData['FP1'][2] ?? '-') ?></td><td><?= esc($avwData['FP1'][3] ?? '-') ?></td><td><?= (esc($avwData['FP1'][2] ?? 0) < (682.57 - 36.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>FP 2</td><td>36.50</td><td><?= esc($avwData['FP2'][0] ?? '-') ?></td><td><?= esc($avwData['FP2'][1] ?? '-') ?></td><td><?= esc($avwData['FP2'][2] ?? '-') ?></td><td><?= esc($avwData['FP2'][3] ?? '-') ?></td><td><?= (esc($avwData['FP2'][2] ?? 0) < (682.24 - 36.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>FP 3</td><td>46.50</td><td><?= esc($avwData['FP3'][0] ?? '-') ?></td><td><?= esc($avwData['FP3'][1] ?? '-') ?></td><td><?= esc($avwData['FP3'][2] ?? '-') ?></td><td><?= esc($avwData['FP3'][3] ?? '-') ?></td><td><?= (esc($avwData['FP3'][2] ?? 0) < (556.41 - 46.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>FP 4</td><td>46.50</td><td><?= esc($avwData['FP4'][0] ?? '-') ?></td><td><?= esc($avwData['FP4'][1] ?? '-') ?></td><td><?= esc($avwData['FP4'][2] ?? '-') ?></td><td><?= esc($avwData['FP4'][3] ?? '-') ?></td><td><?= (esc($avwData['FP4'][2] ?? 0) < (556.08 - 46.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td rowspan="9" class="align-middle">Timbunan</td><td>EP 1</td><td>60.50</td><td><?= esc($avwData['EP1'][0] ?? '-') ?></td><td><?= esc($avwData['EP1'][1] ?? '-') ?></td><td><?= esc($avwData['EP1'][2] ?? '-') ?></td><td><?= esc($avwData['EP1'][3] ?? '-') ?></td><td><?= (esc($avwData['EP1'][2] ?? 0) < (409.59 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 2</td><td>60.50</td><td><?= esc($avwData['EP2'][0] ?? '-') ?></td><td><?= esc($avwData['EP2'][1] ?? '-') ?></td><td><?= esc($avwData['EP2'][2] ?? '-') ?></td><td><?= esc($avwData['EP2'][3] ?? '-') ?></td><td><?= (esc($avwData['EP2'][2] ?? 0) < (408.37 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 3</td><td>60.50</td><td><?= esc($avwData['EP3'][0] ?? '-') ?></td><td><?= esc($avwData['EP3'][1] ?? '-') ?></td><td><?= esc($avwData['EP3'][2] ?? '-') ?></td><td><?= esc($avwData['EP3'][3] ?? '-') ?></td><td><?= (esc($avwData['EP3'][2] ?? 0) < (344.76 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 4</td><td>60.50</td><td><?= esc($avwData['EP4'][0] ?? '-') ?></td><td><?= esc($avwData['EP4'][1] ?? '-') ?></td><td><?= esc($avwData['EP4'][2] ?? '-') ?></td><td><?= esc($avwData['EP4'][3] ?? '-') ?></td><td><?= (esc($avwData['EP4'][2] ?? 0) < (408.37 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 5</td><td>60.50</td><td><?= esc($avwData['EP5'][0] ?? '-') ?></td><td><?= esc($avwData['EP5'][1] ?? '-') ?></td><td><?= esc($avwData['EP5'][2] ?? '-') ?></td><td><?= esc($avwData['EP5'][3] ?? '-') ?></td><td><?= (esc($avwData['EP5'][2] ?? 0) < (408.89 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 6</td><td>73.00</td><td><?= esc($avwData['EP6'][0] ?? '-') ?></td><td><?= esc($avwData['EP6'][1] ?? '-') ?></td><td><?= esc($avwData['EP6'][2] ?? '-') ?></td><td><?= esc($avwData['EP6'][3] ?? '-') ?></td><td><?= (esc($avwData['EP6'][2] ?? 0) < (229.84 - 73.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 7</td><td>73.00</td><td><?= esc($avwData['EP7'][0] ?? '-') ?></td><td><?= esc($avwData['EP7'][1] ?? '-') ?></td><td><?= esc($avwData['EP7'][2] ?? '-') ?></td><td><?= esc($avwData['EP7'][3] ?? '-') ?></td><td><?= (esc($avwData['EP7'][2] ?? 0) < (229.84 - 73.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 8</td><td>85.50</td><td><?= esc($avwData['EP8'][0] ?? '-') ?></td><td><?= esc($avwData['EP8'][1] ?? '-') ?></td><td><?= esc($avwData['EP8'][2] ?? '-') ?></td><td><?= esc($avwData['EP8'][3] ?? '-') ?></td><td><?= (esc($avwData['EP8'][2] ?? 0) < (114.92 - 85.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Penampang 2 -->
        <h5 class="fw-bold text-secondary mt-4 mb-2">AVWR STA. 0+180</h5>
        <div class="row g-2 align-items-start">
          <div class="col-md-6 pe-1">
            <img src="<?= base_url('assets/img/180.jpg') ?>"alt="Skema Penampang 2"class="img-fluid"style="width:100%; height:auto; border:none; padding:0; margin:0;">
          </div>
          <div class="col-md-6 ps-1">
            <div class="table-responsive w-100">
              <table class="table table-bordered table-sm mb-0" style="font-size:0.93em; min-width:320px;">
                <thead class="thead-light" style="background:#e9ecef;">
                  <tr>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Lokasi</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Kode</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Elevasi</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Frekuensi (Hz)</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">P (kPa)</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">P (mH2O)</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Temp. (°C)</th>
                    <th class="align-top text-center border border-dark" style="background:#e9ecef;">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Contoh data penampang 2, silakan sesuaikan -->
                  <tr><td rowspan="4" class="align-middle">Pondasi</td><td>FP 5</td><td>28.00</td><td><?= esc($avwData['FP5'][0] ?? '-') ?></td><td><?= esc($avwData['FP5'][1] ?? '-') ?></td><td><?= esc($avwData['FP5'][2] ?? '-') ?></td><td><?= esc($avwData['FP5'][3] ?? '-') ?></td><td><?= (esc($avwData['FP5'][2] ?? 0) < (767.04 - 28.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>FP 6</td><td>28.00</td><td><?= esc($avwData['FP6'][0] ?? '-') ?></td><td><?= esc($avwData['FP6'][1] ?? '-') ?></td><td><?= esc($avwData['FP6'][2] ?? '-') ?></td><td><?= esc($avwData['FP6'][3] ?? '-') ?></td><td><?= (esc($avwData['FP6'][2] ?? 0) < (766.71 - 28.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>FP 7</td><td>38.00</td><td><?= esc($avwData['FP7'][0] ?? '-') ?></td><td><?= esc($avwData['FP7'][1] ?? '-') ?></td><td><?= esc($avwData['FP7'][2] ?? '-') ?></td><td><?= esc($avwData['FP7'][3] ?? '-') ?></td><td><?= (esc($avwData['FP7'][2] ?? 0) < (640.88 - 38.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>FP 8</td><td>38.00</td><td><?= esc($avwData['FP8'][0] ?? '-') ?></td><td><?= esc($avwData['FP8'][1] ?? '-') ?></td><td><?= esc($avwData['FP8'][2] ?? '-') ?></td><td><?= esc($avwData['FP8'][3] ?? '-') ?></td><td><?= (esc($avwData['FP8'][2] ?? 0) < (640.55 - 38.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td rowspan="12" class="align-middle">Timbunan</td><td>EP 9</td><td>48.00</td><td><?= esc($avwData['EP9'][0] ?? '-') ?></td><td><?= esc($avwData['EP9'][1] ?? '-') ?></td><td><?= esc($avwData['EP9'][2] ?? '-') ?></td><td><?= esc($avwData['EP9'][3] ?? '-') ?></td><td><?= (esc($avwData['EP9'][2] ?? 0) < (553.71 - 48.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 10</td><td>48.00</td><td><?= esc($avwData['EP10'][0] ?? '-') ?></td><td><?= esc($avwData['EP10'][1] ?? '-') ?></td><td><?= esc($avwData['EP10'][2] ?? '-') ?></td><td><?= esc($avwData['EP10'][3] ?? '-') ?></td><td><?= (esc($avwData['EP10'][2] ?? 0) < (488.08 - 48.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 11</td><td>48.00</td><td><?= esc($avwData['EP11'][0] ?? '-') ?></td><td><?= esc($avwData['EP11'][1] ?? '-') ?></td><td><?= esc($avwData['EP11'][2] ?? '-') ?></td><td><?= esc($avwData['EP11'][3] ?? '-') ?></td><td><?= (esc($avwData['EP11'][2] ?? 0) < (553.38 - 48.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 12</td><td>48.00</td><td><?= esc($avwData['EP12'][0] ?? '-') ?></td><td><?= esc($avwData['EP12'][1] ?? '-') ?></td><td><?= esc($avwData['EP12'][2] ?? '-') ?></td><td><?= esc($avwData['EP12'][3] ?? '-') ?></td><td><?= (esc($avwData['EP12'][2] ?? 0) < (409.59 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 13</td><td>60.50</td><td><?= esc($avwData['EP13'][0] ?? '-') ?></td><td><?= esc($avwData['EP13'][1] ?? '-') ?></td><td><?= esc($avwData['EP13'][2] ?? '-') ?></td><td><?= esc($avwData['EP13'][3] ?? '-') ?></td><td><?= (esc($avwData['EP13'][2] ?? 0) < (408.37 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 14</td><td>60.50</td><td><?= esc($avwData['EP14'][0] ?? '-') ?></td><td><?= esc($avwData['EP14'][1] ?? '-') ?></td><td><?= esc($avwData['EP14'][2] ?? '-') ?></td><td><?= esc($avwData['EP14'][3] ?? '-') ?></td><td><?= (esc($avwData['EP14'][2] ?? 0) < (344.76 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 15</td><td>60.50</td><td><?= esc($avwData['EP15'][0] ?? '-') ?></td><td><?= esc($avwData['EP15'][1] ?? '-') ?></td><td><?= esc($avwData['EP15'][2] ?? '-') ?></td><td><?= esc($avwData['EP15'][3] ?? '-') ?></td><td><?= (esc($avwData['EP15'][2] ?? 0) < (408.37 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 16</td><td>60.50</td><td><?= esc($avwData['EP16'][0] ?? '-') ?></td><td><?= esc($avwData['EP16'][1] ?? '-') ?></td><td><?= esc($avwData['EP16'][2] ?? '-') ?></td><td><?= esc($avwData['EP16'][3] ?? '-') ?></td><td><?= (esc($avwData['EP16'][2] ?? 0) < (408.89 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 17</td><td>60.50</td><td><?= esc($avwData['EP17'][0] ?? '-') ?></td><td><?= esc($avwData['EP17'][1] ?? '-') ?></td><td><?= esc($avwData['EP17'][2] ?? '-') ?></td><td><?= esc($avwData['EP17'][3] ?? '-') ?></td><td><?= (esc($avwData['EP17'][2] ?? 0) < (303.38 - 60.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 18</td><td>73.00</td><td><?= esc($avwData['EP18'][0] ?? '-') ?></td><td><?= esc($avwData['EP18'][1] ?? '-') ?></td><td><?= esc($avwData['EP18'][2] ?? '-') ?></td><td><?= esc($avwData['EP18'][3] ?? '-') ?></td><td><?= (esc($avwData['EP18'][2] ?? 0) < (242.44 - 73.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 19</td><td>73.00</td><td><?= esc($avwData['EP19'][0] ?? '-') ?></td><td><?= esc($avwData['EP19'][1] ?? '-') ?></td><td><?= esc($avwData['EP19'][2] ?? '-') ?></td><td><?= esc($avwData['EP19'][3] ?? '-') ?></td><td><?= (esc($avwData['EP19'][2] ?? 0) < (242.44 - 73.00)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                  <tr><td>EP 20</td><td>85.50</td><td><?= esc($avwData['EP20'][0] ?? '-') ?></td><td><?= esc($avwData['EP20'][1] ?? '-') ?></td><td><?= esc($avwData['EP20'][2] ?? '-') ?></td><td><?= esc($avwData['EP20'][3] ?? '-') ?></td><td><?= (esc($avwData['EP20'][2] ?? 0) < (553.71 - 85.50)) ? 'Aman' : 'Tidak Aman' ?></td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
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
