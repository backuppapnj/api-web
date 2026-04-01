# Integrasi Joomla - Sisa Panjar Perkara

Dokumen ini menjelaskan cara mengintegrasikan modul Sisa Panjar Perkara dengan template Joomla.

## Endpoint API

Base URL: `https://api.pa-penajam.go.id/api`

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/sisa-panjar` | Ambil semua data dengan pagination |
| GET | `/sisa-panjar/{id}` | Ambil detail satu data |
| GET | `/sisa-panjar/tahun/{tahun}` | Filter berdasarkan tahun |

## Parameter Query

| Parameter | Tipe | Deskripsi |
|-----------|------|-----------|
| `tahun` | integer | Filter berdasarkan tahun (2000-2100) |
| `status` | string | Filter status: `belum_diambil` atau `disetor_kas_negara` |
| `bulan` | integer | Filter berdasarkan bulan (1-12) |
| `page` | integer | Nomor halaman (default: 1) |

## Struktur Response

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "tahun": 2025,
      "bulan": 4,
      "nomor_perkara": "279/Pdt.G/2025/PA.Pnj",
      "nama_penggugat_pemohon": "Nining binti Mulyana",
      "jumlah_sisa_panjar": 427000,
      "status": "disetor_kas_negara",
      "tanggal_setor_kas_negara": "2025-04-28",
      "created_at": "2025-04-01T10:00:00.000000Z",
      "updated_at": "2025-04-01T10:00:00.000000Z"
    }
  ],
  "current_page": 1,
  "last_page": 1,
  "per_page": 10,
  "total": 25
}
```

## Contoh Kode PHP untuk Joomla

### 1. Helper Function

```php
<?php
// Simpan di: templates/your_template/helper/sisa_panjar.php

class SisaPanjarHelper {
    private static $apiUrl = 'https://api.pa-penajam.go.id/api';
    
    public static function getData($tahun = null, $status = null) {
        $url = self::$apiUrl . '/sisa-panjar';
        $params = [];
        
        if ($tahun) {
            $params['tahun'] = $tahun;
        }
        if ($status) {
            $params['status'] = $status;
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $data = json_decode($response, true);
            return $data['success'] ? $data['data'] : [];
        }
        
        return [];
    }
    
    public static function getByYear($tahun) {
        $url = self::$apiUrl . '/sisa-panjar/tahun/' . intval($tahun);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $data = json_decode($response, true);
            return $data['success'] ? $data['data'] : [];
        }
        
        return [];
    }
    
    public static function formatRupiah($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
    
    public static function getNamaBulan($bulan) {
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulanNames[$bulan] ?? '';
    }
}
?&gt;
```

### 2. Template Layout

