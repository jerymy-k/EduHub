@props([
'url',
'color' => 'primary',
'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="{{ $align }}">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="{{ $align }}">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>
                                    <a href="{{ $url }}" class="button button-{{ $color }}" target="_blank"
                                        rel="noopener"
                                        style="border-radius: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.2);">
                                        {!! $slot !!}
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
