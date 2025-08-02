<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailTemplate;

class DynamicMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * مفتاح القالب (%key%)
     *
     * @var string
     */
    protected string $templateKey;

    /**
     * بيانات الاستبدال في القالب
     *
     * @var array
     */
    protected array $data;

    /**
     * انشاء الميلابيل مع مفتاح القالب والبيانات (اختياري)
     *
     * @param string $templateKey
     * @param array  $data
     */
    public function __construct(string $templateKey, array $data = [])
    {
        $this->templateKey = $templateKey;
        $this->data        = $data;
    }

    /**
     * بناء البريد: جلب القالب من قاعدة البيانات ثم عرضه
     *
     * @return $this
     */
    public function build()
    {
        $template = EmailTemplate::where('key', $this->templateKey)
                                 ->firstOrFail();

        return $this->subject($template->subject)
                    ->view('emails.dynamic', [
                        'body' => $template->body,
                        'data' => $this->data,
                    ]);
    }
}