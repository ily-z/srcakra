// Receipt.jsx
export default function Receipt({ kunjungan }) {
    return (
        <div className="flex flex-col items-center bg-white p-10 border rounded shadow-lg max-w-md mx-auto mt-20">
            <h2 className="text-2xl font-bold text-green-600">Pendaftaran Berhasil!</h2>
            <p className="text-gray-600 mt-2">Silahkan simpan QR Code di bawah ini</p>
            
            <div className="my-8 p-4 bg-gray-50 border-2 border-dashed rounded-lg text-center">
                {/* QR Code yang digenerate dari qr_token */}
                <img src={`https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${kunjungan.qr_token}`} alt="QR Code" />
                <p className="mt-4 font-mono font-bold text-lg">{kunjungan.qr_token}</p>
            </div>

            <div className="w-full text-sm space-y-2 border-t pt-4">
                <div className="flex justify-between"><span>Nama:</span> <b>{kunjungan.nama_display}</b></div>
                <div className="flex justify-between"><span>Tgl Kunjungan:</span> <b>{kunjungan.tanggal_kunjungan}</b></div>
                <div className="flex justify-between"><span>Jumlah:</span> <b>{kunjungan.jumlah_pengunjung} Orang</b></div>
                <div className="flex justify-between"><span>Pembayaran:</span> <b className="uppercase">{kunjungan.payment_method}</b></div>
            </div>
            
            <button onClick={() => window.print()} className="mt-6 text-blue-600 underline">Cetak Kwitansi</button>
        </div>
    );
}