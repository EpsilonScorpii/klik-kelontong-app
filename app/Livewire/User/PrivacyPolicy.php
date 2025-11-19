<?php

namespace App\Livewire\User;

use Livewire\Component;

class PrivacyPolicy extends Component
{
    public $sections = [];

    public function mount()
    {
        $this->loadPolicySections();
    }

    public function render()
    {
        return view('livewire.user.privacy-policy')->layout('layouts.app', ['title' => 'Privacy Policy']);
    }

    private function loadPolicySections()
    {
        $this->sections = [
            [
                'title' => 'Cancelation Policy',
                'content' => 'Pesanan dapat dibatalkan sebelum proses pengemasan dimulai. Jika pesanan sudah dalam proses pengiriman, pembatalan tidak dapat dilakukan. Untuk bantuan lebih lanjut, silakan hubungi layanan pelanggan kami.'
            ],
            [
                'title' => 'Terms & Condition',
                'content' => 'Dengan mengakses dan menggunakan layanan Klik Kelontong, pengguna dianggap telah membaca, memahami, dan menyetujui semua syarat dan ketentuan yang berlaku. Pengguna bertanggung jawab atas kebenaran data yang diberikan saat mendaftar, termasuk informasi kontak dan alamat pengiriman. Klik Kelontong tidak bertanggung jawab atas keterlambatan atau kegagalan pengiriman akibat informasi yang tidak akurat.

Seluruh transaksi di Klik Kelontong mengikuti ketentuan harga, stok produk, serta kebijakan promosi yang sedang berlaku. Kami berhak membatalkan atau menolak pesanan apabila ditemukan adanya indikasi penyalahgunaan, penipuan, kesalahan sistem, atau pelanggaran terhadap ketentuan platform. Pembatalan juga dapat terjadi apabila produk yang dipesan tidak tersedia atau terjadi kendala logistik di luar kendali kami.'
            ],
            [
                'title' => 'Privacy Policy',
                'content' => 'Klik Kelontong berkomitmen untuk melindungi privasi dan keamanan data pribadi pengguna. Informasi yang kami kumpulkan mencakup nama, alamat email, nomor telepon, alamat pengiriman, dan data transaksi. Data ini digunakan untuk memproses pesanan, mengirimkan notifikasi, dan meningkatkan layanan kami.

Kami tidak akan membagikan, menjual, atau menyewakan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali jika diwajibkan oleh hukum atau diperlukan untuk memproses transaksi (seperti kepada penyedia layanan pembayaran dan kurir).

Data pribadi Anda disimpan dengan aman menggunakan teknologi enkripsi dan protokol keamanan standar industri. Pengguna berhak untuk mengakses, memperbarui, atau menghapus informasi pribadi mereka dengan menghubungi layanan pelanggan kami.'
            ],
            [
                'title' => 'Refund Policy',
                'content' => 'Pengembalian dana (refund) dapat diproses dalam kondisi berikut:
• Produk yang diterima rusak atau tidak sesuai dengan deskripsi
• Pesanan dibatalkan sebelum proses pengiriman dimulai
• Terjadi kesalahan harga atau sistem saat transaksi

Untuk mengajukan refund, pelanggan harus menghubungi layanan pelanggan dalam waktu maksimal 3x24 jam setelah pesanan diterima, disertai dengan foto produk dan bukti kerusakan atau ketidaksesuaian.

Proses refund akan dilakukan melalui metode pembayaran yang sama dengan yang digunakan saat pembelian. Waktu proses refund adalah 7-14 hari kerja setelah pengajuan disetujui. Biaya pengiriman tidak dapat dikembalikan kecuali jika kesalahan berasal dari pihak Klik Kelontong.'
            ],
            [
                'title' => 'Shipping Policy',
                'content' => 'Klik Kelontong bekerja sama dengan berbagai penyedia jasa pengiriman terpercaya untuk memastikan pesanan Anda sampai dengan aman dan tepat waktu. Estimasi waktu pengiriman adalah 2-3 hari kerja untuk pengiriman standar dan 1 hari kerja untuk pengiriman ekspres (tergantung ketersediaan di wilayah Anda).

Ongkos kirim dihitung berdasarkan berat produk, jarak pengiriman, dan jenis layanan yang dipilih. Informasi detail tentang ongkos kirim akan ditampilkan sebelum Anda menyelesaikan pembayaran.

Setelah pesanan dikirim, Anda akan menerima nomor resi (tracking number) yang dapat digunakan untuk melacak status pengiriman secara real-time. Klik Kelontong tidak bertanggung jawab atas keterlambatan pengiriman yang disebabkan oleh faktor di luar kendali kami, seperti cuaca buruk, bencana alam, atau kebijakan pemerintah.'
            ],
            [
                'title' => 'Product Quality',
                'content' => 'Kami berkomitmen untuk menyediakan produk berkualitas tinggi dengan menjaga standar penyimpanan dan pengemasan yang baik. Semua produk yang dijual di Klik Kelontong telah melalui proses seleksi dan pemeriksaan kualitas.

Untuk produk makanan dan minuman, kami memastikan bahwa tanggal kadaluarsa masih dalam jangka waktu aman untuk dikonsumsi. Jika Anda menerima produk dengan kondisi rusak, kadaluarsa, atau tidak sesuai dengan deskripsi, segera hubungi layanan pelanggan kami untuk penggantian atau pengembalian dana.

Kami juga menerima feedback dan review dari pelanggan untuk terus meningkatkan kualitas produk dan layanan kami. Kepuasan Anda adalah prioritas utama kami.'
            ],
        ];
    }
}
