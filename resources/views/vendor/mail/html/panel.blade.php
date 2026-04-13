<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 25px;">
    <tr>
        <td class="panel-content"
            style="background-color: #f0fdf4; border-left: 4px solid #10b981; border-radius: 8px; padding: 16px;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="panel-item"
                        style="color: #064e3b; font-family: 'Figtree', sans-serif; font-size: 14px; line-height: 1.6;">
                        {{ Illuminate\Mail\Markdown::parse($slot) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
