<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['subject'] ?? $templateKey ?? 'Notification' }}</title>
</head>
<body>
    @php
        // استبدال المتغيرات داخل نص القالب
        $rendered = $body;
        foreach ($data as $key => $value) {
            // صياغتي لاستبدال كلا النمطين {{key}} و {{{key}}}
            $rendered = str_replace('{{ ' . $key . ' }}', $value, $rendered);
            $rendered = str_replace('{{{' . $key . '}}}', $value, $rendered);
        }
    @endphp

    {!! $rendered !!}
</body>
</html>