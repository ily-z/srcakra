import React, { useEffect } from 'react';
import { useForm, Head } from '@inertiajs/react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Calendar, User, Building2, MapPin, 
    Mail, Target, FileText, Users, Send 
} from 'lucide-react';


export const home = '/';
export const dashboard = '/dashboard';
export const login = '/login';
export const register = '/register';

// Reusable Input Component untuk kerapihan kode
const InputField = ({ label, icon: Icon, error, ...props }) => (
    <div className="space-y-1">
        <label className="text-sm font-semibold text-gray-700 flex items-center gap-2">
            {Icon && <Icon size={16} className="text-indigo-500" />}
            {label}
        </label>
        <input
            {...props}
            className={`w-full px-4 py-2.5 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-indigo-500 transition-all outline-none
            ${error ? 'border-red-500' : 'border-gray-200'}`}
        />
        {error && <p className="text-xs text-red-500 mt-1">{error}</p>}
    </div>
);

export default function CreateKunjungan({ disabledDays }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        jenis_kunjungan: 'personal', // personal | instansi
        tanggal_kunjungan: '',
        nama: '',
        nama_instansi: '',
        alamat: '',
        email: '',
        tujuan_kunjungan: '',
        surat_pengajuan: null,
        jumlah_pengunjung: 1,
    });

    // Reset field spesifik saat ganti kategori agar data tidak tercampur
    useEffect(() => {
        if (data.jenis_kunjungan === 'personal') {
            setData(prev => ({ ...prev, nama_instansi: '', surat_pengajuan: null, jumlah_pengunjung: 1 }));
        } else {
            setData(prev => ({ ...prev, nama: '' }));
        }
    }, [data.jenis_kunjungan]);

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('kunjungan.store'));
    };

    return (
        <div className="min-h-screen bg-slate-50 py-12 px-4">
            <Head title="Pendaftaran Kunjungan" />
            
            <div className="max-w-3xl mx-auto">
                <div className="bg-white rounded-2xl shadow-xl overflow-hidden">
                    {/* Header */}
                    <div className="bg-indigo-600 p-8 text-white">
                        <h1 className="text-2xl font-bold">Reservasi Kunjungan</h1>
                        <p className="text-indigo-100 mt-1 text-sm">Lengkapi formulir di bawah untuk menjadwalkan kunjungan Anda.</p>
                    </div>

                    <form onSubmit={handleSubmit} className="p-8 space-y-6">
                        {/* Tab Switcher */}
                        <div className="flex p-1 bg-gray-100 rounded-xl w-full sm:w-72">
                            <button
                                type="button"
                                onClick={() => setData('jenis_kunjungan', 'personal')}
                                className={`flex-1 flex items-center justify-center gap-2 py-2 text-sm font-medium rounded-lg transition-all
                                ${data.jenis_kunjungan === 'personal' ? 'bg-white shadow text-indigo-600' : 'text-gray-500 hover:text-gray-700'}`}
                            >
                                <User size={16} /> Personal
                            </button>
                            <button
                                type="button"
                                onClick={() => setData('jenis_kunjungan', 'instansi')}
                                className={`flex-1 flex items-center justify-center gap-2 py-2 text-sm font-medium rounded-lg transition-all
                                ${data.jenis_kunjungan === 'instansi' ? 'bg-white shadow text-indigo-600' : 'text-gray-500 hover:text-gray-700'}`}
                            >
                                <Building2 size={16} /> Instansi
                            </button>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {/* Tanggal Kunjungan */}
                            <InputField
                                label="Tanggal Kunjungan"
                                type="date"
                                icon={Calendar}
                                value={data.tanggal_kunjungan}
                                onChange={e => setData('tanggal_kunjungan', e.target.value)}
                                error={errors.tanggal_kunjungan}
                                min={new Date().toISOString().split('T')[0]}
                            />

                            {/* Email */}
                            <InputField
                                label="Email Aktif"
                                type="email"
                                icon={Mail}
                                placeholder="example@mail.com"
                                value={data.email}
                                onChange={e => setData('email', e.target.value)}
                                error={errors.email}
                            />
                        </div>

                        {/* Animasi Transisi Field Berdasarkan Jenis */}
                        <AnimatePresence mode="wait">
                            <motion.div
                                key={data.jenis_kunjungan}
                                initial={{ opacity: 0, y: 10 }}
                                animate={{ opacity: 1, y: 0 }}
                                exit={{ opacity: 0, y: -10 }}
                                transition={{ duration: 0.2 }}
                                className="space-y-6"
                            >
                                {data.jenis_kunjungan === 'personal' ? (
                                    <InputField
                                        label="Nama Lengkap"
                                        type="text"
                                        icon={User}
                                        placeholder="Sesuai KTP"
                                        value={data.nama}
                                        onChange={e => setData('nama', e.target.value)}
                                        error={errors.nama}
                                    />
                                ) : (
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <InputField
                                            label="Nama Instansi"
                                            type="text"
                                            icon={Building2}
                                            placeholder="PT / Sekolah / Universitas"
                                            value={data.nama_instansi}
                                            onChange={e => setData('nama_instansi', e.target.value)}
                                            error={errors.nama_instansi}
                                        />
                                        <InputField
                                            label="Jumlah Pengunjung"
                                            type="number"
                                            icon={Users}
                                            min="1"
                                            value={data.jumlah_pengunjung}
                                            onChange={e => setData('jumlah_pengunjung', e.target.value)}
                                            error={errors.jumlah_pengunjung}
                                        />
                                        <div className="md:col-span-2">
                                            <label className="text-sm font-semibold text-gray-700 flex items-center gap-2 mb-1">
                                                <FileText size={16} className="text-indigo-500" />
                                                Surat Pengajuan (PDF)
                                            </label>
                                            <input
                                                type="file"
                                                accept=".pdf"
                                                onChange={e => setData('surat_pengajuan', e.target.files[0])}
                                                className="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                            />
                                            {errors.surat_pengajuan && <p className="text-xs text-red-500 mt-1">{errors.surat_pengajuan}</p>}
                                        </div>
                                    </div>
                                )}
                            </motion.div>
                        </AnimatePresence>

                        {/* Alamat */}
                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <MapPin size={16} className="text-indigo-500" /> Alamat Lengkap
                            </label>
                            <textarea
                                rows="3"
                                value={data.alamat}
                                onChange={e => setData('alamat', e.target.value)}
                                className="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                                placeholder="Jl. Nama Jalan No. XX..."
                            />
                            {errors.alamat && <p className="text-xs text-red-500">{errors.alamat}</p>}
                        </div>

                        {/* Tujuan */}
                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <Target size={16} className="text-indigo-500" /> Tujuan Kunjungan
                            </label>
                            <textarea
                                rows="3"
                                value={data.tujuan_kunjungan}
                                onChange={e => setData('tujuan_kunjungan', e.target.value)}
                                className="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                                placeholder="Jelaskan secara singkat tujuan Anda..."
                            />
                            {errors.tujuan_kunjungan && <p className="text-xs text-red-500">{errors.tujuan_kunjungan}</p>}
                        </div>

                        {/* Submit Button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-200 flex items-center justify-center gap-2 transition-all active:scale-[0.98] disabled:opacity-70"
                        >
                            {processing ? (
                                <div className="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin" />
                            ) : (
                                <>
                                    <Send size={18} /> Daftar Kunjungan
                                </>
                            )}
                        </button>
                    </form>
                </div>
                
                <p className="text-center text-gray-400 text-xs mt-6">
                    &copy; 2026 Sistem Reservasi Kunjungan Cakra. All rights reserved.
                </p>
            </div>
        </div>
    );
}