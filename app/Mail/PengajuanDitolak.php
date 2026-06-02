<?php

namespace App\Mail;

use App\Models\Pendaftar;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengajuanDitolak extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pendaftar $pendaftar,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Ditolak – Museum Cakraningrat',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengajuan-ditolak',
        );
    }
}
