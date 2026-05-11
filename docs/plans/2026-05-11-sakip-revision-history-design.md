# SAKIP Reviu History Design

## Tujuan

Modul SAKIP perlu menyimpan riwayat reviu dokumen. Dokumen awal tetap menjadi data utama SAKIP, sedangkan reviu disimpan sebagai history dengan nomor reviu otomatis, tanggal publish, keterangan, dan link dokumen.

## Alur Admin

Pada halaman edit SAKIP, admin mendapat checkbox `Ini reviu dokumen`. Jika checkbox tidak dicentang, form memperbarui dokumen awal seperti alur lama. Jika checkbox dicentang, sistem wajib memastikan dokumen awal sudah ada. Jika belum ada, admin mendapat peringatan bahwa dokumen awal harus disimpan terlebih dahulu.

Saat reviu dibuat, sistem mengambil nomor reviu terakhir untuk dokumen tersebut lalu menyimpan reviu berikutnya: `Reviu 1`, `Reviu 2`, `Reviu 3`, dan seterusnya. Link reviu bisa berasal dari URL manual atau upload file.

## Struktur Data

Tabel `sakip` tetap menyimpan data utama: tahun, jenis dokumen, uraian, link dokumen awal, dan tanggal publish dokumen awal. Tabel baru `sakip_revisions` menyimpan banyak reviu untuk satu dokumen SAKIP.

Field reviu: `sakip_id`, `revisi_ke`, `tanggal_publish`, `keterangan`, `link_dokumen`, timestamps. Relasi menggunakan `Sakip hasMany SakipRevision`, dan reviu ikut terhapus ketika dokumen utama dihapus.

## Integrasi Joomla

API publik tetap kompatibel karena field lama masih ada. API menambahkan `revisions`, `latest_revision`, dan `dokumen_aktif`. Script Joomla memakai `latest_revision` sebagai versi aktif jika tersedia, serta menyediakan tombol `History` yang membuka modal berisi daftar reviu dan link dokumennya.
