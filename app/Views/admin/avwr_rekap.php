<?php echo $this->extend('admin/layout'); ?>

<?= $this->section('styles') ?>
<style>
    /* Table container with fixed header */
    .table-responsive {
        position: relative;
        max-height: 70vh;
        overflow: auto;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background: #fff;
        /* Agar sticky header tetap terlihat saat scroll horizontal */
        /* Webkit browsers */
        -webkit-overflow-scrolling: touch;
    }
    
    /* Table styling */
    .table {
        width: 100%;
        min-width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        table-layout: auto;
    }
    
    /* Fixed header */
    .table thead {
        position: sticky;
        top: 0;
        z-index: 20;
        background: #f8f9fa;
    }
    
    .table thead th {
        background-color: #f8f9fa;
        z-index: 30;
        text-align: center;
        vertical-align: middle;
        border-bottom: 2px solid #dee2e6;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        left: 0;
        background-clip: padding-box;
    }
    
    /* Center align table cells */
    .table td {
        text-align: center;
        vertical-align: middle;
    }
    
    /* Ensure table header has proper background */
    .table thead th {
        background-color: #f8f9fa;
    }
    
    /* Add some padding and border to table cells */
    .table td, .table th {
        padding: 0.5rem;
        vertical-align: middle;
    }
    
    /* Add hover effect */
    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    /* Loading indicator */
    #loadingIndicator {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Loading indicator -->
<div id="loadingIndicator" class="text-center">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Memuat data...</span>
    </div>
    <p class="mt-2">Memuat data, harap tunggu...</p>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">AVWR Rekap Data</h4>
                </div>
                <div class="card-body">
                    <?php 
                    // // Debug output
                    // echo '<!-- Debug Info -->';
                    // echo '<!-- POST: ' . print_r($_POST, true) . ' -->';
                    // echo '<!-- GET: ' . print_r($_GET, true) . ' -->';
                    // echo '<!-- $sensorData: ' . (isset($sensorData) ? 'Set' : 'Not set') . ' -->';
                    
                    if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <strong>Error:</strong> <?= session()->getFlashdata('error') ?>
                            <?php if (ENVIRONMENT !== 'production' && session()->getFlashdata('debug')) : ?>
                                <hr>
                                <pre class="mt-2"><?= htmlspecialchars(session()->getFlashdata('debug')) ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('avwr-rekap') ?>" method="get" class="mb-4">
                        <div class="d-flex flex-wrap gap-3 align-items-end">
                            <div style="min-width: 180px;">
                                <label class="mb-1">Pilih STA</label>
                                <select name="sta" class="form-control" required>
                                    <option value="">-- Pilih STA --</option>
                                    <?php foreach ($stations as $id => $name) : ?>
                                        <option value="<?= $id ?>" <?= (isset($_GET['sta']) && $_GET['sta'] == $id) ? 'selected' : '' ?>>
                                            <?= $name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div style="min-width: 180px;">
                                <label class="mb-1">Pilih Interval</label>
                                <select name="interval" class="form-control" required>
                                    <option value="">-- Pilih Interval --</option>
                                    <?php foreach ($intervals as $key => $label) : ?>
                                        <option value="<?= $key ?>" <?= (isset($interval) && $interval == $key) ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div style="min-width: 200px;">
                                <label class="mb-1">Tanggal Awal</label>
                                <input type="date" name="start_date" class="form-control" value="<?= $_GET['start_date'] ?? '' ?>" required>
                            </div>
                            <div style="min-width: 200px;">
                                <label class="mb-1">Tanggal Akhir</label>
                                <input type="date" name="end_date" class="form-control" value="<?= $_GET['end_date'] ?? date('Y-m-d') ?>" required>
                            </div>
                            <div class="d-flex gap-2 align-items-end" style="min-width: 180px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Tampilkan Data
                                </button>
                                <?php if (isset($sensorData) && !empty($sensorData)) : ?>
                                    <button type="button" class="btn btn-success" id="exportExcelBtn">
                                        <i class="fas fa-file-export"></i> Export Excel
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>

                    <?php 
                    // Debug output
                    if (isset($sensorData)) {
                        if (!is_array($sensorData)) {
                            echo '<!-- sensorData is not an array: ' . gettype($sensorData) . ' -->';
                            if ($sensorData === null) {
                                echo '<!-- sensorData is null -->';
                            }
                        }
                        
                        // // Debug output
                        // echo '<!-- Data Type: ' . gettype($sensorData) . ' -->';
                        // echo '<!-- Data Content: ' . print_r($sensorData, true) . ' -->';
                        
                        if (is_array($sensorData) && !empty($sensorData)) {
                            // Get the first item to check the structure
                            $firstItem = reset($sensorData);
                            $isNested = (is_array($firstItem) && isset($firstItem['data']));
                            
                            // Get all unique column headers
                            $columns = [];
                            foreach ($sensorData as $item) {
                                $data = $isNested ? ($item['data'] ?? []) : $item;
                                $columns = array_merge($columns, array_keys($data));
                            }
                            $columns = array_unique($columns);
                            // Remove unwanted columns
                            $columns = array_diff($columns, ['id', 'id_sta']);
                            sort($columns);
                            ?>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="sensorTable" style="width:100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Waktu</th>
                                            <?php foreach ($columns as $col): ?>
                                                <th><?= ucfirst(str_replace(['_', '-'], ' ', $col)) ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sensorData as $entry): 
                                            $data = $isNested ? ($entry['data'] ?? []) : $entry;
                                            $waktu = $data['waktu'] ?? ($entry['waktu'] ?? 'N/A');
                                            unset($data['waktu']);
                                            ?>
                                            <tr>
                                                <td class="text-nowrap"><?= $waktu ?></td>
                                                <?php foreach ($columns as $col): 
                                                    $value = $data[$col] ?? '';
                                                    // Format numeric values
                                                    if (is_numeric($value)) {
                                                        $value = number_format((float)$value, 2);
                                                    }
                                                    ?>
                                                    <td class="text-nowrap"><?= $value ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php 
                        } elseif (empty($sensorData)) { 
                            // No data message removed
                        }
                    } else { 
                        // Initial message removed
                    }
                    
                    // Error message handling removed as requested
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css"/>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#sensorTable').DataTable({
        dom: "t", // Only show table, no export buttons
        pageLength: 25,
        order: [[0, 'desc']],
        scrollX: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/Indonesian.json'
        }
    });

    // Show loading state on form submit
    $('form').on('submit', function() {
        var loadingIndicator = document.getElementById('loadingIndicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }
        
        var submitBtn = $(this).find('button[type="submit"]');
        if (submitBtn.length) {
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
        }
    });

    // Handle export button click
    $('#exportExcelBtn').on('click', function() {
        // Ambil parameter dari form/filter
        const params = {
            sta: $('select[name="sta"]').val(),
            interval: $('select[name="interval"]').val(),
            start_date: $('input[name="start_date"]').val(),
            end_date: $('input[name="end_date"]').val()
        };
        // Build query string
        const query = $.param(params);
        // Redirect to export endpoint
        window.location.href = '<?= base_url('avwr-rekap/export') ?>?' + query;
    });

    // Hide loading indicator when DataTable is initialized
    var loadingIndicator = document.getElementById('loadingIndicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'none';
    }
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>