```php
<?php
// Simpan di: templates/your_template/html/com_content/article/sisa_panjar.php

defined('_JEXEC') or die;

require_once JPATH_THEMES . '/' . $this->template . '/helper/sisa_panjar.php';

$tahun = JFactory::getApplication()->input->getInt('tahun', date('Y'));
$tab = JFactory::getApplication()->input->getString('tab', 'belum-diambil');

$dataBelumDiambil = SisaPanjarHelper::getData($tahun, 'belum_diambil');
$dataDisetor = SisaPanjarHelper::getData($tahun, 'disetor_kas_negara');

// Group data by month
function groupByMonth($data) {
    $grouped = [];
    foreach ($data as $item) {
        $bulan = $item['bulan'];
        if (!isset($grouped[$bulan])) {
            $grouped[$bulan] = [];
        }
        $grouped[$bulan][] = $item;
    }
    return $grouped;
}

$groupedBelumDiambil = groupByMonth($dataBelumDiambil);
$groupedDisetor = groupByMonth($dataDisetor);
?&gt;

<div class="sisa-panjar-container">
    <h2 class="text-center">Sisa Panjar Yang Belum Diambil</h2>
    <h3 class="text-center">Pada Pengadilan Agama Penajam</h3>
    <h3 class="text-center">Tahun <?php echo $tahun; ?&gt;</h3>
    
    <hr />
    
    <p class="description">
        Sisa Panjar yang tidak diambil dalam waktu 6 (enam) bulan setelah dibacakan putusan, 
        maka uang sisa panjar biaya perkara tersebut akan dikeluarkan dari Buku Jurnal Keuangan 
        yang bersangkutan dan dicatat dalam buku tersendiri sebagai uang tak bertuan (1948 KUHPerdata), 
        yang selanjutnya uang tak bertuan tersebut akan disetorkan ke Kas Negara.
    </p>
    
    <!-- Tab Navigation -->
    <ul class="uk-tab" data-uk-tab>
        <li><a href="?tahun=<?php echo $tahun; ?&gt;&tab=belum-diambil">Sisa Panjar Yang Belum Diambil (<?php echo $tahun; ?&gt;)</a></li>
        <li><a href="?tahun=<?php echo $tahun; ?&gt;&tab=disetor">Sisa Panjar yang Disetor ke Kas Negara (<?php echo $tahun; ?&gt;)</a></li>
    </ul>
    
    <?php if ($tab === 'belum-diambil'): ?&gt;
    <!-- Tabel Belum Diambil -->
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th class="uk-text-center">Bulan</th>
                    <th>Nomor Perkara</th>
                    <th>Nama Penggugat/Pemohon</th>
                    <th class="uk-text-right">Jumlah Sisa Panjar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $hasData = false;
                for ($i = 1; $i <= 12; $i++): 
                    if (isset($groupedBelumDiambil[$i]) && !empty($groupedBelumDiambil[$i])):
                        $hasData = true;
                        foreach ($groupedBelumDiambil[$i] as $index => $item):
                ?&gt;
                    <tr>
                        <?php if ($index === 0): ?&gt;
                        <td class="uk-text-center" rowspan="<?php echo count($groupedBelumDiambil[$i]); ?&gt;">
                            <?php echo SisaPanjarHelper::getNamaBulan($i); ?&gt;
                        </td>
                        <?php endif; ?&gt;
                        <td class="uk-text-center"><?php echo htmlspecialchars($item['nomor_perkara']); ?&gt;</td>
                        <td><?php echo htmlspecialchars($item['nama_penggugat_pemohon']); ?&gt;</td>
                        <td class="uk-text-right"><?php echo SisaPanjarHelper::formatRupiah($item['jumlah_sisa_panjar']); ?&gt;</td>
                    </tr>
                <?php 
                        endforeach;
                    else:
                ?&gt;
                    <tr>
                        <td class="uk-text-center"><?php echo SisaPanjarHelper::getNamaBulan($i); ?&gt;</td>
                        <td class="uk-text-center" colspan="3">Nihil</td>
                    </tr>
                <?php 
                    endif;
                endfor; 
                ?&gt;
            </tbody>
        </table>
    </div>
    <?php else: ?&gt;
    
    <!-- Tabel Disetor Kas Negara -->
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th class="uk-text-center">Bulan</th>
                    <th>Tanggal Setor Ke Kas Negara</th>
                    <th>Nomor Perkara</th>
                    <th>Nama Penggugat/Pemohon</th>
                    <th class="uk-text-right">Jumlah Sisa Panjar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                for ($i = 1; $i <= 12; $i++): 
                    if (isset($groupedDisetor[$i]) && !empty($groupedDisetor[$i])):
                        foreach ($groupedDisetor[$i] as $index => $item):
                ?&gt;
                    <tr>
                        <?php if ($index === 0): ?&gt;
                        <td class="uk-text-center" rowspan="<?php echo count($groupedDisetor[$i]); ?&gt;">
                            <?php echo SisaPanjarHelper::getNamaBulan($i); ?&gt;
                        </td>
                        <?php endif; ?&gt;
                        <td class="uk-text-center">
                            <?php 
                            if ($item['tanggal_setor_kas_negara']) {
                                echo date('d F Y', strtotime($item['tanggal_setor_kas_negara']));
                            } else {
                                echo '-';
                            }
                            ?&gt;
                        </td>
                        <td class="uk-text-center"><?php echo htmlspecialchars($item['nomor_perkara']); ?&gt;</td>
                        <td><?php echo htmlspecialchars($item['nama_penggugat_pemohon']); ?&gt;</td>
                        <td class="uk-text-right"><?php echo SisaPanjarHelper::formatRupiah($item['jumlah_sisa_panjar']); ?&gt;</td>
                    </tr>
                <?php 
                        endforeach;
                    else:
                ?&gt;
                    <tr>
                        <td class="uk-text-center"><?php echo SisaPanjarHelper::getNamaBulan($i); ?&gt;</td>
                        <td class="uk-text-center" colspan="4">Nihil</td>
                    </tr>
                <?php 
                    endif;
                endfor; 
                ?&gt;
            </tbody>
        </table>
    </div>
    <?php endif; ?&gt;
    
    <!-- Year Selector -->
    <div class="uk-margin-top uk-text-center">
        <p>Pilih Tahun:</p>
        <div class="uk-button-group">
            <?php for ($y = date('Y'); $y >= 2021; $y--): ?&gt;
            <a href="?tahun=<?php echo $y; ?&gt;&tab=<?php echo $tab; ?&gt;" 
               class="uk-button <?php echo ($y == $tahun) ? 'uk-button-primary' : 'uk-button-default'; ?&gt;">
                <?php echo $y; ?&gt;
            </a>
            <?php endfor; ?&gt;
        </div>
    </div>
</div>
```

