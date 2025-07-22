<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ApiSimulasi extends ResourceController
{
    use ResponseTrait;

    public function updateSimulasi()
    {
        $db = \Config\Database::connect();
        $request = $this->request->getJSON(true);

        if (!isset($request['table']) || !in_array($request['table'], ['simulasi_tiu_suntuk', 'simulasi_bintang_bano'])) {
            return $this->fail('Nama tabel tidak valid', 400);
        }

        if (!isset($request['data']) || !is_array($request['data'])) {
            return $this->fail('Data tidak ditemukan atau format salah', 400);
        }

        $builder = $db->table($request['table']);
        $updated = 0;

        foreach ($request['data'] as $row) {
            if (!isset($row['id'])) continue;

            $updateData = [];

            if (isset($row['waktu']))  $updateData['waktu']  = $row['waktu'];
            if (isset($row['inflow'])) $updateData['inflow'] = $row['inflow'];
            if (isset($row['outflow'])) $updateData['outflow'] = $row['outflow'];
            if (isset($row['elevasi'])) $updateData['elevasi'] = $row['elevasi'];

            if (!empty($updateData)) {
                try {
                    $builder->where('id', $row['id'])->update($updateData);
                    $updated++;
                } catch (DatabaseException $e) {
                    // bisa log error jika perlu
                }
            }
        }

        return $this->respond([
            'status' => true,
            'updated' => $updated,
            'message' => "Berhasil memperbarui $updated baris data."
        ]);
    }

    public function updateSimulasiGabungan()
        {
        $db = \Config\Database::connect();
        $request = $this->request->getJSON(true);
        $allowedTables = ['simulasi_tiu_suntuk', 'simulasi_bintang_bano'];

        $result = [];
        foreach ($allowedTables as $table) {
            if (!isset($request[$table]) || !is_array($request[$table])) continue;

            $builder = $db->table($table);
            $updated = 0;

            foreach ($request[$table] as $row) {
                if (!isset($row['id'])) continue;

                $data = [];

                if (isset($row['waktu'])) $data['waktu'] = $row['waktu'];
                if (isset($row['inflow'])) $data['inflow'] = $row['inflow'];
                if (isset($row['outflow'])) $data['outflow'] = $row['outflow'];
                if (isset($row['elevasi'])) $data['elevasi'] = $row['elevasi'];

                if (!empty($data)) {
                    $builder->where('id', $row['id'])->update($data);
                    $updated++;
                }
            }

            $result[$table] = $updated;
        }

        return $this->respond([
            'status' => true,
            'updated' => $result,
            'message' => "Berhasil memperbarui data untuk: " . implode(', ', array_keys($result))
        ]);
        
    }


    public function updateGabunganAwlr()
         {
        $json = $this->request->getJSON(true);

        if (!$json || (!isset($json['sampir']) && !isset($json['menemeng']))) {
            return $this->fail('Payload tidak valid.', 400);
        }

        $db = db_connect();
        $success = [];
        $error = [];

        // Update sampir
        if (isset($json['sampir']) && is_array($json['sampir'])) {
            foreach ($json['sampir'] as $row) {
                if (!isset($row['id']) || !isset($row['waktu']) || !isset($row['tma'])) continue;

                try {
                    $db->table('simulasi_awlr_sampir')
                        ->where('id', $row['id'])
                        ->update([
                            'waktu' => $row['waktu'],
                            'tma'   => $row['tma']
                        ]);
                    $success[] = "sampir ID {$row['id']}";
                } catch (\Exception $e) {
                    $error[] = "sampir ID {$row['id']} gagal: " . $e->getMessage();
                }
            }
        }

        // Update menemeng
        if (isset($json['menemeng']) && is_array($json['menemeng'])) {
            foreach ($json['menemeng'] as $row) {
                if (!isset($row['id']) || !isset($row['waktu']) || !isset($row['tma'])) continue;

                try {
                    $db->table('simulasi_awlr_menemeng')
                        ->where('id', $row['id'])
                        ->update([
                            'waktu' => $row['waktu'],
                            'tma'   => $row['tma']
                        ]);
                    $success[] = "menemeng ID {$row['id']}";
                } catch (\Exception $e) {
                    $error[] = "menemeng ID {$row['id']} gagal: " . $e->getMessage();
                }
            }
        }

        return $this->respond([
            'status' => true,
            'updated' => $success,
            'error' => $error
        ]);
     }

}
