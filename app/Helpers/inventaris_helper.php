<?php

if (! function_exists('tgl')) {
    function tgl(?string $tanggal): string
    {
        return $tanggal ? date('d/m/Y', strtotime($tanggal)) : '-';
    }
}

if (! function_exists('badge')) {
    /** Badge berwarna untuk kondisi, status barang, dan status peminjaman. */
    function badge(?string $nilai): string
    {
        $warna = [
            'baik' => 'success', 'rusak' => 'warning', 'hilang' => 'danger',
            'tersedia' => 'success', 'nonaktif' => 'secondary',
            'dipinjam' => 'warning', 'dikembalikan' => 'success',
        ][strtolower((string) $nilai)] ?? 'secondary';

        return '<span class="badge text-bg-' . $warna . '">' . esc(ucfirst((string) $nilai)) . '</span>';
    }
}

if (! function_exists('nilai')) {
    /**
     * Nilai isian form yang aman (di-escape satu kali):
     * input lama (setelah gagal validasi) -> data dari database -> default.
     */
    function nilai(string $key, ?array $row = null, $default = ''): string
    {
        $lama = old($key, null, false);
        $v    = $lama ?? ($row[$key] ?? $default);

        return esc((string) $v);
    }
}
