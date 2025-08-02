<?php
// app/Mail/GenericTemplateMail.php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class GenericTemplateMail extends Mailable
{
    /**
     * محتوى الـ HTML للرسالة
     *
     * @var string
     */
    public $bodyHtml;

    /**
     * أنشئ رسالة جديدة
     *
     * @param  string  $subject    // عنوان الرسالة
     * @param  string  $bodyHtml   // محتوى HTML
     */
    public function __construct(string $subject, string $bodyHtml)
    {
        // استعمل الخاصية الموجودة في المورّث
        $this->subject = $subject;

        $this->bodyHtml = $bodyHtml;
    }

    /**
     * عرّف البناء (build) لإرسال HTML مخصّص
     */
    public function build()
    {
        return $this
            // تمّ ضبط $this->subject في الكونستركتور
            ->html($this->bodyHtml);
    }
}
