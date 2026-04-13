<tr>
    <td class="header" style="padding: 40px 0; text-align: center;">
        <a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
            @if (trim($slot) === 'Laravel' || trim($slot) === 'EduHub')
            <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;">
                <tr>
                    <td style="vertical-align: middle; padding-right: 12px;">
                        <img src="{{ asset('favicon.ico') }}" class="logo" alt="EduHub"
                            style="width: 40px; height: 40px; border-radius: 8px;">
                    </td>
                    <td style="vertical-align: middle;">
                        <span
                            style="font-family: 'Figtree', Arial, sans-serif; font-size: 28px; font-weight: 800; color: #064e3b; letter-spacing: -1px; line-height: 1;">
                            Edu<span style="color: #10b981;">Hub</span>
                        </span>
                    </td>
                </tr>
            </table>
            @else
            <span
                style="font-family: 'Figtree', Arial, sans-serif; font-size: 24px; font-weight: bold; color: #064e3b;">
                {{ $slot }}
            </span>
            @endif
        </a>
    </td>
</tr>
