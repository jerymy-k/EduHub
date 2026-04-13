<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation"
    style="border-top: 1px solid #e2e8f0; margin-top: 25px; padding-top: 25px;">
    <tr>
        <td style="font-family: 'Figtree', sans-serif;">
            <div style="font-size: 12px; color: #64748b; line-height: 1.5;">
                {{ Illuminate\Mail\Markdown::parse($slot) }}
            </div>
        </td>
    </tr>
</table>
