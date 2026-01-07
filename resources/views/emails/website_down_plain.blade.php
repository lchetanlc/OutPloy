<h2>Website Down Alert</h2>

<p><strong>Website:</strong> {{ $website->url }}</p>
<p><strong>Status:</strong> DOWN</p>
<p><strong>Checked at:</strong> {{ optional($website->last_checked_at)->toDayDateTimeString() }}</p>

<p>Please check your server / DNS / SSL.</p>
