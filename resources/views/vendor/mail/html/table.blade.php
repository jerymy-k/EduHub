<div class="table" style="margin-top: 25px; margin-bottom: 25px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="border-collapse: collapse; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
        <tbody style="font-family: 'Figtree', sans-serif; font-size: 14px; color: #475569;">
            {{ Illuminate\Mail\Markdown::parse($slot) }}
        </tbody>
    </table>
</div>
