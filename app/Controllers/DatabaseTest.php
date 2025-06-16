<?php

namespace App\Controllers;

use App\Models\TelemetriModel;
use CodeIgniter\Controller;

class DatabaseTest extends Controller
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $version = $db->getVersion();

            // Panggil data dari model
            $model = new TelemetriModel();
            $data = $model->findAll();

            echo "<h2>Koneksi ke database BERHASIL!</h2>";
            echo "<p>Versi MySQL: <strong>$version</strong></p>";
            echo "<h3>Data dari tabel tb_telemetri:</h3>";

            if (empty($data)) {
                echo "<p>Tidak ada data.</p>";
            } else {
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>ID</th><th>Nama Lokasi</th><th>Waktu</th><th>TMA</th><th>Hujan</th></tr>";
                foreach ($data as $row) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nama_lokasi']}</td>
                            <td>{$row['waktu']}</td>
                            <td>{$row['tma']}</td>
                            <td>{$row['hujan']}</td>
                          </tr>";
                }
                echo "</table>";
            }

        } catch (\Exception $e) {
            echo "<h2>Koneksi ke database GAGAL!</h2>";
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}
