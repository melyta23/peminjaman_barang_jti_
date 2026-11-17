<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permohonan Izin Peminjaman - {{ $borrowing->kode_transaksi }}</title>
    
    <!-- Bootstrap Icons untuk print bar -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: 210mm 297mm; /* A4 Portrait */
            margin: 0; /* Hapus margin @page → browser tidak tampilkan header/footer tanggal & URL */
        }

        /* Saat dicetak: padding .sheet yang mengatur jarak tepi konten */
        @media print {
            body {
                background-color: #fff !important;
            }
            .print-toolbar {
                display: none !important;
            }
            .sheet {
                width: 210mm !important;
                min-height: 297mm !important;
                padding: 40mm 30mm 30mm 40mm !important; /* Top 4cm | Right 3cm | Bottom 3cm | Left 4cm */
                margin: 0 !important;
                box-shadow: none !important;
                page-break-after: always;
            }
            .sheet:last-child {
                page-break-after: avoid;
            }
        }

        body {
            background-color: #525659;
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Navigasi Cetak Atas */
        .print-toolbar {
            background-color: #1e293b;
            color: #fff;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        /* Lembar Kertas A4 */
        .sheet {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 12mm 12mm 15mm; /* Preview layar — compact 1 halaman */
            margin: 20px auto;
            background: #ffffff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.35);
            box-sizing: border-box;
            position: relative;
        }

        .sheet:last-child {
            page-break-after: avoid;
        }

        /* Kop Surat */
        .kop-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
            width: 100%;
            box-sizing: border-box;
            gap: 8px;
        }

        .kop-logo,
        .kop-logo-kanan {
            width: 80px;
            min-width: 80px;
            max-width: 80px;
            height: 80px;
            object-fit: contain;
            flex: 0 0 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kop-text {
            text-align: center;
            flex: 1 1 0%;
            min-width: 0; /* Wajib 0 agar flexbox membungkus teks ke bawah, bukan memanjang ke samping */
            max-width: calc(100% - 176px);
            padding: 0 4px;
            box-sizing: border-box;
        }

        /* Setiap Baris Kop Berdiri Sendiri Sebagai Block Penuh & Selalu Bungkus ke Bawah */
        .kop-line {
            display: block !important;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 1px 4px;
            outline: none;
            transition: all 0.15s ease;
            box-sizing: border-box;
            border-radius: 4px;
            white-space: normal !important;
            word-wrap: break-word !important;
            overflow-wrap: anywhere !important; /* Memaksa kata atau karakter panjang langsung turun ke baris berikutnya */
            word-break: break-word !important;
        }

        .kop-line:empty::before {
            content: "\00a0"; /* Baris kosong tetap memiliki tinggi wajar & bisa diklik kembali */
        }

        .kop-line-1 {
            font-size: 13.5pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            line-height: 1.25;
            text-transform: uppercase;
        }

        .kop-line-2 {
            font-size: 12.5pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            line-height: 1.25;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .kop-line-3 {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            line-height: 1.25;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .kop-line-alamat {
            font-size: 9.5pt;
            font-weight: normal;
            line-height: 1.3;
            margin-top: 3px;
        }

        .kop-line-kontak {
            font-size: 9.5pt;
            font-weight: normal;
            line-height: 1.3;
            margin-top: 1px;
        }

        /* TTD Editable Styles - Selalu Block agar Nama & NIP/NIM Pasti Berpindah Baris */
        .ttd-col p {
            margin: 0;
            display: block !important;
            clear: both;
        }

        .ttd-col [contenteditable="true"] {
            outline: none;
            transition: all 0.15s ease;
            display: block !important;
            width: 100%;
            border-radius: 3px;
            padding: 1px 2px;
            clear: both;
        }

        .surat-editable-inline {
            outline: none;
            transition: all 0.15s ease;
            border-radius: 3px;
            padding: 0 3px;
        }

        .kop-line,
        .surat-editable-inline,
        .ttd-col [contenteditable="true"] {
            cursor: text;
            user-select: text;
            -webkit-user-select: text;
            caret-color: #000;
        }

        .kop-line:hover,
        .surat-editable-inline:hover,
        .ttd-col [contenteditable="true"]:hover {
            background-color: transparent;
            outline: 1px dashed #93c5fd;
        }

        .kop-line:focus,
        .surat-editable-inline:focus,
        .ttd-col [contenteditable="true"]:focus {
            background-color: transparent !important;
            box-shadow: none !important;
            outline: 1.5px solid #3b82f6;
            outline-offset: 1px;
        }

        @media print {
            .kop-text [contenteditable="true"]:hover,
            .kop-text [contenteditable="true"]:focus,
            .kop-text [contenteditable="true"],
            .ttd-col [contenteditable="true"]:hover,
            .ttd-col [contenteditable="true"]:focus,
            .ttd-col [contenteditable="true"] {
                background: transparent !important;
                box-shadow: none !important;
            }
        }

        /* Garis Ganda Pemisah Kop */
        .kop-divider {
            border-top: 2.5px solid #000;
            border-bottom: 1px solid #000;
            height: 4px;
            margin-top: 4px;
            margin-bottom: 18px;
        }

        /* Body Surat */
        .surat-header {
            display: flex;
            justify-content: space-between;
            font-size: 11pt;
            line-height: 1.45;
            margin-bottom: 16px;
        }

        .surat-header table td {
            padding: 1px 0;
            vertical-align: top;
        }

        .surat-body {
            font-size: 10.5pt;
            line-height: 1.4;
            text-align: justify;
        }

        .surat-body p {
            margin-bottom: 6px;
        }

        .surat-kegiatan-table {
            margin: 4px 0 8px 25px;
            font-size: 10.5pt;
            line-height: 1.4;
        }

        .surat-kegiatan-table td {
            padding: 1px 4px;
            vertical-align: top;
        }

        /* Bagian Tanda Tangan */
        .table-ttd-layout {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
            margin-top: 20px;
            font-size: 10.5pt;
            line-height: 1.35;
        }

        .table-ttd-layout td {
            border: none !important;
            padding: 0;
        }

        /* Gambar Stempel BEM */
        .stempel-badge {
            position: absolute;
            top: -15px;
            left: 20px;
            width: 115px;
            height: 115px;
            opacity: 0.88;
            pointer-events: none;
        }

        /* Tabel Lampiran */
        .lampiran-title {
            font-size: 11pt;
            font-style: italic;
            margin-bottom: 14px;
        }

        .table-sarpras {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            margin-top: 5px;
        }

        .table-sarpras th, .table-sarpras td {
            border: 1px solid #000;
            padding: 7px 12px;
            vertical-align: middle;
        }

        .table-sarpras th {
            text-align: center;
            font-weight: bold;
        }

        .table-sarpras td.col-no {
            text-align: center;
            width: 45px;
        }

        .table-sarpras td.col-jumlah {
            text-align: center;
            width: 120px;
        }

        @media print {
            body {
                background: none;
            }
            .print-toolbar {
                display: none !important;
            }
            .sheet {
                margin: 0;
                box-shadow: none;
                width: 100%;
                min-height: 297mm;
                padding: 18mm 22mm 18mm 22mm;
            }
        }
    </style>
</head>
<body>

    @php
        // Konversi Tanggal Bahasa Indonesia
        $hariIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        $tglNow = $borrowing->created_at ?? now();
        $hariNow = $hariIndo[$tglNow->format('l')] ?? 'Selasa';
        $bulanNow = $bulanIndo[(int)$tglNow->format('m')] ?? 'November';
        $tglSurat = $hariNow . ', ' . $tglNow->format('d') . ' ' . $bulanNow . ' ' . $tglNow->format('Y');

        $blnRom = $bulanRomawi[(int)$tglNow->format('m')] ?? 'XI';
        $nomorSurat = sprintf('%03d/SPH/KEMENRIN/%s/%s', $borrowing->id, $blnRom, $tglNow->format('Y'));

        $tglPinjamHari = $hariIndo[$borrowing->tanggal_pinjam->format('l')] ?? '';
        $tglPinjamFormat = $tglPinjamHari . ', ' . $borrowing->tanggal_pinjam->format('d') . ' ' . $bulanIndo[(int)$borrowing->tanggal_pinjam->format('m')] . ' ' . $borrowing->tanggal_pinjam->format('Y');

        $tglKembaliHari = $hariIndo[$borrowing->tanggal_kembali->format('l')] ?? '';
        $tglKembaliFormat = $tglKembaliHari . ', ' . $borrowing->tanggal_kembali->format('d') . ' ' . $bulanIndo[(int)$borrowing->tanggal_kembali->format('m')] . ' ' . $borrowing->tanggal_kembali->format('Y');

        $rentangHari = ($tglPinjamFormat === $tglKembaliFormat) ? $tglPinjamFormat : ($tglPinjamFormat . ' s/d ' . $tglKembaliFormat);

        $jamMulai = !empty($borrowing->jam_mulai) ? \Carbon\Carbon::parse($borrowing->jam_mulai)->format('H.i') : '07.00';
        if (empty($borrowing->jam_selesai) || strtolower(trim($borrowing->jam_selesai)) === 'selesai') {
            $rentangWaktu = $jamMulai . ' WIB – selesai';
        } else {
            try {
                $jamSelesai = \Carbon\Carbon::parse($borrowing->jam_selesai)->format('H.i');
                $rentangWaktu = $jamMulai . ' WIB – ' . $jamSelesai . ' WIB';
            } catch (\Throwable $e) {
                $rentangWaktu = $jamMulai . ' WIB – ' . $borrowing->jam_selesai;
            }
        }

        // Penyesuaian Kop Surat & Data secara otomatis berdasarkan Program Studi Peminjam
        $prodi = trim($borrowing->prodi ?? '');
        $isOrmawa = str_contains(strtolower($prodi), 'ormawa') || str_contains(strtolower($prodi), 'bem') || str_contains(strtolower($prodi), 'ukm');
        $isDosen = str_contains(strtolower($prodi), 'dosen') || str_contains(strtolower($prodi), 'tendik');

        if ($isOrmawa) {
            $kopBaris3Default = 'BADAN EKSEKUTIF MAHASISWA';
            $kopPenyelenggaraDefault = 'Keluarga Mahasiswa Politeknik Negeri Jember';
            $ttdKananDefault1 = 'Presiden Mahasiswa';
        } elseif ($isDosen) {
            $kopBaris3Default = 'DOSEN / TENAGA KEPENDIDIKAN';
            $kopPenyelenggaraDefault = 'Jurusan Teknologi Informasi Politeknik Negeri Jember';
            $ttdKananDefault1 = 'Dosen / Pemohon';
        } else {
            $prodiUpper = strtoupper($prodi);
            if (empty($prodi)) {
                $kopBaris3Default = 'PROGRAM STUDI TEKNOLOGI INFORMASI';
                $kopPenyelenggaraDefault = 'Mahasiswa Jurusan Teknologi Informasi Politeknik Negeri Jember';
            } elseif (str_starts_with($prodiUpper, 'PROGRAM STUDI')) {
                $kopBaris3Default = $prodiUpper;
                $kopPenyelenggaraDefault = 'Mahasiswa ' . $prodi . ' Politeknik Negeri Jember';
            } else {
                $kopBaris3Default = 'PROGRAM STUDI ' . $prodiUpper;
                $kopPenyelenggaraDefault = 'Mahasiswa Program Studi ' . $prodi . ' Politeknik Negeri Jember';
            }
            $ttdKananDefault1 = 'Pemohon / Mahasiswa';
        }
    @endphp

    <!-- Toolbar Atas (Hanya tampil di layar) -->
    <div class="print-toolbar d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-2">
            <strong class="fs-6"><i class="bi bi-file-earmark-text-fill text-warning me-1"></i>Surat Peminjaman Resmi</strong>
            <span class="badge bg-secondary">{{ $borrowing->kode_transaksi }}</span>
            <span class="badge d-none d-md-inline-block" style="background: rgba(14, 165, 233, 0.2); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); font-size: 0.75rem; font-weight: 500;">
                <i class="bi bi-cursor-text text-warning me-1"></i>Kop, Nama TTD & NIP dapat diedit langsung
            </span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-warning text-dark fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#editKopModal">
                <i class="bi bi-pencil-square me-1"></i> Edit Kop & TTD
            </button>
            <a href="{{ route('peminjaman.show', $borrowing->id) }}" class="btn btn-sm btn-outline-light">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-sm btn-outline-light fw-semibold px-3">
                <i class="bi bi-printer me-1"></i> Cetak
            </button>
            <button onclick="savePDF()" class="btn btn-sm btn-danger fw-bold px-3 shadow">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Simpan PDF
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- HALAMAN 1: SURAT PERMOHONAN IZIN PEMINJAMAN -->
    <!-- ========================================== -->
    <div class="sheet">
        <!-- KOP SURAT RESMI -->
        <div class="kop-wrapper">
            <!-- Logo Polije Kiri -->
            <div class="kop-logo">
                <img src="{{ asset('images/logo-polije.png') }}" alt="Logo Polije" width="80" height="80" style="object-fit: contain;">
            </div>

            <!-- Teks Kop Surat (Dapat Diedit Langsung per Baris) -->
            <div class="kop-text">
                <div class="kop-line kop-line-1" id="kopBaris1" contenteditable="true" title="Klik langsung untuk mengedit Institusi Baris 1">POLITEKNIK NEGERI JEMBER</div>
                <div class="kop-line kop-line-2" id="kopBaris2" contenteditable="true" title="Klik langsung untuk mengedit Sub-Institusi Baris 2">KELUARGA MAHASISWA</div>
                <div class="kop-line kop-line-3" id="kopBaris3" contenteditable="true" title="Klik langsung untuk mengedit Program Studi / Lembaga">{{ $kopBaris3Default }}</div>
                <div class="kop-line kop-line-alamat" id="kopAlamat" contenteditable="true" title="Klik langsung untuk mengedit Alamat">Jalan Mastrip Kotak Pos 164 Jember 68121</div>
                <div class="kop-line kop-line-kontak" id="kopKontak" contenteditable="true" title="Klik langsung untuk mengedit Kontak & Email">Hp. 081287349270, Email : bem@polije.ac.id</div>
            </div>

            <!-- Logo Polije Kanan -->
            <div class="kop-logo kop-logo-kanan" id="kopLogoKanan_p1">
                <img src="{{ asset('images/logo-polije.png') }}" alt="Logo Polije" width="80" height="80" style="object-fit: contain;" id="imgLogoKanan_p1">
            </div>
        </div>

        <!-- Garis Ganda Pemisah Kop -->
        <div class="kop-divider"></div>

        <!-- Header Surat: Nomor, Lampiran, Perihal, & Tanggal -->
        <div class="surat-header">
            <table>
                <tr>
                    <td style="width: 70px;">Nomor</td>
                    <td style="width: 15px;">:</td>
                    <td><span contenteditable="true" id="suratNomor" class="surat-editable-inline" title="Klik untuk mengedit nomor surat">{{ $nomorSurat }}</span></td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td><span contenteditable="true" id="suratLampiran" class="surat-editable-inline" title="Klik untuk mengedit lampiran">1</span></td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td><strong contenteditable="true" id="suratPerihal" class="surat-editable-inline" title="Klik untuk mengedit perihal">Permohonan Izin Peminjaman</strong></td>
                </tr>
            </table>

            <div style="text-align: right; min-width: 180px;">
                {{ $tglSurat }}
            </div>
        </div>

        <!-- Tujuan Surat -->
        <div style="font-size: 11pt; line-height: 1.4; margin-bottom: 16px;">
            Kepada<br>
            <strong>Yth. Ketua Jurusan Teknologi Informasi</strong><br>
            Politeknik Negeri Jember<br>
            di<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Tempat
        </div>

        <!-- Isi Surat -->
        <div class="surat-body">
            <p>Dengan hormat,</p>
            <p style="text-indent: 30px;">
                Sehubungan dengan dilaksanakannya kegiatan <strong>{{ $borrowing->keperluan }}</strong> oleh 
                <span id="suratPenyelenggara" contenteditable="true" class="surat-editable-inline" title="Klik langsung untuk mengedit pihak penyelenggara">{{ $kopPenyelenggaraDefault }}</span> tahun {{ date('Y') }}, yang dilaksanakan pada :
            </p>

            <table class="surat-kegiatan-table">
                <tr>
                    <td style="width: 110px;">hari, tanggal</td>
                    <td style="width: 15px;">:</td>
                    <td><strong>{{ $rentangHari }}</strong></td>
                </tr>
                <tr>
                    <td>waktu</td>
                    <td>:</td>
                    <td>{{ $rentangWaktu }}</td>
                </tr>
                <tr>
                    <td>tempat</td>
                    <td>:</td>
                    <td>Laboratorium Jurusan Teknologi Informasi, Politeknik Negeri Jember</td>
                </tr>
            </table>

            <p style="text-indent: 30px;">
                Dengan adanya surat ini, kami bermaksud untuk memohon izin terkait peminjaman dan penggunaan sarana prasarana penunjang untuk mendukung kegiatan ini dengan tetap mematuhi peraturan yang berlaku. Demikian surat permohonan ini kami sampaikan. Atas perhatian dan kerja sama Bapak kami sampaikan terima kasih.
            </p>
        </div>

        <!-- Tanda Tangan Halaman 1 (Sejajar & Lurus Sempurna Secara Horizontal) -->
        <table class="table-ttd-layout" style="width: 100%; border-collapse: collapse; border: none; margin-top: 20px; table-layout: fixed;">
            <colgroup>
                <col style="width: 50%;">
                <col style="width: 50%;">
            </colgroup>
            <tbody>
                <!-- Baris 1: Jabatan Atas — tinggi ditentukan oleh baris tertinggi secara otomatis -->
                <tr style="vertical-align: top;">
                    <td class="ttd-col" style="vertical-align: top; padding: 0 30px 0 0; border: none;">
                        <p style="margin: 0;" contenteditable="true" id="ttdKiriJabatan1" title="Klik langsung untuk mengedit jabatan">Mengetahui,</p>
                        <p style="margin: 0;" contenteditable="true" id="ttdKiriJabatan2" title="Klik langsung untuk mengedit jabatan">Koordinator Minat, Bakat dan</p>
                        <p style="margin: 0;" contenteditable="true" id="ttdKiriJabatan3" title="Klik langsung untuk mengedit jabatan">Kedisiplinan Mahasiswa</p>
                    </td>
                    <td class="ttd-col" style="vertical-align: top; padding: 0 0 0 30px; border: none;">
                        <p style="margin: 0;" contenteditable="true" id="ttdKananJabatan1" title="Klik langsung untuk mengedit jabatan">Pemohon / Mahasiswa</p>
                        <p style="margin: 0;" contenteditable="true" id="ttdKananJabatan2" title="Klik langsung untuk mengedit jabatan">Politeknik Negeri Jember</p>
                    </td>
                </tr>

                <!-- Baris 2: Ruang TTD Kosong (Tinggi Seragam) -->
                <tr>
                    <td style="height: 55px; border: none;"></td>
                    <td style="height: 55px; border: none;"></td>
                </tr>

                <!-- Baris 3: Nama Lengkap & NIP/NIM (Pasti Sejajar & Lurus Horizontal) -->
                <tr style="vertical-align: bottom;">
                    <td class="ttd-col" style="vertical-align: bottom; padding: 0 30px 0 0; border: none;">
                        <p style="margin: 0; font-weight: bold; text-decoration: underline;" contenteditable="true" id="ttdKiriNama" title="Klik langsung untuk mengedit Nama Penandatangan">Iwan Setiadi, S.Sos</p>
                        <p style="margin: 0;" contenteditable="true" id="ttdKiriNip" title="Klik langsung untuk mengedit NIP">NIP. 197212202001121001</p>
                    </td>
                    <td class="ttd-col" style="vertical-align: bottom; padding: 0 0 0 30px; border: none;">
                        <p style="margin: 0; font-weight: bold; text-decoration: underline;" contenteditable="true" id="ttdKananNama" title="Klik langsung untuk mengedit Nama Pemohon">{{ $borrowing->nama_peminjam }}</p>
                        <p style="margin: 0;" contenteditable="true" id="ttdKananNip" title="Klik langsung untuk mengedit NIM/NIP">NIM. {{ $borrowing->nim_nip }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <!-- ========================================== -->
    <!-- HALAMAN 2: LAMPIRAN I DAFTAR PEMINJAMAN   -->
    <!-- ========================================== -->
    <div class="sheet" id="halamanLampiran">
        <!-- KOP SURAT RESMI (Sama persis seperti di foto) -->
        <div class="kop-wrapper">
            <!-- Logo Polije Kiri Halaman 2 -->
            <div class="kop-logo">
                <img src="{{ asset('images/logo-polije.png') }}" alt="Logo Polije" width="80" height="80" style="object-fit: contain;">
            </div>

            <!-- Teks Kop Surat Halaman 2 (Sinkron Otomatis per Baris) -->
            <div class="kop-text">
                <div class="kop-line kop-line-1" id="kopBaris1_p2" contenteditable="true" title="Klik langsung untuk mengedit Institusi Baris 1">POLITEKNIK NEGERI JEMBER</div>
                <div class="kop-line kop-line-2" id="kopBaris2_p2" contenteditable="true" title="Klik langsung untuk mengedit Sub-Institusi Baris 2">KELUARGA MAHASISWA</div>
                <div class="kop-line kop-line-3" id="kopBaris3_p2" contenteditable="true" title="Klik langsung untuk mengedit Program Studi / Lembaga">{{ $kopBaris3Default }}</div>
                <div class="kop-line kop-line-alamat" id="kopAlamat_p2" contenteditable="true" title="Klik langsung untuk mengedit Alamat">Jalan Mastrip Kotak Pos 164 Jember 68121</div>
                <div class="kop-line kop-line-kontak" id="kopKontak_p2" contenteditable="true" title="Klik langsung untuk mengedit Kontak & Email">Hp. 081287349270, Email : bem@polije.ac.id</div>
            </div>

            <!-- Logo Polije Kanan Halaman 2 -->
            <div class="kop-logo kop-logo-kanan" id="kopLogoKanan_p2">
                <img src="{{ asset('images/logo-polije.png') }}" alt="Logo Polije" width="80" height="80" style="object-fit: contain;" id="imgLogoKanan_p2">
            </div>
        </div>

        <div class="kop-divider"></div>

        <!-- Judul Lampiran persis di foto -->
        <div class="lampiran-title">
            Lampiran I Daftar Peminjaman
        </div>

        <!-- Tabel Persis seperti di Foto Lampiran (Sinkron Otomatis Seluruh Barang Inventaris) -->
        <table class="table-sarpras">
            <thead>
                <tr>
                    <th style="width: 50px;">No.</th>
                    <th>Sarana Prasarana</th>
                    <th style="width: 140px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowing->details as $index => $detail)
                    @php
                        if (!$detail->item) continue;
                        $item = $detail->item;
                        $jumlahItem = $detail->jumlah;
                    @endphp
                    <tr>
                        <td class="col-no">{{ $index + 1 }}.</td>
                        <td contenteditable="true" title="Klik langsung untuk mengedit nama barang">
                            {{ $item->nama_barang }}
                            @if($item->merk)
                                <span style="font-size: 10pt; color: #333;">({{ $item->merk }})</span>
                            @endif
                        </td>
                        <td class="col-jumlah" contenteditable="true" title="Klik langsung untuk mengedit jumlah">
                            {{ $jumlahItem }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- MODAL PENGATURAN KOP & TANDA TANGAN SURAT -->
    <div class="modal fade" id="editKopModal" tabindex="-1" aria-labelledby="editKopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square text-warning fs-5"></i>
                        <h5 class="modal-title fw-bold" id="editKopModalLabel">Pengaturan Kop Surat & Tanda Tangan</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="font-family: system-ui, -apple-system, sans-serif;">
                    
                    <!-- Nav Tabs Pengaturan -->
                    <ul class="nav nav-pills nav-fill mb-3 p-1 bg-light rounded-3" id="editModalTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-2 fw-semibold" id="tab-kop-tab" data-bs-toggle="pill" data-bs-target="#tab-kop" type="button" role="tab">
                                <i class="bi bi-file-earmark-richtext me-1"></i> 1. Kop Surat
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2 fw-semibold" id="tab-ttd-tab" data-bs-toggle="pill" data-bs-target="#tab-ttd" type="button" role="tab">
                                <i class="bi bi-pen me-1"></i> 2. Nama & NIP Tanda Tangan
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="editModalTabContent">
                        <!-- TAB 1: KOP SURAT -->
                        <div class="tab-pane fade show active" id="tab-kop" role="tabpanel">
                            <!-- Pilihan Preset Cepat -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1.5 d-flex align-items-center gap-1">
                                    <i class="bi bi-lightning-charge-fill text-warning"></i> Preset Cepat Kop Surat:
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="applyPreset('bem')">
                                        🏛️ BEM Polije (Default)
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="applyPreset('jti')">
                                        💻 Jurusan Teknologi Informasi (JTI)
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="applyPreset('hmti')">
                                        👥 HMTI Polije
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="applyPreset('lab')">
                                        🔬 Laboratorium JTI
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="applyPreset('pusat')">
                                        🏫 Polije Pusat
                                    </button>
                                </div>
                            </div>

                            <!-- Pilihan Logo Kanan -->
                            <div class="mb-3 p-2.5 bg-light rounded-3 border">
                                <label class="form-label fw-bold text-dark small mb-1.5 d-flex align-items-center gap-1.5">
                                    <i class="bi bi-image text-primary"></i> Pilihan Logo Sisi Kanan:
                                </label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioLogoKanan" id="radioLogoPolije" value="polije" checked onchange="previewLogoKanan('polije')">
                                        <label class="form-check-label small fw-semibold" for="radioLogoPolije">🏛️ Tampilkan Logo Polije di Kanan (Kanan & Kiri Sama)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioLogoKanan" id="radioLogoNone" value="none" onchange="previewLogoKanan('none')">
                                        <label class="form-check-label small fw-semibold" for="radioLogoNone">🚫 Sembunyikan Logo Kanan (Hanya Logo Kiri)</label>
                                    </div>
                                </div>
                                <div class="text-muted small mt-1" style="font-size: 8pt;">
                                    *Jika disembunyikan, ruang kanan tetap diseimbangkan agar teks kop tetap persis di tengah lembar A4.
                                </div>
                            </div>

                            <div class="alert alert-light border small text-muted py-2 px-3 mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-info-circle text-primary"></i>
                                <span>Pilih preset di atas atau edit teks kop surat kustom per baris di bawah ini:</span>
                            </div>

                            <!-- Input Fields Kop -->
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Institusi Utama (Baris 1):</label>
                                    <input type="text" id="inputKop1" class="form-control" placeholder="POLITEKNIK NEGERI JEMBER">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Sub-Institusi / Bagian (Baris 2):</label>
                                    <input type="text" id="inputKop2" class="form-control" placeholder="KELUARGA MAHASISWA">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Lembaga / Program Studi (Baris 3 - Judul Tebal):</label>
                                    <input type="text" id="inputKop3" class="form-control" placeholder="{{ $kopBaris3Default }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Alamat Kampus / Kantor (Baris 4):</label>
                                    <input type="text" id="inputKopAlamat" class="form-control" placeholder="Jalan Mastrip Kotak Pos 164 Jember 68121">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Kontak & Email (Baris 5):</label>
                                    <input type="text" id="inputKopKontak" class="form-control" placeholder="Hp. 081287349270, Email : bem@polije.ac.id">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Pihak Penyelenggara Kegiatan (Di Isi Paragraf Surat):</label>
                                    <input type="text" id="inputPenyelenggara" class="form-control" placeholder="{{ $kopPenyelenggaraDefault }}">
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: TANDA TANGAN & PEJABAT -->
                        <div class="tab-pane fade" id="tab-ttd" role="tabpanel">
                            <div class="alert alert-light border small text-muted py-2 px-3 mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-info-circle text-primary"></i>
                                <span>Ruang tanda tangan dibuat <strong>kosongan</strong> untuk tanda tangan fisik & stempel basah. Anda dapat menyesuaikan jabatan, nama pejabat, dan NIP/NIM di bawah ini:</span>
                            </div>

                            <div class="row g-3">
                                <!-- Penandatangan Kiri (Mengetahui) -->
                                <div class="col-md-6 border-end pe-md-3">
                                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2 d-flex align-items-center gap-1.5">
                                        <i class="bi bi-person-badge text-primary"></i>
                                        <span>Penandatangan Kiri (Mengetahui)</span>
                                    </h6>
                                    <div class="mb-2">
                                        <label class="form-label small text-secondary mb-1">Jabatan Baris 1:</label>
                                        <input type="text" id="inputTtdKiri1" class="form-control form-control-sm" value="Mengetahui,">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small text-secondary mb-1">Jabatan Baris 2:</label>
                                        <input type="text" id="inputTtdKiri2" class="form-control form-control-sm" value="Koordinator Minat, Bakat dan">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small text-secondary mb-1">Jabatan Baris 3:</label>
                                        <input type="text" id="inputTtdKiri3" class="form-control form-control-sm" value="Kedisiplinan Mahasiswa">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold text-dark mb-1">Nama Lengkap & Gelar:</label>
                                        <input type="text" id="inputTtdKiriNama" class="form-control form-control-sm fw-bold" value="Iwan Setiadi, S.Sos">
                                    </div>
                                    <div>
                                        <label class="form-label small text-secondary mb-1">Nomor Induk Pegawai (NIP):</label>
                                        <input type="text" id="inputTtdKiriNip" class="form-control form-control-sm" value="NIP. 197212202001121001">
                                    </div>
                                </div>

                                <!-- Penandatangan Kanan (Pemohon) -->
                                <div class="col-md-6 ps-md-3">
                                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2 d-flex align-items-center gap-1.5">
                                        <i class="bi bi-person-check text-primary"></i>
                                        <span>Penandatangan Kanan (Pemohon)</span>
                                    </h6>
                                    <div class="mb-2">
                                        <label class="form-label small text-secondary mb-1">Jabatan Baris 1:</label>
                                        <input type="text" id="inputTtdKanan1" class="form-control form-control-sm" value="Presiden Mahasiswa">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small text-secondary mb-1">Jabatan Baris 2:</label>
                                        <input type="text" id="inputTtdKanan2" class="form-control form-control-sm" value="Politeknik Negeri Jember">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold text-dark mb-1">Nama Lengkap Pemohon:</label>
                                        <input type="text" id="inputTtdKananNama" class="form-control form-control-sm fw-bold" value="{{ $borrowing->nama_peminjam }}">
                                    </div>
                                    <div>
                                        <label class="form-label small text-secondary mb-1">NIM / NIP Pemohon:</label>
                                        <input type="text" id="inputTtdKananNip" class="form-control form-control-sm" value="NIM. {{ $borrowing->nim_nip }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="mt-3 text-muted small border-top pt-2">
                        <i class="bi bi-lightbulb text-warning me-1"></i>
                        <strong>Tips Praktis:</strong> Semua baris kop surat, teks pihak penyelenggara, dan tanda tangan dapat <strong>langsung diklik dan diketik</strong> pada lembar kertas A4 tanpa merusak format.
                    </div>

                </div>
                <div class="modal-footer bg-light px-4 py-3 border-top d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="resetKopDefault()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Bawaan
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary btn-sm fw-semibold px-3" onclick="saveKopFromModal()">
                            <i class="bi bi-check2-circle me-1"></i> Terapkan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Pengaturan & Sinkronisasi Kop & TTD Surat -->
    <script>
        let currentLogoKanan = 'polije';
        const storageKeyKop = 'kop_surat_{{ $borrowing->id }}';
        const storageKeyTtd = 'ttd_surat_{{ $borrowing->id }}';

        const defaultKop = {
            baris1: 'POLITEKNIK NEGERI JEMBER',
            baris2: 'KELUARGA MAHASISWA',
            baris3: {!! json_encode($kopBaris3Default) !!},
            alamat: 'Jalan Mastrip Kotak Pos 164 Jember 68121',
            kontak: 'Hp. 081287349270, Email : bem@polije.ac.id',
            logoKanan: 'polije',
            penyelenggara: {!! json_encode($kopPenyelenggaraDefault) !!}
        };

        const defaultTtd = {
            kiri1: 'Mengetahui,',
            kiri2: 'Koordinator Minat, Bakat dan',
            kiri3: 'Kedisiplinan Mahasiswa',
            kiriNama: 'Iwan Setiadi, S.Sos',
            kiriNip: 'NIP. 197212202001121001',
            kanan1: {!! json_encode($ttdKananDefault1) !!},
            kanan2: 'Politeknik Negeri Jember',
            kananNama: {!! json_encode($borrowing->nama_peminjam) !!},
            kananNip: 'NIM. {!! json_encode($borrowing->nim_nip) !!}'.replace(/"/g, '')
        };

        const presets = {
            bem: {
                baris1: 'POLITEKNIK NEGERI JEMBER',
                baris2: 'KELUARGA MAHASISWA',
                baris3: 'BADAN EKSEKUTIF MAHASISWA',
                alamat: 'Jalan Mastrip Kotak Pos 164 Jember 68121',
                kontak: 'Hp. 081287349270, Email : bem@polije.ac.id',
                logoKanan: 'polije',
                penyelenggara: 'Kementerian Riset, Inovasi, dan Prestasi Badan Eksekutif Mahasiswa Keluarga Mahasiswa Politeknik Negeri Jember',
                ttdKiri1: 'Mengetahui,',
                ttdKiri2: 'Koordinator Minat, Bakat dan',
                ttdKiri3: 'Kedisiplinan Mahasiswa',
                ttdKiriNama: 'Iwan Setiadi, S.Sos',
                ttdKiriNip: 'NIP. 197212202001121001',
                ttdKanan1: 'Presiden Mahasiswa',
                ttdKanan2: 'Politeknik Negeri Jember'
            },
            jti: {
                baris1: 'KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI',
                baris2: 'POLITEKNIK NEGERI JEMBER',
                baris3: 'JURUSAN TEKNOLOGI INFORMASI',
                alamat: 'Jl. Mastrip PO. BOX 164 Jember 68121 Jawa Timur',
                kontak: 'Telp. (0331) 333532, Email : jti@polije.ac.id · Website: jti.polije.ac.id',
                logoKanan: 'polije',
                penyelenggara: 'Jurusan Teknologi Informasi Politeknik Negeri Jember',
                ttdKiri1: 'Mengetahui,',
                ttdKiri2: 'Ketua Jurusan Teknologi Informasi',
                ttdKiri3: 'Politeknik Negeri Jember',
                ttdKiriNama: 'Hendra Yufit Riskiawan, S.Kom., M.Cs.',
                ttdKiriNip: 'NIP. 198302032006041003',
                ttdKanan1: 'Koordinator / Pemohon',
                ttdKanan2: 'Jurusan Teknologi Informasi'
            },
            hmti: {
                baris1: 'POLITEKNIK NEGERI JEMBER',
                baris2: 'JURUSAN TEKNOLOGI INFORMASI',
                baris3: 'HIMPUNAN MAHASISWA TEKNOLOGI INFORMASI (HMTI)',
                alamat: 'Jl. Mastrip Kotak Pos 164 Jember 68121 Jawa Timur',
                kontak: 'Email : hmti@polije.ac.id · Instagram: @hmti_polije',
                logoKanan: 'polije',
                penyelenggara: 'Himpunan Mahasiswa Jurusan Teknologi Informasi (HMTI) Polije',
                ttdKiri1: 'Mengetahui,',
                ttdKiri2: 'Pembina HMTI Jurusan TI',
                ttdKiri3: 'Politeknik Negeri Jember',
                ttdKiriNama: 'Iwan Setiadi, S.Sos',
                ttdKiriNip: 'NIP. 197212202001121001',
                ttdKanan1: 'Ketua Umum HMTI',
                ttdKanan2: 'Politeknik Negeri Jember'
            },
            lab: {
                baris1: 'POLITEKNIK NEGERI JEMBER',
                baris2: 'JURUSAN TEKNOLOGI INFORMASI',
                baris3: 'LABORATORIUM SARANA PRASARANA JTI',
                alamat: 'Gedung TI Polije, Jl. Mastrip PO. BOX 164 Jember 68121',
                kontak: 'Kontak Laboran: 081287349270, Email : lab.jti@polije.ac.id',
                logoKanan: 'polije',
                penyelenggara: 'Laboratorium Sarana & Prasarana Jurusan Teknologi Informasi',
                ttdKiri1: 'Mengetahui,',
                ttdKiri2: 'Kepala Laboratorium TI',
                ttdKiri3: 'Politeknik Negeri Jember',
                ttdKiriNama: 'Iwan Setiadi, S.Sos',
                ttdKiriNip: 'NIP. 197212202001121001',
                ttdKanan1: 'Petugas / Pemohon Lab',
                ttdKanan2: 'Politeknik Negeri Jember'
            },
            pusat: {
                baris1: 'KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI',
                baris2: 'DIREKTORAT JENDERAL PENDIDIKAN VOKASI',
                baris3: 'POLITEKNIK NEGERI JEMBER',
                alamat: 'Jalan Mastrip Kotak Pos 164 Jember 68121 Telp. (0331) 333532',
                kontak: 'Email : politeknik@polije.ac.id · Laman : www.polije.ac.id',
                logoKanan: 'polije',
                penyelenggara: 'Politeknik Negeri Jember',
                ttdKiri1: 'Mengetahui,',
                ttdKiri2: 'Wakil Direktur Kemahasiswaan',
                ttdKiri3: 'Politeknik Negeri Jember',
                ttdKiriNama: 'Wahyu Kurnia Dewanto, S.Kom., M.T.',
                ttdKiriNip: 'NIP. 198012142005011001',
                ttdKanan1: 'Peminjam / Pemohon',
                ttdKanan2: 'Politeknik Negeri Jember'
            }
        };

        function setLogoKanan(type) {
            currentLogoKanan = type;
            const img1 = document.getElementById('imgLogoKanan_p1');
            const img2 = document.getElementById('imgLogoKanan_p2');

            if (img1) img1.style.visibility = (type === 'none') ? 'hidden' : 'visible';
            if (img2) img2.style.visibility = (type === 'none') ? 'hidden' : 'visible';

            // Radio button modal
            const radPolije = document.getElementById('radioLogoPolije');
            const radNone = document.getElementById('radioLogoNone');
            if (radPolije && type !== 'none') radPolije.checked = true;
            if (radNone && type === 'none') radNone.checked = true;
        }

        function previewLogoKanan(type) {
            setLogoKanan(type);
        }

        function safeGetText(id) {
            const el = document.getElementById(id);
            return el ? el.innerText.trim() : '';
        }

        function getCurrentKop() {
            return {
                baris1: safeGetText('kopBaris1'),
                baris2: safeGetText('kopBaris2'),
                baris3: safeGetText('kopBaris3'),
                alamat: safeGetText('kopAlamat'),
                kontak: safeGetText('kopKontak'),
                logoKanan: currentLogoKanan || 'bem',
                penyelenggara: safeGetText('suratPenyelenggara') || defaultKop.penyelenggara
            };
        }

        function getCurrentTtd() {
            return {
                kiri1: safeGetText('ttdKiriJabatan1'),
                kiri2: safeGetText('ttdKiriJabatan2'),
                kiri3: safeGetText('ttdKiriJabatan3'),
                kiriNama: safeGetText('ttdKiriNama'),
                kiriNip: safeGetText('ttdKiriNip'),
                kanan1: safeGetText('ttdKananJabatan1'),
                kanan2: safeGetText('ttdKananJabatan2'),
                kananNama: safeGetText('ttdKananNama'),
                kananNip: safeGetText('ttdKananNip')
            };
        }

        function syncModalKopInputs(data) {
            const el1 = document.getElementById('inputKop1');
            const el2 = document.getElementById('inputKop2');
            const el3 = document.getElementById('inputKop3');
            const elAl = document.getElementById('inputKopAlamat');
            const elKt = document.getElementById('inputKopKontak');
            const elPeny = document.getElementById('inputPenyelenggara');

            if (el1) el1.value = data.baris1 || '';
            if (el2) el2.value = data.baris2 || '';
            if (el3) el3.value = data.baris3 || '';
            if (elAl) elAl.value = data.alamat || '';
            if (elKt) elKt.value = data.kontak || '';
            if (elPeny) elPeny.value = data.penyelenggara || defaultKop.penyelenggara;
        }

        function syncModalTtdInputs(data) {
            const setInput = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.value = val || '';
            };

            setInput('inputTtdKiri1', data.kiri1);
            setInput('inputTtdKiri2', data.kiri2);
            setInput('inputTtdKiri3', data.kiri3);
            setInput('inputTtdKiriNama', data.kiriNama);
            setInput('inputTtdKiriNip', data.kiriNip);

            setInput('inputTtdKanan1', data.kanan1);
            setInput('inputTtdKanan2', data.kanan2);
            setInput('inputTtdKananNama', data.kananNama);
            setInput('inputTtdKananNip', data.kananNip);
        }

        function placeCaretAtEnd(el) {
            el.focus();
            if (typeof window.getSelection !== "undefined" && typeof document.createRange !== "undefined") {
                const range = document.createRange();
                range.selectNodeContents(el);
                range.collapse(false); // Posisi kursor di akhir / belakang teks
                const sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }

        // Simpan sebagai PDF — set nama file lalu panggil print dialog
        function savePDF() {
            const kode = '{{ $borrowing->kode_transaksi }}';
            const nama = '{{ $borrowing->nama_peminjam }}';
            const oldTitle = document.title;
            // Ubah judul sementara → nama file PDF di dialog print
            document.title = 'Surat_Peminjaman_' + kode + '_' + nama.replace(/\s+/g, '_');
            window.print();
            // Kembalikan judul asli setelah dialog tertutup
            setTimeout(() => { document.title = oldTitle; }, 2000);
        }

        function updateKopDisplay(data, saveToStorage = true) {
            // Halaman 1
            const p1_1 = document.getElementById('kopBaris1');
            const p1_2 = document.getElementById('kopBaris2');
            const p1_3 = document.getElementById('kopBaris3');
            const p1_al = document.getElementById('kopAlamat');
            const p1_kt = document.getElementById('kopKontak');
            const p_peny = document.getElementById('suratPenyelenggara');

            if (p1_1) p1_1.innerText = (data.baris1 !== undefined) ? data.baris1 : defaultKop.baris1;
            if (p1_2) p1_2.innerText = (data.baris2 !== undefined) ? data.baris2 : defaultKop.baris2;
            if (p1_3) p1_3.innerText = (data.baris3 !== undefined) ? data.baris3 : defaultKop.baris3;
            if (p1_al) p1_al.innerText = (data.alamat !== undefined) ? data.alamat : defaultKop.alamat;
            if (p1_kt) p1_kt.innerText = (data.kontak !== undefined) ? data.kontak : defaultKop.kontak;
            if (p_peny && data.penyelenggara) p_peny.innerText = data.penyelenggara;

            // Halaman 2 (Lampiran)
            const p2_1 = document.getElementById('kopBaris1_p2');
            const p2_2 = document.getElementById('kopBaris2_p2');
            const p2_3 = document.getElementById('kopBaris3_p2');
            const p2_al = document.getElementById('kopAlamat_p2');
            const p2_kt = document.getElementById('kopKontak_p2');

            if (p2_1) p2_1.innerText = (data.baris1 !== undefined) ? data.baris1 : defaultKop.baris1;
            if (p2_2) p2_2.innerText = (data.baris2 !== undefined) ? data.baris2 : defaultKop.baris2;
            if (p2_3) p2_3.innerText = (data.baris3 !== undefined) ? data.baris3 : defaultKop.baris3;
            if (p2_al) p2_al.innerText = (data.alamat !== undefined) ? data.alamat : defaultKop.alamat;
            if (p2_kt) p2_kt.innerText = (data.kontak !== undefined) ? data.kontak : defaultKop.kontak;

            // Logo Kanan
            setLogoKanan(data.logoKanan || 'bem');

            // Update Input Modal
            syncModalKopInputs(data);

            if (saveToStorage) {
                localStorage.setItem(storageKeyKop, JSON.stringify(data));
            }
        }

        function updateTtdDisplay(data, saveToStorage = true) {
            const setField = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.innerText = val || '';
            };

            setField('ttdKiriJabatan1', data.kiri1);
            setField('ttdKiriJabatan2', data.kiri2);
            setField('ttdKiriJabatan3', data.kiri3);
            setField('ttdKiriNama', data.kiriNama);
            setField('ttdKiriNip', data.kiriNip);

            setField('ttdKananJabatan1', data.kanan1);
            setField('ttdKananJabatan2', data.kanan2);
            setField('ttdKananNama', data.kananNama);
            setField('ttdKananNip', data.kananNip);

            // Update modal input fields
            syncModalTtdInputs(data);

            if (saveToStorage) {
                localStorage.setItem(storageKeyTtd, JSON.stringify(data));
            }
        }

        function applyPreset(key) {
            if (presets[key]) {
                const p = presets[key];
                document.getElementById('inputKop1').value = p.baris1;
                document.getElementById('inputKop2').value = p.baris2;
                document.getElementById('inputKop3').value = p.baris3;
                document.getElementById('inputKopAlamat').value = p.alamat;
                document.getElementById('inputKopKontak').value = p.kontak;
                if (p.penyelenggara) {
                    const elPeny = document.getElementById('inputPenyelenggara');
                    if (elPeny) elPeny.value = p.penyelenggara;
                }

                // Update Logo
                setLogoKanan(p.logoKanan || 'none');

                // Jika preset memiliki pengaturan TTD spesifik, masukkan juga ke input TTD
                if (p.ttdKiri1) document.getElementById('inputTtdKiri1').value = p.ttdKiri1;
                if (p.ttdKiri2) document.getElementById('inputTtdKiri2').value = p.ttdKiri2;
                if (p.ttdKiri3) document.getElementById('inputTtdKiri3').value = p.ttdKiri3;
                if (p.ttdKiriNama) document.getElementById('inputTtdKiriNama').value = p.ttdKiriNama;
                if (p.ttdKiriNip) document.getElementById('inputTtdKiriNip').value = p.ttdKiriNip;
                if (p.ttdKanan1) document.getElementById('inputTtdKanan1').value = p.ttdKanan1;
                if (p.ttdKanan2) document.getElementById('inputTtdKanan2').value = p.ttdKanan2;
            }
        }

        function saveKopFromModal() {
            // Dapatkan Pilihan Radio Logo Kanan
            let selectedLogo = 'polije';
            const radNone = document.getElementById('radioLogoNone');
            if (radNone && radNone.checked) selectedLogo = 'none';

            // Simpan Kop
            const dataKop = {
                baris1: document.getElementById('inputKop1').value.trim(),
                baris2: document.getElementById('inputKop2').value.trim(),
                baris3: document.getElementById('inputKop3').value.trim(),
                alamat: document.getElementById('inputKopAlamat').value.trim(),
                kontak: document.getElementById('inputKopKontak').value.trim(),
                logoKanan: selectedLogo,
                penyelenggara: document.getElementById('inputPenyelenggara').value.trim() || defaultKop.penyelenggara
            };
            updateKopDisplay(dataKop, true);

            // Simpan TTD
            const dataTtd = {
                kiri1: document.getElementById('inputTtdKiri1').value.trim() || defaultTtd.kiri1,
                kiri2: document.getElementById('inputTtdKiri2').value.trim() || defaultTtd.kiri2,
                kiri3: document.getElementById('inputTtdKiri3').value.trim() || defaultTtd.kiri3,
                kiriNama: document.getElementById('inputTtdKiriNama').value.trim() || defaultTtd.kiriNama,
                kiriNip: document.getElementById('inputTtdKiriNip').value.trim() || defaultTtd.kiriNip,
                kanan1: document.getElementById('inputTtdKanan1').value.trim() || defaultTtd.kanan1,
                kanan2: document.getElementById('inputTtdKanan2').value.trim() || defaultTtd.kanan2,
                kananNama: document.getElementById('inputTtdKananNama').value.trim() || defaultTtd.kananNama,
                kananNip: document.getElementById('inputTtdKananNip').value.trim() || defaultTtd.kananNip
            };
            updateTtdDisplay(dataTtd, true);

            // Tutup Modal
            const modalEl = document.getElementById('editKopModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        }

        function resetKopDefault() {
            if (confirm('Kembalikan kop surat dan tanda tangan ke format standar bawaan?')) {
                localStorage.removeItem(storageKeyKop);
                localStorage.removeItem(storageKeyTtd);
                localStorage.removeItem('kop_surat_custom');
                updateKopDisplay(defaultKop, false);
                updateTtdDisplay(defaultTtd, false);
                const modalEl = document.getElementById('editKopModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            }
        }

        // Sinkronisasi Dua Arah saat mengetik langsung di lembar A4
        function setupLiveSync(elId, mirrorId) {
            const el = document.getElementById(elId);
            const mirror = document.getElementById(mirrorId);
            if (!el || !mirror) return;

            el.addEventListener('input', function () {
                mirror.innerText = el.innerText;
                const current = getCurrentKop();
                localStorage.setItem(storageKeyKop, JSON.stringify(current));
                syncModalKopInputs(current);
            });

            mirror.addEventListener('input', function () {
                el.innerText = mirror.innerText;
                const current = getCurrentKop();
                localStorage.setItem(storageKeyKop, JSON.stringify(current));
                syncModalKopInputs(current);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Bersihkan storage statis lama agar konfigurasi dinamis terbaru aktif
            localStorage.removeItem('kop_surat_custom');

            // 1. Muat Kop Tersimpan
            const savedKop = localStorage.getItem(storageKeyKop);
            if (savedKop) {
                try {
                    const data = JSON.parse(savedKop);
                    updateKopDisplay(data, false);
                } catch (e) {
                    console.error('Gagal memuat kop tersimpan', e);
                    updateKopDisplay(defaultKop, false);
                }
            } else {
                updateKopDisplay(defaultKop, false);
            }

            // 2. Muat TTD Tersimpan
            const savedTtd = localStorage.getItem(storageKeyTtd);
            if (savedTtd) {
                try {
                    const dataTtd = JSON.parse(savedTtd);
                    updateTtdDisplay(dataTtd, false);
                } catch (e) {
                    console.error('Gagal memuat ttd tersimpan', e);
                    updateTtdDisplay(defaultTtd, false);
                }
            } else {
                updateTtdDisplay(defaultTtd, false);
            }

            // 3. Sinkronisasi Teks Kop Halaman 1 & 2
            setupLiveSync('kopBaris1', 'kopBaris1_p2');
            setupLiveSync('kopBaris2', 'kopBaris2_p2');
            setupLiveSync('kopBaris3', 'kopBaris3_p2');
            setupLiveSync('kopAlamat', 'kopAlamat_p2');
            setupLiveSync('kopKontak', 'kopKontak_p2');

            // 4. Sinkronisasi Pihak Penyelenggara di Paragraf Isi Surat
            const elPeny = document.getElementById('suratPenyelenggara');
            if (elPeny) {
                elPeny.addEventListener('input', function () {
                    const current = getCurrentKop();
                    localStorage.setItem(storageKeyKop, JSON.stringify(current));
                    syncModalKopInputs(current);
                });
            }

            // 5. Sinkronisasi Otomatis saat mengetik langsung pada TTD di kertas
            const ttdIds = [
                'ttdKiriJabatan1', 'ttdKiriJabatan2', 'ttdKiriJabatan3', 'ttdKiriNama', 'ttdKiriNip',
                'ttdKananJabatan1', 'ttdKananJabatan2', 'ttdKananNama', 'ttdKananNip'
            ];
            ttdIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', function () {
                        const currentTtd = getCurrentTtd();
                        localStorage.setItem('ttd_surat_{{ $borrowing->id }}', JSON.stringify(currentTtd));
                        // HANYA perbarui nilai input modal, JANGAN menimpa innerText elemen aktif agar kursor TIDAK loncat ke depan!
                        syncModalTtdInputs(currentTtd);
                    });
                }
            });

            // 6. Proteksi Contenteditable: Kursor Otomatis di Belakang, Cegah Enter Merusak Baris & Paste Plain Text
            const editableLines = document.querySelectorAll('.kop-line, .surat-editable-inline, .table-ttd-layout [contenteditable]');
            editableLines.forEach(el => {
                // Saat baru difokuskan / diklik, jika kursor berada di paling depan (index 0), otomatis posisikan ke paling belakang
                el.addEventListener('focus', function() {
                    setTimeout(() => {
                        const sel = window.getSelection();
                        if (sel && sel.rangeCount > 0) {
                            const range = sel.getRangeAt(0);
                            if (range.startOffset === 0 && this.innerText.trim().length > 0) {
                                placeCaretAtEnd(this);
                            }
                        }
                    }, 20);
                });

                el.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.blur(); // Mengakhiri editan tanpa memecah tag HTML menjadi multi-divs
                    }
                });

                el.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const text = (e.clipboardData || window.clipboardData).getData('text/plain');
                    document.execCommand('insertText', false, text);
                });
            });
        });
    </script>
</body>
</html>
