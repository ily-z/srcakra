import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';

export default function RegisterForm() {
    const { data, setData, post } = useForm({
        jenis: 'personal', // default
        nama: '',
        nama_instansi: '',
        email: '',
        method: 'cash',
        // ... field lainnya
    });

    return (
        <div className="bg-gray-100 min-h-screen p-10">
            <div className="bg-white max-w-xl mx-auto rounded-xl shadow p-8">
                <h1 className="text-xl font-bold mb-6">Form Pendaftaran Kunjungan</h1>
                
                <div className="mb-4">
                    <label className="block text-sm font-medium">Jenis Kunjungan</label>
                    <select 
                        className="w-full mt-1 border-gray-300 rounded-md"
                        value={data.jenis} 
                        onChange={e => setData('jenis', e.target.value)}
                    >
                        <option value="personal">Personal / Individu</option>
                        <option value="instansi">Instansi / Rombongan</option>
                    </select>
                </div>

                {/* Kondisional Nama vs Instansi */}
                {data.jenis === 'personal' ? (
                    <div className="mb-4">
                        <label className="block text-sm">Nama Lengkap</label>
                        <input type="text" className="w-full border-gray-300 rounded" 
                            onChange={e => setData('nama', e.target.value)} />
                    </div>
                ) : (
                    <>
                        <div className="mb-4">
                            <label className="block text-sm">Nama Instansi</label>
                            <input type="text" className="w-full border-gray-300 rounded" 
                                onChange={e => setData('nama_instansi', e.target.value)} />
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm">Jumlah Pengunjung</label>
                            <input type="number" min="1" className="w-full border-gray-300 rounded" 
                                onChange={e => setData('jumlah_pengunjung', e.target.value)} />
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm">Surat Pengajuan (PDF)</label>
                            <input type="file" className="w-full text-sm" 
                                onChange={e => setData('surat_pengajuan', e.target.files[0])} />
                        </div>
                    </>
                )}

                <div className="mb-6 p-4 bg-blue-50 rounded-lg">
                    <p className="text-sm font-semibold mb-2">Metode Pembayaran</p>
                    <div className="flex gap-4">
                        <label className="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="method" value="cash" checked={data.method === 'cash'} 
                                onChange={e => setData('method', e.target.value)} />
                            <span>Cash (Bayar di Tempat)</span>
                        </label>
                        <label className="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="method" value="midtrans" 
                                onChange={e => setData('method', e.target.value)} />
                            <span>Online Payment (Midtrans)</span>
                        </label>
                    </div>
                </div>

                <button 
                    onClick={() => post('/submit-pendaftaran')}
                    className="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700"
                >
                    {data.method === 'cash' ? 'Daftar & Terima Kwitansi' : 'Lanjut ke Pembayaran'}
                </button>
            </div>
        </div>
    );
}