<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\LhkpnReport;
use DOMDocument;
use DOMXPath;

class LhkpnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Load Data Pegawai for NIP matching
        $jsonPath = base_path('../data_pegawai.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("File data_pegawai.json not found at: $jsonPath");
            return;
        }

        $pegawaiData = json_decode(file_get_contents($jsonPath), true);
        $nameToNip = [];
        foreach ($pegawaiData as $p) {
            // Create a mapping of lowercase name to NIP for easier matching
            $nameToNip[strtolower($p['nama'])] = $p['nip'];
            $nameToNip[$p['nama']] = $p['nip'];
        }

        // 2. Load HTML File
        $htmlPath = base_path('../lhkpn.html');
        if (!file_exists($htmlPath)) {
            $this->command->error("File lhkpn.html not found at: $htmlPath");
            return;
        }

        // Suppress HTML5 parsing errors
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(file_get_contents($htmlPath));
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        // Define expected table structures
        $tables = $dom->getElementsByTagName('table');
        $count = 0;
        
        // Strategy: Iterate through tables and try to determine Context (Year, Type) from preceding elements
        foreach ($tables as $index => $table) {
            // Find the preceding heading or tab indicator to determine Year and Type
            $prev = $table->previousSibling;
            $year = null;
            $type = null;
            
            // Loop backwards through siblings to find context
            while ($prev) {
                if ($prev->nodeType === XML_ELEMENT_NODE) {
                    $text = $prev->textContent;
                    
                    // Detect Year (e.g., "{tab Tahun 2025}")
                    if (preg_match('/Tahun\s+(\d{4})/i', $text, $matches) && !$year) {
                        $year = $matches[1];
                    }
                    
                    // Detect Type
                    if (stripos($text, 'Laporan Harta Kekayaan Pejabat Negara') !== false && !$type) {
                        $type = 'LHKPN';
                    } elseif (stripos($text, 'Laporan Harta Kekayaan') !== false && !$type) { // Fallback/General
                         // Check if specific ASN text exists nearby or check table header
                         // But for now, let's assume if it says "Pejabat Negara" it's LHKPN
                    } elseif ((stripos($text, 'Laporan SPT Tahunan') !== false || stripos($text, 'Laporan Harta Kekayaan Aparatur Sipil Negara') !== false) && !$type) {
                        $type = 'SPT Tahunan';
                    }
                }
                // Stop if we found both or hit a previous HR/Table
                if ($year && $type) break;
                if ($prev->nodeName === 'hr' || $prev->nodeName === 'table') break; // Don't go back too far
                
                $prev = $prev->previousSibling;
            }

            // Fallback: If year not found in immediate sibling, try searching siblings further up/context from known structure
            // Manual adjustment for known structure if auto-detection fails
             if (!$year) {
                 // Try to guess from text content within the table? No, risky.
                 // Let's rely on the file structure being relatively consistent.
                 // If detection failed, skip or log warning.
                 // Actually, the structure uses {tab Tahun XXXX} quite consistently.
             }

             // If type is missing, try to detect from table headers
             if (!$type) {
                 $headerRow = $table->getElementsByTagName('tr')->item(0);
                 if ($headerRow) {
                     $headerText = $headerRow->textContent;
                     if (stripos($headerText, 'SPT') !== false) {
                         $type = 'SPT Tahunan';
                     } else {
                         // Default to LHKPN if strictly ambiguous but looks like the main table
                         $type = 'LHKPN'; 
                     }
                 }
             }

             if (!$year) {
                 // Try to look really far back if still null?
                 // Or assume it inherits from the last found year?
                 // For safety, let's just log and continue.
                 // $this->command->warn("Could not determine Year for Table #$index");
                 continue; 
             }
             
            // Process Rows
            $rows = $table->getElementsByTagName('tr');
            // Skip Header
            for ($i = 1; $i < $rows->length; $i++) {
                $row = $rows->item($i);
                $cols = $row->getElementsByTagName('td');
                
                if ($cols->length < 4) continue; // Invalid row

                $nama = trim($cols->item(0)->textContent);
                $jabatan = trim($cols->item(1)->textContent);
                
                // Find NIP
                $nip = null;
                $cleanName = strtolower($nama);
                // Remove titles for better matching ?
                // For now, try direct match.
                
                // Fuzzy match loop
                foreach ($nameToNip as $n => $code) {
                    if (strpos($cleanName, strtolower(explode(',', $n)[0])) !== false) { // Match first part of name
                         $nip = $code;
                         break;
                    }
                }
                
                if (!$nip) {
                    // $this->command->warn("Could not find NIP for: $nama");
                    $nip = '-'; // Placeholder
                }

                // Extract Links
                $linkTandaTerima = null;
                $linkDokumen = null;

                // Warning: Column indexes vary by year/table type!
                // We need to look for <a> tags in specific columns or all columns.
                
                $links = $row->getElementsByTagName('a');
                foreach ($links as $link) {
                    $href = $link->getAttribute('href');
                    if (empty($href)) continue;
                    
                    // Simple logic: If we don't have one yet, assign it.
                    // Ideally we distinguish based on column, but column indices change.
                    // Generally: Tanda Terima comes before Laporan/Pengumuman/SPT
                    
                    if (!$linkTandaTerima) {
                        $linkTandaTerima = $href;
                    } elseif (!$linkDokumen) {
                         $linkDokumen = $href;
                    }
                }
                
                // Extract Date
                $tanggalLapor = null;
                // Search for date string in all columns
                foreach ($cols as $col) {
                     if (preg_match('/(\d{1,2})[\/\-\s](\d{1,2}|[a-zA-Z]+)[\/\-\s](\d{4})/', $col->textContent, $dateMatches)) {
                         // Try to parse date
                         try {
                            $d = date_create($dateMatches[0]);
                            if ($d) $tanggalLapor = $d->format('Y-m-d');
                         } catch (\Exception $e) {}
                         break; 
                     }
                }

                // Insert Data
                LhkpnReport::create([
                    'nip' => $nip,
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'tahun' => $year,
                    'jenis_laporan' => $type,
                    'tanggal_lapor' => $tanggalLapor,
                    'link_tanda_terima' => $linkTandaTerima,
                    'link_dokumen_pendukung' => $linkDokumen,
                ]);
                $count++;
            }
        }
        
        $this->command->info("Seeded $count reports.");
    }
}
