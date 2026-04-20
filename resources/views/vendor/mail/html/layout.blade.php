<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        /* Google Fonts Fallback */
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;800&display=swap');

        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

        body {
            font-family: 'Figtree', Tahoma, Geneva, Verdana, sans-serif !important;
            background-color: #f4f7f6 !important;
            /* Gris bared m3a chwiya dyal l-khdor-iya */
        }
    </style>
    {!! $head ?? '' !!}
</head>

<body style="background-color: #f4f7f6; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: none;">

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="background-color: #f4f7f6;">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    {!! $header ?? '' !!}

                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation"
                                style="background-color: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">

                                <tr>
                                    <td style="height: 5px; background: linear-gradient(to right, #064e3b, #10b981);">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="content-cell" style="padding: 40px;">
                                        {!! Illuminate\Mail\Markdown::parse($slot) !!}

                                        {!! $subcopy ?? '' !!}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {!! $footer ?? '' !!}
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