### 3. CSS Styling (Optional)

```css
/* Simpan di: templates/your_template/css/sisa_panjar.css */

.sisa-panjar-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.sisa-panjar-container h2 {
    font-size: 18pt;
    font-weight: bold;
    margin-bottom: 5px;
}

.sisa-panjar-container h3 {
    font-size: 14pt;
    font-weight: bold;
    margin-bottom: 10px;
}

.sisa-panjar-container .description {
    text-align: justify;
    margin-bottom: 20px;
    line-height: 1.6;
}

.sisa-panjar-container table {
    width: 100%;
    border-collapse: collapse;
}

.sisa-panjar-container th,
.sisa-panjar-container td {
    padding: 10px;
    border: 1px solid #ddd;
}

.sisa-panjar-container th {
    background-color: #f5f5f5;
    font-weight: bold;
}

.sisa-panjar-container .uk-text-center {
    text-align: center;
}

.sisa-panjar-container .uk-text-right {
    text-align: right;
}
```

### 4. Alternative: JavaScript Fetch (Client-side)

Jika ingin menggunakan JavaScript untuk fetch data:

```html
<script>
// Fungsi untuk mengambil data dari API
async function fetchSisaPanjar(tahun, status) {
    const baseUrl = 'https://api.pa-penajam.go.id/api/sisa-panjar';
    const params = new URLSearchParams();
    
    if (tahun) params.append('tahun', tahun);
    if (status) params.append('status', status);
    params.append('limit', '100');
    
    try {
        const response = await fetch(`${baseUrl}?${params.toString()}`);
        const data = await response.json();
        
        if (data.success) {
            return data.data;
        }
        return [];
    } catch (error) {
        console.error('Error fetching data:', error);
        return [];
    }
}

// Format Rupiah
function formatRupiah(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(amount);
}

// Format bulan
const namaBulan = [
    '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

// Group data by month
function groupByMonth(data) {
    const grouped = {};
    for (let i = 1; i <= 12; i++) {
        grouped[i] = [];
    }
    data.forEach(item => {
        if (grouped[item.bulan]) {
            grouped[item.bulan].push(item);
        }
    });
    return grouped;
}

// Render tabel
document.addEventListener('DOMContentLoaded', async function() {
    const tahun = new URLSearchParams(window.location.search).get('tahun') || new Date().getFullYear();
    
    // Fetch data
    const dataBelumDiambil = await fetchSisaPanjar(tahun, 'belum_diambil');
    const dataDisetor = await fetchSisaPanjar(tahun, 'disetor_kas_negara');
    
    // Render ke tabel (implementasi sesuai kebutuhan)
    console.log('Belum Diambil:', dataBelumDiambil);
    console.log('Disetor:', dataDisetor);
});
</script>
```

## Cache Strategy

Untuk mengurangi beban API, disarankan menggunakan cache:

```php
// Contoh dengan Joomla Cache
$cache = JFactory::getCache('sisa_panjar', 'output');
$cache->setCaching(1);
$cache->setLifeTime(3600); // 1 jam

$cacheKey = 'sisa_panjar_' . $tahun . '_' . $status;
$data = $cache->get($cacheKey);

if (!$data) {
    $data = SisaPanjarHelper::getData($tahun, $status);
    $cache->store($data, $cacheKey);
}
```

## Catatan Penting

1. **HTTPS**: Pastikan website Joomla menggunakan HTTPS untuk menghindari mixed content errors
2. **CORS**: API sudah dikonfigurasi untuk menerima request dari semua origin
3. **Rate Limiting**: API memiliki limit 100 request per menit
4. **Error Handling**: Selalu implementasikan error handling untuk menghindari broken layout
